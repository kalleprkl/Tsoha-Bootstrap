<?php

class MittauspaikkaController extends BaseController {

    public static function uusi($kohde_id) {
        $vesisto = Vesisto::find($kohde_id);
        View::make('mittauspaikka/uusi.html', array('vesisto' => $vesisto));
    }

    public static function tallenna() {
        $params = $_POST;

        $attributes = array(
            'koordinaatit' => $params['koordinaatit'],
            'kohde' => $params['kohde'],
            'nimi' => $params['nimi'],
            'lahestymisohje' => $params['lahestymisohje']
        );

        $uusi = new Mittauspaikka($attributes);

        $errors = $uusi->errors();
        $errors =  array_merge($errors, $uusi->validate_koordinaatit());

        if (count($errors) == 0) {
            $uusi->save();
            Redirect::to('/vesistot/' . $uusi->kohde, array('message' => 'Uusi mittauspaikka lisätty'));
        } else {
            $vesisto = array('kohde_id' => $params['kohde']);
            View::make('mittauspaikka/uusi.html', array('errors' => $errors, 'attributes' => $attributes, 'vesisto' => $vesisto));
        }
    }

    public function poista($koordinaatit) {
        $mittauspaikka = Mittauspaikka::findByKoordinaatit($koordinaatit);
        $mittauspaikka->delete();
        Redirect::to('/vesistot/' .$mittauspaikka->kohde, array('message' => 'Kohde poistettu'));
    }
    
    public static function muokkaa($koordinaatit) {
        $mittauspaikka = Mittauspaikka::findByKoordinaatit($koordinaatit);
        View::make('/mittauspaikka/muokkaa.html', array('mittauspaikka' => $mittauspaikka));
    }
    
    public function paivita($koordinaatit) {
        $params = $_POST;
        
        $kentat = array(
            'koordinaatit' => $koordinaatit,
            'kohde' => $params['kohde'],
            'nimi' => $params['nimi'],
            'lahestymisohje' => $params['lahestymisohje']
        );
        
        $mittauspaikka = new Mittauspaikka($kentat);
        $errors = $mittauspaikka->errors();
        
        if (count($errors) == 0) {
            $mittauspaikka->update();
            Redirect::to('/vesistot/' .$mittauspaikka->kohde, array('message' => 'Mittauspaikan ' .$mittauspaikka->nimi. ' tiedot päivitetty'));
        } else {
            $vesisto = array('kohde_id' => $params['kohde']);
            View::make('mittauspaikka/muokkaa.html', array('errors' => $errors, 'mittauspaikka' => $kentat));
        }
    }
}
