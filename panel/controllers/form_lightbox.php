<?php
$sbman = new SubjectManager();
$subjects = $sbman->ListSubjects("1","normal");
?>
<div class="overlay">
  <div class="lightbox fst-lgtbx">
    <h4>Bienvenue !</h4>
    <p style="padding:10px;">Nous vous remercions d'utiliser <em>Scribus</em> et vous invitons en tant que nouvel administrateur à nous communiquer la matière que vous enseignez...</p>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 col-md-offset-3 col-xs-12">
          <form>
            <div class="form-group" style="text-align:left;">
              <select class="form-control" id="lesson-input" name="lesson">
                <?php
                  for($i=0;$i<count($subjects);$i++){
                    echo "<option value='".$subjects[$i]->Id()."'>".$subjects[$i]->Name()."</option>";
                  }
                 ?>
                <option value="-1">Aucune</option>
              </select>
            </div>
            <div class="btn btn-submit" style="width:60%;" onclick="sendWelcomeForm();">Confirmer</div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
