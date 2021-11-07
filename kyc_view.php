<?php
        date_default_timezone_set("Africa/lagos");

     header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$response = array();
	if (isset($_POST['profileuser'] , $_POST['auth'])) {
		if ($_POST['auth'] == 'udrapoquierjhcnm37840904hceowsdmlkapoquierjhcnm37840904hcnm37843068904hceowsdml5472jf') {
			include('model/DB.php');
			include('model/controller.php');
			$fetch =  new api();
			$fetch->kyc_data($_POST['profileuser']);
		} else {
			$response['status'] = false;
			$response['message'] = "invalid token";
			   echo json_encode($response);

		}   

	}  else {
			$response['status'] = false;
			$response['message'] = "invalid entry";
			   echo json_encode($response);

		}
} else {
			$response['status'] = false;
			$response['message'] = "invalid server request";
			   echo json_encode($response);

	}




?>