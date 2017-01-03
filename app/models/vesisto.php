<?php

class Vesisto extends BaseModel {

    public $kohde_id, $nimi, $paikkakunta;

    public function __construct($attributes) {
        parent::__construct($attributes);
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

}
