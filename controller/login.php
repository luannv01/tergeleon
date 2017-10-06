<?php
session_start();
require_once '../modal/user.php';
$user_login = new USER();
if(isset($_POST['checkLog'])){
	if($_POST['checkLog']==="OK"){
		if($user_login->is_logged_in()!="")
		{
		 echo'already';
		}
	}
}


if(isset($_POST['email'],$_POST['password']))
{
 $email = trim($_POST['email']);
 $upass = trim($_POST['password']);
 if($user_login->is_logged_in()!="")
		{
		 location("www.google.com");
		 exit();
		}
 if($user_login->login($email,$upass))
 { echo "successfully";
 }else{
  $a = $user_login->login($email,$upass);
  echo ($a);
 }
}
?>