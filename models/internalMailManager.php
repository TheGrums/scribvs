<?php

class InternalMailManager{

private $_bdd;

public function __construct(){

    $this->setDatabase(getBdd());

}

//////////////////////
//                  //
//      Adders      //
//                  //
//////////////////////

public function Add(InternalMail $imail){

  $request = $this->_bdd->prepare('INSERT INTO `internal_mails`(`id`, `aid`, `dest`, `send_date`, `content`) VALUES (NULL,:aid,:dest,NOW(),:content)');
  $request->execute(array(
    "aid"=>$imail->Aid(),
    "dest"=>$imail->Dest(),
    "content"=>$imail->Content()
  ));
  $getId = $this->_bdd->query('SELECT id, send_date FROM internal_mails order by id desc limit 1 ;');
  $id = $getId->fetch();
  $imail->setId($id['id']);
  $imail->setSend_date($id['send_date']);
  return $imail->getJsonFormat();
}

public function Update(InternalMail $imail){
  $request = $this->_bdd->prepare('UPDATE `internal_mails` SET `aid`=:aid,`dest`=:dest WHERE id=:id');

  $request->execute(array("id"=>$imail->Id(),"dest"=>$imail->Dest(),"aid"=>$imail->Aid()));
}

public function ListInternalMails(User $viewer, $filter='', $nb=15, $begin=0, $format="html"){

  $req = $this->_bdd->prepare("SELECT * FROM internal_mails ".$filter." order by send_date desc limit ".$nb." offset ".$begin." ;");
  $req->execute();

  $mails = array();
  $i=0;
  while($data = $req->fetch()){
    $i++;
    $tmp_imail = new InternalMail($data);
    if($format=="json"){
      array_push($mails,json_decode($tmp_imail->getJsonFormat()));
    }
    else if($format=="normal"){
      array_push($mails,$tmp_imail);
    }
    else{
      echo $tmp_imail->getHtmlFormat($viewer);
    }


  }
  if($i==0&&$format=="html")echo "<span style='font-family:Sniglet;'>Votre boîte de réception est vide.</span>";

  if($format=="json"){
    echo json_encode($mails);
  }
  else if($format=="normal"){
    return $mails;
  }


}
//
//  Setter
//
public function setDatabase($bdd){
  $this->_bdd=$bdd;
}

}

?>
