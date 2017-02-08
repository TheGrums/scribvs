<?php
//ini_set("display_errors",true);
class UserManager{

private $_bdd;

public function __construct(){

    $this->setDatabase(getBdd());

}

//////////////////////
//                  //
//      Adders      //
//                  //
//////////////////////

public function Add(User $us){

  if($this->getUserByMail($us->Email())==0&&count($this->getSuggestions(new User(array("level"=>10)),$us->WholeName(),"","normal"))==0){
    $request = $this->_bdd->prepare('INSERT INTO `accounts`(`id`, `first_name`, `name`, `e_mail`, `lesson`, `class`, `img`, `friends`, `signature`, `level`, `pass`, `sessid`, `ip`) VALUES ( NULL, :first, :last, :e_mail, "0", :class, "./pictures/default.jpg", "", "", :level, :pass, :sessid, :ip);');
    $request->execute(array(
      "first"=>$us->First(),
      "last"=>$us->Last(),
      "e_mail"=>$us->Email(),
      "class"=>$us->ClassId(),
      "level"=>$us->Level(),
      "pass"=>$us->Pass(),
      "sessid"=>$us->Sessid(),
      "ip"=>$us->Ip()
    ));

    $getId = $this->_bdd->query('SELECT id FROM accounts order by id desc limit 1 ;');
    $id = $getId->fetch();
    $us->setId($id['id']);
    return "ok";
  }
  else die ("<div class='row yolo' style='font-family:Sniglet;color:red;font-size:12px;'>Vous semblez être déjà enregisté...<br /> Si vous pensez que c'est une erreur veuillez contacter les administrateurs du site.</div>");
}

//////////////////////
//                  //
//     Deleters     //
//                  //
//////////////////////

public function Update(User $us){
  $request = $this->_bdd->prepare('UPDATE accounts SET signature=:signature, class=:class, img=:img, lesson=:lesson, friends=:friends, level=:level, pass=:pass, sessid=:sessid, ip=:ip WHERE id=:id;');
  $friends = $us->Friends();

  $request->execute(array(
    "signature"=>$us->Signature(),
    "img"=>$us->Image(),
    "class"=>$us->ClassId(),
    "level"=>$us->Level(),
    "pass"=>$us->Pass(),
    "sessid"=>$us->Sessid(),
    "friends"=>$us->Friends(),
    "lesson"=>$us->Lesson(),
    "id"=>$us->Id(),
    "ip"=>$us->Ip()

  ));
}

// Special getters

public function getUserById($id, $format="normal"){

  $request = $this->_bdd->prepare('SELECT *, NULL AS pass, NULL AS sessid FROM accounts WHERE id=:id;');
  $request->execute(array("id"=>$id));
  if($request->rowCount()==0)return false;
  $data = $request->fetch();
  $user = new User($data);
  if($format=="normal")return $user;
  else if($format=="json")echo $user->getJsonFormat();

}

public function getUserByMail($mail, $format="normal"){

  $request = $this->_bdd->prepare('SELECT * FROM accounts WHERE e_mail=:mail;');
  $request->execute(array("mail"=>$mail));
  if($request->rowCount()==0)return false;
  $data = $request->fetch();
  $user = new User($data);
  if($format=="normal")return $user;
  else if($format=="json")echo $user->getJsonFormat();

}

public function getUserByUrl($url){

  $user = explode("-",$url);
  $last = $user[0];
  array_splice($user,0,1);
  $first = implode("-", $user);

  $request = $this->_bdd->prepare('SELECT *, NULL AS pass, NULL AS sessid FROM accounts WHERE first_name=:fst AND name=:lst;');
  $request->execute(array("fst"=>htmlentities($first),"lst"=>htmlentities($last)));
  if($request->rowCount()==0)return false;
  $data = $request->fetch();
  $user = new User($data);
  return $user;

}

public function getSuggestions($viewer, $a, $afilter="", $format="json"){

  $chararr = str_split($a);
  $users = array();

  if($chararr[0]!="@"){
    $request = $this->_bdd->prepare('SELECT *, NULL AS pass, NULL AS sessid FROM accounts WHERE (LOWER(CONCAT(name," ",first_name)) LIKE LOWER(:op1) OR LOWER(CONCAT(first_name," ",name)) LIKE LOWER(:op2)) '.$afilter.' ORDER BY first_name limit 15;');
    $request->execute(array(
      "op1"=>"%".$a."%",
      "op2"=>"%".$a."%"
    ));

    while($data = $request->fetch()){
      $user = new User($data);
      if(in_array($user->Id(),$viewer->FriendsArray())) $user->setAlreadyFriend(true);
      else $user->setAlreadyFriend(false);
      $user->autoSetGroups();
      if($format=="normal")array_push($users,$user);
      else if($format=="json")array_push($users,json_decode($user->getJsonFormat()));
    }

  }

  else if(count($chararr)!=1&&$chararr[0]=="@"){
    $chararr = array_slice($chararr,1);
    $gman = new GroupManager();
    $groups = $gman->getSuggestions($viewer,implode($chararr),"normal");

    $max = 30;
    $ctr = 0;

    for($i=0;$i<count($groups);$i++){

      $membersIds = $groups[$i]->MembersArray();

      for($j=0;$j<count($membersIds);$j++){
        if($ctr>=$max)break;
        $user = $this->getUserById($membersIds[$j]);
        if(in_array($user->Id(),$viewer->FriendsArray())) $user->setAlreadyFriend(true);
        else $user->setAlreadyFriend(false);
        $user->autoSetGroups();
        if($format=="normal")array_push($users,$user);
        else if($format=="json")array_push($users,json_decode($user->getJsonFormat()));
        $ctr++;
      }
      if($ctr>=$max)break;

    }


  }

  if ($format=="normal")return $users;
  else if ($format=="json"){
    echo json_encode($users);
  }
}

public function getUsersByGroup($gid, $viewer, $filter="",$format="json"){
  $gman = new GroupManager();
  $group = $gman->getGroupById($gid);
  $arr = $group->MembersArray();
  $users=array();

  for($i=0;$i<count($arr);$i++){

    $user=$this->getUserById($arr[$i]);
    if(in_array($user->Id(),$viewer->FriendsArray())) $user->setAlreadyFriend(true);
    else $user->setAlreadyFriend(false);

    if($format=="normal")array_push($users,$user);
    else if($format=="json")array_push($users,json_decode($user->getJsonFormat()));

  }

  if ($format=="normal")return $users;
  else if ($format=="json"){
    echo json_encode($users);
  }

}

//
//  Setter
//
public function setDatabase($bdd){
  $this->_bdd=$bdd;
}

}

?>
