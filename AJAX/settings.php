<?php
  if(!function_exists('loadClass'))require_once '../config/db.php';
  session_start();
  $uid=uniqid(rand(),false);
  $_SESSION["formid"]=$uid;
?>
<div class="container-fluid profile-container">
<h3>Paramètres</h3>
<form>
  <div class="col-sm-6 col-sm-offset-3">
    <div class="form-group">
      <label for="email" class="left-label">Adresse électronique :</label>
      <input class="form-control" type="text" name="email" id="email" value="<?php echo $_SESSION['user']->Email(); ?>"></input>
      <p class="help-block">Ne changez jamais votre mot de passe et votre adresse en même temps.</p>
    </div>
    <div class="form-group">
      <label for="pass" class="left-label">Mot de passe :</label>
      <input class="form-control" type="password" name="pass" placeholder="Nouveau mot de passe" id="pass"></input>
      <p class="help-block">Le changement de mot de passe nécessite une vérification par email.</p>
    </div>
    <div class="form-group">
      <label for="signature" class="left-label">Signature :</label>
      <input class="form-control" type="text" id="email" placeholder="Signature" value="<?php echo $_SESSION['user']->Signature(); ?>"></input>
      <p class="help-block">Ceci apparaitra sous vos messages dans le forum.</p>
    </div>

  </div>
</form>


</div>
