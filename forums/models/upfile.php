<?php
header('content-type: application/json');
ob_start('ob_gzhandler');
header('Cache-Control: max-age=31536000, must-revalidate');
//ini_set("display_errors",true);
session_start();

if(!isset($_SESSION['user'])){

  header("Location: ../index.php");

}
else{

  require('./../../config/db.php');

  $images = array();
  if(isset($_FILES['upload'])){
          $target = '../uploads/';
          $extensions = array('jpg','gif','png','jpeg');
          $ext  = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);

              if (in_array(strtolower($ext),$extensions)){
                  if(isset($_FILES['upload']['error']) && UPLOAD_ERR_OK === $_FILES['upload']['error']){
                      $img_name = md5(uniqid()) .'.'. $ext;
                      switch (strtolower($ext)) {
                          case 'jpg':
                              $img = imagecreatefromjpeg($_FILES['upload']['tmp_name']);
                              break;
                          case 'jpeg':
                              $img = imagecreatefromjpeg($_FILES['upload']['tmp_name']);
                              break;
                          case 'png':
                              $img = imagecreatefrompng($_FILES['upload']['tmp_name']);
                              break;
                          case 'gif':
                              $img = imagecreatefromgif($_FILES['upload']['tmp_name']);
                          break;
                          default:
                              $img = imagecreatefromjpeg($_FILES['upload']['tmp_name']);
                          }

                      $width = imagesx($img);
                      $height = imagesy($img);

                      $tmp_img = imagecreatetruecolor($width, $height);

                      imageinterlace($tmp_img,true);

                      imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $width, $height, $width, $height);
                      $pathToImage = $target.$img_name;


                      switch (strtolower($ext)) {
                          case 'jpg':
                              imagejpeg($tmp_img, $pathToImage);
                              break;
                          case 'jpeg':
                              imagejpeg($tmp_img, $pathToImage);
                              break;
                          case 'png':
                              imagepng($tmp_img, $pathToImage);
                              break;
                          case 'gif':
                              imagegif($tmp_img, $pathToImage);
                          break;
                          default:
                              imagejpeg($tmp_img, $pathToImage);
                          }
                          $result = $pathToImage;
                      if($result){
                          $jsondata = array("uploaded"=>1,"fileName"=>$imb_name,"url"=>substr($pathToImage,1));
                          echo json_encode($jsondata);
                      }
                  }
              }

  }

}
?>
