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

<nav class="navbar navbar-default navbar-fixed-top " role="navigation" >
<?php 
$link= $_SERVER['PHP_SELF'];
$link= '/'.explode('/',$link)[2];
if ($_SESSION['admin']==1){
    if($link=='/assign.php' or $link=='/professors.php' or $link=='/pujar_fitxer.php' or $link=='/editar_admin.php' or $link=='/nou_professor.php' or $link=='/editar_professors.php' or $link=='/editar_assignatures.php' ){
		if($link=='/assign.php' or $link=='/professors.php' or $link=='/pujar_fitxer.php' or $link=='/editar_admin.php' ){
		$redir=ADMINISTRADOR;}
		if ($link=='/nou_professor.php' or $link=='/editar_professors.php'){
			$redir=PROFESSORS;}
		if ($link=='/editar_assignatures.php'){
			$redir=ASSIGNATURES;}
			
?>
 <ul class="nav navbar-nav">
<li>
<a style='color:black; padding=0;' HREF="<?php echo $redir ?>" >
                    <span style='font-size:20px' class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span>
                </a></li> </ul>
				
				
	<?php
}}
?>
    <div class="container ">
        <div class="navbar-header ">

            <span class="navbar-brand" href="" style="font-size:14px">Eina per a la gestió de l'encàrrec docent</span>
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse" onclick="void(0)">
		
            <ul class="nav navbar-nav">
                <li class='<?php echo $inici?>'><a href="<?php echo INICI ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
                <li class="dropdown <?php echo $q1?>">
                    <a class="dropdown-toggle" aria-expanded="false" data-hover="dropdown" >  Q1  </a>
                    <ul class="dropdown-menu " role="menu">
                        <li ><a href="<?php echo OCUPACIO_Q1 ?>"> Ocupació grups</a></li>
                        <li>   <a  href="<?php echo Q1 ?>" > Distribució docent </a></li>
                    </ul>
                </li>
                <li class="dropdown <?php echo $q2?>">
                    <a class="dropdown-toggle" aria-expanded="false" data-hover="dropdown">  Q2  </a>
                    <ul class="dropdown-menu ">
                        <li><a href="<?php echo OCUPACIO_Q2 ?>"> Ocupació grups</a></li>
                        <li><a href="<?php echo Q2 ?>">Distribució docent</a></li>
                    </ul>
                </li>
				 <li class="<?php echo $general?>"><a href="<?php echo PRINCIPAL ?>">General</a></li>
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
                    <li><a href="">
                            <?php echo "Punts pendents: " . $punts_pendents ?></a>
                    </li>
                
                <li class="dropdown ">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>    <?php echo '' . $_SESSION['nom']; ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo DADES ?>"><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>     Dades personals</a></li>

         
		 <li><a href="<?php echo LOGOUT ?>"><span class="glyphicon glyphicon-off" aria-hidden="true"></span>     Tanca sessió</a></li></ul>
<?php
				}
if ($_SESSION['admin'] == "1") {
    ?>
 <li class="dropdown ">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>    <?php echo '' . $_SESSION['nom']; ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
        <li><a  href="<?php echo ADMINISTRADOR ?>"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Opcions administrador</a></li>
		 <li><a href="<?php echo LOGOUT ?>"><span class="glyphicon glyphicon-off" aria-hidden="true"></span>     Tanca sessió</a></li> </ul>  </li>
<?php }; ?>
                   

        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->

</nav>
