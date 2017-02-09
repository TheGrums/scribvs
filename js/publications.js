var pubFiles=[];
var pubLinks=[];
var coms=[];
var img_preview;
var scroll=false;

function refreshThread(){

	var last = $("#thread").children().first().attr("id");
	last = last.split("-");
	last = parseInt(last[1]);

	$.ajax({
		method	: "POST",
		url		: "./AJAX/thread.php",
		dataType: "html",
		data 	: {"place":$("body").attr('id'),"begin":0,"nb":5,"refreshfrom":last},
		success: function(data){

			if(data != ""){
				$('.display_min, .display_more, .read_more').remove();
				var objs = data;
				var j;
				$('#thread').prepend(data);
				shortPub();
				$('#thread').emoticonize();
			}

		},
		error: function(){

				location.reload(true);

		}
	});

	setTimeout(refreshThread, 10000);

}

function scrollFunction() {

	var win = $(window);

	var viewport = {
		top : win.scrollTop(),
		left : win.scrollLeft()
	};
	viewport.right = viewport.left + win.width();
	viewport.bottom = viewport.top + win.height();

	var bounds = $("body").offset();
	bounds.right = bounds.left + $("body").outerWidth();
	bounds.bottom = bounds.top + $("body").outerHeight();
	if(scroll && viewport.bottom>scroll){
		$(window).scrollTop(scroll-$(window).height());
	}
	//$(document).height() - $win.height() <= $win.scrollTop()
		if (bounds.bottom<=viewport.bottom ) {

				scroll = viewport.bottom;
				setTimeout(function(){scroll=false;}, 2000);

				var last = $("#thread").children().length;
				$.ajax({
					method	: "POST",
					url		: "./AJAX/thread.php",
					dataType: "html",
					data 	: {"place":$("body").attr('id'),"begin":last+1,"nb":15},
					success: function(data){

						if(data != ""){
							$('.display_min, .display_more, .read_more').remove();
							var objs = data;
							var j;
							$('#thread').append(data);
							shortPub();
							$('#thread').emoticonize();
						}
						else{
							$(window).unbind('scroll');
							$('#load').html('Fin');
						}

					},
					error: function(){

							location.reload(true);

					}
				});
		}
}

function buildPub(fill){

	var com="glyphicon-pencil";
	var lov="glyphicon-heart-empty";
	if(fill._commented)com="glyphicon-pencil under-pub-active";
	if(fill._loved)lov="glyphicon-heart under-pub-active";

	var pub = '<div class = "container-fluid" id = "pub-'+fill._id+'">'+
		'<div class = "row pub-header">'+
			'<div class = "pub-info col-xs-3" style="font-size:11px;">'+fill._author+
			'</div>'+
			'<div class = "col-xs-4 col-xs-offset-1 col-sm-2 col-sm-offset-2">'+
				'<img src="'+fill._author_pic+'" class = "pub-img"/>'+
			'</div>'+
			'<div class = "pub-info col-xs-3 col-xs-offset-1 col-md-offset-2" style="font-size:10px;">'+fill._pub_date+
			'</div>'+
		'</div>'+
		'<hr></hr>'+
		'<div class = "pub-content item">'+fill._content+
		'</div>'+
		'<div class = "row">'+
			'<div class = "col-sm-2 col-xs-4 under-pub" id = '+fill._id+'>'+
				'<span class = "glyphicon '+lov+' under-pub-content"></span><span class = "under-pub-content">'+fill._nbr_loves+'</span>'+
			'</div>'+
			'<div class = "col-sm-2 col-xs-4 under-pub">'+
				'<span class = "glyphicon '+com+' under-pub-content"></span><span class = "under-pub-content">'+fill._nbr_coms+'</span>'+
			'</div>';

			if(fill._suppressible){

						pub+='<div class = "col-sm-2 col-xs-4 under-pub pub-remove">'+
								'<span class = "glyphicon glyphicon-remove under-pub-content" data-pub-id="'+fill._id+'"></span>'+
							'</div>';
			}
	pub+='</div>';

	return pub;

}

