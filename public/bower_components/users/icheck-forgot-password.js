       
            $("#forgot_form").submit(function(e) {
              /* stop form from submitting normally */
              e.preventDefault();
              var email = $('#email').val();
             
             
                $('#btn_forgot_pass').text('Sending...');
                 
                    $.ajax({
                        url:'../controller/forgot-password.php',
                        type:'POST',
                        data:{email : email},
                        success:function(result){
                            if(result!=="successfully"){
                               $('#error-msg').empty().html(result);
                            }
                            if(result==="successfully"){
                             alert('oke');
                            }
                            $('#btn_forgot_pass').text('Submit');
                            //grecaptcha.reset()
                        }
                    });
            });