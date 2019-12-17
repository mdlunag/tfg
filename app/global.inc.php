<?php

class Globals {

    
    private $assignatura;
     private $tipus;
    private $quadri;
    private $professor;
    private $grups;
 

    public function __construct($id, $assignatura, $tipus, $quadri, $professor, $grups) {
        
        $this->assignatura = $assignatura;
        $this->quadri = $quadri;
        $this->tipus = $tipus;
        $this->professor = $professor;
        $this->grups = $grups;

    }
    public function obtenir_assignatura() {
        return $this->assignatura;
    }

    public function obtenir_quadri() {
        return $this->quadri;
    }
    
     public function obtenir_tipus() {
        return $this->tipus;
    }

    public function obtenir_professor() {
        return $this->professor;
    }

    public function obtenir_grups() {
        return $this->grups;
    }

  

}
