<?php
//ini_set("display_errors",true);
if(!function_exists('loadClass'))require_once '../config/db.php';
session_start();

if(isset($_SESSION['user']) && isset($_POST['pid'])){


	if($_POST['todo'] == "more"){

		$pst = $bdd->prepare('SELECT aid FROM posts WHERE id=:id');
		$pst->execute(array("id"=>$_POST['pid']));
		$data = $pst->fetch();
		$request = $bdd->prepare('INSERT INTO `heart`(`id`, `pid`, `uid`) VALUES ( NULL, :pid, :uid);');
		$request->execute(array("pid"=>$_POST['pid'], "uid"=>$_SESSION['user']->Id()));
		if($data['aid']!=$_SESSION['user']->Id()){
		$nfman = new NotifManager();
		$notif = new Notif(array(
			"type"=>3,
			"dest"=>$data['aid'],
			"content"=>"<strong>".$_SESSION['user']->WholeName()."</strong> à aimé votre publication<br /><br /><button class='btn btn-primary publication-spoiler' data-pub-id='".$_POST['pid']."'>Voir la publication.</button>"
			));
		$nfman->Add($notif);
		}

	}
	else if ($_POST['todo'] == "min"){
		$request = $bdd->prepare('DELETE FROM `heart` WHERE pid=:pid AND uid=:uid');
		$request->execute(array("pid"=>$_POST['pid'], "uid"=>$_SESSION['co_elements']['uid']));
	}
	else{
		die("Are u lost ?");
	}

}
else{
	die("Are u lost ?");
}

?>
