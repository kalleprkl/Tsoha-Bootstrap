<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
//   	  View::make('home.html');
        echo 'Tämä on etusivu!';
    }

    public static function sandbox() {
//        $regex = '/[+-][01][0-8][0-9][.][0-9]{5}[,]\h[+-][01][0-8][0-9][.][0-9]{5}/';
//        $subject = '+032.30642, -122.61458';
//        if (preg_match($regex, $subject)) {
//            echo 'yeah';
//        }
        $string = 'N91.16738E181.95306';
        echo substr($string, 4, 5);
        echo '<br>';
        echo substr($string, 14, 5);
    }

    public static function kohteet() {
        View::make('suunnitelmat/kohteet.html');
    }

    public static function kohde() {
        View::make('suunnitelmat/kohde.html');
    }

    public static function paikka() {
        View::make('suunnitelmat/paikka.html');
    }

    public static function raportti() {
        View::make('suunnitelmat/raportti.html');
    }

    public static function tyyppi() {
        View::make('suunnitelmat/tyyppi.html');
    }

    public static function muokkaaKohde() {
        View::make('suunnitelmat/muokkaaKohde.html');
    }

    public static function muokkaaPaikka() {
        View::make('suunnitelmat/muokkaaPaikka.html');
    }

    public static function muokkaaRaportti() {
        View::make('suunnitelmat/muokkaaRaportti.html');
    }

    public static function muokkaaNayte() {
        View::make('suunnitelmat/muokkaaNayte.html');
    }

}
