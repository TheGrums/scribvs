<?php ob_start();if(!function_exists('loadClass'))require_once './config/db.php';session_start(); ?>
<!DOCTYPE html>

<html>

	<head>
		<?php
			$animate = true;
			require(dirname(__FILE__)."/controllers/head.php");
			if(isset($_SESSION['user'])||isset($_COOKIE['sessid'])){
				echo "<script>window.location.href='./index.php';</script>";
			}
		?>
	</head>

	<body>

		<div class = "container-fluid" style="min-height:100vh;">

			<div class = "row">

				<div class="col-md-4 col-sm-6 col-sm-offset-3 col-md-offset-4 col-xs-12" style="margin-top:5vh;">
					<svg version="1.0" id="logo-path" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						 width="100%" viewBox="0 0 484.006 484.006" enable-background="new 0 0 484.006 484.006"
						 xml:space="preserve">
						 <polyline fill="none" stroke="#616BBB" stroke-width="2" stroke-miterlimit="10" points="151.023,211.277 134.495,220.774
						 	134.495,220.782 247.215,285.55 247.231,285.55 359.952,220.782 359.952,220.774 344.51,211.901 "/>
						 <g>
						 	<polygon fill="none" stroke="#616BBB" stroke-width="2" stroke-miterlimit="10" points="248.318,243.027 248.302,243.027
						 		107.704,162.242 107.704,162.234 248.302,81.448 248.318,81.448 388.915,162.234 388.915,162.242 	"/>
						 </g>
						 <polyline fill="none" stroke="#616BBB" stroke-width="2" stroke-miterlimit="10" points="358.57,259.371 371.672,275.636
						 	385.703,257.248 375.597,244.391 372.596,182.748 "/>
						 <g>
						 	<path fill="none" stroke="#616BBB" stroke-miterlimit="10" d="M13.055,400.224c0.208-1.457,1.664-13.001,1.664-17.057
						 		c0-2.705,0.624-13.938,0.312-16.434l2.392,0.625c-0.104,1.352,0.416,7.279,0.728,9.152c2.808,6.656,8.944,11.336,16.121,11.336
						 		c8.216,0,14.769-5.408,14.769-13.104c0-8.425-6.552-12.585-13.312-16.952c-10.192-6.656-18.305-12.48-18.305-24.233
						 		c0-8.112,6.032-18.305,21.425-18.305c6.136,0,11.544,1.248,14.041,1.872c0.728-2.496,1.248-5.616,1.872-8.424l2.392-0.312
						 		c-1.456,10.297-2.496,19.969-2.496,28.497l-2.392-1.04c0-3.536-0.208-6.032-0.416-7.904c-1.144-3.744-6.552-9.36-13.833-9.36
						 		c-8.944,0-12.688,5.72-12.688,10.4c0,6.761,7.072,10.4,14.977,15.393c8.632,5.408,17.369,11.232,17.369,24.337
						 		c0,14.457-11.44,22.673-25.585,22.673c-4.992,0-11.44-1.04-14.353-2.601c-0.52,1.977-1.56,6.969-2.288,10.816L13.055,400.224z"/>
						 	<path fill="none" stroke="#616BBB" stroke-miterlimit="10" d="M138.689,339.589c0-1.977-0.312-6.864-0.624-8.633
						 		c-1.976-4.576-11.648-12.064-25.065-12.064c-18.929,0-30.889,13.729-30.889,29.953c0,20.281,16.745,37.441,38.689,37.441
						 		c7.904,0,17.265-1.248,24.649-5.615l-1.456,4.472c-2.392,1.976-12.896,6.24-29.225,6.24c-3.848,0-15.185-0.416-23.609-4.576
						 		c-13.521-6.656-21.529-18.513-21.529-31.825c0-14.353,7.28-24.961,16.433-31.098c10.816-7.279,20.489-8.632,30.993-8.632
						 		c9.152,0,18.825,1.872,21.737,2.704c0.624-1.352,1.872-8.008,2.184-9.256l2.392-0.521c-1.56,11.44-2.184,22.257-2.288,32.138
						 		L138.689,339.589z"/>
						 	<path fill="none" stroke="#616BBB" stroke-miterlimit="10" d="M164.894,345.829c0-3.744-0.104-23.713-0.52-25.689
						 		c-1.768-0.416-8.84-1.039-11.128-1.248l-0.312-2.184l22.465-0.104c9.88,0,22.257,0.104,29.329,2.912
						 		c5.512,2.184,8.944,6.136,8.944,11.855c0,6.553-6.656,15.186-14.665,19.657c1.144,2.601,17.889,29.849,28.705,41.29l-4.576,0.728
						 		c-7.28-3.328-34.945-35.257-36.609-37.441c-3.952,0.312-8.216,0.624-9.984,0.624v2.704c0,6.761,0.208,22.776,0.52,27.562
						 		c1.768,0.52,8.632,1.248,10.92,1.455l0.416,2.185c-2.6-0.208-13.104-0.416-17.889-0.416c-4.264,0-15.185,0.208-17.577,0.416
						 		l0.416-2.185c1.456-0.104,8.112-0.728,11.024-1.455c0.416-3.017,0.52-23.401,0.52-34.322V345.829z M176.542,353.005
						 		c3.744,0,8.216-0.312,12.688-1.976s11.856-6.448,11.856-16.745c0-6.656-6.032-14.768-24.025-14.768
						 		c-0.312,4.264-0.52,22.881-0.52,30.265V353.005z"/>
						 	<path fill="none" stroke="#616BBB" stroke-miterlimit="10" d="M254.645,353.526c0,13.521,0.104,30.89,0.521,32.97
						 		c2.6,0.623,8.84,1.248,10.92,1.455l0.52,2.185c-2.288-0.208-13.104-0.416-19.553-0.416c-3.535,0-13.104,0.208-16.224,0.416
						 		l0.416-2.185c1.768-0.104,8.84-1.039,11.024-1.455c0.417-4.369,0.52-23.609,0.52-33.802v-6.136c0-3.433-0.104-22.881-0.52-26.418
						 		c-2.08-0.416-8.944-1.248-10.92-1.455l-0.52-2.185c1.976,0.208,11.544,0.416,19.761,0.416c5.304,0,14.248-0.208,16.016-0.416
						 		l-0.52,2.185c-2.08,0.207-7.176,1.039-10.92,1.455c-0.416,2.08-0.521,14.145-0.521,26.938V353.526z"/>
						 	<path fill="none" stroke="#616BBB" stroke-miterlimit="10" d="M288.546,348.117c0-7.488-0.312-23.713-0.728-27.978
						 		c-3.536-0.623-7.696-0.832-10.712-1.039l-0.521-2.185c3.433-0.104,23.297-0.832,29.849-0.832c20.281,0,23.401,8.632,23.401,13.521
						 		c0,3.016-0.104,5.616-2.704,9.776c-3.848,6.032-9.984,9.36-13.416,10.816v0.312c10.296,1.664,21.32,9.049,21.32,20.073
						 		c0,11.96-9.776,19.969-24.232,19.969c-1.457,0-4.992-0.208-8.737-0.416c-3.64-0.208-7.487-0.416-9.672-0.416
						 		c-2.288,0-12.792,0.208-15.809,0.416l0.416-2.185c2.392-0.207,8.632-0.832,10.816-1.455c0.728-7.177,0.728-22.674,0.728-31.826
						 		V348.117z M299.779,350.509c3.225,0,8.529-0.623,12.48-3.535c3.849-2.809,6.033-7.801,6.033-13.105
						 		c0-8.943-5.513-14.977-14.041-14.977c-1.664,0-3.225,0.209-4.16,0.625c-0.208,1.039-0.312,15.809-0.312,25.168V350.509z
						 		 M299.779,359.245c0,8.945,0.729,24.441,1.248,25.793c2.393,1.664,6.24,2.185,8.32,2.185c9.881,0,14.041-5.513,14.041-12.688
						 		c0-6.656-4.264-14.664-11.336-18.408c-4.16-2.185-9.777-2.809-12.273-2.496V359.245z"/>
						 	<path fill="none" stroke="#616BBB" stroke-miterlimit="10" d="M338.884,316.5c3.328,0.208,9.152,0.416,14.977,0.416
						 		c6.447,0,15.704-0.208,17.992-0.416l-0.52,2.185c-2.185,0.207-8.009,0.832-9.777,1.455c0.729,3.537,21.113,51.482,23.817,54.811
						 		c2.392-4.784,21.217-43.785,23.297-54.811c-1.976-0.416-6.24-0.936-9.568-1.455l-0.521-2.185c1.456,0.208,8.841,0.416,15.185,0.416
						 		c4.889,0,9.152-0.208,11.649-0.416l-0.521,2.185c-1.976,0.416-3.64,0.832-6.345,1.455c-2.184,1.248-36.089,70.827-37.441,74.155
						 		c-3.328-5.824-30.265-67.083-35.361-74.155c-1.352-0.416-3.119-0.936-6.447-1.455L338.884,316.5z"/>
						 	<path fill="none" stroke="#616BBB" stroke-miterlimit="10" d="M426.347,400.224c0.209-1.457,1.664-13.001,1.664-17.057
						 		c0-2.705,0.625-13.938,0.312-16.434l2.393,0.625c-0.104,1.352,0.416,7.279,0.728,9.152c2.808,6.656,8.944,11.336,16.12,11.336
						 		c8.217,0,14.77-5.408,14.77-13.104c0-8.425-6.553-12.585-13.312-16.952c-10.193-6.656-18.305-12.48-18.305-24.233
						 		c0-8.112,6.031-18.305,21.424-18.305c6.137,0,11.545,1.248,14.041,1.872c0.729-2.496,1.248-5.616,1.872-8.424l2.392-0.312
						 		c-1.455,10.297-2.496,19.969-2.496,28.497l-2.392-1.04c0-3.536-0.208-6.032-0.416-7.904c-1.144-3.744-6.552-9.36-13.833-9.36
						 		c-8.943,0-12.688,5.72-12.688,10.4c0,6.761,7.072,10.4,14.977,15.393c8.632,5.408,17.368,11.232,17.368,24.337
						 		c0,14.457-11.44,22.673-25.585,22.673c-4.992,0-11.44-1.04-14.353-2.601c-0.521,1.977-1.56,6.969-2.288,10.816L426.347,400.224z"/>
						 </g>
	 				</svg>

				</div>

			</div>
			<div class="row">

				<div class="col-md-6 col-md-offset-3">

					<form style="display:inline-block;">
						<div class="form-group" style="display:inline-block;">
							<input id = "mail-lg-input" type="text" class="form-control" placeholder="E-mail"></input>
						</div>
						<div class="form-group" style="display:inline-block;">
							<input id = "pass-lg-input" type="password" class="form-control" placeholder="Mot de passe"></input>
							<span class="help-block" style="color: gray;ext-align:center;margin-bottom:0px;">
	                    &nbsp<a href = "./recover.php" style="color:gray;"> Mot de passe perdu ?</a><br />
	            </span>
						</div><br />
						<div class="form-group" style="display:inline-block;">
							<button class="form-control" id="login-btn"><span class="glyphicon glyphicon-menu-right"></span></button>
						</div>
						<span class="help-block" id="pass-fail" style="color: red; display: none;text-align:center;">
                    Mot de passe incorrect.<br />
            </span>
						<span class="help-block" id="mail-fail" style="color: red; display: none;text-align:center;">
                    Ce compte n'existe pas, <a href="#second-form" class="smooth-scroll" style="font-size:11px;opacity:0.6;">enregistrez vous.</a> <br />
            </span>
						<span class="help-block" id="error-fail" style="color: red; display: none;text-align:center;">
                    Une erreur s'est produite, rechargez la page et réessayez.<br />
            </span>
					</form>

				</div>

			</div>

			<div class="row">
				<div class="col-sm-2 col-sm-offset-5" style = "text-align:center;margin-top:5vh;">
					<a href="#second-form" class="smooth-scroll" style="font-size:3em;opacity:0.3;color:gray;"><p style="font-size:12px;margin:10px 0px 0px;">S'enregistrer</p><span class="glyphicon glyphicon-menu-down"></span></a>
				</div>
			</div>
		</div>
		<div class="second-form">
		<div class="container-fluid embed-container" id="second-form">
			<form class = "form-vertical" id = "register-form">
					<div class="col-md-3 col-md-offset-3 col-sm-8 col-sm-offset-2 ">
						<div class = "form-group">
							<label for = "prenom" class = "left-label">Prénom :</label>
							<input class = "form-control required" type = "text" id = "firstname" placeholder = "Prénom"></input>
						</div>
						<div class = "form-group">
							<label for = "nom" class = "left-label">Nom :</label>
							<input class = "form-control required" type = "text" id = "name" placeholder = "Nom"></input>
						</div>
						<div class = "form-group">
							<label for = "email" class = "left-label">E-mail :</label>
							<input class = "form-control required" type = "email" id = "email" placeholder = "Courrier électronique"></input>
						</div>
						<div class = "form-group">
							<label for = "auth_id" class = "left-label">Identification :</label>
							<input class="form-control required" type="text" id="auth_id" name="auth_id" placeholder="<?php echo ID_PREFIX; ?>aA1"></input>
						</div>
					</div>
					<div class="col-md-3 col-md-offset-0 col-sm-8 col-sm-offset-2">
						<div class = "form-group">
							<label for = "year" class = "left-label" style = "width:100%;text-align:left;">Classe :</label>
							<div class = "class-input">
							<select class="form-control" id = "year" name = "year">
  								<option>1</option>
  								<option>2</option>
  								<option>3</option>
  								<option>4</option>
  								<option>5</option>
  								<option>6</option>
							</select>
								<input type = "text" id = "class-id" class = "form-control required" name = "class-id" placeholder="A"></input>
							</div>
						</div>
						<div class = "form-group">
							<label for="pass1" class = "left-label">Mot de passe : </label>
							<input type = "password" id = "pass1" class = "form-control required" placeholder="Mot de passe"></input>
						</div>
						<div class = "form-group">
							<label for="pass2" class = "left-label">Confirmation : </label>
							<input type = "password" id = "pass2" class = "form-control required" placeholder="Retapez votre mot de passe"></input>
						</div>
						<button type = "submit" class = "btn btn-submit" id = "register-btn">S'inscrire</button>
					</div>
				</form>
		</div>
	</div>
	<script type="text/javascript" src="./js/svgxuse.min.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/vivus/latest/vivus.min.js"></script>
	<script>
	var ua = navigator.userAgent;
	if(ua.match(/Edge.*/)||ua.match(/Android.*/));
	else
	var path = new Vivus('logo-path', {
		type: 'oneByOne',
    duration: 400,
    animTimingFunction: Vivus.EASE
	});
	</script>
	<?php
		$mobile = true;
		require(dirname(__FILE__)."/controllers/scripts.php");
	?>
	<script type="text/javascript" src="./js/login.js"></script>
	</body>

</html>
