<?php

header('content-type: application/json');
	ob_start('ob_gzhandler');
	header('Cache-Control: max-age=31536000, must-revalidate');
require_once("../config/db.php");
session_start();

	if(isset($_SESSION["user"]) && isset($_POST['dest']) && isset($_POST['sticky'])){


		require_once("../models/functions.php");

		$images_returned = uploadFiles("photos", "post_images");
		$image1 = $images_returned[0];
		$images_returned[0] = "";
		$images = $image1.'<div class="clearfix mosaicflow-container">'.implode($images_returned).'</div>';
		$status = 1;
		$sticky = intval($_POST['sticky']);

		switch($_POST['dest']){
			case 'class-post':
				$dest = $_SESSION['user']->ClassId();
				if($_SESSION['user']->Level()<2){
					$sticky=0;
				}
				break;
			case 'year-post':
				$dest = 'y'.$_SESSION['user']->Year();
				if($_SESSION['user']->Level()<4){
					$sticky=0;
				}
				break;
			case 'school-post':

				if($_SESSION['user']->Level()<3){
					echo 'waiting';
					$status = 0;
					$sticky = 0;
				}
				if($_SESSION['user']->Level()<4){
					$sticky=0;
				}
				$dest = 'school';
				break;
			case 'friends-post':
				$sticky=0;
				$dest = implode("|",$_SESSION['user']->FriendsArray());
				break;
		}

		/*$content = str_replace(array("<a"), "|a", $_POST['content']);
		$content = str_replace(array(">"), "||", $content);
		$content = str_replace(array("</a"), "a|", $content);
		$content = htmlspecialchars($content).' '.$images;
		$content = str_replace(array("|a"), "<a", $content);
		$content = str_replace(array("a|"), "</a", $content);
		$content = str_replace(array("||"), ">", $content);
		$content = str_replace(array("&quot;"), "'", $content);
		$content = str_replace(array("&lt;p"), "<p", $content);
		$content = str_replace(array("&lt;/p"), "</p", $content);*/
		$content = $_POST['content'].' '.$images;
		$content = killXss($content);
		$content = str_replace(array("Jay Nichols"),"Superman",$content);
		$content = str_replace(array("Theresa Nichols"),"Princess",$content);
		$content = str_replace(array("Bobo Nichols"),"A never tired boy",$content);
		$content = str_replace(array("Kelly Nichols"),"The boss",$content);
		$content = str_replace(array("Luke Heidtke"),"A crazy american",$content);

		$pst=new Post(array("sticky"=>$sticky,"content"=>nl2br($content),"level"=>$status,"dest"=>$dest,"aid"=>$_SESSION['user']->Id()));
		$man=new PostManager();
		$man->Add($pst);
		$man->ListPosts(($sticky?"":"sticky!=1 AND ")."aid=".$_SESSION['user']->Id(),0,1,$_SESSION['user'],"json");
	}
	else{
		die("Are u lost ?");
	}

?>
