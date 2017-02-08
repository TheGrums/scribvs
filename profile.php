<?php
	//ini_set("display_errors",true);
	require("./config/db.php");
	require("./models/id.php");

	session_start();

	if(isset($_GET['q'])){

		if(isset($_SESSION['user'])&&$_SESSION['user']->Last()."-".$_SESSION['user']->First() == htmlentities($_GET['q'])){
			require("./controllers/private_profile.php");
		}
		else{
			$uman = new UserManager();
			if($user = $uman->getUserByUrl($_GET['q']))require("./controllers/public_profile.php");
			else require("./controllers/not_found.php");
		}

	}
	else if(isset($_SESSION['user'])){
		header("Location: ./profile.php?q=".$_SESSION['user']->Last()."-".$_SESSION['user']->First());
	}

?>
