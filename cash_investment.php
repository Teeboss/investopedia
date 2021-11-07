<?php
    date_default_timezone_set("Africa/lagos");

   header('Access-Control-Allow-Origin: *');
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   	$response = array();
      if (isset($_POST['amount'] , $_POST['profileuserid'] , $_POST['auth'] )) {
      	include('model/DB.php');
      	include('model/controller.php');
      	if ($_POST['auth'] == 'jfwieoweqpireruefnmxcn474iwey7u4389duei21030294r8eidiojcds489usiljkcdmfnde43302491hjgtrftyh234567hgfdhbvcfh') {
      		api::cash_investment($_POST['amount'], $_POST['profileuserid']);
      		// api::investment_calculator($_POST['profileuserid'] );
      	} else {
			$response['status'] = false;
			$response['message'] = "invalid token";
		}
      } else {
			$response['status'] = false;
			$response['message'] = "invalid entry";
		}
   } else {
			$response['status'] = false;
			$response['message'] = "invalid server request";
	}
    echo json_encode($response); 
?>