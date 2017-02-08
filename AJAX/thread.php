<?php
//ini_set("display_errors",true);
//header('content-type: application/json');
//ob_start('ob_gzhandler');
//header('Cache-Control: max-age=31536000, must-revalidate');
require_once("../config/db.php");
session_start();

if(isset($_SESSION["user"])&& isset($_POST['begin']) && isset($_POST['nb'])&& isset($_POST['place'])){

	$man = new PostManager();

	if(is_string($_POST['place'])){
		switch ($_POST['place']){
			case "target-post":
				$filter = "id=".intval($_POST['id']);
				break;
			case "profile":
				$filter="level!=0 AND aid=".$_SESSION['user']->Id();
				break;
			case "thread-page":
				$filter="level!=0 AND (dest LIKE '%|".$_SESSION['user']->Id()."' OR dest LIKE '".$_SESSION['user']->Id()."|%' OR dest LIKE '%|".$_SESSION['user']->Id()."|%' OR dest LIKE '".$_SESSION['user']->Id();
				$filter.="' OR dest LIKE '%|".$_SESSION['user']->ClassId()."' OR dest LIKE '".$_SESSION['user']->ClassId()."|%' OR dest LIKE '%|".$_SESSION['user']->ClassId()."|%' OR dest LIKE '".$_SESSION['user']->ClassId();
				$filter.="' OR dest='school' OR dest LIKE '%|y".$_SESSION['user']->Year()."' OR dest LIKE 'y".$_SESSION['user']->Year()."|%' OR dest LIKE '%|y".$_SESSION['user']->Year()."|%' OR dest LIKE 'y".$_SESSION['user']->Year()."' OR aid = ".$_SESSION['user']->Id().")";
				if($_SESSION['user']->Level()>3)$filter="level!=0";
				break;
			case "class-page":
				$filter="level!=0 AND (dest='school' OR dest LIKE '%|y".$_SESSION['user']->Year()."' OR dest LIKE 'y".$_SESSION['user']->Year()."|%' OR dest LIKE '%|y".$_SESSION['user']->Year()."|%' OR dest LIKE '".$_SESSION['user']->Year();
				$filter.="' OR dest LIKE '%|".$_SESSION['user']->ClassId()."' OR dest LIKE '".$_SESSION['user']->ClassId()."|%' OR dest LIKE '%|".$_SESSION['user']->ClassId()."|%' OR dest LIKE '".$_SESSION['user']->ClassId()."')";
				break;
			case "pbprofile":
				if(isset($_POST["user"])){
					$filter="level!=0 AND aid=".intval($_POST["user"])." AND (dest LIKE '%|".$_SESSION['user']->Id()."' OR dest LIKE '".$_SESSION['user']->Id()."|%' OR dest LIKE '%|".$_SESSION['user']->Id()."|%' OR dest LIKE '".$_SESSION['user']->Id();
					$filter.="' OR dest LIKE '%|".$_SESSION['user']->ClassId()."' OR dest LIKE '".$_SESSION['user']->ClassId()."|%' OR dest LIKE '%|".$_SESSION['user']->ClassId()."|%' OR dest LIKE '".$_SESSION['user']->ClassId();
					$filter.="' OR dest='school' OR dest LIKE '%|y".$_SESSION['user']->Year()."' OR dest LIKE 'y".$_SESSION['user']->Year()."|%' OR dest LIKE '%|y".$_SESSION['user']->Year()."|%' OR dest LIKE 'y".$_SESSION['user']->Year()."' OR aid = ".$_SESSION['user']->Id().")";
					if($_SESSION['user']->Level()>3)$filter="level!=0";
					break;
				}
				else{
					$filter="level=-9999";
				}
			break;
		}
	}
	if(isset($_POST['refreshfrom'])){$filter.=" AND id>".intval($_POST['refreshfrom']);}
	$posts = $man->ListPosts($filter,$_POST['begin'],$_POST['nb'],$_SESSION['user']);
	for($i=0;$i<count($posts);$i++){
		echo $posts[$i]->getHtml();
	}
}
?>
