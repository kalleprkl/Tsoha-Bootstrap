<?php

class Vesisto extends BaseModel {

    public $kohde_id, $nimi, $paikkakunta, $validators;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_paikkakunta');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Vesisto');
        $query->execute();
        $rows = $query->fetchAll();
        $vesistot = array();

        foreach ($rows as $row) {
            $vesistot[] = new Vesisto(array(
                'kohde_id' => $row['kohde_id'],
                'nimi' => $row['nimi'],
                'paikkakunta' => $row['paikkakunta']
            ));
        }
        return $vesistot;
    }

    public static function find($kohde_id) {
        $query = DB::connection()->prepare('SELECT * FROM Vesisto WHERE kohde_id = :kohde_id LIMIT 1');
        $query->execute(array('kohde_id' => $kohde_id));
        $row = $query->fetch();

        if ($row) {
            $vesisto = new Vesisto(array(
                'kohde_id' => $row['kohde_id'],
                'nimi' => $row['nimi'],
                'paikkakunta' => $row['paikkakunta']
            ));
            return $vesisto;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Vesisto (nimi, paikkakunta) VALUES (:nimi, :paikkakunta) RETURNING kohde_id');
        $query->execute(array('nimi' => $this->nimi, 'paikkakunta' => $this->paikkakunta));
        $row = $query->fetch();
        $this->kohde_id = $row['kohde_id'];
    }
    
    public function update() {
        $query = DB::connection()->prepare('UPDATE Vesisto SET nimi = :nimi, paikkakunta = :paikkakunta WHERE kohde_id = :kohde_id');
        $query->execute(array('kohde_id' => $this->kohde_id, 'nimi' => $this->nimi, 'paikkakunta' => $this->paikkakunta));
    }
    
    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Vesisto WHERE kohde_id = :kohde_id');
        $query->execute(array('kohde_id' => $this->kohde_id));
    }

    public function validate_nimi() {
        $errors = array();
        if (count(parent::validate_string_not_empty($this->nimi)) > 0) {
            $errors[] = 'Nimi ei voi olla tyhjä';
        }
        return $errors;
    }

    public function validate_paikkakunta() {
        $errors = array();
        if (count(parent::validate_string_not_empty($this->paikkakunta)) > 0) {
            $errors[] = 'Paikkakunta ei voi olla tyhjä';
        }
        return $errors;
    }

}
