<?php
        date_default_timezone_set("Africa/lagos");

   header('Access-Control-Allow-Origin: *');
   $response = array();
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   	 if (isset($_POST['profileuserid'] , $_POST['withdrawal_value'] , $_POST['bitcoin_wallet_id'] , $_POST['auth'])) {
   	 	include('model/DB.php');
   	 	include('model/controller.php');
   	 	 if ($_POST['auth'] == 'jfwieoweqpireruefnmxcn474iwey7u4389duei21030294r8eidiojcds489usiljkcdmfnde43302491hjgtrftyh234567hgfdhbvcfh') {
          $get_roi = DB::query('SELECT SUM(ROI) FROM investment WHERE userid = :userid', array(':userid'=>$_POST['profileuserid']));
             foreach ($get_roi as $get_ro) {
            $response['total_roi'] = $get_ro['SUM(ROI)'];
            }
           $calculation = DB::query('SELECT SUM(ROI) , userid FROM investment WHERE userid = :userid' , array(':userid'=>$_POST['profileuserid'])); 
          foreach ( $calculation as $cal ) {
            if (count(DB::query('SELECT * FROM withdrawal WHERE userid = :userid', array(':userid'=>$cal['userid']))) == 0) {
              $init_cal = $cal['SUM(ROI)'];
            } else {
              $init_cal = DB::query('SELECT new_roi FROM withdrawal WHERE userid = :userid' , array(':userid'=>$cal['userid']))[0]['new_roi'];
            }
             if ($init_cal > $_POST['withdrawal_value']) {
              $final_cal = $init_cal - $_POST['withdrawal_value'];
              api::withdrawal($_POST['profileuserid'] , $_POST['withdrawal_value'] , $_POST['bitcoin_wallet_id'] , $final_cal );
              $response['status'] = true;
              $response['message'] = "your withdrawal has been sent wait for funds";
              } else {
             $response['status'] = false;
             $response['message'] = "insert a value lesser than your return on investment"; 
            }
          } 
       
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