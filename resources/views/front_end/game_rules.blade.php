@extends('layout.master')

@section('title')
    Game Rules
@stop

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
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
                        
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
