<?php
  $imailman = new InternalMailManager();
  $gman = new GroupManager();
  $gr = $gman->getOwnedGroups($_SESSION['user'],"normal");

  $fman = new FileManager();
  $filter="uid=".$_SESSION['user']->Id();
  $files = $fman->listFiles($_SESSION['user'],$filter,'normal','','.');
?>
    <div class="col-md-12">
    <div class="container-fluid embed-container">
      <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-default slide-button active" onclick="setView(0);">Réception</button>
            <button type="button" class="btn btn-default slide-button" onclick="setView(1);">Envoi</button>
          </div>
        </div>
      </div>
      <div class="row part part-1" style="display:none;">
        <div class="col-md-12" style="min-height:100vh;">
          <div class="container-fluid">

            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 form-inline">
                  <div class="well well-large" style="margin-top:20px;">
                    <div class="form-group" style="margin:0px 5px;">
      									<div class='checkbox tb-checkbox'>
      										<label>
      											<input type='checkbox' id="check-all"> Tout cocher
      										</label>
      									</div>
      							</div>
                    <div class="form-group vertical-top" style="margin:0px 5px;">
                      <?php
                      if (count($gr)%7==0)$divider=7;
                      else if (count($gr)%6==0||count($gr)%9==0)$divider=6;
                      else if (count($gr)%5==0)$divider=5;
                      else if (count($gr)%4==0)$divider=4;
                      else if (count($gr)%3==0)$divider=3;
                      else $divider=7;
                      for($i=0;$i<count($gr);$i++){
                        if($i%$divider==0&&$i!=0)echo "</div><div class='form-group' style='margin:0px 5px;'>";
                        if($gr[$i]->Name()==$_SESSION['user']->WholeName())
                        echo "<div class='checkbox tb-checkbox'>
                        <label>
                        <input type='checkbox' class='chk-in' name='groups' value='".$gr[$i]->Id()."' > Vos amis
                        </label>
                        </div>";
                        else
                        echo "<div class='checkbox tb-checkbox'>
                        <label>
                        <input type='checkbox' class='chk-in' name='groups' value='".$gr[$i]->Id()."' > ".$gr[$i]->Name()."
                        </label>
                        </div>";
                      }

                      ?>
                    </div>
                  </div>
                </div>
            </div>

            <div class="row">
              <div class="col-md-4 col-md-offset-4">
                <p class="dest-area">

                </p>
                <div class="form-group">
                  <div class="input-group">
                    <input id="suggest-dest" data-cmp-val = "<?php echo ((isset($_GET['dest'])&&isset($_GET['destid']))?intval($_GET['destid']):""); ?>" value = "<?php echo ((isset($_GET['dest'])&&isset($_GET['destid']))?htmlspecialchars($_GET['dest']):""); ?>" class="form-control" placeholder="Ajouter un destinataire unique" onblur="setTimeout(function(){$('#quick-dest-preview').hide();},100);" onkeyup="$(this).removeAttr('data-cmp-val');autoSuggest($(this),$('#quick-dest-preview'),'.',undefined,createSimplePreview,undefined);" type="text">
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
                      <div class="btn btn-submit" id="internal_message_send" onclick="sendMessage();">Envoyer</div>
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
      <div class="row part part-0">
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
