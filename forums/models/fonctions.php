<?php
//ini_set("display_errors",true);
function postTopic($bdd,$aid,$secid,$stid,$title,$content){

  $request = $bdd->prepare("INSERT INTO `topics`(`id`, `aid`, `secid`, `stid`, `title`, `content`, `solved`, `pub_date`) VALUES (NULL, :aid, :secid, :stid, :title, :content, 0, NOW());");

  $request->execute(array(
    "aid"=>$aid,
    "secid"=>$secid,
    "stid"=>$stid,
    "title"=>$title,
    "content"=>$content
  ));

}

function postMessage($bdd,$aid,$tid,$content,$link,$name){

  $request = $bdd->prepare("INSERT INTO `messages`(`id`, `aid`, `topicid`, `content`, `pub_date`) VALUES (NULL, :aid, :tid, :content, NOW());");

  $request->execute(array(
    "aid"=>$aid,
    "tid"=>$tid,
    "content"=>$content
  ));

  $tids_r = $bdd->prepare("SELECT aid FROM messages WHERE topicid=:tid ;");
  $tids_r->execute(array(
    "tid"=>$tid
  ));
  $aid_r = $bdd->prepare("SELECT aid FROM topics WHERE id=:tid ;");
  $aid_r->execute(array(
    "tid"=>$tid
  ));
  $tpc_aid = $aid_r->fetch();

  $sended_array = array($_SESSION['user']->Id());
  $nfman = new NotifManager();

  if($__SESSION['user']->Id()!=$tpc_aid){
    $notif = new Notif(array(
      "dest"=>$tpc_aid[0],
      "type"=>3,
      "content"=>'<button type="button" class="close"></button><a href="'.$link.'" style="font-size: 20px;font-style: italic;font-family: Sniglet;">'.$name.'</a><br />contient de nouveaux messages.<br /></div>'
    ));
    $nfman->Add($notif);
    $sended_array=array_merge($sended_array,array($tpc_aid[0]));
  }

  while($data = $tids_r->fetch()){
    if(!in_array($data[0],$sended_array)){
        $notif = new Notif(array(
          "dest"=>$data[0],
          "type"=>3,
          "content"=>'<button type="button" class="close"></button><strong>'.$_SESSION['user']->WholeName().'</strong> à posté un nouveau message sur le sujet <br /><br /><a href="'.$link.'" style="font-size: 20px;font-style: italic;font-family: Sniglet;">'.$name.'</a><br /><br /></div>'
        ));
        $nfman->Add($notif);
        $sended_array=array_merge($sended_array,array($data[0]));
    }
  }
}

// Pas supprimer

function countTopics($bdd,$secid,$stid){

  $request = $bdd->prepare("SELECT COUNT(*) AS nbr FROM `topics` WHERE secid=:secid AND stid=:stid;");
  $request->execute(array(

    "secid"=>$secid,
    "stid"=>$stid
  ));

  $data=$request->fetch();

  return $data['nbr'];

}

function getTopics($bdd,$formulas,$secid,$stid,$last,$search){

  if($formulas>0){

    $request = $bdd->prepare("SELECT `id`, `aid`, `title`, `content`, `solved` FROM `topics` WHERE secid=:secid AND ( title LIKE :test OR title LIKE :testb OR title LIKE :testbb ) AND stid=:stid ORDER BY title limit 10 offset ".intval($last-1).";");
    $request->execute(array(

      "secid"=>$secid,
      "stid"=>$stid,
      "test"=>'%'.$search,
      "testb"=>'%'.$search.'%',
      "testbb"=>$search.'%'
    ));


    while($data = $request->fetch()){
      $ctr=rand();
      echo'   <div class="row small-row topic">

      <div class="col-xs-1 smart-hidden">
      <div style = "width:75%;">
      <div class="img-rounded profile-img section-thumbnail" style="background-image:url(\'./images/flat_icons.jpg\');background-position:'.($ctr%3==0?'33% 38%':($ctr%2==0?'33% 75%':'33% 99%')).';background-size: 500%;margin:10px 0px;"></div>
      </div>
      </div>
      <div class="col-sm-4 col-xs-12 col-sm-offset-1">
      <h5>'.$data['title'].'</h5>
      </div>
      <div class="col-sm-4 col-xs-12">
      <p style = "margin-bottom:10px;color:#337AB7;"><span class="math-tex">'.$data['content'].'</span></p>
      </div>

      </div>';
    }
  }
  else if($formulas==0){

    $content=$bdd->prepare("SELECT COUNT(*) AS nbr FROM messages WHERE topicid=:tid ;");
    $author=$bdd->prepare("SELECT name, first_name FROM accounts WHERE id=:aid ;");

    $request = $bdd->prepare("SELECT `id`, `aid`, `title`, `content`, `solved`, `pub_date` FROM `topics` WHERE secid=:secid AND ( title LIKE :test OR title LIKE :testb OR title LIKE :testbb ) AND stid=:stid ORDER BY id desc limit 10 offset ".intval($last-1).";");
    $request->execute(array(

      "secid"=>$secid,
      "stid"=>$stid,
      "test"=>'%'.$search,
      "testb"=>'%'.$search.'%',
      "testbb"=>$search.'%'
    ));

    while($data = $request->fetch()){

      $ctr=rand();

      $content->execute(array("tid"=>$data['id']));
      $nbr = $content->fetch();
      $author->execute(array("aid"=>$data['aid']));
      $name = $author->fetch();

      switch($data['solved']){
        case 1:
        $color='rgba(0,0,200,0.5)';
        break;
        case 0:
        $color='transparent';
        break;
        case -1:
        $color='rgba(0,0,0,0.5)';
        break;

        default:
        $color='transparent';
        break;
      }

      list($year, $month, $daytime) = explode("-",$data['pub_date']);
      list($day, $time) = explode(" ",$daytime);

      echo'
      <div class="row small-row topic clickable" style="border-bottom:2px solid '.$color.';" onclick="window.location.href=\'./view.php\'+window.location.search+\'&tid='.$data['id'].'\';">

      <div class="col-sm-1 col-sm-offset-0 col-xs-4 col-xs-offset-4">
      <div style = "width:75%;margin:auto;">
      <div class="img-rounded profile-img section-thumbnail" style="background-image:url(\'./images/flat_icons.jpg\');background-position:'.($ctr%3==0?'33% 38%':($ctr%2==0?'33% 75%':'33% 99%')).';background-size: 500%;margin:10px 0px;"></div>
      </div>
      </div>
      <div class="col-sm-4 col-xs-12">
      <h5>'.$data['title'].'</h5>
      </div>
      <div class="col-sm-2 col-xs-12">
      <p><span class="topic-info">'.($nbr['nbr']+1).' message'.($nbr['nbr']+1>1?'s':'').'</span></p>
      </div>
      <div class="col-sm-3 col-xs-12">
      <span class="topic-info" style="font-size:12px;">Auteur:</span> <span class="topic-info" style="opacity:1;">'.$name['first_name'].' '.$name['name'].'</span>
      </div>
      <div class="col-sm-2 col-xs-12">
      <span class="topic-info">'.$day.'-'.$month.'-'.$year.'</span>
      </div>


      </div>';
    }
  }

}

