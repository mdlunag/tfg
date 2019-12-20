<?php

session_start();
$message3 = '';
$message4 = '';
include_once 'app/Conexio.inc.php';
include_once 'app/RepositoriAssignatures.inc.php';
include_once 'app/assignatura.inc.php';


if (isset($_POST['uploadBtn2']) && $_POST['uploadBtn2'] == 'Upload') {
    if (isset($_FILES['arxiu_assign']) && $_FILES['arxiu_assign']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['arxiu_assign']['name'];
        $tipo = $_FILES['arxiu_assign']['type'];

        $fileNameCmps = explode(".", $fileName);

        $fileExtension = strtolower(end($fileNameCmps));

        $tamanio = $_FILES['arxiu_assign']['size'];

        $archivotmp = $_FILES['arxiu_assign']['tmp_name'];
        $allowedfileExtensions = array('xls', 'csv');
        if (in_array($fileExtension, $allowedfileExtensions)) {


            $lineas = file($archivotmp);

            $i = 0;
            Conexio :: obrir_conexio();


            foreach ($lineas as $linea_num => $linea) {

                if ($i != 0) {

                    if (strpos($linea, ';') !== false){
						$datos = explode(";", $linea);
                 
				}else{
      
						$datos = explode(",", $linea);

						}

                    $nom = $datos[0];
                    $tipus = $datos[1];
                    $credits = $datos[2];
                    $grups = $datos[3];
                    $quadri = rtrim($datos[4]);
                    
                    
                    $assign = new Assignatura('',$nom, $tipus, $credits, $grups,$quadri);

                    $assign_afegida = RepositoriAssignatures :: afegir_assign(Conexio :: obtenir_conexio(), $assign);

                    if ($assign_afegida) {
                        $message4 = 'Afegides ' . $i . ' assign';
                    }
                }
                $i++;
            }
            Conexio :: tancar_conexio();


            
        } else {
            $message3 = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
        }
    } else {
        $message3 = 'There is some error in the file upload. Please check the following error.<br>';
        $message3 .= 'Error:' . $_FILES['arxiu_assign']['error'];
    }
}



$_SESSION['message3'] = $message3;
$_SESSION['message4'] = $message4;
header("Location: pujar_fitxer.php");
?>


