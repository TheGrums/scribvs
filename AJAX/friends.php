<?php
  //ini_set("display_errors",true);
  if(!function_exists('loadClass'))require_once '../config/db.php';
  session_start();

  $friendsleft = $_SESSION['user']->FriendsGroup()->FriendsLeft();
  $friends=$_SESSION['user']->FriendsGroup();
  $friends_array = $friends->MembersArray();
  $man = new GroupManager();

?>
<div class="container-fluid profile-container ">
  <div class="row">
    <div class="col-md-10 col-md-offset-1 smart-col">
      <div class="well well-lg">Vous pouvez encore ajouter <?php echo '<strong>'.$friendsleft.'</strong> ami'.($friendsleft>1?'s':'') ?> à votre groupe.</div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8 col-md-offset-2"><div class="list-group friends">
    <?php
      $usman = new UserManager();

      if($friendsleft!=10){
      for($i=0;$i<count($friends_array);$i++){

        $user = $usman->getUserById($friends_array[$i]);

     ?>
     <a href="./profile.php?q=<?php echo $user->Last().'-'.$user->First(); ?>" class="list-group-item">
       <h4 class="list-group-item-heading"><img src="<?php echo $user->Image();?>" style="width:60px;height:60px;"/><?php echo $user->WholeName(); ?></h4>
       <p class="list-group-item-text">
        <?php $groups = $man->getGroupsByMember($user->Id(),"normal");for($j=0;$j<count($groups);$j++){ ?>
          <span class="label label-default"><?php echo $groups[$j]->Name(); ?></span>
        <?php } ?>
         <span class="label label-primary"><?php echo $user->Status(); ?></span>
         <button style = "float:none;" class="btn btn-danger btn-small delete-friend" role="button"><span class="glyphicon glyphicon-ban-circle"></span></button>
       </p>
     </a>
     <?php }} ?>

   </div></div>
  </div>
  <div class="row">
    <div class="col-sm-4 col-sm-offset-4">
      <div style="margin:10px 0px 20px;">
        <div class="input-group stylish-input-group">
          <input type="text" class="form-control" id="search-space" data-secid="3" data-stid="1" placeholder="Retrouver des amis">
          <span class="input-group-addon">
            <button>
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="row user-preview" style="min-height:100vh;">
    <div class="col-md-8 col-md-offset-2">
      <div class="list-group">

        <img class='loader' src='./pictures/loader.gif' style='width:10%;height:auto;margin-left:45%;margin-right:45%;position:absolute;display:none;' />
      </div>
    </div>
  </div>


  </div>

</div>
