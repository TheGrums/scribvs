<?php
if(!function_exists('loadClass'))require_once '../config/db.php';
include('../models/functions.php');
require_once('../lib/phpmailer/PHPMailerAutoload.php');

if(!isset($_POST["code"])||!isset($_COOKIE["recPass"]))die("0"); // Avoid segfault

$id = $_POST["code"];
$cryptedid = $_COOKIE["recPass"];

//  Simplest way
if(password_verify($id, $cryptedid)){

  //  Delete cookie
  setcookie('recPass', NULL, time(), "/", null, false, true);

  //  Identity verified the tmpuser IS the user
  $_SESSION["user"] = $_SESSION["tmpuser"];
  $_SESSION["tmpuser"] = null;
  echo "1";

}
else echo "0";

?>
