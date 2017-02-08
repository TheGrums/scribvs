<?php

class CommentManager{

private $_bdd;

public function __construct(){

    $this->setDatabase(getBdd());

}

//////////////////////
//                  //
//      Adder       //
//                  //
//////////////////////

public function Add(Comment $cmt){

  $ist_req = $this->_bdd->prepare("INSERT INTO `comments`(`id`, `uid`, `pid`, `content`) VALUES (NULL, :uid, :pid, :content);");

  $ist_req->execute(array(
    "uid"=>$cmt->Uid(),
    "content"=>$cmt->Content(),
    "pid"=>$cmt->Pid()
  ));



}


//////////////////////
//                  //
//     Updater     //
//                  //
//////////////////////

public function Update(Comment $cmt){
  $request = $this->_bdd->prepare('UPDATE `comments` SET `content`=:content WHERE id=:id');

  $request->execute(array(
    "content"=>$cmt->Content(),
    "id"=>intval($cmt->Id())
  ));
}

//////////////////////
//                  //
//      Getters     //
//                  //
//////////////////////

public function ListComments($filter, $begin, $nb, User $viewer, $format="normal"){



  $request = "SELECT * FROM comments WHERE ".$filter." order by id desc limit ".intval($nb)." OFFSET ".intval($begin)." ;";
  $qry = $this->_bdd->query($request);
  $comments=array();

  $usr_query=$this->_bdd->prepare("SELECT img, name, first_name FROM accounts WHERE id = :uid;");

  while($data=$qry->fetch()){


    $suppressible=0;

    if($viewer->Level()>2||$viewer->Id()==$data['uid']||stripos($data['content'], $_SESSION['user']->WholeName())||stripos($data['content'], $_SESSION['user']->Last())||stripos($data['content'], $_SESSION['user']->First())){
      $suppressible=1;
    }


    $usr_query->execute(array("uid"=>$data['uid']));


    $ud = $usr_query->fetch();
    $usr = new User($ud);
    $data["author"]=$usr;

    $data["suppressible"]=$suppressible;

    $comment = new Comment($data);
    if($format=="normal")array_push($comments,$comment);
    else if($format=="json")array_push($comments,json_decode($comment->getJsonFormat()));
  }

  if ($format=="normal")return $comments;
  else if ($format=="json"){
    echo json_encode($comments);
  }

}

//////////////////////
//                  //
//     Remover      //
//                  //
//////////////////////
public function Remove(Comment $comment,User $viewer){
  $rem = $this->_bdd->prepare("DELETE FROM `comments` WHERE id=:id");

  if($viewer->Level()<3&&$viewer->Id()!=$comment->Uid()){

    $pos = stripos($get['content'], $_SESSION['user']->WholeName())||stripos($get['content'], $_SESSION['user']->Last())||stripos($get['content'], $_SESSION['user']->First());
    if($pos&&(($viewer->Level()==2||$viewer->Level()==3)&&$Comment->Dest()==$viewer->ClassId())){
      return false;
    }

  }


  $rem->execute(array("id"=>$comment->Id()));
  return true;

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
