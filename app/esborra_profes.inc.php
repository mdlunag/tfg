<?php

if (isset($_REQUEST['esborra'])) {
    $chekes = $_REQUEST["check"];
    for ($x = 0; $x < count($chekes); $x++) {
        Conexio::obrir_conexio();
        $conexio = Conexio::obtenir_conexio();
        $sql1 = "SELECT nom,cognoms FROM Professors WHERE Professors.id=$chekes[$x]";
        $sql = "DELETE FROM Professors WHERE Professors.id = $chekes[$x]  ";
        $sentencia1 = $conexio->prepare($sql1);
        $sentencia = $conexio->prepare($sql);
        $sentencia1->execute();
        $sentencia->execute();
        

        foreach ($sentencia1 as $fila) {
            $professor = $fila['nom'] . " " . $fila['cognoms'];
            $sql2 = "DELETE FROM Globals WHERE Globals.Professor='$professor'";
            $sentencia2 = $conexio->prepare($sql2);
            $sentencia2->execute();
        }
    }
    $total_usuaris = RepositoriProfessors :: obtenir_num_professors(Conexio::obtenir_conexio());
    $tots_profes = RepositoriProfessors::obtenir_tots($conexio);
    $y = 1;
    foreach ($tots_profes as $professor) {
        $professor->id = $y;
        RepositoriProfessors::modificar_id($conexio, $professor);
        $y++;
    }
    Conexio :: tancar_conexio();
}
?>