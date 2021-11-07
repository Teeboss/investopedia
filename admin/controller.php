<?php

class api {




	public static function signup( $phone_number ) {
		$response =  array();
         $email = "your 80kobosms registered email ";
         $verification_pin =  rand(99 - 999999);
            $password = "Your password";
            $message = "Your YAWO verification pin is ".$verification_pin;
            $sender_name = "Your sender name";
            $recipients = $phone_number;
            $forcednd = "set to 1 if you want DND numbers to ";

            $data = array("email" => $email, "password" => $password,"message"=>$message,"sender_name"=>$sender_name,"recipients"=>$recipients,"forcednd"=>$forcednd);
            $data_string = $data;
            $ch = curl_init('https://api.80kobosms.com/v2/app/sms');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
               // 'Content-Type: application/json',
            	'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
                'Content-Length: ' . strlen($data_string))
            );
            $result = curl_exec($ch);
            $res_array = json_decode($result);
            DB::query('INSERT INTO users VALUES (\'\' , :phone_number , :verification_pin)' , array(':phone_number' => $phone_number , ':verification_pin'=>$verification_pin));
           // print_r($res_array);
	}




			  public static function confirm_number ($pin ) {

             $phone_number = DB::query('SELECT phone_number FROM users WHERE verification_pin = :pin' , array(':pin' => $pin))[0]['phone_number'];

             if (DB::query('SELECT phone_number FROM users WHERE verification_pin = :pin' , array(':pin' => $pin))) {
             	DB::query('UPDATE users SET status = "verified" WHERE phone_number = :phone_number' , array(':phone_number' => $phone_number));
               $response = array('status' => true , 'message' => 'phone number verified you are welcome to loan app ');
               echo json_encode($response);
             }
              $response = array('status' => false , 'message' => 'this pin is not registered with this user ');
               echo json_encode($response);

             }


      
        public static function request_loan ( $userid , $first_name , $last_name, $phone_number, $email, $gender, $DOB, $marital_status, $HA, $SOT, $city, $profession_status, $professional_category, $professional_subcategory, $employer_name, $started_work, $pay_day, $salary, $g_name, $g_relationship, $g_phone_number, $loan_amount, $loan_purpose, $loan_use = "null") {

             DB::query('INSERT INTO loan VALUES (\'\' , :userid , :first_name , :last_name , :phone_number , :email , :gender , :DOB , :marital_status , :HA , :SOT , :city , :profession_status , :professional_category , :professional_subcategory , :employer_name , :started_work , :pay_day , :salary , :g_name , :g_relationship , :g_phone_number , :loan_amount , :loan_purpose , :loan_use )' , array(':userid'=>$userid , ':first_name'=>$first_name, ':last_name'=>$last_name, ':phone_number'=>$phone_number, ':email'=>$email, ':gender'=>$gender, ':DOB'=>$DOB, ':marital_status'=>$marital_status, ':HA'=>$HA, ':SOT'=>$SOT, ':city'=>$city, ':profession_status'=>$profession_status, ':professional_category'=>$professional_category, ':professional_subcategory'=>$professional_subcategory ));

            }

         

}



?>