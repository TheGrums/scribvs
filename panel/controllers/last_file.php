<?php
  //ini_set("display_errors",true);
  if(!function_exists('loadClass')){
    date_default_timezone_set('Europe/Brussels');
    $today = date('Y-m-d');
    require('./../../config/db.php');
    session_start();
  }
  $fman = new FileManager();
  $file = $fman->ListFiles($_SESSION['user'], "uid=".$_SESSION['user']->Id(),"normal"," limit 1");
  if(count($file)>0){
  $senddate = $file[0]->Send_date();
?>
  <div class="col-md-6">

    <div class="panel panel-default">
      <div class="panel-heading">Votre dernier fichier</div>
      <div class="panel-body">
        <?php echo '<a target="_blank"><div class="col-xs-6 col-xs-offset-3 file-item"><img src="./.'.$file[0]->Preview().'" /><span style="color:green;" >'.$file[0]->Name().'</span></div></a>'; ?>
      </div>
      <ul class="list-group centergroup">
        <li class="list-group-item">Publication : <strong><?php echo date('d-m-Y',strtotime($senddate)); ?></strong></li>
        <li class="list-group-item">En ligne depuis : <strong><?php $d1 = date_create($today);$d2 = date_create($senddate);$difference = date_diff($d1,$d2);echo  $difference->format('%a'); ?></strong> jours</li>
        <li class="list-group-item"><strong><?php echo $file[0]->Nb_download(); ?></strong> téléchargements</li>
        <li class="list-group-item"><button class="btn btn-primary" onclick = "fileNotif(<?php echo $file[0]->Id(); ?>,$(this));">Rappel</button><button class="btn btn-danger" style = "margin-left:10%;" onclick = "deleteFile(<?php echo $file[0]->Id(); ?>,$(this).parents('.col-md-6').eq(0),'last_file');"><span class="glyphicon glyphicon-trash"></span></button></li>
      </ul>
    </div>

  </div>

<?php
}
else{
?>
<div class="col-md-6">

  <div class="panel panel-default">
    <div class="panel-heading">Votre dernier fichier</div>
    <div class="panel-body">
      <a href="./index.php#1"><button class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span><span style="margin-left:4px;" class="glyphicon glyphicon-file"></span></button></a>
    </div>
    <ul class="list-group centergroup">
      <li class="list-group-item">Publication : <strong>-</strong></li>
      <li class="list-group-item">En ligne depuis : <strong>-</strong> jours</li>
      <li class="list-group-item"><strong>-</strong> téléchargements</li>
    </ul>
  </div>

</div>
<?php } ?>
