<?php
//ini_set("display_errors",true);
require('./models/fonctions.php');

$title=htmlentities($_GET['title']);
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
<body id="view">
  <div class="maincontainer">
    <div class="wrapper">
      <div class="container-fluid embed-container">

        <div class="row" style="margin-top:5vh;">
          <div class="col-sm-12">
            <h1 class = "maintitle"><?php echo $title; ?></h1>
            <h5><?php echo $section; ?></h5>
          </div>
        </div>

        <div class="row">
          <ol class="breadcrumb" style="margin-top: 25px;">
            <li><a href="./index.php">Accueil</a></li>
            <li><a href="./sections.php?q=<?php echo intval($_GET['q']); ?>&title=<?php echo $title; ?>"><?php echo htmlentities($_GET['title']); ?></a></li>
            <li><a href="./list.php?q=<?php echo intval($_GET['q']); ?>&s=<?php echo intval($_GET['s']); ?>&title=<?php echo $title; ?>"<?php echo htmlentities($_GET['title']); ?>><?php echo $section; ?></a></li>
            <li class="active">Topic n°<?php echo intval($_GET['tid']);?></li>
          </ol>
        </div>


        <div class="topics-container" style="margin-bottom:100px;">

          <?php
            $tmman = new TopicMessageManager();
            $tcman = new TopicManager();
            $solved = $tcman->ShowTopic(intval($_GET['tid']));
            $tmman->ListTopicMessages(intval($_GET['tid']),"html");
          ?>
        </div>
      </div>
      <div class="container-fluid" <?php if($solved!=0)echo 'style="display:none;"'; ?>>
        <hr style = "margin:5vh 0vh;"></hr>
        <div class="row">
          <div class="col-sm-6 col-sm-offset-3">
            <h4 id="bottom-form-title">Répondre</h4>
            <h6 style="opacity:0.4;">Restez aimable et poli sur le forum...</h6>
          </div>
        </div>
        <div class = "row">
          <div class="col-sm-6 col-md-offset-3" style="margin-bottom:50px;" id = "editor">

            <form id="new-forum-message">
              <div class="form-group">
                <textarea id="ckinput" name="ckinput" rows="10" cols="80">
                </textarea>
              </div>
              <div class="form-group" id="send-message-wrapper" style="clear:both;">
                <div class="row">
                  <div class="col-sm-6 col-sm-offset-3">
                    <button class="form-control btn btn-submit" id = "forum-message-send">Envoyer</button>
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
  <script type="text/javascript" async src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_HTMLorMML"></script>
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
