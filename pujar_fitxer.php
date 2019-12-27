<?php
session_start();
include_once'plantilles/doc_declaracio.inc.php';
include_once 'plantilles/navbar.inc.php';
?>



<div class="container">
    <br><br><br>
    <div class='col-lg-1'></div>
    <div class='col-lg-5'>
        <br>
        <div class='row'>
            <div class='col-lg-6 col-lg-offset-2'>

                <form method="POST" action="pujar_profes.php" enctype="multipart/form-data">
                    <div>
                        <h4><strong>Afegeix professors:</strong></h4>
                        <input type="file" name="file" />
                        <button value='Upload' class="btn  btn-primary btn-block" type="submit" name="uploadBtn">Puja</button>

                    </div>
                </form>

                <?php
                if (isset($_SESSION['message']) && $_SESSION['message']) {
                    printf('<b>%s</b>', $_SESSION['message']);
                    unset($_SESSION['message']);
                }

                if (isset($_SESSION['message2']) && $_SESSION['message2']) {
                    printf('<b>%s</b>', $_SESSION['message2']);
                    unset($_SESSION['message2']);
                }
                ?>
            </div>
            <div class='col-lg-6'></div>

        </div>
        <br><br><br>
        <div class='row'>

            <div class='col-lg-6 col-lg-offset-2'>
                <form method="POST" action="pujar_assign.php" enctype="multipart/form-data">
                    <div>
                        <h4><strong>Afegeix assignatures:</strong></h4>
                        <input type="file" name="arxiu_assign" /> 
                        <button value='Upload' class="btn  btn-primary btn-block" type="submit" name="uploadBtn2">Puja</button>


                    </div>
                </form>

                <?php
                if (isset($_SESSION['message3']) && $_SESSION['message3']) {
                    printf('<b>%s</b>', $_SESSION['message3']);
                    unset($_SESSION['message3']);
                }

                if (isset($_SESSION['message4']) && $_SESSION['message4']) {
                    printf('<b>%s</b>', $_SESSION['message4']);
                    unset($_SESSION['message4']);
                }
                ?>
            </div>
            <div class='col-lg-6'></div>

        </div>
    </div>
    
    <div class='col-lg-4 panel'>
        <br>
        <p align="justify"> Penja fitxers amb extensió <b>.csv</b> (es crea un Excel i al guardar es selecciona el format, ).<br> La primera fila <b>no</b> es tindrà en compte,
            serveix per posar els títols dels camps i evitar confusions. </p>
        <p align="justify"> El fitxer amb les dades dels professors ha de constar de 5 columnes en el següent ordre:<b> Nom, Cognoms, Email,
                Punts, DNI (serà la contrasenya).</b> L'ordre en què estiguin escrits serà l'ordre de prioritat. </p>

        <p align="justify"> El fitxer amb les dades de les assignatures ha de constar de 5 columnes en el següent ordre:<b> Nom, Tipus, Crèdits,
                Grups, Quadrimestre. </b> </p>
        <br>
        <p align="justify" style="font-size: 12px">Nota: és possible que a penjar professors/assignatures no es vegin bé els accents. Això és degut a un problema en la codificació del text
        al guardar-lo en format .csv. Per tal de solucionar-ho, a la pantalla <i>Guardar como<i>, on has de seleccionar la localització i format del fitxer, prem <i>Herramientas-
        Opciones web... - Codifiación<i> y selecciona <i> Guardar este documento como: Unicode (UTF-8) <i>.</p>

    </div>
    <div class='col-lg-2'></div>
  
    <?php
    include_once 'plantilles/doc_tancament.inc.php'
    ?>

