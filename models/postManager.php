<?php

class PostManager{

private $_bdd;

public function __construct(){

    $this->setDatabase(getBdd());

}

//////////////////////
//                  //
//      Adder       //
//                  //
//////////////////////

public function Add(Post $pst){

  $ist_req = $this->_bdd->prepare("INSERT INTO `posts`(`id`, `aid`, `pub_date`, `content`, `level`, `dest`, `sticky`) VALUES (NULL, :aid, NOW(), :content, :level, :dest, :sticky);");

  $ist_req->execute(array("aid"=>$pst->Aid(),"content"=>$pst->Content(),"level"=>$pst->Level(),"dest"=>$pst->Destination(),"sticky"=>$pst->Sticky()));

}


//////////////////////
//                  //
//     Updater      //
//                  //
//////////////////////

public function Update(Post $ps){
  $request = $this->_bdd->prepare('UPDATE `posts` SET `content`=:content,`sticky`=:sticky, level=:level WHERE id=:id');

  $request->execute(array(
    "sticky"=>$ps->Sticky(),
    "content"=>$ps->Content(),
    "level"=>$ps->Level(),
    "id"=>intval($ps->Id())
  ));
}

//////////////////////
//                  //
//      Getters     //
//                  //
//////////////////////

public function ListPosts($filter, $begin, $nb, User $viewer, $format="normal"){



  $request = "SELECT * FROM posts WHERE ".$filter." order by sticky desc, pub_date desc limit ".intval($nb)." OFFSET ".intval($begin)." ;";
  $qry = $this->_bdd->query($request);
  $posts=array();
  $love_query=$this->_bdd->prepare("SELECT COUNT(*) AS nbr FROM heart WHERE pid=:pid;");
  $love_usr_query=$this->_bdd->prepare("SELECT COUNT(*) AS nbr FROM heart WHERE uid=:uid AND pid=:pid;");

  $coms_query=$this->_bdd->prepare("SELECT COUNT(*) AS nbr FROM comments WHERE pid=:pid;");
  $coms_usr_query=$this->_bdd->prepare("SELECT COUNT(*) AS nbr FROM comments WHERE uid=:uid AND pid=:pid;");

  $usr_query=$this->_bdd->prepare("SELECT img, name, first_name FROM accounts WHERE id = :uid;");

  while($data=$qry->fetch()){

    $suppressible=0;

    if($viewer->Level()>2||($viewer->Level()==2&&$viewer->ClassId()==$destination['class'])||$viewer->Id()==$data['aid']||stripos($data['content'], $_SESSION['user']->WholeName())||stripos($data['content'], $_SESSION['user']->Last())||stripos($data['content'], $_SESSION['user']->First())){
      $suppressible=1;
    }

    $coms_query->execute(array("pid"=>$data['id']));
    $coms_usr_query->execute(array("uid"=>$viewer->Id(),"pid"=>$data['id']));
    $love_query->execute(array("pid"=>$data['id']));
    $love_usr_query->execute(array("uid"=>$viewer->Id(),"pid"=>$data['id']));
    $usr_query->execute(array("uid"=>$data['aid']));


    $nb = $coms_query->fetch();
    $data["nbr_coms"]=$nb['nbr'];

    $nb = $coms_usr_query->fetch();
    $data["commented"]=(bool)$nb['nbr'];

    $nb = $love_query->fetch();
    $data["nbr_loves"]=$nb['nbr'];

    $nb = $love_usr_query->fetch();
    $data["loved"]=(bool)$nb['nbr'];

    $u = $usr_query->fetch();
    $data["author_pic"]=$u['img'];
    $data["author"]=($u['first_name'].' '.$u['name']);

    $data["suppressible"]=$suppressible;

    $post = new Post($data);
    if($format=="normal")array_push($posts,$post);
    else if($format=="json")array_push($posts,json_decode($post->getJsonFormat()));
  }

  if ($format=="normal")return $posts;
  else if ($format=="json"){
    echo json_encode($posts);
  }

}

public function getPostsByContent(array $combinaisons, $format="normal"){

  $posts=array();
  $usr_query=$this->_bdd->prepare("SELECT name, first_name FROM accounts WHERE id = :uid;");

  for($i=0;$i<count($combinaisons);$i++){
    $req = $this->_bdd->prepare("SELECT id,aid FROM posts WHERE LOWER(content) LIKE LOWER(:opt) AND LOWER(content) NOT LIKE LOWER(:notopt);");
    $req->execute(array("opt"=>"%".$combinaisons[$i]."%","notopt"=>"%>".$combinaisons[$i]."</a>%"));
    while($data = $req->fetch()){

      $usr_query->execute(array("uid"=>$data['aid']));
      $u = $usr_query->fetch();
      $data["author"]=($u['first_name'].' '.$u['name']);


      $post = new Post($data);
      if($format=="normal")array_push($posts,$post);
      else if($format=="json")array_push($posts,json_decode($post->getJsonFormat()));

    }

  }
  if ($format=="normal")return $posts;
  else if ($format=="json"){
    return json_encode($posts);
  }




}

public function getRandomPosts($filter, $nb, User $viewer, $format="normal"){
  $request = "SELECT * FROM posts WHERE ".$filter." ORDER BY RAND() LIMIT ".intval($nb)." ;";
  $qry = $this->_bdd->query($request);
  $posts=array();
  $love_query=$this->_bdd->prepare("SELECT COUNT(*) AS nbr FROM heart WHERE pid=:pid;");
  $love_usr_query=$this->_bdd->prepare("SELECT COUNT(*) AS nbr FROM heart WHERE uid=:uid AND pid=:pid;");

  $coms_query=$this->_bdd->prepare("SELECT COUNT(*) AS nbr FROM comments WHERE pid=:pid;");
  $coms_usr_query=$this->_bdd->prepare("SELECT COUNT(*) AS nbr FROM comments WHERE uid=:uid AND pid=:pid;");

  $usr_query=$this->_bdd->prepare("SELECT img, name, first_name FROM accounts WHERE id = :uid;");

  while($data=$qry->fetch()){

    $suppressible=0;

    if($viewer->Level()>2||($viewer->Level()==2&&$viewer->ClassId()==$destination['class'])||$viewer->Id()==$data['aid']||stripos($data['content'], $_SESSION['user']->WholeName())||stripos($data['content'], $_SESSION['user']->Last())||stripos($data['content'], $_SESSION['user']->First())){
      $suppressible=1;
    }

    $coms_query->execute(array("pid"=>$data['id']));
    $coms_usr_query->execute(array("uid"=>$viewer->Id(),"pid"=>$data['id']));
    $love_query->execute(array("pid"=>$data['id']));
    $love_usr_query->execute(array("uid"=>$viewer->Id(),"pid"=>$data['id']));
    $usr_query->execute(array("uid"=>$data['aid']));


    $nb = $coms_query->fetch();
    $data["nbr_coms"]=$nb['nbr'];

    $nb = $coms_usr_query->fetch();
    $data["commented"]=(bool)$nb['nbr'];

    $nb = $love_query->fetch();
    $data["nbr_loves"]=$nb['nbr'];

    $nb = $love_usr_query->fetch();
    $data["loved"]=(bool)$nb['nbr'];

    $u = $usr_query->fetch();
    $data["author_pic"]=$u['img'];
    $data["author"]=($u['first_name'].' '.$u['name']);

    $data["suppressible"]=$suppressible;

    $post = new Post($data);
    if($format=="normal")array_push($posts,$post);
    else if($format=="json")array_push($posts,json_decode($post->getJsonFormat()));
  }

  if ($format=="normal")return $posts;
  else if ($format=="json"){
    echo json_encode($posts);
  }

}

//////////////////////
//                  //
//     Remover      //
//                  //
//////////////////////
public function Remove(Post $post,User $viewer){
  $rem = $this->_bdd->prepare("DELETE FROM `posts` WHERE id=:id");

  if($viewer->Level()<3&&$viewer->Id()!=$post->Aid()){

    $pos = stripos($get['content'], $_SESSION['user']->WholeName())||stripos($get['content'], $_SESSION['user']->Last())||stripos($get['content'], $_SESSION['user']->First());
    if(!$pos&&(($viewer->Level()==2||$viewer->Level()==3)&&$post->Dest()==$viewer->ClassId())){
      return "Vous ne pouvez supprimer cette publication.";
    }

  }


  $rem->execute(array("id"=>$post->Id()));
  return "Publication supprimée.";

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
