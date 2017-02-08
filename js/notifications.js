var nbnotifs = 0;
function buildNotif(fill,add){
  if(add===undefined)add='';
  var type;
  switch(parseInt(fill._type)){
    case 1:
      type="alert-info";
    break;
    case 2:
      type="alert-danger";
    break;
    case 3:
      type="alert-success";
    break;
    case 4:
      type="alert-warning";
    break;
    case 10:
      type="remember-alert";
    break;
  }
  var notif = '<div class="alert '+type+' alert-dismissible"><button type="button" data-notif-id="'+fill._id+'" class="close '+add+'"><span aria-hidden="true">&times;</span></button>'+fill._content+'</div>';

  return notif;
}

$(document).ready(function(){
  $.ajax({
    method	: "POST",
    url		: "./AJAX/concerned_posts.php",
    dataType: "JSON",
    data 	: {"type":$('body').attr('id')},
    success: function(data){
      var objs = data;
      nbnotifs+=objs.length;
      for(var i=0;i<objs.length;i++){
        objs[i]._type=2;
        objs[i]._content='<strong>'+objs[i]._author+'</strong> vous a cité dans une publication.<br /><br /><button class="btn btn-primary publication-spoiler citation" data-pub-id="'+objs[i]._id+'">Voir la publication.</button>';
        $(".notifs-container").append(buildNotif(objs[i],'post-notif'));
      }
      if(nbnotifs>0)$(".mobile-buttons").children().eq(2).children(".badge").eq(0).html(nbnotifs);
    },
    error: function(){

        window.location.reload(true);

    }
  });
  $.ajax({
    method	: "POST",
    url		: "./AJAX/notifications.php",
    dataType: "JSON",
    data 	: {"type":$('body').attr('id')},
    success: function(data){
      var objs = data;
      nbnotifs+=objs.length;
      for(var i=0;i<objs.length;i++)
        $(".notifs-container").append(buildNotif(objs[i]));
      if(nbnotifs>0)$(".mobile-buttons").children().eq(2).children(".badge").eq(0).html(nbnotifs);
    },
    error: function(){

        window.location.reload(true);

    }
  });
  $('body').on('click','.publication-spoiler:not(.citation), .close:not(.post-notif)',function(){
    $(this).parents().eq(0).addClass("animated fadeOutRight").delay(600).slideUp();
    var $element = $(this);
    var id =($element.attr("data-notif-id")||$element.parents().eq(0).children().first().attr("data-notif-id"));
    $.ajax({
      type  :"POST",
      url   :"./AJAX/remove_notif.php",
      dataType:"html",
      data  :{"id":id}

    });
  });
  $('body').on('click','.publication-spoiler:not(.citation)',function(){

    var $elem = $(this);
    var id = $(this).attr('data-pub-id');

    $.ajax({
      method:"POST",
      dataType:"html",
      data:{'place':'target-post','id':id,'begin':0,nb:1},
      url:'./AJAX/thread.php',
      success:function(data){
        $("#thread").prepend(data);
        $("#thread").children().first().addClass("animated pulse");
        $("#thread").children().first().css("border","1px solid #f78f97");
        $elem.parents().eq(0).addClass("animated fadeOutRight").delay(600).slideUp();
      },
      error:function(){
        console.log('error');
      }

    });
  });
  $('body').on('click','.close.post-notif',function(){
    $(this).parents().eq(0).addClass("animated fadeOutRight").delay(600).slideUp();
    var $element = $(this);
    $.ajax({
      type  :"POST",
      url   :"./AJAX/remove_notif.php",
      dataType:"html",
      data  :{"id":$element.attr("data-notif-id"),"type":"delete-citation"}
    });
  });
  $('body').on('click','.publication-spoiler.citation',function(){
    var $elem = $(this);
    var id = $(this).attr('data-pub-id');
    $.ajax({
      type  :"POST",
      url   :"./AJAX/remove_notif.php",
      dataType:"html",
      data  :{"id":id,"type":"delete-citation"}
    });
    $.ajax({
      method:"POST",
      dataType:"html",
      data:{'place':'target-post','id':id,'begin':0,nb:1},
      url:'./AJAX/thread.php',
      success:function(data){
        $("#thread").prepend(data);
        $("#thread").children().first().addClass("animated pulse");
        $("#thread").children().first().css("border","1px solid #f78f97");
        $elem.parents().eq(0).addClass("animated fadeOutRight").delay(600).slideUp();
      },
      error:function(){
        console.log('error');
      }

    });
  });
});
