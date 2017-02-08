<?php
ini_set("display_errors",true);
include_once("../config/db.php");
include_once("../models/functions.php");

session_start();

if(isset($_SESSION['user'])&&isset($_POST['fid'])){

  $man = new FileManager();
  $nfman = new NotifManager();

  $files = $man->listFiles($_SESSION['user'],"id=".$_POST['fid']);

  if($files[0]->Uid()==$_SESSION['user']->Id()||$_SESSION['user']->Level()>2){
    $nfman->RemoveLinkedToFile(substr($files[0]->Path(),1));
    $man->Remove($files[0]);
  }
  else{
    $deleted = explode("|",$files[0]->RemovedBy());
    array_push($deleted,$_SESSION['user']->Id());
    $files[0]->setRemoved_by(implode("|",$deleted));
    $man->Update($files[0]);
  }

}

?>
