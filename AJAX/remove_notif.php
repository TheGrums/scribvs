<?php
ini_set("display_errors",true);
require_once("../config/db.php");
session_start();

if(isset($_SESSION['user'])&&isset($_POST['id'])){

  if(isset($_POST['type'])&&$_POST['type']=="delete-citation"){
    $man = new PostManager();
    $posts = $man->ListPosts("id=".$_POST['id'],0,1,$_SESSION['user']);
    $combi=$_SESSION['user']->Combinaisons();
    print_r($posts);
    $posts[0]->setContent(str_ireplace($combi,"<a href='./profile.php?q=".$_SESSION['user']->Last().'-'.$_SESSION['user']->First()."'>".$_SESSION['user']->WholeName()."</a>",$posts[0]->Content()));
    $man->Update($posts[0]);
  }

  else{
    $req = $bdd->prepare("SELECT * FROM notifs WHERE id=:id;");
    $req->execute(array("id"=>intval($_POST['id'])));
    $data=$req->fetch();
    $nf = new Notif($data);
    $man = new NotifManager();

    echo $man->Remove($nf,$_SESSION['user']);
  }
}



?>
