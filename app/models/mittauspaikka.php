<?php

class Mittauspaikka extends BaseModel {

    public $koordinaatit, $kohde, $nimi, $lahestymisohje, $validators;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_lahestymisohje');
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

    public static function findByKoordinaatit($koordinaatit) {
        $query = DB::connection()->prepare('SELECT * FROM Naytteenottopaikka WHERE koordinaatit = :koordinaatit LIMIT 1');
        $query->execute(array('koordinaatit' => $koordinaatit));
        $row = $query->fetch();

        if ($row) {
            $mittauspaikka = new Mittauspaikka(array(
                'koordinaatit' => $row['koordinaatit'],
                'kohde' => $row['kohde'],
                'nimi' => $row['nimi'],
                'lahestymisohje' => $row['lahestymisohje']
            ));
            return $mittauspaikka;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Naytteenottopaikka (koordinaatit, kohde, nimi, lahestymisohje) VALUES (:koordinaatit, :kohde, :nimi, :lahestymisohje)');
        $query->execute(array('koordinaatit' => $this->koordinaatit, 'kohde' => $this->kohde, 'nimi' => $this->nimi, 'lahestymisohje' => $this->lahestymisohje));
    }
    
    public function validate_koordinaatit() {
        $errors = array();
        if (count(parent::validate_string_not_empty($this->koordinaatit)) > 0) {
            $errors[] = 'Koordinaatit ei voi olla tyhjä';
        }
        if (count(parent::validate_string_length($this->koordinaatit, 30)) > 0) {
            $errors[] = 'Koordinaatit voi olla korkeintaan 30 merkkiä pitkä';
        }
        
        $paikka = Mittauspaikka::findByKoordinaatit($this->koordinaatit);
        
        if ($paikka) {
            $errors[] = "Koordinaatteja vastaava mittauspaikka on jo olemassa";
        }
        return $errors;
    }
    
    public function validate_nimi() {
        $errors = array();
        if (count(parent::validate_string_not_empty($this->nimi)) > 0) {
            $errors[] = 'Nimi ei voi olla tyhjä';
        }
        if (count(parent::validate_string_length($this->nimi, 50)) > 0) {
            $errors[] = 'Nimi voi olla korkeintaan 50 merkkiä pitkä';
        }
        return $errors;
    }
    
    public function validate_lahestymisohje() {
        $errors = array();
        if (count(parent::validate_string_length($this->lahestymisohje, 200)) > 0) {
            $errors[] = 'Ohje voi olla korkeintaan 200 merkkiä pitkä';
        }
        return $errors;
    }
    
    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Naytteenottopaikka WHERE koordinaatit = :koordinaatit');
        $query->execute(array('koordinaatit' => $this->koordinaatit));
    }
    
    public function update() {
        $query = DB::connection()->prepare('UPDATE Naytteenottopaikka SET nimi = :nimi, lahestymisohje = :lahestymisohje WHERE koordinaatit = :koordinaatit');
        $query->execute(array('koordinaatit' => $this->koordinaatit, 'nimi' => $this->nimi, 'lahestymisohje' => $this->lahestymisohje));
    }
}
