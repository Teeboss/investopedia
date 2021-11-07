<?php
   
   date_default_timezone_set("Africa/lagos");
 
   header('Access-Control-Allow-Origin: *');
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   	$response = array();
    if (isset($_POST['bitcoin_deposited'] , $_POST['profileuserid'] , $_POST['bitcoin_wallet_id'] , $_POST['deposit_description'] , $_POST['auth'] , $_POST['deposit_type'])) {
      	include('model/DB.php');
      	include('model/controller.php');
      	if ($_POST['auth'] == 'jfwieoweqpireruefnmxcn474iwey7u4389duei21030294r8eidiojcds489usiljkcdmfnde43302491hjgtrftyh234567hgfdhbvcfh') {
      		api::deposit($_POST['profileuserid'] , $_POST['bitcoin_deposited'] , $_POST['bitcoin_wallet_id'] , $_POST['deposit_description'] , $_POST['deposit_type']);
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