<?php
//ini_set("display_errors",true);
require('./../../config/db.php');
session_start();
if(isset($_SESSION['user'])){
	$gman = new GroupManager();
	$ogr = $gman->getOwnedGroups($_SESSION['user'],"normal");
  $uman = new UserManager();
?>
	<div class="col-sm-12 smart-col">
    <div class="container-fluid">
			<div class="row" style="margin:30px 0px 80px;">
				<div class="col-md-10 col-md-offset-1 col-xs-12 smart-col">
					<div class="well large-well" style="padding-top:50px;padding-bottom:40px;">
						<div clas="container-fluid">
							<div class="row">
								<div class="col-md-3 col-md-offset-2">
									<div class="input-group stylish-input-group">
										<input class="form-control" id="search-space-groups" placeholder="Cherchez un groupe" type="text">
										<span class="input-group-addon">
											<button>
												<span class="glyphicon glyphicon-search"></span>
											</button>
										</span>
									</div>
								</div>
								<div class="col-md-2">
									<h4>OU</h4>
								</div>
								<div class="col-md-3">
									<div class="btn btn-primary" style="width:80%;" onclick="callCreationTool();">Créez un groupe</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-10 col-sm-offset-1">
									<div class="list-group"  id="group-results-area">

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row" id="add-row">

			</div>
      <div class="row">
        <?php
          for($i=0;$i<count($ogr);$i++){

        ?>
        <div class="col-sm-6">
          <div class="panel panel-default group-card" data-group-id="<?php echo $ogr[$i]->Id(); ?>">
            <div class="panel-heading"><?php echo $ogr[$i]->Name(); ?> <span class="glyphicon glyphicon glyphicon-trash panel-delete" onclick="detachGroupOwner(<?php echo $ogr[$i]->Id(); ?>,$(this).parents('.panel').eq(0));"></span><span class="glyphicon glyphicon glyphicon-chevron-down panel-down"></span></div>
            <table class="table">
              <tbody>
                <tr>
                <?php
                  $members = $ogr[$i]->MembersArray();
                  for($j=0;$j<count($members);$j++){

                    $user = $uman->getUserById($members[$j]);

                    echo '<td>'.$user->WholeName().'<button class="btn btn-small btn-danger" onclick="detachGroupMember('. $ogr[$i]->Id().', '.$user->Id().',$(this).parents(\'td\').eq(0));" style="padding: 2px 8px 5px;"><span class="glyphicon glyphicon-ban-circle" style="font-size:0.9em;"></span></button></td>';


                    echo ($j%2==1?"</tr><tr>":"");

                  }
                ?>
              </tr>
							<tr>
								<td colspan="2">
									<div class="container-fluid">
										<div class="row">
												<div class="col-lg-6 col-lg-offset-3">
													<div class="help-block" style="color:red;">

													</div>
													<div class="input-group">
														<input type="text" id="suggestInput-<?php echo $i; ?>" class="form-control" placeholder="Ajouter" onkeyup="autoSuggest($(this),$('#quick-preview-<?php echo $i; ?>'),'.',undefined,createSimplePreview);">
														<span class="input-group-btn">
															<button style = "padding-right:6px;" class="btn btn-primary quick-add-member" type="button"><span class="glyphicon glyphicon-plus" style="float:none;"></span>&nbsp;</button>
														</span>
													</div>
												</div>
										</div>
										<div class="row">
											<div class="col-lg-6 col-lg-offset-3">
												<div class="list-group " style="max-height:250px;width:100%;overflow-y:scroll;cursor:pointer;" data-linked-to = "#suggestInput-<?php echo $i; ?>" id="quick-preview-<?php echo $i; ?>">

												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
              </tbody>
            </table>
          </div>
        </div>
        <?php
          echo ($i%2==1?"</div><div class='row'>":"");
          }
        ?>
      </div>
    </div>
  </div>
<?php
}
?>
