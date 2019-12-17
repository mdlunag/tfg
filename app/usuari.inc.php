<?php

class Usuari{
  private $id;
  private $nom;
  private $cognoms;
  private $email;
  private $punts;
  private $contra;
  private $Dataregistre;
  private $actiu;
  
  public function __construct($id,$nom,$cognoms,$email,$punts,$contra,$Dataregistre,$actiu) {
      $this -> id = $id;
      $this -> nom = $nom;
      $this -> cognoms = $cognoms;
      $this -> email = $email;
      $this -> punts= intval($punts);
      $this -> contra = $contra;
      $this -> Dataregistre = $Dataregistre;
      $this -> actiu = $actiu;
      
  }
  
  public function obtenir_id(){
      return $this -> id;
  }   
   public function obtenir_nom(){
      return $this -> nom;
      
  } 
  
  public function obtenir_cognoms(){
      return $this -> cognoms;
      
  }
  
   public function obtenir_email(){
      return $this -> email;
      
  }  
  
   public function obtenir_punts(){
      return $this -> punts;
      
  } 
  
   public function obtenir_contra(){
      return $this -> contra;
   }   
       public function obtenir_Dataregisre(){
      return $this -> Dataregistre;
      
  }  
  
   public function esta_actiu(){
      return $this -> actiu;
        
  } 
  
  public function canvia_nom($nom) {
      $this -> nom = $nom;
  }
  
  public function canvia_cognoms($cognoms) {
      $this -> cognoms = $cognoms;
  }
  
  public function canvia_email($email) {
      $this -> email = $email;
  }
  
  public function canvia_punts($punts) {
      $this -> punts = $punts;
  }
  
  public function canvia_contra($contra) {
      $this -> contra = $contra;
  }
  
  public function canvia_actiu($actiu) {
      $this -> actiu = $actiu;
  }
}