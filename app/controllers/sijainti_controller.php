<?php

class RaporttiController extends BaseController {
    
    public static function index() {
        
        $raportit = Raportti::all();
        
        View::make('raportti/index.html', array('games' => $games));
    }
}


