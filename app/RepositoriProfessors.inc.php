<?php

include_once 'app/global.inc.php';
include_once 'app/RepositoriGlobals.inc.php';
include_once 'app/professor.inc.php';

class RepositoriProfessors {

    public static function obtenir_tots($conexio) {

        $usuaris = array();

        if (isset($conexio)) {

            try {
                include_once "professor.inc.php";

                $sql = "SELECT * FROM Professors WHERE admin=0";

                $sentencia = $conexio->prepare($sql);
                $sentencia->execute();
                $resultat = $sentencia->fetchAll();

                if (count($resultat)) {

                    foreach ($resultat as $fila) {
                        $usuaris[] = new Professor(
                                $fila['id'], $fila['nom'], $fila['cognoms'], $fila['email'], $fila['punts'], $fila['cobert_Q1'], $fila['cobert_Q2'], $fila['contrasenya'], $fila['data_creacio'], $fila['estat'], $fila['admin']
                        );
                    }
                } else {

                    print "No hi ha usuaris";
                }
            } catch (PDOException $ex) {
                print 'ERROR' . $ex->getMessage();
            }
        }
        return $usuaris;
    }

    public static function obtenir_num_professors($conexio) {
        $total_professors = null;

        if (isset($conexio)) {
            try {
                $sql = "SELECT COUNT(*)as total from Professors WHERE admin=0;";
                $sentencia = $conexio->prepare($sql);
                $sentencia->execute();
                $resultat = $sentencia->fetch();

                $total_professors = $resultat['total'];
            } catch (Exception $ex) {
                print "ERROR" . $ex->getMessage();
            }
            return $total_professors;
        }
    }

    public static function afegir_professor($conexio, $usuari, $num_profes) {
        $professor_afegit = false;

        if (isset($conexio)) {

            try {
                if ($num_profes == 0) {
                    $query = "ALTER TABLE Professors AUTO_INCREMENT = 1";
                    $resp = $conexio->prepare($query);
                    $valor_max = $resp->execute();
                } else {

                    $query = "Select Max(id) FROM Professors";
                    $sentencia = $conexio->prepare($query);
                    $sentencia->execute();
                    $resultat = $sentencia->fetch();
                    foreach ($resultat as $max) {
                        $valor_max = $max;
                    }

                    $query2 = "ALTER TABLE Professors AUTO_INCREMENT = $valor_max";
                    $resp2 = $conexio->prepare($query2);
                    $resp2->execute();
                }

                if ($usuari->estat() == '') {
                    $sql = "INSERT INTO Professors(nom, cognoms, email, punts, cobert_Q1, cobert_Q2, contrasenya, data_creacio, estat, admin) VALUES(:nom, :cognoms,:email,:punts,0,0, :contrasenya,NOW(),0,0)";
                    $sentencia = $conexio->prepare($sql);
                } else {
                    $sql = "INSERT INTO Professors(nom, cognoms, email, punts, cobert_Q1, cobert_Q2, contrasenya, data_creacio, estat, admin) VALUES(:nom, :cognoms,:email,:punts,0,0, :contrasenya,NOW(),:estat,0)";
                    $estattemp = $usuari->estat();
                    $sentencia = $conexio->prepare($sql);
                    $sentencia->bindParam(':estat', $estattemp, PDO::PARAM_STR);
                }

                $nomtemp = $usuari->obtenir_nom();
                $cognomstemp = $usuari->obtenir_cognoms();
                $emailtemp = $usuari->obtenir_email();
                $puntstemp = $usuari->obtenir_punts();
                $contrasenyatemp = $usuari->obtenir_contrasenya();

                $sentencia->bindParam(':nom', $nomtemp, PDO::PARAM_STR);
                $sentencia->bindParam(':cognoms', $cognomstemp, PDO::PARAM_STR);
                $sentencia->bindParam(':email', $emailtemp, PDO::PARAM_STR);
                $sentencia->bindParam(':punts', $puntstemp, PDO::PARAM_STR);
                $sentencia->bindParam(':contrasenya', $contrasenyatemp, PDO::PARAM_STR);
                $professor_afegit = $sentencia->execute();

                $sql2 = "SELECT nom,credits,tipus,quadri FROM Assignatures";
                $sentencia2 = $conexio->prepare($sql2);
                $sentencia2->execute();
                foreach ($sentencia2 as $assignatura) {


                    $globals = new Globals('', $assignatura['nom'], $assignatura['tipus'], $assignatura['quadri'], $nomtemp . " " . $cognomstemp, 0);
                    $global_afegit = RepositoriGlobals :: afegir_global(Conexio :: obtenir_conexio(), $globals);
                }
            } catch (PDOException $ex) {
                $avis_inici = " <br><div class='alert alert-danger' role='alert'>";
                $avis_tancament = "</div>";

                $missatge = $ex->getMessage();
                $missatge_email_1 = "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '";
                $missatge_email_2 = "' for key 'email'";
                $missatge_nom_cognoms_1 = "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '";
                $missatge_nom_cognoms_2 = "' for key 'nom_cognoms_uidx'";

                if ($missatge == $missatge_email_1 . $emailtemp . $missatge_email_2) {
                    echo $avis_inici . "Email duplicat. Canvia'l." . $avis_tancament;
                }
                if ($missatge == $missatge_nom_cognoms_1 . $nomtemp . "-" . $cognomstemp . $missatge_nom_cognoms_2) {
                    echo $avis_inici . "Professor ja existent." . $avis_tancament;
                }
            }
        }

        return $professor_afegit;
    }

