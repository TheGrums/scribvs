<?php
if($_GET["type"]=="json"){
  header('content-type: application/json');
  ob_start('ob_gzhandler');
  header('Cache-Control: max-age=31536000, must-revalidate');
}
//ini_set("display_errors",true);
require_once("../config/db.php");
require_once("../models/functions.php");
session_start();
if(isset($_SESSION['user'])){


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
          break;
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
              break;
            }
          $path = $pathToImage;
          $status=1;
      }
    }
    else{
      $status = 0;
    }
  }
  else{
    $status = 0;
  }

}
if($_GET['type']=="html"){
$funcNum = $_GET['CKEditorFuncNum'] ;
$CKEditor = $_GET['CKEditor'] ;
$langCode = $_GET['langCode'] ;
$url = $path;
$message = '';
die("<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>");
}
?>
{
    "uploaded": <?php echo $status; ?>,
    "fileName": "<?php echo $_FILES['upload']['name']; ?>",
    "url": "<?php echo $path; ?>"
}
