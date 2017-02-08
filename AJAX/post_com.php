<?php

header('content-type: application/json');
ob_start('ob_gzhandler');
header('Cache-Control: max-age=31536000, must-revalidate');
require("../config/db.php");
session_start();

	if(isset($_SESSION["user"]) && isset($_POST['pid']) && isset($_POST['content'])){

		$comment = new Comment(array(
			"uid"=>$_SESSION['user']->Id(),
			"pid"=>intval($_POST['pid']),
			"content"=>nl2br(htmlspecialchars($_POST['content']))
		));
		$man = new CommentManager();
		$man->Add($comment);
		$man->ListComments(" uid=".$_SESSION['user']->Id()." ", 0, 1, $_SESSION['user'], "json");

  }
  else{
    die("Are u lost ?");
  }

?>
