<?php

class NayteController extends BaseController {
    
    public static function uusi($tutkimus_id) {
        $raportti = Raportti::find($tutkimus_id);
        View::make('naytteet/uusi.html', array('raportti' => $raportti));
    }
    
    public static function tallenna() {
        $params = $_POST;

        $attributes = array(
            'tutkimus' => $params['tutkimus_id'],
            'tulokset' => $params['tulokset'],
        );

        $uusi = new Nayte($attributes);

        $errors = $uusi->errors();

        if (count($errors) == 0) {
            $uusi->save();
            Redirect::to('/raportit/' . $uusi->tutkimus, array('message' => 'Uusi näyte lisätty'));
        } else {
            $raportti = array('tutkimus_id' => $attributes['tutkimus']);
            View::make('naytteet/uusi.html', array('errors' => $errors, 'attributes' => $attributes, 'raportti' => $raportti));
        }
    }
    
    public static function muokkaa($nayte_id) {
        $nayte = Nayte::find($nayte_id);
        View::make('naytteet/muokkaa.html', array('nayte' => $nayte));
    }
    
    public static function paivita($tutkimus_id) {
        $params = $_POST;
        
        $nayte = new Nayte($params);
        
        $errors = array();
        
        if (count($errors == 0)) {
            $nayte->update();
            Redirect::to('/raportit/' .$nayte->tutkimus, array('message' => 'Näytteen '.$nayte->nayte_id. ' tiedot päivitetty'));
        } else {
            
        }
    }
    
    public function poista($nayte_id) {
        $nayte = Nayte::find($nayte_id);
        $nayte->delete();
       
        Redirect::to('/raportit/' .$nayte->tutkimus, array('message' => 'Nayte poistettu'));
    }
}