    public static function obtenir_per_email($conexio, $email) {
        $professor = null;

        if (isset($conexio)) {
            try {
                $sql = "SELECT * FROM Professors WHERE Professors.email= :email";
                $sentencia = $conexio->prepare($sql);
                $sentencia->bindParam(':email', $email, PDO::PARAM_STR);
                $sentencia->execute();
                $resultat = $sentencia->fetch();

                if (!empty($resultat)) {
                    $professor = new Professor($resultat['id'], $resultat['nom'], $resultat['cognoms'], $resultat['email'], $resultat['punts'], $resultat['cobert_Q1'], $resultat['cobert_Q2'], $resultat['contrasenya'], $resultat['data_creacio'], $resultat['estat'], $resultat['admin']);
                }
            } catch (PDOException $ex) {

                print 'ERROR' . $ex->getMessage();
            }
        }
        return $professor;
    }

    public static function modificar_professor($conexio, $usuari) {
        $professor_modificat = false;

        if (isset($conexio)) {
            try {
                $id = $usuari->obtenir_id();
                $sql0 = "SELECT nom, cognoms FROM Professors WHERE id=$id";
                $sentencia0 = $conexio->prepare($sql0);
                $sentencia0->execute();
                $resultat = $sentencia0->fetch();

                $nom_profe_abans = $resultat['nom'] . ' ' . $resultat['cognoms'];
                $nom = $usuari->obtenir_nom();
                $cognoms = $usuari->obtenir_cognoms();
                $email = $usuari->obtenir_email();
                $punts = $usuari->obtenir_punts();
                $cobert_q1 = $usuari->obtenir_cobert_Q1();
                $cobert_q2 = $usuari->obtenir_cobert_Q2();
                $estat = $usuari->estat();
                $contrasenya = $usuari->obtenir_contrasenya();

                $sql = "UPDATE Professors SET nom='" . $nom . "', cognoms='" . $cognoms . "', email='" . $email . "', punts=" . $punts . ", cobert_Q1='" . $cobert_q1 . "', cobert_Q2='" . $cobert_q2 . "', contrasenya='" . $contrasenya . "',estat='" . $estat . "' WHERE id=" . $id;

                $sentencia = $conexio->prepare($sql);

                $professor_modificat = $sentencia->execute();
                $nom_profe = $nom . ' ' . $cognoms;
                $sql2 = "UPDATE Globals SET professor='" . $nom_profe . "' WHERE professor='" . $nom_profe_abans . "'";
                $sentencia2 = $conexio->prepare($sql2);
                $sentencia2->execute();
            } catch (PDOException $ex) {
                $avis_inici = " <br><div class='alert alert-danger' role='alert'>";
                $avis_tancament = "</div>";

                $missatge = $ex->getMessage();
                echo $avis_inici . $missatge . $avis_tancament;
            }
        }


        return $professor_modificat;
    }

    public static function modificar_id($conexio, $nou_id, $id) {

        if (isset($conexio)) {
            try {
                $sql0 = 'SELECT estat FROM Professors WHERE id=' . $id;
                $sentencia0 = $conexio->prepare($sql0);
                $estat = intval($sentencia0->execute());

                if ($nou_id == 1 && $estat == 0) {
                    $estat = 1;
                }

                if ($id = 1 && $estat == 1) {
                    $estat = 0;
                }
                $sql = "UPDATE Professors SET estat=" . $estat . ", id=" . $nou_id . " WHERE id=" . $id;

                $sentencia = $conexio->prepare($sql);

                $professor_modificat = $sentencia->execute();
            } catch (PDOException $ex) {
                $avis_inici = " <br><div class='alert alert-danger' role='alert'>";
                $avis_tancament = "</div>";

                $missatge = $ex->getMessage();
                echo $avis_inici . $missatge . $avis_tancament;
            }
        }
    }

    public static function afegir_professor_id_canviat($conexio, $professor, $nou_id) {
        $sql = "INSERT INTO Professors(id, nom, cognoms, email, punts, cobert_Q1, cobert_Q2, contrasenya, data_creacio, estat, admin) VALUES(:id,:nom, :cognoms,:email,:punts,:cobert_Q1,:cobert_Q2, :contrasenya,NOW(),:estat,0)";
        $nomtemp = $professor['nom'];
        $cognomstemp = $professor['cognoms'];
        $emailtemp = $professor['email'];
        $puntstemp = $professor['punts'];
        $cobertq1temp = $professor['cobert_Q1'];
        $cobertq2temp = $professor['cobert_Q2'];
        $estattemp = $professor['estat'];
        if ($nou_id == 1 && $estattemp == 0) {
            $estattemp = 1;
        }
        $contrasenyatemp = $cobertq1temp = $professor['contrasenya'];

        $sentencia = $conexio->prepare($sql);

        $sentencia->bindParam(':id', $nou_id, PDO::PARAM_STR);
        $sentencia->bindParam(':nom', $nomtemp, PDO::PARAM_STR);
        $sentencia->bindParam(':cognoms', $cognomstemp, PDO::PARAM_STR);
        $sentencia->bindParam(':email', $emailtemp, PDO::PARAM_STR);
        $sentencia->bindParam(':cobert_Q1', intval($cobertq1temp), PDO::PARAM_STR);
        $sentencia->bindParam(':cobert_Q2', intval($cobertq2temp), PDO::PARAM_STR);
        $sentencia->bindParam(':estat', $estattemp, PDO::PARAM_STR);
        $sentencia->bindParam(':punts', $puntstemp, PDO::PARAM_STR);
        $sentencia->bindParam(':contrasenya', $contrasenyatemp, PDO::PARAM_STR);

        $professor_nou_id = $sentencia->execute();
    }

}
