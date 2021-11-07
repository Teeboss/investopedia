<?php
        date_default_timezone_set("Africa/lagos");

   header('Access-Control-Allow-Origin: *');
   $response = array();
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   	 if (isset($_POST['profileuserid'] , $_POST['SOR'] , $_POST['address'] , $_POST['password'] , $_POST['auth'] , $_POST['image'])) {
   	 	include('model/DB.php');
   	 	include('model/controller.php');
   	 	 if ($_POST['auth'] == 'jfwieoweqpireruefnmxcn474iwey7u4389duei21030294r8eidiojcds489usiljkcdmfnde43302491hjgtrftyh234567hgfdhbvcfh') {
                $image = base64_decode($_POST['image']);
                $rename = "SAMTOS_KYC_IMAGE_".time().str_shuffle("guoiijierebrbbryryryry");
                $filename = $rename . '.' . 'jpg';
                $image_url = "image/".$filename;
                $info = pathinfo($image_url , PATHINFO_EXTENSION);
                move_uploaded_file( $filename, $image_url);
                $compressed = api::compress_image($image , $image_url, 70);

   	 	 	api::kyc($_POST['profileuserid'] , $_POST['SOR'] , $_POST['address'] , $_POST['password'] , $filename);

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