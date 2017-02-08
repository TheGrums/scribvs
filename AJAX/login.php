<?php
//ini_set("display_errors",true);

if(!function_exists('loadClass'))require_once '../config/db.php';
include('../models/functions.php');

session_start();
ob_start();

if(isset($_POST["mail"])&&$_POST["mail"]!=""&&isset($_POST["pass"])&&$_POST["pass"]!=""){

  $uman = new UserManager();
  $u = $uman->getUserByMail($_POST["mail"]);

  if(!$u)echo "-1";
  else if(password_verify($_POST["pass"],$u->Pass())){
    $u->setIp($_SERVER["REMOTE_ADDR"]);
    $uman->Update($u);
    $u->CreateCookie();
    echo "1";
  }
  else echo "0";

}
else echo "-2";
?>
