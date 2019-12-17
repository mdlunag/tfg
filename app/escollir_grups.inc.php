<?php
if (isset($_POST['afegir'])) {

    $assign = explode(' ', $_POST['assignatura']);
    $nom_assign = $assign[0];
    $tipus_assign = $assign[1];
    $grups = floatval($_POST['grups']);
    $profe = $_SESSION['nom'];
    
    
    $sql0="SELECT grups FROM Globals WHERE (assignatura='" . $nom_assign . "'AND professor='" . $profe . "' AND tipus='" . $tipus_assign . "' AND quadri='Q1')"
            . "OR (assignatura='" . $nom_assign . "'AND professor='" . $profe . "' AND tipus='" . $tipus_assign . "' AND quadri='tots' ) ";
    $sentencia0=$conexio->prepare($sql0);
    $sentencia0->execute();
    $grups_abans=$sentencia0->fetch()[0];
    
    
    $sql = "SELECT grups, credits FROM Assignatures WHERE (nom= '" . $nom_assign . "'AND tipus='" . $tipus_assign . "' AND quadri='Q1')"
                        . "OR (nom='" . $nom_assign . "' AND tipus='" . $tipus_assign . "' AND quadri='tots' ) ";
    $sentencia = $conexio->prepare($sql);
    $sentencia->execute();
    $result = $sentencia->fetch();
    $grups_total=floatval($result[0]);
    $credits=floatval($result[1]);
   
    $punts_coberts = $credits * 3 *($grups-$grups_abans);
    
    $sql00="SELECT sum(grups) as grups_coberts FROM Globals WHERE (assignatura='" . $nom_assign . "' AND tipus='" . $tipus_assign . "' AND quadri='Q1')"
            . "OR (assignatura='" . $nom_assign . "' AND tipus='" . $tipus_assign . "' AND quadri='tots' ) ";
    $sentencia00=$conexio->prepare($sql00);
    $sentencia00->execute();
    $grups_coberts=$sentencia00->fetch()[0];
    
    if($grups_coberts+$grups>$grups_total||$punts_coberts>$punts_pendents){
        if($grups_coberts+$grups>$grups_total){
        echo "<div class='alert alert-danger alert-dismissible erroni' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><center>No pots afegir més grups dels que queden disponibles. Prova-ho de nou amb un altre nombre.</center></div>";
        }
        if ($punts_coberts>$punts_pendents){
                   echo "<div class='alert alert-danger alert-dismissible erroni' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><center>Siagafes aquests grups superes es PADs contractats.</center></div>";
 
        }
        
        } else{
            
            
    
    
    
    $sql1 = "UPDATE Globals SET grups=" . $grups . " WHERE (assignatura='" . $nom_assign . "'AND professor='" . $profe . "' AND tipus='" . $tipus_assign . "' AND quadri='Q1')"
            . "OR (assignatura='" . $nom_assign . "'AND professor='" . $profe . "' AND tipus='" . $tipus_assign . "' AND quadri='tots' ) ";
    $sentencia1 = $conexio->prepare($sql1);
    $sentencia1->execute();
    
    $id= $_SESSION['id'];
    $sql2 = "UPDATE Professors SET cobert_Q1= cobert_Q1+" . $punts_coberts . " WHERE id=".$id;
    $sentencia2 = $conexio->prepare($sql2);
    $sentencia2->execute();
    Redireccio::redirigir(OCUPACIO_Q1);
    }
}

?>