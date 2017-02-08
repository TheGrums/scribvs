function autoSuggest($source,$target,depth,button,fct,additional){
  if(depth==undefined)var depth="";
  $target.show();
  if($source.val()==""||$source.val()==" "){$target.empty();$target.hide();return;}
  $("body").on("click",".suggestion-item",function(e){
    e.stopPropagation();
    e.preventDefault();
    var sel = $(this).parents().eq(0).attr("data-linked-to");
    $(sel).val($(this).html());
    $(sel).attr("data-cmp-val",$(this).attr("data-val"));
    $target.empty();
    $target.hide();

  });
  $.ajax({
    url     : depth+"./AJAX/autosuggest.php",
    method  : "POST",
    dataType: "JSON",
    data    :{"q":$source.val(),"add":(additional===undefined?"":additional)},
    success : function(data){
      $target.empty();
      if(!data.status){
        var objs = data;
        for(var i=0;i<objs.length;i++){
          if(fct==undefined)$target.append(createPreview(objs[i],depth,button));
          else {
            $target.append(fct(objs[i],depth,$target));
          }
        }
      }
    }

  });

}
function createPreview(userTarget,depth,button){

  var anon=true;

  if(depth==undefined)var depth="";
  if(button==undefined){var button=(userTarget._alreadyfriend||userTarget._id==user._id?'<label class="label label-success">Vous êtes déjà amis.</label>':'<button class="btn btn-success btn-small quick-add-friend" data-user-id = "'+userTarget._id+'" style="float:none;"><span class="glyphicon glyphicon-plus"></span> <span class="glyphicon glyphicon-user"></span></button>');anon = false;}

  /*if(user._level>=3&&userTarget._level<3&&!anon){
    button+= '<button class="btn btn-primary btn-small quick-ban-user" data-user-id = "'+userTarget._id+'" style="float:none;"><span class="glyphicon glyphicon-link"></span> Lier un groupe</button>';
  }
  else if(user._level>3&&userTarget._level<3&&!anon){
    button+= '<button class="btn btn-danger btn-small quick-link-group" data-user-id = "'+userTarget._id+'" style="float:none;"><span class="glyphicon glyphicon-fire"></span> Bannir</button>';
  }*/

  var preview = '<a href="'+depth+'./profile.php?q='+userTarget._familyname+'-'+userTarget._firstname+'" class="list-group-item" data-user-id = "'+userTarget._id+'">'+
    '<h4 class="list-group-item-heading"><img src="'+depth+userTarget._img+'" style="width:60px;height:60px;"/>'+userTarget._firstname+' '+userTarget._familyname+'</h4>'+
    '<p class="list-group-item-text">';
    for(var j=0;j<userTarget._groups.length;j++)
      preview+='<span class="label label-default">'+userTarget._groups[j]._name+'</span>';

  preview+='<span class="label label-primary">'+userTarget._status+'</span>'+
    button+'</p></a>';

  return preview;

}
function createSimplePreview(userTarget,depth, $target){
    var preview = '<a class="list-group-item suggestion-item" data-val="'+userTarget._id+'">'+userTarget._firstname+' '+userTarget._familyname+'</a>';
    return preview;
}
