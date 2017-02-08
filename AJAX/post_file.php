<?php
//ini_set("display_errors",true);
header('content-type: application/json');
ob_start('ob_gzhandler');
header('Cache-Control: max-age=31536000, must-revalidate');

include_once("../config/db.php");
include_once("../models/functions.php");
require_once('../lib/phpmailer/PHPMailerAutoload.php');

session_start();

if(isset($_SESSION['user'])&&isset($_POST['dest'])){

  $dest_post = $_POST['dest'];

  switch($dest_post){
    case "file-year":
      $dest='y'.$_SESSION['user']->Year();
      break;
    case "file-friends":
      $dest=implode("|",$_SESSION['user']->FriendsArray());
      break;
    case "file-class":
      $dest=$_SESSION['user']->ClassId();
      break;
    case "file-group":
      if(isset($_POST['groups'])){
        $gman = new GroupManager();
        $arr=explode(',',$_POST['groups']);
        $dest=array();
        for($i=0;$i<count($arr);$i++){
          $tmpgroup=$gman->getGroupById($arr[$i]);
          $dest = array_merge($dest,$tmpgroup->MembersArray());
        }
        $dest = array_unique($dest);
        $dest=implode("|",$dest);
      }
      break;
  }


  $man = new FileManager();
  $uman = new UserManager();

  $paths = uploadFiles("files");

  if(!$paths){die(json_encode("error"));}

  for($i=0;$i<count($_FILES['files']['name']);$i++){

    $fl = new File(array(
      "name"=>$_FILES['files']['name'][$i],
      "path"=>substr($paths[$i],1),
      "suppressible"=>1,
      "uid"=>$_SESSION['user']->Id(),
      "dest"=>$dest
    ));
    $ext  = pathinfo(substr($paths[$i],1), PATHINFO_EXTENSION);
    $previews = array("avi","css","doc","html","mp3","pdf","png","ppt","psd","wav","xls","zip","paper");

    if(in_array(strtolower($ext),$previews)){
      $prev="./pictures/".$ext.".svg";
    }
    else{
      $prev="./pictures/cloud.svg";
    }
    $fl->setPreview($prev);
    $fid = $man->Add($fl);
    $fl->sendNotif(1);
    if($dest_post=="file-class"){

      $grman = new GroupManager();
      $group = $grman->getGroupByName($_SESSION['user']->ClassId());

      $members = $group->MembersArray();
      $nfman = new NotifManager();

      for($b=0;$b<count($members);$b++){

        if($members[$b]!=$_SESSION['user']->Id()){
          $notif = new Notif(array(
            "type"=>1,
            "dest"=>$members[$b],
            "content"=>'<button type="button" class="close"></button><strong>'.$_SESSION['user']->WholeName().'</strong> vous a envoyé un fichier. <br /><div class="container-fluid"><div class="row"><a href="'.substr($paths[$i],1).'" download="'.$_FILES['files']['name'][$i].'" target="_blank"><div class="col-sm-12 file-item" data-fl-id="'.$fid[0].'"><img src="'.$prev.'" style="width:20%;" /><br/><span style="color:blue;">'.$_FILES['files']['name'][$i].'</span></div></a></div></div></div>'
          ));

          $nfman->Add($notif);

          $u = $uman->getUserById($members[$b]);

          $mail = new PHPMailer(true);

          $mail->IsSMTP(); // telling the class to use SMTP
          $mail->SMTPOptions = array(
            'ssl' => array(
              'verify_peer' => false,
              'verify_peer_name' => false,
              'allow_self_signed' => true
            )
          );                 // enables SMTP debug information (for testing)
          $mail->SMTPAuth   = true;
          $mail->Host = 'scribvs.com';
          $mail->Port = 25;                  // set the SMTP port for the GMAIL server
          $mail->addCustomHeader('List-Unsubscribe', '<webmaster@scribvs.com>, <http://scribvs.com>');
          $mail->Username   = "webmaster@scribvs.com"; // SMTP account username
          $mail->Password   = "BigBang3640";
          $mail->AddReplyTo('no-reply@scribvs.com', 'Scribvs');
          $mail->AddAddress($u->Email(), $u->WholeName());
          $mail->SetFrom('notif-bot@scribvs.com', 'Notification Scribvs');
          $mail->CharSet = "UTF-8";
          $mail->Subject = $_SESSION["user"]->WholeName().' vous a envoyé un fichier.';
          $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically

          $mailcontent = "

          <div style='Margin-left: 20px;Margin-right: 20px;'>

          <h1 class='size-34' style='Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #4d5f94;font-size: 30px;line-height: 38px;font-family: Cinzel,Georgia,serif;text-align: center;' lang='x-size-34'><strong>Scribvs</strong></h1>
          <h3 class='size-14' style='Margin-top: 20px;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #bccad1;font-size: 14px;line-height: 21px;font-family: Open Sans,sans-serif;text-align: center;' lang='x-size-14'><strong>&#8212; SYSTEME DE NOTIFICATION &#8212;</strong></h3>
          <p class='size-15' style='Margin-top: 12px;Margin-bottom: 20px;font-size: 15px;line-height: 23px;' lang='x-size-15'>
          <strong>".$_SESSION["user"]->WholeName()."</strong> vous a envoyé un fichier intitulé <strong>".$_FILES['files']['name'][$i]."</strong> rendez vous dans l'onglet \"fichiers\" de la plateforme Scribvs pour le télécharger.<br />Si vous pensez que ce fichier ne respecte pas les conditions d'utilisations veuillez en faire part aux administrateurs du site.
          </p>
          </div>

          <div style='Margin-left: 20px;Margin-right: 20px;'>
          <div class='divider' style='display: block;font-size: 2px;line-height: 2px;Margin-left: auto;Margin-right: auto;width: 40px;background-color: #a2a5ca;Margin-bottom: 20px;'>&nbsp;</div>
          </div>

          <div style='Margin-left: 20px;Margin-right: 20px;'>
          <div class='btn btn--flat btn--large' style='Margin-bottom: 20px;text-align: center;'>
          <![if !mso]><a style='border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #fff;background-color: #6a73bf;font-family: Merriweather, Georgia, serif;' href='https://scribvs.com/files.php'>Télécharger</a><![endif]>
          <!--[if mso]><p style='line-height:0;margin:0;'>&nbsp;</p><v:roundrect xmlns:v='urn:schemas-microsoft-com:vml' href='https://scribvs.com/files.php' style='width:206px' arcsize='9%' fillcolor='#6A73BF' stroke='f'><v:textbox style='mso-fit-shape-to-text:t' inset='0px,11px,0px,11px'><center style='font-size:14px;line-height:24px;color:#FFFFFF;font-family:Georgia,serif;font-weight:bold;mso-line-height-rule:exactly;mso-text-raise:4px'>Télécharger</center></v:textbox></v:roundrect><![endif]--></div>
            </div>
          <div style='Margin-left: 20px;Margin-right: 20px;Margin-bottom: 12px;'>
          <div style='line-height:5px;font-size:1px'>&nbsp;</div>
          </div>

          </div>


          ";
          $mc = file_get_contents('http://scribvs.com/controllers/mail-top.html').$mailcontent.file_get_contents('http://scribvs.com/controllers/mail-bot.html');
          $mail->MsgHTML($mc); // attachment
          $mail->Send();


        }

      }

    }
    else if($dest_post=="file-friends"||$dest_post=="file-group"){

      if($dest_post=="file-friends")$friends = $_SESSION['user']->FriendsArray();
      else $friends = explode("|",$dest);
      $nfman = new NotifManager();
      for($b=0;$b<count($friends);$b++){
        $notif = new Notif(array(
          "type"=>1,
          "dest"=>$friends[$b],
          "content"=>'<button type="button" class="close"></button><strong>'.$_SESSION['user']->WholeName().'</strong> vous a envoyé un fichier. <br /><div class="container-fluid"><div class="row"><a href="'.substr($paths[$i],1).'" download="'.$_FILES['files']['name'][$i].'" target="_blank"><div class="col-sm-12 file-item" data-fl-id="'.$fid[0].'"><img src="'.$prev.'" style="width:20%;" /><br/><span style="color:blue;">'.$_FILES['files']['name'][$i].'</span></div></a></div></div></div>'
        ));
        $nfman->Add($notif);

        $u = $uman->getUserById($friends[$b]);

        $mail = new PHPMailer(true);

        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPOptions = array(
          'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
          )
        );                 // enables SMTP debug information (for testing)
        $mail->SMTPAuth   = true;
        $mail->Host = 'scribvs.com';
        $mail->Port = 25;                  // set the SMTP port for the GMAIL server
        $mail->addCustomHeader('List-Unsubscribe', '<webmaster@scribvs.com>, <http://scribvs.com>');
        $mail->Username   = "webmaster@scribvs.com"; // SMTP account username
        $mail->Password   = "BigBang3640";
        $mail->AddReplyTo('no-reply@scribvs.com', 'Scribvs');
        $mail->AddAddress($u->Email(), $u->WholeName());
        $mail->SetFrom('notif-bot@scribvs.com', 'Notification Scribvs');
        $mail->CharSet = "UTF-8";
        $mail->Subject = $_SESSION["user"]->WholeName().' vous a envoyé un fichier.';
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically

        $mailcontent = "

        <div style='Margin-left: 20px;Margin-right: 20px;'>

        <h1 class='size-34' style='Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #4d5f94;font-size: 30px;line-height: 38px;font-family: Cinzel,Georgia,serif;text-align: center;' lang='x-size-34'><strong>Scribvs</strong></h1>
        <h3 class='size-14' style='Margin-top: 20px;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #bccad1;font-size: 14px;line-height: 21px;font-family: Open Sans,sans-serif;text-align: center;' lang='x-size-14'><strong>&#8212; SYSTEME DE NOTIFICATION &#8212;</strong></h3>
        <p class='size-15' style='Margin-top: 12px;Margin-bottom: 20px;font-size: 15px;line-height: 23px;' lang='x-size-15'>
        <strong>".$_SESSION["user"]->WholeName()."</strong> vous a envoyé un fichier intitulé <strong>".$_FILES['files']['name'][$i]."</strong> rendez vous dans l'onglet \"fichiers\" de la plateforme Scribvs pour le télécharger.<br />Si vous pensez que ce fichier ne respecte pas les conditions d'utilisations veuillez en faire part aux administrateurs du site.
        </p>
        </div>

        <div style='Margin-left: 20px;Margin-right: 20px;'>
        <div class='divider' style='display: block;font-size: 2px;line-height: 2px;Margin-left: auto;Margin-right: auto;width: 40px;background-color: #a2a5ca;Margin-bottom: 20px;'>&nbsp;</div>
        </div>

        <div style='Margin-left: 20px;Margin-right: 20px;'>
        <div class='btn btn--flat btn--large' style='Margin-bottom: 20px;text-align: center;'>
        <![if !mso]><a style='border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #fff;background-color: #6a73bf;font-family: Merriweather, Georgia, serif;' href='https://scribvs.com/files.php'>Télécharger</a><![endif]>
        <!--[if mso]><p style='line-height:0;margin:0;'>&nbsp;</p><v:roundrect xmlns:v='urn:schemas-microsoft-com:vml' href='https://scribvs.com/files.php' style='width:206px' arcsize='9%' fillcolor='#6A73BF' stroke='f'><v:textbox style='mso-fit-shape-to-text:t' inset='0px,11px,0px,11px'><center style='font-size:14px;line-height:24px;color:#FFFFFF;font-family:Georgia,serif;font-weight:bold;mso-line-height-rule:exactly;mso-text-raise:4px'>Télécharger</center></v:textbox></v:roundrect><![endif]--></div>
          </div>
        <div style='Margin-left: 20px;Margin-right: 20px;Margin-bottom: 12px;'>
        <div style='line-height:5px;font-size:1px'>&nbsp;</div>
        </div>

        </div>


        ";
        $mc = file_get_contents('http://scribvs.com/controllers/mail-top.html').$mailcontent.file_get_contents('http://scribvs.com/controllers/mail-bot.html');
        $mail->MsgHTML($mc); // attachment
        $mail->Send();


      }

    }
    else if($dest_post=="file-year"){

      $grman = new GroupManager();
      $groupsarray = $grman->getGroups("LOWER(name) LIKE '".$_SESSION['user']->Year()."%'");

      for($m=0;$m<count($groupsarray);$m++){

      $group = $groupsarray[$m];
      $members = $group->MembersArray();
      $nfman = new NotifManager();

      for($b=0;$b<count($members);$b++){

        if($members[$b]!=$_SESSION['user']->Id()){
          $notif = new Notif(array(
            "type"=>1,
            "dest"=>$members[$b],
            "content"=>'<button type="button" class="close"></button><strong>'.$_SESSION['user']->WholeName().'</strong> vous a envoyé un fichier. <br /><div class="container-fluid"><div class="row"><a href="'.substr($paths[$i],1).'" download="'.$_FILES['files']['name'][$i].'" target="_blank"><div class="col-sm-12 file-item" data-fl-id="'.$fid[0].'"><img src="'.$prev.'" style="width:20%;" /><br/><span style="color:blue;">'.$_FILES['files']['name'][$i].'</span></div></a></div></div></div>'
          ));
          $nfman->Add($notif);

          $u = $uman->getUserById($members[$b]);

          $mail = new PHPMailer(true);

          $mail->IsSMTP(); // telling the class to use SMTP
          $mail->SMTPOptions = array(
            'ssl' => array(
              'verify_peer' => false,
              'verify_peer_name' => false,
              'allow_self_signed' => true
            )
          );                 // enables SMTP debug information (for testing)
          $mail->SMTPAuth   = true;
          $mail->Host = 'scribvs.com';
          $mail->Port = 25;                  // set the SMTP port for the GMAIL server
          $mail->addCustomHeader('List-Unsubscribe', '<webmaster@scribvs.com>, <http://scribvs.com>');
          $mail->Username   = "webmaster@scribvs.com"; // SMTP account username
          $mail->Password   = "BigBang3640";
          $mail->AddReplyTo('no-reply@scribvs.com', 'Scribvs');
          $mail->AddAddress($u->Email(), $u->WholeName());
          $mail->SetFrom('notif-bot@scribvs.com', 'Notification Scribvs');
          $mail->CharSet = "UTF-8";
          $mail->Subject = $_SESSION["user"]->WholeName().' vous a envoyé un fichier.';
          $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically

          $mailcontent = "

          <div style='Margin-left: 20px;Margin-right: 20px;'>

          <h1 class='size-34' style='Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #4d5f94;font-size: 30px;line-height: 38px;font-family: Cinzel,Georgia,serif;text-align: center;' lang='x-size-34'><strong>Scribvs</strong></h1>
          <h3 class='size-14' style='Margin-top: 20px;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #bccad1;font-size: 14px;line-height: 21px;font-family: Open Sans,sans-serif;text-align: center;' lang='x-size-14'><strong>&#8212; SYSTEME DE NOTIFICATION &#8212;</strong></h3>
          <p class='size-15' style='Margin-top: 12px;Margin-bottom: 20px;font-size: 15px;line-height: 23px;' lang='x-size-15'>
          <strong>".$_SESSION["user"]->WholeName()."</strong> vous a envoyé un fichier intitulé <strong>".$_FILES['files']['name'][$i]."</strong> rendez vous dans l'onglet \"fichiers\" de la plateforme Scribvs pour le télécharger.<br />Si vous pensez que ce fichier ne respecte pas les conditions d'utilisations veuillez en faire part aux administrateurs du site.
          </p>
          </div>

          <div style='Margin-left: 20px;Margin-right: 20px;'>
          <div class='divider' style='display: block;font-size: 2px;line-height: 2px;Margin-left: auto;Margin-right: auto;width: 40px;background-color: #a2a5ca;Margin-bottom: 20px;'>&nbsp;</div>
          </div>

          <div style='Margin-left: 20px;Margin-right: 20px;'>
          <div class='btn btn--flat btn--large' style='Margin-bottom: 20px;text-align: center;'>
          <![if !mso]><a style='border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #fff;background-color: #6a73bf;font-family: Merriweather, Georgia, serif;' href='https://scribvs.com/files.php'>Télécharger</a><![endif]>
          <!--[if mso]><p style='line-height:0;margin:0;'>&nbsp;</p><v:roundrect xmlns:v='urn:schemas-microsoft-com:vml' href='https://scribvs.com/files.php' style='width:206px' arcsize='9%' fillcolor='#6A73BF' stroke='f'><v:textbox style='mso-fit-shape-to-text:t' inset='0px,11px,0px,11px'><center style='font-size:14px;line-height:24px;color:#FFFFFF;font-family:Georgia,serif;font-weight:bold;mso-line-height-rule:exactly;mso-text-raise:4px'>Télécharger</center></v:textbox></v:roundrect><![endif]--></div>
            </div>
          <div style='Margin-left: 20px;Margin-right: 20px;Margin-bottom: 12px;'>
          <div style='line-height:5px;font-size:1px'>&nbsp;</div>
          </div>

          </div>


          ";
          $mc = file_get_contents('http://scribvs.com/controllers/mail-top.html').$mailcontent.file_get_contents('http://scribvs.com/controllers/mail-bot.html');
          $mail->MsgHTML($mc); // attachment
          $mail->Send();

        }

      }

      }

    }

  }
  $man->listFiles($_SESSION['user'],"uid=".$_SESSION['user']->Id(),"json"," limit ".(count($_FILES['files']['name'])));

}

?>
