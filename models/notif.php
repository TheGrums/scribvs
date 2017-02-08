<?php
//ini_set("display_errors",true);
class Notif{

private $_id, $_content, $_creation, $_dest, $_type;

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
public function Creation(){
  return $this->_pub_date;
}
public function Content(){
  return $this->_content;
}
public function Dest(){
  return $this->_dest;
}
public function Type(){
  return $this->_type;
}
//////////////////////
//                  //
//      Setters     //
//                  //
//////////////////////

public function setContent($a){
  $this->_content = $a;
}
public function setDest($a){
  $this->_dest=$a;
}
public function setId($a){
  $this->_id=$a;
}
public function setCreation($a){
  $this->_creation=$a;
}
public function setType($a){
  $this->_type = $a;
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
