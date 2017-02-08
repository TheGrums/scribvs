<?php
  //ini_set("display_errors",true);
  $imailman = new InternalMailManager();
?>
<!DOCTYPE html>
<html lang="fr">
  <head>

    <title>Panel</title>

    <?php
      $animate=true;
      require(dirname(__FILE__).'/head.php');
    ?>
  </head>

  <body class = "maincontainer">
    <?php require(dirname(__FILE__).'/navbar.php'); ?>
    <div class="wrapper">
    <div class="container-fluid embed-container">
      <div class="row">
        <div class="col-xs-6 panel-nav-item" onclick="setView(0);">
          <span class="glyphicon glyphicon-inbox"></span><br>
          <span class="panel-nav-text">Réception</span>
        </div>
        <div class="col-xs-6 panel-nav-item" onclick="setView(1);">
          <span class="glyphicon glyphicon-send"></span><br>
          <span class="panel-nav-text">Envoi</span>
        </div>
      </div>
      <div class="row part part-1" style="display:none;">
        <div class="col-md-12" style="min-height:100vh;">
          <div class="container-fluid">

            <div class="row" style="margin-top:3vw;">
              <div class="col-md-8 col-md-offset-2">
                <h3>Rédigez un message</h3>
                <h5>Uniquement pour vos professeurs.</h5>
              </div>
            </div>

            <div class="row" style="margin-top:3vw;">
              <div class="col-md-4 col-md-offset-4">
                <p class="dest-area">

                </p>
                <div class="form-group">
                  <div class="input-group">
                    <input id="suggest-dest" data-cmp-val = "<?php echo ((isset($_GET['dest'])&&isset($_GET['destid']))?intval($_GET['destid']):""); ?>" value = "<?php echo ((isset($_GET['dest'])&&isset($_GET['destid']))?htmlspecialchars($_GET['dest']):""); ?>" class="form-control" placeholder="Destinataire(s)" onblur="setTimeout(function(){$('#quick-dest-preview').hide();},100);" onkeyup="$(this).removeAttr('data-cmp-val');autoSuggest($(this),$('#quick-dest-preview'),'',undefined,createSimplePreview,'only-bigger');" type="text">
                    <span class="input-group-btn">
                      <button style="padding-right:6px;" id="add-dest" class="btn btn-primary quick-add-member" type="button"><span class="glyphicon glyphicon-plus" style="float:none;"></span>&nbsp;</button>
                    </span>
                  </div>
                  <span class="help-block" id="add-fail" style="display:none;color:red;">
                    Sélectionnez un utilisateur de la liste qui n'a pas encore été sélectionné.
                  </span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-4 col-lg-offset-4">
                <div class="list-group contextual_suggestions" data-linked-to="#suggest-dest" id="quick-dest-preview">

                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 col-md-offset-3">
                <div class="form-group">
                  <textarea id="message-input" class="form-control" placeholder="Votre message..." style="text-align:left;min-height:300px;padding:15px;"></textarea>
                </div>
              </div>
            </div>

            <div class="row" style="margin-bottom:30px;">
              <div class="col-md-8 col-md-offset-2 smart-col">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                      <div class="btn btn-submit" id="internal_message_send">Envoyer</div>
                      <span class="help-block" id="send-fail" style="display:none;color:red;">
                        Un destinataire miniumum et un message sont requis pour effectuer cette opération.
                      </span>
                    </div>
                  </div>
                  <div class="row" style="margin-top:40px;">
                    <div class="col-md-6 col-md-offset-3">
                      <h3>Envoyés</h3>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 smart-col" id="sended-mails">
                      <?php

                        $imailman->ListInternalMails($_SESSION['user'], 'WHERE aid='.$_SESSION['user']->Id());

                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row part part-0" style="display:none;">
        <div class="col-md-8 col-md-offset-2" style="margin-top:3vw;">
          <div class="container-fluid">
            <div class="row">
              <div class="col-xs-12">
                <?php

                  $imailman->ListInternalMails($_SESSION['user'],"WHERE dest LIKE concat('%|', ".$_SESSION['user']->Id().", '|%') OR dest LIKE concat(".$_SESSION['user']->Id().", '|%') OR dest LIKE concat(".$_SESSION['user']->Id().", '|%') OR dest=".$_SESSION['user']->Id());

                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    <?php require(dirname(__FILE__).'/scripts.php'); ?>
  	<script type = "text/javascript" src="<?php echo GENERAL_PATH; ?>js/autosuggest.js"></script>
    <script type = "text/javascript" src="<?php echo GENERAL_PATH; ?>js/messages.js"></script>
    <script>detectActive(6);</script>
  </body>
</html>
