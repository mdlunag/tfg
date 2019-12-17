<?php

class RepositoriGlobals{
    
  
 public static function afegir_global($conexio,$global){
     $global_afegit = false;
     
     if (isset($conexio)){
         
         try{
             $sql="INSERT INTO Globals(assignatura, tipus ,quadri,  professor, grups) VALUES(:assignatura,:tipus, :quadri,:professor,:grups)";
             $assignaturatemp =$global ->obtenir_assignatura();
             $tipustemp=$global -> obtenir_tipus();
             $quadritemp=$global-> obtenir_quadri();
             $professortemp=$global-> obtenir_professor();
             $grupstemp=$global ->obtenir_grups();
    
            
             
             $sentencia = $conexio -> prepare($sql);
             
             $sentencia -> bindParam('assignatura',$assignaturatemp, PDO::PARAM_STR);
             $sentencia -> bindParam('tipus',$tipustemp, PDO::PARAM_STR);
             $sentencia -> bindParam(':quadri',$quadritemp, PDO::PARAM_STR);
             $sentencia -> bindParam(':professor',$professortemp, PDO::PARAM_STR);
             $sentencia -> bindParam(':grups',$grupstemp, PDO::PARAM_STR);
            
          
             
             $global_afegit = $sentencia-> execute();
         } catch (PDOException $ex) {
             
             print 'ERROR' . $ex-> getMessage();

         }
         
     }
     
     return $global_afegit;
 }
  
}