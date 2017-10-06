
            /* attach a submit handler to the form */
            $("#sign_in_form").submit(function(e) {
              /* stop form from submitting normally */
              e.preventDefault();
              var email = $('#email').val();
              var password = $('#password').val();
             
                $('#btn_sign_in').text('Sending...');
                 
                    $.ajax({
                        url:'../controller/login.php',
                        type:'POST',
                        data:$(this).serialize(),
                        success:function(result){
                            if(result!=="successfully"){
                               $('#error-msg').empty().html(result);
                            }
                            if(result==="successfully"){
                              window.location.href="index.html";
                            }
                            $('#btn_sign_in').text('Sign In');
                            //grecaptcha.reset()
                        }
                    });
            });
       