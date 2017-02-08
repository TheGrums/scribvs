<?php
if(!function_exists('loadClass'))require_once '../config/db.php';
session_start();


if(isset($_SESSION['user'])&&isset($_POST['id'])&&isset($_POST['content'])){

  $req = $bdd->prepare("SELECT * FROM comments WHERE id=:id ;");
  $req->execute(array("id"=>$_POST['id']));
  $data = $req->fetch();

  $com = new Comment($data);
  $com->setContent(killXss($_POST['content']));
  $man = new CommentManager();
  $man->Update($com);

  echo 1;

}
echo 0;
?>
