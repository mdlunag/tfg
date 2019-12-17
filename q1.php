
<?php
include_once 'app/Conexio.inc.php';
include_once 'app/RepositoriAssignatures.inc.php';
$titol = 'Principal';
Conexio::obrir_conexio();
$conexio = Conexio::obtenir_conexio();
$total_professors = RepositoriProfessors:: obtenir_num_professors(Conexio::obtenir_conexio());
Conexio :: tancar_conexio();
include_once 'plantilles/doc_declaracio.inc.php';
include_once 'plantilles/navbar.inc_1.php';

?>




<div class='container'>
    <h2>Ocupació grups</h2>



    <div class="table-responsive  "> 


        <table style="text-align:center" class="table">

            <thead> 

           
            <td style=' border-left-color: transparent; '></td>

            <?php
            if (isset($conexio)) {

                $sql = "SELECT * FROM Professors WHERE admin=0 ";

                $sentencia = $conexio->prepare($sql);
                $sentencia->execute();
                $resultat = $sentencia->fetchAll();


                foreach ($resultat as $fila) {
                    $sigles_nom = explode(" ", $fila['nom']);
                    $sigles_cognom = explode(" ", $fila['cognoms']);
                    $sigles_tot = array_merge($sigles_nom, $sigles_cognom);
                    $profe = '';
                    foreach ($sigles_tot as $paraula) {
                        $profe = $profe . $paraula[0];
                    }
                    ?>

                    <td style="border-top: 1px solid black;width: 55px; " BGCOLOR="#c2e5d2"; font-size:12px' WIDTH="25" title="<?php echo $fila['nom'] . " " . $fila['cognoms'] ?>"><?php echo $profe ?></td>



                    <?php
                }
            }
            ?>




            <?php
            if (isset($conexio)) {

                $sql3 = "SELECT * FROM Assignatures WHERE Assignatures.quadri='Q1' or Assignatures.quadri='tots' ";

                $sentencia3 = $conexio->prepare($sql3);
                $sentencia3->execute();
                $resultat3 = $sentencia3->fetchAll();

                foreach ($resultat3 as $fila3) {

                    $sql2 = "SELECT professor, assignatura, tipus, quadri, cast(cast(grups as DECIMAL(3,2)) as float) as grups FROM Globals WHERE Globals.quadri='Q1' or Globals.quadri='tots'";

                    $sentencia2 = $conexio->prepare($sql2);
                    $sentencia2->execute();
                    $resultat2 = $sentencia2->fetchAll();
                    ?>
                    <tr> <td WIDTH="200"><?php echo $fila3['nom']." ".$fila3['tipus'] ?></td>
                        <?php
                        foreach ($resultat2 as $fila2) {

                            if ($fila3['nom'] == $fila2['assignatura'] && $fila3['tipus'] == $fila2['tipus']) {
                                ?>  

                                <td WIDTH="25" BGCOLOR="#ffffff"><?php echo $fila2['grups'] ?></td>

                                <?php
                            }
                        }
                    }
                }
                ?>
            </tr>
            </thead>


        </table>

    </div>
</div>

<?php
include_once 'plantilles/doc_tancament.inc.php'
?>
