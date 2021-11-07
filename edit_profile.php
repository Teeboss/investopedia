<?php
     header('Access-Control-Allow-Origin: *');
     date_default_timezone_set("Africa/lagos");
     
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  	$response = array();
  	 if (isset($_POST['edit_profileimg'] , $_POST['phone']  , $_POST['auth'])) {
  	 	include('model/DB.php');
  	 	include('model/controller.php');
	   $userid = $_POST['uploaderid'];
	   if ($_POST['auth'] == 'ftuifnvftuifnvcmqioe052641234368oe05264123497133499096pwzmqioe05264123436mxmlktuifnvcmqioe052641234368oe052641234971334990lsdacmqioe052641pwzmqioe05264123436mxmcmqioe052641234368oe05264123497133499096pwzmqlktuifnvcmqioe052641234368oe052641234971334990lsda' ) {
            $image = base64_decode($_POST['edit_profileimg']);
			$rename = "SAMTOS_IMAGE_".time().str_shuffle("guoiijierebrbbryryryry");
			$filename = $rename . '.' . 'jpg';
		    $image_url = "image/".$filename;
		    $info = pathinfo($image_url , PATHINFO_EXTENSION);
		    move_uploaded_file( $filename, $image_url);
			$compressed = api::compress_image($image , $image_url, 70);
			api::edit_profile_with_phone($filename , $userid , $_POST['phone']);
			$response['status'] = true;
			$response['body'] = " profile updated successfully ";
	   	 }   else {
		$response['status'] = false;
		$response['message'] = "invalid token check again";
		}
  	 } else  {
	    $response['status'] = false;
		$response['message'] = "check your inputs and try again";
	}
  }else {
      $response['status'] = false;
	  $response['message'] = "invalid request method ";
}
 echo json_encode($response);


?>