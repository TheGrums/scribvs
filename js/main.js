var user;
var toggled = 0;

jQuery.ajaxSetup({
beforeSend: function() {
    $('.loader').show();
},
complete: function(){
    $('.loader').hide();
},
success: function(data) {
		console.log(data); //	DEBUG MODE
    $('.loader').hide();
}
});

$.ajax({

	url:"./AJAX/getusrinfo.php",
	method:"GET",
	dataType:"JSON",
	success:function(data){user = data;},
	error:function(){
		$.ajax({

			url:"./../AJAX/getusrinfo.php",
			method:"GET",
			dataType:"JSON",
			success:function(data){user = data;}

		});
	}

});

function embedDate(date){

	var ar = date.split(" ");
	var scdar = ar[0].split("-");

	return scdar[2]+"-"+scdar[1]+"-"+scdar[0]+" "+ar[1];

}

function lightboxClose(name){
	var $elem = $("."+name).parents(".overlay").eq(0);
	if(typeof coms !== 'undefined')coms = [];
	$("."+name).fadeOut("fast", function() { $(this).remove();$elem.fadeOut("fast", function() { $(this).remove();}) });
}

function downloadFile(id){
  $.ajax({
    method	: "POST",
    url		: "./AJAX/download_file.php",
    dataType: "html",
    data 	: {"id":id},
    success:function(data){
      console.log("yolo");
    }
  });
}

function confirmEmbed(text,choice1, choice2){
	$("body").append('<div class = "overlay">'+
	'<div class = "lightbox">'+
	'	<h5 style="margin-top:30px;">'+text+'</h5>'+
	'	<div class="row" style="margin-top:30px;">'+
	'		<div class="col-sm-2 col-sm-offset-4">'+
	'			<button class="btn btn-danger btn-lightbox" id="opt1">'+choice1+'</button>'+
	'		</div>'+
	'		<div class="col-sm-2">'+
	'			<button class="btn btn-success btn-lightbox" id="opt2">'+choice2+'</button>'+
	'		</div>'+
	'	</div>'+
	'</div>'+
	'</div>');
}

function lightbox(data, name){
	if(name===undefined)name="fst-lgtbx";
	$("body").append('<div class = "overlay">'+
	'<div class = "lightbox '+name+'">'+data+
		'<div id = "lightbox-close" data-target="'+name+'" class="glyphicon glyphicon-remove"></div>'+
	'</div></div>');
}

function detectActive(number){

	$('.navbar-nav').children().eq(number).addClass('act');

}

function popError(){

	ligthbox("<h3>Une erreur s'est produite, veuillez réessayer.</h3>");

}

function popWorking(description,depth){
  if(description===undefined)description="";
  if(depth===undefined)depth="";
  lightbox("<h4>Construction en cours</h4>"+description+"<img src = '"+depth+"./pictures/work_in_progress.jpg' style='max-height: 63vh;width: auto;'></img>");
}

function detectViPo(){

   	var width = $( window ).width();
    if(width<850){
			$('body').swipe({
				swipeRight:function(){

					if(toggled === 0 && $(window).width()<850){
							$('.maincontainer').addClass("nav-vis");
							$('.left-nav').addClass("left-nav-visible");
							$('.mobile-bottom').addClass("left-nav-act");
							$('.wrapper').addClass("wrapper-active");
							toggled = 1;
					}

				},
				swipeLeft:function(){
						if(toggled === 1 && $(window).width()<850){
							$('.maincontainer').removeClass("nav-vis");
							$('.left-nav').removeClass("left-nav-visible");
							$('.mobile-bottom').removeClass("left-nav-act");
							$('.wrapper').removeClass("wrapper-active");
							toggled = 0;
						}
			}

			});

			$('body').on('click','.mobile-btn',function(){
				var target = $(this).attr('data-target-display');
				$(".mobile-btn").fadeOut('slow',function(){$('#return-btn').fadeIn();});
				$(".pub-wrapper").fadeOut('slow',function(){$(".profile-container").append($("."+target).clone());$(".profile-container ."+target).fadeIn('slow');});

			});

			$('body').on('click','#return-btn, .publication-spoiler',function(){
				$("#return-btn").fadeOut('slow',function(){$('.mobile-btn').fadeIn()});
				$(".profile-container").children().last().fadeOut('slow',function(){$(".profile-container").children().last().remove();$(".pub-wrapper").fadeIn('slow');});
			});



    }
    else{

    	$('.left-nav').css('display','inline');

    }
}



$(document).ready(function() {

  detectViPo();

	$(window).resize(function() {
		detectViPo();
	});

	$('body').on('click', '.embed-file-input',function(){
		document.getElementById($(this).attr("data-target-input")).click();
	});

	$('body').on('click','#lightbox-close',function(e){
		e.stopPropagation();
		lightboxClose($(this).attr("data-target"));
	});

	$("body").on("click",".panel-down",function(){
    $(this).parents(".panel").eq(0).children().eq(1).toggle();
    $(this).replaceWith('<span class="glyphicon glyphicon glyphicon-chevron-up panel-up"></span>');
  });

  $("body").on("click",".panel-up",function(){
    $(this).parents(".panel").eq(0).children().eq(1).toggle();
    $(this).replaceWith('<span class="glyphicon glyphicon glyphicon-chevron-down panel-down"></span>');
  });


	$('body').on('click','img.clickable-image',function(){

		lightbox("<img style='max-width:80%;max-height:90vh;' src='"+$(this).attr('src')+"' />");

	});

	$('.navbar-nav [data-toggle="tooltip"]').tooltip();

	$('body').on('click','.smooth-scroll',function(e){

		e.preventDefault();

		var hash = this.hash;

			$('html, body').animate({
				scrollTop: $(hash).offset().top
			}, 500, function(){

			window.location.hash = hash;
		});

	});

	$('body').on('click','.quick-add-friend',function(e){
		e.stopPropagation();
    e.preventDefault();

    var id = $(this).attr("data-user-id");
		$elem = $(this);

    $.ajax({
      url     : "./AJAX/add_friend.php",
      method  : "POST",
      dataType: "html",
      data    :{"id":id},
      success : function(data){

				console.log(data);
        if(data){

					$elem.html("<span class='glyphicon glyphicon-ok'></span>");
					$elem.replaceWith('<label class="label label-success">Vous êtes amis.</label>');

				}
        else{
          lightbox("<h5>Vous ne pouvez ajouter plus d'amis à votre groupe.</h5><a href='./profile.php?q="+user._familyname+"-"+user._firstname+"&d=friends'><button class='btn btn-primary' style='margin-top:20px;'>Gérer mes amis</button></a>");
        }
      },
      error  :  function(){
        console.log("error");
      }

    });

	});

});
