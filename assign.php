<?php
$titol = 'Assignatures';

include_once 'app/RepositoriAssignatures.inc.php';
include_once 'app/Conexio.inc.php';
include_once 'plantilles/navbar.inc.php';
Conexio::obrir_conexio();
$total_assigns = RepositoriAssignatures :: obtenir_num_assigns(Conexio::obtenir_conexio());
$conexio = Conexio::obtenir_conexio();
Conexio :: tancar_conexio();
include_once 'plantilles/doc_declaracio.inc.php';
?>
<br><br>
<form method="POST">


    <div class="container">

        <nav class="profes-navbar navbar-default "  >


            <ul class='nav navbar-nav navbar-right'>
                <span></span>
            </ul>

            <ul class='nav navbar-nav navbar-right'>

                <button   formaction="nova_assign.php" type="submit" class="btn btn-default" >
                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                </button>

                <button type="submit" class="btn btn-default" aria-label="Left Align">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
                <button type="submit"  class="btn btn-default" name="esborra" aria-label="Left Align">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </button>

                <?php
                if (isset($_REQUEST['esborra'])) {
                    $chekes = $_REQUEST["check"];
                    for ($x = 0; $x < count($chekes); $x++) {
                        Conexio::obrir_conexio();
                        $conexio = Conexio::obtenir_conexio();
                        $sql1 = "SELECT nom FROM Assignatures WHERE Assignatures.id=$chekes[$x]";
                        $sql = "DELETE FROM Assignatures WHERE Assignatures.id = $chekes[$x]  ";
                        $sentencia1 = $conexio->prepare($sql1);
                        $sentencia = $conexio->prepare($sql);
                        $sentencia1->execute();
                        $sentencia->execute();
                        
                        $total_usuaris = RepositoriAssignatures :: obtenir_num_assigns(Conexio::obtenir_conexio());
                        
                        

                        foreach ($sentencia1 as $fila) {
                            $assign = $fila['nom'];
                            $sql2 = "DELETE FROM Global WHERE Global.Assignatura='$assign'";
                            $sentencia2 = $conexio->prepare($sql2);
                            $sentencia2->execute();
                        }
                        Conexio :: tancar_conexio();
                    }
                }
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-left" >
                <span>Nombre professors: <?php echo $total_assigns ?></span>

            </ul>


        </nav>

    </div>

    <div class="table-responsive container "> 


        <table class="table table-bordered table-striped ">

            <thead> 

                <tr style='font-size:15px'>
                    <!-- definimos cabeceras de la tabla --> 

                    <th> </th>
                    <th >Nom</th>

                    <th>Tipus</th>

                    <th>Crèdits
                    <th>Grups</th>

                    <th>Quadri</th>

                


                </tr>

            </thead>


            <tbody style="cursor:pointer">

<?php
if (isset($conexio)) {

    $sql = "SELECT * FROM Assignatures ";

    $sentencia = $conexio->prepare($sql);
    $sentencia->execute();
    $resultat = $sentencia->fetchAll();

    foreach ($resultat as $fila) {
        ?>
                        <tr onclick="seleccionar(this, <?php echo $fila['id'] ?>)" style='font-size:13px'>
                            <td> <input type="checkbox" name="check[]" value="<?php echo $fila['id'] ?>" id="<?php echo'chk' . $fila['id'] ?>"></td>
                            <td><?php echo $fila['nom'] ?></td>
                            <td><?php echo $fila['tipus'] ?></td>
                            <td><?php echo $fila['credits'] ?></td>
                            <td><?php echo $fila['grups'] ?></td>
                            <td><?php echo $fila['quadri'] ?></td>
                           
                        </tr>

        <?php
    }
}
?>
            </tbody>

        </table>

    </div>

</form>
<script>
    function seleccionar(tr, value) {
        $(function () {
            if ($("#chk" + value).attr("checked") == "checked") {

                $("#chk" + value).removeAttr("checked");


            }
            else {
                $("#chk" + value).attr("checked", "true");

            }
        })
    }
</script>
<?php
include_once 'plantilles/doc_tancament.inc.php'
?>