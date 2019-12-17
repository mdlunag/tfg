<?php
if (isset($_POST['estat'])){
    $valors=explode(' ',$_POST['estat']);
    $id=$valors[0];
   
    $estat_nou=$valors[1];
    
    $sql='UPDATE Professors SET estat='.$estat_nou.' WHERE id='.$id;
    $sentencia=$conexio->prepare($sql);
    $sentencia->execute();
}
?>
