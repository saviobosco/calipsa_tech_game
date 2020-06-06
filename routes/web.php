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

Route::get('/start-game', 'GameController@start')->name('game.start');
Route::post('/game/begin', 'GameController@begin')->name('game.begin');
Route::post('/game/join', 'GameController@join')->name('game.join');
Route::post('/game/ask-question', 'GameController@askQuestion')->name('game.ask_question');
Route::post('/game/answer-question', 'GameController@answerQuestion')->name('game.answer_question');

Route::get('/game/get-questions', 'GameController@getQuestions')->name('game.get_questions');


Route::get('/game/in-play', 'GameController@inPlay')->name('game.in_play');
