<?php 
include_once 'app/config.inc.php';
include_once 'app/control_sessio.inc.php';
include_once 'app/redireccio.inc.php';

ControlSessio::tancar_sessio();
Redireccio::redirigir(SERVIDOR);

?>