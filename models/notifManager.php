<?php

class NotifManager{

private $_bdd;

public function __construct(){

    $this->setDatabase(getBdd());

}

//////////////////////
//                  //
//      Adder       //
//                  //
//////////////////////

public function Add(Notif $nf){

  $ist_req = $this->_bdd->prepare("INSERT INTO `notifs` (`id`, `dest`, type, `creation`, `content`) VALUES (NULL, :dest, :type, NOW(), :content);");

  $ist_req->execute(array("type"=>$nf->Type(),"content"=>$nf->Content(),"dest"=>$nf->Dest()));


}


//////////////////////
//                  //
//     Updater     //
//                  //
//////////////////////

public function Update(Notif $nf){
  $request = $this->_bdd->prepare('UPDATE `posts` SET `content`=:content, dest=:dest, type=:type WHERE id=:id');

  $request->execute(array(
    "dest"=>$nf->Dest(),
    "content"=>$nf->Content(),
    "type"=>$nf->Type()
  ));
}

//////////////////////
//                  //
//      Getters     //
//                  //
//////////////////////

public function ListNotifs(User $viewer,$filter, $format="normal"){

  $request = "SELECT * FROM notifs WHERE ".$filter." order by creation desc;";
  $qry = $this->_bdd->query($request);
  $notifs = array();
  while($data=$qry->fetch()){

    $notif = new Notif($data);
    if($format=="normal")array_push($notifs,$notif);
    else if($format=="json")array_push($notifs,json_decode($notif->getJsonFormat()));

  }

  if ($format=="normal")return $notifs;
  else if ($format=="json"){
    echo json_encode($notifs);
  }

}

//////////////////////
//                  //
//     Remover      //
//                  //
//////////////////////
public function Remove(Notif $nf,User $viewer){
  $rem = $this->_bdd->prepare("DELETE FROM `notifs` WHERE id=:id");

  if($viewer->Id()!= $nf->Dest()){
      return 0;
  }


  $rem->execute(array("id"=>$nf->Id()));
  return 1;

}

public function RemoveLinkedToFile($filepath){
  echo "yolo";
  $rem = $this->_bdd->prepare("DELETE FROM `notifs` WHERE content LIKE :filepath");
  $rem->execute(array("filepath"=>"%".$filepath."%"));

}

//////////////////////
//                  //
//     Setter       //
//                  //
//////////////////////


public function setDatabase($bdd){
  $this->_bdd=$bdd;
}

//////////////////////
//                  //
//     Other        //
//                  //
//////////////////////


public function getJsonData($ar){
  for($i=0;$i<count($ar);$i++){
    $var = get_object_vars($ar[$i]);
    foreach($var as &$value){
      if(is_object($value) && method_exists($value,'getJsonData')){
        $value = $this->getJsonData($value);
      }
    }
    return $var;
  }
}

public function getJsonFormat($ar){
  return json_encode($this->getJsonData($ar));
}

}

?>
