<?php
//ini_set("display_errors",true);
require_once("../config/db.php");
session_start();

if(isset($_SESSION['user'])&&isset($_POST['id'])){
  $man = new FileManager();
  $file = $man->ListFiles($_SESSION['user'], "id=".intval($_POST['id']));
  $file[0]->setNb_download($file[0]->nb_download()+1);
  $man->Update($file[0]);

}

?>
