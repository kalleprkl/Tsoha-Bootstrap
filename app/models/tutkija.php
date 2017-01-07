<?php

class Tutkija extends BaseModel {
    
    public $tutkija_id, $nimi, $kayttajatunnus, $salasana;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function authenticate($kayttajatunnus, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM Tutkija WHERE kayttajatunnus = :kayttajatunnus AND salasana = :salasana LIMIT 1');
        $query->execute(array('kayttajatunnus' => $kayttajatunnus, 'salasana' => $salasana));
        $row = $query->fetch();
        
        if ($row) {
            $kayttaja = new Tutkija(array(
                'tutkija_id' => $row['tutkija_id'],
                'nimi' => $row['nimi'],
                'kayttajatunnus' => $row['kayttajatunnus'],
                'salasana' => $row['salasana']
            ));
            return $kayttaja;
        } else {
            return null;
        }
    }
    
    public static function find($tutkija_id) {
        $query = DB::connection()->prepare('SELECT * FROM Tutkija WHERE tutkija_id = :tutkija_id LIMIT 1');
        $query->execute(array('tutkija_id' => $tutkija_id));
        $row = $query->fetch();

        if ($row) {
            $kayttaja = new Tutkija(array(
                'tutkija_id' => $row['tutkija_id'],
                'nimi' => $row['nimi'],
                'kayttajatunnus' => $row['kayttajatunnus'],
                'salasana' => $row['salasana']
            ));
            return $kayttaja;
        } else {
            return null;
        }
    }
}