<?php

ini_set("display_errors",true);
require "./config/db.php";
echo file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'controllers/mail-top.html').file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'controllers/default-mail-mid.php').file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'controllers/mail-bot.html');
?>
