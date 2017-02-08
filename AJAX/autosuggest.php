<?php
//ini_set("display_errors",true);
header('content-type: application/json');
ob_start('ob_gzhandler');
header('Cache-Control: max-age=31536000, must-revalidate');
if(!function_exists('loadClass'))require_once '../config/db.php';
session_start();


if(isset($_SESSION['user'])&&isset($_POST['q'])){

  $man = new UserManager();

  if(!isset($_POST["add"])||$_POST["add"]=="")$man->getSuggestions($_SESSION['user'],$_POST['q']);
  else if(isset($_POST["add"])&&$_POST["add"]=="only-bigger")$man->getSuggestions($_SESSION['user'],$_POST['q'],"AND level>".$_SESSION["user"]->Level());

}
else{
  echo json_encode(array('status'=>false));
}
?>
