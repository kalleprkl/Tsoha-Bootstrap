<?php

class Raportti extends BaseModel {

    public $tutkimus_id, $tutkija, $sijainti, $pvm, $vari, $haju, $sameus, $lampotila, $ph, $muuta;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Kenttatutkimusraportti');
        $query->execute();
        $rows = $query->fetchAll();
        $raportit = array();

        foreach ($rows as $row) {
            $raportit[] = new Raportti(array(
                'tutkimus_id' => $row['tutkimus_id'],
                'tutkija' => $row['tutkija'],
                'sijainti' => $row['sijainti'],
                'pvm' => $row['pvm'],
                'vari' => $row['vari'],
                'haju' => $row['haju'],
                'sameus' => $row['sameus'],
                'lampotila' => $row['lampotila'],
                'ph' => $row['ph'],
                'muuta' => $row['muuta']
            ));
            return $raportit;
        }
    }

    public static function find($tutkimus_id) {
        $query = DB::connection()->prepare('SELECT * FROM Kenttatutkimusraportti WHERE tutkimus_id = :tutkimus_id LIMIT 1');
        $query->execute(array('tutkimus_id' => $tutkimus_id));
        $row = $query->fetch();

        if ($row) {
            $raportti = new Raportti(array(
            'tutkimus_id' => $row['tutkimus_id'],
            'tutkija' => $row['tutkija'],
            'sijainti' => $row['sijainti'],
            'pvm' => $row['pvm'],
            'vari' => $row['vari'],
            'haju' => $row['haju'],
            'sameus' => $row['sameus'],
            'lampotila' => $row['lampotila'],
            'ph' => $row['ph'],
            'muuta' => $row['muuta']
            ));
            return $raportti;
        }
        return null;
    }
    
    public static function findBySijainti($koordinaatit) {
        $query = DB::connection()->prepare('SELECT * FROM Kenttatutkimusraportti WHERE sijainti = :koordinaatit LIMIT 1');
        $query->execute(array('koordinaatit' => $koordinaatit));
        $row = $query->fetch();

        if ($row) {
            $raportti = new Raportti(array(
            'tutkimus_id' => $row['tutkimus_id'],
            'tutkija' => $row['tutkija'],
            'sijainti' => $row['sijainti'],
            'pvm' => $row['pvm'],
            'vari' => $row['vari'],
            'haju' => $row['haju'],
            'sameus' => $row['sameus'],
            'lampotila' => $row['lampotila'],
            'ph' => $row['ph'],
            'muuta' => $row['muuta']
            ));
            return $raportti;
        }
        return null;
    }
}
