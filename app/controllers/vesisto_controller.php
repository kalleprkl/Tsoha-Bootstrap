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

    public static function muokkaa($kohde_id) {
        $vesisto = Vesisto::find($kohde_id);
        View::make('vesisto/muokkaa.html', array('vesisto' => $vesisto));
    }

    public static function paivita($kohde_id) {
        $params = $_POST;

        $kentat = array(
            'kohde_id' => $kohde_id,
            'nimi' => $params['nimi'],
            'paikkakunta' => $params['paikkakunta']
        );
        
        $vesisto = new Vesisto($kentat);
        $errors = $vesisto->errors();
        
        if (count($errors) > 0) {
            View::make('vesisto/muokkaa.html', array('errors' => $errors, 'vesisto' => $vesisto));
        } else {
            $vesisto->update();
            Redirect::to('/vesistot/' . $vesisto->kohde_id, array('message' => 'Kohteen ' . $vesisto->nimi . ' tiedot päivitetty'));
        }
    }

    public static function store() {
        $params = $_POST;

        $attributes = array(
            'nimi' => $params['nimi'],
            'paikkakunta' => $params['paikkakunta']
        );

        $uusi = new Vesisto($attributes);

        $errors = $uusi->errors();

        if (count($errors) == 0) {
            $uusi->save();
            Redirect::to('/vesistot/' . $uusi->kohde_id, array('message' => 'Uusi vesistö lisätty'));
        } else {
            View::make('vesisto/uusi.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public function poista($kohde_id) {
        $vesisto = new Vesisto(array('kohde_id' => $kohde_id));
        $vesisto->delete();
        Redirect::to('/vesistot', array('message' => 'Kohde poistettu'));
    }
}
