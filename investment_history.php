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
			$fetch->investment_history($_POST['profileuser']);
			echo     date("Y-m-d h:i:sa");

			$response['status'] =  true;
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