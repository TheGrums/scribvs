<?php

ini_set("display_errors",true);
require "./config/db.php";
echo file_get_contents(GENERAL_PATH.'controllers/mail-top.html').file_get_contents(GENERAL_PATH.'controllers/default-mail-mid.php').file_get_contents(GENERAL_PATH.'controllers/mail-bot.html');
echo password_hash("Ae4bDy67qxJ9",PASSWORD_BCRYPT,['cost' => 10]);
?>
