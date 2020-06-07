<?php
namespace App\Http\Controllers;



use App\GameQuestion;
use App\GameSession;
use App\WebSocket\EventPusher;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class GameController extends Controller {

    public function start()
    {
        return view('game.start');
    }



    public function begin(Request $request)
    {
        $request->validate([
            'guess_word' => 'required',
            'username' => 'required',
        ]);

        $game_session = GameSession::create([
            'code' => uniqid(),
            'guess_word' => $request->input('guess_word'),
            'player_1_username' => $request->input('username'),
        ]);

        if ($game_session) {
            // store game details in session
            $request->session()->put('game_session', [
                'code' => $game_session->code,
                'username' => $request->input('username')
            ]);

            return redirect()->route('game.in_play');
        }
        return back();
        // Create the game session
    }

    public function join(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'username' => 'required'
        ]);

        $game_session = GameSession::where('code', $request->input('code'))->first();

        if ($game_session) {
            if (empty($game_session->player_2_username)) {

                if ($game_session->player_1_username === $request->input('username')) {
                    \session()->flash('error', 'username already exist!.');
                    return redirect()->route('game.start');
                }

                $game_session->update([
                    'player_2_username' => $request->input('username')
                ]);

                $request->session()->put('game_session', [
                    'code' => $game_session->code,
                    'username' => $request->input('username')
                ]);

                $details = [
                    'game_code' => $game_session->code,
                    'event_type' => 'player_joined',
                    'username' => $request->input('username')
                ];
                EventPusher::pushEvent($details);

                return redirect()->route('game.in_play');
            } else {
                \session()->flash('error', 'Sorry you can\'t join the game session because game participants are complete.');
                return redirect()->route('game.start');
            }
        } else {
            \session()->flash('error', 'Game code does not exist!.');
            return redirect()->route('game.start');
        }
    }

    public function inPlay()
    {
        // check if the session exists
        if (\request()->session()->has('game_session')) {
            $game_session_details = \request()->session()
                ->get('game_session');


            $game_session = GameSession::where('code', $game_session_details['code'])
                ->first();

            if ($game_session->player_1_username !== $game_session_details['username'] &&
            $game_session->player_2_username !== $game_session_details['username']) {
                \session()->flash('error', 'UnAuthorised action');
                return redirect()->route('game.start');
            }

            if ($game_session->game_over) {
                \session()->flash('info', 'This game session has ended.');

                return redirect()->route('game.start');
            }

            $totalQuestionsCount = GameQuestion::where('game_session_id', $game_session->id)
                ->count();

            $unAnsweredQuestions = GameQuestion::where('game_session_id', $game_session->id)
                ->whereNull('answer')
                ->get();

            $answeredQuestions = GameQuestion::where('game_session_id', $game_session->id)
                ->whereNotNull('answer')
                ->latest()
                ->get();

            return view('game.in_play')
                ->with(compact('game_session', 'totalQuestionsCount', 'unAnsweredQuestions', 'answeredQuestions'));

        } else {
            return redirect()->route('game.start');
        }
    }


    public function askQuestion(Request $request)
    {
        $game_session = GameSession::where('code', $request->input('game_session_code'))
            ->first();

        if (!$game_session) {
            \session()->flash('error', 'Invalid Session.');
            return redirect()->route('game.start');
        }

        $request->validate([
            'question' => 'required',
            'game_session_code' => 'required'
        ]);
        $questionsCount = GameQuestion::where('game_session_id', $game_session->id)
            ->count();

        if ($questionsCount >= 20) {

            $data = [
                'game_code' => $request->session()->get('game_session.code'),
                'event_type' => 'game_over',
                'message' => 'Player could not guess the correct word after 20 questions.'
            ];


            EventPusher::pushEvent($data);

            if ($request->ajax()) {
                return response()->json([
                    'message' => '<div class="alert alert-info"> Questions maximum limit reached!. </div>'
                ]);
            }
        }


        $question = GameQuestion::create([
            'question' => $request->input('question'),
            'game_session_id' => $game_session->id
        ]);

        if ($question) {
            $details = [
                'game_code' => $game_session->code,
                'event_type' => 'question_asked',
                'username' => $request->session()->get('game_session.username'),
                'question_view' => view('game.question.question')->with(compact('question'))->render()
            ];

            EventPusher::pushEvent($details);


            if ($request->ajax()) {
                return response()->json([
                    'message' => '<div class="alert alert-success"> Question was successfully sent!. </div>'
                ]);
            }

            session()->flash('success', 'Question was successfully received.');

        } else {
            session()->flash('error', 'Question could not be saved.');

            if ($request->ajax()) {
                return response()->json([
                    'message' => '<div class="alert alert-success"> Question was not sent successfully please try again!. </div>'
                ]);
            }
        }

        return back();
    }


    public function answerQuestion(Request $request, GameQuestion $gameQuestion)
    {

        $game_session = GameSession::where('code', $request->session()->get('game_session.code'))->first();

        if (!$game_session) {
            $request->session()->flash('error', 'Invalid Session.');
            return redirect()->route('game.start');
        }
        $gameQuestion->update($request->input());

        $total_questions = GameQuestion::where('game_session_id', $game_session->id)->count();
        $unAnsweredQuestions = GameQuestion::where('game_session_id', $game_session->id)
            ->whereNull('answer')
            ->count();

        $data = [
            'game_code' => $request->session()->get('game_session.code'),
            'event_type' => 'question_answered',
            'username' => $request->session()->get('game_session.username'),
            'answer_view' => view('game.question.answer')->with(['question' => $gameQuestion])->render(),
            'un_answered_questions' => $unAnsweredQuestions
        ];
        if (isset($total_questions)) {
            $data['total_questions'] = $total_questions;
        }
        EventPusher::pushEvent($data);

        return 'saved';
    }



    public function guessWord(Request $request)
    {
        $game_session = GameSession::where('code', $request->session()->get('game_session.code'))->first();
        if (!$game_session) {
            $request->session()->flash('error', 'Invalid Session.');
            return redirect()->route('game.start');
        }

        $request->validate([
            'guess_word' => 'required'
        ]);

        if (strtolower($request->input('guess_word')) === strtolower($game_session->guess_word)) {

            // game over
            $data = [
                'game_code' => $request->session()->get('game_session.code'),
                'event_type' => 'game_over',
                'message' => 'Player 2 Guessed the word Correctly. Word: '. $game_session->guess_word,
            ];

            EventPusher::pushEvent($data);

            if ($request->ajax()) {
                return response()->json([
                    'message' => '<div class="alert alert-success"> You guessed the word Correctly. </div>'
                ]);
            }
            \session()->flash('error', 'You guessed the word correctly');

        } else {

            if ($request->ajax()) {
                return response()->json([
                    'message' => '<div class="alert alert-danger"> Incorrect Word. Try Again. </div>'
                ]);
            }
            \session()->flash('error', 'Incorrect guess. Try again');
        }
        return back();
    }


    public function gameOver()
    {
        $game_session = GameSession::where('code', \request()->session()->get('game_session.code'))->first();

        if (!$game_session) {
            \session()->flash('error', 'Invalid Session.');
            return redirect()->route('game.start');
        }

        if ($game_session) {
            $game_session->update(['game_over' => 1]);
            \request()->session()->flush();
        }

        return view('game.game_over');
    }

}
