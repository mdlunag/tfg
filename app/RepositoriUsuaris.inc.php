<?php

class RepositoriUsuaris{
    
 public static function obtenir_tots($conexio){
     
     $usuaris = array();
     
     if (isset($conexio)){
         
         try{
             include_once "usuari.inc.php";
             
             $sql = "SELECT * FROM profes ";
             
             $sentencia = $conexio -> prepare($sql);
             $sentencia -> execute();
             $resultat = $sentencia -> fetchAll();  
             
             if (count($resultat)){
              
                 foreach($resultat as $fila){
                     $usuaris[] =new Usuari(
                             $fila['id'],$fila['nom'],$fila['cognoms'],$fila['email'],$fila['punts'],$fila['contra'],$fila['Dataregistre'],$fila['actiu']
                             );
                    }
             } else{
                 
                 print "No hi ha usuaris";
             }
          
             
         } catch (PDOException $ex) {
             print 'ERROR' .$ex ->getMessage();

         }
     }
     return $usuaris;
 }   
 public static function obtenir_num_usuaris($conexio){
  $total_usuaris=null;
  
  if (isset($conexio)){
      try{
        $sql = "SELECT COUNT(*)as total from profes";
        $sentencia = $conexio -> prepare($sql);
        $sentencia ->execute();
        $resultat = $sentencia -> fetch();
        
        $total_usuaris=$resultat['total'];
         
      } catch (Exception $ex) {
          print "ERROR" .$ex -> getMessage();

      }
  return $total_usuaris;
 }
     
     
 }
 
   
 
 public static function afegir_profe($conexio,$usuari){
     $usuari_afegit = false;
     
     if (isset($conexio)){
         
         try{
             $sql="INSERT INTO profes(nom, cognoms, email, punts, contra, Dataregistre, actiu) VALUES(:nom, :cognoms,:email,:punts, :contra,NOW(),1)";
             $nomtemp =$usuari ->obtenir_nom();
             $cognomstemp=$usuari-> obtenir_cognoms();
             $emailtemp=$usuari ->obtenir_email();
             $puntstemp=$usuari -> obtenir_punts();
             $contratemp=$usuari->obtenir_contra();
             
             $sentencia = $conexio -> prepare($sql);
             
             $sentencia -> bindParam(':nom',$nomtemp, PDO::PARAM_STR);
             $sentencia -> bindParam(':cognoms',$cognomstemp, PDO::PARAM_STR);
             $sentencia -> bindParam(':email',$emailtemp, PDO::PARAM_STR);
             $sentencia -> bindParam(':punts',$puntstemp, PDO::PARAM_STR);
             $sentencia -> bindParam(':contra',$contratemp , PDO::PARAM_STR);
             
             $usuari_afegit = $sentencia-> execute();
         } catch (PDOException $ex) {
             
             print 'ERROR' . $ex-> getMessage();

         }
         
     }
     
     return $usuari_afegit;
 }
  
}