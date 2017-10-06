<?php if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
	 	$secret = '6LcwgDEUAAAAACDc3-GXoe2qunLLJ-0DyHwcJRfG';
       // get verify response data
       $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
       $responseData = json_decode($verifyResponse);
		        if($responseData->success){
						if(isset($_POST['password'],$_POST['id'],$_POST['retypePassword'])){
							if($_POST['password']===$_POST['retypePassword']){
								require_once '../modal/user.php';
								$user = new USER();
								$cpass = md5($_POST['retypePassword']);
								$key = base64_encode($cpass);
							    $stmt = $user->runQuery("UPDATE tbl_users SET userPass=:upass WHERE userEmail=:userEmail");
							    $stmt->execute(array(":upass"=>$cpass,":userEmail"=>$_POST['id']));
							    $stmt1 = $user->runQuery("UPDATE tbl_users SET userName=:userName WHERE userEmail=:userEmail");
							    $stmt1->execute(array(":userName"=>$key,":userEmail"=>$_POST['id'])); 
							    
							    echo '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>Password changed! <a href="login.html">Login here</a></h5></div>';
							}else{
								echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>The password doesn&#39;t match. Please try again</h5></div>';
							}
						}else{
							echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>Something wrong. Please try again</h5></div>';
						}

		        }else{
		        	echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>Something wrong. Please try again</h5></div>';
		        }
    }else{
    	echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>Please checked the Captcha.</h5></div>';
    }