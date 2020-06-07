@extends('layout.master')

@section('title')
  {{ $game_session->code }} Game In Session.
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <p style="float: right">

                            @if($game_session->player_1_username === request()->session()->get('game_session.username'))
                                <span>Player 2: <strong id="player-2-username"> {{ $game_session->player_2_username }} </strong>  </span>
                            @endif

                            @if($game_session->player_2_username === request()->session()->get('game_session.username'))
                                <span>player 1: <strong> {{ $game_session->player_1_username }} </strong>  </span>
                            @endif
                        </p>
                        <h4 class="card-title">Game Code : {{ $game_session->code }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            Game in Session.
                        </div>
                        @if (!$game_session->player_2_username)
                            <div id="game-code-share" class="alert alert-info">
                                Copy game code : <strong>{{ $game_session->code }}</strong> and share with a friend.
                            </div>
                        @endif


                        <div>
                            @if($game_session->player_1_username === request()->session()->get('game_session.username'))
                                <p> Total Question Asked : <strong id="total-questions"> {{ $totalQuestionsCount }} </strong>  </p>
                            @endif

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
                                    @if (isset($unAnsweredQuestions) && !empty($unAnsweredQuestions))
                                        @foreach($unAnsweredQuestions as $unAnsweredQuestion)
                                            @include('game.question.question', ['question' => $unAnsweredQuestion])
                                        @endforeach
                                    @endif
                                </div>
                            @endif





                            @if($game_session->player_2_username === request()->session()->get('game_session.username'))
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div id="guess-word-response">

                                        </div>
                                        <form id="guess-word-form" method="POST" action="{{ route('game.guess_word') }}">
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
                                        <p> Total Question Asked : <strong id="total-questions"> {{ $totalQuestionsCount }} </strong>  </p>
                                        <div id="question-sent-response">

                                        </div>
                                        <form style="{{ (isset($unAnsweredQuestions) && !$unAnsweredQuestions->isEmpty()) ? 'display:none;' : 'display:block;' }}"
                                            id="ask_question_form" method="POST" action="{{ route('game.ask_question') }}">
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

                                        <hr>
                                        <div id="asked-questions-container">
                                            @if(isset($answeredQuestions) && !$answeredQuestions->isEmpty())
                                                @foreach($answeredQuestions as $answeredQuestion)
                                                    @include('game.question.answer', ['question' => $answeredQuestion])
                                                @endforeach
                                            @endif
                                        </div>
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
            game_code: "{{ $game_session->code }}",
            username: "{{ request()->session()->get('game_session.username') }}",
        }



        $('#ask_question_form').submit(function (event) {
            event.preventDefault();
            $.post(this.action, $(this).serialize(), function(data) {
                if (data.message) {
                    $('#question').val('');
                    questionSentResponseMessage(data.message);
                    $('#ask_question_form').hide();
                } else {
                    questionSentResponseMessage(data.message)
                }
            });
        });

        $('#guess-word-form').submit(function(event) {
           event.preventDefault();

            $.post(this.action, $(this).serialize(), function(data) {
                if (data.message) {
                    guessWordResponseMessage(data.message);
                } else {
                    guessWordResponseMessage(data.message)
                }
            });

        });
        function guessWordResponseMessage(message) {
            $('#guess-word-response').html(message);
            setTimeout(function () {
                $('#guess-word-response').html('');
            }, 3000);
        }


        function questionSentResponseMessage(message) {
            $('#question-sent-response').html(message);
            setTimeout(function () {
                $('#question-sent-response').html('');
            }, 3000);
        }

        $('#display_player_1_question').click(function (event) {

            if (event.target.tagName=== "BUTTON") {
                event.preventDefault();
                // get the form
                var form_data = $(event.target.form).serialize();
                if (form_data == '') {
                    alert('Please select an answer.')
                } else {
                    $.post(event.target.form.action, form_data, function(data) {
                        if (data) {
                            $('#display_player_1_question').html('');
                        }
                    });
                }
            }
        });

    </script>


    <script src="{{ asset('js/ab_websock.js') }}"></script>
    <script>
        var conn = new ab.Session('ws://' + window.location.hostname +':9091',
            function() {
                conn.subscribe('{{ $game_session->code }}', function(game_code, data) {
                    if (game_code === game_data.game_code) {
                        if (data !== undefined) {

                            if (data.event_type === "player_joined") {
                                if (data.username !== game_data.username) {
                                    alert("Player 2 has join the game");
                                    $('#player-2-username').text(data.username);
                                    $('#game-code-share').hide();
                                }
                            }

                            if (data.event_type === 'question_asked') {
                                $('#display_player_1_question').prepend(data.question_view);
                            }

                            if (data.event_type === 'question_answered') {
                                $('#asked-questions-container').prepend(data.answer_view);
                                if (data.total_questions !== undefined) {
                                    $('#total-questions').text(data.total_questions);
                                }

                                if ( parseInt(data.un_answered_questions) === 0) {
                                    $('#ask_question_form').show();
                                }
                            }

                            if (data.event_type === 'game_over') {

                                alert(data.message);
                                window.location.href ="{{ route('game.game_over') }}"
                            }
                        }
                    }
                    // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                });
            },
            function() {
                console.warn('WebSocket connection closed');
            },
            {'skipSubprotocolCheck': true}
        );
    </script>
@stop
