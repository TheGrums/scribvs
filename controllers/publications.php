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

		<div class = "pub-wrapper">
			<div class = "container-fluid post-form single">

				<div class = "col-xs-2">
					<div class = "place-t-post active-item" id = "class-post" title="Ecrivez à votre classe.">
						<?php echo $_SESSION['user']->ClassId(); ?>
					</div>
					<div class = "place-t-post" id = "year-post" title="Ecrivez aux camarades de votre année.">
						<?php echo $_SESSION['user']->Year(); ?>
					</div>
					<div class = "place-t-post" id = "friends-post" title="Ecrivez à vos amis.">
						<span class = "glyphicon glyphicon-user" style="line-height: 1.42857;"></span>
					</div>
					<div class = "place-t-post" id = "school-post" title="Ecrivez à toute l'école.">
						<span class = "glyphicon glyphicon-globe" style="line-height: 1.42857;"></span>
					</div>
				</div>
				<div class = "col-xs-10" style="line-height: 0;background-color: white;">
					<textarea id = "write-space" placeholder="Ecrivez à votre classe."></textarea>
					<span id = "img-preview">
						<div class="clearfix" id="mf"></div>
					</span>
					<div class = "bottom-post" style="min-height: 30px;">
						<div class = "complement">
							<span id = "pic-button" class = "glyphicon glyphicon-picture embed-file-input" data-target-input="pictures-input"></span>
						</div>
						<div class = "complement">
							<span id="sticky-button" title="Publication fixe" class = "glyphicon glyphicon-flag"></span>
						</div>
						<button class = "btn btn-submit btn-small" id = "pub-send">Envoyer</button>
					</div>
					<input type="file" id="pictures-input" style="display:none;" accept="image/*" capture="camera" multiple=""/>


				</div>

			</div>

			<div id = "thread">

			</div>
			<div class="btn btn-primary" id="load" style="margin-bottom:25px;"><span class="glyphicon glyphicon-plus"></span></div>
		</div>
	</div>
	<div class="smart-hidden col-lg-5 col-md-4 notifs-container">

	</div>
</div>
