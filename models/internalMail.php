<?php
//ini_set("display_errors",true);
class InternalMail{

private $_id, $_aid, $_content, $_send_date, $_dest, $_deleted_by;

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

public function Id(){
  return $this->_id;
}
public function Aid(){
  return $this->_aid;
}
public function Send_date(){
  return $this->_send_date;
}
public function Embed_Send_date(){
  list($year, $month, $day_t) = explode("-",$this->_send_date);
  list($day,$time)=explode(" ",$day_t);
  return $day."/".$month."/".$year." ".$time;
}
public function Content(){
  return $this->_content;
}
public function Dest(){
  return $this->_dest;
}
//////////////////////
//                  //
//      Setters     //
//                  //
//////////////////////

public function setContent($a){
  $this->_content = $a;
}
public function setDest($a){
  $this->_dest=$a;
}
public function setId($a){
  $this->_id=$a;
}
public function setSend_date($a){
  $this->_send_date=$a;
}
public function setAid($a){
  $this->_aid = $a;
}


//////////////////////
//                  //
//      Other       //
//                  //
//////////////////////

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
public function getHtmlFormat(User $viewer){
  $condition = $viewer->Id()==$this->_aid;
  if($condition){

    $man=new UserManager();

    $usar = explode("|",$this->_dest);

    if(count($usar)>1){
      $destination = "Groupe(s): ";
      for($i=0;$i<count($usar)&&$i<3;$i++){
        $us = $man->getUserById($usar[$i]);
        $destination.=$us->WholeName()." ";
      }
    }
    else {
      $us = $man->getUserById($usar[0]);
      $destination = $us->WholeName();
    }

    $sender=$viewer;
    $shape = '<div class="panel panel-default">
      <div class="panel-heading" style="text-align:left;">
        '.$destination.'
        <span class="glyphicon glyphicon-chevron-down panel-down"></span>
        <span class="glyphicon panel-date">'.$this->Embed_Send_date().'</span>
      </div>
      <div class="panel-body" style="display:none;">
        <div class="well large-well" style="text-align:left;">
        '.$this->_content.'
        </div>
      </div>
    </div>';
  }
  else {

    $uman = new UserManager();
    $sender = $uman->getUserById($this->_aid);

    $shape = '<div class="panel panel-default">
      <div class="panel-heading" style="text-align:left;">
        '.$sender->WholeName().'
        <span class="glyphicon glyphicon-chevron-down panel-down"></span>
        <span class="glyphicon panel-date">'.$this->Embed_Send_date().'</span>
      </div>
      <div class="panel-body" style="display:none;">
        <div class="well large-well" style="text-align:left;">
        '.$this->_content.'
        </div>
      </div>
      <div class="panel-footer">
        <div class="btn btn-small btn-submit" style="float:none;" onclick="window.location.href = \'./messages.php?dest='.$sender->WholeName().'&destid='.$sender->Id().'#1\'">Répondre</div>
      </div>
    </div>';

  }


  return $shape;
}



}
?>
