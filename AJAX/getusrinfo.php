<?php
	header('content-type: application/json');
    ob_start('ob_gzhandler');
    header('Cache-Control: max-age=31536000, must-revalidate');
	require_once("../config/db.php");
	session_start();

	if(isset($_SESSION["user"])){

    echo $_SESSION["user"]->getJsonFormat();

  }

?>
