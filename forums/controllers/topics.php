<?php
//ini_set("display_errors",true);
$man = new TopicManager();
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

      <div class="container-fluid embed-container">

        <div class="row" style="margin-top:5vh;">
          <div class="col-sm-12">
            <h1 class = "maintitle"><?php echo $title; ?></h1>
            <h5><?php echo $section; ?></h5>
          </div>
        </div>

        <?php require("./controllers/forum-header.php"); ?>


        <div class="topics-container">
          <?php
          $man->listTopics("secid=".intval($_GET['s'])." AND stid=".intval($_GET['q']),"html",0);
          ?>
        </div>
      </div>
      <nav>
        <ul class="pagination">
          <?php for($i=1;$i<(countTopics($bdd,$_GET['s'],$_GET['q'])/15+1);$i++){

            echo '<li class="page-item"><a class="page-link" onclick="pagination('.$i.','.intval($_GET['s']).','.intval($_GET['q']).')">'.$i.'</a></li>';

          }
          ?>


        </ul>
      </nav>
      <div class="container-fluid">
        <hr style = "margin:5vh 0vh;"></hr>
        <div class="row">
          <div class="col-sm-6 col-sm-offset-3">
            <h4>Créer un sujet</h4>
            <h6 style="opacity:0.4;">N'oubliez pas de vérifier si un sujet similaire n'a pas déjà été créé...</h6>
          </div>
        </div>
        <div class = "row">
          <div class="col-md-6 col-md-offset-3" style="margin-bottom:50px;">

            <form id="new-forum-topic">
              <div class="form-group">
                <input type="text" class="form-control" name="title" id = "title" placeholder="Titre du sujet"></input>
              </div>
              <div class="form-group">
                <textarea id="ckinput" name="ckinput" rows="10" cols="80">
                </textarea>
              </div>
              <div class="form-group" style="clear:both;">
                <div class="row">
                  <div class="col-sm-6 col-sm-offset-3">
                    <button class="form-control btn btn-submit" id = "forum-topic-send" style="padding-bottom:25px;">Envoyer</button>
                  </div>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require(INCLUDE_FROM_DEEPER."controllers/navbar.php");?>
  <?php require(INCLUDE_FROM_DEEPER.'controllers/scripts.php'); ?>
  <!--<script type="text/javascript" src="./MathJax/MathJax.js?config=TeX-AMS_CHTML,local/local"></script>-->
  <script type="text/javascript" src="./ckeditor/ckeditor.js"></script>
  <script type="text/javascript" async src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_SVG"></script>
  <script type='text/javascript' src='./sheets/js/forum_main.js'></script>
  <script type="text/javascript">
  CKEDITOR.replace( 'ckinput',
  {
    removePlugins: 'sourcearea'
  } );
  </script>
  <script type='text/javascript'>detectActive(3);</script>
</body>

</html>
