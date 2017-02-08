<?php

class GroupManager{

private $_bdd;

public function __construct(){

    $this->setDatabase(getBdd());

}

//////////////////////
//                  //
//      Adders      //
//                  //
//////////////////////

public function Add(Group $gr){

  $request = $this->_bdd->prepare('INSERT INTO `groups`(`id`, `aid`, `name`, `members`) VALUES ( NULL, :aid, :name, :members);');
  $request->execute(array(
    "aid"=>$gr->Aid(),
    "name"=>$gr->Name(),
    "members"=>$gr->Members()
  ));
  $getId = $this->_bdd->query('SELECT id FROM groups order by id desc limit 1 ;');
  $id = $getId->fetch();
  $gr->setId($id['id']);
  return $gr->getJsonFormat();
}

//////////////////////
//                  //
//     Deleters     //
//                  //
//////////////////////

public function Update(Group $gr,$format="normal"){
  $request = $this->_bdd->prepare('UPDATE groups SET members=:members, aid=:aid, name=:name WHERE id=:id;');

  $request->execute(array(
    "id"=>$gr->Id(),
    "members"=>$gr->Members(),
    "name"=>$gr->Name(),
    "aid"=>$gr->Aid()
  ));

  if($format=="normal")return "ok";
  else if($format="json")echo $gr->getJsonFormat();
}

//////////////////////
//                  //
//      Getter      //
//                  //
//////////////////////

public function getGroups($filter, $format="normal"){
  $request = $this->_bdd->query('SELECT * FROM groups WHERE '.$filter.';');
  $groups = array();
  while($data = $request->fetch()){
    $group = new Group($data);
    if($format=="normal")array_push($groups,$group);
    else if($format=="json")array_push($groups,json_decode($group->getJsonFormat()));
  }

  if ($format=="normal")return $groups;
  else if ($format=="json"){
    echo json_encode($groups);
  }
}

public function getOwnedGroups(User $us, $format="normal"){

  $request = $this->_bdd->prepare('SELECT * FROM groups WHERE aid LIKE :aid1 OR aid LIKE :aid2 OR aid LIKE :aid3 OR aid LIKE :aid4 order by name;');
  $request->execute(array("aid1"=>"%|".$us->Id(),"aid2"=>"%|".$us->Id()."|%","aid3"=>$us->Id()."|%","aid4"=>$us->Id()));
  $groups = array();
  while($data = $request->fetch()){
    $group = new Group($data);
    if($format=="normal")array_push($groups,$group);
    else if($format=="json")array_push($groups,json_decode($group->getJsonFormat()));
  }

  if ($format=="normal")return $groups;
  else if ($format=="json"){
    echo json_encode($groups);
  }

}

public function getGroupByName($name, $format="normal", $filter=""){

  $request = $this->_bdd->prepare('SELECT * FROM groups WHERE name=:name;');
  $request->execute(array("name"=>$name));
  if($request->rowCount()==0)return false;
  $data = $request->fetch();
  $group = new Group($data);
  if($format=="normal")return $group;
  else if($format=="json")echo $group->getJsonFormat();

}

public function getSuggestions($viewer, $a, $format="json"){

  $request = $this->_bdd->prepare('SELECT * FROM groups WHERE LOWER(name) LIKE LOWER(:op1) ORDER BY name limit 10;');
  $request->execute(array(
    "op1"=>"%".$a."%"
  ));

  $groups = array();

  while($data = $request->fetch()){
    $group = new Group($data);
    if($format=="normal")array_push($groups,$group);
    else if($format=="json")array_push($groups,json_decode($group->getJsonFormat()));
  }

  if ($format=="normal")return $groups;
  else if ($format=="json"){
    echo json_encode($groups);
  }

}

public function getGroupById($id, $format="normal", $filter=""){

  $request = $this->_bdd->prepare('SELECT * FROM groups WHERE id=:id;');
  $request->execute(array("id"=>$id));
  if($request->rowCount()==0)return false;
  $data = $request->fetch();
  $group = new Group($data);
  if($format=="normal")return $group;
  else if($format=="json")echo $group->getJsonFormat();

}

public function getGroupsByMember($a, $format="json"){

  $request = $this->_bdd->prepare('SELECT name FROM groups WHERE LOWER(members) LIKE LOWER(:op1) OR LOWER(members) LIKE LOWER(:op2) OR LOWER(members) LIKE LOWER(:op3) OR LOWER(members) LIKE LOWER(:op4) ORDER BY name;');
  $variable = $request->execute(array(
    "op1"=>"%|".$a."|%",
    "op2"=>$a."|%",
    "op3"=>"%|".$a,
    "op4"=>$a
  ));

  $groups = array();
  if(!$request)return false;
  while($data = $request->fetch()){
    $group = new Group($data);
    if($format=="normal")array_push($groups,$group);
    else if($format=="json")array_push($groups,json_decode($group->getJsonFormat()));
    else if($format=="array")array_push($groups,json_decode($group->getJsonFormat()));
  }

  if ($format=="normal")return $groups;
  else if ($format=="json")echo json_encode($groups);
  else if($format=="array")return $groups;
}

public function getPostsByDay(Group $class, $day){
  $request = $this->_bdd->prepare("SELECT COUNT(*) as nbr FROM `posts` WHERE pub_date LIKE :day AND dest=:dest ;");
  $request->execute(array("day"=>$day."%","dest"=>$class->Name()));
  $data=$request->fetch();
  return $data['nbr'];
}
public function getFilesByDay(Group $class, $day){
  $request = $this->_bdd->prepare("SELECT COUNT(*) as nbr FROM `files` WHERE send_date LIKE :day AND dest=:dest ;");
  $request->execute(array("day"=>$day."%","dest"=>$class->Name()));
  $data=$request->fetch();
  return $data['nbr'];
}

//
//  Setter
//
public function setDatabase($bdd){
  $this->_bdd=$bdd;
}

}

?>
