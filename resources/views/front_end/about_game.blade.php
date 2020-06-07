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
                        <h4 class="card-title"> About Game </h4>
                    </div>
                    <div class="card-body text-center">
                        <p>
                            Word Guesser is a real time multiplayer word guessing game. 
                            A player enters a word, and another player try to guess the correct word while asking up to 20 questions.
                        </p>
                        <code>
                            Developed by Omebe Johnbosco for calipsa assessment test.
                            <p> Platform : Docker Machine <br>
                            PHP 7.2-fpm <br>
                            MySql 5.2 Server  <br>
                            Jquery 3.4 <br>
                            Php Rachet Server 2.0


                             </p>
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
