<?php
//ini_set("display_errors",true);
ob_start();
session_start();

if(isset($_COOKIE['sessid']) || isset($_SESSION['co_elements'])){

	if(!isset($_SESSION['co_elements'])){

		require("./AJAX/decode_cookie.php");

		if($result==-1){
			require("./controllers/suspended.php");
			die();
		}
		else if($result==0){
			header("Location: ./welcome.php");
			die();
		}

	}

}
else{
	header("Location: ./welcome.php");
	die();
}

?>
