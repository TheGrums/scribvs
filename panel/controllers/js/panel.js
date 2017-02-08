var tmpmembers = [];

function autoSuggestGroups($source,$target){
  $.ajax({
    url     : "./AJAX/groups.php",
    method  : "POST",
    dataType: "html",
    data    :{"q":$source.val(),"type":"autosuggest"},
    success : function(data){
      $target.children(".list-group-item").remove();
      if(data){
          $target.append(data);
      }
    }

  });
}
function setPanelActive(nbr){

  $(".active").removeClass("active");
  var $elem = $(".panel-nav-item").eq(nbr);
  $elem.addClass("active");
  window.location.hash = nbr;

  $.ajax({
    method  :"GET",
    url     :"./AJAX/"+$elem.attr("data-ajax-target")+".php",
    dataType:"html",
    beforeSend: function() {
        $(".panel-main-container").empty();
    },
    success :function(data){
      $(".panel-main-container").append(data);
    },
    error   :function(){
      ligthbox("<h3>Une erreur s'est produite, veuillez réessayer.</h3>");
    }
  });


}
function fileNotif(id,$elem){
  $.ajax({
    method  :"POST",
    url     :"./AJAX/sendNotif.php",
    dataType:"html",
    data    :{"id":id,"type":"file"},
    success :function(data){
      $elem.replaceWith("<span class='glyphicon glyphicon-ok btn' style='border:1px solid green;'></span>");
    },
    error   :function(){
      lightbox("<h5>Une erreur s'est produite, veuillez réessayer.</h5>");
    }
  });
}
function deleteFile(fid,$elem,url){
  $.ajax({
    method  :"POST",
    url     :"../AJAX/remove_file.php",
    dataType:"html",
    data    :{"fid":fid},
    success :function(data){
      if(url!=undefined){
        $.ajax({
          method  :"GET",
          url     :"./controllers/"+url+".php",
          dataType:"html",
          success :function(data){
            var $newelem = $.parseHTML(data);
            $elem.fadeOut().replaceWith($newelem);
          }
        });
      }
      else{
        $elem.fadeOut();
      }
    },
    error   :function(){
      lightbox("<h5>Une erreur s'est produite, veuillez réessayer.</h5>");
    }
  });
}
function detachGroupOwner(gid,$elem){
  $.ajax({
    method  :"POST",
    url     :"./AJAX/groups.php",
    dataType:"html",
    data    :{"id":gid,"type":"detachOwner"},
    success :function(data){
      $elem.slideUp();
    },
    error   :function(){
      lightbox("<h5>Une erreur s'est produite, veuillez réessayer.</h5>");
    }
  });
}
function detachGroupMember(gid,uid,$elem){
  $.ajax({
    method  :"POST",
    url     :"./AJAX/groups.php",
    dataType:"html",
    data    :{"uid":uid,"id":gid,"type":"detachMember"},
    success :function(data){
      if(data=="1")$elem.fadeOut();
      else lightbox("Un groupe ne peut être vide !");
    },
    error   :function(){
      lightbox("<h5>Une erreur s'est produite, veuillez réessayer.</h5>");
    }
  });
}
function getPubImages(){
  $(".pub-content img").each(function(){var src = $(this).attr("src");$(this).attr("src","../"+src)});
}
function deletePost($elem,pid){
  $.ajax({
    method  :"POST",
    url     :"../AJAX/remove_post.php",
    dataType:"html",
    data    :{"id":pid},
    success :function(data){
      $elem.parents(".container-fluid").first().addClass("animated fadeOutRight").delay(1500).slideUp();
    },
    error   :function(){
      lightbox("<h5>Une erreur s'est produite, veuillez réessayer.</h5>");
    }
  });
}
function sendWelcomeForm(){
  $.ajax({
    method:"POST",
    url:"../AJAX/modify_profile.php",
    dataType:"html",
    data:{"lesson":$("#lesson-input").val()},
    success:function(data){
      if(data){
        window.location.reload(true);
      }
    },
    error:function(){
      window.location.reload(true);
    }
  });
}
function sendFileToGroup($fileinput,chkname){
  var fd = new FormData();
  for (var i = 0; i < $fileinput[0].files.length; i++) {
    var file = $fileinput[0].files[i];
    if (file != ""){
      fd.append('files[]', file, file.name);
    }
  }
  var selectedGroups=[];
  $('input[name="'+chkname+'"]:checked').each(function() {
    selectedGroups.push(this.value);
  });
  fd.append('dest','file-group');
  fd.append('groups',selectedGroups);
  $.ajax({
      url: '../AJAX/post_file.php',
      type: 'POST',
      cache: false,
      data: fd,
      dataType: "JSON",
      processData: false,
      contentType: false,
      success: function (data) {
        var file = data[0];
        $(".files-row").append('<div class="col-md-2 col-sm-4 col-xs-6 file-item file-panel-item col-centered" style="background-color:#c9f2c9;"><img src=".'+file._preview+'"><br /><span class="file-panel-name">'+file._name+'</span><div class="file-panel-info">'+file._send_date+'</div><div class="btn btn-danger btn-small" style="float:none;" onclick="deleteFile('+file._id+',$(this).parents(\'.file-panel-item\').eq(0));">Supprimer</div></div>');
      },
      error: function () {
        lightbox("Une erreur s'est produite, veuillez réessayer.");
      }
  });
}
function addOwnedGroup(gid,fct){
  $.ajax({
    method:"POST",
    url:"./AJAX/groups.php",
    dataType:"html",
    data:{"type":"addOwner","id":gid},
    success: function(data){
      if(fct!=undefined)fct(data);
    },
    error: function(){

    }
  });
}
function callCreationTool(){
  $.ajax({
    url:"./AJAX/group_creation_tool.php",
    method:"GET",
    dataType:"html",
    success:function(data){
      $(".group-tool").remove();
      $(".well").append(data);
    },
    error:function(){
      lightbox("Une erreur s'est produite, veuillez réessayer.");
    }


  });
}
function addMemberCreationTool($elem){
  var name = $elem.parents(".list-group-item").eq(0).children(".list-group-item-heading").eq(0).text();
  var id = $elem.parents(".list-group-item").eq(0).attr("data-user-id");

  if(tmpmembers.indexOf(id)==-1){
    tmpmembers.push(id);
    if($("#group-preview").children("tr").last().children().length>=3)
      $("#group-preview").append("<tr></tr>");

    $("#group-preview").children("tr").last().append('<td data-user-id = "'+id+'">'+name+'<button class="btn btn-small btn-danger remove-tmpmbmr" style="padding: 2px 8px 5px;"><span class="glyphicon glyphicon-ban-circle" style="font-size:0.9em;"></span></button></td>');

  }

  $elem.replaceWith("<label class='label label-success'>Ajouté</label>");

}
function deleteCreationTool(){
  $(".well").eq(0).children(".container-fluid").eq(0).fadeOut("slow",function(){$(this).remove();});
}
function sendNewGroupData(){

  if($("#new-group-name").val()==""){$("#new-group-name").css("border","1px solid red");$("#grp-creator-error").html("Veuillez indiquer un nom pour votre groupe.");return;}
  if(tmpmembers.length==0){$("#search-space-students").css("border","1px solid red");$("#grp-creator-error").html("Veuillez ajouter des membres à votre groupe.");return;}

  $.ajax({
    url:  "./AJAX/groups.php",
    method: "POST",
    dataType: "html",
    data:{"name":$("#new-group-name").val(),"type":"createGroup","members":tmpmembers},
    success:function(data){
      $("#add-row").prepend(data);
      deleteCreationTool();
      $("#group-results-area").prepend("<div class='help-block' style='color:green;text-align: center;font-family: Sniglet;font-size: 11px;'>Groupe ajouté.</div>");
      setTimeout(3000,function(){$("#group-results-area .help-block").fadeOut();});
    },
    error:function(){
      lightbox("Une erreur s'est produite, veuillez réessayer.");
    }
  });
}
function addMember(uid,gid){

  return $.ajax({
    method:"POST",
    url:"./AJAX/groups.php",
    dataType:"html",
    data:{"type":"addMember","uid":uid,"gid":gid}
  });


}

