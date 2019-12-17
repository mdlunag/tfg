<?php
include_once 'app/Conexio.inc.php';
include_once 'app/RepositoriProfessors.inc.php';
include_once 'app/professor.inc.php';
include_once 'app/config.inc.php';
include_once 'app/control_sessio.inc.php';
include_once 'app/Nou_profe.inc.php';
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
                   $nombre_profes=$_POST['nombre_profes'];
                    $modificats = 0;
                    for ($x = 0; $x < $nombre_profes; $x++) {
                        Conexio :: obrir_conexio();

                        $validador = new ValidaCredencials($_POST['nom'.$x], $_POST['cognoms'.$x], $_POST['email'.$x], $_POST['punts'.$x], $_POST['contra'.$x]);
                        if ($validador->registre_valid()) {
                            $usuari = new Professor($_POST['id'.$x], $validador->obtenir_nom(), $validador->obtenir_cognoms(), $validador->obtenir_email(), $validador->obtenir_punts(), '', '', $validador->obtenir_contra(), '', '', '');
                            $usuari_modificat = RepositoriProfessors :: modificar_professor(Conexio :: obtenir_conexio(), $usuari);

                            if ($usuari_modificat) {
                                $modificats ++;
                            }
                        }
                    }
                 
                    echo "<br><br><center>". $modificats . ' usuari(s) modificat(s) correctament!';
                    ?>
                <br><br><br><button formaction="<?php echo PROFESSORS?>" class="btn btn-lg btn-primary btn-block" type="submit" >Torna</button>
                </center>
                <?php

                    Conexio :: tancar_conexio();
                } else {
                    if(empty($_POST)){
                        ?>
                        <?php
                    echo "<center><br>Has de seleccionar algun professor!<br>";
                    ?>
                <br><br><br><button formaction="<?php echo PROFESSORS?>" class="btn btn-lg btn-primary btn-block" type="submit" >Torna</button>
                </center>
                <?php
                         
                    }else{
                    $checkes = $_POST["check"];
                    $nombre_profes=count($checkes);
                   
?>
                    <center>Editar professor</center> 
                     <?php
                    for ($x = 0; $x < $nombre_profes; $x++) {


                        $id = $checkes[$x];
                        $sql = "SELECT * FROM Professors WHERE id = $id";
                        $sentencia = $conexio->prepare($sql);
                        $sentencia->execute();
                        $resultat = $sentencia->fetch();
                        ?>
                        
                        <input type="hidden" name="<?php echo 'id' . $x ?>" value="<?php echo $id ?>" />
                        <label for="inputNom" class="sr-only">Nom</label>
                        <input name="<?php echo 'nom' . $x ?>" id="inputNom" class="form-control" placeholder="Nom" value="<?php echo $resultat['nom'] ?>" required autofocus>
                        <label for="inputCognom" class="sr-only">Cognoms</label>
                        <input name="<?php echo 'cognoms' . $x ?>" id="inputNom" class="form-control" placeholder="Cognoms" value="<?php echo $resultat['cognoms'] ?>" required autofocus>
                        <label for="inputEmail" class="sr-only">Adreça electrònica</label>
                        <input type="email" name="<?php echo 'email' . $x ?>" id="inputEmail" class="form-control" placeholder="Adreça electrònica" value="<?php echo $resultat['email'] ?>" required autofocus>
                        <label for="inputPunts" class="sr-only">Punts</label>
                        <input name="<?php echo 'punts' . $x ?>" type="number" id="inputPunts" class="form-control" placeholder="Punts" value="<?php echo $resultat['punts'] ?>" required autofocus>
                        <label for="inputPassword" class="sr-only">Contrasenya</label>
                        <input  name="<?php echo 'contra' . $x ?>" id="inputPassword" class="form-control" placeholder="Contrasenya"  value="<?php echo $resultat['contrasenya'] ?>" required>
                        <br>
                            <?php
                    }

?>
                <input type="hidden" name="nombre_profes" value="<?php echo $nombre_profes ?>" />
  
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