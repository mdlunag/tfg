
<?php
include_once 'app/Conexio.inc.php';
$titol = 'Principal';
Conexio::obrir_conexio();
$conexio = Conexio::obtenir_conexio();
Conexio :: tancar_conexio();
include_once 'plantilles/doc_declaracio.inc.php';
$inici='active';
include_once 'plantilles/navbar.inc.php';
if (session_id() == '') {
    session_start();
}

 ?>


<?php
if ($_SESSION['estat']==0 && $_SESSION['admin']==0){
?>

<div class='alert alert-warning alert-dismissible erroni' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><center>Recorda: encara no tens permís per escollir grups. T'has d'esperar que els professors amb més prioritat escullin, rebràs un correu electrònic quan puguis.</center></div>
<?php } ?>


<div class='container'>
  
    
   <h3 style="padding-top:10px;">
    <?php echo "Hola ".$_SESSION['nom']."!"?>
  
</h3>
<?php
if($_SESSION['admin']==0){
	
?>
<br>
  <p>
   Aquesta eina ha estat creada amb la finalitat de facilitar als professors la tasca d'escollir els grups als quals volen impartir classe
   el quadrimestre següent.Tingues en compte que està pensada per a ordinadors, si proves d'accedir des del mòbil és possible que no es vegi bé. <br> <br>
   A continuació trobaràs una petita guia de com funciona:<br><br>

 <h4>Puc escollir grups?</h4>
 No sempre podràs escollir grups quan inicis sessió a la web, ja que en primer lloc has de tenir permís per fer-ho degut que s'ha de seguir un ordre de prioritat segons antiguitat a l'escola.<br>
 Si ja tens permís per escollir hauràs rebut un correu notificant-ho i veuràs que a la part superior de la barra de navegació t'apareix el botó 'Validar',
si és així, podràs escollir dins de les pestanyes 'Ocupació grups' tant del Q1 com del Q2.
  <br><br> <h4>Quan he de clicar Validar? </h4>
   Prem el botó Validar un cop hagis escollit el grups, tot i així recorda, el fet de validar <strong>no impedeix seguir modificant els grups triats.</strong>
   Un cop ho fagis, el següent professor en l'ordre de prioritat rebrà un email notificant-li que pot escollir i se li concedirà permís.
  <br><br><h4>Puc veure la situació actual? </h4>
  A 'Distribució docent' dins de cada quadrimestre, podràs veure què ha escollit cadascú en aquell quadrimestre (els noms dels professors estan en sigles però si passes per sobre amb el ratolí t'apareixerà el nom complet). 
  <br>A la pestanya General, trobaràs la informació tant de tots dos quadrimestres, allà et podràs baixar un <strong>excel</strong> amb totes les dades. <br>
  
</p>

<?php } if($_SESSION['admin']==1){?>

	  <br>
  <p>
   Aquesta eina ha estat creada amb la finalitat de facilitar als professors la tasca d'escollir els grups als quals volen impartir classe
   el quadrimestre següent.Tingues en compte que està pensada per a ordinadors, si proves d'accedir des del mòbil és possible que no es vegi bé. <br> <br>
   A continuació trobaràs una petita guia de com funciona:<br><br>

 <h4>Com puc afegir professors i assignatures?</h4>
 Prem el desplegable de la dreta de tot on posa Administrador i ves a 'Opcions administrador', allà veuràs totes les accions que pots realitzar. Pots pujar tots els professors i assignatures de cop
 a l'apartat 'Pujar fitxers', on se't demanarà un arxiu en format .csv tant pels professors com per les assignatures.
 <br>També pots pujar professors de manera individual a l'apartat 'Taula Professors' amb el botó <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>.
  <br><br> <h4>Puc esborrar professors i assignatures? </h4>
   Sí. Això es fa anant a l'apartat 'Taula Professors' o 'Taula Assignatures', seleccionant tots els que  vulguin esborrar i prement el botó <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>.
  <br><br><h4>Puc veure la situació actual? </h4>
  A 'Distribució docent' dins de cada quadrimestre, podràs veure què ha escollit cadascú en aquell quadrimestre (els noms dels professors estan en sigles però si passes per sobre amb el ratolí t'apareixerà el nom complet). 
  <br>A la pestanya General, trobaràs la informació tant de tots dos quadrimestres, allà et podràs baixar un <strong>excel</strong> amb totes les dades i informació sobre PADs i grups totals escollits. <br>
  
</p> 

<?php } ?>

  
</div>

<script>
    document.getElementById('submitExport').addEventListener('click', function(e) {
    e.preventDefault();
    let export_to_excel = document.getElementById('export_to_excel');
    let data_to_send = document.getElementById('data_to_send');
    data_to_send.value = export_to_excel.outerHTML;
    document.getElementById('formExport').submit();
});
</script>

<?php
include_once 'plantilles/doc_tancament.inc.php'
?>
