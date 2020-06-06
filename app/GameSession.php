<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    protected $table = 'game_sessions';

    protected $fillable = [
        'code',
        'guess_word',
        'player_1_username',
        'player_2_username',
        'game_over'
    ];


    public function questions() {
        return $this->belongsTo(GameQuestion::class, 'game_session_id', 'id');
    }
}
