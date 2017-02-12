<?php

ini_set("display_errors",true);
require "./config/db.php";
session_start();
sendMail($_SESSION['user'],"test","test");

?>
