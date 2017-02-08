<?php

class TopicMessage{

private $_id, $_aid, $_topicid, $_content, $_pub_date;

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
public function Aid(){
  return intval($this->_aid);
}
public function Topicid(){
  return intval($this->_topicid);
}
public function Pub_date(){
  return $this->_pub_date;
}
public function Content(){
  return $this->_content;
}


//////////////////////
//                  //
//      Setters     //
//                  //
//////////////////////

public function setTopicid($a){
  $this->_topicid = $a;
}
public function setId($a){
  $this->_id=$a;
}
public function setAid($a){
  $this->_aid=$a;
}
public function setPub_date($a){
  $this->_pub_date=$a;
}
public function setContent($a){
  $this->_content = $a;
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
