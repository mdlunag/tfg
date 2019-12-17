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
                  
                        Conexio :: obrir_conexio();

                       
                            $usuari = new Professor(0, $_POST['nom'],'', $_POST['email'], 0, '', '', rtrim($_POST['contra']), '', '', '');
                            $usuari_modificat = RepositoriProfessors :: modificar_professor(Conexio :: obtenir_conexio(), $usuari);

                            if ($usuari_modificat) {
                                echo 'Administrador modificat correctament!';
                            }
                        
                    
               
                    ?>
                <br><br><br><button formaction="<?php echo PROFESSORS?>" class="btn btn-lg btn-primary btn-block" type="submit" >Torna</button>
                </center>
                <?php

                    Conexio :: tancar_conexio();
                } else {
                   
                        $sql = "SELECT * FROM Professors WHERE id = 0";
                        $sentencia = $conexio->prepare($sql);
                        $sentencia->execute();
                        $resultat = $sentencia->fetch();
                        ?>
                         <center>Editar admin</center> 
                      
                        <label for="inputNom" class="sr-only">Nom</label>
                        <input name='nom'  id="inputNom" class="form-control" placeholder="Nom" value="<?php echo $resultat['nom'] ?>" required autofocus>
                        <label for="inputEmail" class="sr-only">Adreça electrònica</label>
                        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Adreça electrònica" value="<?php echo $resultat['email'] ?>" required autofocus>
                        <label for="inputPassword" class="sr-only">Contrasenya</label>
                        <input  name='contra' id="inputPassword" class="form-control" placeholder="Contrasenya"  value="<?php echo $resultat['contrasenya'] ?>" required>
                        <br>
                <br><button class="btn btn-lg btn-primary btn-block" type="submit" name="enviar">Edita</button>

                           <?php
    }

?>
            </form>


        </div>
        <div classe="col-md-4"> </div>

    </div>

</div> <!-- /container -->


<?php
include_once 'plantilles/doc_tancament.inc.php'
?>