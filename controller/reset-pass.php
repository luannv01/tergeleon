<?php 
			require_once '../modal/user.php';
				$user_login = new USER();
				if(isset($_POST['email'],$_POST['token'])){
					$email = strip_tags(mysql_real_escape_string(trim($_POST['email'])));
					$token = strip_tags(mysql_real_escape_string(trim($_POST['token'])));
					
						if($user_login->check_reset_pass($email,$token)>0)
						{
							echo 's';
						}else{
							echo 'x';
						}
					
				}
	
					