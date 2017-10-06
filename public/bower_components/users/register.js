  /* attach a submit handler to the form */
            $("#register_form").submit(function(e) {
              /* stop form from submitting normally */
              e.preventDefault();
              var password = $('#password').val();
              var retypePassword = $('#retypePassword').val();
              if(password === retypePassword){
                $('#btn-submit-register').text('Sending...');
                 
                    $.ajax({
                        url:'../controller/register.php',
                        type:'POST',
                        data:$(this).serialize(),
                        success:function(result){
                            $('#error-msg').empty().html(result);
                            $('#btn-submit-register').text('Register');
                            grecaptcha.reset();
                           
                        }
                        
                    });
              }else{
                var error_msg_html ='<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>The password don&apos;t match!</h5></div>';
                 $('#error-msg').empty().html(error_msg_html);
              }
                
                   
            });
       