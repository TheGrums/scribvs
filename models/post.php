<?php

class Post{

private $_id, $_nbr_coms, $_nbr_loves, $_content, $_author, $_author_pic, $_pub_date, $_suppressible, $_level, $_dest, $_sticky, $_commented, $_loved, $_aid;

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
public function Nbr_coms(){
  return $this->_nbr_coms;
}
public function Nbr_loves(){
  return $this->_nbr_loves;
}
public function Content(){
  return $this->_content;
}
public function Author(){
  return $this->_author;
}
public function Author_pic(){
  return $this->_author_pic;
}
public function Pub_date(){
  return $this->_pub_date;
}
public function Suppressible(){
  return $this->_supressible;
}
public function Level(){
  return $this->_level;
}
public function Destination(){
  return $this->_dest;
}
public function Sticky(){
  return (bool)$this->_sticky;
}
public function Loved(){
  return (bool)$this->_loved;
}
public function Commented(){
  return (bool)$this->_loved;
}
public function Aid(){
  return $this->_aid;
}
public function Id(){
  return $this->_id;
}
public function getHtml(){

  $com="glyphicon-pencil";
	$lov="glyphicon-heart-empty";
	if($this->_commented)$com="glyphicon-pencil under-pub-active";
	if($this->_loved)$lov="glyphicon-heart under-pub-active";

	$pub = '<div class = "container-fluid" id = "pub-'.$this->_id.'">';
		$pub.='<div class = "row pub-header">';

			$pub.='<div class = "pub-info col-xs-3" style="font-size:11px;">'.$this->_author;
			$pub.='</div>';

			$pub.='<div class = "col-xs-4 col-xs-offset-1 col-sm-2 col-sm-offset-2">';
				$pub.='<img src="'.$this->_author_pic.'" class = "pub-img"/>';
			$pub.='</div>';

			$pub.='<div class = "pub-info col-xs-3 col-xs-offset-1 col-md-offset-2" style="font-size:10px;">'.$this->_pub_date;
			$pub.='</div>';

		$pub.='</div>';

		$pub.='<hr></hr>';

		$pub.='<div class = "pub-content item">'.$this->_content;
		$pub.='</div>';

		$pub.='<div class = "row">';

			$pub.='<div class = "col-sm-2 col-xs-4 under-pub under-'.$lov.'" id = '.$this->_id.'>';
				$pub.='<span class = "glyphicon '.$lov.' under-pub-content"></span><span class = "under-pub-content" style="color:black;">'.$this->_nbr_loves.'</span>';

      $pub.='</div>';

			$pub.='<div class = "col-sm-2 col-xs-4 under-pub under-'.$com.'">';
				$pub.='<span class = "glyphicon '.$com.' under-pub-content"></span><span class = "under-pub-content" style="color:black;">'.$this->_nbr_coms.'</span>';
			$pub.='</div>';

			if($this->_suppressible){

						$pub.='<div class = "col-sm-2 col-xs-4 under-pub pub-remove">';
								$pub.='<span class = "glyphicon glyphicon-remove under-pub-content" data-pub-id="'.$this->_id.'"></span>';
							$pub.='</div>';
			}
	$pub.='</div></div>';

	return $pub;
}
public function getPanelHtml(){

  $com="glyphicon-pencil";
	$lov="glyphicon-heart-empty";
	if($this->_commented)$com="glyphicon-pencil under-pub-active";
	if($this->_loved)$lov="glyphicon-heart under-pub-active";

	$pub = '<div class = "container-fluid" id = "pub-'.$this->_id.'">';
		$pub.='<div class = "row pub-header">';

			$pub.='<div class = "pub-info col-xs-3" style="font-size:11px;">'.$this->_author;
			$pub.='</div>';

			$pub.='<div class = "col-xs-4 col-xs-offset-1 col-sm-2 col-sm-offset-2">';
				$pub.='<img src="../'.$this->_author_pic.'" class = "pub-img"/>';
			$pub.='</div>';

			$pub.='<div class = "pub-info col-xs-3 col-xs-offset-1 col-md-offset-2" style="font-size:10px;">'.$this->_pub_date;
			$pub.='</div>';

		$pub.='</div>';

		$pub.='<hr></hr>';

		$pub.='<div class = "pub-content item">'.$this->_content;
		$pub.='</div>';

		$pub.='<div class = "row">';

			if($this->_suppressible){

						$pub.='<div class = "col-sm-2 col-xs-4 under-pub pub-remove" onclick="deletePost($(this),'.$this->_id.');">';
								$pub.='<button class = "btn btn-danger btn-small" style="margin:5px 0px 10px;">Censurer</button>';
							$pub.='</div>';
			}
	$pub.='</div></div>';

	return $pub;
}

//////////////////////
//                  //
//      Setters     //
//                  //
//////////////////////

public function setNbr_coms($nbr_coms){
  $this->_nbr_coms=$nbr_coms;
}
public function setNbr_loves($nbr_loves){
  $this->_nbr_loves=$nbr_loves;
}
public function setAuthor_pic($author_pic){
  $this->_author_pic=$author_pic;
}
public function setAuthor($author_name){
  $this->_author=$author_name;
}
public function setPub_date($pub_date){
  $this->_pub_date=$pub_date;
}
public function setContent($content){
  $this->_content=$content;
}
public function setSuppressible($supp){
    $this->_suppressible = (bool)$supp;
}
public function setLevel($lev){
  $this->_level=$lev;
}
public function setDest($dest){
  $this->_dest=$dest;
}
public function setSticky($st){
  $this->_sticky=$st;
}
public function setLoved($l){
  $this->_loved=$l;
}
public function setCommented($c){
  $this->_commented=$c;
}
public function setAid($aid){
  $this->_aid=$aid;
}
public function setId($id){
  $this->_id=$id;
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


}


?>
