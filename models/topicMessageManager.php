<?php

class TopicMessageManager{

  private $_bdd;

  public function __construct(){

    $this->setDatabase(getBdd());

  }

  //////////////////////
  //                  //
  //      Adder       //
  //                  //
  //////////////////////

  public function Add(TopicMessage $tcm){

    $ist_req = $this->_bdd->prepare("INSERT INTO `messages`(`id`, `aid`, `topicid`, `content`, `pub_date`) VALUES (NULL,:aid,:topicid,:content,NOW()) ;");

    $ist_req->execute(array("aid"=>$tcm->Aid(),"secid"=>$tcm->Topicid(),"content"=>$tcm->Content()));

  }


  //////////////////////
  //                  //
  //     Updater     //
  //                  //
  //////////////////////

  public function Update(TopicMessage $tcm){
    $request = $this->_bdd->prepare('UPDATE `messages` SET `topicid`=:topicid,`content`=:content WHERE id=:id');

    $request->execute(array("id"=>$tcm->Id(),"topicid"=>$tcm->Topicid(),"content"=>$tcm->Content()));
  }

  //////////////////////
  //                  //
  //      Getters     //
  //                  //
  //////////////////////

  public function ListTopicMessages($tid, $format="json", $andfilter=''){

    $uman = new UserManager();

    $data = $this->_bdd->prepare('SELECT * FROM `messages` WHERE topicid=:tid '.$andfilter.' ORDER BY pub_date asc;');
    $data->execute(array("tid"=>$tid));

    $TopicMessages=array();

    while($TopicMessagedata = $data->fetch()){
      $lesson = false;

      $TopicMessage = new TopicMessage($TopicMessagedata);

      $auth = $uman->getUserById($TopicMessage->Aid());

      $autorisation = stripos($TopicMessage->Content(), $_SESSION['user']->WholeName())||stripos($TopicMessage->Content(), $_SESSION['user']->Last())||stripos($TopicMessage->Content(), $_SESSION['user']->First())||$_SESSION['user']->Level()>3||$TopicMessage->Aid()==$_SESSION['user']->Id();

      if($format=="json"){
        array_push($TopicMessages,json_decode($TopicMessage->getJsonFormat()));
      }
      else if($format=="normal"){
        array_push($TopicMessages,$TopicMessage);
      }
      else if($format=="html"){
        list($year, $month, $day) = explode("-",$TopicMessage->Pub_date());
        $sman = new SubjectManager();
        if($auth->Lesson()){
          $lesson = $sman->ListSubjects("id=".$auth->Lesson(),"normal");
          $lesson = $lesson[0]->Name();
        }

        switch($auth->Level()){

          case 1:
          $title="Elève de ".$auth->ClassId().($lesson?"<span class='forum-usr-info' style='opacity:0.5'>Actif en <em>".$lesson."</em></span></span>":"</span>");
          break;

          case 2:
          $title="Délégué de ".$auth->ClassId();
          break;

          case 3:
          $title="Professeur ".($lesson?"de ".$lesson:"");
          break;

          case 4:
          $title="Administrateur";
          break;

          case 5:
          $title="Directeur";
          break;

          default:
          $title="Créateur";
          break;
        }

        echo '
        <div class="row small-row topic topic-message">
        <div class="col-md-2 col-md-offset-0 author-info col-xs-8 col-xs-offset-2">
        <div class = "profile-img-container">
        <div class="img-rounded profile-img section-thumbnail" style="background-image:url(\'./.'.$auth->Image().'\');margin:10px 0px;"></div>
        </div>
        <div>
        <div class="forum-username">'.$auth->WholeName().'</div>
        <div class="forum-usr-info" style="opacity:0.7">'.$title.'</div>
        <div class="forum-usr-info" style="opacity:0.7">'.$day.'-'.$month.'-'.$year.'</div>
        '.($autorisation?'<div class="message-forum-delete"><div class="msg-frm-edit" data-msg-id="'.$TopicMessage->Id().'"><span class="glyphicon-remove glyphicon"></span></div><div class="msg-frm-edit" data-msg-id="'.$TopicMessage->Id().'"><span class="glyphicon-edit glyphicon"></span></div></div>':'').'
        </div>
        </div>
        <div class="col-md-10 col-xs-12 forum-msg-right" >
        '.$TopicMessage->Content().'
        </div>
        <div class="container-fluid">
        <div class="row">
        <div class="col-md-10 col-md-offset-2 col-xs-12">
        <hr style="margin:10px 0px;"></hr>
        <div class="signature">'.$auth->Signature().'</div>
        </div>
        </div>
        </div>

        </div>';
      }

      if ($format=="normal")return $TopicMessages;
      else if ($format=="json"){
        echo json_encode($TopicMessages);
      }

    }
  }

  public function getTopicMessage($id){
    $req = $this->_bdd->prepare("SELECT * FROM messages WHERE id = :id;");
    $req->execute(array("id"=>$id));
    $data = $req->fetch();
    $msg = new TopicMessage($data);
    return $msg;
  }

  //////////////////////
  //                  //
  //     Remover      //
  //                  //
  //////////////////////
  public function Remove(TopicMessage $TopicMessage,User $viewer){
    $rem = $this->_bdd->prepare("DELETE FROM `messages` WHERE id=:id");

    if($viewer->Level()<3&&$viewer->Id()!=$TopicMessage->Aid()){

      $pos = stripos($TopicMessage->Content(), $_SESSION['user']->WholeName())||stripos($TopicMessage->Content(), $_SESSION['user']->Last())||stripos($TopicMessage->Content(), $_SESSION['user']->First());
      if(!$pos){
        return "Vous ne pouvez supprimer ce TopicMessage.";
      }

    }


    $rem->execute(array("id"=>$TopicMessage->Id()));
    return "Message supprimé.";

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