function getTopicMessages($bdd,$tid){

  $title = $bdd->prepare("SELECT title, aid, content, pub_date FROM topics WHERE id=:tid");
  $title->execute(array("tid"=>$tid));
  $data1=$title->fetch();

  $author = $bdd->prepare("SELECT img, first_name, name, class, level, lesson, signature FROM accounts WHERE id=:aid");
  $author->execute(array("aid"=>$data1['aid']));
  $data2=$author->fetch();

  $messages = $bdd->prepare("SELECT * FROM messages WHERE topicid=:tid");
  $messages->execute(array("tid"=>$tid));

  list($year, $month, $daytime) = explode("-",$data1['pub_date']);
  list($day, $time) = explode(" ",$daytime);

  switch($data2['level']){

    case 1:
    $title="Elève de ".$data2['class'].($data2['lesson']!="0"?"<span class='forum-usr-info' style='opacity:0.5'>Actif en <em>".$data2['lesson']."</em></span></span>":"</span>");
    break;

    case 2:
    $title="Délégué de ".$data2['class'];
    break;

    case 3:
    $title="Professeur de ".$data2['lesson'];
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
  <div class="container-fluid">
  <div class="row">
  <div class="col-xs-12">
  <h3 class="topic-title">'.$data1['title'].'</h3>
  </div>
  </div>
  </div>
  <div class="col-md-2 col-md-offset-0 author-info col-xs-8 col-xs-offset-2">
  <div class = "profile-img-container">
  <div class="img-rounded profile-img section-thumbnail" style="background-image:url(\'./.'.$data2['img'].'\');margin:10px 0px;"></div>
  </div>
  <div>
  <span class="forum-username">'.$data2['first_name'].' '.$data2['name'].'</span>
  <span class="forum-usr-info" style="opacity:0.7">'.$title.'
  <span class="forum-usr-info" style="opacity:0.3">'.$day.'-'.$month.'-'.$year.'</span>

  </div>
  </div>
  <div class="col-md-10 col-xs-12 forum-msg-right" >
  '.$data1['content'].'
  </div>
  <div class="container-fluid">
  <div class="row">
  <div class="col-md-10 col-md-offset-2 col-xs-12">
  <hr style="margin:10px 0px;"></hr>
  <div class="signature">'.$data2['signature'].'</div>
  </div>

  </div>
  </div>

  </div>';

  while($message = $messages->fetch()){


    $author->execute(array("aid"=>$message['aid']));
    $data2=$author->fetch();



    echo '
    <div class="row small-row topic topic-message">
    <div class="col-md-2 col-md-offset-0 author-info col-xs-8 col-xs-offset-2">
    <div class = "profile-img-container">
    <div class="img-rounded profile-img section-thumbnail" style="background-image:url(\'./.'.$data2['img'].'\');margin:10px 0px;"></div>
    </div>
    <div>
    <span class="forum-username">'.$data2['first_name'].' '.$data2['name'].'</span>
    <span class="forum-usr-info" style="opacity:0.7">'.$title.'
    <span class="forum-usr-info" style="opacity:0.3">'.$day.'-'.$month.'-'.$year.'</span>
    '.($data2['first_name'].' '.$data2['name']==$_SESSION['co_elements']['first'].' '.$_SESSION['co_elements']['name']?'<div class="message-forum-delete"><span class="glyphicon-remove glyphicon"></span><span class="glyphicon-pencil glyphicon"></span></div>':'').'
    </div>
    </div>
    <div class="col-md-10 col-xs-12 forum-msg-right" >
    '.$message['content'].'
    </div>
    <div class="container-fluid">
    <div class="row">
    <div class="col-md-10 col-md-offset-2 col-xs-12">
    <hr style="margin:10px 0px;"></hr>
    <div class="signature">'.$data2['signature'].'</div>
    </div>
    </div>
    </div>

    </div>';
  }


}

?>
