<?php
     date_default_timezone_set("Africa/lagos");
     header('Access-Control-Allow-Origin: *');

$response =  array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['auth'])) {
		if ($_POST['auth'] == "j734fh34ui232oi003498582nmdnmfdker4323n4") {
			include("model/DB.php");
            include("model/controller.php");
		if (api::userlogin($_POST['username'] ,  $_POST['password']) == "") {
	       api::getusername($_POST['username']);
		} else if (api::userlogin($_POST['username'] ,  $_POST['password']) == "invalid") {
			$response['status'] = false;
		    $response['body'] = "invalid password"; 
		} else if (api::userlogin($_POST['username'] ,  $_POST['password']) == "not_user") {
			$response['status'] = false;
		    $response['body'] = "user not registered";
		} else if (api::userlogin($_POST['username'] ,  $_POST['password']) == "banned") {
			$userid =  DB::query('SELECT id FROM users WHERE username = :username', array(':username'=>$_POST['username']))[0]['id'];
			$banned = DB::query('SELECT reason FROM banned_table WHERE userid = :userid', array(':userid'=>$userid))[0]['reason'];
		    $response['status'] = false;
		    $response['body'] = $banned;	

		}
	  } else {
       $response['status'] = false;
		$response['body'] = "invalid auth key";
	  }
	} else {
		$request['status'] = false;
		$request['body'] = "required field is empty"; 
	}
} else {
	$response['status'] = false;
	$response['body'] = "invalid request";
}
echo json_encode($response);



?>