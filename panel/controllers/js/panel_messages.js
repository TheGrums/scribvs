var dest = [];
var destgr = [];
function setView(nbr){

  $(".btn-default.active").removeClass("active");
  var $elem = $(".slide-button").eq(nbr);
  $elem.addClass("active");
  $(".part").hide();
  $(".part-"+nbr).show();

}
function sendMessage(){
  $('input[name="groups"]:checked').each(function() {
    destgr.push(this.value);
    $(this).removeAttr("checked");
  });
  if(dest.length==0&&$("#suggest-dest").val()!=""&&$("#suggest-dest").val()!=undefined){var destid = $("#suggest-dest").attr("data-cmp-val");dest.push(destid);}

  if($("#message-input").val()!=""&&$("#message-input").val()!=undefined&&(dest.length!=0||destgr.length!=0)){
    $.ajax({
      url:"../AJAX/send_imail.php",
      method:"POST",
      dataType:"html",
      data:{"dest":dest,"destgr":destgr,"content":$("#message-input").val()},
      success:function(data){
        if(data){
          var originalsize = $("#sended-mails").children().length;
          $("#sended-mails").prepend(data);
          var newsize = $("#sended-mails").children().length;
          for(var i=0;i<newsize-originalsize;i++)$("#sended-mails").children().eq(i).children().first().css('background-color','rgb(204, 206, 246)');
          $("#suggest-dest").val("");
          $("#message-input").val("");
          $(".dest-area").empty();
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

}
$(document).ready(function(){

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
    $(".dest-area").append("<div style='display:inline-block;'>"+(dest.length!=1?" ,":" ")+destname+"</div>");
  });


});
