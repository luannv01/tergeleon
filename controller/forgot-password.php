<?php 
			require_once '../modal/user.php';
				$reg_user = new USER();

				 	$email =$_POST['email'];
				 	$code = md5(uniqid(rand()));
					$stmt = $reg_user->runQuery("SELECT userID,userFullName FROM tbl_users WHERE userEmail=:email_id");
					$stmt->execute(array(":email_id"=>$email));
					$row = $stmt->fetch(PDO::FETCH_ASSOC);

				 if($stmt->rowCount() > 0)
				 {
				  $id = str_pad(rand(0,'9'.round(microtime(true))),11, "0", STR_PAD_LEFT); 
				 	    
					  
					   $key = base64_encode($id);
					   $name =$row['userFullName'];
					   $userID=$row['userID'];
					  
					   $message = "<p>Hi $name, </p>
							<p>We received a request to reset password for your account:</p>
							$email. We are here to help!.
							<p>Simply click on the button to set a new password</p>
							<a href='http://localhost/net/public/reset-pass.html?token=$key&&email=$email' style=' background-color: #4CAF50;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;'>Change password</a>
							<p>If you did not ask to change your password, do not worry!. Your password is still safe and you can delete this email</p>
							<p>Cheers</p>
							";
					      
					   $subject = "Reset your password";
					      
					  $reg_user->send_mail($email,$message,$subject); 
					  $reg_user->update_token_reset_pwd($userID,$key); 
					   echo $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>We&apos;ve sent an email to '.$email.'
					                    Please click on the confirmation link in the email to reset your password!</h5></div>';
					
				 }
				 else{
				 	 echo $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>Sorry! Email is not exist!</h5></div>
					     ';
					}