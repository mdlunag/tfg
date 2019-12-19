<?php
include_once 'app/Conexio.inc.php';
include_once 'app/global.inc.php';
include_once 'app/RepositoriAssignatures.inc.php';
$titol = 'Principal';
Conexio::obrir_conexio();
$conexio = Conexio::obtenir_conexio();
$total_assign = RepositoriAssignatures:: obtenir_num_assigns(Conexio::obtenir_conexio());
Conexio :: tancar_conexio();
include_once 'plantilles/doc_declaracio.inc.php';
include_once 'plantilles/navbar.inc_1.php';
include_once 'app/config.inc.php';
include_once 'app/redireccio.inc.php';
include_once 'app/escollir_grups_1.inc.php';

?>

<div class='container'>
    <form method="post">
        <div class='col-lg-1'></div>
		<div class='col-lg-6'>
            <div class="table-responsive  "> 
                <h3>    Ocupació grups </h3>
<br>
                <table style="text-align:center" class="table ">

                    <thead> 
                        <tr style='font-size:12px'>
                            <!-- definimos cabeceras de la tabla --> 


                            <th style="border-bottom: 1px solid black; border-left-color: transparent; border-right-color:transparent"></th>

                            <th style="border-bottom: 1px solid black; border-left-color: transparent"></th>

                            <th style="text-align: center; width: 100px; border-top: 1px solid black; border-bottom:1px solid black; ">Grups coberts (usuari)</th>
							
							<th style="text-align: center;width: 100px;border-top: 1px solid black;border-bottom:1px solid black;"> Grups coberts (total) </th> 

                        </tr>


                        <?php
                        if (isset($conexio)) {

                            $sql = "SELECT ass.nom, ass.tipus, cast(cast(sum(gb.grups) as DECIMAL(3,2)) as float) as grups_coberts, ass.grups FROM Globals as gb

                        INNER JOIN Assignatures as ass on ass.nom = gb.assignatura and ass.tipus=gb.tipus

                        WHERE ass.quadri = 'Q1' or ass.quadri = 'tots'

                        GROUP BY ass.nom , ass.tipus
                        
                        ORDER BY ass.id ";
						
						
						$sql2="SELECT cast(cast(sum(gb.grups) as DECIMAL (3,2)) as float) as grups_propis FROM Globals as gb 
						 INNER JOIN Assignatures as ass on ass.nom = gb.assignatura and ass.tipus=gb.tipus
                        WHERE (gb.quadri='Q1' or gb.quadri='tots') AND gb.professor='".$_SESSION['nom']."' GROUP BY gb.assignatura, gb.tipus ORDER BY ass.id;";

                            $sentencia = $conexio->prepare($sql);
							$sentencia2=$conexio ->prepare($sql2);
                            $sentencia->execute();
							$sentencia2->execute();
                            $resultat = $sentencia->fetchAll();
							$resultat2=$sentencia2->fetchAll();
							$i=0;


                            foreach ($resultat as $fila) {
                                ?>
                                <tr>
                                    <td BGCOLOR="#C3EEF7" ><?php echo $fila['nom'] ?></td>
                                    <td BGCOLOR="#C3EEF7" ><?php echo $fila['tipus'] ?></td>
								<td BGCOLOR="#ffffff" style="width: 100px;"><?php echo $resultat2[$i]['grups_propis'] ?></td>
								<td BGCOLOR="#ffffff" style="width: 100px;"><?php echo $fila['grups_coberts'] . '/' . $fila['grups'] ?></td>
                                </tr> 

                                <?php
								$i++;
                            }
                        }
                        ?>

                    </thead>

                </table>

            </div>
        </div>

        <div class='col-lg-5'> 
            <br><br><br><br>
            <?php
if ($_SESSION['estat']!=0 && $_SESSION['admin']==0){
?>

<br><br><br>
            <div class='row'>
                <div class='col-lg-7' style='margin-left:10px'><label>   Assignatura</label></div>
                <div class='col-lg-3'><label>Grups</label></div>
                <div class='col-lg-5'></div>
            </div>


            <div class='row'>
                <div class='form-group col-lg-7' style='margin-left:10px'>

                    <select name='assignatura' class='form-control'>
                        <?php
                        $sql = "SELECT * FROM Assignatures WHERE Assignatures.quadri='Q1' or Assignatures.quadri='tots' ";

                        $sentencia = $conexio->prepare($sql);
                        $sentencia->execute();
                    $resultat = $sentencia->fetchAll();

                        foreach ($resultat as $fila) {
                            ?>

                            <option value="<?php echo $fila['nom'] . " " . $fila['tipus'] ?>"><?php echo $fila['nom'] . " " . $fila['tipus'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class='form-group col-lg-1'>
                    <label for="grups" class="sr-only">Grups</label>
                    <input name="grups" id="grups" class="form-control input_grups" placeholder="0" required autofocus style="width: 47px;"/>

                </div>
				<div class='col-lg-1'></div>
				
               <div class='col-lg-1'> <button class='btn btn-primary' type='submit' name='afegir'  >Afegir</button></div>
              
                

<?php } ?>

            </div>
        </div>

    </form>
</div>




<?php
include_once 'plantilles/doc_tancament.inc.php'
?>



