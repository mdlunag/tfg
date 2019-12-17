<?php

class Professor {

    public $id;
    private $nom;
    private $cognoms;
    private $email;
    private $punts;
    private $cobert_Q1;
    private $cobert_Q2;
    private $contrasenya;
    private $data_creacio;
    private $estat;
    private $admin;

    public function __construct($id, $nom, $cognoms, $email, $punts, $cobert_Q1, $cobert_Q2, $contrasenya, $data_creacio, $estat, $admin) {
        $this->id = $id;
        $this->nom = $nom;
        $this->cognoms = $cognoms;
        $this->email = $email;
        $this->punts = intval($punts);
        $this->cobert_Q1 = $cobert_Q1;
        $this->cobert_Q2 = $cobert_Q2;
        $this->contrasenya = $contrasenya;
        $this->data_creacio = $data_creacio;
        $this->estat = $estat;
        $this -> admin = $admin;
    }

    public function obtenir_id() {
        return $this->id;
    }

    public function obtenir_nom() {
        return $this->nom;
    }

    public function obtenir_cognoms() {
        return $this->cognoms;
    }
    
    public function obtenir_nom_complet(){
        return $this->nom .' '.$this->cognoms;
    }

    public function obtenir_email() {
        return $this->email;
    }

    public function obtenir_punts() {
        return $this->punts;
    }

    public function obtenir_cobert_Q1() {
        return intval($this->cobert_Q1);
    }

    public function obtenir_cobert_Q2() {
        return intval($this->cobert_Q2);
    }

    public function obtenir_contrasenya() {
        return $this->contrasenya;
    }

    public function obtenir_data_creacio() {
        return $this->data_creacio;
    }

    public function estat() {
        return intval($this->estat);
    }
    
    public function admin() {
        return $this->admin;
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
    
    public function canvia_cobert_Q1($cobert_Q1) {
        $this->cobert_Q1 = $cobert_Q1;
    }

    public function canvia_cobert_Q2($cobert_Q2) {
        $this->cobert_Q2 = $cobert_Q2;
    }
    
    public function canvia_contrasenya($contrasenya) {
        $this->contrasenya = $contrasenya;
    }

    public function canvia_estat($estat) {
        $this->estat = $estat;
    }
    
     public function canvia_admin($admin) {
        $this->admin = $admin;
    }

}
