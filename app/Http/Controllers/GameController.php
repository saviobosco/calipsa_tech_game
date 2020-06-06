<?php
namespace App\Http\Controllers;



use App\GameQuestion;
use App\GameSession;
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
                $game_session->update([
                    'player_2_username' => $request->input('username')
                ]);

                $request->session()->put('game_session', [
                    'code' => $game_session->code,
                    'username' => $request->input('username')
                ]);
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
        if (\request()->session()->exists('game_session')) {
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

            return view('game.in_play')
                ->with(compact('game_session'));

        } else {
            return redirect()->route('game.start');
        }
    }


    public function askQuestion(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'game_session_code' => 'required'
        ]);

        $game_session = GameSession::where('code', $request->input('game_session_code'))
            ->first();

        if ($game_session) {

            GameQuestion::create([
                'question' => $request->input('question'),
                'game_session_id' => $game_session->id
            ]);


            if ($request->ajax()) {
                return response()->json([
                    'message' => 'success'
                ]);
            }
            session()->flash('success', 'Question was successfully received.');
        } else {
            session()->flash('error', 'Question could not be saved.');
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Could not add the question. Please try again.'
                ]);
            }
        }
        return back();
    }


    /**
     * For player One
     */
    public function getQuestions()
    {
        // get the last unanswered question in the group
        $questions = GameQuestion::where('game_session_id', \request()->query('game_session_id'))
            ->get();

        return view('game.get_questions')
            ->with(compact('questions'));
    }


    public function answerQuestion()
    {

    }

    public function gameOver()
    {

    }

}
