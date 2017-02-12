<?php
ob_start();
session_start();
setcookie('sessid', NULL, time(), "/", null, false, true);
session_unset();
header("Location: ./index.php");
?>
