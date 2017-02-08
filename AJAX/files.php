<?php
header('content-type: application/json');
ob_start('ob_gzhandler');
header('Cache-Control: max-age=31536000, must-revalidate');
//ini_set("display_errors",true);
require_once("../config/db.php");
session_start();

if(isset($_SESSION['user'])&&isset($_POST['type'])){
  $place=$_POST['type'];
  $man = new FileManager();

  if(!is_string($place)){die("F***ing error !!!");}

  switch($place){
    case "profile":
      $filter="uid=".$_SESSION['user']->Id();
    break;
    case "class-page":
      $filter.="dest LIKE '%|".$_SESSION['user']->ClassId()."' OR dest LIKE '".$_SESSION['user']->ClassId()."|%' OR dest LIKE '%|".$_SESSION['user']->ClassId()."|%' OR dest LIKE '".$_SESSION['user']->ClassId();
      $filter.="' OR dest='school' LIKE '%|y".$_SESSION['user']->Year()."' OR dest LIKE 'y".$_SESSION['user']->Year()."|%' OR dest LIKE '%|y".$_SESSION['user']->Year()."|%' OR dest LIKE 'y".$_SESSION['user']->Year()."'";
      break;
    case "pbprofile":
      $filter="uid=".intval($_POST['uid'])." AND (dest LIKE '%|".$_SESSION['user']->Id()."' OR dest LIKE '".$_SESSION['user']->Id()."|%' OR dest LIKE '%|".$_SESSION['user']->Id()."|%' OR dest LIKE '".$_SESSION['user']->Id();
      $filter.="' OR dest LIKE '%|".$_SESSION['user']->ClassId()."' OR dest LIKE '".$_SESSION['user']->ClassId()."|%' OR dest LIKE '%|".$_SESSION['user']->ClassId()."|%' OR dest LIKE '".$_SESSION['user']->ClassId();
      $filter.="' OR dest='school' LIKE '%|y".$_SESSION['user']->Year()."' OR dest LIKE 'y".$_SESSION['user']->Year()."|%' OR dest LIKE '%|y".$_SESSION['user']->Year()."|%' OR dest LIKE 'y".$_SESSION['user']->Year()."' OR uid=".$_SESSION['user']->Id().")";
      $filter.=" AND removed_by NOT LIKE '%|".$_SESSION['user']->Id()."' AND removed_by NOT LIKE '".$_SESSION['user']->Id()."|%' AND removed_by NOT LIKE '%|".$_SESSION['user']->Id()."|%' AND removed_by NOT LIKE '".$_SESSION['user']->Id()."'";
    break;
    default:
      $filter="(dest LIKE '%|".$_SESSION['user']->Id()."' OR dest LIKE '".$_SESSION['user']->Id()."|%' OR dest LIKE '%|".$_SESSION['user']->Id()."|%' OR dest LIKE '".$_SESSION['user']->Id();
      $filter.="' OR dest LIKE '%|".$_SESSION['user']->ClassId()."' OR dest LIKE '".$_SESSION['user']->ClassId()."|%' OR dest LIKE '%|".$_SESSION['user']->ClassId()."|%' OR dest LIKE '".$_SESSION['user']->ClassId();
      $filter.="' OR dest='school' LIKE '%|y".$_SESSION['user']->Year()."' OR dest LIKE 'y".$_SESSION['user']->Year()."|%' OR dest LIKE '%|y".$_SESSION['user']->Year()."|%' OR dest LIKE 'y".$_SESSION['user']->Year()."' OR uid=".$_SESSION['user']->Id().")";
      $filter.=" AND removed_by NOT LIKE '%|".$_SESSION['user']->Id()."' AND removed_by NOT LIKE '".$_SESSION['user']->Id()."|%' AND removed_by NOT LIKE '%|".$_SESSION['user']->Id()."|%' AND removed_by NOT LIKE '".$_SESSION['user']->Id()."'";
      break;

  }

  $man->listFiles($_SESSION['user'],$filter,'json');


}

?>
