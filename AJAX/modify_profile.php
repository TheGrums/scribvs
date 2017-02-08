<?php
header('content-type: application/json');
  ob_start('ob_gzhandler');
  header('Cache-Control: max-age=31536000, must-revalidate');
if(!function_exists('loadClass'))require_once '../config/db.php';
session_start();
if(isset($_SESSION["user"])){

  if(isset($_POST['imgData'])){


    $imageData=$_POST['imgData'];


    if(strpos($imageData, 'image') !== false){

      $filteredData=substr($imageData, strpos($imageData, ",")+1);
      $unencodedData=base64_decode($filteredData);

      $img_name = md5(uniqid()) .'.png';

      $fp = fopen( '../uploads/'.$img_name, 'wb' );
      fwrite( $fp, $unencodedData);
      fclose( $fp );

      $_SESSION['user']->setImg('./uploads/'.$img_name);
    }
  }

  if(!isset($_POST['imgData'])&&count($_POST)>=1||count($_POST)>1){
    foreach ($_POST as $key => $value){
      $method = 'set'.ucfirst($key);
      if (method_exists($_SESSION["user"], $method)){
        $_SESSION["user"]->$method($value);
      }
    }
  }

  $man = new UserManager();
  $man->Update($_SESSION["user"]);
  echo $_SESSION["user"]->getJsonFormat();
}
else{
  echo "failed";
}


?>
