<?php

class Topic{

private $_id, $_aid, $_secid, $_stid, $_title, $_content, $_solved, $_pub_date, $_msgnbr, $_suppressible, $_author_name;

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

public function Authorname(){
  return $this->_author_name;
}
public function Suppressible(){
  return (bool)$suppressible;
}
public function Msgnbr(){
  return $this->_msgnbr;
}
public function Id(){
  return intval($this->_id);
}
public function EuroDate(){
  list($year, $month, $daytime) = explode("-",$this->_pub_date);
  list($day, $time) = explode(" ",$daytime);
  return $day.'-'.$month.'-'.$year;
}
public function Color(){
  switch($this->_solved){
    case 1:
      $color='rgba(0,0,200,0.5)';
      break;
    case 0:
      $color='transparent';
      break;
    case -1:
      $color='rgba(0,0,0,0.5)';
      break;

    default:
      $color='transparent';
      break;
  }
  return $color;
}
public function Aid(){
  return intval($this->_aid);
}
public function Secid(){
  return intval($this->_secid);
}
public function Stid(){
  return intval($this->_stid);
}
public function Title(){
  return $this->_title;
}
public function Content(){
  return $this->_content;
}
public function Solved(){
  return $this->_solved;
}
public function Pub_date(){
  return $this->_pub_date;
}


//////////////////////
//                  //
//      Setters     //
//                  //
//////////////////////

public function setAuthor_name($a){
  $this->_author_name=$a;
}
public function setSupressible($a){
  $this->_suppressible=(bool)$a;
}
public function setId($a){
  $this->_id=$a;
}
public function setMsgnbr($a){
  $this->_msgnbr=$a;
}
public function setAid($a){
  $this->_aid=$a;
}
public function setSecid($a){
  $this->_secid=$a;
}
public function setStid($a){
  $this->_stid=$a;
}
public function setTitle($a){
  $this->_title=$a;
}
public function setContent($a){
  $this->_content=$a;
}
public function setSolved($a){
  $this->_solved=$a;
}
public function setPub_date($a){
  $this->_pub_date=$a;
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
