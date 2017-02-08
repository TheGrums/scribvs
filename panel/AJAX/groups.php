<?php
//ini_set("display_errors",true);
require('./../../config/db.php');
session_start();
if(isset($_SESSION['user'])){

if($_SESSION['user']->Level()>=3&&isset($_POST['type'])){
  switch($_POST['type']){
    case "detachOwner":
      if(isset($_POST['id'])){
        $gman = new GroupManager();
        $group = $gman->getGroupById(intval($_POST['id']));
        $group->deleteOwner($_SESSION['user']->Id());
        $gman->Update($group);
      }
    break;
    case "detachMember":
      if(isset($_POST['uid'])&&isset($_POST['id'])){
        $gman = new GroupManager();
        $group = $gman->getGroupById(intval($_POST['id']));
        if($group->deleteMember(intval($_POST['uid'])))echo 1;
        $gman->Update($group);
      }
    break;
    case "autosuggest":
      if(isset($_POST['q'])){
        $gman = new GroupManager();
        $groups = $gman->getSuggestions($_SESSION['user'],$_POST['q'],"normal");
        for($i=0;$i<count($groups);$i++){
          echo $groups[$i]->getSuggestionShape($_SESSION['user']);
        }
      }
    break;
    case "addOwner":
      if(isset($_POST['id'])){
        $gman = new GroupManager();
        $group = $gman->getGroupById(intval($_POST['id']));
        $group->addOwner($_SESSION['user']->Id());
        $gman->Update($group);
        echo $group->getEditShape();
      }
    break;
    case "addMember":
      if(isset($_POST['gid'])&&isset($_POST['uid'])){
        $gman = new GroupManager();
        $uman = new UserManager();
        $user = $uman->getUserById(intval($_POST['uid']));
        $group = $gman->getGroupById(intval($_POST['gid']));
        echo (int)$group->addMember($user->Id());
        $gman->Update($group);
      }
    break;
    case "createGroup":
    if(isset($_POST['members'])&&isset($_POST['name'])){
      $gman = new GroupManager();
      $group = new Group(array(
        "aid"=>$_SESSION['user']->Id(),
        "name"=>htmlspecialchars($_POST['name']),
        "members"=>implode("|",$_POST['members'])
      ));
      $gman->Add($group);
      echo $group->getEditShape();
    }
    break;



  }


}

}
