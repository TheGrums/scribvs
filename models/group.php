<?php

class Group{

private $_id, $_aid, $_name, $_members;

public function __construct(array $data){
    $this->feed($data);
}

//////////////////////
//                  //
//      Feeder      //
//                  //
//////////////////////

public function feed(array $donnees){
  foreach ($donnees as $key => $value){
    $method = 'set'.ucfirst($key);
    if (method_exists($this, $method)){
      $this->$method($value);
    }
  }
}


//////////////////////
//                  //
//      Getters     //
//                  //
//////////////////////

public function Id(){
  return $this->_id;
}
public function FriendsLeft(){
  $nbFriends = count($this->MembersArray());
  if($this->MembersArray()[0]=="")
    return 10;
  else
    return 10-$nbFriends;
}
public function Aid(){
  return $this->_aid;
}
public function Name(){
  return $this->_name;
}
public function Members(){
  return $this->_members;
}
public function MembersArray(){
  $members = explode("|",$this->_members);
  if($members[0]=="")return array();
  else return $members;
}
public function OwnersArray(){
  $owners = explode("|",$this->_aid);
  if($owners[0]==""||$owners[0]=="-1")return array();
  else return $owners;
}


//////////////////////
//                  //
//      Setters     //
//                  //
//////////////////////


public function setId($a){
  $this->_id=$a;
}
public function setAid($a){
  $this->_aid = $a;
}
public function setMembers($a){
  return $this->_members=$a;
}
public function setName($a){
  return $this->_name=$a;
}
public function getEditShape(){

  $uman = new userManager();

  $html = '<div class="col-sm-6">
    <div class="panel panel-default group-card">
      <div class="panel-heading">'.$this->Name().'<span class="glyphicon glyphicon glyphicon-trash panel-delete" onclick="detachGroupOwner('.$this->Id().',$(this).parents(\'.panel\').eq(0));"></span><span class="glyphicon glyphicon glyphicon-chevron-down panel-down"></span></div>
      <table class="table">
        <tbody>
          <tr>';
            $members = $this->MembersArray();
            for($j=0;$j<count($members);$j++){

              $user = $uman->getUserById($members[$j]);

              $html.= '<td>'.$user->WholeName().'<button class="btn btn-small btn-danger" onclick="detachGroupMember('. $this->Id().', '.$user->Id().',$(this).parents(\'td\').eq(0));" style="padding: 2px 8px 5px;"><span class="glyphicon glyphicon-ban-circle" style="font-size:0.9em;"></span></button></td>';


              $html.= ($j%2==1?"</tr><tr>":"");

            }
        $html.='</tr>
        </tbody>
      </table>
    </div>
  </div>';
  return $html;
}

// No name



public function addMember($a){
  $arr = $this->MembersArray();
  if(in_array($a,$arr))return false;
  array_push($arr,$a);
  $this->_members = implode("|",$arr);
  return true;
}
public function addOwner($a){
  $arr = $this->OwnersArray();
  array_push($arr,$a);
  $this->_aid = implode("|",$arr);
}

public function deleteOwner($a){
  $arr = $this->OwnersArray();
  $arr = array_diff($arr,array($a));
  if(count($arr)>0)
    $this->_aid = implode("|",$arr);
  else
    $this->_aid = "-1";
}

public function getSuggestionShape($viewer){

  $gman = new GroupManager();

  $groups = $gman->getOwnedGroups($_SESSION['user']);
  $gid = array();
  for($i=0;$i<count($groups);$i++){
   $gid[$i]=$groups[$i]->Id();
  }

  $html= '<div class="list-group-item"><h3 class="list-group-item-heading" style="margin:15px;">'.$this->_name.'</h3><p class="list-group-item-text">';
  $membersIds = $this->MembersArray();
  $uman = new UserManager();

  for($i=0;$i<count($membersIds);$i++){
    $user=$uman->getUserById($membersIds[$i]);
    $html.= '<span class="label label-default">'.$user->WholeName().'</span>';
  }

  if(!in_array($this->_id,$gid))$html.='<br /><button class="btn btn-success btn-small quick-add-group" data-group-id="'.$this->_id.'" style="float:none;">Gérer ce groupe.</button></p></div>';
  else $html.='</p></div>';
  return $html;
}

public function deleteMember($a){
  $arr = $this->MembersArray();
  if(count($arr)==1)return false;
  $yolo = $arr[$a];
  $arr = array_diff($arr,array($yolo));
  $this->_members = implode("|",$arr);
  return true;
}

//////////////////////
//                  //
//      Other       //
//                  //
//////////////////////

public function getJsonData(){
   $var = get_object_vars($this);
   foreach($var as &$value){
      if(is_object($value) && method_exists($value,'getJsonData')){
         $value = $value->getJsonData();
      }
   }
   return $var;
}
public function getJsonFormat(){
  return json_encode($this->getJsonData());
}




}

?>
