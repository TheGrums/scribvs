<?php

		session_start();

		if(!function_exists('loadClass'))require_once '../config/db.php';

		$datarray = explode('----',$_COOKIE['sessid']);
		$count = $bdd -> prepare("SELECT * FROM accounts WHERE sessid = :uniqid ;");
		$count->execute(array("uniqid"=>$datarray[3]));
		if($count->rowCount()!=0){
			$data=$count->fetch();
			$us = new User($data);
			$result = $us->compareCookie($datarray[3], $datarray[0], $datarray[1], $datarray[2]);
		}
		else{
		  setcookie('sessid', NULL, time(), "/", null, false, true);
		}




?>
