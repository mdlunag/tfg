<?php
include_once 'app/Conexio.inc.php';
include_once 'app/config.inc.php';
include_once 'app/RepositoriProfessors.inc.php';
$titol = 'Inicia sessió';
Conexio::obrir_conexio();
$total_usuaris = RepositoriProfessors :: obtenir_num_professors(Conexio::obtenir_conexio());
$conexio = Conexio::obtenir_conexio();
Conexio :: tancar_conexio();

include_once'plantilles/doc_declaracio.inc.php';
include_once 'plantilles/navbar.inc.php';
?>

<div class='container'><center>
        <form  method="post">
        <br>
        <button class="btn btn-primary " formaction= "<?php echo PUJAR_FITXER ?>" name="Fitxers">Pujar fitxers</button><br><br>
        <button class="btn  btn-primary " formaction= "<?php echo PROFESSORS ?>" name="profes">Taula Professors</button>
        <br><br><button  class="btn btn-primary " formaction= "<?php echo ASSIGNATURES ?>" name="enviar">Taula Assignatures</button>
        <br><br> <button class="btn  btn-primary " formaction= "<?php echo EDITAR_ADMIN ?>" name="admin">Canviar credencials administrador</button>

            <br><br><button class="btn btn-primary " type="submit"  style="background-color:#FF0000; border-color:#FF0000"  onclick="return confirmation()" name="esborrar_professors"  >Esborrar TOTS els professors</button>
            <br><br><button class="btn btn-primary "  type="submit" style="background-color:#FF0000; border-color:#FF0000"   onclick="return confirmation()" name="esborrar_assignatures">Esborrar TOTES les assignatures</button>
            <?php
            if (isset($_POST['esborrar_professors'])) {
                $sql = "DELETE FROM Professors WHERE admin=0;"
                        . "TRUNCATE TABLE Globals";
                $sentencia = $conexio->prepare($sql);
                $sentencia->execute();
            }

            if (isset($_POST['esborrar_assignatures'])) {
                $sql = "TRUNCATE TABLE Assignatures;"
                        . "TRUNCATE TABLE Globals";
                $sentencia = $conexio->prepare($sql);
                $sentencia->execute();
            }
            ?>
        </form>

    </center>
</div>

<script type="text/javascript">
    function confirmation()
    {
        if (confirm("Segur que vols esborrar les dades?"))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
</script>

<?php
include_once 'plantilles/doc_tancament.inc.php'
?>