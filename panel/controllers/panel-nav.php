<?php
if(isset($_SESSION['user'])){
?>
<div class="col-xs-2 col-xs-offset-2 panel-nav-item" data-ajax-target="home" onclick="setPanelActive(0);">
  <span class="glyphicon glyphicon-home"></span><br>
  <span class="panel-nav-text">Accueil</span>
</div>
<div class="col-xs-2 panel-nav-item" data-ajax-target="files" onclick="setPanelActive(1);">
  <span class="glyphicon glyphicon-duplicate"></span><br>
  <span class="panel-nav-text">Fichiers</span>
</div>
<div class="col-xs-2 panel-nav-item" data-ajax-target="students-groups" onclick="setPanelActive(2);">
  <span class="glyphicon glyphicon-tag"></span><br>
  <span class="panel-nav-text">Groupes</span>
</div>
<div class="col-xs-2 panel-nav-item" data-ajax-target="sendmessage" onclick="setPanelActive(3);">
  <span class="glyphicon glyphicon-send"></span><br>
  <span class="panel-nav-text">Messages</span>
</div>
<!--<div class="col-xs-2 panel-nav-item">
  <span class="glyphicon glyphicon-eye-open"></span><br>
  <span class="panel-nav-text">Elèves</span>
</div>
<div class="col-xs-2 panel-nav-item">
  <span class="glyphicon glyphicon-stats"></span><br>
  <span class="panel-nav-text">Stats</span>
</div>-->

<?php
}
?>
