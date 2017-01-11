<?php

class BaseController {

    public static function get_user_logged_in() {
        if (isset($_SESSION['user'])) {
            $tutkija_id = $_SESSION['user'];
            $user = Tutkija::find($tutkija_id);

            return $user;
        }

        return null;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['user'])) {
            Redirect::to('/login', array('error' => 'Sisäänkirjautuminen vaaditaan'));
        }
    }

}
