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
          getTopics($bdd,1,$_GET['s'],$_GET['q'],1,'');
          ?>
        </div>
      </div>
      <nav>
        <ul class="pagination">
          <?php for($i=1;$i<=(countTopics($bdd,$_GET['s'],$_GET['q'])/15+1);$i++){

            echo '<li class="page-item"><a class="page-link" onclick="pagination('.$i.','.intval($_GET['s']).','.intval($_GET['q']).')">'.$i.'</a></li>';

          }
          ?>


        </ul>
      </nav>
      <?php if($_SESSION['co_elements']['level']>=2){ ?>
        <div class="container-fluid">
          <hr style = "margin:5vh 0vh;"></hr>
          <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
              <h4>Ajoutez votre propre formule !</h4>
              <h6 style="opacity:0.4;">N'oubliez pas de vérifier si votre formule n'existe pas déjà avant de la publier.</h6>
            </div>
          </div>
          <div class = "row">
            <div class="col-md-4 col-md-offset-4" style="margin-bottom:50px;">
              <form>
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Nom de la formule" id="form-name" required></input>
                </div>
                <div class="form-group">
                  <textarea class="form-control" id="formula-input" style="min-height:100px;text-align:left;" placeholder="Formule en LaTeX. Ex: \phi = { 1+\sqrt{5} \over 2}"></textarea>
                </div>
                <div class="form-group">
                  <div id="preview" style="text-align:left;min-height:15px;">

                  </div>
                </div>
                <div class="form-group" style = "text-align:left;">
                  <label style = "font-family:Sniglet;opacity:0.5;">Aide-mémoire :</label><br>
                  <ul class="cheat-sheet" style="float:left;">
                    <li>\sqrt{2} => <span class="math-tex">\( \sqrt{2} \)</span></li>
                    <li>b^2 => <span class="math-tex">\( b^2 \)</span></li>
                    <li>1 \over 2 => <span class="math-tex">\( 1 \over 2 \)</span></li>
                  </ul>
                  <ul class="cheat-sheet" style="float:right;">
                    <li>\pm => <span class="math-tex">\( \pm \)</span></li>
                    <li>\pi => <span class="math-tex">\( \pi \)</span></li>
                    <li><a target="http://www.commentcamarche.net/contents/620-latex-table-de-caracteres#symboles-mathematiques" href="http://www.commentcamarche.net/contents/620-latex-table-de-caracteres#symboles-mathematiques">Manuel...</a></li>
                  </ul>
                  <br />
                </div>
                <div class="form-group" style="clear:both;">
                  <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                      <button class="form-control btn btn-submit" id = "formula-send">Envoyer</button>
                    </div>
                  </div>
                </div>
              </form>

              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require(INCLUDE_FROM_DEEPER."controllers/navbar.php");?>
    <?php require(INCLUDE_FROM_DEEPER.'controllers/scripts.php'); ?>
    <?php if($_SESSION['co_elements']['level']>=2){echo "<script type='text/javascript' src='./sheets/js/profadds.js'></script>";} ?>
    <script type="text/javascript" src="./MathJax/MathJax.js?config=TeX-AMS_CHTML,local/local"></script>
    <!--<script type="text/javascript" async src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML"></script>-->
    <script type='text/javascript' src='./sheets/js/forum_main.js'></script>
    <?php if($_SESSION['co_elements']['level']>=2){ echo '<script type="text/javascript">latexInputs('.intval($_GET['s']).','.intval($_GET['q']).');</script>';} ?>
    <script type='text/javascript'>detectActive(3);</script>
  </body>

  </html>
