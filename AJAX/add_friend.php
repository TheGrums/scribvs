<?php
header('content-type: application/json');
ob_start('ob_gzhandler');
header('Cache-Control: max-age=31536000, must-revalidate');
//ini_set("display_errors",true);
if(!function_exists('loadClass'))require_once '../config/db.php';
require_once('../lib/phpmailer/PHPMailerAutoload.php');
session_start();


if(isset($_SESSION['user'])&&isset($_POST['id'])&&is_numeric($_POST['id'])){

  $friendsleft = $_SESSION['user']->FriendsGroup()->FriendsLeft();

  if($friendsleft>0&&$_POST['id']!=$_SESSION['user']->Id()){
    $_SESSION['user']->FriendsGroup()->addMember(intval($_POST['id']));

    $uman = new UserManager();
    $u = $uman->getUserById(intval($_POST['id']));
    if($u){
      $man = new GroupManager();
      $man->Update($_SESSION['user']->FriendsGroup());

      $nfman = new NotifManager();
      $notif = new Notif(array(
        "dest"=>intval($_POST['id']),
        "content"=>'<button type="button" class="close"></button><strong>'.$_SESSION['user']->WholeName().'</strong><br /> vous a ajouté à son groupe d\'amis.<br /><span style="font-size:10px;opacity:.6;font-family:Sniglet;"> Vous pouvez à présent suivre ses publications.</span>',
        "type"=>4
      ));
      $nfman->Add($notif);
      $sub = $_SESSION["user"]->WholeName().' vous a ajouté à son groupe d\'amis';
      $mailcontent = "

        <div style='Margin-left: 20px;Margin-right: 20px;'>

        <h1 class='size-34' style='Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #4d5f94;font-size: 30px;line-height: 38px;font-family: Cinzel,Georgia,serif;text-align: center;' lang='x-size-34'><strong>Scribvs</strong></h1>
        <h3 class='size-14' style='Margin-top: 20px;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #bccad1;font-size: 14px;line-height: 21px;font-family: Open Sans,sans-serif;text-align: center;' lang='x-size-14'><strong>&#8212; SYSTEME DE NOTIFICATION &#8212;</strong></h3>
        <p class='size-15' style='Margin-top: 12px;Margin-bottom: 20px;font-size: 15px;line-height: 23px;' lang='x-size-15'>
        ".$_SESSION["user"]->WholeName()." vous a ajouté à son groupe d'amis, cela signifie que vous pourrez voir les publications qu'il poste pour ses amis.<br /> Pour qu'il puisse voir les vôtres il vous suffit de l'ajouter à votre propre groupe.
        </p>
        </div>

        <div style='Margin-left: 20px;Margin-right: 20px;'>
        <div class='divider' style='display: block;font-size: 2px;line-height: 2px;Margin-left: auto;Margin-right: auto;width: 40px;background-color: #a2a5ca;Margin-bottom: 20px;'>&nbsp;</div>
        </div>

        <div style='Margin-left: 20px;Margin-right: 20px;'>
        <div class='btn btn--flat btn--large' style='Margin-bottom: 20px;text-align: center;'>
        <![if !mso]><a style='border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #fff;background-color: #6a73bf;font-family: Merriweather, Georgia, serif;' href='https://scribvs.com/profile.php?q=".$u->Last()."-".$u->First()."&d=friends'>Gérer mes amis</a><![endif]>
          <!--[if mso]><p style='line-height:0;margin:0;'>&nbsp;</p><v:roundrect xmlns:v='urn:schemas-microsoft-com:vml' href='https://scribvs.com/profile.php?q=".$u->Last()."-".$u->First()."&d=friends' style='width:206px' arcsize='9%' fillcolor='#6A73BF' stroke='f'><v:textbox style='mso-fit-shape-to-text:t' inset='0px,11px,0px,11px'><center style='font-size:14px;line-height:24px;color:#FFFFFF;font-family:Georgia,serif;font-weight:bold;mso-line-height-rule:exactly;mso-text-raise:4px'>Gérer mes amis</center></v:textbox></v:roundrect><![endif]--></div>
            </div>

            <div style='Margin-left: 20px;Margin-right: 20px;Margin-bottom: 12px;'>
            <div style='line-height:5px;font-size:1px'>&nbsp;</div>
            </div>

            </div>
      ";
      sendMail($u,$sub,$mailcontent);
      echo true;
    }
    else echo false;
  }
  else{
    echo false;
  }

}
?>
