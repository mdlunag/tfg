<?php

include_once 'RepositoriProfessors.inc.php';

class ValidadorLogin {
    private $professor;
    private $error;
    public function __construct ($email, $contrasenya, $conexio){
        $this -> error="";
        if (!$this -> variable_iniciada($email) || !$this -> variable_iniciada($contrasenya)){
            
            $this -> professor = null;
            $this -> error ="Has d'introduir el teu email";
            
        }else{
            $this -> professor = RepositoriProfessors::obtenir_per_email($conexio,$email);
                if(is_null($this -> professor) || $contrasenya!=$this ->professor -> obtenir_contrasenya()){
                //if(is_null($this -> professor) || !password_verify($contrasenya,$this ->professor -> obtenir_contrasenya())){
                $this -> error = "Dades incorrectes";
                
            }
        }
    }
    
    
     private function variable_iniciada($variable) {
        if (isset($variable) && !empty($variable)) {

            return true;
        } else {
            return false;
        }
    }
    
    
    public function obtenir_professor(){
        return $this -> professor;
    }
    
     public function obtenir_error(){
        return $this -> error;
    }
    
     public function mostrar_error(){
       if( $this -> error !== ''){
           echo "<br><div class='alert alert-danger' role='alert'>";
           echo $this -> error;
           echo"</div><br>";
       }
    }
}



?>