function buildCom(com,pos){
	var comment = '<div class="container-fluid">'+
		'<div class="row"  style = "display: flex;align-items: center; text-align:left;">'+
			'<div class = "col-xs-4 col-md-2">'+
				'<div class="container-fluid"><div class="row"><div class="col-xs-12" style="padding: 0px;"><img src = "'+com._author._img+'" class = "pub-img" /></div>'+
				(com._suppressible?'<div class="row"><div class="col-xs-6 com-delete" data-com-id="'+pos+'"><span class="glyphicon glyphicon-remove"></span></div><div class="col-xs-6 com-edit" data-com-id="'+pos+'"><span class="glyphicon glyphicon-edit"></span></div></div></div>':'</div>')+
				'</div>'+
			'</div>'+
			'<div class = "col-xs-5 col-md-7">'+
			'	<h6>'+com._author._firstname+' '+com._author._familyname+'</h6>'+
			'</div>'+
		'</div>'+
		'<div class="row">'+
		'	<div class="col-xs-8 col-xs-offset-4 col-md-10 col-md-offset-2 com-content"><em>'+com._content+
		'	</em></div>'+
		'	</div>'+
		'	<hr class="left-hr" style = "opacity: 0.3;"></hr>'+
		'	</div>';
		return comment;

}

function shortPub(){
	return; // Temporary avoiding function
	$('.text-pub').each(function(event){

			var max_length = 300;

			if($(this).html().length > max_length){

				var short_content 	= $(this).text().substr(0,max_length);
				var long_content	= $(this).text().substr(max_length);

				$(this).html(short_content+
							 '<a href="#" class="read_more"><br />...Lire la suite</a>'+
							 '<span class="more_text" style="display:none;">'+long_content+'</span>');

				$(this).find('a.read_more').click(function(event){

					event.preventDefault();
					$(this).hide();
					$(this).parents('.text-pub').find('.more_text').show();

				});

			}

	});

	$('.item').each(function(){

		if($(this).find('.mosaicflow-container img').size()>0){
			//$(this).find('.mosaicflow_item').hide();
			$(this).append('<a href="#" class="display_more"><br />Afficher toutes les images...</a>');
		}

	});

	$('body').on('click','.display_more',function(event){
		event.preventDefault();
		$(this).parent().find('.mosaicflow_item').fadeIn();
		$(this).parent().append('<a href="#" class="display_min"></br>Masquer les images...</a>');
		$(this).remove();
	});

	$('body').on('click','.display_min',function(event){
		event.preventDefault();
		$(this).parent().find('.mosaicflow_item').fadeOut();
		$(this).parent().append('<a href="#" class="display_more"><br />Afficher toutes les images...</a>');
		$(this).remove();
	});
}

function verifyStickyPerm(dest,user){

	var yes;

	switch (dest){
		case "year-post":
			yes=user._level>3;
			break;
		case "school-post":
			yes=user._level>3;
			break;
		case "class-post":
			yes=user._level>1;
			break;
		case "friends-post":
			yes=1<0;
			break;

	}
	return yes;

}

function loadPic(file) {
	var src = URL.createObjectURL(file);
	var id = pubFiles.length;

	pubFiles.push(file);
	if(pubFiles.length===1)
		$("#img-preview").prepend('<div class="delete" data-transit-id="'+id+'"><span class="glyphicon glyphicon-remove"></span></div><img class="transit-image" src="'+src+'">');
	else if($("#img-preview .mosaicflow__column").length!=1){
		if(pubFiles.length%2===1){
    	$("#img-preview").children('.mosaicflow__column').eq(0).append('<div class="delete" data-transit-id="'+id+'"><span class="glyphicon glyphicon-remove"></span></div><img class="transit-image" src="'+src+'" style="position: static; visibility: visible; display: block;" />');
		}
		else{
			$("#img-preview").children('.mosaicflow__column').eq(1).append('<div class="delete" data-transit-id="'+id+'"><span class="glyphicon glyphicon-remove"></span></div><img class="transit-image" src="'+src+'" style="position: static; visibility: visible; display: block;" />');
		}
	}
	else{
		console.log("pipi");
		$("#img-preview .clearfix").eq(0).children('.mosaicflow__column').append('<div class="delete" data-transit-id="'+id+'"><span class="glyphicon glyphicon-remove"></span></div><img class="transit-image" src="'+src+'" style="position: static; visibility: visible; display: block;" />');
	}
}

function isAdvancedUpload() {
  	var div = document.createElement('div');
  	return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
}

//	Not final function:
//  it have to display links live...

