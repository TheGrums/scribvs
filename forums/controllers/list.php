<?php

  require('./models/fonctions.php');

  $title=htmlentities($_GET['title']);

  switch(intval($_GET['s'])){

    case 1:
      $section="Microcours";
      require("./controllers/microlessons.php");
      break;
    case 2:
      $section="Discussions";
      require("./controllers/topics.php");
      break;
    case 3:
      $section="Formulaire";
      require("./controllers/formules.php");
      break;


  }
?>
