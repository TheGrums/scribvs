function pagination(limit,secid,stid,func){

  var last = limit*15-15;

  var formulas=0;
  if($("li.active").html()=="Formulaire"){
    formulas=1;
  }

  $.ajax({
    method: "POST",
    url:    "./AJAX/topics.php",
    data: {"action":"list","last":last,"secid":secid,"stid":stid,"formulas":formulas},
    success: function (data){
      $(".topics-container").html(data);
      MathJax.Hub.Typeset();
      if(func!=undefined)func();
    },
    error: function(){
      window.location.reload(true);
    }
  });



}


$(document).ready(function(){

  $("#forum-topic-send").click(function(e){
    e.preventDefault();

    var parts = window.location.search.substr(1).split("&");
    var $_GET = {};
    for (var i = 0; i < parts.length; i++) {
      var temp = parts[i].split("=");
      $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
    }

    var content = CKEDITOR.instances.ckinput.getData();


    $.ajax({
			method	: "POST",
			url		: "./AJAX/topics.php",
			dataType: "html",
			data 	: {"action":"new","secid":$_GET['s'],"stid":$_GET['q'],"content":content,"title":$("#title").val()},
			success: function(data){

        $(".hp").remove();
				$("#forum-topic-send").parent().append(data);
        if(data=="<span style='color:green;font-family:sniglet;font-size:10px;' class='hp'>Votre entrée a bien été ajoutée.</span>"){
          $("#title").val("");
          $("iframe").contents().find(".cke_editable").html("");
          pagination(1,$_GET['s'],$_GET['q'],function(){$(".topics-container").children().first().css("border","1px solid lightgreen");});
        }

			},
			error: function(){

					location.reload(true);

			}
		});

  });

  $("#forum-message-send").click(function(e){
    e.preventDefault();

    var title;

    switch(user._level){

      case "1":
        title="Elève de "+user._class;
        break;

      case "2":
        title="Délégué de "+user._class;
        break;

      case "3":
        title="Professeur";
        break;

      case "4":
        title="Administrateur";
        break;

      case "5":
        title="Directeur";
        break;
    }

    var parts = window.location.search.substr(1).split("&");
    var $_GET = {};
    for (var i = 0; i < parts.length; i++) {
      var temp = parts[i].split("=");
      $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
    }

    var content = CKEDITOR.instances.ckinput.getData();

    $.ajax({
			method	: "POST",
			url		: "./AJAX/send_topic_message.php",
			dataType: "html",
			data 	: {"tid":$_GET['tid'],"content":content,"name":$(".topic-title").text(),"link":window.location.href},
			success: function(data){
        console.log(data);
        /*$(".hp").remove();
				$("#forum-message-send").parent().append(data);
        if(data=="<span style='color:green;font-family:sniglet;font-size:10px;' class='hp'>Votre entrée a bien été ajoutée.</span>"){
          $("#title").val("");
          $("iframe").contents().find(".cke_editable").html("");

          $(".topics-container").append('<div class="row small-row topic topic-message" style="border:2px solid lightgreen;">'+
            '<div class="col-md-2 col-md-offset-0 author-info col-xs-8 col-xs-offset-2">'+
                '<div style = "width:75%;margin:auto;">'+
                    '<div class="img-rounded profile-img section-thumbnail" style="background-image:url(\'./.'+user._img+'\');margin:10px 0px;"></div>'+
                      '</div>'+
                        '<div>'+
                    '<div class="forum-username">'+user._firstname+' '+user._familyname+'</div>'+
                  '<div class="forum-usr-info" style="opacity:0.7">'+title+'</div>'+
                  '<div class="forum-usr-info" style="opacity:0.7">A l\'instant</div>'+

                '</div>'+
            '</div>'+
            '<div class="col-md-10 col-xs-12 forum-msg-right" >'+content+
            '</div>'+
            '<div class="container-fluid">'+
              '<div class="row">'+
                '<div class="col-md-10 col-md-offset-2 col-xs-12">'+
                  '<hr style="margin:10px 0px;"></hr>'+
                  '<div class="signature">'+user._signature+'</div>'+
                '</div>'+
              '</div>'+
            '</div>'+
            '</div>');

        }
        MathJax.Hub.Queue(["Typeset",MathJax.Hub]);*/
			},
			error: function(){

					//location.reload(true);

			}
		});

  });

  $("#forum-search-space").keyup(function(){

    var formulas=0;

    if($("li.active").html()=="Formulaire"){
      formulas=1;
    }

    if($(this).val()!=""){
      $(".page-item").hide();

      $.ajax({
        method: "POST",
        url:    "./AJAX/topics.php",
        data: {"action":"list","last":0,"secid":$(this).attr("data-secid"),"stid":$(this).attr("data-stid"),"like":$(this).val(),"formulas":formulas},
        success: function (data){
          $(".topics-container").html(data);
          MathJax.Hub.Typeset();
        },
        error: function(){
          window.location.reload(true);
        }
      });


    }
    else{
      $(".page-item").fadeIn();
      $.ajax({
        method: "POST",
        url:    "./AJAX/topics.php",
        data: {"action":"list","last":0,"secid":$(this).attr("data-secid"),"stid":$(this).attr("data-stid"),"formulas":formulas},
        success: function (data){
          $(".topics-container").html(data);
          MathJax.Hub.Typeset();
        },
        error: function(){
          window.location.reload(true);
        }
      });
    }
  });

  $("body").on("click",".topic",function(){if($(this).attr("data-tid"))window.location.href='./view.php'+window.location.search+'&tid='+$(this).attr("data-tid")});

  $("body").on("click",".delete-topic",function(e){
    e.stopPropagation();
    e.preventDefault();
    var id = $(this).attr("data-topic-id");
    var $elem = $(this);
    confirmEmbed("Cette action supprimera le topic et tous ses messages.<br /><br />Ce sujet pourrait servir à d'autres personnes...<br />Voulez vous vraiment continuer ?","Annuler","Confirmer");
    $("body").on("click","#opt2",function(){
      $.ajax({
        method:"POST",
        dataType:"html",
        url:"./AJAX/topics.php",
        data:{"action":"delete","id":id},
        success:function(data){
          if(data=="Topic supprimé."){
            if($("body").attr("id")=="view")history.back();
            $elem.parents(".topic").add(0).addClass("animated fadeOutRight").delay(1000).slideUp();
          }
          },
          error:function(){
            lightbox("Une erreur s'est produite, veuillez réessayer.");
          }
      });

      $("body").off("click","#opt1");
      $("body").off("click","#opt2");
      $(".lightbox").fadeOut("fast", function() { $(this).remove();$(".overlay").fadeOut("fast", function() { $(this).remove();}) });


    });
    $("body").on("click","#opt1",function(){
      $("body").off("click","#opt1");
      $("body").off("click","#opt2");
      $(".lightbox").fadeOut("fast", function() { $(this).remove();$(".overlay").fadeOut("fast", function() { $(this).remove();}) });
    });

  });

  $("body").on("click",".topic-edit",function(e){

    var $elem = $(this);

    $(this).parents(".topic-message").eq(0).children(".forum-msg-right").eq(0).addClass("modify-target");
    var val = $(this).parents(".topic-message").eq(0).children(".forum-msg-right").html();
    var id = $(this).attr("data-topic-id");
    $("#bottom-form-title").text("Edition");
    CKEDITOR.instances["ckinput"].setData(val);
    $("html, body").animate({
      'scrollTop':   $('#editor').offset().top
    }, 1000);
    $("#send-message-wrapper").hide();
    $("#new-forum-message").append('<div class="form-group" id="modify-message-wrapper" style="clear:both;"><div class="row" style="margin-top:30px;">		<div class="col-sm-2 col-sm-offset-4">			<button class="btn btn-danger btn-lightbox" id="cancel">Annuler</button>		</div>		<div class="col-sm-2">			<button class="btn btn-success btn-lightbox" id="modify-topic" data-topic-id="'+id+'">Modifier</button>		</div>	</div></div>');

  });

  $("body").on("click",".msg-frm-edit",function(e){

    var $elem = $(this);

    if($(this).children().eq(0).hasClass("glyphicon-edit")){
      $(this).parents(".topic-message").eq(0).children(".forum-msg-right").eq(0).addClass("modify-target");
      var val = $(this).parents(".topic-message").eq(0).children(".forum-msg-right").html();
      var id = $(this).attr("data-msg-id");
      CKEDITOR.instances["ckinput"].setData(val);
      $("html, body").animate({
        'scrollTop':   $('#editor').offset().top
      }, 1000);
      $("#send-message-wrapper").hide();
      $("#new-forum-message").append('<div class="form-group" id="modify-message-wrapper" style="clear:both;"><div class="row" style="margin-top:30px;">		<div class="col-sm-2 col-sm-offset-4">			<button class="btn btn-danger btn-lightbox" id="cancel">Annuler</button>		</div>		<div class="col-sm-2">			<button class="btn btn-success btn-lightbox" id="modify" data-msg-id="'+id+'">Modifier</button>		</div>	</div></div>');

    }

    else if($(this).children().eq(0).hasClass("glyphicon-remove")){
      var id = $(this).attr("data-msg-id");
      $.ajax({
        url:"./AJAX/messages.php",
        method:"POST",
        dataType:"html",
        data:{"action":"delete","id":id},
        success:function(data){
          $elem.parents(".topic").eq(0).addClass("animated fadeOutRight").delay(1000).slideUp();
        },
        error:function(){
          lightbox("Une erreur s'est produite veuillez réessayer.");
        }


      });
    }
  });

  $("body").on("click","#modify",function(e){
    e.preventDefault();

    var msgid = $(this).attr("data-msg-id");
    var content = CKEDITOR.instances.ckinput.getData();

    $.ajax({
      method	: "POST",
      url		: "./AJAX/messages.php",
      dataType: "html",
      data 	: {"id":msgid,"content":content,"action":"edit"},
      success: function(data){

        $(".hp").remove();
        $("#forum-message-send").parent().append(data);
        if(data){
          $("#title").val("");
          $("iframe").contents().find(".cke_editable").html("");
        }
        $(".modify-target").html(content);
        $(".modify-target").removeClass("modify-target");
        $("#modify-message-wrapper").remove();
        $("#send-message-wrapper").show();

        MathJax.Hub.Queue(["Typeset",MathJax.Hub]);

      },
      error: function(){

          location.reload(true);

      }
    });

  });

  $("body").on("click","#modify-topic",function(e){
    e.preventDefault();

    var msgid = $(this).attr("data-topic-id");
    var content = CKEDITOR.instances.ckinput.getData();

    $.ajax({
      method	: "POST",
      url		: "./AJAX/topics.php",
      dataType: "html",
      data 	: {"id":msgid,"content":content,"action":"edit"},
      success: function(data){

        $(".hp").remove();
        $("#forum-message-send").parent().append(data);
        if(data){
          $("iframe").contents().find(".cke_editable").html("");
        }
        $(".modify-target").html(content);
        $(".modify-target").removeClass("modify-target");
        $("#modify-message-wrapper").remove();
        $("#send-message-wrapper").show();

        MathJax.Hub.Queue(["Typeset",MathJax.Hub]);

      },
      error: function(){

          lightbox("Une erreur s'est produite.</br>Veuillez réessayer...");

      }
    });

  });

  $("body").on("click","#cancel",function(e){

    $("#modify-message-wrapper").remove();
    $("#send-message-wrapper").show();
    $("iframe").contents().find(".cke_editable").html("");




  });

  $("body").on("click","#close-topic",function(e){
    var id = $(".delete-topic").attr("data-topic-id");
    $.ajax({
      method:"POST",
      url:"./AJAX/topics.php",
      dataType:"html",
      data:{"action":"close","id":id},
      success:function(data){
        if(data){
          if($(".topics-container").children().length>=3)$(".topics-container").children().eq(1).remove();
          $(".topics-container").children().first().replaceWith('<div class="row small-row" style="margin-bottom:20px;"><div class="col-sm-4 col-sm-offset-4"><div class="btn btn-primary" id="reopen-topic">Réouvrir</div></div></div><div class="row small-row"><div class="col-xs-12"><div class="alert alert-dead">Sujet fermé.</div></div></div>');
          $("#editor").parents(".container-fluid").first().fadeOut();
        }
      },
      error:function(){
        lightbox("Une erreur s'est produite.<br />Veuillez réessayer...");
      }
    });
  });

  $("body").on("click","#reopen-topic",function(e){
    var id = $(".delete-topic").attr("data-topic-id");
    $.ajax({
      method:"POST",
      url:"./AJAX/topics.php",
      dataType:"html",
      data:{"action":"reopen","id":id},
      success:function(data){
        if(data){
          if($(".topics-container").children().length>=3)$(".topics-container").children().eq(1).remove();
          $(".topics-container").children().first().replaceWith('<div class="row" style="margin-top:30px;margin-bottom:20px;">		<div class="col-sm-2 col-sm-offset-4 col-xs-6">			<button class="btn btn-dead btn-lightbox" id="close-topic">Fermer le topic.</button>		</div>		<div class="col-sm-2 col-xs-6">			<button class="btn btn-primary btn-lightbox" id="solve-topic">Sujet résolu.</button>		</div>	</div><div class="row small-row"><div class="col-xs-12"><div class="alert alert-success">Sujet réouvert.</div></div></div>');
          $("#editor").parents(".container-fluid").first().fadeIn();
        }
      },
      error:function(){
        lightbox("Une erreur s'est produite.<br />Veuillez réessayer...");
      }
    });
  });


  $("body").on("click","#solve-topic",function(e){
    var id = $(".delete-topic").attr("data-topic-id");
    $.ajax({
      method:"POST",
      url:"./AJAX/topics.php",
      dataType:"html",
      data:{"action":"solve","id":id},
      success:function(data){
        if(data){
          if($(".topics-container").children().length>=3)$(".topics-container").children().eq(1).remove();
          $(".topics-container").children().first().replaceWith('<div class="row small-row" style="margin-bottom:20px;"><div class="col-sm-4 col-sm-offset-4"><div class="btn btn-primary" id="reopen-topic">Réouvrir</div></div></div><div class="row small-row"><div class="col-xs-12"><div class="alert alert-primary">Sujet résolu.</div></div></div>');
          $("#editor").parents(".container-fluid").first().fadeOut();
        }
      },
      error:function(){
        lightbox("Une erreur s'est produite.<br />Veuillez réessayer...");
      }
    });
  });


});
