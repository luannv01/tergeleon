<?php
	session_start();

	 if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
	 	 $secret = '6LcwgDEUAAAAACDc3-GXoe2qunLLJ-0DyHwcJRfG';
       // get verify response data
       $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
       $responseData = json_decode($verifyResponse);
        if($responseData->success){
        	if(empty($_POST['fullName']) || empty($_POST['password']) || empty($_POST['retypePassword']) || empty($_POST['email'])){
        		echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>Something wrong. Please try again</h5></div>';
        	}elseif($_POST['password'] !== $_POST['retypePassword']){
        		echo'<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>The password don&apos;t match!</h5></div>';
        	}elseif(!isset($_POST['confirm'])){
        		echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>Please accept our terms!</h5></div>';
        	}else{

				require_once '../../modal/user.php';
				$reg_user = new USER();
					$name=$_POST['fullName'];
				 	$uname= base64_encode($_POST['fullName']);
				 	$email =$_POST['email'];
				 	$upass=$_POST['password'];
				 	$userLevel = $_POST['userLevel'];
				 	$code = md5(uniqid(rand()));
					 $stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
					 $stmt->execute(array(":email_id"=>$email));
					 $row = $stmt->fetch(PDO::FETCH_ASSOC);

				 if($stmt->rowCount() > 0)
				 {
				  echo $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5>Email is already registered!</h5></div>
					     ';
				 }
				 else{
				 	
				 		$id = str_pad(rand(0,'9'.round(microtime(true))),11, "0", STR_PAD_LEFT); 
				 	  if($reg_user->register_admin($id,$name,$uname,$email,$upass,$userLevel))
					  {   
					  
					      
					
					   echo $msg = 'Successfully';
					  }
				 }
        		
        	}
        }else{
        	 echo $msg = " <div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Capcha not match. Please try again</div>
					     ";
       }
	 }else{
		 echo $msg = " <div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Capcha not found. Please try again</div>
					     ";
	}
        		?>
