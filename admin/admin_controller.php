<?php

     function postmethod ($postevent) {
              $_POST[$postevent];
                }         

 include("admin_model.php");
  if (isset($_POST['username'])) {
  	$username = $_POST['username'];
  	$password = $_POST['password'];
  	$type = $_POST['type'];
     
     ADMIN::add_admin($username , $password ,$type);

  }




if (isset($_POST['admin']) && isset($_POST['password'])) {
	$admin = $_POST['admin'];
	$password = $_POST['password'];

if (DB::query('SELECT username FROM admin WHERE username=:admin', array(':admin'=>$admin))) {
	if (password_verify($password , DB::query('SELECT password FROM admin WHERE username = :admin', array(':admin'=>$admin))[0]['password'])) {
              session_start([
            'cookie_lifetime' => 86400,
              ]);
              $user_id=DB::query('SELECT id FROM admin WHERE username=:admin', array(':admin'=>$admin))[0]['id'];
               $_SESSION['admin'] = $user_id;
               $_SESSION['logged_in']="true";
        echo "true";
    } else {
    echo "false_password";
    echo $admin;
    echo $password;
  }
} else {
    echo "false_user";
  }
}




   // if ($_POST['see']) {
   //   echo $_POST['see'];
   // }





if (isset($_POST['postid'])) {
	$postid = $_POST['postid'];
	$userid = $_POST['userid'];
	if (DB::query('SELECT status FROM deposit WHERE id = :postid AND status = "pending" AND userid = :userid', array(':postid'=>$postid , ':userid'=>$userid))) {
		$value_to_add = DB::query('SELECT bitcoin_deposited FROM deposit WHERE userid = :userid AND id = :postid' , array(':userid'=>$userid , ':postid'=>$postid))[0]['bitcoin_deposited'];
     if (count(DB::query('SELECT userid FROM investment WHERE userid = :userid ' , array(':userid'=>$userid))) == 0) {
    DB::query('UPDATE deposit SET status = TRIM("confirmed") WHERE userid=:userid AND id= :postid' , array(':userid'=>$userid , ':postid'=>$postid));  
     } else {
    DB::query('UPDATE deposit SET status =  TRIM("confirmed") WHERE userid=:userid AND id= :postid' , array(':userid'=>$userid , ':postid'=>$postid));
    DB::query('UPDATE investment SET available_balance = available_balance + :value_to_add WHERE userid=:userid ' , array(':userid'=>$userid , ':value_to_add'=>$value_to_add));
 
     }
		echo "confirmed";
	} else if (DB::query('SELECT status FROM deposit WHERE id = :postid AND status = "confirmed" AND userid = :userid', array(':postid'=>$postid , ':userid'=>$userid))){
		$value_to_add = DB::query('SELECT bitcoin_deposited FROM deposit WHERE userid = :userid AND id = :postid' , array(':userid'=>$userid , ':postid'=>$postid))[0]['bitcoin_deposited'];
     if (count(DB::query('SELECT userid FROM investment WHERE userid = :userid ' , array(':userid'=>$userid))) == 0) {
    DB::query('UPDATE deposit SET status = TRIM("pending") WHERE userid=:userid AND id= :postid' , array(':userid'=>$userid , ':postid'=>$postid));  
     } else {
    DB::query('UPDATE deposit SET status = TRIM("pending") WHERE userid=:userid AND id= :postid' , array(':userid'=>$userid , ':postid'=>$postid));
    DB::query('UPDATE investment SET available_balance = available_balance - :value_to_add WHERE userid=:userid ' , array(':userid'=>$userid , ':value_to_add'=>$value_to_add));
     }
		echo "not_confirmed";
	}
	else {
		echo "rejected";
	}
}


if (isset($_POST['reject'])) {
	$rejectid = $_POST['reject'];
	if (DB::query('SELECT status FROM deposit WHERE id = :postid', array(':postid'=>$rejectid))) {
		DB::query('UPDATE deposit SET status = TRIM("rejected") WHERE id = :postid' , array(':postid'=>$rejectid));
		echo "rejected";
	}
}



