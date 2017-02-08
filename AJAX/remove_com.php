<?php
	//ini_set("display_errors",true);
	require("../config/db.php");
	session_start();

	if(isset($_SESSION["user"]) && isset($_POST['id'])){

		$req = $bdd->prepare("SELECT * FROM comments WHERE id=:id;");
		$req->execute(array("id"=>intval($_POST['id'])));
		$data=$req->fetch();
    $com = new Comment($data);
		$man = new CommentManager();

    echo $man->Remove($com,$_SESSION['user']);


	}
	else{
		die("Are u lost ?");
	}

?>
