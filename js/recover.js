$(document).ready(function(){
  $("body").on("click","#rc-mail-btn",function(e){

    e.preventDefault();
    e.stopPropagation();

    var mail = $("#mail-rc-input").val();

    //  Sending cookie and mail with encrypted code
    //  Aditionnaly store mail in session
    $.ajax({
      method:"POST",
      url:"./AJAX/setCid.php",
      dataType:"html",
      data:{"mail":mail},
      success : function(data){
        console.log(data);

        if(data === "0"){
          $("#mail-fail").fadeIn();
            setTimeout(function(){$("#mail-fail").fadeOut();},300);
        }
        else {
          $("#step-1").fadeOut();
          $("#step-2").fadeIn();
        }

      }
    });


  });

  $("body").on("click","#rc-id-btn",function(e){

    e.preventDefault();
    e.stopPropagation();

    var code = $("#id-rc-input").val();

    //  Sending code to compare it with cookie
    $.ajax({
      method:"POST",
      url:"./AJAX/matchIdCookie.php",
      dataType:"html",
      data:{"code":code},
      success : function(data){
        //console.log(data);

        if(data === "0"){
          $("#id-fail").fadeIn();
            setTimeout(function(){$("#id-fail").fadeOut();},300);
        }
        else {
          $("#step-2").fadeOut();
          $("#step-3").fadeIn();
        }

      }
    });


  });

  $("body").on("click","#rc-p-btn",function(e){

    e.preventDefault();
    e.stopPropagation();

    var p1 = $("#p1-rc-input").val();
    var p2 = $("#p2-rc-input").val();

    //  Gen error when passwords are not same
    if(p1!=p2){
      $("#pass-fail").fadeIn();
      setTimeout(function(){$("#pass-fail").fadeOut();},300);
      return;
    }

    $.ajax({
      method:"POST",
      url:"./AJAX/modify_profile.php",//  Some dirty stuff there
      dataType:"JSON",
      data:{"pass":p1},
      success : function(data){
        //console.log(data);
        window.location.href = "./";
      },
      error : function(){popError();}
    });


  });


});
