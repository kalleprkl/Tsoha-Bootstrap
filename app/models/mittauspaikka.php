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
        //N91.16738E181.95306
        if (!preg_match('/[NS][0-9][0-9][.][0-9]{5}[WE][01][0-8][0-9][.][0-9]{5}/', $this->koordinaatit)) {
            $errors[] = 'Anna koordinaatit halutussa muodossa';
        }
        if (substr($this->koordinaatit, 1, 1) == '9' && substr($this->koordinaatit, 2, 1) != '0') {
            $errors[] = 'Leveysaste ei ole kelvollinen';
        }
        if (substr($this->koordinaatit, 1, 1) == '9' && substr($this->koordinaatit, 4, 5) != '00000') {
            $errors[] = 'Leveysaste ei ole kelvollinen';
        }
        if (substr($this->koordinaatit, 11, 1) == '8' && substr($this->koordinaatit, 12, 1) != '0') {
            $errors[] = 'Pituusaste ei ole kelvollinen';
        }if (substr($this->koordinaatit, 11, 1) == '8' && substr($this->koordinaatit, 14, 5) != '00000') {
            $errors[] = 'Pituusaste ei ole kelvollinen';
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
