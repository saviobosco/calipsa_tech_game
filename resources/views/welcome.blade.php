<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Word Guesser (Multiplayer Game) </title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
        <div class="top-right links">
            <a href="{{ route('front_end.game_rules') }}">Game Rules</a>
            <a href="{{ route('front_end.instructions') }}"> Instructions </a>
            <a href="{{ route('front_end.about_game') }}"> About Game </a>

        </div>

            <div class="content">
                <div class="title m-b-md">
                    Word Guesser. <br/>
                    <small style="font-size: 30px;">  Multiplayer Word Guessing Game </small>
                </div>

                <div class="links">
                    <a class="btn btn-primary" href="{{ route('game.start') }}">Click Here To Start  Game</a>
                </div>
            </div>
        </div>
    </body>
</html>
