<?php
$grman = new groupManager();
$groups = $grman->getOwnedGroups($_SESSION['user']);
if(count($groups)>0){
?>
  <div class="col-md-6 animated fadeIn">

    <div class="panel panel-default">
      <div class="panel-heading">Vos groupes</div>
        <ul class="list-group">
          <?php
            for($i=0;$i<count($groups);$i++){
              if($groups[$i]->Name()!=$_SESSION['user']->WholeName()){
           ?>
           <li class="list-group-item"><?php echo $groups[$i]->Name(); ?><button class="btn btn-small btn-danger" onclick = "detachGroupOwner(<?php echo $groups[$i]->Id(); ?>,$(this).parents().eq(0));"><span class="glyphicon glyphicon-trash" style = "font-size:0.9em;"></span></button></li>
          <?php }
          else {
            echo '<li class="list-group-item">Vos amis</li>';
          }

          } ?>
          <li class="list-group-item" style="text-align:center;"><a href="./index.php#2"><button class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span></button></a></li>
        </ul>
      </div>
    </div>

<?php }else{ }?>
