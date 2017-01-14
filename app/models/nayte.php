<?php

class Nayte extends BaseModel {
    
    public $nayte_id, $tutkimus, $tulokset, $validators;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_tulokset');
    }
    
    public static function find($nayte_id) {
        $query = DB::connection()->prepare('SELECT * FROM Nayte WHERE nayte_id = :nayte_id LIMIT 1');
        $query->execute(array('nayte_id' => $nayte_id));
        $row = $query->fetch();

        if ($row) {
            $nayte = new Nayte(array(
                'nayte_id' => $row['nayte_id'],
                'tutkimus' => $row['tutkimus'],
                'tulokset' => $row['tulokset']
             ));
            return $nayte;
        }
        return null;
    }
    
    public static function findByRaportti($tutkimus_id) {
        $query = DB::connection()->prepare('SELECT * FROM Nayte WHERE tutkimus = :tutkimus');
        $query->execute(array('tutkimus' => $tutkimus_id));
        $rows = $query->fetchAll();
        $naytteet = array();

        foreach ($rows as $row) {
            $naytteet[] = new Nayte(array(
                'nayte_id' => $row['nayte_id'],
                'tutkimus' => $row['tutkimus'],
                'tulokset' => $row['tulokset']
            ));
        }
        
        return $naytteet;
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Nayte (tutkimus, tulokset) VALUES (:tutkimus, :tulokset) RETURNING nayte_id');
        $query->execute(array(
            'tutkimus' => $this->tutkimus,
            'tulokset' => $this->tulokset,
        ));
        $row = $query->fetch();
        $this->nayte_id = $row['nayte_id'];
        
    }
    
    public function update() {
        $query = DB::connection()->prepare('UPDATE Nayte SET tulokset = :tulokset WHERE nayte_id = :nayte_id');
        $query->execute(array('nayte_id' => $this->nayte_id, 'tulokset' => $this->tulokset));
    }
    
    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Nayte WHERE nayte_id = :nayte_id');
        $query->execute(array('nayte_id' => $this->nayte_id));
    }
    
    public function validate_tulokset() {
        $errors = array();
        if (count(parent::validate_string_length($this->tulokset, 1000)) > 0) {
            $errors[] = 'Tulokset voi olla korkeintaan 1000 merkkiä pitkä';
        }
        return $errors;
    }
}

