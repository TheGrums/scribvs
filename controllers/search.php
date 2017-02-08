<?php

if(!function_exists('loadClass'))require_once './config/db.php';
session_start();

?>
<!DOCTYPE html>

<html>

<head>
	<?php
	require(dirname(__FILE__)."/head.php");
	?>
</head>

<body id="search">

	<div class="maincontainer">
		<div class="wrapper">


			<div class = "embed-container container-fluid" style = "min-height:90vh;margin-top:10vh;">
				<?php

				$friendsleft = $_SESSION['user']->FriendsGroup()->FriendsLeft();

				?>
				<div class="row">
					<div class="col-md-10 col-md-offset-1 smart-col">
						<div class="well well-lg">Vous pouvez encore ajouter <?php echo '<strong>'.$friendsleft.'</strong> ami'.($friendsleft>1?'s':''); ?> à votre groupe.</div>
					</div>
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
						<img class='loader' src='./pictures/loader.gif' style='width: 10%; height: auto; position: absolute; display: none; right: 45%;' />
					</div>
				</div>

				<div class="row user-preview">
					<div class="col-md-8 col-md-offset-2">
						<div class="list-group">

						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-md-offset-3 col-xs-12" style="text-align:left;">
						<span class="label label-default" style = "opacity:.6">1V</span><span style="font-size:11px;opacity:.7;"> - Groupes dont la personne est membre</span><br /><br />
						<span class="label label-primary"style = "opacity:.6">Elève</span><span style="font-size:11px;opacity:.7;"> - Statut de la personne</span><br /><br />
						<button class="btn btn-success btn-small" style="float:none;opacity:.6;"><span class="glyphicon glyphicon-plus"></span> <span class="glyphicon glyphicon-user"></span></button><span style="font-size:11px;opacity:.7;"> - Ajouter cette personne dans votre groupe d'amis. Cela lui permettra de suivre vos publications.</span><br />
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
	<script type = "text/javascript" src="<?php echo GENERAL_PATH; ?>js/autosuggest.js"></script>
	<script type = "text/javascript" src="<?php echo GENERAL_PATH; ?>js/search.js"></script>
</body>

</html>
