<?php

class File{

  private $_path, $_uid, $_dest, $_name, $_id, $_suppressible,$_preview,$_removed_by,$_nb_download,$_send_date,$_aname,$_afirstname;

  public function __construct(array $data){
      $this->feed($data);
  }

  //////////////////////
  //                  //
  //      Feeder      //
  //                  //
  //////////////////////

  public function feed(array $donnees){
    foreach ($donnees as $key => $value){
      $method = 'set'.ucfirst($key);
      if (method_exists($this, $method)){
        $this->$method($value);
      }
    }
  }

  //////////////////////
  //                  //
  //      Getters     //
  //                  //
  //////////////////////

  public function Send_date(){
    return $this->_send_date;
  }
  public function Nb_download(){
    return $this->_nb_download;
  }
  public function Path(){
    return $this->_path;
  }
  public function RemovedBy(){
    return $this->_removed_by;
  }
  public function Uid(){
    return $this->_uid;
  }
  public function Dest(){
    return $this->_dest;
  }
  public function DestArr(){
    $data = explode ("|",$this->_dest);
    return $data;
  }
  public function Name(){
    return $this->_name;
  }
  public function Id(){
    return $this->_id;
  }
  public function Suppressible(){
    return (bool)$this->_supressible;
  }
  public function Preview(){
    return $this->_preview;
  }
  public function First(){
    return $this->_afirstname;
  }
  public function Last(){
    return $this->_aname;
  }


  //////////////////////
  //                  //
  //      Setters     //
  //                  //
  //////////////////////
  public function setNb_download($a){
    $this->_nb_download=$a;
  }
  public function setSend_date($a){
    $this->_send_date=$a;
  }
  public function setId($a){
    $this->_id=$a;
  }
  public function setRemoved_by($a){
    $this->_removed_by=$a;
  }
  public function setDest($a){
    $this->_dest=$a;
  }
  public function setPath($a){
    $this->_path=$a;
  }
  public function setAname($a){
    $this->_aname=$a;
  }
  public function setSendstring($a){
    $this->_sendstring = $a;
  }
  public function setAfirst_name($first){
    $this->_afirstname=$first;
  }
  public function setName($name){
    $this->_name=$name;
  }
  public function setUid($a){
    $this->_uid=$a;
  }
  public function setSuppressible($a){
    $this->_suppressible=(bool)$a;
  }
  public function setPreview($a){
    $this->_preview=$a;
  }

  //////////////////////
  //                  //
  //      Other       //
  //                  //
  //////////////////////

  public function sendNotif($type=1){
    $grman = new GroupManager();
    if(is_string($this->_dest)){
      if(str_split($this->_dest)[0]!='y')
        $groupsarray = $grman->getGroups("LOWER(name) = LOWER('".$this->_dest."') OR id='.$this->_dest.'");
      else
        $groupsarray = $grman->getGroups("LOWER(name) LIKE '".str_split($this->_dest)[1]."%'");
    }


    for($m=0;$m<count($groupsarray);$m++){

    $group = $groupsarray[$m];
    $members = $group->MembersArray();
    $nfman = new NotifManager();

    for($b=0;$b<count($members);$b++){
      if($type == 1)$content = '<button type="button" class="close"></button><strong>'.$_SESSION['user']->WholeName().'</strong> vous a envoyé un fichier. <br /><div class="container-fluid"><div class="row"><a href="'.substr($this->_path,1).'" download="'.$this->_name.'" target="_blank"><div class="col-sm-12 file-item"><img src="'.$this->_preview.'" style="width:20%;" /><br/><span style="color:blue;">'.$this->_name.'</span></div></a></div></div></div>';
      if($type == 10)$content = '<button type="button" class="close"></button><strong>'.$_SESSION['user']->WholeName().'</strong><br /> vous rappelle de télécharger ce fichier : <br /><div class="container-fluid"><div class="row"><a href="'.substr($this->_path,1).'" download="'.$this->_name.'" target="_blank"><div class="col-sm-12 file-item"><img src="'.$this->_preview.'" style="width:20%;" /><br/><span style="color:blue;">'.$this->_name.'</span></div></a></div></div></div>';


      if($members[$b]!=$_SESSION['user']->Id()){
        $notif = new Notif(array(
          "type"=>$type,
          "dest"=>$members[$b],
          "content"=>$content
        ));
        $nfman->Add($notif);
      }

    }
    }
  }

  public function getJsonData(){
     $var = get_object_vars($this);
     foreach($var as &$value){
        if(is_object($value) && method_exists($value,'getJsonData')){
           $value = $value->getJsonData();
        }
     }
     return $var;
  }

  public function getJsonFormat(){
    return json_encode($this->getJsonData());
  }


}

?>
