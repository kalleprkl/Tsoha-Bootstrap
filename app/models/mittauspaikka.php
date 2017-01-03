<?php

class Mittauspaikka extends BaseModel {
    
    public $koordinaatit, $kohde, $nimi, $lahestymisohje;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function findByVesisto($kohde_id) {
        $query = DB::connection()->prepare('SELECT * FROM Naytteenottopaikka WHERE kohde = :kohde_id');
        $query->execute(array('kohde_id' => $kohde_id));
        $rows = $query->fetchAll();
        $mittauspaikat = array();

        foreach ($rows as $row) {
            $mittauspaikat[] = new Mittauspaikka(array(
                'koordinaatit' => $row['koordinaatit'],
                'kohde' => $row['kohde'],
                'nimi' => $row['nimi'],
                'lahestymisohje' => $row['lahestymisohje']
            ));
            
        }
        return $mittauspaikat;
    }
}

