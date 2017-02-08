<?php

//ini_set("display_errors",true);
require('./../../config/db.php');
require('../models/fonctions.php');

session_start();

$man = new TopicManager();
if(isset($_POST['action'])&&isset($_SESSION['user'])){
  switch($_POST['action']){

    case "new":

    break;

    case "delete":
      if(isset($_POST['id'])){
        $man = new TopicMessageManager();
        $message = $man->getTopicMessage(intval($_POST['id']));
        echo $man->Remove($message,$_SESSION['user']);
      }
    break;

    case "edit":
      if(isset($_POST['id'])&&isset($_POST['content'])){
        $man = new TopicMessageManager();
        $message = $man->getTopicMessage(intval($_POST['id']));
        if($message->Aid()==$_SESSION['user']->Id())$message->setContent(wordsFilter($_POST['content']));
        $man->Update($message);
        echo "<span style='color:green;font-size:10px;font-family:Sniglet;'>Modifications enregistrées.</span><br />";
      }
    break;
  }

}

?>
