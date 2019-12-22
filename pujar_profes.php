
<?php

session_start();
$message = '';
$message2 = '';
include_once 'app/Conexio.inc.php';
include_once 'app/RepositoriProfessors.inc.php';
include_once 'app/professor.inc.php';
include_once 'app/global.inc.php';
include_once 'app/config.inc.php';
Conexio::obrir_conexio();
$total_usuaris = RepositoriProfessors :: obtenir_num_professors(Conexio::obtenir_conexio());
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
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['file']['name'];
        $tipo = $_FILES['file']['type'];

        $fileNameCmps = explode(".", $fileName);

        $fileExtension = strtolower(end($fileNameCmps));

        $tamanio = $_FILES['file']['size'];

        $archivotmp = $_FILES['file']['tmp_name'];
        $allowedfileExtensions = array('xls', 'csv');
        if (in_array($fileExtension, $allowedfileExtensions)) {


            $lineas = file($archivotmp);

            $i = 0;
            $afegits = 0;
            Conexio :: obrir_conexio();
            $conexio = Conexio::obtenir_conexio();

            foreach ($lineas as $linea_num => $linea) {

                if ($i != 0) {
                    if (strpos($linea, ';') !== false) {
                        $datos = explode(";", $linea);
                    } else {

                        $datos = explode(",", $linea);
                    }


                    $nom = $datos[0];
                    $cognoms = $datos[1];
                    $email = strval($datos[2]);
                    $punts = $datos[3];
                    $contra = rtrim($datos[4]);
                    $estat = intval(0);

                    if ($total_usuaris == 0 && $i == 1) {
                        $estat = intval(1);
                    }

                    $usuari = new Professor('', $nom, $cognoms, $email, $punts, '', '', $contra, '', $estat, '');
                    //$usuari = new Professor('', $nom, $cognoms, $email, $punts,'','',password_hash($contra,PASSWORD_DEFAULT), '', '','');

                    $usuari_afegit = RepositoriProfessors :: afegir_professor(Conexio :: obtenir_conexio(), $usuari, $total_usuaris);

                    if ($usuari_afegit) {
                        $afegits++;
                    }
                }
                $i++;
            }
            $message2 = 'Afegits ' . $afegits . ' professors';
            Conexio :: tancar_conexio();


            $message = '';
        } else {
            $message = "Error en el format de l'arxiu. Extensions permeses: " . implode(',', $allowedfileExtensions);
        }
    } elseif (in_array($_FILES['file']['error'], $errors, true)) {
        $message = $llista_errors[$_FILES['file']['error']];
    } else {
        $message = "Hi ha algun error desconegut amb la pujada de l'arxiu.";
    }
}



$_SESSION['message'] = $message;
$_SESSION['message2'] = $message2;
header("Location: pujar_fitxer.php");
?>


