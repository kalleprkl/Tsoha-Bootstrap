<?php

class Raportti extends BaseModel {

    public $tutkimus_id, $tutkija, $sijainti, $pvm, $vari, $haju, $sameus, $lampotila, $ph, $muuta, $validators;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_vari', 'validate_haju', 'validate_sameus', 'validate_muuta', 'validate_lampotila', 'validate_ph', 'validate_pvm');
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
        }
        return $raportit;
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
        $query = DB::connection()->prepare('SELECT * FROM Kenttatutkimusraportti JOIN Tutkija ON Kenttatutkimusraportti.tutkija = Tutkija.tutkija_id WHERE sijainti = :koordinaatit');
        $query->execute(array('koordinaatit' => $koordinaatit));
        $rows = $query->fetchAll();
        $raportit = array();

//        foreach ($rows as $row) {
//            $raportit[] = new Raportti(array(
//                'tutkimus_id' => $row['tutkimus_id'],
//                'tutkija' => $row['tutkija_id'],
//                'sijainti' => $row['sijainti'],
//                'pvm' => $row['pvm'],
//                'vari' => $row['vari'],
//                'haju' => $row['haju'],
//                'sameus' => $row['sameus'],
//                'lampotila' => $row['lampotila'],
//                'ph' => $row['ph'],
//                'muuta' => $row['muuta']
//            ));
//        }
        return $rows;
    }

    public static function findByTutkija($tutkija_id) {
        $query = DB::connection()->prepare('SELECT tutkimus_id, pvm, Naytteenottopaikka.nimi AS paikka, paikkakunta, Vesisto.nimi AS vesi '
                . '                             FROM Kenttatutkimusraportti '
                . '                             JOIN Naytteenottopaikka ON Kenttatutkimusraportti.sijainti = Naytteenottopaikka.koordinaatit '
                . '                             JOIN Vesisto ON Naytteenottopaikka.kohde = Vesisto.kohde_id '
                . '                         WHERE tutkija = :tutkija_id');
        $query->execute(array('tutkija_id' => $tutkija_id));
        $rows = $query->fetchAll();
        
        return $rows;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kenttatutkimusraportti (tutkija, sijainti, pvm, vari, haju, sameus, lampotila, ph, muuta) VALUES (:tutkija, :sijainti, :pvm, :vari, :haju, :sameus, :lampotila, :ph, :muuta) RETURNING tutkimus_id');
        $query->execute(array(
            'tutkija' => $this->tutkija,
            'sijainti' => $this->sijainti,
            'pvm' => $this->pvm,
            'vari' => $this->vari,
            'haju' => $this->haju,
            'sameus' => $this->sameus,
            'lampotila' => $this->lampotila,
            'ph' => $this->ph,
            'muuta' => $this->muuta
        ));
        $row = $query->fetch();
        $this->tutkimus_id = $row['tutkimus_id'];
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Kenttatutkimusraportti SET pvm = :pvm, vari = :vari, haju = :haju, sameus = :sameus, lampotila = :lampotila, ph = :ph, muuta = :muuta WHERE tutkimus_id = :tutkimus_id');
        $query->execute(array('pvm' => $this->pvm, 'vari' => $this->vari, 'haju' => $this->haju, 'sameus' => $this->sameus, 'lampotila' => $this->lampotila, 'ph' => $this->ph, 'muuta' => $this->muuta, 'tutkimus_id' => $this->tutkimus_id));
    }
    
    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Kenttatutkimusraportti WHERE tutkimus_id = :tutkimus_id');
        $query->execute(array('tutkimus_id' => $this->tutkimus_id));
    }
    
    public function validate_pvm() {
        $errors = array();
        $tekijat = explode('-', $this->pvm);
        if (count($tekijat) == 3) {
            if (checkdate($tekijat[1], $tekijat[2], $tekijat[0])) {
                return $errors;
            } else {
                $errors[] = 'Päivämäärä ei ole kelvollinen';
            }
        } else {
            $errors[] = 'Päivämäärä on syötetty väärin';
        }
        return $errors;
    }
    
    public function validate_vari() {
        $errors = array();
        if (count(parent::validate_string_length($this->vari, 50)) > 0) {
            $errors[] = 'Vari voi olla korkeintaan 50 merkkiä pitkä';
        }
        return $errors;
    }
    
    public function validate_haju() {
        $errors = array();
        if (count(parent::validate_string_length($this->haju, 50)) > 0) {
            $errors[] = 'Haju voi olla korkeintaan 50 merkkiä pitkä';
        }
        return $errors;
    }
    
    public function validate_sameus() {
        $errors = array();
        if (count(parent::validate_string_length($this->sameus, 50)) > 0) {
            $errors[] = 'Sameus voi olla korkeintaan 50 merkkiä pitkä';
        }
        return $errors;
    }
    
    public function validate_muuta() {
        $errors = array();
        if (count(parent::validate_string_length($this->muuta, 500)) > 0) {
            $errors[] = 'Muuta voi olla korkeintaan 500 merkkiä pitkä';
        }
        return $errors;
    }
    
    public function validate_lampotila() {
        $errors = array();
        if (!is_numeric($this->lampotila)) {
            $errors[] = 'Lämpötilan täytyy olla luku';
        }
        return $errors;
    }
    
    public function validate_ph() {
        $errors = array();
        if (!is_numeric($this->ph)) {
            $errors[] = 'pH:n täytyy olla luku';
        }
        return $errors;
    }
}
