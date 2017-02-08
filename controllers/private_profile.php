<!DOCTYPE html>

<html>

<head>
	<?php
	$animate = true;
	require(dirname(__FILE__)."/head.php");
	?>
</head>

<body id="profile">

	<div class="maincontainer">
		<div class="wrapper">

			<div class = "embed-container container-fluid" style = "min-height:90vh;margin-top:10vh;">
				<div class = "row">
					<div class = "col-sm-3" style = "padding:0px;">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-12">
									<div style = "margin:auto;width:70%;" id="profile-image">
										<div class="img-rounded profile-img" style="background-image:url('<?php echo $_SESSION['user']->Image(); ?>');background-size:cover;background-position:center;width:100%;height:auto;padding:50%;"></div>
									</div>
								</div>
							</div>
							<div class="row" style="margin-top:20px;">
								<div class="col-sm-12">
									<button class="btn btn-primary" id = "profile-img-change" ><span class="glyphicon glyphicon-retweet"></span> Changer</button>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-9">
						<div class="container-fluid">
							<div class = "row labels-container-row">
								<div class="col-md-6">
									<h1 class="profile-page-name"><?php echo $_SESSION['user']->First().' '.$_SESSION['user']->Last(); ?></h1>
								</div>
								<div class = "col-md-6">
									<?php $man = new GroupManager();$groups = $man->getGroupsByMember($_SESSION["user"]->Id(),"normal");for($j=0;$j<count($groups);$j++){ ?>
										<span class="label label-default"><?php echo $groups[$j]->Name(); ?></span>
										<?php } ?>
									</div>
								</div>
								<div class = "row" style = "margin-top:5px;">
									<div class="portable-nav-item col-xs-3">
										<div id = "home"><span class = "glyphicon glyphicon-home"></span> <span class = "txt">Mon profil</span></div>
									</div>
									<div class="portable-nav-item col-xs-3">
										<div id = "settings"><span class = "glyphicon glyphicon-cog"></span> <span class = "txt">Paramètres</span></div>
									</div>
									<div class="portable-nav-item col-xs-3">
										<div id = "class"><span class = "glyphicon glyphicon-education"></span> <span class = "txt"><?php echo $_SESSION['user']->ClassId(); ?></span></div>
									</div>
									<div class="portable-nav-item col-xs-3">
										<div id = "friends"><span class = "glyphicon glyphicon-user"></span> <span class = "txt">Amis</span></div>
									</div>
								</div>


							</div>
						</div>
					</div>
					<div class = "row">
						<div class="col-sm-9 col-sm-offset-3 smart-col">
							<div class="container-fluid" id = "R2_d2">
								<?php
								require('./controllers/publications.php');
								?>
							</div>
						</div>
					</div>
				</div>

			</div>

			<?php require(dirname(__FILE__)."/navbar.php");?>
		</div>

		<?php
		require(dirname(__FILE__)."/scripts.php");
		echo "<script type = 'text/javascript'> detectActive(0); </script>";
		?>
		<script async src="//cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>
		<script type = "text/javascript" src="<?php echo GENERAL_PATH; ?>js/autosuggest.js"></script>
		<script type = "text/javascript" src="<?php echo GENERAL_PATH; ?>js/publications.js"></script>
		<script type = "text/javascript" src="<?php echo GENERAL_PATH; ?>js/profile.js"></script>
		<script type = "text/javascript" src="<?php echo GENERAL_PATH; ?>js/image-editor.js"></script>
		<?php
		if(isset($_GET['d'])){
			echo "<script type='text/javascript'>$(document).ready(function(){
				$( \"#".$_GET['d']."\" ).trigger( \"click\" );
			});</script>";
		}
		?>
	</body>

	</html>
