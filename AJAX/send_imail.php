<?php
//ini_set("display_errors",true);
require_once("../config/db.php");
require_once('../lib/phpmailer/PHPMailerAutoload.php');
session_start();

	if(isset($_SESSION["user"]) && ((isset($_POST['dest'])&&is_array($_POST['dest']))||(isset($_POST['destgr'])&&is_array($_POST['destgr']))) && isset($_POST['content'])){

    if(isset($_POST['dest'])&&count($_POST['dest'])>0)$sendto = $_POST['dest'];
		else $sendto=array();
    $man = new InternalMailManager();
		$uman = new UserManager();
		$gman = new GroupManager();

		for($i=0;$i<count($_POST['destgr']);$i++){
			$gr = $gman->getGroupById($_POST['destgr'][$i]);
			$sendto = array_merge($sendto,$gr->MembersArray());
		}

		$sendto = array_unique($sendto);

		for($i=0;$i<count($sendto);$i++){

      $imail = new InternalMail(array("aid"=>$_SESSION['user']->Id(),"content"=>killXSS($_POST['content']),"dest"=>$sendto[$i]));
      $man->Add($imail);
      echo $imail->getHtmlFormat($_SESSION['user']);
			$nfman = new NotifManager();
			$notif = new Notif(array(
	      "dest"=>$sendto[$i],
	      "content"=>'<button type="button" class="close"></button><strong>'.$_SESSION['user']->WholeName().'</strong><br /> vous à envoyé un message.<br /><span style="font-size:10px;opacity:.6;font-family:Sniglet;"> Consultez votre boîte mail ou rendez vous dans la section messages pour le lire.</span>',
	      "type"=>1
	    ));
	    $nfman->Add($notif);

			$us = $uman->getUserById($sendto[$i]);

			if($us->Level()>2)$msg_link="https://scribvs.com/panel/#3";
			else $msg_link="https://scribvs.com/messages.php#1";

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
			$mail->addCustomHeader('List-Unsubscribe', '<webmaster@scribvs.com>, <https://scribvs.com>');
			$mail->Username   = "webmaster@scribvs.com"; // SMTP account username
			$mail->Password   = "BigBang3640";
			$mail->AddReplyTo('no-reply@scribvs.com', 'Scribvs');
			$mail->AddAddress($us->Email(), $us->WholeName());
			$mail->SetFrom('info@scribvs.com', 'Messagerie Scribvs');
			$mail->CharSet = "UTF-8";
			$mail->Subject = $_SESSION['user']->WholeName().' vous a envoyé un message.';
			$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically

			$mailcontent = "

			<div style='Margin-left: 20px;Margin-right: 20px;'>

			  <h1 class='size-34' style='Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #4d5f94;font-size: 30px;line-height: 38px;font-family: Cinzel,Georgia,serif;text-align: center;' lang='x-size-34'><strong>Scribvs</strong></h1>
			  <h3 class='size-14' style='Margin-top: 20px;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #bccad1;font-size: 14px;line-height: 21px;font-family: Open Sans,sans-serif;text-align: center;' lang='x-size-14'><strong>&#8212; SYSTEME DE MESSAGERIE &#8212;</strong></h3>
			  <p class='size-15' style='Margin-top: 12px;Margin-bottom: 20px;font-size: 15px;line-height: 23px;min-height:300px;' lang='x-size-15'>
			  	".nl2br($_POST['content'])."
			  </p>
			</div>

			<div style='Margin-left: 20px;Margin-right: 20px;'>
				<div class='btn btn--flat btn--large' style='Margin-bottom: 20px;text-align: center;'>
					<![if !mso]><a style='border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #fff;background-color: #6a73bf;font-family: Merriweather, Georgia, serif;' href='".$msg_link."'>Accéder à ma messagerie</a><![endif]>
					<!--[if mso]><p style='line-height:0;margin:0;'>&nbsp;</p><v:roundrect xmlns:v='urn:schemas-microsoft-com:vml' href='".$msg_link."' style='width:206px' arcsize='9%' fillcolor='#6A73BF' stroke='f'><v:textbox style='mso-fit-shape-to-text:t' inset='0px,11px,0px,11px'><center style='font-size:14px;line-height:24px;color:#FFFFFF;font-family:Georgia,serif;font-weight:bold;mso-line-height-rule:exactly;mso-text-raise:4px'>Accéder à ma messagerie</center></v:textbox></v:roundrect><![endif]--></div>
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
	else{
		die("Are u lost ?");
	}

?>
