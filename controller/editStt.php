<?php 
session_start();
require_once "../modal/app.php";
$app = new APP();
if (!empty($_POST['tokenAdmin'])) {
    if (hash_equals($_SESSION['userToken'], $_POST['tokenAdmin'])) {
        $numberID = str_replace(['+', '-'], '', filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT));
       $act = $app->setStatusApp($numberID,$_POST['status']);
        echo 'success';
    } else {
       echo 'Something wrong! Please try again';
    }
}else{
	echo 'Something wrong! Please try again';
}