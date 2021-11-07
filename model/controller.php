<?php 

  date_default_timezone_set("Africa/lagos");

  class api 

  {
  	    public static function createUser ($fname, $lname, $uname , $password, $email , $phone) {
              $response = array();
          if (!DB::query('SELECT username FROM users WHERE username=:uname', array(':uname'=>$uname))) {
            if (!DB::query('SELECT email FROM users WHERE email=:email', array(':email'=>$email))) {
              if (strlen($password) >= 6 && strlen($password) <=60 ) {
                if (filter_var($email , FILTER_VALIDATE_EMAIL)) {
                    $request =  DB::query('INSERT INTO users VALUES (\'\',  :first_name, :last_name,  :username , :email , :phone  , :password , \'\' , NOW() , \'no\' ,\'unverified\' )', array(':first_name'=>$fname, ':last_name'=>$lname, ':username'=>$uname, ':password'=>password_hash($password, PASSWORD_BCRYPT), ':phone' => $phone , ':email'=>$email));
                     self::getusername($uname);
                      $terget = "support@samtos4realtech.com";
                      $subject =  "
                      SAMTOS INVESTMENT: Welcome to Samtos Global Company LTD ".$fname. "
                         ";
                      $message = "
                     <html>
                     <head>
                     <title><b> SAMTOS FORGOT PASSWORD</b></title>
                     </head>
                     <body>
                     <p style='font-weight: 100; font-size: 15px; color : #404040; font-style : normal; line-height: 1.6;'> 

                     Dear ". $uname . ", <br><br><br> Welcome to Samtos Global Company Investment. You have successfully registered as a user. 
                          <br><br>
                         Samtos Global Company LTD is a Fund/Portfolio manager that deploys her resources into Forex, Binary and Commodity trading in a multi-trillion dollar forex market. In recent times, we have started diversifying our business portfolio into Agriculture, Agro-Allied and Real Estate sectors of the Nigerian economy.
                           <br><br>
                        There is <b><b>No Risk</b></b>  in investing your capital with us, as we use the best strategy and money management system to navigate though these markets. All Funds are personally guaranteed by our CEO.
                        <br><br>
                        Samtos Global Company handles the administrative process and contracts with all investors.
                        <br><br>
                        This is how it works ðŸ‘‡
                        <br><br>
                        We currently operate two categories of investments.
                        <br><br>
                       <b><b>Professional Plan: Minimum deposit is #50,000 and you get 15% biweekly and Business Plan, with a minimum deposit of #50,000 and you get 40% ROI monthly. You cash out your Returns on Investment ROI every two weeks/ month(depending on your plan) through the website by following simple procedures and filling accurately your bank details and credits alerts are made by the Management within *24hours of withdrawal</b></b>
                           <br><br>
                        you will get your capital back at the end of the 6 months contract or renew the investment for the Professional plan or Business Plan.
                         <br><br>
                        Samtos Global Company LTD will deliver the commensurate percentage of your capital to your bank account whenever it is due.
                         <br><br>
                        HOW TO INVEST
                         <br><br>
                        1. Sign up on www.samtosglobal.com and register. 
                        2. Subscribe for the plan you desires. 
                        3. Make payment deposits to the bank details below;
                        <br><br>
                       <b> 0022073036 
                        Sterling Bank 
                        Bamo Wonderland Venture</b>
                     C. We also receive investment in the form of cryptocurrency Bitcoin. The BTC wallet address is<br> 
                    <b>343cNdTUfoa5vfgxEYgYm7gHV2sNMuzz8W </b>
                    <br><br>
                    4.Screenshot/ snap the payment receipt or debit alert and send to samtosglobal@gmail.com  then after your payment has been confirmed you can  proceed to <b> make an(new) investment </b> on your dashboard.
                    5. Check the box at the bottom and press <b>pay via main balance.</b>
                    <br><br>
                    Investor Funds are 100% personally guaranteed by our CEO. We employ the best Management, risk:reward ratio to secure and preserve our funds. We ensure we make profit daily!
                    <br><br>
                   <b> INVESTMENT HIGHLIGHTS </b>
                    <br><br>
                    1. <b>RETURN OF CAPITAL</b>: All capital at the end of the 6Months contracts shall be made available to all our investors.
                    <br><br>
                    2. <b>THIRD PARTY PAYMENT</b>: Third party payments will not be allowed. For example, If Mr Baba wants to invest with samtosglobal.com the deposit/transfer should be made by Mr Baba not by another person.
                    <br><br>
                    Again, Mr Baba nominated account to receive his ROI should be in the name of Mr Baba, not someone else's account. In the case of investment for minors(children below the age of 18 or who do not have bank accounts), parent will write us a mail at samtosglobal@gmail.com to accept nominated account in the name of the parent.
                     
                     <br><br>If you have any question or  require help, please contact the Customercare using the Contact Us form on the website or Open a Support Ticket on your dashboard (recommended), or send an email to admin@samtosglobal.com.\n\nThanks , best regards \n\n\nTeam SGCL\nwww.samtosglobal.com\n
                      <br><br>
                      <b>&copy;</b> 2020 Samtos Global Company

                   </p>
                   </body>
                   </html>
             ";
               $header = "MIME-Version: 1.0\r\n";
               $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
               $header .= "FROM:". $terget;
               mail($email, $subject, $message , $header);
                } else {
                $response['status'] = false;
                $response['body'] = "invalid email";
                }
              } else {
                $response['status'] = false;
                $response['body'] = "password is too long or short";
              }
              } 
              else {
                $response['status']= false;
                $response['body'] = "email already registered";
              }
           }
            else {
                      $response['status']= false;
                $response['body'] = "username name is taken";
          }
          echo json_encode($response);
        }






		    public static function userlogin($username , $pass) {
		                $val =  "invalid";
		                 $not = "not_user";
                     $ban = "banned";
			  if (DB::query('SELECT username FROM users WHERE username = :username',array(':username'=>$username))) {
			     if (password_verify($pass, DB::query('SELECT password FROM users WHERE username = :username', array(':username'=>$username))[0]['password'])) {
             if (DB::query('SELECT status FROM users WHERE username = :username AND (status = "verified" OR status="unverified")',array(':username'=>$username))) {
                   $request =  DB::query('SELECT id FROM users WHERE username = :username AND password = :pass' , array(':username'=> $username , ':pass'=>$pass));
                } else {
                return $ban;
                }
					    } else {
					      return $val;
					    }
					} else {
					   return $not;
			    }
		    }






		 public static function getusername($username) {
		    $response = array();
		 $request =  DB::query('SELECT id, username , first_name, last_name, email , password , profileimg , phone FROM users WHERE username = :username' , array(':username'=> $username)); 
		      $response['status'] = true;
		      $response['id'] = $request[0]['id']; 
		      $response['username'] = $request[0]['username']; 
		      $response['firstname'] = $request[0]['first_name']; 
		      $response['phone'] = $request[0]['phone'];
		      if ($request[0]['profileimg']) {
		      $response['profileimg'] = "https://samtos4realtech.com/api/image/".$request[0]['profileimg'];
		      } else {
		      	$response['profileimg'] = "";
		      }
		      $response['lastname'] = $request[0]['last_name']; 
		      $response['email'] = $request[0]['email']; 
		      $response['password'] = $request[0]['password']; 
		       
		    echo json_encode($response);
		  }

        


        

   public $response_oop = array();




   public function return_response() {
       echo json_encode($this->response_oop);
   }
   


   public static function withdrawal ($userid , $withdrawal_value , $bitcoin_wallet_id , $new_roi) {
     $response = array();
   	$dates = date("Y-m-d/h:i:sa");
  if (!DB::query('SELECT userid FROM investment WHERE userid = :userid', array(':userid'=>$userid))) {
          $response['status'] =  false;
          $response['message'] =  "you do not have an investment yet try to invest and try again , thanks";
          echo json_encode($response);
 
  } else {
     if (count(DB::query('SELECT * FROM withdrawal WHERE userid = :userid', array(':userid'=>$userid))) == 0) {
             
      DB::query('INSERT INTO withdrawal VALUES( \'\' , :userid , :withdrawal_value, :bitcoin_wallet_id , :new_roi , :dates , \'pending\')' , array(':userid'=>$userid , ':withdrawal_value'=>$withdrawal_value , ':bitcoin_wallet_id'=>$bitcoin_wallet_id , ':new_roi'=>$new_roi ,':dates'=>$dates));
   } else {
    $newest_roi = DB::query('SELECT new_roi FROM withdrawal WHERE userid = :userid' , array(':userid'=>$userid))[0]['new_roi'];
    DB::query('UPDATE withdrawal SET new_roi = :newest_roi - :withdrawal_value , withdrawal_value = :withdrawal_value WHERE userid = :userid' , array(':newest_roi'=>$newest_roi , ':withdrawal_value'=>$withdrawal_value , ':userid'=>$userid));
     }
    $newest_roi = DB::query('SELECT new_roi FROM withdrawal WHERE userid = :userid' , array(':userid'=>$userid))[0]['new_roi'];
    DB::query('INSERT INTO withdrawal_history VALUES(\'\' , :userid , :withdrawal_value ,:bitcoin_wallet_id , :newest_roi ,:dates , \'pending\')', array(':userid'=>$userid , ':withdrawal_value'=>$withdrawal_value , ':bitcoin_wallet_id'=>$bitcoin_wallet_id , ':newest_roi'=>$newest_roi, ':dates'=>$dates));
  }
   }





/*
   public static function withdrawal_update ($investmentId , $userid) {

      
      $investments =  DB::query('SELECT * FROM investsment_history WHERE userid = :userid AND id = :investmentid' , array(':userid'=>$userid , ':investmentid'=>$investmentId));
   
       foreach ($investments as $investment) {
        $this->$response_oop = array('bitcoin_deposited' => $requests['amount'] , 'date_deposited' => $requests['investment_date'] , 'bitcoin_status' => $requests['status'] );
      }
     
       $this->return_response();

     }


public static function withdrawal_updated ($investmentId , $userid) {

         $dates = date("Y-m-d/h:i:sa");

     if (DB::query('SELECT * FROM investsment_history WHERE userid = :userid AND id = :investmentid AND status = active' , array(':userid'=>$userid , ':investmentid'=>$investmentId))) {
         DB::query('INSERT INTO withdrawal_history VALUES(\'\' , :userid , :investmentId , \'\' , \'\' ,:dates , \'pending\')', array(':userid'=>$userid , ':investmentId'=>$investmentId , ':dates'=>$dates));
         $this->response_oop['status'] = true;
         $this->response_oop['message'] = "your withdrawal for this investment has been sent successfully wait for approval";
     } 
    $this->return_response();
     }

*/






			public static function investment($amount , $userid ) {
        	$dates = date("Y-m-d h:i:sa");
		   //  $value_per_bitcoin = DB::query('SELECT value_per_bitcoin FROM investment ', array())[0]['value_per_bitcoin'];
		    // $bitcoin_val = $amount / $value_per_bitcoin;
		    $ROI = 60/100 * $amount;
		   /* if ($investment_type == "weekly") {
		    	$investment_return_days = 7 ;
		    } else if ($investment_type == "bi_weekly") {
		    	$investment_return_days =  14 ;
		    } else {
		    	$investment_return_days =  30 ;
		    } */
		    $sum = DB::query('SELECT SUM(bitcoin_deposited) FROM deposit WHERE userid = :userid and status = "confirmed" AND deposit_type = "bitcoin"' , array(':userid'=>$userid));
        if (count(DB::query('SELECT userid FROM investment WHERE userid = :userid' , array(':userid'=>$userid))) == 0) {
         foreach ($sum as $su) { $balanced = $su['SUM(bitcoin_deposited)']; }
        } else {
        $balanced = DB::query('SELECT available_balance FROM investment WHERE userid = :userid' , array(':userid'=>$userid))[0]['available_balance'];
         }
             foreach ($sum as $su) {
		      if ($balanced > $amount) {
		      	   if (count(DB::query('SELECT userid FROM investment WHERE userid = :userid' , array(':userid'=>$userid))) == 0) {
                $available_balance = $su['SUM(bitcoin_deposited)'] - $amount ; 
		            DB::query('INSERT INTO investment VALUES (\'\' , :amount , \'\' , :dates , :userid , \'\' , \'\' , :ROI , \'\' , \'\', \'active\' , :available_balance)' , array(':amount'=>$amount , ':userid'=>$userid  ,':ROI'=>$ROI , ':available_balance'=>$available_balance , ':dates'=>$dates));
				    DB::query('UPDATE users SET invested = \'yes\' WHERE id = :userid', array(':userid'=>$userid));
				    $response['status'] = true;
				    $response['message'] = "bitcoin invested successfully";

             } else {
             	    $newest_available_balance = DB::query('SELECT available_balance FROM investment WHERE userid = :userid' , array(':userid'=>$userid))[0]['available_balance'];
             	DB::query('UPDATE investment SET available_balance = :newest_available_balance - :amount  WHERE userid = :userid' , array(':newest_available_balance'=>$newest_available_balance , ':userid'=>$userid , ':amount' => $amount));
                  $balance = DB::query('SELECT available_balance FROM investment WHERE userid = :userid' , array(':userid'=>$userid))[0]['available_balance'];
            $response['available_balance'] = $balance;
               $response['status'] = true;
              $response['message'] = "bitcoin invested successfully";
             }
            $newest_available_balance = DB::query('SELECT available_balance FROM investment WHERE userid = :userid' , array(':userid'=>$userid))[0]['available_balance'];            
		    DB::query('INSERT INTO investment_history VALUES (\'\' , :amount , \'\' , :dates , :userid , \'\' , \'\' , :ROI , \'bitcoin\' , \'\', \'active\' , :available_balance )' , array(':amount'=>$amount , ':userid'=>$userid ,':ROI'=>$ROI  , ':available_balance'=>$newest_available_balance , ':dates'=>$dates));
		    $response['status'] = true;
		    $response['message'] = "bitcoin invested successfully";
		      } else {
		      	$response['status'] = false;
		      	$response['message'] = "your investment is more than your amount depositted  !!";
		      }
            }
              echo json_encode($response);
          
		}








      public static function cash_investment($amount , $userid ) {
          $dates = date("Y-m-d h:i:sa");
       //  $value_per_bitcoin = DB::query('SELECT value_per_bitcoin FROM investment ', array())[0]['value_per_bitcoin'];
        // $bitcoin_val = $amount / $value_per_bitcoin;
        $ROI = 40/100 * $amount;
       /* if ($investment_type == "weekly") {
          $investment_return_days = 7 ;
        } else if ($investment_type == "bi_weekly") {
          $investment_return_days =  14 ;
        } else {
          $investment_return_days =  30 ;
        } */
          $charge_val = 50000;
           if ($amount < $charge_val ) {
            $response['status'] = false;
            $response['message'] = "minimum investment for Business plan is 50k";
           } else {
        $sum = DB::query('SELECT SUM(bitcoin_deposited) FROM deposit WHERE userid = :userid and status = "confirmed" AND deposit_type = "naira"' , array(':userid'=>$userid));
        if (count(DB::query('SELECT userid FROM cash_investment WHERE userid = :userid' , array(':userid'=>$userid))) == 0) {
         foreach ($sum as $su) { $balanced = $su['SUM(bitcoin_deposited)']; }
        } else {
        $balanced = DB::query('SELECT available_balance FROM cash_investment WHERE userid = :userid' , array(':userid'=>$userid))[0]['available_balance'];
         }
             foreach ($sum as $su) {
          if ($balanced > $amount) {
               if (count(DB::query('SELECT userid FROM cash_investment WHERE userid = :userid' , array(':userid'=>$userid))) == 0) {
                $available_balance = $su['SUM(bitcoin_deposited)'] - $amount ; 
                DB::query('INSERT INTO cash_investment VALUES (\'\' , :amount , \'\' , :dates , :userid , \'\' , \'\' , :ROI , \'\' , \'\', \'active\' , :available_balance)' , array(':amount'=>$amount , ':userid'=>$userid  ,':ROI'=>$ROI , ':available_balance'=>$available_balance , ':dates'=>$dates));
            DB::query('UPDATE users SET invested = \'yes\' WHERE id = :userid', array(':userid'=>$userid));
            $response['status'] = true;
            $response['message'] = "money invested successfully";

             } else {
                  $newest_available_balance = DB::query('SELECT available_balance FROM cash_investment WHERE userid = :userid' , array(':userid'=>$userid))[0]['available_balance'];
              DB::query('UPDATE cash_investment SET available_balance = :newest_available_balance - :amount  WHERE userid = :userid' , array(':newest_available_balance'=>$newest_available_balance , ':userid'=>$userid , ':amount' => $amount));
                  $balance = DB::query('SELECT available_balance FROM cash_investment WHERE userid = :userid' , array(':userid'=>$userid))[0]['available_balance'];
            $response['available_balance'] = $balance;
               $response['status'] = true;
              $response['message'] = "money invested successfully";
             }
            $newest_available_balance = DB::query('SELECT available_balance FROM cash_investment WHERE userid = :userid' , array(':userid'=>$userid))[0]['available_balance'];            
        DB::query('INSERT INTO investment_history VALUES (\'\' , :amount , \'\' , :dates , :userid , \'\' , \'\' , :ROI , \'naira\' , \'\', \'active\' , :available_balance)' , array(':amount'=>$amount , ':userid'=>$userid ,':ROI'=>$ROI  , ':available_balance'=>$newest_available_balance , ':dates'=>$dates));
        $response['status'] = true;
        $response['message'] = "money invested successfully";
          } else {
            $response['status'] = false;
            $response['message'] = "your investment is more than your amount depositted  !!";
          }
        }
      }
              echo json_encode($response);
          
    }









     public static function deposit ($userid , $bitcoin_deposited , $bitcoin_wallet_id  , $deposit_description , $deposit_type) {

           $url = "https://bitpay.com/api/rates";
             $json = json_decode(file_get_contents($url));
             $dollar = $btc = 0;
             foreach($json as $obj){

             if ($obj->code == 'USD') {
               $btc = $obj->rate;
             }

             }

        $response = array();
            $bitpay_val = $btc;
            $charge_val = 1500 / $bitpay_val;
            $response['charge_val_message'] = "this is the btc equivalent of $1500";
            $response['charge_val'] = $charge_val;
           if ($bitcoin_deposited < $charge_val ) {
            $response['status'] = false;
            $response['message'] = "please input a value that is up to 1500 dollars thanks and check if your deposit is enough";
           } else {
                    
           
           $response = array();
           DB::query('INSERT INTO deposit VALUES(\'\' , :userid, :bitcoin_deposited , :bitcoin_wallet_id , TRIM(\'pending\') , :deposit_description , NOW() , :deposit_type)' , array(':userid'=>$userid , ':bitcoin_deposited'=>$bitcoin_deposited , ':bitcoin_wallet_id'=>$bitcoin_wallet_id, ':deposit_description'=>$deposit_description , ':deposit_type'=>$deposit_type));
           $response['status'] = true;
           $response['message'] = "details submitted wait for your comfirmation";
       }
   echo json_encode($response);
     }



   public static function deposit_history ($userid) {
   	  $response = array();
      $request =  DB::query('SELECT * FROM deposit WHERE userid = :loggedinUserid ORDER BY id DESC', array(':loggedinUserid'=>$userid));
      	foreach ($request as $requests) {
     $response[] = array('bitcoin_deposited' => $requests['bitcoin_deposited'] , 'date_deposited' => $requests['date'] , 'bitcoin_status' => $requests['status'] , 'type' =>$request['deposit_type'] , 'ROI' => "" );
	
      	}
  	      echo json_encode($response);
   }






     public static function investment_history($userid) {
   	  $response = array();
      $request =  DB::query('SELECT * FROM investment_history WHERE userid = :loggedinUserid  ORDER BY id DESC', array(':loggedinUserid'=>$userid));
      $res  =  "naira";
      	foreach ($request as $requests) {
     $response[] = array('bitcoin_deposited' => $requests['amount'] , 'date_deposited' => $requests['investment_date'] , 'bitcoin_status' => $requests['status'] , 'type' => $requests['investment_type'] , 'ROI' => self::roi_calculator($requests['investment_date'] , $userid) );
	
      	}
  	      echo json_encode($response);
   }




     public static function withdrawal_history($userid) {
   	  $response = array();
      $request =  DB::query('SELECT * FROM withdrawal_history WHERE userid = :loggedinUserid  ORDER BY id DESC', array(':loggedinUserid'=>$userid));
      	foreach ($request as $requests) {
     $response[] = array('bitcoin_deposited' => $requests['withdrawal_value'] , 'date_deposited' => $requests['withdrawal_date'] , 'bitcoin_status' => $requests['status'] , 'type' => "" , 'ROI' => "" );
	
      	}
  	      echo json_encode($response);
   }



     public static function kyc_data($userid) {
   	  $response = array();
      $request =  DB::query('SELECT * FROM kyc WHERE userid = :loggedinUserid  ORDER BY id DESC', array(':loggedinUserid'=>$userid));
     $response['SOR'] = $request[0]['SOR'];
     $response['address'] = $request[0]['address'];
     $response['image'] =  "/image/".$request[0]['image'];
	
  	      echo json_encode($response);
   }










  /* public static function dashboard ($userid) {

   	$query = DB::query('SELECT SUM(investment.amount) , SUM(investment.ROI), SUM(investment.bitcoin_val) , SUM(deposit.bitcoin_deposited) FROM investment , deposit WHERE deposit.userid = :userid' , array(':userid'=>$userid));

      $response =  array();
   	 foreach ($query as $que) {
   	  if ($que['SUM(investment.amount)'] == "") {
     // $response['TAI'] = 0;
   	  $response['TBD'] =  0;
      $response['ROI'] = 0;
      $response['btc_val'] = 0;
   	  } else {
    //  $response['TAI'] = $que['SUM(amount)']; 	
   	  $response['TBD'] =  $que['SUM(deposit.bitcoin_deposited)'];
      $response['ROI'] = round($que['SUM(investment.ROI)']);
      $response['btc_val'] = $que['SUM(investment.bitcoin_val)'];
   	  }
       
   	 }
   	 $response['username'] = DB::query('SELECT username FROM users WHERE id = :userid' , array(':userid'=>$userid))[0]['username'];
    echo json_encode($response);
   }
*/


public static function confirm_deposit ($deposit_id , $userid) {

 
$value_to_add = DB::query('SELECT bitcoin_deposited FROM deposit WHERE userid = :userid AND id = :deposit_id' , array(':userid'=>$userid , ':deposit_id'=>$deposit_id))[0]['bitcoin_deposited'];
if (count(DB::query('SELECT userid FROM investment WHERE userid = :userid ' , array(':userid'=>$userid))) == 0) {
DB::query('UPDATE deposit SET status = "confirmed" WHERE userid=:userid AND id= :deposit_id' , array(':userid'=>$userid , ':deposit_id'=>$deposit_id));  
} else {
 DB::query('UPDATE deposit SET status = TRIM("confirmed") WHERE userid=:userid AND id= :deposit_id' , array(':userid'=>$userid , ':deposit_id'=>$deposit_id));
DB::query('UPDATE investment SET available_balance = available_balance + :value_to_add WHERE userid=:userid ' , array(':userid'=>$userid , ':value_to_add'=>$value_to_add));
 
}


}

  

public static function dashboard ($userid) {
      $response =  array();
    $query = DB::query('SELECT SUM(ROI) FROM investment_history WHERE userid = :userid AND status = "active" AND investment_type = "bitcoin"' , array(':userid'=>$userid));
    foreach ($query as $que) {
      if ($que['SUM(ROI)'] == "" || $que['SUM(ROI)'] == 0) {
      $response['ROI'] = 0; 
      } else {
    $response['ROI'] = $que['SUM(ROI)'];
     }
    }
     $query_naira = DB::query('SELECT SUM(ROI) FROM investment_history WHERE userid = :userid AND status = "active" AND investment_type = "naira"' , array(':userid'=>$userid));
    foreach ($query_naira as $que_naira) {
      if ($que_naira['SUM(ROI)'] == "" || $que_naira['SUM(ROI)'] == 0) {
      $response['ROI_NAIRA'] = 0; 
      } else {
    $response['ROI_NAIRA'] = $que_naira['SUM(ROI)'];
     }
    }
    $investment = DB::query('SELECT amount FROM investment_history WHERE status = "active" AND userid = :userid ' , array(':userid'=>$userid));
    if (count( DB::query('SELECT available_balance FROM investment WHERE userid = :userid ' , array(':userid'=>$userid))) == 0) {
    $balance = DB::query('SELECT SUM(bitcoin_deposited) FROM deposit WHERE userid = :userid AND status = "confirmed" AND deposit_type = "bitcoin"' , array(':userid'=>$userid));
     foreach ($balance as $bal) {
      if ($bal['SUM(bitcoin_deposited)'] == 0 ) {
      $response['available_balance'] = 0;
      } else {
      $response['available_balance'] = $bal['SUM(bitcoin_deposited)'];
      }
    }
    } else {
    $available_balance = DB::query('SELECT available_balance FROM investment WHERE userid = :userid ' , array(':userid'=>$userid))[0]['available_balance'];
    $response['available_balance'] = $available_balance;
    }


    if (count( DB::query('SELECT available_balance FROM cash_investment WHERE userid = :userid' , array(':userid'=>$userid))) == 0 ) {
      
    $balance_naira = DB::query('SELECT SUM(bitcoin_deposited) FROM deposit WHERE userid = :userid AND status = "confirmed" AND deposit_type = "naira"' , array(':userid'=>$userid));
       foreach ($balance_naira as $bal_nai) {
      if ($bal_nai['SUM(bitcoin_deposited)'] == "" || $bal_nai['SUM(bitcoin_deposited)'] == 0 ) {
      $response['availables_balance_naira'] = 0;
      } else {
      $response['availables_balance_naira'] = $bal_nai['SUM(bitcoin_deposited)'];
      }
    }
    } else {
    $naira =  DB::query('SELECT available_balance FROM cash_investment WHERE userid = :userid' , array(':userid'=>$userid))[0]['available_balance'];
    $response['availables_balance_naira'] = $naira;
    }
    $withdrawal = DB::query('SELECT withdrawal_value FROM withdrawal_history WHERE userid = :userid ' , array(':userid'=>$userid));
    $withdrawal_paid = DB::query('SELECT withdrawal_value FROM withdrawal_history WHERE  status = "paid" AND userid = :userid ' , array(':userid'=>$userid));
   $withdrawal_requested = DB::query('SELECT withdrawal_value FROM withdrawal_history WHERE  status = "requested" AND userid = :userid ' , array(':userid'=>$userid));
   $confirmation = DB::query('SELECT status FROM users WHERE id = :userid ' , array(':userid'=>$userid))[0]['status'];

   $response['investment'] = count($investment);
  
   $response['withdrawal'] = count($withdrawal);
   $response['withdrawal_paid'] = count($withdrawal_paid);
   $response['withdrawal_requested'] = count($withdrawal_requested);
   $response['confirmation'] = $confirmation;
       
     $response['username'] = DB::query('SELECT username FROM users WHERE id = :userid' , array(':userid'=>$userid))[0]['username'];
    echo json_encode($response);
   }




    

   // public static function ROImodel($userid , $investment, )





      
      public static function investment_calculator ($userid) {
                
        
       

      }



















public static function roi_calculator($roi_time , $userid)  
 {  
      $roi_val = DB::query('SELECT ROI FROM investment_history WHERE investment_date = :roi_time AND userid = :userid' , array(':roi_time'=>$roi_time , ':userid'=>$userid))[0]['ROI'];
      $roi_user_val =  $roi_val / 14;
      $time_ago = strtotime($roi_time);  
      $current_time = time();  
      $time_difference = $current_time - $time_ago;  
      $seconds = $time_difference;  
      $minutes      = round($seconds / 60 );           // value 60 is seconds  
      $hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec  
      $days          = round($seconds / 86400);          //86400 = 24 * 60 * 60;  
      $weeks          = round($seconds / 604800);          // 7*24*60*60;  
      $months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
      $years          = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60 


 /* while ($days <= 14) {
    $day = $roi_time[(int)$days]; */

 
    if ($days <= 14) {
     return $roi_user_val * $days;
    } else {
     return $roi_val;
    }
  /*  $days++;
  } */

 /*  for ($i = $days; $i < 15; $i++) {
    foreach ($variable as $key => $value) {
      # code...
    }
     } 

       
  /*   if($days==1) { 
     return $roi_user_val * $days;

     } else if ( $days == 2) {
     return $roi_user_val * $days;

     } else if ( $days == 3) {
     return $roi_user_val * $days;

     } else if ( $days == 4) {
      return $roi_user_val * $days;

     } else if ( $days == 5) {
     return $roi_user_val * $days;

     } else if ( $days == 6) {
     return $roi_user_val * $days;

     } else if ( $days == 7) {
     return $roi_user_val * $days;

     } else if ( $days == 8) {
     return $roi_user_val * $days;

     } else if ( $days == 9) {
      return $roi_user_val * $days;
 
     } else if ( $days == 10) {
     return $roi_user_val * $days;

     } else if ( $days == 11) {
     return $roi_user_val * $days;
 
     } else if ( $days == 12) {
      return $roi_user_val * $days;
 
     } else if ( $days == 13) {
     return $roi_user_val * $days;

     } else if ( $days == 14) {
     return $roi_user_val * $days;

     }  */
     //echo json_encode($response); 
 }
















  
  public static function forgot_password($email) {
  $response = array();
  if (DB::query('SELECT email FROM users WHERE email = :email', array(':email'=>$email))) {
    $terget = "support@samtos4realtech.com";
      $password = rand(999 , 99999);
      $subject =  "
				 SAMTOS INVESTMENT: password recovery
               ";
      $message = "
			    <html>
				<head>
				<title><b> SAMTOS FORGOT PASSWORD</b></title>
				</head>
				<body>
				 <p style='font-weight: 300; font-size: 28px;'> Dear investor we would employ you to use this pin to recover your password"." <p style='color: #66a3ff; font-size: 33px'><strong><b>".$password."</b></strong></p></p>
				</body>
				</html>
             ";
       $header = "MIME-Version: 1.0\r\n";
       $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
       $header .= "FROM:". $terget;
      $to = DB::query('SELECT email FROM users WHERE email = :email', array(':email'=>$email))[0]['email'];
      $user_id = DB::query('SELECT id FROM users WHERE email = :email', array(':email'=>$email))[0]['id'];
    if (mail($to, $subject, $message , $header)) {
      if (count(DB::query('SELECT userid FROM password_token WHERE userid = :user_id', array(':user_id'=>$user_id))) == 0) {
         DB::query('INSERT INTO password_token VALUES (\'\', :password, :userid)', array(':password'=>$password, ':userid'=>$user_id));
        } else {
           DB::query('UPDATE password_token SET password = :password WHERE userid=:user_id', array(':password'=>$password , ':user_id'=>$user_id));        
        }
         $reponse['status'] = true;
        $response['body'] = "check your email for the pin";
      } else {
           $reponse['status'] = false;
        $response['body'] = "error sending your mail";
    }
  } else {
   $reponse['status'] = false;
   $response['body'] = "no user with this email";
  }
  echo json_encode($response);
}









public static function recover_password($token , $password) {
  
  $response = array();
  $userid = DB::query('SELECT userid FROM password_token WHERE password = :token', array(':token'=>$token))[0]['userid'];
      if (DB::query('SELECT password FROM password_token WHERE password = :token', array(':token'=>$token))) {
          if (strlen($password) >= 6 && strlen($password) <= 60) {
            DB::query('UPDATE users SET password = :password WHERE id = :userid' , array(':password'=>password_hash($password , PASSWORD_BCRYPT), ':userid'=>$userid));
            $response['status'] = true;
            $response['body'] = "password updated successfully";
            DB::query('DELETE FROM password_token WHERE password=:token', array(':token'=>$token));
          } else {
             $response['status'] = false;
             $response['body'] = "password is too short or too long";
          }
      } else {
        $response['status'] = false;
       $response['body'] = "invalid recovery pin";
      }
  
    echo json_encode($response);
}










public static function compress_image($source_url, $destination_url, $quality) {

      
        $info = getimagesizefromstring($source_url);

        if ($info['mime'] == 'image/jpeg')
              $image = imagecreatefromstring($source_url);

        elseif ($info['mime'] == 'image/gif')
              $image = imagecreatefromstring($source_url);

      elseif ($info['mime'] == 'image/png')
              $image = imagecreatefromstring($source_url);

        imagejpeg($image, $destination_url, $quality);
        return $destination_url;
    }






public static function createpropic ($profileimg, $userid) {
    if ($userid) {
      DB::query('UPDATE users SET profileimg=:profileimg WHERE id=:userid', array(':profileimg'=>$profileimg, ':userid'=>$userid));
    }
  }

public static function edit_profile_with_phone ($profileimg, $userid , $phone) {
    if ($userid) {
      DB::query('UPDATE users SET profileimg=:profileimg , phone = :phone WHERE id=:userid', array(':profileimg'=>$profileimg, ':userid'=>$userid , ':phone' => $phone));
      getusername($userid);
      $response = array();
      $response['status'] = true;
      $response['message'] = "image uploaded successfully";
      echo json_encode($response);
    }
  }





public static function kyc($userid , $SOR , $address , $password , $image) {
         $response = array();
	 if (password_verify($password, DB::query('SELECT password FROM users WHERE id = :userid', array(':userid'=>$userid))[0]['password'])) {
	 	DB::query('INSERT INTO kyc VALUES( \'\' , :SOR , :address , :userid , :password , :image)' , array(':SOR'=>$SOR , ':address'=>$address , ':userid'=>$userid , ':password'=>$password , ':image'=>$image));
	 	$response['status'] = true;
	 	$response['message'] = "kyc updated successfully ";

      } else {
      	$response['status'] = false;
      	$response['message'] = "you inserted the wrong password <br> try again!!";
      }
     
 echo json_encode($response);
}







}


 ?>