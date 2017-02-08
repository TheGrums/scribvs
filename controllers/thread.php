<!DOCTYPE html>
<html>

<head>
	<?php
	$buttons=array("file"=>"dialog-box-container","bell"=>"notifs-container");
	$animate = true;
	require(dirname(__FILE__)."/head.php");
	?>
</head>

<body id = "thread-page">

	<div class="maincontainer">
		<div class="wrapper">

			<!-- Files -->
			<div class="dialog-box-container med-hidden">
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
				<div class="dialog-box-help">
					<img src="./pictures/file-box-help-1.jpg" />
					<img src="./pictures/file-box-help-2.jpg" style="display:none;"/>
				</div>
			</div>

			<!-- Files -->
			<div class = "container-fluid embed-container" style = "min-height:90vh;">

				<div class = "row">
					<div class = "col-md-9 col-md-offset-3 smart-col">
						<div class = "container-fluid">
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
	$mobile = true;
	require(dirname(__FILE__)."/scripts.php");
	echo "<script type = 'text/javascript'> detectActive(1); </script>";
	?>
	<script async src="//cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>
	<script type = "text/javascript" src="./js/publications.js"></script>
	<script type = "text/javascript" src="./js/files.js"></script>
	<script type = "text/javascript" src="./js/notifications.js"></script>
</body>

</html>
