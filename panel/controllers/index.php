<!DOCTYPE html>
<html lang="fr">
  <head>

    <title>Panel</title>

    <?php
      $animate=true;
      require(INCLUDE_FROM_DEEPER.'controllers/head.php');
    ?>
    <link href="./controllers/css/panel.css" rel="stylesheet">
  </head>

  <body class = "maincontainer">
    <?php require(INCLUDE_FROM_DEEPER.'controllers/navbar.php'); ?>
    <div class="container-fluid embed-container">
      <div class="row">
        <?php require("./controllers/panel-nav.php"); ?>

      </div>
    </div>
    <img class="loader" src="./../pictures/loader.gif" style="width: 2%;height: auto;position: absolute;margin-top:10vh;">
    <div class="container-fluid embed-container panel-main-container">

    </div>
    <?php require(INCLUDE_FROM_DEEPER.'controllers/scripts.php'); ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.bundle.js" ></script>
    <script type="text/javascript" src="../js/autosuggest.js"></script>
    <script src="./controllers/js/panel.js" type="text/javascript"></script>
    <script type="text/javascript" src="./controllers/js/panel_messages.js"></script>
    <script>detectActive(6);</script>
  </body>
</html>
