<?php

class SubjectManager{

private $_bdd;

public function __construct(){

    $this->setDatabase(getBdd());

}

//////////////////////
//                  //
//      Adder       //
//                  //
//////////////////////

public function Add(Subject $sb){

  $ist_req = $this->_bdd->prepare("INSERT INTO `subjects`(`id`, `name`, `description`, `img`, `formules`) VALUES (NULL,:name,:description,:img,:formules) ;");

  $ist_req->execute(array("name"=>$sb->Name(),"description"=>$sb->Desctiption(),"img"=>$sb->Img(),"formules"=>$sb->Formules()));

}


//////////////////////
//                  //
//     Updater     //
//                  //
//////////////////////

public function Update(Subject $sb){
  $request = $this->_bdd->prepare('UPDATE `subjects` SET `name`=:name,`description`=:description,`img`=:img,`formules`=:formules WHERE id=:id');

  $request->execute(array("name"=>$sb->Name(),"description"=>$sb->Desctiption(),"img"=>$sb->Img(),"formules"=>$sb->Formules()));
}

//////////////////////
//                  //
//      Getters     //
//                  //
//////////////////////

public function ListSubjects($filter, $format="json"){



  $data = $this->_bdd->query('SELECT * FROM `subjects` WHERE '.$filter.' ORDER BY name ASC;');

  $contenu = $this->_bdd->prepare('SELECT title  FROM topics WHERE secid=:secid AND stid=:stid order by id desc;');

  $subjects=array();

  while($section = $data->fetch()){

    $contenu->execute(array('secid'=>2,'stid'=>$section['id']));
    $number = $contenu->fetch();
    $section['last']=$number['title'];
    $subject = new Subject($section);
    if($format=="json"){
      array_push($subjects,json_decode($subject->getJsonFormat()));
    }
    else if($format=="normal"){
      array_push($subjects,$subject);
    }

  }

  if ($format=="normal")return $subjects;
  else if ($format=="json"){
    echo json_encode($subjects);
  }

}

//////////////////////
//                  //
//     Remover      //
//                  //
//////////////////////
public function Remove(Subject $sb,User $viewer){
  $rem = $this->_bdd->prepare("DELETE FROM `subjects` WHERE id=:id");

  if($viewer->Level()<3){

      return "Vous ne pouvez supprimer ce sujet.";

  }


  $rem->execute(array("id"=>$post->Id()));
  return "Sujet supprimé.";

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
