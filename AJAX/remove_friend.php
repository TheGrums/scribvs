<?php
  //ini_set("display_errors",true);
	require("../config/db.php");
	session_start();

	if(isset($_SESSION['user']) && isset($_POST['id'])){


    $_SESSION["user"]->FriendsGroup()->deleteMember(intval($_POST['id']));
    $man = new GroupManager();
    $man->Update($_SESSION["user"]->FriendsGroup());

	}
	else{
		die("Are u lost ?");
	}

?>
