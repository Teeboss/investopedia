<?php
        date_default_timezone_set("Africa/lagos");
     header('Access-Control-Allow-Origin: *');
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   	$response= array();
   	  if (isset($_POST['token'] , $_POST['password'] , $_POST['auth'])) {
   	  	if ($_POST['auth'] == 'ftuifnvftuifnvcmqioe052641234368oe05264123497133499096pwzmqioe05264123436mxmlktuifnvcmqioe052641234368oe052641234971334990lsdacmqioe052641234368oe05264123497133499096pwzmqioe05264123436mxmlktuifnvcmqioe052641234368oe052641234971334990lsda') {
   	  		include('model/DB.php');
   	  		include('model/controller.php');
   	  		api::recover_password($_POST['token'] , $_POST['password']);
   	  	}  else {
		$response['status'] = false;
		$response['message'] = "invalid token check again";
		}
   	  } else {
	    $response['status'] = false;
		$response['message'] = "check your inputs and try again";
	}
   } else {
      $response['status'] = false;
	  $response['message'] = "invalid request method ";
}
 echo json_encode($response);
?>