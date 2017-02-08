$(document).ready(function(){

  $("body").on("keyup","#search-space",function(){
    if($(this).val()!="")autoSuggest($("#search-space"),$(".user-preview .list-group"));
    else $(".user-preview .list-group").children(".list-group-item").remove();
  });

});
