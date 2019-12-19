<?php
include_once 'app/config.inc.php';
include_once 'app/control_sessio.inc.php';
if (session_id() == '') {
    session_start();
}
include_once 'app/Conexio.inc.php';
Conexio::obrir_conexio();
$conexio = Conexio::obtenir_conexio();
Conexio :: tancar_conexio();
$id_profe =  $_SESSION['id'];
$sql = "SELECT punts, cobert_Q1, cobert_Q2 FROM Professors WHERE id=".$id_profe;
$sentencia = $conexio->prepare($sql);
$sentencia->execute();
$resultat = $sentencia->fetch();
$punts_pendents = $resultat[0] - $resultat[1] - $resultat[2];
include_once 'app/validar_grups.inc.php';
?>

<nav class="navbar navbar-default navbar-fixed-top "  >
    <div class="container">
        <div class="navbar-header">

            <a class="navbar-brand" href="<?php echo PRINCIPAL ?>">Eina per a la gestió de l'encàrrec docent</a>

        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo PRINCIPAL ?>">General</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle"  data-hover="dropdown" aria-expanded='false'>  Q1  </a>
                    <ul class="dropdown-menu ">
                        <li ><a href="<?php echo OCUPACIO_Q1 ?>"> Ocupació grups</a></li>
                        <li>   <a  href="<?php echo Q1 ?>" > Distribució docent </a></li>
                    </ul>
                </li>
                <li class="dropdown active">
                    <a href="#" class="dropdown-toggle"  data-hover="dropdown" aria-expanded='false'>  Q2  </a>
                    <ul class="dropdown-menu ">
                        <li><a href="<?php echo OCUPACIO_Q2 ?>"> Ocupació grups</a></li>
                        <li><a href="<?php echo Q2 ?>">Distribució docent</a></li>
                    </ul>
                </li>
                                  <?php
                if ($_SESSION['admin'] == "0" && $_SESSION['estat']==1) {
                    ?>
                <ul class='nav navbar-nav navbar-validar'><form class='selection' method="post"><button type='submit'name='validar' class='btn validar btn-xs btn-primary'>Validar</button></form></ul>
                <?php } ?>
                


            </ul>
            

            <ul class='nav navbar-nav navbar-right'>

                                <?php
                if ($_SESSION['admin'] == "0") {
                    ?>
                    <li><a href="#">
                            <?php echo "Punts pendents: " . $punts_pendents ?></a>
                    </li>
                    <?php
                }
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>    <?php echo '' . $_SESSION['nom']; ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>     Propietats</a></li>

                        <li><a href="<?php echo LOGOUT ?>"><span class="glyphicon glyphicon-off" aria-hidden="true"></span>     Tanca sessió</a></li>
<?php
if ($_SESSION['admin'] == "1") {
    ?>

                            <li><a  href="<?php echo ADMINISTRADOR ?>">Opcions administrador</a></li>

<?php }; ?>


                    </ul>

                </li>
            </ul


        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->

</nav>