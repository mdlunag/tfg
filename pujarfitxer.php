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

                        <button value='Upload' class="btn  btn-primary btn-block" type="submit" name="uploadBtn">Upload</button>

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
                        <button value='Upload' class="btn  btn-primary btn-block" type="submit" name="uploadBtn2">Upload</button>


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
    <br>
    <div class='col-lg-4 panel'>
        <br>
        <p> Penja fitxers amb extensió <b>.csv</b> delimitats amb coma. La primera fila <b>no</b> es tindrà en compte,
            serveix per posar els títols dels camps i evitar confusions. </p>
        <p> El fitxer amb les dades dels professors ha de constar de 5 columnes en el següent ordre:<b> Nom, Cognoms, Email,
                Punts, DNI (serà la contrasenya).</b> L'ordre en què estiguin escrits serà l'ordre de prioritat. </p>

        <p> El fitxer amb les dades de les assignatures ha de constar de 5 columnes en el següent ordre:<b> Nom, Cognoms, Email,
                Punts, DNI (serà la contrasenya)</b> </p>
        <br>

    </div>
    <div class='col-lg-2'></div>
  
    <?php
    include_once 'plantilles/doc_tancament.inc.php'
    ?>

