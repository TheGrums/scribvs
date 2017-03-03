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
      <div class="row" style="margin-top:50px;">
        <div class="col-md-1 col-xs-12">
          <a href="./welcome.php"><span class="glyphicon glyphicon-home"></span></a>
        </div>
      </div>
      <div class="row" style="margin-top:80px">
        <h2>Suivez les instructions</h2>
        <h5>Lisez les toutes avant de continuer.</h5>
      </div>

      <div class="row">
        <div class="col-lg-2 col-lg-offset-3 col-xs-12">
          <strong style="font-family:Sniglet;font-size:18px;" >1</strong>
            <p style="font-family:Sniglet;font-size:14px;">Entrez l'adresse e-mail que vous avez utilisée pour vous enregistrer dans le champ prévu à cet effet ci-dessous. Un mail vous sera envoyé lorsque vous aurez cliqué sur ">".</p>
        </div>
        <div class="col-lg-2 col-xs-12">
          <strong style="font-family:Sniglet;font-size:18px;" >2</strong>
            <p style="font-family:Sniglet;font-size:14px;">Ce mail contiendra un code composé de chiffres et de lettres que vous entrerez dans l'espace prévu à cet effet ci-dessous dans l'heure. Il apparaîtra après l'envoi du mail.</p>
        </div>
        <div class="col-lg-2 col-xs-12">
          <strong style="font-family:Sniglet;font-size:18px;" >3</strong>
            <p style="font-family:Sniglet;font-size:14px;">Si le code que vous avez entré est correct, deux champs apparaitron et vous inviteront à entrer votre nouveau mot de passe. Veillez à ne pas l'oublier cette fois.</p>
        </div>
      </div>

			<div class="row" id="step-1" style="margin-top:20px;">

				<div class="col-md-6 col-md-offset-3">

					<form style="display:inline-block;">
						<div class="form-group" style="display:inline-block;width: 250px;margin-bottom:0px;">
							<input id = "mail-rc-input" type="text" class="form-control" placeholder="E-mail"></input>
						</div><br />
						<span class="help-block" id="pass-fail" style="color: red; display: none;text-align:center;">
                    Mot de passe incorrect.<br />
            </span>
						<span class="help-block" id="mail-fail" style="color: red; display: none;text-align:center;">
                    Ce compte n'existe pas, <a href="#second-form" class="smooth-scroll" style="font-size:11px;opacity:0.6;">enregistrez vous.</a> <br />
            </span>
						<span class="help-block" id="error-fail" style="color: red; display: none;text-align:center;">
                    Une erreur s'est produite, rechargez la page et réessayez.<br />
            </span>
						<div class="form-group" style="display:inline-block;">
							<button class="form-control" id="rc-mail-btn"><span class="glyphicon glyphicon-menu-right"></span></button>
						</div>
					</form>

				</div>

			</div>

			<div class="row" id="step-2" style="margin-top:20px;display:none;">

				<div class="col-md-6 col-md-offset-3">

					<form style="display:inline-block;">
						<div class="form-group" style="display:inline-block;width: 250px;margin-bottom:0px;">
							<input id = "id-rc-input" type="text" class="form-control" placeholder="Entrez votre code"></input>
						</div><br />
						<span class="help-block" id="id-fail" style="color: red; display: none;text-align:center;">
										Code incorrect.<br />Veuillez ne pas changer de navigateur lors de la procédure.</br>Veuillez réessayer.<br />
						</span>
						<div class="form-group" style="display:inline-block;">
							<button class="form-control" id="rc-id-btn"><span class="glyphicon glyphicon-menu-right"></span></button>
						</div>
					</form>

				</div>

			</div>

			<div class="row" id="step-3" style="margin-top:20px;display:none;">

				<div class="col-md-6 col-md-offset-3">

					<form style="display:inline-block;">
						<div class="form-group" style="display:inline-block;width: 250px;">
							<input id = "p1-rc-input" type="password" class="form-control" placeholder="Nouveau mot de passe"></input>
						</div><br />
						<div class="form-group" style="display:inline-block;width: 250px;margin-bottom:0px;">
							<input id = "p2-rc-input" type="password" class="form-control" placeholder="Répétez le mot de passe"></input>
						</div><br />
						<span class="help-block" id="pass-fail" style="color: red; display: none;text-align:center;">
							Les mots de passes sont différents.</br>
						</span>
						<div class="form-group" style="display:inline-block;">
							<button class="form-control" id="rc-p-btn"><span class="glyphicon glyphicon-menu-right"></span></button>
						</div>
					</form>

				</div>

			</div>


    </div>
	<?php require("./controllers/scripts.php"); ?>
	<script type="text/javascript" src = "./js/recover.js"></script>
	</body>

</html>
