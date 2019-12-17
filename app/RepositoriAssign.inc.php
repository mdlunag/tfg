<?php

class RepositoriAssign{
    
 public static function obtenir_tots($conexio){
     
     $assigns= array();
     
     if (isset($conexio)){
         
         try{
             include_once "assign.inc.php";
             
             $sql = "SELECT * FROM assignatures ";
             
             $sentencia = $conexio -> prepare($sql);
             $sentencia -> execute();
             $resultat = $sentencia -> fetchAll();  
             
             if (count($resultat)){
              
                 foreach($resultat as $fila){
                     $assigns[] =new Assign(
                             $fila['id'],$fila['nom'],$fila['tipus'],$fila['credits'],$fila['grups']
                             );
                    }
             } else{
                 
                 print "No hi ha usuaris";
             }
          
             
         } catch (PDOException $ex) {
             print 'ERROR' .$ex ->getMessage();

         }
     }
     return $assigns;
     
     
 }   
 public static function obtenir_num_assigns($conexio){
  $total_assign=null;
  
  if (isset($conexio)){
      try{
        $sql = "SELECT COUNT(*)as total from assignatures";
        $sentencia = $conexio -> prepare($sql);
        $sentencia ->execute();
        $resultat = $sentencia -> fetch();
        
        $total_assign=$resultat['total'];
         
      } catch (Exception $ex) {
          print "ERROR" .$ex -> getMessage();

      }
  return $total_assign;
 }
     
     
 }
 
   
 
 public static function afegir_assign($conexio,$assign){
     $assign_afegida = false;
     
     if (isset($conexio)){
         
         try{
             $sql="INSERT INTO assignatures(nom, tipus, credits, grups) VALUES(:nom, :tipus,:credits,:grups)";
             $nomtemp =$assign ->obtenir_nom();
             $creditstemp=$assign-> obtenir_credits();
             $tipustemp=$assign ->obtenir_tipus();
             $grupstemp=$assign -> obtenir_grups();
             
             
             $sentencia = $conexio -> prepare($sql);
             
             $sentencia -> bindParam(':nom',$nomtemp, PDO::PARAM_STR);
             $sentencia -> bindParam(':tipus',$tipustemp, PDO::PARAM_STR);
             $sentencia -> bindParam(':credits',$creditstemp, PDO::PARAM_STR);
             $sentencia -> bindParam(':grups',$grupstemp, PDO::PARAM_STR);
             
             
             $assign_afegida = $sentencia-> execute();
         } catch (PDOException $ex) {
             
             print 'ERROR' . $ex-> getMessage();

         }
         
     }
     
     return $assign_afegida;
 }
  
}