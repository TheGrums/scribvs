function buildFile(file){
  return '<a href="'+file._path+'" download="'+file._name+'" target="_blank"><div class="col-xs-4 file-item" data-fl-sup="'+file._suppressible+'" data-fl-id="'+file._id+'"><img src="'+file._preview+'" /><span '+(file._suppressible?"style='color:green;'":"")+' >'+file._name+'</span></div></a>';
}


$(document).ready(function(){

var files_array = [];
var destination="";
var startTime, endTime;
var longpress = false;
var userid = 0;

if(userid = $('body').attr("data-user-id"));


$.ajax({
  method	: "POST",
  url		: "./AJAX/files.php",
  dataType: "JSON",
  data 	: {"type":$('body').attr('id'),"uid":userid},
  success: function(data){
    files_array=data;
    for(j=0;j<files_array.length;j++){
      if(j%3==0)$('#files-container').append('<div class="row"></div>');
      $('#files-container').children('.row').last().append(buildFile(files_array[j]));
    }
    $('#files-container').append('</div>');
  },
  error: function(){

      window.location.reload(true);

  }
});

$('body').on('click', "#add-file",function(){
  $(this).css("display","none");
  $(".send-file").css("display","inline-block").addClass("animated fadeInRight");
});

$('body').on('click',".send-file",function(){
  destination = $(this).attr("id");
});

$('body').on('change', "#file-input", function(){
  $(".dialog-box-container").removeClass("animated wobble");
  var fd = new FormData();
  for (var i = 0; i < $(this)[0].files.length; i++) {
    var file = $(this)[0].files[i];
    if (file != ""){
      fd.append('files[]', file, file.name);
    }
  }
  fd.append('dest',destination);
  $.ajax({
      url: './AJAX/post_file.php',
      type: 'POST',
      cache: false,
      data: fd,
      dataType: "JSON",
      processData: false,
      contentType: false,
      beforeSend: function(){
        $("#files-container").children().eq(0).prepend('<div class="col-xs-4 col-xs-offet-4 load-item file-item" data-fl-sup="true" data-fl-id="214"><img src="./pictures/loader.gif" style="width:73%;margin: 24% 0%;"><span style="color:green;">Envoi</span></div>');
      },
      success: function (data) {
        $('.load-item').fadeOut();
        if(data=="error"){
          $(".dialog-box-container").addClass("animated wobble");
          return;
        }
        files_array = data.concat(files_array);
        $('#files-container').empty();
        $('#files-container').append('<div class="row"></div>');
        for(j=0;j<files_array.length;j++){
          if(j%3==0)$('#files-container').append('<div class="row"></div>');
          $('#files-container').children('.row').last().append(buildFile(files_array[j]));
        }
        $('#files-container').append('</div>');
      },
      error: function () {
        alert("une erreur s'est produite.");
      }
  });
});


$('body').on('click', '.file-item', function (e) {
    var file=$(this);
    if(longpress){
      e.preventDefault();
      e.stopPropagation();
      var confirmed=true;
      var path = $(this).parents().eq(0).attr("href");
      var $element = $(this);
      if($(this).attr("data-fl-sup")=="true"){
        confirmEmbed("Ce fichier vous appartient. <br />Cette action empêchera tous les destinataires de ce fichier d'y accéder.","Annuler","Confirmer");
        $("body").on("click","#opt2",function(){
          $.ajax({
            method	: "POST",
            url		: "./AJAX/remove_file.php",
            dataType: "html",
            data 	: {"fid":$element.attr('data-fl-id')},
            success: function(data){
              $element.addClass("animated zoomOut");
              for (var i=0; i < files_array.length; i++) {
                if (files_array[i]._path == path) {
                  files_array.splice(i,1);
                }
              }
            },
            error: function(){
              window.location.reload(true);
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
      }
      else {
        $.ajax({
          method	: "POST",
          url		: "./AJAX/remove_file.php",
          dataType: "html",
          data 	: {"fid":$element.attr('data-fl-id')},
          success: function(data){
            $element.addClass("animated zoomOut");
            for (var i=0; i < files_array.length; i++) {
              if (files_array[i]._path == path) {
                files_array.splice(i,1);
              }
            }

          },
          error: function(){
            window.location.reload(true);
          }
        });
      }


    }
    else{
      downloadFile(file.attr("data-fl-id"));
    }
});

$('body').on('taphold', '.file-item', function (e) {
    var file=$(this);
      e.preventDefault();
      e.stopPropagation();
      var confirmed=true;
      var path = $(this).parents().eq(0).attr("href");
      var $element = $(this);
      if($(this).attr("data-fl-sup")=="true"){
        confirmEmbed("Ce fichier vous appartient. <br />Cette action empêchera tous les destinataires de ce fichier d'y accéder.","Annuler","Confirmer");
        $("body").on("click","#opt2",function(){
          $.ajax({
            method	: "POST",
            url		: "./AJAX/remove_file.php",
            dataType: "html",
            data 	: {"fid":$element.attr('data-fl-id')},
            success: function(data){
              $element.addClass("animated zoomOut");
              for (var i=0; i < files_array.length; i++) {
                if (files_array[i]._path == path) {
                  files_array.splice(i,1);
                }
              }

            },
            error: function(){
              window.location.reload(true);
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
      }
      else {
        $.ajax({
          method	: "POST",
          url		: "./AJAX/remove_file.php",
          dataType: "html",
          data 	: {"fid":$element.attr('data-fl-id')},
          success: function(data){
            $element.addClass("animated zoomOut");
            for (var i=0; i < files_array.length; i++) {
              if (files_array[i]._path == path) {
                files_array.splice(i,1);
              }
            }

          },
          error: function(){
            window.location.reload(true);
          }
        });
      }
});


$('body').on('mousedown', '.file-item', function (e) {
    e.preventDefault();
    startTime = new Date().getTime();
});

$('body').on('mouseup', '.file-item', function (e) {
    e.preventDefault();
    endTime = new Date().getTime();
    longpress = (endTime - startTime < 500) ? false : true;
});

});
