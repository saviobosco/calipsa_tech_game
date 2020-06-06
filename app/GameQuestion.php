<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class GameQuestion extends Model
{
    protected $table = 'game_questions';

    protected $fillable = [
        'game_session_id',
        'question',
        'answer',
    ];

}
