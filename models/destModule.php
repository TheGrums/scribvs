<?php
ini_set("display_errors",true);
include("../config/db.php");
class DestModule{

private $_type, $_string, $_idlist, $_bdd;

public function __construct($string){

  if(!isset($string))return;

  $this->setDatabase(getBdd());
  $this->setString($string);
  $charbasearr = str_split($string);

  if(is_numeric($charbasearr[0])){

    $idlist = explode("|",$string);
    print_r($idlist);

  }
  else if($charbasearr[0]=="g"){

    

      $type = 2;

      $request = $this->_bdd->prepare("SELECT members FROM groups WHERE id=:id ;");

      $chararr = array_slice($chararr,1);

      $request->execute(array("id"=>implode("",$chararr)));

      $data = $request->fetch()[0];

      $this->setIdList(explode("|",$data));

  }

}

//////////////////////
//                  //
//      Getters     //
//                  //
//////////////////////

function getString(){
  return $this->_string;
}

//////////////////////
//                  //
//      Setters     //
//                  //
//////////////////////

function setIdList($a){
  return $this->_idlist=$a;
}

function setString($a){
  return $this->_string=$a;
}

public function setDatabase($bdd){
  $this->_bdd=$bdd;
}

//////////////////////
//                  //
//      Other       //
//                  //
//////////////////////


}
$coucou = new DestModule("g15");

?>
