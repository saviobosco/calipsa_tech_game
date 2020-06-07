<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Front End Routes 
Route::get('/game-rules', 'FrontEndController@gameRules')->name('front_end.game_rules');
Route::get('/instructions', 'FrontEndController@instructions')->name('front_end.instructions');
Route::get('/about-game', 'FrontEndController@aboutGame')->name('front_end.about_game');
Route::get('/help', 'FrontEndController@help')->name('front_end.help');


// Game Routes 
Route::get('/start-game', 'GameController@start')->name('game.start');
Route::post('/game/begin', 'GameController@begin')->name('game.begin');
Route::post('/game/join', 'GameController@join')->name('game.join');

Route::post('/game/ask-question', 'GameController@askQuestion')->name('game.ask_question');

Route::post('/game/answer-question/{gameQuestion}', 'GameController@answerQuestion')->name('game.answer_question');

Route::post('/game/guess-word', 'GameController@guessWord')->name('game.guess_word');

Route::get('/game/game_over', 'GameController@gameOver')->name('game.game_over');

Route::get('/game/in-play', 'GameController@inPlay')->name('game.in_play');
