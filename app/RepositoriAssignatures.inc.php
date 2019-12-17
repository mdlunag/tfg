<?php

include_once 'app/RepositoriProfessors.inc.php';
include_once 'app/global.inc.php';

class RepositoriAssignatures {

    public static function obtenir_tots($conexio) {

        $assigns = array();

        if (isset($conexio)) {

            try {
                include_once "assignatura.inc.php";

                $sql = "SELECT * FROM assignatures ";

                $sentencia = $conexio->prepare($sql);
                $sentencia->execute();
                $resultat = $sentencia->fetchAll();

                if (count($resultat)) {

                    foreach ($resultat as $fila) {
                        $assigns[] = new Assign(
                                $fila['id'], $fila['nom'], $fila['tipus'], $fila['credits'], $fila['grups'], $fila['quadri']
                        );
                    }
                } else {

                    print "No hi ha usuaris";
                }
            } catch (PDOException $ex) {
                print 'ERROR' . $ex->getMessage();
            }
        }
        return $assigns;
    }

    public static function obtenir_num_assigns($conexio) {
        $total_assign = null;

        if (isset($conexio)) {
            try {
                $sql = "SELECT COUNT(*)as total from Assignatures";
                $sentencia = $conexio->prepare($sql);
                $sentencia->execute();
                $resultat = $sentencia->fetch();

                $total_assign = $resultat['total'];
            } catch (Exception $ex) {
                print "ERROR" . $ex->getMessage();
            }
            return $total_assign;
        }
    }

    public static function afegir_assign($conexio, $assign) {
        $assign_afegida = false;

        if (isset($conexio)) {

            try {
                $sql = "INSERT INTO Assignatures(nom, tipus, credits, grups,quadri) VALUES(:nom, :tipus,:credits,:grups,:quadri)";
                $nomtemp = $assign->obtenir_nom();
                $creditstemp = $assign->obtenir_credits();
                $tipustemp = $assign->obtenir_tipus();
                $grupstemp = $assign->obtenir_grups();
                $quadritemp = $assign->obtenir_quadri();


                $sentencia = $conexio->prepare($sql);

                $sentencia->bindParam(':nom', $nomtemp, PDO::PARAM_STR);
                $sentencia->bindParam(':tipus', $tipustemp, PDO::PARAM_STR);
                $sentencia->bindParam(':credits', $creditstemp, PDO::PARAM_STR);
                $sentencia->bindParam(':grups', $grupstemp, PDO::PARAM_STR);
                $sentencia->bindParam(':quadri', $quadritemp, PDO::PARAM_STR);


                $assign_afegida = $sentencia->execute();

                $sql2 = "SELECT nom,cognoms FROM Professors WHERE admin=0";
                $sentencia2 = $conexio->prepare($sql2);
                $sentencia2->execute();
                foreach ($sentencia2 as $profe) {


                    $globals = new Globals('', $nomtemp,$tipustemp, $quadritemp, $profe['nom'] . " " . $profe['cognoms'], 0);
                    $global_afegit = RepositoriGlobals :: afegir_global(Conexio :: obtenir_conexio(), $globals);
                }
            } catch (PDOException $ex) {


                print 'ERROR' . $ex->getMessage();
            }
        }

        return $assign_afegida;
    }

}
