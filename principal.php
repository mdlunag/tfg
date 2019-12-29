
<?php
include_once 'app/Conexio.inc.php';
include_once 'app/RepositoriAssignatures.inc.php';
$titol = 'Principal';
Conexio::obrir_conexio();
$conexio = Conexio::obtenir_conexio();
$total_assign = RepositoriAssignatures:: obtenir_num_assigns(Conexio::obtenir_conexio());
Conexio :: tancar_conexio();
include_once 'plantilles/doc_declaracio.inc.php';
$general='active';
include_once 'plantilles/navbar.inc.php';
if (session_id() == '') {
    session_start();
}
?>


<div class='container'>
    <h3>Ocupació grups</h3>
  <p>
   <?php include_once 'app/php_excel.php'; ?>
    <a class="btn btn-default btn-primary" href="<?php echo EXCEL ?>" download="excel_emplenat">Exportar a Excel</a>
  
</p>

<form action="excel.php" method="post" target="_blank" id="formExport">
    <input type="hidden" id="data_to_send" name="data_to_send" />
</form>

	   



    <div class="table-responsive "> 

        <table style="text-align:center" class="table" id="export_to_excel">

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

                    <td style="border-top: 1px solid black; font-weight:bold; width: 55px; " BGCOLOR="#FFFF98"   title="<?php echo $fila['nom'] . " " . $fila['cognoms'] ?>"><?php echo $profe ?></td>
                    
                    <?php
                }
            }
            ?>

            <?php
            if (isset($conexio)) {

                $sql3 = "SELECT * FROM Assignatures ";

                $sentencia3 = $conexio->prepare($sql3);
                $sentencia3->execute();
                $resultat3 = $sentencia3->fetchAll();

                foreach ($resultat3 as $fila3) {

                    $sql2 = "SELECT professor, assignatura, tipus, quadri, cast(cast(grups as DECIMAL(3,2)) as float) as grups FROM Globals ";

                    $sentencia2 = $conexio->prepare($sql2);
                    $sentencia2->execute();
                    $resultat2 = $sentencia2->fetchAll();
                    ?>
                    <tr> <td BGCOLOR="#C3EEF7" ><?php echo $fila3['nom'] . " " . $fila3['tipus'] . " " . $fila3['quadri'] ?></td>
                        <?php
                        foreach ($resultat2 as $fila2) {

                            if ($fila3['nom'] == $fila2['assignatura'] && $fila3['tipus'] == $fila2['tipus']) {
                                ?>  

                                <td BGCOLOR="#ffffff" style='width: 50px;'><?php echo $fila2['grups'] ?></td>

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
