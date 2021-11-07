<?php

date_default_timezone_set("Africa/lagos");
header('Access-Control-Allow-Origin: *');



$response =  array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include("model/DB.php");
    include("model/controller.php");
     if (
     isset($_POST['auth']) &&
     isset($_POST['fname']) &&
     isset($_POST['lname']) &&
     isset($_POST['uname']) &&
     isset($_POST['password']) &&
     isset($_POST['phone']) &&
     isset($_POST['email'])
     ) {
       if ($_POST['auth'] == "rfhhhdfjhfddfvnmopwwpfivn26485j5894489jh8974j33934kfjhkfdhkf8303") {
        
       
            api::createUser(
            $_POST['fname'] ,
            $_POST['lname'] ,
            $_POST['uname'] ,
            $_POST['password'] ,
            $_POST['email'],
            $_POST['phone']
             );   
        } else {
          $response['status'] = false;
         $response['message'] = "invalid auth request";   
        }



       } else {
    $response['status'] = false;
    $response['message'] = "check for empty input field";
}
    
} else {
    $response['status'] = false;
    $response['message'] = "invalid request";
}
echo json_encode($response);


?>