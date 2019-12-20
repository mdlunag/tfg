<?php
$titol = 'Professors';

include_once 'app/RepositoriProfessors.inc.php';
include_once 'app/Conexio.inc.php';
include_once 'plantilles/navbar.inc.php';
Conexio::obrir_conexio();
$total_usuaris = RepositoriProfessors :: obtenir_num_professors(Conexio::obtenir_conexio());
$conexio = Conexio::obtenir_conexio();
Conexio :: tancar_conexio();
include_once 'plantilles/doc_declaracio.inc.php';
include_once 'app/canviar_prioritat.inc.php';
include_once 'app/canviar_estat.inc.php';
?>
<br><br>
<form method="POST">


    <div class="container">

        <nav class="profes-navbar navbar-default "  >


            <ul class='nav navbar-nav navbar-right'>
                <span></span>
            </ul>

            <ul class='nav navbar-nav navbar-right'>

                <button   formaction="<?php echo NOU_PROFESSOR ?>" type="submit" class="btn btn-default" >
                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                </button>

                <button formaction="<?php echo EDITAR_PROFESSORS ?>" type="submit" formaction="editar_profe.php" class="btn btn-default" aria-label="Left Align">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
                <button type="submit" onclick="return confirmation()"   class="btn btn-default" name="esborra" aria-label="Left Align">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </button>

                <?php
                include_once 'app/esborra_profes.inc.php';
                include_once 'app/boto_mail.inc.php';
                ?>
                <script type="text/javascript">
                    function confirmation()
                    {
                        if (confirm("Segur que vols esborrar les dades?"))
                        {
                            return true;
                        } else
                        {
                            return false;
                        }
                    }

                    function confirmation_enviar()
                    {
                        if (confirm("Vols enviar un mail a aquest usuari recordant-li que pot escollir grups?"))
                        {
                            return true;
                        } else
                        {
                            return false;
                        }
                    }
                </script>
            </ul>
            <ul class="nav navbar-nav navbar-left" >
                <span>Nombre professors: <?php echo $total_usuaris ?></span>

            </ul>


        </nav>

    </div>

    <div class="table-responsive container "> 


        <table style="text-align: center;" class="table table-bordered table-striped ">

            <thead > 

                <tr style='font-size:12.5px; ' >
                    <!-- definimos cabeceras de la tabla --> 

                    <th > </th>
                    <th style="text-align: center; padding-bottom:15px">Nom</th>

                    <th style="text-align: center;padding-bottom:15px">Cognoms</th>

                    <th style="text-align: center;padding-bottom:15px" >Email</th>

                    <th style="text-align: center;">Punts <br> contractats</th>
					
                    <th style="text-align: center;">Punts <br> pendents</th>
                   
                    <th style="text-align: center;padding-bottom:15px">DNI</th>

                    <th style="text-align: center;padding-bottom:15px">Data Creació</th>

                    <th style="text-align: center; vertical-align: center; padding-bottom:15px">Estat 
                        <div class="popup info" >
                            <span onclick="myFunction()" class=" glyphicon glyphicon-info-sign" aria-hidden="true"></span>

                            <span class="popuptext" id="myPopup">0: Sense permís per escollir.  No validat. <br><br>
                                1: Amb permís per escollir.  No validat.<br><br>
                                2: Amb permís per escollir. Validat.</span> 
                        </div>
                    </th>

            <script>
                function myFunction() {
                    var popup = document.getElementById("myPopup");
                    popup.classList.toggle("show");
                }
            </script>
            </tr>

            </thead>


            <tbody style="cursor:pointer">

                <?php
                if (isset($conexio)) {

                    $sql = "SELECT * FROM Professors WHERE admin=0 ORDER BY id ";

                    $sentencia = $conexio->prepare($sql);
                    $sentencia->execute();
                    $resultat = $sentencia->fetchAll();

                    foreach ($resultat as $fila) {
                        ?>



                        <tr  onclick="seleccionar(this, <?php echo $fila['id'] ?>)" style='font-size:13px'>
                            <td style="padding-top: 0;padding-bottom:0"> <label >

                                    <input  class="checkbox-id" type="checkbox" name="check[]" value="<?php echo $fila['id'] ?>" id="<?php echo'chk' . $fila['id'] ?>">
                                    <form method="post" class='form-selection'>
                                        <select onchange="this.form.submit()" id='ordre' name='ordre' >
                                            <option selected disabled hidden><?php echo ' ' . $fila['id'] ?></option>


                                            <?php
                                            for ($i = 1; $i <= $total_usuaris; $i++) {
                                                ?>
                                                <option value="<?php echo $fila['id'] . ' ' . $i ?>"><?php echo $i ?></option>

                                            <?php }
                                            ?>

                                        </select></form></label></td>

                            <td><?php echo $fila['nom'] ?></td>
                            <td><?php echo $fila['cognoms'] ?></td>
                            <td><?php echo $fila['email'] ?>
                                <button type="submit" onclick="return confirmation_enviar()"   value="<?php echo $fila['id'];?>" class="enviar" name="envia" aria-label="Left Align">
                                    <span class="glyphicon glyphicon-envelope" aria-hidden="true">  </span>
                                </button>
                            </td>
                            <td style="text-align: center;"><?php echo $fila['punts'] ?></td>
                            <td style="text-align: center;"><?php echo ($fila['punts']-$fila['cobert_Q1']-$fila['cobert_Q2']) ?></td>
                            <td style="text-align: center;"><?php echo $fila['contrasenya'] ?></td>
                            <td style="text-align: center;"><?php echo $fila['data_creacio'] ?></td>
                            <td style="text-align: center;"><form method="post" class='form-selection'>
                                    <select onchange="this.form.submit()"  name='estat' >
                                        <option selected disabled hidden><?php echo $fila['estat'] ?></option>


                                        <?php
                                        for ($i = 0; $i <= 2; $i++) {
                                            ?>
                                            <option value="<?php echo $fila['id'] . ' ' . $i ?>"><?php echo $i ?></option>

                                        <?php }
                                        ?>

                                    </select></form>

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
            } else {
                $("#chk" + value).attr("checked", "true");
            }
        })
    }



</script>
<?php
include_once 'plantilles/doc_tancament.inc.php'
?>