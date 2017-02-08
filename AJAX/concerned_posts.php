<?php
header('content-type: application/json');
ob_start('ob_gzhandler');
header('Cache-Control: max-age=31536000, must-revalidate');
//ini_set("display_errors",true);
require_once("../config/db.php");
session_start();

if(isset($_SESSION['user'])&&isset($_POST['type'])){
  $place=$_POST['type'];

  if(!is_string($place)){die("F***ing error !!!");}

  switch($place){
    case "profile":
      $filter="aid=".$_SESSION->Id();
    break;
    case "class-page":
      $filter.="dest LIKE '%|".$_SESSION['user']->ClassId()."' OR dest LIKE '".$_SESSION['user']->ClassId()."|%' OR dest LIKE '%|".$_SESSION['user']->ClassId()."|%' OR dest LIKE '".$_SESSION['user']->ClassId();
      $filter.="' OR dest='school' LIKE '%|y".$_SESSION['user']->Year()."' OR dest LIKE 'y".$_SESSION['user']->Year()."|%' OR dest LIKE '%|y".$_SESSION['user']->Year()."|%' OR dest LIKE 'y".$_SESSION['user']->Year()."'";
      break;
    default:
      $man = new PostManager();
      echo $man->getPostsByContent($_SESSION['user']->Combinaisons(),'json');
      break;

  }


}

?>
