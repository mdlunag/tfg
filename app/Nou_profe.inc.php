<?php

class ValidaCredencials {

    private $avis_inici;
    private $avis_tancament;
    private $nom;
    private $cognoms;
    private $email;
    private $punts;
    private $error_contra;
    private $error_nom;
    private $error_cognoms;
    private $error_email;
    private $contra;

    public function __construct($nom, $cognoms, $email, $punts,$contra) {
        $this->avis_inici = " <br><div class='alert alert-danger' role='alert'>";
        $this->avis_tancament = "</div>";
        $this->nom = "";
        $this->cognoms = "";
        $this->email = "";
        $this -> punts = 0;
        $this -> contra ="";
        $this->error_nom = $this->validar_nom($nom);
        $this->error_cognoms = $this->validar_cognoms($cognoms);
        $this->error_email = $this->validar_email($email);
        $this->error_punts = $this->validar_punts($punts);
        $this->error_contra = $this->validar_contra($contra);
        
        if ($this-> error_contra === ""){
            
            $this -> contra= $contra;
        }
    }

    private function variable_iniciada($variable) {
        if (isset($variable) && !empty($variable)) {

            return true;
        } else {
            return false;
        }
    }
    
   
    private function validar_nom($nom) {
        if (!$this->variable_iniciada($nom)) {
            return "Has d'escriure un nom";
        } else {
            $this->nom = $nom;
        }

        if (strlen($nom) < 2) {

            return "Escriu un nom vàlid";
        }

        if (strlen($nom) > 25) {

            return "Escriu un nom vàlid";
        }

        return "";
    }

    private function validar_cognoms($cognoms) {
        if (!$this->variable_iniciada($cognoms)) {
            return "Has d'escriure un nom";
        } else {
            $this->cognoms = $cognoms;
        }

        if (strlen($cognoms) < 2) {

            return "Escriu un cognom vàlid";
        }


        return "";
    }

    private function validar_email($email) {
        if (!$this->variable_iniciada($email)) {
            return "Has d'escriure un email";
        } else {
            $this->email = $email;
        }

        if (strpos($email, '@') == false) {
            return "Escriu una adreça email vàlida";
        }


        return "";
    }

     private function validar_punts($punts) {
        if (!$this->variable_iniciada($punts)) {
            return "Has d'escriure el nombre de punts";
        } else {
            $this->punts = $punts;
        }

        return "";
    }
    
    private function validar_contra($contra) {

        if (strlen($contra) > 10) {

            return "Contrasenya no vàlida. Prova-ho de nou.";
        }

        return "";
    }

    public function obtenir_nom() {
        return $this->nom;
    }
    
    public function obtenir_contra(){
        return $this->contra;
    }

    public function obtenir_cognoms() {
        return $this->cognoms;
    }
    
    public function obtenir_punts() {
        return $this->punts;
    }

    public function obtenir_email() {
        return $this->email;
    }
    

    public function obtenir_error_nom() {

        return $this->error_nom;
    }

    public function obtenir_error_cognoms() {

        return $this->error_cognoms;
    }

    public function obtenir_error_email() {

        return $this->error_email;
    }
    
     public function obtenir_error_punts() {

        return $this->error_punts;
    }

    public function obtenir_error_contra() {

        return $this->error_contra;
    }

    public function mostrar_email() {

        if ($this->email !== "") {

            echo 'value="' . $this->email . '"';
        }
    }

    public function mostrar_nom() {

        if ($this->nom !== "") {

            echo 'value="' . $this->nom . '"';
        }
    }

     public function mostrar_punts() {

        if ($this->punts !== "") {

            echo 'value="' . $this->punts . '"';
        }
    }

    public function mostrar_cognoms() {

        if ($this->cognoms !== "") {

            echo 'value="' . $this->cognoms . '"';
        }
    }

    public function mostrar_error_contra() {
        if ($this->error_contra !== "") {
            echo $this->avis_inici . $this->error_contra . $this->avis_tancament;
        }
    }

    public function mostrar_error_nom() {
        if ($this->error_nom !== "") {
            echo $this->avis_inici . $this->error_nom . $this->avis_tancament;
        }
    }

    public function mostrar_error_email() {
        if ($this->error_email !== "") {
            echo $this->avis_inici . $this->error_email . $this->avis_tancament;
        }
    }

    public function mostrar_error_cognoms() {
        if ($this->error_cognoms !== "") {
            echo $this->avis_inici . $this->error_cognoms . $this->avis_tancament;
        }
    }
    
     public function mostrar_error_punts() {
        if ($this->error_punts !== "") {
            echo $this->avis_inici . $this->error_punts . $this->avis_tancament;
        }
    }

    public function registre_valid() {

        if ($this->error_nom ==="" &&
            $this->error_email === "" &&
            $this ->error_punts ===""&&
            $this->error_nom === ""&&
            $this->error_cognoms ==="" &&
            $this->error_contra === ""){
            return true;
        }else{
            return false;
        }
    }

}

?>