@extends('layout.master')

@section('title')
    Start Game
@stop

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-sm-12" style="margin-bottom: 20px;">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> Game Rules </h4>
                    </div>
                    <div class="card-body">
                        <p> These are the rules of the game. </p>

                        <ol>
                            <li> A player can guess the correct word or ask up to 20 questions to guess the correct word. </li>
                            <li> If a player is unable to gues the correct word after 20 guess. the game ends. </li>
                            <li> If a player guess the word correctly, the game enter.</li>
                            <li> One player can start a game and share game code with a friend to join game </li>
                            <li> A User can enter an active game code to join a game.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Start New Game</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('game.begin') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="guess_word">Enter a Guess Word Here to Begin Game. &nbsp; &nbsp;  Eg. (Aeroplane) </label>
                                <input id="guess_word" type="text" class="form-control" name="guess_word">
                            </div>

                            <div class="form-group">
                                <label for="username">Enter Username</label>
                                <input id="username" type="text" class="form-control" name="username">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary">Start Game</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Join A Game</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('game.join') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="code">Enter Game Code</label>
                                <input id="code" type="text" class="form-control" name="code">
                            </div>

                            <div class="form-group">
                                <label for="username">Enter Username</label>
                                <input id="username" type="text" class="form-control" name="username">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary">Join Game</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
