function latexInputs(sid,stid){

  $("#formula-input").keyup(function(){

    $("#preview").html("\\("+$(this).val()+"\\)");
    MathJax.Hub.Typeset();

  });

  $("#formula-send").click(function(e){

    e.preventDefault();

    $.ajax({
			method	: "POST",
			url		: "./AJAX/topics.php",
			dataType: "html",
			data 	: {"action":"new","secid":sid,"stid":stid,"content":"\\("+$("#formula-input").val()+"\\)","title":$("#form-name").val()},
			success: function(data){

        $(".hp").remove();
				$("#formula-send").parent().append(data);
        if(data=="<span style='color:green;font-family:sniglet;font-size:10px;' class='hp'>Votre formule a bien été ajoutée.</span>"){
          $("#preview").html("");
          $("#formula-input, #form-name").val("");
        }

			},
			error: function(){

					location.reload(true);

			}
		});

  });

}
