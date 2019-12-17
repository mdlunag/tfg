<?php

class Assign {

    private $id;
    private $nom;
    private $tipus;
    private $credits;
    private $grups;

    public function __construct($id, $nom, $tipus, $credits, $grups) {
        $this->id = $id;
        $this->nom = $nom;
        $this->tipus = $tipus;
        $this->credits = $credits;
        $this->grups = $grups;
    }

    
    
    public function obtenir_id(){
      return $this -> id;
  }
  
    public function obtenir_nom() {
        return $this->nom;
    }

    public function obtenir_tipus() {
        return $this->tipus;
    }

    public function obtenir_credits() {
        return $this->credits;
    }

    public function obtenir_grups() {
        return $this->grups;
    }

    public function canvia_nom($nom) {
        $this->nom = $nom;
    }

    public function canvia_cognoms($cognoms) {
        $this->cognoms = $cognoms;
    }

    public function canvia_email($email) {
        $this->email = $email;
    }

    public function canvia_punts($punts) {
        $this->punts = $punts;
    }

    public function canvia_contra($contra) {
        $this->contra = $contra;
    }

    public function canvia_actiu($actiu) {
        $this->actiu = $actiu;
    }

}
