<?php
require('../config/db.php');
session_start();
//ini_set("display_errors",true);

if(!isset($_SESSION['user'])){

  header("Location: ../index.php");

}
else{
  if(isset($_GET['q'])&&isset($_GET['s'])){
    require("./controllers/list.php");
  }
  else{
    header("Location: ./index.php");
  }
}


?>
