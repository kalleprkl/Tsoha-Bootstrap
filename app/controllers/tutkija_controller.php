<?php

class TutkijaController extends BaseController {

    public static function login() {
        View::make('login/login.html');
    }

    public static function logout() {
        $_SESSION['user'] = null;
        Redirect::to('/', array('message' => 'Olet kirjautunut ulos!'));
    }

    public static function kasittele() {
        $params = $_POST;

        $user = Tutkija::authenticate($params['kayttajatunnus'], $params['salasana']);

        if (!$user) {
            View::make('login/login.html', array('error ' => 'Väärä salasana', 'kayttajatunnus' => $params['kayttajatunnus']));
        } else {
            $_SESSION['user'] = $user->tutkija_id;

            Redirect::to('/vesistot');
        }
    }

}
