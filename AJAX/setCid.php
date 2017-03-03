<?php
if(!function_exists('loadClass'))require_once '../config/db.php';
include('../models/functions.php');
require_once('../lib/phpmailer/PHPMailerAutoload.php');

if(!isset($_POST["mail"]))die("0"); // Avoid segfault

$uman = new UserManager();
$u = $uman->getUserByMail($_POST["mail"]);

if($u){

  //  Storing user in session
  $_SESSION["tmpuser"] = $u;

  //  Generating code
  $id = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(6/strlen($x)) )),1,6);

  //  Creating cookie
  setcookie('recPass', password_hash($id,PASSWORD_BCRYPT,['cost' => 6]), time()+3600, "/", null, false, true);
  if(LOCAL)echo $id;

  //  Creating and sending mail
  $sub = 'Récupération de mot de passe';
  $mailcontent = "

  <div style='Margin-left: 20px;Margin-right: 20px;'>

    <h1 class='size-34' style='Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #4d5f94;font-size: 30px;line-height: 38px;font-family: Cinzel,Georgia,serif;text-align: center;' lang='x-size-34'><strong>Scribvs</strong></h1>
    <h3 class='size-14' style='Margin-top: 20px;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #bccad1;font-size: 14px;line-height: 21px;font-family: Open Sans,sans-serif;text-align: center;' lang='x-size-14'><strong>&#8212; VOICI VOTRE CODE &#8212;</strong></h3>
    <p class='size-15' style='Margin-top: 12px;Margin-bottom: 20px;font-size: 15px;line-height: 23px;text-align: center;' lang='x-size-15'>
      ".$id."
    </p>
  </div>

  ";
  sendMail($u,$sub,$mailcontent);
}
else echo "0";

?>
