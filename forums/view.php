<?php
require('../config/db.php');
session_start();
//ini_set("display_errors",true);

if(!isset($_SESSION['user'])){

  header("Location: ../index.php");

}
else{
  if(isset($_GET['q'])&&isset($_GET['s'])&&isset($_GET['tid'])){
    switch(intval($_GET['s'])){

      case 1:
        $section="Microcours";
        break;
      case 2:
        $section="Discussions";
        break;
      case 3:
        $section="Formulaire";
        break;


    }
    require("./controllers/view.php");
  }
  else{
    header("Location: ./index.php");
  }
}

?>
