<?php

class VesistoController extends BaseController {

    public static function index() {

        $vesistot = Vesisto::all();

        View::make('vesisto/index.html', array('vesistot' => $vesistot));
    }

    public static function show($kohde_id) {
        $mittauspaikat = Mittauspaikka::findByVesisto($kohde_id);
        $vesisto = Vesisto::find($kohde_id);
        View::make('vesisto/mittauspaikat.html', array('mittauspaikat' => $mittauspaikat, 'vesisto' => $vesisto));
    }

    public static function lomake() {
        View::make('vesisto/uusi.html');
    }

    public static function store() {
        $params = $_POST;
        
        $uusi = new Vesisto(array(
            'nimi' => $params['nimi'],
            'paikkakunta' => $params['paikkakunta']
        ));

        $uusi->save();

        // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
        Redirect::to('/vesistot/' . $uusi->kohde_id, array('message' => 'Uusi vesistö lisätty'));
    }

}
