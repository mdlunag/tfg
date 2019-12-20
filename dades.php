<?php
include_once 'app/Conexio.inc.php';
$titol = 'Dades';
Conexio::obrir_conexio();
$conexio = Conexio::obtenir_conexio();
Conexio :: tancar_conexio();

if (session_id() == '') {
    session_start();
}
include_once 'plantilles/doc_declaracio.inc.php';
include_once 'plantilles/navbar.inc.php';
?>

<center>
<div class='container' style="width:600px">
<br>
    <h3>Dades usuari</h3>
    
  
	  <br><br>
    <div class="table-responsive "> 

        <table style="text-align:center;border-top: 1px solid black;" class="table">

            <thead> 

          

            <?php
            if (isset($conexio)) {
				
                $sql = "SELECT  email, contrasenya, punts, cobert_Q1, cobert_Q2 FROM Professors WHERE admin=0 and id=".$_SESSION['id'];

                $sentencia = $conexio->prepare($sql);
                $sentencia->execute();
                $resultat = $sentencia->fetch();
				
                    ?>
                    
                   <tr>
				   <td style="border-top: 1px solid black; " BGCOLOR="#c2e5d2" >Usuari</td>
                    <td><?php echo $_SESSION['nom'];?></td>
					</tr>
					
					 <tr>
				   <td style="border-top: 1px solid black; " BGCOLOR="#c2e5d2" >Email</td>
                    <td><?php echo $resultat['email'];?></td>
					</tr>
					
					 <tr>
				   <td style="border-top: 1px solid black; " BGCOLOR="#c2e5d2" >DNI</td>
                    <td><?php echo $resultat['contrasenya'];?></td>
					</tr>
					
					 <tr>
				   <td style="border-top: 1px solid black; " BGCOLOR="#c2e5d2" >Punts contractats</td>
                    <td><?php echo $resultat['punts'];?></td>
					</tr>
					
					 <tr>
				   <td style="border-top: 1px solid black; " BGCOLOR="#c2e5d2" >Punts pendents</td>
                    <td><?php echo $punts_pendents;?></td>
					</tr>
					
                    <?php
                
            }
            ?>

            
            </thead>


        </table>

    </div>
</div>
</center>



<?php
include_once 'plantilles/doc_tancament.inc.php'
?>
