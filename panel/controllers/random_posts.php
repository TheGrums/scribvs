<?php
  $psman = new PostManager();
?>

<div class="col-md-6 animated fadeIn">

  <div class="panel panel-default">
    <div class="panel-heading">Filtre à publications</div>
    <div class="panel-body">
      <div class="container-fluid" id="thread">

        <?php

          $posts = $psman->getRandomPosts(($_SESSION['user']->Level()>3?"level!=0":" dest LIKE '%|".$_SESSION['user']->ClassId()."' OR dest LIKE '".$_SESSION['user']->ClassId()."|%' OR dest LIKE '%|".$_SESSION['user']->ClassId()."|%' OR dest LIKE '".$_SESSION['user']->ClassId()."'"),3,$_SESSION['user']);
          for($i=0;$i<count($posts);$i++){
        ?>

        <div class="row">
          <div class="col-sm-12">
            <?php echo $posts[$i]->getPanelHtml(); ?>
          </div>
        </div>

        <?php } ?>

      </div>
    </div>
  </div>

</div>
<script type="text/javascript">getPubImages();</script>
