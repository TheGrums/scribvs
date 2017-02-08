<?php
	//ini_set("display_errors",true);
	header('content-type: application/json');
  ob_start('ob_gzhandler');
  header('Cache-Control: max-age=31536000, must-revalidate');
	require_once("../config/db.php");
	session_start();

	if(isset($_SESSION["user"])&&(isset($_POST["gid"])||isset($_POST["gname"]))){

		$gid = $_POST['gid'];

		if(isset($_POST["gname"])){
			$gman = new GroupManager();
			$group = $gman->getGroupByName($_POST["gname"]);
			$gid = $group->Id();
		}
    $man = new UserManager();
    $man->getUsersByGroup(intval($gid),$_SESSION["user"]);

  }

?>
