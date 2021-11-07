<?php

class int {
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
  

  //controller part 
        if(isset($_POST['email_login']) && isset($_POST['password_login'])){
    include ("model/DB.php");
	$email = $_POST['email_login'];
  $password = $_POST['password_login'];
  if (DB::query('SELECT email FROM users WHERE email=:email', array(':email'=>$email))) {
if(DB::query('SELECT active FROM users WHERE email=:email AND active = 1', array(':email'=>$email))){
	if (password_verify($password , DB::query('SELECT passwords FROM users WHERE email = :email', array(':email'=>$email))[0]['passwords'])) {
              session_start([
            'cookie_lifetime' => 86400,
              ]);
              $user_id=DB::query('SELECT id FROM users WHERE email=:email', array(':email'=>$email))[0]['id'];
               $_SESSION['naijatron'] = $user_id;
               $_SESSION['logged_in']="true";
        echo "true";
    } else {
    echo "false_password";
  }
} else {
    echo "false_user";
  }
} else {
  echo "false_email";
}
}




//js intrgration for login



<script>
    document.getElementById("none_display").style.display = "none";
</script>
<script src="js/jquery.min.js"></script>
<script>
    $(document).ready(() => {
        $("#show_button").click((e) => {
            e.preventDefault()
            $(".right").css("display" , "none")
            $("#none_display").css("display" , "block")
        })






        $("#submit").click(function (e) {
                e.preventDefault() 
                 var email = $("#email").val()
                 var password = $("#password").val()
        
                 $.ajax({
                            url: "controller.php",
                            type: 'POST',
                            cache: false,
                            data:  { "email_login" : email , "password_login" : password}, 
                            error : function (error){
                                alert('error connecting to the internet')
                            },
                           success: function (data) {
                             if (data == "false_user") {
                                $("#email_message").show().html("your account has not been activated yet check your confirmation email for your confirmation ").css({"background-color":"#ffcccc" , "border":"3px solid #ff8080" , "border-radius":"5px" , "margin-top":"3%"}).fadeOut(6000)
                             } else if (data == "false_email") {
                                $("#email_message").show().html("your email has not been registered with Naijatron").css({"background-color":"#ffcccc" , "border":"3px solid #ff8080" , "border-radius":"5px" , "margin-top":"3%"}).fadeOut(6000)
                             } else if (data == "false_password") {
                                $("#email_message").show().html("invalid password try again later try the forgot password if you can't remember your current password").css({"background-color":"#ffcccc" , "border":"3px solid #ff8080" , "border-radius":"5px" , "margin-top":"5px"}).fadeOut(6000)
                             } else {
                                $("#email_message").show().html("login successful").css({"background-color":"#ccffcc" , "border":"3px solid #80ff80" , "border-radius":"5px" , "margin-top":"5px"}).fadeOut(6000)
                                 location.replace("dashboard.php")
                             }
                           }
                        })
                 
             })  
    })
</script>






}

?>