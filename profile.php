<?php
     date_default_timezone_set("Africa/lagos");

     header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$response = array();
	if (isset($_POST['profileuser'] , $_POST['auth'])) {
		if ($_POST['auth'] == 'udrapoquierjhcnm37840904hceowsdmlkapoquierjhcnm37840904hcnm37843068904hceowsdml5472jf') {
			include('model/DB.php');
			include('model/controller.php');
			$response['status'] = true;
		$response['profile_photo'] = "image/".DB::query('SELECT profileimg FROM users WHERE id = :userid', array(':userid'=>$_POST['profileuser']))[0]['profileimg'];
			if (DB::query('SELECT invested FROM users WHERE id = :userid', array(':userid'=>$_POST['profileuser'])) == "no") {
				$response['investment'] = "no";
			} else {
				$response['investment'] = DB::query('SELECT amount FROM investment WHERE userid = :userid', array(':userid'=>$_POST['profileuser']))[0]['amount'];
			}
			$response['first_name'] = DB::query('SELECT first_name FROM users WHERE id = :userid', array(':userid'=>$_POST['profileuser']))[0]['first_name'];
			$response['last_name'] = DB::query('SELECT last_name FROM users WHERE id = :userid', array(':userid'=>$_POST['profileuser']))[0]['last_name'];
			$response['user_name'] = DB::query('SELECT username FROM users WHERE id = :userid', array(':userid'=>$_POST['profileuser']))[0]['username'];
			$response['email'] = DB::query('SELECT email FROM users WHERE id = :userid', array(':userid'=>$_POST['profileuser']))[0]['email'];
			$response['phone_number'] = DB::query('SELECT phone FROM users WHERE id = :userid', array(':userid'=>$_POST['profileuser']))[0]['phone'];
			$select = DB::query('SELECT * FROM investment WHERE userid = :userid', array(':userid'=>$_POST['profileuser']));
			   api::time_ago($select[0]['investment_date'] , $select[0]['userid']); 
			    
		} else {
			$response['status'] = false;
			$response['message'] = "invalid token";
		}

     

	}  else {
			$response['status'] = false;
			$response['message'] = "invalid entry";
		}
} else {
			$response['status'] = false;
			$response['message'] = "invalid server request";
	}


   echo json_encode($response);


?>