<?php
namespace App\Http\Controllers;

class FrontEndController extends Controller {

    public function gameRules()
    {
        return view('front_end.game_rules');
    }


    public function instructions()
    {
        return view('front_end.instructions');
    }


    public function aboutGame()
    {
        return view('front_end.about_game');
    }


    public function help()
    {
        return view('front_end.help');
    }
    
}