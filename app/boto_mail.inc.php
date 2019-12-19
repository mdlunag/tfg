<?php
if (isset($_POST['envia'])){
$id_=$_POST['envia'];
$sql_='SELECT nom,email FROM Professors WHERE id='.$id_;
$sentencia_=$conexio->prepare($sql_);
$sentencia_->execute();

$dades=$sentencia_->fetch();
$nom_envia=$dades[0];
$email_envia=$dades[1];
include_once 'app/enviar_mail.inc.php';
}
?>

