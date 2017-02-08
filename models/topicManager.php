<?php

class TopicManager{

private $_bdd;

public function __construct(){

    $this->setDatabase(getBdd());

}

//////////////////////
//                  //
//      Adder       //
//                  //
//////////////////////

public function Add(Topic $tc){

  $ist_req = $this->_bdd->prepare("INSERT INTO `topics`(`id`, `aid`, `secid`, `stid`, `title`, `content`, `solved`, `pub_date`) VALUES (NULL,:aid,:secid,:stid,:title,:content,0,NOW()) ;");

  $ist_req->execute(array("aid"=>$tc->Aid(),"secid"=>$tc->Secid(),"stid"=>$tc->Stid(),"title"=>$tc->Title(),"content"=>$tc->Content()));

}


//////////////////////
//                  //
//     Updater     //
//                  //
//////////////////////

public function Update(Topic $tc){
  $request = $this->_bdd->prepare('UPDATE `topics` SET `secid`=:secid,`stid`=:stid,`title`=:title,`content`=:content,`solved`=:solved WHERE id=:id');

  $request->execute(array("id"=>$tc->Id(),"secid"=>$tc->Secid(),"stid"=>$tc->Stid(),"title"=>$tc->Title(),"content"=>$tc->Content(),"solved"=>$tc->Solved()));
}

//////////////////////
//                  //
//      Getters     //
//                  //
//////////////////////

public function ListTopics($filter, $format="json", $formulas, $offset=0, $limit=15, $add=0){

  $content=$this->_bdd->prepare("SELECT COUNT(*) AS nbr FROM messages WHERE topicid=:tid ;");
  $author=$this->_bdd->prepare("SELECT name, first_name FROM accounts WHERE id=:aid ;");

  $data = $this->_bdd->prepare('SELECT * FROM `topics` WHERE '.$filter.((bool)$add?' AND LOWER(title) LIKE LOWER(:title)':'').' ORDER BY pub_date desc, id desc, solved asc limit '.$limit.' offset '.$offset.';');
  if((bool)$add)$data->execute(array("title"=>$add));
  else $data->execute(array());

  $topics=array();

  while($topicdata = $data->fetch()){

    $content->execute(array('tid'=>$topicdata['id']));
    $number = $content->fetch();
    $topicdata['msgnbr']=$number['nbr'];

    $content->execute(array('tid'=>$topicdata['id']));
    $number = $content->fetch();
    $topicdata['msgnbr']=$number['nbr'];
    $topic = new Topic($topicdata);
    if($format=="json"){
      array_push($topics,json_decode($topic->getJsonFormat()));
    }
    else if($format=="normal"){
      array_push($topics,$topic);
    }
    else if($format=="html"){
      $ctr=rand();
      if((bool)$formulas){
        echo  '<div class="row small-row topic">

                  <div class="col-xs-1 smart-hidden">
                    <div style = "width:75%;">
                      <div class="img-rounded profile-img section-thumbnail" style="background-image:url(\'./images/flat_icons.jpg\');background-position:'.($ctr%3==0?'33% 38%':($ctr%2==0?'33% 75%':'33% 99%')).';background-size: 500%;margin:10px 0px;"></div>
                      </div>
                      </div>
                      <div class="col-sm-4 col-xs-12 col-sm-offset-1">
                      <h5>'.$topic->Title().'</h5>
                      </div>
                      <div class="col-sm-4 col-xs-12">
                      <p style = "margin-bottom:10px;color:#337AB7;"><span class="math-tex">'.$topic->Content().'</span></p>
                      </div>

                      '.($topic->Aid()==$_SESSION['user']->Id()?'<div class="col-sm-2 col-xs-12 delete-topic" data-topic-id="'.$topic->Id().'">
                        <span class="glyphicon glyphicon-remove"></span>
                      </div>':'').'

                      </div>';
      }
      else{
              $author->execute(array("aid"=>$topic->Aid()));
              $name = $author->fetch();
              $color = $topic->Color();

              list($year, $month, $daytime) = explode("-",$topic->Pub_date());
              $dayandtime= explode(" ",$daytime);
              $autorisation = stripos($topic->Content(), $_SESSION['user']->WholeName())||stripos($topic->Content(), $_SESSION['user']->Last())||stripos($topic->Content(), $_SESSION['user']->First())||$_SESSION['user']->Level()>2||$topic->Aid()==$_SESSION['user']->Id();

              echo'
               <div class="row small-row topic clickable" style="border-bottom:2px solid '.$color.';" data-tid = "'.$topic->Id().'">

                        <div class="col-sm-1 col-sm-offset-0 col-xs-4 col-xs-offset-4">
                          <div style = "width:75%;margin:auto;">
                            <div class="img-rounded profile-img section-thumbnail" style="background-image:url(\'./images/flat_icons.jpg\');background-position:'.($ctr%3==0?'33% 38%':($ctr%2==0?'33% 75%':'33% 99%')).';background-size: 500%;margin:10px 0px;"></div>
                            </div>
                            </div>
                            <div class="col-sm-3 col-xs-12">
                            <h5>'.$topic->Title().'</h5>
                            </div>
                            <div class="col-sm-2 col-xs-12">
                            <p><span class="topic-info">'.($topic->Msgnbr()+1).' message'.($topic->Msgnbr()+1>1?'s':'').'</span></p>
                            </div>
                            <div class="col-sm-3 col-xs-12">
                              <span class="topic-info" style="font-size:12px;">Auteur:</span> <span class="topic-info" style="opacity:1;">'.$name['first_name'].' '.$name['name'].'</span>
                            </div>
                            <div class="col-sm-2 col-xs-12">
                              <span class="topic-info">'.$dayandtime[0].'-'.$month.'-'.$year.'</span>
                            </div>
                            '.($autorisation?'<div class="col-sm-1 col-xs-12 delete-topic" data-topic-id="'.$topic->Id().'">
                              <span class="glyphicon glyphicon-remove"></span>
                            </div>':'').'

                            </div>';
      }
    }

  }

  if ($format=="normal")return $topics;
  else if ($format=="json"){
    echo json_encode($topics);
  }

}

public function ShowTopic($tid){

  $uman = new UserManager();

  $data = $this->_bdd->prepare('SELECT * FROM `topics` WHERE id=:id;');
  $data->execute(array("id"=>$tid));

  $TopicMessagedata = $data->fetch();

  $auth = $uman->getUserById($TopicMessagedata['aid']);

  $autorisation = stripos($TopicMessagedata['content'], $_SESSION['user']->WholeName())||stripos($TopicMessagedata['content'], $_SESSION['user']->Last())||stripos($TopicMessagedata['content'], $_SESSION['user']->First())||$_SESSION['user']->Level()>2||$TopicMessagedata['aid']==$_SESSION['user']->Id();

  list($year, $month, $day) = explode("-",$TopicMessagedata['pub_date']);
  $sman = new SubjectManager();
  if($auth->Lesson()){
    $lesson = $sman->ListSubjects("id=".$auth->Lesson(),"normal");
    $lesson = $lesson[0]->Name();
  }

  if($TopicMessagedata['solved']==1){
    $status = '<div class="row small-row" style="margin-bottom:20px;"><div class="col-sm-4 col-sm-offset-4"><div class="btn btn-primary" id="reopen-topic">Réouvrir</div></div></div><div class="row small-row"><div class="col-xs-12"><div class="alert alert-primary">Sujet résolu.</div></div></div>';
  }
  else if($TopicMessagedata['solved']==-1){
    $status = '<div class="row small-row" style="margin-bottom:20px;"><div class="col-sm-4 col-sm-offset-4"><div class="btn btn-primary" id="reopen-topic">Réouvrir</div></div></div><div class="row small-row"><div class="col-xs-12"><div class="alert alert-dead">Sujet fermé.</div></div></div>';
  }
  else if($autorisation&&$TopicMessagedata['solved']==0){
    $status='<div class="row" style="margin-top:30px;">		<div class="col-sm-2 col-sm-offset-4 col-xs-6">			<button class="btn btn-dead btn-lightbox" id="close-topic">Fermer le topic.</button>		</div>		<div class="col-sm-2 col-xs-6">			<button class="btn btn-primary btn-lightbox" id="solve-topic">Sujet résolu.</button>		</div>	</div>';
  }
  else{
    $status='';
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

  echo $status.'
  <div class="row small-row topic topic-message">
  <div class="container-fluid">
  <div class="row">
  <div class="col-xs-12">
  <h3 class="topic-title">'.$TopicMessagedata['title'].'</h3>
  </div>
  </div>
  </div>
  <div class="col-md-2 col-md-offset-0 $author-info col-xs-8 col-xs-offset-2">
  <div class = "profile-img-container">
  <div class="img-rounded profile-img section-thumbnail" style="background-image:url(\'./.'.$auth->Image().'\');margin:10px 0px;"></div>
  </div>
  <div>
  <div class="forum-username">'.$auth->WholeName().'</div>
  <div class="forum-usr-info" style="opacity:0.7">'.$title.'</div>
  <div class="forum-usr-info" style="opacity:0.7">'.$day.'-'.$month.'-'.$year.'</div>
  '.($autorisation?'<div class="message-forum-delete"><div class="topic-control delete-topic" data-topic-id="'.$TopicMessagedata['id'].'"><span class="glyphicon-remove glyphicon"></span></div>'.($auth->Id()==$_SESSION['user']->Id()?'<div class="topic-edit topic-control" data-topic-id="'.$TopicMessagedata['id'].'"><span class="glyphicon-edit glyphicon"></span></div></div>':'</div>'):'').'
  </div>
  </div>
  <div class="col-md-10 col-xs-12 forum-msg-right" >
  '.$TopicMessagedata['content'].'
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

  return intval($TopicMessagedata["solved"]);


}
//////////////////////
//                  //
//     Remover      //
//                  //
//////////////////////
public function Remove(Topic $topic,User $viewer){
  $rem = $this->_bdd->prepare("DELETE FROM `topics` WHERE id=:id");

  if($viewer->Level()<3&&$viewer->Id()!=$topic->Aid()){

    $pos = stripos($topic->Content(), $_SESSION['user']->WholeName())||stripos($topic->Content(), $_SESSION['user']->Last())||stripos($topic->Content(), $_SESSION['user']->First());
    if(!$pos){
      return "Vous ne pouvez supprimer ce topic.";
    }

  }


  $rem->execute(array("id"=>$topic->Id()));
  return "Topic supprimé.";

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
