<?php
header('content-type: application/json');
ob_start('ob_gzhandler');
header('Cache-Control: max-age=31536000, must-revalidate');
require("../config/db.php");
session_start();

if(isset($_SESSION["user"]) && isset($_POST['pid'])){
		$man = new CommentManager();
    $man->ListComments(" pid = ".intval($_POST['pid']), 0, 100, $_SESSION['user'], 'json');
}
else{
  die("Are u lost ?");
}

  ?>
