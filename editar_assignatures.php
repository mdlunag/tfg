<?php
include_once 'app/Conexio.inc.php';
include_once 'app/assignatura.inc.php';

include_once 'app/RepositoriAssignatures.inc.php';
include_once 'app/professor.inc.php';
include_once 'app/config.inc.php';
include_once 'app/control_sessio.inc.php';
include_once 'app/RepositoriGlobals.inc.php';
include_once 'plantilles/navbar.inc.php';
include_once 'app/redireccio.inc.php';
$titol = 'Editar professor';
include_once'plantilles/doc_declaracio.inc.php';
Conexio::obrir_conexio();
$total_usuaris = RepositoriProfessors :: obtenir_num_professors(Conexio::obtenir_conexio());
$conexio = Conexio::obtenir_conexio();
Conexio :: tancar_conexio();
?>

<div class="container">
    <br>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form role="form" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                <?php
                
                
                if (isset($_POST['enviar'])) {
                   $nombre_assigns=$_POST['nombre_assigns'];
                    $modificats = 0;
                    for ($x = 0; $x < $nombre_assigns; $x++) {
                        Conexio :: obrir_conexio();

                        $usuari = new Assignatura($_POST['id'.$x],$_POST['nom'.$x], $_POST['tipus'.$x], $_POST['punts'.$x]/3, $_POST['grups'.$x], $_POST['quadri'.$x]);
              
                            $usuari_modificat = RepositoriAssignatures :: modificar_assignatura(Conexio :: obtenir_conexio(), $usuari);

                            if ($usuari_modificat) {
                                $modificats ++;
                            }
                        }
                    
                 
                    echo "<br><br><center>". $modificats . ' assignatura/es modificada/es correctament!';
                    ?>
                <br><br><br><button formaction="<?php echo ASSIGNATURES?>" class="btn btn-lg btn-primary btn-block" type="submit" >Torna</button>
                </center>
                <?php

                    Conexio :: tancar_conexio();
                } else {
                    if(empty($_POST)){
                        ?>
                        <?php
                    echo "<center><br>Has de seleccionar alguna assignatura!<br>";
                    ?>
                <br><br><br><button formaction="<?php echo ASSIGNATURES?>" class="btn btn-lg btn-primary btn-block" type="submit" >Torna</button>
                </center>
                <?php
                         
                    }else{
                    $checkes = $_POST["check"];
                    $nombre_assigns=count($checkes);
                   
?>
                    <center>Editar assignatura</center> 
                     <?php
                    for ($x = 0; $x < $nombre_assigns; $x++) {


                        $id = $checkes[$x];
                        $sql = "SELECT * FROM Assignatures WHERE id = $id";
                        $sentencia = $conexio->prepare($sql);
                        $sentencia->execute();
                        $resultat = $sentencia->fetch();
                        ?>
                        
                        <input type="hidden" name="<?php echo 'id' . $x ?>" value="<?php echo $id ?>" />
                        <label for="inputNom" class="sr-only">Nom</label>
                        <input name="<?php echo 'nom' . $x ?>" id="inputNom" class="form-control" placeholder="Nom" value="<?php echo $resultat['nom'] ?>" required autofocus>
                        <label for="inputTipus" class="sr-only">Tipus</label>
                        <input name="<?php echo 'tipus' . $x ?>" id="inputTipus" class="form-control" placeholder="Tipus" value="<?php echo $resultat['tipus'] ?>" required autofocus>
                        <label for="inputPunts" class="sr-only">Punts</label>
                        <input name="<?php echo 'punts' . $x ?>"  class="form-control" id="inputPunts" placeholder="Punts" value="<?php echo $resultat['credits']*3 ?>" required autofocus>
                        <label for="inputGrups" class="sr-only">Grups</label>
                        <input name="<?php echo 'grups' . $x ?>" type="number" id="inputGrups" class="form-control" placeholder="Grups" value="<?php echo $resultat['grups'] ?>" required autofocus>
                        <label for="inputQuadri" class="sr-only">Quadri</label>
                        <input  name="<?php echo 'quadri' . $x ?>" id="inputQuadri" class="form-control" placeholder="Quadrimestre"  value="<?php echo $resultat['quadri'] ?>" required>
                        <br>
                            <?php
                    }

?>
                <input type="hidden" name="nombre_assigns" value="<?php echo $nombre_assigns ?>" />
  
                <br><button class="btn btn-lg btn-primary btn-block" type="submit" name="enviar">Edita</button>
<?php
                }}
?>

            </form>


        </div>
        <div classe="col-md-4"> </div>

    </div>

</div> <!-- /container -->


<?php
include_once 'plantilles/doc_tancament.inc.php'
?>