<?php
//ini_set("display_errors",true);
class User{

private $_id, $_firstname, $_familyname, $_signature, $_level, $_lesson, $_email, $_img, $_pass, $_sessid, $_ip, $_class, $_friends, $_groups, $_status, $_alreadyfriend;

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

public function Combinaisons(){
  return array(
    $this->_firstname.' '.$this->_familyname,
    $this->_firstname.$this->_familyname,
    $this->_familyname.' '.$this->_firstname,
    $this->_familyname.$this->_firstname
  );
}
public function AlreadyFriend(){
  return $this->_alreadyfriend;
}
public function WholeName(){
  $f = $this->_firstname;
  $l = $this->_familyname;
  return $f.' '.$l;
}
public function FriendsGroup(){
  return $this->_friends;
}
public function First(){
  return $this->_firstname;
}
public function Last(){
  return $this->_familyname;
}
public function Level(){
  return $this->_level;
}
public function Pass(){
  return $this->_pass;
}
public function Image(){
  return $this->_img;
}
public function Lesson(){
  return $this->_lesson;
}
public function Signature(){
  return $this->_signature;
}
public function Email(){
  return $this->_email;
}
public function ClassId(){
  return $this->_class;
}
public function Year(){
  $class=$this->_class;
  $year=$class[0];
  return $year;
}
public function FriendsArray(){
  $friendsarray=$this->_friends->MembersArray();
  return $friendsarray;
}
public function Friends(){
  return $this->_friends->Id();
}
public function Id(){
  return $this->_id;
}
public function Sessid(){
  return $this->_sessid;
}
public function Ip(){
  return $this->_ip;
}
public function Status(){
  return $this->_status;
}
public function Groups(){
  return $this->_groups;
}

//////////////////////
//                  //
//      Setters     //
//                  //
//////////////////////

public function setAlreadyFriend($a){
  $this->_alreadyfriend=(bool)$a;
}
public function autoSetGroups(){
  $man = new GroupManager();
  $this->_groups = $man->getGroupsByMember($this->_id,"array");
}
public function setId($id){
  $id=(int)$id;
  $this->_id=$id;
}
public function setFirst_name($first){
  $this->_firstname=$first;
}
public function setName($name){
  $this->_familyname=$name;
}
public function setE_mail($email){
  $this->_email=$email;
}
public function setLesson($lesson){
  $this->_lesson=(int)$lesson;
}
public function setSignature($signature){
  $this->_signature=$signature;
}
public function setFriends($a){
  $man = new GroupManager();
  $friends = $man->getGroupById($a);
  $this->_friends=$friends;
}
public function setIp($ip){
  $this->_ip=$ip;
}
public function setSessid($sessid){
  $this->_sessid=$sessid;
}
public function setImg($img){
  $this->_img=$img;
}
public function setLevel($level){
  $this->_level=$level;

  switch($this->_level){
      case 1:
        $this->_status =  "Elève";
      break;
      case 2:
        $this->_status =  "Délégué";
      break;
      case 3:
        $this->_status =  "Professeur";
      break;
      case 4:
        $this->_status =  "Educateur";
      break;
      case 5:
        $this->_status =  "Directeur";
      break;
      default:
        $this->_status =  "Indéfini";
      break;
  }
}
public function setPass($pass){
  $this->_pass=$pass;
}
public function setClass($class){
  $this->_class=$class;
}



//////////////////////
//                  //
//      Other       //
//                  //
//////////////////////

public function CompareCookie($uniqid, $ip, $first, $name){

  $bool = password_verify($this->_ip, $ip)&&password_verify($this->_firstname, $first)&&password_verify($this->_familyname, $name);

  if($this->_level==0){
    return -1;
  }
  else if($bool){
    $this->CreateCookie();

    $_SESSION['id'] = uniqid(rand(),true);

    //$this->setPass("");
    $_SESSION['user']=$this;

    $_SESSION['co_elements'] = array(

      'uid' => $this->_id,
      'pass' => $this->_pass,
      'first' => $this->_firstname,
      'name' => $this->_familyname,
      'class' => $this->_class,
      'img' => $this->_img,
      'level' => $this->_level,
      'friends' => $this->Friends(),
      'signature' => $this->_signature,
      'lesson' => $this->_lesson

    );

    return 1;
  }
  else{
    setcookie('sessid', NULL, time(), "/", null, false, true);
    return 0;
  }
}
public function CreateCookie(){

    $unique_id = uniqid(rand(),true);

    $this->setSessid($unique_id);

    $manager = new userManager();
    $manager->Update($this);


    $_SESSION['co_element'] = array(

      'uid' => $this->_id,
      'pass' => $this->_pass,
      'first' => $this->_firstname,
      'name' => $this->_familyname,
      'class' => $this->_class,
      'img' => $this->_img,
      'level' => $this->_level,
      'friends' => $this->Friends(),
      'signature' => $this->_signature,
      'lesson' => $this->_lesson

    );

    $_SESSION['user']=$this;

    $cookiedata = password_hash($_SERVER['REMOTE_ADDR'],PASSWORD_BCRYPT,['cost' => 6]).'----'.password_hash($this->_firstname,PASSWORD_BCRYPT,['cost' => 6]).'----'.password_hash($this->_familyname,PASSWORD_BCRYPT,['cost' => 6]).'----'.$unique_id ;

    setcookie('sessid', $cookiedata, time()+3600*24*14, "/", null, false, true);

}
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
