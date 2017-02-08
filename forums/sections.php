<?php
require('../config/db.php');
session_start();

if(!isset($_SESSION['user'])){

  header("Location: ../index.php");

}
else{
  if(isset($_GET['q'])){
    require("./controllers/sections.php");
  }
  else{
    header("Location: ./index.php");
  }
}


?>
