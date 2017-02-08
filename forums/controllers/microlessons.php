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
        <?php require("./controllers/forum-header.php"); ?>

      </div>

    </div>
  </div>
  <?php require(INCLUDE_FROM_DEEPER."controllers/navbar.php");?>
  <?php require(INCLUDE_FROM_DEEPER.'controllers/scripts.php'); ?>
  <script type='text/javascript'>detectActive(3);popWorking("Cette section n'est pas encore disponible...<br />",".");</script>
</body>

</html>
