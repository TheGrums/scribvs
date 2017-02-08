<?php

	if(!function_exists('loadClass'))require_once './config/db.php';
	session_start();
	require("./models/id.php");

	require("./controllers/thread.php");

?>