function detectLink(text){

	var words = text.split(" ");
	words.unshift("<p class = 'text-pub'>");
	words.push("</p>");
	var a = 0;
	var i = 0;
	var https = new Array();
	var found = false;
	var cutted_url = "";

	for (var a = 0; a < words.length; a++){
		if(words[a].indexOf('http') >= 0){
			https[i] = a;
			found = true;
			i++;
		}
	}

	if(found){

		for(var j=0;j<https.length;j++){

			var cutted_url = words[https[j]].split("/");

			$('#img-preview').prepend("<a class='embedly-card' href='"+words[https[j]]+"'>"+cutted_url[2]+"</a>");
			words.push("<a class='embedly-card' href='"+words[https[j]]+"'>"+cutted_url[2]+"</a>");
			words[https[j]] = "";

		}

	}
	return words.join(" ");

}

$(document).ready(function() {

	if($("body").attr("id")=="class-page"){
		$.ajax({
			method	: "POST",
			url		: "./AJAX/group_members_list.php",
			dataType: "JSON",
			data 	: {"gname":$('#group-name').html()},
			success: function(data){
				var i = 0;
				$(".notifs-container").css("margin-top","0px");
				$(".notifs-container").append("<div class='list-group' id='members-list'></div>");
				for(i=0;i<data.length;i++){
					$("#members-list").append('<li class="list-group-item"><a href="./profile.php?q='+data[i]._familyname+'-'+data[i]._firstname+' ">'+data[i]._firstname+' '+data[i]._familyname+'</a>'+(data[i]._alreadyfriend?'<label class="label label-success" style="float:right;">Vous êtes amis.</label>':'<button class="btn btn-success btn-small quick-add-friend" data-user-id = "'+data[i]._id+'" style="float:right;"><span class="glyphicon glyphicon-plus"></span> <span class="glyphicon glyphicon-user"></span></button>')+'</li>');
				}

			},
			error: function(){

					window.location.reload(true);

			}
		});
	}

	var nbr = 0;
	var inputs = document.querySelectorAll( '.box-input' );
	var letters = 0;
	var boxIsDisplayed = false;
	var bottom = "no";
	var i = 0;

	$.ajax({
		method	: "POST",
		url		: "./AJAX/thread.php",
		dataType: "html",
		data 	: {"place":$('body').attr('id'),"begin":0,"nb":15},
		success: function(data){

			if(data!=""){

					$("#thread").append(data);
					$(".text-pub").emoticonize();
					shortPub();
					for(var j=0;j<$('.mosaicflow-container').length;j++){
						var mosaic = $('.mosaicflow-container').eq(j).mosaicflow({
							itemSelector: '.mosaicflow_item',
							minItemWidth: $('.mosaicflow-container').width()/2
						});
						mosaic.mosaicflow('refill');
					}
					img_preview = $('#mf').mosaicflow({
										itemSelector: '.mosaicflow_item',
										minItemWidth: $('.mosaicflow-container').width()/2
					});
					img_preview.mosaicflow('refill');


					autosize($('textarea'));
					if(verifyStickyPerm("class-post",user)){
						$("#sticky-button").fadeIn();
					}
					else {
						$("#sticky-button").fadeOut();
					}
					setTimeout(refreshThread, 10000);
			}
			else{
				if($(".maincontainer").attr("id")!="pbprofile"){$("#load").hide();$('.profile-container').append('<div style="width:100%;margin-bottom:50px;"><br /><h4>Aucune publication vous concernant n\'a été trouvée.</h4></div>');}
				else $('#load').html('Cet utilisateur n\'a pas posté de publications vous concernant...');
			}

		},
		error: function(){

				window.location.reload(true);

		}
	});

	$("body").on('click','.delete',function(){
		pubFiles[$(this).attr("data-transit-id")]="";
		var $elm = $(this).next();
		$elm.slideUp("fast");
		$(this).remove();
	});

	$("body").on('click',".pub-remove",function(e){

		e.stopPropagation();

		var id = $(this).children().first().attr("data-pub-id");
		$button = $(this);

		$.ajax({
			method	: "POST",
			url		: "./AJAX/remove_post.php",
			dataType: "html",
			data 	: {"id":id},
			success: function(data){

				lightbox(data);

				if(data=="Publication supprimée."){
					$button.parents().eq(1).addClass("animated hinge").delay(2000).slideUp("slow");
				}

			},
			error: function(){
				alert("Une erreur critique s'est produite, veuillez en alerter les administrateurs du site.");
			}
		});


	});

	$("body").on('click','.com-delete',function(e){
		var position = $(this).attr('data-com-id');
		var $com = $(this).parents(".container-fluid").eq(1);
		if(coms[position]._suppressible){
			$.ajax({
				method	: "POST",
				url		: "./AJAX/remove_com.php",
				dataType: "html",
				data 	: {"id":coms[position]._id},
				success: function(data){
					if(data === "Are u lost ?"){
					 	window.location.reload(true);
					}
					else if (data){

						$com.addClass("animated fadeOutRight").delay(1000).slideUp("fast");
						var pid = coms[position]._pid;
						$('#'+pid).parent().children().eq(1).children().eq(0).removeClass('under-pub-active');
						var nbr = parseInt($('#'+pid).parent().children().eq(1).children().eq(1).html());
						nbr--;
						$('#'+pid).parent().children().eq(1).children().eq(1).html(nbr);

					}
					else{
						alert("Vous ne pouvez supprimer ce commentaire");
					}

				},
				error: function(){

						window.location.reload(true);

				}
			});
		}
	});

	$("body").on('click','#com-edit-send',function(e){
		var position = $(this).attr('data-com-id');
		coms[position]._content = $("#com-edit-area").val();
		if(coms[position]._suppressible){
			$.ajax({
				method	: "POST",
				url		: "./AJAX/modify_com.php",
				dataType: "html",
				data 	: {"id":coms[position]._id,"content":coms[position]._content},
				success: function(data){
					console.log(data);
					if(data === "Are u lost ?"){
						window.location.reload(true);
					}
					else if (!data){
						alert("Vous ne pouvez éditer ce commentaire");
					}

				},
				error: function(){

						location.reload(true);

				}
			});
			$("#com-edit-area").replaceWith("<em>"+coms[$("#com-edit-send").attr("data-com-id")]._content+"</em>");
			var prevpos = $("#com-edit-send").attr("data-com-id");
			$("#com-edit-send").replaceWith('<div class="col-xs-6 com-edit" data-com-id="'+prevpos+'"><span class="glyphicon glyphicon-edit"></span></div>');
			$(".com-content").emoticonize();
		}
	});

	$("body").on('click','.com-edit',function(e){

		if ( $( "#com-edit-area" ).length ) {
			$("#com-edit-area").replaceWith("<em>"+coms[$("#com-edit-send").attr("data-com-id")]._content+"</em>");
			var prevpos = $("#com-edit-send").attr("data-com-id");
			$("#com-edit-send").replaceWith('<div class="col-xs-6 com-edit" data-com-id="'+prevpos+'"><span class="glyphicon glyphicon-edit"></span></div>');
			$(".com-content").emoticonize();
		}

		var position = $(this).attr('data-com-id');
	  $(this).parents('.container-fluid').eq(1).children().eq(1).children().eq(0).html('<textarea id = "com-edit-area">'+coms[position]._content+'</textarea>');
		autosize($('textarea'));
		$(this).replaceWith('<div class="col-xs-6" id = "com-edit-send" data-com-id="'+position+'"><span class="glyphicon glyphicon-ok hover-green"></span></div>');
	});


	$("#sticky-button").click(function(){

		$(this).toggleClass("complement-active");

	});


	$(".place-t-post").click(function(){

		if(verifyStickyPerm($(this).attr("id"),user)){
			$("#sticky-button").fadeIn();
		}
		else {
			$("#sticky-button").fadeOut();
		}

		$(".post-form").children().eq(0).children().each(function(){
			$(this).removeClass("active-item");
		});
		$(this).addClass("active-item");
		$("#write-space").attr("placeholder", $(this).attr("title"));

	});


	$("#pub-send").click(function(e){
		var content = detectLink($("#write-space").val());

		var place = $(".active-item").attr('id');

		var formData = new FormData();

		var sticky=0;

		if($("#sticky-button").hasClass("complement-active")){
			sticky = 1;
		}

		formData.append('content',content);

		if ($("#write-space").val()===""&&$("#img-preview").children().size()===0){return false;}

		formData.append('dest',place);
		formData.append('sticky',sticky);

		for (var i = 0; i < pubFiles.length; i++) {
		  var file = pubFiles[i];
		  if (file != ""){
		  	if (!file.type.match('image.*')) {
		    	continue;
		  	}
		  	formData.append('photos[]', file, file.name);
		  }
		}
		var xhr = new XMLHttpRequest();
		xhr.open('POST', './AJAX/post_pub.php', true);
		xhr.timeout = 10000;

		xhr.onreadystatechange = function() {
		    if (xhr.readyState == XMLHttpRequest.DONE) {
		        if(xhr.responseText === "Are u lost ?"){
		        	window.location.reload();
		        }
		    }
		}

		xhr.onload = function () {
		  if (xhr.status === 200) {
				$("#thread").prepend(buildPub(JSON.parse(xhr.responseText)[0]));
				$("#img-preview").empty();
				$("#write-space").val("");
				$(".post-form.single").children().fadeIn();
				$("#thread").children().first().css("border","2px dotted lightgreen");
				$("#thread").children().first().emoticonize();
				$(".display_more").remove();
				shortPub();
				var mosaic = $('.mosaicflow-container').mosaicflow({
									itemSelector: '.mosaicflow_item',
									minItemWidth: $('.mosaicflow-container').width()/2
				});
				mosaic.mosaicflow('refill');
		  } else {
		    alert('Une erreur s\'est produite!');
		  }
		};

		pubFiles={};
		pubLinks={};

		xhr.send(formData);

	});

	$("body").on('click','.under-glyphicon-heart-empty',function(){

		var pid = $(this).attr('id');

		$.ajax({
			method	: "POST",
			url		: "./AJAX/love.php",
			dataType: "html",
			data 	: {"pid":pid,"todo":"more"},
			success: function(data){

				if(data === "Are u lost ?"){
					window.location.reload(true);
				}
				else{
					var value = parseInt($("#"+pid).children().eq(1).text());
					value++;
					$("#"+pid).removeClass("under-glyphicon-heart-empty");
					$("#"+pid).addClass("under-glyphicon-heart");
					$("#"+pid).children().eq(1).text(value);
					$("#"+pid).children().eq(0).removeClass("glyphicon-heart-empty");
					$("#"+pid).children().eq(0).addClass("glyphicon-heart under-pub-active");
				}

			},
			error: function(){

					location.reload(true);

			}
		});

	});


	$("body").on('click','.under-glyphicon-heart',function(){

		var pid = $(this).attr('id');

		$.ajax({
			method	: "POST",
			url		: "./AJAX/love.php",
			dataType: "html",
			data 	: {"pid":pid,"todo":"min"},
			success: function(data){

				if(data === "Are u lost ?"){
					window.location.reload(true);
				}
				else{
					var value = parseInt($("#"+pid).children().eq(1).text());
					value--;
					$("#"+pid).removeClass("under-glyphicon-heart under-pub-active");
					$("#"+pid).addClass("under-glyphicon-heart-empty");
					$("#"+pid).children().eq(1).text(value);
					$("#"+pid).children().eq(0).removeClass("glyphicon-heart under-pub-active");
					$("#"+pid).children().eq(0).addClass("glyphicon-heart-empty");
				}

			},
			error: function(){

					location.reload(true);

			}
		});

	});


	$("body").on('click','.under-glyphicon-pencil',function(){

		var pid = $(this).parent().children().first().attr("id");

		$.ajax({
			method	: "POST",
			url		: "./AJAX/coms.php",
			dataType: "JSON",
			data 	: {"pid":pid},
			success: function(data){

				if(data === "Are u lost ?"){
					window.location.reload(true);
				}
				else{

					lightbox('<div class="comments-container"><p class="no-coms-text">'+(data.length===0?'Soyez le premier à donner votre avis.':'')+'</p></div><div class="container-fluid comments-form"><div class="row"><div class="col-xs-12"><textarea class="write-space-bis" id="write-space-coms"></textarea></div></div><div class="row"><div class="col-md-4 col-md-offset-4 col-xs-6 col-xs-offset-3"><button class="btn btn-submit" id="comment-submit" data-post-id="'+pid+'">Envoyer</button></div></div></div>');
					var objs = data;
					var j;
					for(j=0;j<objs.length;j++){
						$('.comments-container').append(buildCom(objs[j],coms.length+j));
					}
					coms = coms.concat(objs);
					$('em').emoticonize();
				}

			},
			error: function(){

					location.reload(true);

			}
		});

	});


	$("body").on('click','#comment-submit',function(){
		var pid = $(this).attr('data-post-id');
		var content = $("#write-space-coms").val();

		if(content===""){return null;}

		$.ajax({
			method	: "POST",
			url		: "./AJAX/post_com.php",
			dataType: "JSON",
			data 	: {"pid":pid,"content":content},
			success: function(data){
				if(data != "Are u lost ?"){
					$(".comments-container").prepend(buildCom(data[0],coms.length));
					coms.push(data[0]);
					$(".comments-container").children().eq(1).css("border","none");
					$(".comments-container").children().first().css("border","1px solid lightgreen");
					$("#write-space-coms").val("");
					$(".no-coms-text").remove();
					$('em').emoticonize();
					$('#'+pid).parent().children().eq(1).children().eq(0).addClass('under-pub-active');
					var nbr = parseInt($('#'+pid).parent().children().eq(1).children().eq(1).html());
					nbr++;
					$('#'+pid).parent().children().eq(1).children().eq(1).html(nbr);

				}
				else{
						window.location.reload(true);
				}

			},
			error: function(){

					window.location.reload(true);

			}
		});

	});

	$("body").on('change','#pictures-input',function(){
		var k = 0;
		for(k=0;k<$(this)[0].files.length;k++){
			loadPic($(this)[0].files[k]);
		}
	});


	//$(window).scroll(function(){scrollFunction();});

	$("body").on('click','#load',function(){


		var last = $("#thread").children().length;
		$.ajax({
			method	: "POST",
			url		: "./AJAX/thread.php",
			dataType: "html",
			data 	: {"place":$("body").attr('id'),"begin":last+1,"nb":15},
			success: function(data){

				if(data != ""){
					$('.display_min, .display_more, .read_more').remove();
					var objs = data;
					var j;
					$('#thread').append(data);
					shortPub();
					$('#thread').emoticonize();
				}
				else{
					$(window).unbind('scroll');
					$('#load').html('Fin');
				}

			},
			error: function(){

					location.reload(true);

			}
		});
	});

	if (isAdvancedUpload()) {
					var input = document.getElementById('file');

					$('.post-form').addClass('has-advanced-upload');

		  			$('.post-form').on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
		    			e.preventDefault();
		    			e.stopPropagation();
		  			})
		  			.on('dragover dragenter', function() {
		  			  	$('.post-form').addClass('is-dragover');
		  			})
		  			.on('dragleave dragend drop', function() {
		   			  	$('.post-form').removeClass('is-dragover');
		  			})
		  			.on('drop', function(e) {
		  				var preview=true;
		  				var fileName = '', i=0;
		  				do{
		  					fileName = e.originalEvent.dataTransfer.files[i].name;
		  					if( fileName ){
		  						var cutName = fileName.split('.');
		  						var ext = cutName[cutName.length-1];
		  						switch(ext){
		  							case 'jpg':
		  								$('#drag-drop-label').append('<br />'+fileName);
		  								pubFiles.push(e.originalEvent.dataTransfer.files[i]);
		  								break;
		  							case 'jpeg':
		  								$('#drag-drop-label').append('<br />'+fileName);
		  								pubFiles.push(e.originalEvent.dataTransfer.files[i]);
		  								break;
		  							case 'png':
		  								$('#drag-drop-label').append('<br />'+fileName);
		  								pubFiles.push(e.originalEvent.dataTransfer.files[i]);
		  								break;
		  							case 'gif':
		  								$('#drag-drop-label').append('<br />'+fileName);
		  								pubFiles.push(e.originalEvent.dataTransfer.files[i]);
		  								break;
		  							default:
		  								$('#drag-drop-label').append('<br />Oups, ce fichier ne semble pas être une image.');
		  								preview = false;
		  								break;
		  						}
		  					}
		  					else{
		  						$('#drag-drop-label').append(labelVal);
		  					}
		  					nbr++;
		  					if(preview){
		  						loadPic(e.originalEvent.dataTransfer.files[i]);
		  					}
		  					i++;
		  				}while(i<e.originalEvent.dataTransfer.files.length)
		  			});
	}

});
