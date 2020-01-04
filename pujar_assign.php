<?php

session_start();
$message3 = '';
$message4 = '';
include_once 'app/Conexio.inc.php';
include_once 'app/RepositoriAssignatures.inc.php';
include_once 'app/assignatura.inc.php';
Conexio::obrir_conexio();
$total_assigns = RepositoriAssignatures :: obtenir_num_assigns(Conexio::obtenir_conexio());
$conexio = Conexio::obtenir_conexio();
Conexio :: tancar_conexio();

$errors = array(1, 2, 3, 4, 5, 6, 7, 8);
$llista_errors = array(
    1 => "El tamany de l'arxiu supera el màxim permès",
    2 => "El tamany de l'arxiu supera el màxim permès",
    3 => "L'arxiu s'ha pujat parcialment",
    4 => 'Has de pujar un fitxer!',
    6 => 'Falta una carpeta temporal',
    7 => "Error en escriure l'arxiu al disc",
    8 => "Una extensió de PHP ha aturat la pujada de l'arxiu."
);

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
             $afegides=0;
            Conexio :: obrir_conexio();


            foreach ($lineas as $linea_num => $linea) {

                if ($i != 0) {

                    if (strpos($linea, ';') !== false){
						$datos = explode(";", $linea);
                 
				}else{
      
						$datos = explode(",", $linea);

						}

                    $nom = utf8_encode($datos[0]);
                    $tipus = utf8_encode($datos[1]);
                    $credits = $datos[2];
                    $grups = $datos[3];
                    $quadri = rtrim($datos[4]);
                    
                    
                    $assign = new Assignatura('',$nom, $tipus, $credits, $grups,$quadri);

                    $assign_afegida = RepositoriAssignatures :: afegir_assign(Conexio :: obtenir_conexio(), $assign, $total_assigns );

                    if ($assign_afegida) {
                       $afegides++;
                    }
                }
                $i++;
            }
            $message4 = 'Afegides ' . $afegides . ' assignatures';
            Conexio :: tancar_conexio();
            } else {
            $message3 = "Error en el format de l'arxiu. Extensions permeses: " . implode(',', $allowedfileExtensions);
        }           
    } elseif (in_array($_FILES['arxiu_assign']['error'], $errors, true)) {
        $message3 = $llista_errors[$_FILES['arxiu_assign']['error']];
    } else {
        
        $message3 = "Hi ha algun error desconegut amb la pujada de l'arxiu.";
    }
}


$_SESSION['message3'] = $message3;
$_SESSION['message4'] = $message4;
header("Location: pujar_fitxer.php");
?>


