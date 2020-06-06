@extends('layout.master')


@section('content')

    <div class="container">
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
