<?php
session_start();
$buttons=array("file"=>"dialog-box-container","th-list"=>"notifs-container");
?>
<!DOCTYPE html>

<html>

<head>
  <?php
  $animate = true;
  require(dirname(__FILE__)."/head.php");
  ?>
  <style>

  .place-t-post{
    display:none;
  }
  .profile-container{
    margin-top: 3vh;
  }
  #class-post{
    display:block;
  }

  </style>
</head>

<body id="class-page">
  <div class="maincontainer">
    <div class="wrapper">

      <div class = "container-fluid embed-container" style = "min-height:90vh;padding-top:10vh;">

        <div class="row">
          <div class="col-sm-12">
            <h1 id = "group-name" style="font-family:'Zapfino';font-size:4.5em;" ><?php echo $_SESSION['user']->ClassId(); ?></h1>
          </div>
        </div>

        <div class = "row">
          <div class = "col-md-9 col-md-offset-3 smart-col">
            <div class = "container-fluid">
              <?php
              require('./controllers/publications.php');
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Files -->
    <div class="dialog-box-container med-hidden">
      <div class="dialog-box-up">
        Fichiers
      </div>
      <div class="dialog-box-content">
        <span class = "files-info">Appuyez longtemps pour supprimer.</span>
        <div class="container-fluid" id="files-container">

        </div>
      </div>
      <div class="dialog-box-down">
        <span id="file-class" data-target-input="file-input" class="send-file embed-file-input"><?php echo $_SESSION['user']->ClassId(); ?></span>
        <span id="add-file">+</span>
        <input id="file-input" type="file" multiple="" style="display:none;"></input>
      </div>
    </div>

    <?php require(dirname(__FILE__)."/navbar.php");?>
  </div>
  <?php
  $mobile = true;
  require(dirname(__FILE__)."/scripts.php");
  echo "<script type = 'text/javascript'> detectActive(2); </script>";
  ?>
  <script async src="//cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>
  <script type = "text/javascript" src="<?php echo GENERAL_PATH; ?>/js/publications.js"></script>
  <script type = "text/javascript" src="<?php echo GENERAL_PATH; ?>/js/files.js"></script>
</body>

</html>
