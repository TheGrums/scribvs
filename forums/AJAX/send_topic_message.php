<?php
ini_set("display_errors",true);
require("../../config/db.php");
session_start();
print_r($_POST);
if(!isset($_POST['tid'])||$_POST['tid']==""||!isset($_POST['content'])||!isset($_POST['name'])||!isset($_POST['link'])||$_POST['content']==""){die("<span style='color:red;font-family:sniglet;font-size:10px;' class='hp'>Une erreur s'est produite, veuillez réessayer.</span>");}

if(!isset($_SESSION['user'])){

  header("Location: ../index.php");

}
else{
  require('../models/fonctions.php');
  postMessage($bdd,intval($_SESSION['user']->Id()),intval($_POST['tid']),$_POST['content'],$_POST['link'],killXss($_POST['name']));

  die("<span style='color:green;font-family:sniglet;font-size:10px;' class='hp'>Votre entrée a bien été ajoutée.</span>");

}



?>
