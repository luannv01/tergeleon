<?php
session_start();
require_once '../modal/user.php';
$user = new USER();

if(!$user->is_logged_in())
{
 $user->redirect('login.html');
}

if($user->is_logged_in()!="")
{
 $user->logout(); 
 $user->redirect('login.html');
}
?>