$(document).ready(function(){

  setPanelActive(parseInt(window.location.hash.substr(1,2)));

  $("body").on("change","#check-all",function(){
    if($(this).prop("checked"))$('.chk-in').prop('checked', true);
    else $('.chk-in').prop('checked',false);
  });

  $("body").on("keyup","#search-space-groups",function(){
    if($(this).val()!="")autoSuggestGroups($(this),$("#group-results-area"));
    else $("#group-results-area").empty();
  });

  $("body").on("click",".quick-add-group",function(e){
    e.stopPropagation();
    e.preventDefault();
    $elem = $(this);
    addOwnedGroup($(this).attr("data-group-id"),function(arg){
      $elem.replaceWith("<label class='label label-success'>Groupe ajouté</label>");
      $("#add-row").prepend(arg);
    });
  });

  $("body").on("click","#search-students-results .list-group-item",function(e){
    e.preventDefault();
  });

  $("body").on("keyup","#search-space-students",function(e){
    e.stopPropagation();
    e.preventDefault();
    if($(this).val()!="")autoSuggest($(this),$("#search-students-results"),".",'<button class="btn btn-success btn-small" onclick="event.stopPropagation();event.preventDefault();addMemberCreationTool($(this));" style="float:none;"><span class="glyphicon glyphicon-plus"></span></button>');
    else $("#search-students-results").empty();
  });

  $("body").on("click",".remove-tmpmbmr",function(e){
      $(this).parents("td").eq(0).remove();
      var id = tmpmembers.indexOf($(this).parents("td").eq(0).attr("data-user-id"));
      tmpmembers.splice(id,1);
  });

  $("body").on("click",".quick-add-member",function(){

    var $elem=$(this);
    addMember($(this).parents().eq(1).children().first().attr("data-cmp-val"),$(this).parents(".panel").eq(0).attr("data-group-id")).success(function(data){
      if(data!="1"){
        $elem.parents("tbody").first().children().last().children().last().children().last().children().first().children().first().children().first().html("<div class='animated fadeOut' style='animation-delay:1.5s;text-align:left;'>Cet utilisateur n'existe pas ou est déjà membre de ce groupe.</div>");
        return;
      }
      $elem.parents("tbody").first().prepend('<tr><td colspan="2">'+$elem.parents(".input-group").eq(0).children("input").first().val()+'<button class="btn btn-small btn-danger" onclick="detachGroupMember('+$elem.parents(".panel").eq(0).attr("data-group-id")+', '+$elem.parents(".input-group").eq(0).children("input").first().attr("data-cmp-val")+',$(this).parents(\'td\').eq(0));" style="padding: 2px 8px 5px;"><span class="glyphicon glyphicon-ban-circle" style="font-size:0.9em;"></span></button></td>              </tr>');
      $elem.parents().eq(1).children().first().val("");
      $elem.parents().eq(1).children().first().attr("data-cmp-val","");
    });
  });



});
