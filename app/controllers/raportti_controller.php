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
        $naytteet = Nayte::findByRaportti($tutkimus_id);
        
        View::make('raportit/raportti.html', array('raportti' => $raportti, 'mittauspaikka' => $mittauspaikka, 'vesisto' => $vesisto, 'naytteet' => $naytteet));
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

        $errors = $uusi->errors();

        if (count($errors) == 0) {
            $uusi->save();
            Redirect::to('/vesistot/' . $uusi->sijainti. '/raportit', array('message' => 'Uusi raportti lisätty'));
        } else {
            $tutkija = array('tutkija_id' => $attributes['tutkija']);
            $mittauspaikka = array('koordinaatit' => $attributes['sijainti']);
            View::make('raportit/uusi.html', array('errors' => $errors, 'attributes' => $attributes, 'tutkija' => $tutkija, 'mittauspaikka' => $mittauspaikka));
        }
    }

    public static function muokkaa($tutkimus_id) {
        $raportti = Raportti::find($tutkimus_id);
        View::make('raportit/muokkaa.html', array('raportti' => $raportti));
    }
    
    public static function paivita($tutkimus_id) {
        $params = $_POST;
        
        $raportti = new Raportti($params);
        
        $errors = $raportti->errors();
        
        if (count($errors) == 0) {
            $raportti->update();
            Redirect::to('/raportit/' .$raportti->tutkimus_id, array('message' => 'Raportin tiedot päivitetty'));
        } else {
            View::make('raportit/muokkaa.html', array('errors' => $errors, 'raportti' => $raportti));
        }
    }
    
    public function poista($tutkimus_id) {
        $raportti = Raportti::find($tutkimus_id);
        $raportti->delete();
        Redirect::to('/vesistot/' .$raportti->sijainti. '/raportit', array('message' => 'Raportti poistettu'));
    }
}
