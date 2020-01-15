<?php
include_once 'app/Conexio.inc.php';
include_once 'app/RepositoriProfessors.inc.php';
include_once 'app/professor.inc.php';
include_once 'app/Nou_profe.inc.php';
include_once 'app/RepositoriGlobals.inc.php';
include_once 'plantilles/navbar.inc.php';
include_once 'app/redireccio.inc.php';
include_once 'app/config.inc.php';
$titol = 'Nou professor';
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
                    $validador = new ValidaCredencials($_POST['nom'], $_POST['cognoms'], $_POST['email'], $_POST['punts'], $_POST['contra']);

                    include_once 'plantilles/credencials_validat.inc.php';

                    if ($validador->registre_valid()) {
                        $usuari = new Professor('', $validador->obtenir_nom(), $validador->obtenir_cognoms(), $validador->obtenir_email(), $validador->obtenir_punts(), '', '', password_hash($validador->obtenir_contra(), PASSWORD_DEFAULT), '', '');
                        $usuari_afegit = RepositoriProfessors :: afegir_professor(Conexio :: obtenir_conexio(), $usuari, $total_usuaris);

                        if ($usuari_afegit) {
                           ?>
							
                               <script> location.href= "<?php echo PROFESSORS ?>" </script>
							
								<?php
                        }
                    }

                    Conexio :: tancar_conexio();
                } else {
                    include_once 'plantilles/credencials_buit.inc.php';
                }
                ?>
                <br><button class="btn btn-lg btn-primary btn-block" type="submit" name="enviar">Crea</button>

                <div class:>Nota: el professor es posarà per defecte l'últim en l'ordre de prioritat</div>
            </form>


        </div>
        <div classe="col-md-4"> </div>



    </div>

</div> <!-- /container -->


<?php
include_once 'plantilles/doc_tancament.inc.php'
?>