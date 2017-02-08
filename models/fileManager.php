<?php
class FileManager{

  private $_bdd;

  public function __construct(){

    $this->setDatabase(getBdd());


  }

  //////////////////////
  //                  //
  //      Adder       //
  //                  //
  //////////////////////

  public function Add(File $fl){


    $req = $this->_bdd->prepare("INSERT INTO `files`(`id`, `uid`, `name`, `path`, `dest`, `removed_by`, send_date, nb_download) VALUES (NULL, :uid, :name, :filepath, :dest, '', NOW(), 0) ;");
    $getId = $this->_bdd->query('SELECT id FROM files order by id desc limit 1 ;');
    $id = $getId->fetch();
    $req->execute(array(
      "uid"=>$fl->Uid(),
      "name"=>$fl->Name(),
      "filepath"=>$fl->Path(),
      "dest"=>(string)$fl->Dest()
    ));
    return $id;


  }


  //////////////////////
  //                  //
  //     Updater     //
  //                  //
  //////////////////////

  public function Update(File $fl){
    $request = $this->_bdd->prepare('UPDATE `files` SET `uid`=:uid,`name`=:name,`path`=:filepath,`dest`=:dest,removed_by=:rem, nb_download=:nbd WHERE id = :id;');

    $request->execute(array(
      "id"=>$fl->Id(),
      "uid"=>$fl->Uid(),
      "name"=>$fl->Name(),
      "filepath"=>$fl->Path(),
      "dest"=>$fl->Dest(),
      "nbd"=>$fl->Nb_download(),
      "rem"=>$fl->RemovedBy()
    ));
  }

  //////////////////////
  //                  //
  //      Getters     //
  //                  //
  //////////////////////

  public function ListFiles(User $viewer, $filter, $format="normal", $add="", $depth=""){


    $request = "SELECT * FROM files WHERE ".$filter." order by id DESC ".$add.";";
    $qry = $this->_bdd->query($request);
    $files=array();

    while($data=$qry->fetch()){

      $ext  = pathinfo($data['path'], PATHINFO_EXTENSION);
      $previews = array("avi","css","doc","html","mp3","pdf","png","ppt","psd","wav","xls","zip","paper");

      if(in_array(strtolower($ext),$previews)){
        $data["preview"]=$depth."./pictures/".$ext.".svg";
      }
      else{
        $data["preview"]=$depth."./pictures/cloud.svg";
      }

      $suppressible=0;

      if($viewer->Level()>2||($viewer->Level()==2&&$viewer->ClassId()==$destination['class'])||$viewer->Id()==$data['uid']){
        $suppressible=1;
      }
      $data["suppressible"]=$suppressible;

      if(strlen($data["name"])>20&&$format!="normal")$data["name"]=substr($data["name"],0,7).'...'.substr($data["name"],-9);
      $data["path"]=$depth.$data["path"];
      $fl = new File($data);
      if($format=="normal")array_push($files,$fl);
      else if($format=="json")array_push($files,json_decode($fl->getJsonFormat()));

    }

    if ($format=="normal")return $files;
    else if ($format=="json"){
      echo json_encode($files);
      return;
    }

  }

  public function ListFilesSortedBySender(User $viewer, $filter, $format="normal", $depth=""){
    $request = "SELECT files.*, accounts.name as aname, accounts.first_name as afirst_name FROM accounts, files WHERE files.uid = accounts.id AND (".$filter.") order by accounts.name ;";
    $qry = $this->_bdd->query($request);
    $files=array();

    while($data=$qry->fetch()){

      $ext  = pathinfo($data['path'], PATHINFO_EXTENSION);
      $previews = array("avi","css","doc","html","mp3","pdf","png","ppt","psd","wav","xls","zip","paper");

      if(in_array(strtolower($ext),$previews)){
        $data["preview"]=$depth."./pictures/".$ext.".svg";
      }
      else{
        $data["preview"]=$depth."./pictures/cloud.svg";
      }

      $suppressible=0;

      if($viewer->Level()>2||($viewer->Level()==2&&$viewer->ClassId()==$destination['class'])||$viewer->Id()==$data['uid']){
        $suppressible=1;
      }
      $data["suppressible"]=$suppressible;

      if(strlen($data["name"])>20&&$format!="normal")$data["name"]=substr($data["name"],0,7).'...'.substr($data["name"],-9);
      $data["path"]=$depth.$data["path"];
      $fl = new File($data);
      if($format=="normal")array_push($files,$fl);
      else if($format=="json")array_push($files,json_decode($fl->getJsonFormat()));

    }

    if ($format=="normal")return $files;
    else if ($format=="json"){
      echo json_encode($files);
      return;
    }


  }

  //////////////////////
  //                  //
  //     Remover      //
  //                  //
  //////////////////////
  public function Remove(File $fl){
    $rem = $this->_bdd->prepare("DELETE FROM `files` WHERE id=:id");
    $rem->execute(array("id"=>$fl->Id()));
    return "Fichier supprimé.";
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
