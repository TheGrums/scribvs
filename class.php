<?php
	if(!function_exists('loadClass'))require_once './config/db.php';
	session_start();
	require_once "./models/id.php";

  if(isset($_GET['q'])){

    if(isset($_SESSION['user'])&&$_SESSION['user']->ClassId() == $_GET['q']){
      require("./controllers/private_class.php");
    }
    else{
      require("./controllers/public_class.php");
    }

  }

?>
