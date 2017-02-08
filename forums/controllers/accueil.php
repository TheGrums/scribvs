<?php
  //ini_set("display_errors",true);
  $man = new SubjectManager();
?>

<!DOCTYPE html>
<html>
  <head>
    <?php
      $animate=true;
      require(INCLUDE_FROM_DEEPER.'controllers/head.php');
    ?>
    <link rel="stylesheet" href="./sheets/css/add.css"></link>
  </head>
  <body>
    <div class="maincontainer">
    <div class="wrapper">

      <div class="container-fluid embed-container" style="min-height:90vh;">

        <div class="row" style="margin-top:5vh;">
          <div class="col-sm-12">
            <h1 class="maintitle">Forum</h1>
            <h5>Liste des matières.</h5>
          </div>
        </div>

        <div class="row">
          <ol class="breadcrumb" style="margin-top: 25px;">
            <li class="active">Accueil</li>
          </ol>
        </div>

        <div class="row small-row">
          <?php
          $sbs = $man->listSubjects(1,"normal");
          for($i=0;$i<count($sbs);$i++){
            echo '
            <div class="col-md-4 col-sm-6 forum-ctnr" onclick="window.location.href=\'./sections.php?q='.$sbs[$i]->Id().'&title='.$sbs[$i]->Name().'\';">
            <div class="forum-case">
            <div class="container-fluid">
            <div class="row">
            <div class="col-xs-3 thub-container">
            <div class="img-rounded profile-img section-thumbnail" style="background-image:url(\'./images/flat_icons.jpg\');background-size:500%;background-position: '.$sbs[$i]->Img().';"></div>
            </div>
            <div class="col-xs-9 txt-container">
            <h4>'.$sbs[$i]->Name().'</h4>
            <p class="forum-desc">'.$sbs[$i]->Description().'</p>
            </div>
            </div>
            <hr></hr>
            <div class="row">
            <div class="col-xs-12" style="padding:5px 15px;">
            <h5 style="display:inline;float:left;">Dernier sujet: </h5><h6 style="display:inline;float:right;max-width:50%;overflow-wrap:break-word;">'.$sbs[$i]->Last().'</h6>
            </div>
            </div>
            </div>
            </div>
            </div>';
          } ?>
        </div>

      </div>

    </div>
    </div>
      <?php require(INCLUDE_FROM_DEEPER."controllers/navbar.php");?>
      <?php require(INCLUDE_FROM_DEEPER.'controllers/scripts.php'); ?>
      <script type='text/javascript'>detectActive(3);</script>
  </body>

</html>
