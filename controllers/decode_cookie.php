
<!DOCTYPE html>

<html>

	<head>
	</head>

	<body>

	<?php
		$mobile = true;
		require(dirname(__FILE__)."/scripts.php");
	?>
	<script type = "text/javascript">

	$(document).ready(function(){

		$.ajax({

			method	: "GET",
			url		: "./AJAX/decode_cookie.php",
			dataType: "html",
			success: function(data){

				if(data=="suspended"){
					$(".logo").remove();
					$(".cssload-loader2").remove();
					$(".col-md-4").append("<h3 style='color:red;'><span style='font-size:15px'>Suite à de nombreuses infractions au règlement</span><br />Votre compte a été suspendu...</h3>");
				}

				else{

						location.reload(true);
				}

			},
			error: function(){

					location.reload(true);

			}

		});

	});

	</script>
	</body>

</html>
