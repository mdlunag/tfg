<?php 
class ControlSessio {
    
    public static function iniciar_sessio($id, $nom, $estat, $admin){
        if (session_id() == ''){
            session_start();
        }
        $_SESSION['id'] = $id;
        $_SESSION['nom'] = $nom;
        $_SESSION['estat']=$estat;
         $_SESSION['admin'] = $admin;
    
    }
    
    public static function tancar_sessio(){
        if (session_id()==''){
            session_start();
        }
        if (isset($_SESSION['id'])){
            unset($_SESSION['id']);
            
        }
        
          if (isset($_SESSION['nom'])){
            unset($_SESSION['nom']);
            
        }
        
          if (isset($_SESSION['admin'])){
            unset($_SESSION['admin']);
            
        }
        session_destroy();
        
    }
    
    public static function sessio_iniciada(){
        if (session_id()==''){
            session_start();
        }
        if (isset($_SESSION['id']) && isset($_SESSION['nom']) && isset($_SESSION['admin'])){
            return true;
        }else{
            return false;
        }
    }
}