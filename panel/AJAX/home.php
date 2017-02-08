<?php
//ini_set("display_errors",true);
date_default_timezone_set('Europe/Brussels');
require('./../../config/db.php');
session_start();
if(isset($_SESSION['user'])){

if($_SESSION['user']->Level()==3){
  if($_SESSION['user']->Lesson()=="")require("../controllers/form_lightbox.php");
?>


<div class="row">
<?php
  require("../controllers/class_activity_graph.php");
  require("../controllers/random_posts.php");
?>
</div>

<?php
}
}
?>
