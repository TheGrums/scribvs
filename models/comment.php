<?php

class Comment{

private $_id, $_uid, $_pid, $_content, $_supressible, $_author;

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
public function Uid(){
  return $this->_uid;
}
public function Pid(){
  return $this->_pid;
}
public function Content(){
  return $this->_content;
}
public function Suppressible(){
  return (bool)$this->_suppressible;
}
public function Author(){
  return $this->_author;
}


//////////////////////
//                  //
//      Setters     //
//                  //
//////////////////////


public function setId($a){
  $this->_id=$a;
}
public function setAuthor(User $a){
  $this->_author = $a;
}
public function setUid($a){
  return $this->_uid=$a;
}
public function setPid($a){
  return $this->_pid=$a;
}
public function setContent($a){
  return $this->_content=$a;
}
public function setSuppressible($a){
  $this->_suppressible=$a;
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