if (isset($_POST['invt_id'])) {
  $postid = $_POST['invt_id'];
  $userid = $_POST['userid'];
if (DB::query('SELECT status FROM investment_history WHERE id = :postid AND status = "active" AND userid = :userid', array(':postid'=>$postid , ':userid'=>$userid))) {
   DB::query('UPDATE investment_history SET status = "cancelled" WHERE id = :postid AND userid = :userid' , array(':userid'=>$userid , ':postid'=>$postid));
   $amount = DB::query('SELECT amount FROM investment_history WHERE id = :postid AND userid = :userid' , array(':userid'=>$userid , ':postid'=>$postid))[0]['amount'];
   DB::query('UPDATE investment SET available_balance = available_balance - :amount WHERE userid = :userid' , array(':amount' => $amount , ':userid'=>$userid));
   echo "cancelled";
 } else {
   DB::query('UPDATE investment_history SET status = "active" WHERE id = :postid AND userid = :userid' , array(':userid'=>$userid , ':postid'=>$postid));
   $amount = DB::query('SELECT amount FROM investment_history WHERE id = :postid AND userid = :userid' , array(':userid'=>$userid , ':postid'=>$postid))[0]['amount'];
   DB::query('UPDATE investment SET available_balance = available_balance + :amount WHERE userid = :userid' , array(':amount' => $amount , ':userid'=>$userid));
   echo "active";
 }
}



if (isset($_POST['ban_user'])) {
  $userid = $_POST['ban_user'];
  $reason = $_POST['text_for'];
  if (DB::query('SELECT status FROM users WHERE id= :userid AND (status ="unverified" OR status = "verified")', array(':userid'=>$userid))) {
   DB::query('UPDATE users SET status = "banned" WHERE id = :userid' , array(':userid'=>$userid));
   if (count(DB::query('SELECT userid FROM banned_table WHERE userid = :i ' , array(':i'=>$userid))) == 0) {
    DB::query('INSERT INTO banned_table VALUES(\'\' , :reason , :userid)' , array(':reason'=>$reason , ':userid'=>$userid));
   } else {
      DB::query('UPDATE banned_table SET reason = :reason WHERE id = :userid' , array(':userid'=>$userid , ':reason'=>$reason)); 
   }
   echo "banned";
  } else {
   DB::query('UPDATE users SET status = TRIM("verified") WHERE id = :userid' , array(':userid'=>$userid));
   DB::query('DELETE FROM banned_table WHERE userid = :userid' , array(':userid'=>$userid));
   echo "verified";
  }
}

if (isset($_POST['ver_id'])) {
  $userid = $_POST['ver_id'];
  if (DB::query('SELECT status FROM users WHERE id= :userid AND status ="unverified" ', array(':userid'=>$userid))) {
   DB::query('UPDATE users SET status = TRIM("verified") WHERE id = :userid' , array(':userid'=>$userid));
   echo "verified";
  } else {
   DB::query('UPDATE users SET status = TRIM("unverified") WHERE id = :userid' , array(':userid'=>$userid));
   echo "unverified";
  } 
}

