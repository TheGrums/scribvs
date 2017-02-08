$(document).ready(function(){

  $("#home").on('click',function(){
    window.location.reload();
  });

  $("#profile-img-change").click(function(e){
    e.preventDefault();
    e.stopPropagation();

    var form = "<div class='container-fluid canvas-wrapper'>"+
                  "<div class='row'>"+
                      "<div class='col-sm-12'>"+
    		                "<canvas data-attached-input='files' style='margin:auto;border: 1px solid rgba(0,0,0,0.2);' width='300px' height='300px' ></canvas>"+
                      "</div>"+
                    "</div>"+
                    "<div class='row'>"+
                      "<div class='col-sm-12'>"+
                        "<label for='scale' id='range-input-label'></label><input id = 'scale' data-track-theme='d' data-theme='b' type='range' name='size' min='50' max='200' value='100' style='width:40%;margin:20px auto 20px;'>"+
                      "</div>"+
                    "</div>"+
                  "<div class='row'>"+
                    "<div class='col-sm-2 col-sm-offset-4 col-xs-3 col-xs-offset-3'>"+
                      "<button class='btn btn-primary embed-file-input' data-target-input='files' >"+
                        "<span class='glyphicon glyphicon-retweet'></span>"+
                      "</button>"+
                    "</div>"+
                    "<div class='col-sm-2 col-xs-3'>"+
                      "<button class='rotate-canvas' style='display:none;'>rotate</button>"+
                      "<button class='save profile-img-save btn btn-success'><span class='glyphicon glyphicon-ok'></span></button>"+
                    "</div>"+
                  "</div>"+
                  "<input class='files profile-img-input' style = 'display:none;' id='files' type='file' /></div>";

    lightbox(form);

    $( "#scale" ).slider();

    var fileInput = document.querySelector('#files');
    fileInput.addEventListener('change', function(e) {
      userImage = new UserImage({
        wrapperSelector: ".canvas-wrapper",
        borderStyle: "circle",
        borderWidth: 25,
        borderStroke: "#767FC4",
        borderShade: "#1D1D32B3",
        cropWidth: 300,
        cropHeight: 300
      });
    });



  });

  $("body").on("click",".profile-img-save",function(){console.log("caca");lightboxClose("fst-lgtbx")});

  $("#settings").on('click',function(){

      $.ajax({
        url     : "./AJAX/settings.php",
        method  : "GET",
        success : function(data){
          $(".profile-container").parent().hide().empty().prepend(data).fadeIn();
          $(document).on('change', '.btn-file :file', function() {
            var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
          });

          $(document).ready( function() {
            $('.btn-file :file').on('fileselect', function(event, numFiles, label) {

              var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

              if( input.length ) {
                input.val(log);
              } else {
                if( log ) alert(log);
              }

            });
          });

        }

      });
  });

  $("#friends").on('click',function(){

      $.ajax({
        url     : "./AJAX/friends.php",
        method  : "GET",
        success : function(data){
          $("body").on("keyup","#search-space",function(){
            if($(this).val()!="")autoSuggest($("#search-space"),$(".user-preview .list-group"));
            else $(".user-preview .list-group").children(".list-group-item").remove();
          });
          $(".profile-container").parent().hide().empty().prepend(data).fadeIn();
        }

      });
  });

  $("body").on("click",".btn-add-friend",function(e){
    e.stopPropagation();
    e.preventDefault();

    var id = $(this).attr("data-user-id");
    var $userpreview = $(this).parents(".list-group-item");

    $.ajax({
      url     : "./AJAX/add_friend.php",
      method  : "POST",
      dataType: "html",
      data    :{"id":id},
      success : function(data){

        if(data){
          var nbr = $(".well-lg strong").html();
          $(".well-lg strong").html(parseInt(nbr)-1);
          $(".list-group").eq(0).append($userpreview);
          $(".list-group").eq(0).children().last().children('.list-group-item-text').eq(0).prepend('<span class="label label-default">'+user._firstname+' '+user._familyname+'</span>');
          $('<button data-nth-friend="4" style="float:none;" class="btn btn-danger btn-small delete-friend" role="button"><span class="glyphicon glyphicon-ban-circle"></span></button>').replaceAll('.friends .btn-add-friend');
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

  $("#class").on('click',function(){
    location.href = "./class.php?q="+$(this).children().last().text();
  });

  $("body").on('click','.delete-friend .glyphicon-ban-circle',function(e){
    e.preventDefault();
  });

  $("body").on('click','.delete-friend',function(e){
    e.preventDefault();
    e.stopPropagation();
    var id = $('.friends .list-group-item').index($(this).parents(".list-group-item").eq(0));
    var element = $(this);
    $.ajax({
      url     : "./AJAX/remove_friend.php",
      method  : "POST",
      dataType: "html",
      data    : {"id":id},
      success : function(data){
        var nbr = $(".well-lg strong").html();
        $(".well-lg strong").html(parseInt(nbr)+1);
        element.parents(".list-group-item").eq(0).slideUp("normal",function() { $(this).remove(); });
      },
      error : function(){
        lightbox("Une erreur c'est produite. Veuillez en alerter les concepteurs du site au plus vite.");
      }
    });
  });

  $("body").on('click','#modify',function(e){

    e.stopPropagation();

    var fdata = new FormData($('#settings-form')[0]);

    $.ajax({
      url     : "./AJAX/settingscript.php",
      method  : "POST",
      data    : fdata,
      cache: false,
      contentType: false,
      processData: false,
      success : function(data){
        $("#info").empty();
        $("#info").append(data);
        $.ajax({

          url:"./AJAX/getusrinfo.php",
          method:"GET",
          dataType:"JSON",
          success:function(data){var user = data;$('#profile-image').children().first().css('background-image','url(\''+user.img+'\')');},
          error:function(){window.location.reload(true);}

        });

      }
    });

  });

  $('body').on('drag dragstart dragend dragover dragenter dragleave drop', 'canvas',function(e) {
    e.preventDefault();
    e.stopPropagation();
  })
  .on('dragover dragenter','canvas', function() {
      $(this).css('box-shadow','inset 0 0px 10px -2px rgba(0,0,0,0.2)');
      $(this).css('-webkit-box-shadow','inset 0 0px 10px -2px rgba(0,0,0,0.2)');
      $(this).css('-moz-box-shadow','inset 0 0px 10px -2px rgba(0,0,0,0.2)');
      $(this).css('border-color','#6E77C0');
  })
  .on('dragleave dragend drop','canvas', function() {
      $(this).css('box-shadow','none');
      $(this).css('-webkit-box-shadow','none');
      $(this).css('-moz-box-shadow','none');
      $(this).css('border-color','#CCCCCC');
  })
  .on('drop','canvas', function(e) {
    var wrapper       = document.querySelector('.canvas-wrapper');
    var canvas        = wrapper.getElementsByTagName('canvas')[0];
    var ctx = canvas.getContext('2d');
    ctx.clearRect(0,0, 400, 400);
    var imgObj        = {};
    var canvasObj     = {};
    var fileInput     = wrapper.querySelector('.files');
    var file          = e.originalEvent.dataTransfer.files[0];
    canvasObj.element = canvas;
    canvasObj.height  = canvas.height;
    canvasObj.width   = canvas.width;
    var imageType     = /image.*/;

    if (file.type.match(imageType)) {

      var reader = new FileReader();
      reader.onloadend = function(e) {
        var img = new Image();
        img.src = reader.result;
        console.log(img.src);
        img.onload = function() {
          imgObj.file     = img;
          imgObj.src      = img.src;
          imgObj.width    = img.width;
          imgObj.height   = img.height;
          myEditableImage = new ImageManipulator(imgObj, canvasObj, {

              wrapperSelector: ".canvas-wrapper",
              borderStyle: "circle",
              borderWidth: 25,
              borderStroke: "#767FC4",
              borderShade: "#1D1D32B3",
              cropWidth: 300,
              cropHeight: 300

          });
        };
      };
      reader.readAsDataURL(file);
    }

  });

});
