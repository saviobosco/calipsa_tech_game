@extends('layout.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <p style="float: right">

                            @if($game_session->player_1_username === request()->session()->get('game_session.username'))
                                <span>Player 2: {{ $game_session->player_2_username }} </span>
                            @endif

                            @if($game_session->player_2_username === request()->session()->get('game_session.username'))
                                <span>player 1: {{ $game_session->player_1_username }} </span>
                            @endif
                        </p>
                        <h4 class="card-title">Game Code : {{ $game_session->code }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            Game in Session.
                        </div>
                        <div>
                            <p class="text-center">
                                @if($game_session->player_1_username === request()->session()->get('game_session.username'))
                                  Guess Word:  {{ $game_session->guess_word }}
                                @endif
                            </p>
                        </div>
                        <hr>


                        <div>
                            @if($game_session->player_1_username === request()->session()->get('game_session.username'))
                                <div id="display_player_1_question">

                                </div>
                            @endif





                            @if($game_session->player_2_username === request()->session()->get('game_session.username'))
                                <div class="row">
                                    <div class="col-sm-6">
                                        <form method="POST" action="">
                                            <div class="form-group">
                                                <label for="guess_word">Guess the Word</label>
                                                <input id="guess_word" class="form-control" type="text" name="guess_word" placeholder="Enter the Guess Word">
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-success">Guess Word</button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-sm-6">
                                        <p> Total Question Asked : <strong> 0 </strong>  </p>
                                        <form id="ask_question_form" method="POST" action="{{ route('game.ask_question') }}">
                                            @csrf
                                            <input type="hidden" name="game_session_code" value="{{ $game_session->code }}">
                                            <div class="form-group">
                                                <label for="question">Ask Player 1 a question to help you guess word correctly.</label>
                                                <input id="question" type="text" class="form-control" name="question">
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary">Submit Question</button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    <script>
        var game_data = {
            player_type :"{{ ($game_session->player_1_username === request()->session()->get('game_session.username')) ? 'player_1' : 'player_2' }}" ,
            questions : [],
            current_question: null,
        }

        function askQuestion(event) {
            // get the question
            event.preventDefault();
            $.post(this.action, $(this).serialize(), function(data) {
               if (data.message === 'success') {
                   game_data.questions.push({
                       'question' : $('#question').val()
                   });
                   game_data.current_question = game_data.questions.length - 1;

               } else {
                   alert(data.message)
               }
            });
        }

        function getQuestion() {
            $.get(window.origin + '/game/get-questions',{ game_session_id : {{ $game_session->id }} }, function(data) {
                $('#display_player_1_question').html(data);
            });
        }

        //setInterval(getQuestion, 1000);


        $('#ask_question_form').submit(function (event) {
            event.preventDefault();
            $.post(this.action, $(this).serialize(), function(data) {
                if (data.message === 'success') {
                    game_data.questions.push({
                        'question' : $('#question').val()
                    });
                    game_data.current_question = game_data.questions.length - 1;

                } else {
                    alert(data.message)
                }
            });
        });



    </script>
@stop
