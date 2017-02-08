<?php

class Subject{

private $_id, $_formules, $_img, $_name, $_description, $_last;

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
  return intval($this->_id);
}
public function Formules(){
  return (bool)$this->_formules;
}
public function Last(){
  return $this->_last;
}
public function Description(){
  return $this->_description;
}
public function Name(){
  return $this->_name;
}
public function Img(){
  return $this->_img;
}

//////////////////////
//                  //
//      Setters     //
//                  //
//////////////////////

public function setLast($a){
  $this->_last=$a;
}
public function setId($a){
  $this->_id=$a;
}
public function setFormules($a){
  $this->_formules=$a;
}
public function setName($a){
  $this->_name=$a;
}
public function setDescription($a){
  $this->_description=$a;
}
public function setImg($a){
  $this->_img=$a;
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
