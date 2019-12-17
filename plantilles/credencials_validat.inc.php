
<center>Afegir professor nou</center>
<label for="inputNom" class="sr-only">Nom</label>
<input name="nom" id="inputNom" class="form-control" placeholder="Nom" <?php $validador -> mostrar_nom()?> required autofocus>
<label for="inputCognom" class="sr-only">Cognoms</label>
<input name="cognoms" id="inputNom" class="form-control" placeholder="Cognoms" <?php $validador -> mostrar_cognoms()?> required autofocus>
<label for="inputEmail" class="sr-only">Adreça electrònica</label>
<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Adreça electrònica" <?php $validador -> mostrar_email()?> required autofocus>
<label for="inputPunts" class="sr-only">Punts</label>
<input name="punts" type="number" id="inputPunts" class="form-control" placeholder="Punts" <?php $validador -> mostrar_punts()?> required autofocus>
<label for="inputPassword" class="sr-only">Contrasenya</label>
<input type="password" name="contra" id="inputPassword" class="form-control" placeholder="Contrasenya" required>
    <?php $validador -> mostrar_error_nom();?>
    <?php $validador -> mostrar_error_cognoms();?>
    <?php $validador -> mostrar_error_email();?>
    <?php $validador -> mostrar_error_punts();?>
    <?php $validador -> mostrar_error_contra();?>

