<?php
	require("../config/db.php");
	session_start();

	if(isset($_SESSION["user"]) && isset($_POST['id'])){

		$req = $bdd->prepare("SELECT * FROM posts WHERE id=:id;");
		$req->execute(array("id"=>intval($_POST['id'])));
		$data=$req->fetch();
    $post = new Post($data);
		$man = new PostManager();

    echo $man->Remove($post,$_SESSION['user']);


	}
	else{
		die("Une erreur s'est produite, veuillez réessayer.");
	}

?>
