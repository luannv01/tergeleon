 $( document ).ready(function() {
          $.urlParam = function(name){
              var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
              if (results==null){
                 return null;
              }
              else{
                 return decodeURI(results[1]) || 0;
              }
          }
              if($.urlParam("token") === null || $.urlParam('email') === null ){
                window.location.href="error.html";
              }else{
                var token = $.urlParam("token");
                var email = $.urlParam("email");
                $('#id').attr("value",email);

                $.ajax({ 
                            url:'../controller/reset-pass.php',
                            type:'POST',
                            data:{token: token, email:email},
                            success:function(result){
                              if(result!=="s"){
                                window.location.href="error.html";
                              }
                            }
                        });
              }
        });

 $('#reset_pass').submit(function(e){
  e.preventDefault();
  $('#btn_reset_pass').text("Sending...");
  var pass = $('#password').val();
  var rePass = $('#retypePassword').val();
  if(pass !== rePass){
    var err = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>The password doesn&#39;t match</h5></div>';
    $('#error-msg').empty().html(err);
    return false;
  }
   $.ajax({ 
          url:'../controller/change-password.php',
          type:'POST',
          data:$(this).serialize(),
          success:function(result){
            $('#error-msg').empty().html(result);
            grecaptcha.reset();
            $('#btn_reset_pass').text("Submit");
          }
      });
 });