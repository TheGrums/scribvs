<?php

//ini_set("display_errors",true);
require('./../../config/db.php');
require('../models/fonctions.php');

session_start();

$man = new TopicManager();
if(isset($_POST['action'])&&isset($_SESSION['user'])){

  switch($_POST['action']){

    case "list":
      if(!isset($_POST['like']))$man->listTopics("secid=".intval($_POST['secid'])." AND stid=".intval($_POST['stid']),"html",(bool)$_POST['formulas'],$_POST['last']);
      else $man->listTopics("secid=".intval($_POST['secid'])." AND stid=".intval($_POST['stid']),"html",(bool)$_POST['formulas'],0,20,"%".$_POST['like']."%");
    break;

    case "new":
      if(!isset($_POST['title'])||$_POST['title']==""){die("<span style='color:red;font-family:sniglet;font-size:10px;' class='hp'>Une erreur s'est produite, veuillez réessayer.</span>");}
      $man = new TopicManager();
      $topic = new Topic(array("aid"=>intval($_SESSION['user']->Id()),"secid"=>intval($_POST['secid']),"stid"=>intval($_POST['stid']),"title"=>htmlspecialchars($_POST['title']),"content"=>$_POST['content']));
      $man->Add($topic);
      echo "<span style='color:green;font-family:sniglet;font-size:10px;' class='hp'>Votre entrée a bien été ajoutée.</span>";
    break;

    case "delete":
      if(isset($_POST['id'])){
        $man = new TopicManager();
        $topic = $man->listTopics("id=".intval($_POST['id']),"normal",-1,0,1);
        echo $man->Remove($topic[0],$_SESSION['user']);
      }
    break;

    case "edit":
      if(isset($_POST['id'])&&isset($_POST['content'])){
        $man = new TopicManager();
        $topic = $man->listTopics("id=".intval($_POST['id']),"normal",-1,0,1);
        if($topic[0]->Aid()==$_SESSION['user']->Id())$topic[0]->setContent(killXss($_POST['content']));
        $man->Update($topic[0]);
        echo "<span style='color:green;font-size:10px;font-family:Sniglet;'>Modifications enregistrées.</span><br />";
      }
    break;

    case "close":
      if(isset($_POST['id'])){
        $man = new TopicManager();
        $topic = $man->listTopics("id=".intval($_POST['id']),"normal",-1,0,1);
        if($topic[0]->Id()==$_SESSION['user']->Id()||$_SESSION['user']->Id()>2)$topic[0]->setSolved(-1);
        $man->Update($topic[0]);
        echo 1;
      }
    break;

    case "solve":
      if(isset($_POST['id'])){
        $man = new TopicManager();
        $topic = $man->listTopics("id=".intval($_POST['id']),"normal",-1,0,1);
        if($topic[0]->Id()==$_SESSION['user']->Id()||$_SESSION['user']->Id()>2)$topic[0]->setSolved(1);
        $man->Update($topic[0]);
        echo 1;
      }
    break;

    case "reopen":
      if(isset($_POST['id'])){
        $man = new TopicManager();
        $topic = $man->listTopics("id=".intval($_POST['id']),"normal",-1,0,1);
        if($topic[0]->Id()==$_SESSION['user']->Id()||$_SESSION['user']->Id()>2)$topic[0]->setSolved(0);
        $man->Update($topic[0]);
        echo 1;
      }
    break;

  }

}

?>
