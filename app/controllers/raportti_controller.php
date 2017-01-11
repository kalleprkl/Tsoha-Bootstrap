<?php

class RaporttiController extends BaseController {

    public static function listaa($koordinaatit) {
        $raportit = Raportti::findBySijainti($koordinaatit);
        $mittauspaikka = Mittauspaikka::findByKoordinaatit($koordinaatit);
        $vesisto = Vesisto::find($mittauspaikka->kohde);
//        Kint::dump($raportit);
        View::make('raportit/listaus.html', array('raportit' => $raportit, 'mittauspaikka' => $mittauspaikka, 'vesisto' => $vesisto));
    }

    public static function nayta($tutkimus_id) {
        $raportti = Raportti::find($tutkimus_id);
        $mittauspaikka = Mittauspaikka::findByKoordinaatit($raportti->sijainti);
        $vesisto = Vesisto::find($mittauspaikka->kohde);
        View::make('raportit/raportti.html', array('raportti' => $raportti, 'mittauspaikka' => $mittauspaikka, 'vesisto' => $vesisto));
    }

}
