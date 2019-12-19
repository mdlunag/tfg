<?php

if (isset($_POST['ordre'])) {
    $ids = explode(' ', $_POST['ordre']);
    $nou_id = $ids[1];
    $id = $ids[0];
    $sql = "SELECT * FROM Professors WHERE id=" . $id;
    $sentencia = $conexio->prepare($sql);
    $sentencia->execute();
    $p = $sentencia->fetch();
    if ($p['id']==1 && $p['estat']==1){
        $p['estat']=0;
    }
    $sql1 = "DELETE FROM Professors WHERE id=" . $id;
    $sentencia1 = $conexio->prepare($sql1);
    $sentencia1->execute();

    if ($id > $nou_id) {


        for ($o = $id - 1; $o >= $nou_id; $o--) {
            RepositoriProfessors::modificar_id($conexio, intval($o) + 1, $o);
        
        }
        RepositoriProfessors::afegir_professor_id_canviat($conexio, $p, intval($nou_id));
    } elseif ($id < $nou_id) {
        for ($o = $id; $o <= $nou_id - 1; $o++) {
            RepositoriProfessors::modificar_id($conexio, $o, intval($o)+ 1);
            
        }
        RepositoriProfessors::afegir_professor_id_canviat($conexio, $p, intval($nou_id));
    }
    
}
?>