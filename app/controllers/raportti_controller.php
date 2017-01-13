<?php

class RaporttiController extends BaseController {

    public static function listaa($koordinaatit) {
        $raportit = Raportti::findBySijainti($koordinaatit);
        $mittauspaikka = Mittauspaikka::findByKoordinaatit($koordinaatit);
        $vesisto = Vesisto::find($mittauspaikka->kohde);

//        Kint::dump($raportit);
        View::make('raportit/listaus.html', array('raportit' => $raportit, 'mittauspaikka' => $mittauspaikka, 'vesisto' => $vesisto));
    }

    public static function listaus_by_tutkija($tutkija_id) {
        $raportit = Raportti::findByTutkija($tutkija_id);
        $tutkija = Tutkija::find($tutkija_id);
        View::make('raportit/tutkijan_raportit.html', array('raportit' => $raportit, 'tutkija' => $tutkija));
    }

    public static function nayta($tutkimus_id) {
        $raportti = Raportti::find($tutkimus_id);
        $mittauspaikka = Mittauspaikka::findByKoordinaatit($raportti->sijainti);
        $vesisto = Vesisto::find($mittauspaikka->kohde);
        View::make('raportit/raportti.html', array('raportti' => $raportti, 'mittauspaikka' => $mittauspaikka, 'vesisto' => $vesisto));
    }

    public static function uusi($koordinaatit) {
        $mittauspaikka = Mittauspaikka::findByKoordinaatit($koordinaatit);
        $tutkija_id = $_SESSION['user'];
        $tutkija = Tutkija::find($tutkija_id);

        View::make('raportit/uusi.html', array('tutkija' => $tutkija, 'mittauspaikka' => $mittauspaikka));
    }

    public static function tallenna() {
        $params = $_POST;

        $attributes = array(
            'tutkija' => $params['tutkija_id'],
            'sijainti' => $params['koordinaatit'],
            'pvm' => $params['pvm'],
            'vari' => $params['vari'],
            'haju' => $params['haju'],
            'sameus' => $params['sameus'],
            'lampotila' => $params['lampotila'],
            'ph' => $params['ph'],
            'muuta' => $params['muuta']
        );

        $uusi = new Raportti($attributes);

        $errors = array();

        if (count($errors) == 0) {
            $uusi->save();
//            Redirect::to('/vesistot/' . $uusi->sijainti. '/', array('message' => 'Uusi mittauspaikka lisätty'));
        } else {
            $vesisto = array('kohde_id' => $params['kohde']);
            View::make('mittauspaikka/uusi.html', array('errors' => $errors, 'attributes' => $attributes, 'vesisto' => $vesisto));
        }
    }

    public static function muokkaa($tutkimus_id) {
        $raportti = Raportti::find($tutkimus_id);
        View::make('raportit/muokkaa.html', array('raportti' => $raportti));
    }
    
    public static function paivita($tutkimus_id) {
        $params = $_POST;
        
        $raportti = new Raportti($params);
        
        $errors = array();
        
        if (count($errors == 0)) {
            $raportti->update();
            Redirect::to('/raportit/' .$raportti->tutkimus_id, array('message' => 'Raportin tiedot päivitetty'));
        } else {
            
        }
    }
    
    public function poista($tutkimus_id) {
        $raportti = Raportti::find($tutkimus_id);
        $raportti->delete();
        Redirect::to('/mittauspaikat/' .$raportti->sijainti, array('message' => 'Raportti poistettu'));
    }
}
