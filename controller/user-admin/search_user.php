<?php session_start();
require_once '../../modal/user.php';
    $user = new USER();

    if(!$user->is_logged_in_admin())
    {
     $user->redirect('error.html');
     exit();
    }

if (!empty($_POST['tokenAdmin'])) {
    if (hash_equals($_SESSION['userToken'], $_POST['tokenAdmin'])) {
        $key = str_replace(['+', '-'], '', filter_var($_POST['key']));
        $act = $user->search_user($key);
      
        print_r($act);
       
    } else {
       echo 'Something wrong! Please try again';
    }
}else{
	echo 'Something wrong! Please try again';
}