<?php
//ini_set("display_errors",true);
require('./../../config/db.php');
session_start();
if(isset($_SESSION['user'])){

if($_SESSION['user']->Level()==3){
?>


<div class="row">
<?php
  require("../controllers/imail_form.php");
?>
</div>

<?php
}
}
?>
