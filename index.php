<?php
include_once 'app/config.inc.php';
include_once 'app/Conexio.inc.php';
include_once 'app/redireccio.inc.php';
include_once 'app/RepositoriProfessors.inc.php';
include_once 'app/validador_login.inc.php';
include_once 'app/control_sessio.inc.php';
$titol = 'Inicia sessió';
if (ControlSessio::sessio_iniciada()){
    Redireccio::redirigir(INICI);
}
if (isset($_POST['login'])) {
    Conexio::obrir_conexio();
    $validador = new ValidadorLogin($_POST['email'], $_POST['contra'], Conexio::obtenir_conexio());
    if ($validador->obtenir_error() == '' && !is_null($validador->obtenir_professor())) {
        ControlSessio::iniciar_sessio( $validador -> obtenir_professor() -> obtenir_id(),
                $validador -> obtenir_professor()-> obtenir_nom_complet(), $validador -> obtenir_professor()-> estat(),
                $validador -> obtenir_professor()-> admin());
      Redireccio::redirigir(SERVIDOR);
    }

    Conexio :: tancar_conexio();
}


include_once'plantilles/doc_declaracio.inc.php'
?>

<div class="container"><center>
    <form class="form-signin" role='form' method='post' action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <h2 class="form-signin-heading">Inicia sessió</h2>
        <label for="email" class="sr-only">Adreça electrònica</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Adreça electrònica" 
        <?php
        if (isset($_POST['login']) && isset($_POST['email']) && !empty($_POST['email'])) {
            echo 'value="' . $_POST['email'] . '"';
        }
        ?>
               required autofocus>
        <label for="contra" class="sr-only">Contrasenya</label>
        <input type="password" name="contra" id="contra" class="form-control" placeholder="Contrasenya" required>

        <?php
        if (isset($_POST['login'])) {
            $validador->mostrar_error();
        }
        ?>

        
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Entra</button>

            
    </form>
</center></div> 



<?php
include_once 'plantilles/doc_tancament.inc.php'
?>