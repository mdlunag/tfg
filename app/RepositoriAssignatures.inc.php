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

    public static function afegir_assign($conexio, $assign, $total_assigns) {
        $assign_afegida = false;

        if (isset($conexio)) {

            try {
				if ($total_assigns == 0) {
                    $query = "ALTER TABLE Assignatures AUTO_INCREMENT = 1";
                    $resp = $conexio->prepare($query);
                    $valor_max = $resp->execute();
                } else {

                    $query = "Select Max(id) FROM Assignatures";
                    $sentencia = $conexio->prepare($query);
                    $sentencia->execute();
                    $resultat = $sentencia->fetch();
                    foreach ($resultat as $max) {
                        $valor_max = $max;
                    }

                    $query2 = "ALTER TABLE Assignatures AUTO_INCREMENT = $valor_max";
                    $resp2 = $conexio->prepare($query2);
                    $resp2->execute();
                }

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
	
	
	  public static function modificar_assignatura($conexio, $usuari) {
        $assign_modificat = false;

        if (isset($conexio)) {
            try {
                $id = $usuari->obtenir_id();
                $sql0 = "SELECT nom, tipus, quadri FROM Assignatures WHERE id=$id";
                $sentencia0 = $conexio->prepare($sql0);
                $sentencia0->execute();
                $resultat = $sentencia0->fetch();
				

                $nom_assign_abans = $resultat['nom'];
				$tipus_assign_abans=$resultat['tipus'];
                                $quadri_assign_abans=$resultat['quadri'];
                                
                                
				
                 $nom = $usuari->obtenir_nom();
                $tipus = $usuari->obtenir_tipus();
                $credits = $usuari->obtenir_credits();
                $quadri = $usuari->obtenir_quadri();
                $grups = $usuari->obtenir_grups();

                $sql = "UPDATE Assignatures SET nom='" . $nom . "', tipus='" . $tipus . "', credits=" . $credits . ", grups=" . $grups . ", quadri='" . $quadri . "'  WHERE id=" . $id;

                $sentencia = $conexio->prepare($sql);

                $assign_modificat = $sentencia->execute();
                
                $sql2 = "UPDATE Globals SET assignatura='" . $nom . "', tipus='" . $tipus . "', quadri='" . $quadri . "' WHERE assignatura='" . $nom_assign_abans . "' AND tipus='".$tipus_assign_abans."' AND quadri='".$quadri_assign_abans."'";
                $sentencia2 = $conexio->prepare($sql2);
                $sentencia2->execute();
            } catch (PDOException $ex) {
                $avis_inici = " <br><div class='alert alert-danger' role='alert'>";
                $avis_tancament = "</div>";

                $missatge = $ex->getMessage();
                echo $avis_inici . $missatge . $avis_tancament;
            }
        }


        return $assign_modificat;
    }
	
	
	

}