if (isset($_POST['uss'])) {
  $userid = $_POST['uss'];
  $username = $_POST['usernames'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $statusS = $_POST['statusS'];

  DB::query('UPDATE users SET username = :username , first_name = :firstname , last_name = :lastname , email = :email , phone = :phone , status = :statusS WHERE id = :userid' , array(':username'=>$username , ':firstname'=>$firstname , ':lastname'=>$lastname , ':email'=>$email , ':phone'=>$phone , ':statusS'=>$statusS , ':userid'=>$userid));
  echo "updated";
}





if (isset($_POST["c"])) {
    $username = $_POST["c"];
    $people = DB::query('SELECT id , username FROM users WHERE username LIKE :username', array(':username'=>'%'.$_POST["c"].'%'));

    foreach ($people as $peoples) {
      echo '<a href="view_user.php?userid='.$peoples['id'].'">'.$peoples['username'].'</a>';
      echo "<br><br><hr>";
    }
 if (!DB::query('SELECT username FROM users WHERE username LIKE :username', array(':username'=>'%'.$_POST["c"].'%'))) {
  echo "user not registered";
}
} 




if (isset($_POST['loadi'])) {
$sorta= $_POST['loadi']; ?>
      <section class="wrapper">
 <div class="row mt">
          <div class="col-lg-12">
            <div class="content-panel">
              <section id="unseen">
                <table class="table table-bordered table-striped table-condensed">
                  <thead>
                    <tr>
                     <th>username</th>
                      <th>first name</th>
                      <th class="numeric">deposit bitcoin amount</th>
                      <th class="numeric">bitcoin wallet id</th>
                      <th class="numeric">status</th>
                      <th class="numeric">deposit description</th>
                      <th class="numeric">date deposited</th>
                      <th class="numeric">C0NFIRM USER</th>
                      <th class="numeric">Rejected</th>
                    </tr>
                  </thead>
                  <tbody>   

                    <?php
                    $piids = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                    $depositusers =  DB::query("SELECT * FROM deposit  ORDER BY id DESC LIMIT $sorta " ,  array());
                    foreach ($depositusers as $depo) {
                      $user_id = $depo['userid'];
                      $uname = DB::query('SELECT username FROM users WHERE id = :user_id' , array(':user_id'=>$user_id))[0]['username'];
                      $fname = DB::query('SELECT first_name FROM users WHERE id = :user_id' , array(':user_id'=>$user_id))[0]['first_name'];
                      $piids = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $piid = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $pii = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $pi = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      echo "
                    <tr>
                      <p id ='".$pi."' style = 'display:none;'>".$user_id."</p>
                      <td class='numeric'>".$uname."</td>
                      <td class='numeric'>".$fname."</td>
                      <td class='numeric'>".$depo['bitcoin_deposited']."</td>
                      <td class='numeric'>".$depo['bitcoin_wallet_id']."</td>
                      <td class='numeric' id='".$piid."'>".$depo['status']."</td>
                      <td class='numeric'>".$depo['deposit_description']."</td>
                      <td class='numeric'>".$depo['date']."</td>
                      <td class='numeric'><button id='".$piids."' value = '".$depo['id']."' onclick = 'javascript: var postid = this.value;  var userid = document.getElementById(\"".$pi."\").innerHTML; $.ajax({url : \"admin_controller.php\" , type : \"POST\" , data : {postid:postid , userid:userid} , success: function (response) { var y = document.getElementById(\"".$piid."\");  if(response == \"confirmed\") {y.innerHTML = \"confirmed\";} else if (response == \"not_confirmed\") {y.innerHTML = \"pending\";} else {alert(\"this deposit has been rejected\");}this.innerHTML = \"rejected\";  this.innerHTML = \"CONFIRMED\"; }})'>CONFIRM</button></td>
                      <td class='numeric'><button  id='".$pii."' value = '".$depo['id']."' onclick = 'javascript: var reject = this.value;  $.ajax({url : \"admin_controller.php\" , type : \"POST\" , data : {reject:reject} , success: function (response) { var y = document.getElementById(\"".$pii."\");  if(response == \"rejected\") {y.innerHTML = \"rejected\";  document.getElementById(\"".$piid."\").innerHTML = \"rejected\"} } })'>REJECT</button></td>
                    </tr>  

                      ";
                    }
                 
                    ?>
                   
                 </div>
                  </tbody>
                </table>
              </section>
            </div>
            <!-- /content-panel -->
          </div>
          <!-- /col-lg-4 -->
        </div>
      </section>
<?php 
} 

if (isset($_POST['datas'])) {
  $id = $_POST['datas'];
  $amount = $_POST['amount'];
  $status = $_POST['status'];


  DB::query('UPDATE investment_history SET amount = :amount , status = :status WHERE id = :id' , array(':id' =>$id , ':amount' => $amount , ':status' =>$status));
  echo $amount;
                }

                  

?>