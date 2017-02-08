$(document).ready(function(){
  $("body").on("click",".list-group-item",function(){
    var nextClass=".user-"+$(this).attr("data-target-files");
    $(".user-files").hide();
    $(".disabled").removeClass("disabled");
    $(this).addClass("disabled");
    $(nextClass).show();
  });
  $("body").on("click",".user-files",function(e){
    var file = $(this);
    downloadFile(file.attr("data-fl-id"));
  });
});
