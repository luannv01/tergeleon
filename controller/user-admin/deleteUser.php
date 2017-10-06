<?php 
session_start();
require_once '../../modal/user.php';
    $user = new USER();

    if(!$user->is_logged_in_admin())
    {
     $user->redirect('error.html');
     exit();
    }

if (!empty($_POST['tokenAdmin'])) {
    if (hash_equals($_SESSION['userToken'], $_POST['tokenAdmin'])) {
        $numberID = str_replace(['+', '-'], '', filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
       $act = $user->deleteUser($numberID);
        echo 'success';
    } else {
       echo 'Something wrong! Please try again';
    }
}else{
	echo 'Something wrong! Please try again';
}