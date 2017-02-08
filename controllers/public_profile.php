
<!DOCTYPE html>

<html>

<head>
	<?php
	$buttons = array("file"=>"dialog-box-container");
	$uman = new UserManager();
	$animate = true;
	require(dirname(__FILE__)."/head.php");
	?>
</head>

<body id="pbprofile" data-user-id="<?php echo $user->Id();?>">
	<div class="maincontainer">
		<div class="wrapper">

			<div class = "container-fluid embed-container" style = "min-height:90vh;margin-top:10vh;">
				<!-- Files -->
				<div class="dialog-box-container med-hidden pbprofile-file-container">
					<div class="dialog-box-up">
						Fichiers
					</div>
					<div class="dialog-box-content">
						<span class = "files-info">Appuyez longtemps pour supprimer.</span>
						<div class="container-fluid" id="files-container">

						</div>
					</div>
					<div class="dialog-box-down">
						<span id="file-friends" data-target-input="file-input" class="send-file embed-file-input"><span class="glyphicon glyphicon-user" style="font-size:13px;"></span></span>
						<span id="file-class" data-target-input="file-input" class="send-file embed-file-input"><?php echo $_SESSION['user']->ClassId(); ?></span>
						<span id="file-year" data-target-input="file-input" class="send-file embed-file-input"><?php echo $_SESSION['user']->Year(); ?></span>
						<span id="add-file">+</span>
						<input id="file-input" type="file" multiple="" style="display:none;"></input>
					</div>
				</div>

				<!-- Files -->
				<div class = "row">
					<div class = "col-sm-3" style = "padding:0px;">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-12">
									<div style = "margin:auto;width:70%;">
										<div class="img-rounded profile-img" style="background-image:url('<?php echo $user->Image(); ?>');background-size:cover;background-position:center;width:100%;height:auto;padding:50%;"></div>
									</div>
								</div>
							</div>
							<div class="row" style="margin-top:20px;">
								<div class="col-sm-12">
									<?php if(!in_array($user->Id(),$_SESSION['user']->FriendsArray())){ ?> <button class="btn btn-success quick-add-friend" data-user-id="<?php echo $user->Id();?>"><span class="glyphicon glyphicon-plus"></span><span class="glyphicon glyphicon-user"></span></button><?php }
									else{ ?><label class="label label-success">Vous êtes amis.</label><br /> <a href="<?php echo './profile.php?q='.$_SESSION['user']->Last().'-'.$_SESSION['user']->First().'&d=friends'; ?>"><button class="btn btn-primary" style="margin:20px 0;">Gérer mes amis</button></a><?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-9">
						<div class="container-fluid">
							<div class = "row labels-container-row">
								<div class="col-md-6">
									<h1 class="profile-page-name"><?php echo $user->WholeName(); ?></h1>
								</div>
								<div class = "col-md-6">
										<?php $man = new GroupManager();$groups = $man->getGroupsByMember($user->Id(),"normal");for($j=0;$j<count($groups);$j++){ ?>
										<span class="label label-default" style="margin:2px;"><?php echo $groups[$j]->Name(); ?></span>
										<?php } ?>
										<span class="label label-primary" style="margin:2px;"><?php echo $user->Status(); ?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class = "row">
					<div class="col-sm-9 col-sm-offset-3">
						<div class="container-fluid" id = "R2_d2" style="margin-top: -14vh;">
							<div class = "row">
								<div class = "col-sm-10 col-lg-7 col-xs-12 col-sm-offset-1 col-md-8 col-md-offset-0 profile-container">
									<div class="container-fluid">
											<div class="row mobile-buttons">
												<div class="col-xs-12" id="return-btn">
													<span class="glyphicon glyphicon-random"></span>
												</div>
												<?php
													if($buttons){
														$display = 12/count($buttons);
														foreach($buttons as $icon=>$target){

															echo '<div class="col-xs-'.$display.' mobile-btn" data-target-display="'.$target.'">
																			<span class="glyphicon glyphicon-'.$icon.'"></span><span class="badge"></span>
																		</div>';

														}
													}
												?>
											</div>
									</div>
									<div class="pub-wrapper">
										<div id = "thread">

										</div>
										<div class="btn btn-primary" id="load" style="margin-bottom:25px;"><span class="glyphicon glyphicon-plus"></span></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php require(dirname(__FILE__)."/navbar.php");?>
	<?php
	require(dirname(__FILE__)."/scripts.php");
	echo "<script type = 'text/javascript'> detectActive(4); </script>";
	?>
	<script async src="//cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>
	<script type = "text/javascript" src="<?php echo GENERAL_PATH; ?>js/publications.js"></script>
	<script type = "text/javascript" src="<?php echo GENERAL_PATH; ?>js/files.js"></script>
</body>

</html>
