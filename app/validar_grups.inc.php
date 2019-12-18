<?php

if (isset($_POST['validar'])) {
    if (session_id() == '') {
        session_start();
    }

    $sql = 'UPDATE Professors SET estat=2 WHERE id=' . $_SESSION['id'];
    $sentencia = $conexio->prepare($sql);
    $sentencia->execute();

    $query = "Select Max(id) FROM Professors";
    $sentencia0 = $conexio->prepare($query);
    $sentencia0->execute();
    $resultat = $sentencia0->fetch();
    $valor_max = $resultat[0];
   
    if ($_SESSION['id']!=$valor_max){
        
    
        $id_seguent = intval($_SESSION['id']) + 1;
    $sql2 = 'SELECT nom, cognoms, email FROM Professors WHERE id=' . $id_seguent;
    $sentencia2 = $conexio->prepare($sql2);
    $sentencia2->execute();
    $resultat = $sentencia2->fetch();
    $nom_envia = $resultat[0] . ' ' . $resultat[1];
    $email_envia = $resultat[2];
    $sql3 = 'UPDATE Professors SET estat=1 WHERE id=' . $id_seguent;
    $sentencia3 = $conexio->prepare($sql3);
    $sentencia3->execute();
     include_once 'app/enviar_mail.inc.php';
    } else{
        echo "<script>window.alert('Validat!')</script>";
    }
      $_SESSION['estat'] = 2;
   
   
}
?>