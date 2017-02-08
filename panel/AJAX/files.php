<?php
//ini_set("display_errors",true);
require('./../../config/db.php');
session_start();
if(isset($_SESSION['user'])){
	$gman = new GroupManager();
	$gr = $gman->getOwnedGroups($_SESSION['user'],"normal");

	$fman = new FileManager();
	$filter="uid=".$_SESSION['user']->Id();
	$files = $fman->listFiles($_SESSION['user'],$filter,'normal','','.');
?>
	<div class="col-sm-12">
		<div class="container-fluid" style="min-height:80vh;">
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="well large-well">

						<form enctype="multipart/data" class="form-inline">
							<div class="form-group">
								<input onchange="$('#upload-btn').html($(this)[0].files[0].name);" type="file" style="display:none;" id="file-input" name="file"></input>
								<div class="btn btn-default embed-file-input" id="upload-btn" data-target-input="file-input"><span class="glyphicon glyphicon-plus"></span><span class="glyphicon glyphicon-file"></span></div>
							</div>
							<div class="form-group" style="margin:0px 15px;">
								<span class="glyphicon glyphicon-chevron-right" style="font-size:1.6em;opacity:.2;"></span><br />
							</div>
							<div class="form-group" style="margin:0px 5px;">
									<div class='checkbox tb-checkbox'>
										<label>
											<input type='checkbox' id="check-all"> Tout cocher
										</label>
									</div>
							</div>
							<div class="form-group" style="margin:0px 5px;">
								<?php
									if (count($gr)%7==0)$divider=7;
									else if (count($gr)%6==0||count($gr)%9==0)$divider=6;
									else if (count($gr)%5==0)$divider=5;
									else if (count($gr)%4==0)$divider=4;
									else if (count($gr)%3==0)$divider=3;
									else $divider=7;
									for($i=0;$i<count($gr);$i++){
										if($i%$divider==0&&$i!=0)echo "</div><div class='form-group' style='margin:0px 5px;'>";
										if($gr[$i]->Name()==$_SESSION['user']->WholeName())
											echo "<div class='checkbox tb-checkbox'>
			        					<label>
			          					<input type='checkbox' class='chk-in' name='groups' value='".$gr[$i]->Id()."' > Vos amis
			        					</label>
			      					</div>";
										else
											echo "<div class='checkbox tb-checkbox'>
												<label>
													<input type='checkbox' class='chk-in' name='groups' value='".$gr[$i]->Id()."' > ".$gr[$i]->Name()."
												</label>
											</div>";
									}

								?>
							</div>
							<div class="form-group" style="margin:0px 15px;">
								<span class="glyphicon glyphicon-chevron-right" style="font-size:1.6em;opacity:.2;"></span><br />
							</div>
							<div class="form-group">
								<div class="btn btn-primary" onclick="sendFileToGroup($('#file-input'),'groups');">Envoyer</div>
							</div>

						</form>

					</div>
				</div>
			</div>
			<div class="row files-row">
				<?php
					if(count($files)==0){
				?>
					<div class="col-sm-12"><h3>Gérez ici vos fichiers.</h3></div>
				<?php
					}

					for($i=0;$i<count($files);$i++){

						$chararr = str_split($files[$i]->Dest());
						if(in_array("|",$chararr)){
							$filegroup = $gman->getGroupsByMember($files[$i]->Dest(),"normal");
							if($filegroup)$destgroup=$filegroup[0]->Name();
							else $destgroup="Groupes multiples";
						}
						else if(in_array("y",$chararr)){
							$destgroup="Classes de ".$chararr[1].($chararr[1]=="1"?"ère":"ème");
						}
						else if(!is_numeric($chararr[1])&&$chararr[1]!="|"){
							$destgroup="Classe de ".$files[$i]->Dest();
						}
						else{
							$uman = new UserManager();
							$userdest = $uman->getUserById($files[$i]->Dest());
							if($userdest)$destgroup=$userdest->WholeName();
							else $destgroup = $files[$i]->Dest();
						}



						if($i%6==0&&$i!=0)echo "</div><div class='row'>";
				?>
						<div class="col-md-2 col-sm-4 col-xs-6 file-item file-panel-item">
							<img src="<?php echo $files[$i]->Preview(); ?>"><br />
							<span class="file-panel-name"><?php echo $files[$i]->Name(); ?></span>
							<div class="file-panel-info"><?php echo $destgroup; ?><br/><?php echo $files[$i]->Send_date(); ?></div>
							<div class="btn btn-danger btn-small" style="float:none;" onclick="deleteFile(<?php echo $files[$i]->Id(); ?>,$(this).parents('.file-panel-item').eq(0));">Supprimer</div>
						</div>
				<?php
					}
				?>
			</div>
		</div>
	</div>
<?php } ?>
