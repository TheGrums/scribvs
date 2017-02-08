var dest = [];
var destgr = [];
function setView(nbr){

  $(".active").removeClass("active");
  var $elem = $(".panel-nav-item").eq(nbr);
  $elem.addClass("active");
  window.location.hash = nbr;
  $(".part").hide();
  $(".part-"+nbr).show();

}
$(document).ready(function(){
  setView(parseInt(window.location.hash.substr(1,2)));

  $("body").on("click","#add-dest",function(){
    var destid = $(this).parents().eq(1).children().first().attr("data-cmp-val");
    if(destid===undefined||dest.indexOf(destid)!=-1){
      $("#add-fail").fadeIn();
      setTimeout(function(){$("#add-fail").fadeOut();},2000);
      return;
    }
    var destname = $(this).parents().eq(1).children().first().val();
    $(this).parents().eq(1).children().first().val("");
    dest.push(destid);
    $(".dest-area").append(destname + "<br />");
  });

  $("body").on("click","#internal_message_send",function(){
    if(dest.length==0&&$("#suggest-dest").val()!=""&&$("#suggest-dest").val()!=undefined){var destid = $("#suggest-dest").attr("data-cmp-val");dest.push(destid);}
    if($("#message-input").val()!=""&&$("#message-input").val()!=undefined&&(dest.length!=0||destgr.length!=0)){

      $.ajax({
        url:"./AJAX/send_imail.php",
        method:"POST",
        dataType:"html",
        data:{"dest":dest,"destgr":destgr,"content":$("#message-input").val()},
        success:function(data){
          if(data){
            $("#sended-mails").prepend(data);
            $("#sended-mails").children().first().children().first().css('background-color','rgb(164, 172, 234)');
            $("#suggest-dest").val("");
            $("#message-input").val("");
            dest=[];
          }
        },
        error:function(){
          popError();
        }
      });

    }
    else{
      $("#send-fail").fadeIn();
      setTimeout(function(){$("#add-fail").fadeOut();},2000);
    }
  });

});
