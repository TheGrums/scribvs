<?php
$title=htmlentities($_GET['title']);

$man = new SubjectManager();
$sb = $man->listSubjects("id = ".intval($_GET['q']), "normal");


if($sb[0]->Formules()){
  $display="col-md-4 col-sm-6";
}
else{
  $display="col-md-4 col-sm-6 col-md-offset-2";
}

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
            <h1 class="maintitle"><?php echo $title; ?></h1>
            <h5>Liste des sections.</h5>
          </div>
        </div>

        <div class="row">
          <ol class="breadcrumb" style="margin-top: 25px;">
            <li><a href="./index.php">Accueil</a></li>
            <li class="active"><?php echo $title; ?></li>

          </ol>
        </div>

        <div class="row small-row">
          <div class="<?php echo $display; ?> forum-ctnr" onclick="window.location.href='./list.php?q=<?php echo intval($_GET['q']); ?>&s=1&title=<?php echo $title; ?>';">
            <div class="forum-case">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-xs-3 thub-container">
                    <div class="img-rounded profile-img section-thumbnail" style="background-image:url('./images/microlessons.jpg');background-size: 140% auto;"></div>
                  </div>
                  <div class="col-xs-9 txt-container">
                    <h4>Microcours</h4>
                    <p class="forum-desc">Découvrez des petits cours express crées par vos profs juste pour vous.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-sm-6 forum-ctnr" onclick="window.location.href='./list.php?q=<?php echo intval($_GET['q']); ?>&s=2&title=<?php echo $title; ?>';">
            <div class="forum-case">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-xs-3 thub-container">
                    <div class="img-rounded profile-img section-thumbnail" style="background-image:url('./images/stuffs.jpg');background-size:100%;"></div>
                  </div>
                  <div class="col-xs-9 txt-container">
                    <h4>Discussions</h4>
                    <p class="forum-desc">Demandez de l'aide aux profs ou à vos camarades. Il n'y a pas de bêtes questions...</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php if($sb[0]->Formules()){ ?>
            <div class="col-md-4 col-sm-6 forum-ctnr" onclick="window.location.href='./list.php?q=<?php echo intval($_GET['q']); ?>&s=3&title=<?php echo $title; ?>';">
              <div class="forum-case">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-xs-3 thub-container">
                      <div class="img-rounded profile-img section-thumbnail" style="background-image:url('./images/formules.jpg');background-size:190%;"></div>
                    </div>
                    <div class="col-xs-9 txt-container">
                      <h4>Formulaire</h4>
                      <p class="forum-desc">Retrouvez rapidement toutes les formules vues au cours de sciences, maths ou autre...</p>
                    </div>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
  <?php require(INCLUDE_FROM_DEEPER."controllers/navbar.php");?>
  <?php require(INCLUDE_FROM_DEEPER.'controllers/scripts.php'); ?>
  <script type='text/javascript'>detectActive(3);</script>
</body>

</html>
