<?php
//ini_set("display_errors",true);
require('./../../config/db.php');
session_start();
if(isset($_SESSION['user'])){


if($_SESSION['user']->Level()>=3&&isset($_POST['type'])){
  switch($_POST['type']){
    case "file":
      $fman = new FileManager();
      $file = $fman->ListFiles($_SESSION['user'], "id=".intval($_POST['id']),"normal"," limit 1");
      if($file[0]->Uid()==$_SESSION['user']->Id()){
        $file[0]->sendNotif(10);
      }
    break;



  }


}

}
