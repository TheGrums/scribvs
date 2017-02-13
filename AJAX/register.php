<?php
	//ini_set("display_errors",true);

	if(!function_exists('loadClass'))require_once '../config/db.php';
	include('../models/functions.php');
	require_once('../lib/phpmailer/PHPMailerAutoload.php');

	session_start();
	ob_start();

	if(count($_POST) == 7){


		$first = htmlentities($_POST['firstname']);
		$name = htmlentities($_POST['name']);
		$mail = htmlentities($_POST['email']);
		$auth_id = htmlentities($_POST['auth_id']);
		$class = htmlentities($_POST['class-id']);
		$pass = htmlentities($_POST['pass1']);
		$level=authKey($auth_id,$bdd);

		if($level){
		$us=new User(array(
			"first_name"=>$first,
			"name"=>$name,
			"e_mail"=>$mail,
			"lesson"=>"",
			"class"=>$class,
			"pass"=>password_hash($pass,PASSWORD_BCRYPT,['cost' => 10]),
			"level"=>$level,
			"sessid"=>2,
			"ip"=>$_SERVER['REMOTE_ADDR'],
			"img"=>"./pictures/default.jpg"
		));

		$man=new UserManager();

		echo $man->Add($us);

		$grman = new GroupManager();
		$friends = new Group(array(
			"name"=>'Amis de '.$first.' '.$name,
			"members"=>"",
			"aid"=>$us->Id()
		));
		$grman->Add($friends);

		$us->setFriends((string)$friends->Id());

		$man->Update($us);

		$us->CreateCookie();

		$grman = new GroupManager();
		$group = $grman->getGroupByName($class);

		$sub = 'Confirmation d\'inscription.';
		$mailcontent = "

		<div style='Margin-left: 20px;Margin-right: 20px;'>

		  <h1 class='size-34' style='Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #4d5f94;font-size: 30px;line-height: 38px;font-family: Cinzel,Georgia,serif;text-align: center;' lang='x-size-34'><strong>Scribvs</strong></h1>
		  <h3 class='size-14' style='Margin-top: 20px;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #bccad1;font-size: 14px;line-height: 21px;font-family: Open Sans,sans-serif;text-align: center;' lang='x-size-14'><strong>&#8212; L'AVENIR, C'EST VOUS !&#8212;</strong></h3>
		  <p class='size-15' style='Margin-top: 12px;Margin-bottom: 20px;font-size: 15px;line-height: 23px;' lang='x-size-15'>
		    Votre inscription sur la plateforme www.scribvs.com a bien été prise en compte, c'est un <strong>plaisir</strong> de pouvoir vous compter parmi ses membres.<br />Le simple fait de vous inscrire honore notre travail et nous vous en sommes reconnaissants...<br /><br /> Quel que soit votre ressenti, il nous est précieux et nous vous invitons à nous en faire part car en effet, c'est <strong>VOUS</strong> qui rendez tout ceci possible.
				<br />Si vous avez quelque talent que vous désirez mettre à contribution pour faire progresser le projet, libre à vous de nous contacter pour nous faire part de votre motivation. Une simple idée peut suffire à justifier ce geste. <br />Quoi qu'il en soit, nous espérons que vous serez satisfait par l'utilisation de nos services.
		  </p>
		</div>

		";
		sendMail($us,$sub,$mailcontent);

		if(!$group){
			$group = new Group(array(
				"name"=>$class,
				"members"=>$us->Id(),
				"aid"=>-1
			));
			$grman->Add($group);
		}
		else{
			$group->AddMember($us->Id());
			$grman->Update($group);
		}

		$req=$bdd->prepare("DELETE FROM auth_keys WHERE akey=:akey ;");
		$req->execute(array("akey"=>$auth_id));

		}

	}





?>
