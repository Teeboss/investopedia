<?php 
 session_start([
            'cookie_lifetime' => 86400,
              ]);
//header("location: index.php");
 if (!$_SESSION['admin']) {
   header("location: index.php");
 } else
include("admin_controller.php");
  $userid = $_SESSION['admin'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <title>SAMTOS INVESTMENT PRO </title>

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/admin.css" rel="stylesheet">
  <!--external css-->
  <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet">
  <link href="css/table-responsive.css" rel="stylesheet">

  <!-- =======================================================
    Template Name: Dashio
    Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
    Author: TemplateMag.com
    License: https://templatemag.com/license/
  ======================================================= -->
</head>

<body>
  <section id="container">
    <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
    <!--header start-->
    <header class="header black-bg">
      <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
      </div>
      <!--logo start-->
      <a href="#" class="logo"><b>ADMIN<span><?php  //echo $user; ?></span></b></a>
      <!--logo end-->
      <div class="nav notify-row" id="top_menu">
        <!--  notification start -->  
      </div>
            <div class="top-menu">
        <ul class="nav pull-right top-menu">
           <li name="logout" id="logout" class="logout"><a href="#" class="logout">Logout</a> </li>
        </ul>
      </div>
    </header>
    <script type="text/javascript">
      document.getElementById("logout").addEventListener("click" , function() {
        var log = $("#logout").val()
        $.ajax({
          url:"dashboard_admin.php",
          type: "POST",
          data: {"logout" : "logout"},
          success: function(data) {
            location.reload()
          }
        })
      })
    </script>
  </section>
  <?php
 if (isset($_POST['logout'])) {
   session_destroy();
  }
?>
    <!--header end-->
    <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
    <!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
          <p class="centered"><a href="dashboard_admin.php"><img src="Profile-Icon.png" class="img-circle" width="80"></a></p>
          <h5 class="centered"><?php 
        echo  DB::query('SELECT username FROM admin WHERE id = :i ' , array(':i'=>$userid))[0]['username'];

          ?></h5>
            <?php if (DB::query('SELECT type FROM admin WHERE id = :i AND type = "super"' , array(':i' => $userid))) {
            $super = "
             <li class='mt'>
            <a href='add_admin.php'>
              <i class='fa fa-dashboard'></i>
              <span>ADD NEW ADMIN</span>
              </a>
          </li>
            ";
            $super_user =  "
             <li class='mt'>
            <a href='users.php'>
              <i class='fa fa-dashboard'></i>
              <span>VIEW USERs</span>
              </a>
          </li>
            ";
          } else {
            $super = "";
            $super_user = "";
          }
          echo $super  ;
          echo $super_user;
          ?>
           <li class="mt">
            <a href="#">
              <i class="fa fa-dashboard"></i>
              <span>WITHDRAWALS</span>
              </a>
          </li>
           <li class="mt">
            <a href="investment_history.php">
              <i class="fa fa-dashboard"></i>
              <span>INVESTMENTS</span>
              </a>
          </li>
           <li class="mt">
            <a href="deposit_history.php">
              <i class="fa fa-dashboard"></i>
              <span>DEPOSITS</span>
              </a>
          </li>
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">

         <?php
              
               if (isset($_GET['userid'])) {
                 $Ouserid = $_GET['userid'];
                  $username = DB::query('SELECT username FROM users WHERE id = :id', array(':id'=>$Ouserid))[0]['username'];
             ?>
             <br><br>
            <nav class="navbar navbar-inverse">
              <div class="container-fluid">
                <div class="navbar-header">
                  <a class="navbar-brand" href="#"><?php  echo $username; ?></a>
                </div>
                <ul class="nav navbar-nav">
                  <li class="active"><a href="edit_profile.php?userid=<?php echo $Ouserid;?>">Home</a></li>
                  <li ><a href="#"><button id="myBtn">BAN</button></a></li>
                  <li><a href="#"><button id="myBtn_edit">EDIT PROFILE </button></a></li>
                  <li><a href="#">USER TRANSACTIONS</a></li>
                </ul>
              </div>
            </nav>

<!-- The Modal -->

        <div class="row mt">
          
          <div class="col-lg-12">
            <div class="content-panel">
              
              <h4><i class="fa fa-angle-right"></i></h4>
                  <div class="main-body">

              <?php
                  $user = DB::query('SELECT * FROM users WHERE id = :id', array(':id'=>$Ouserid));
                  $deposits = DB::query('SELECT SUM(bitcoin_deposited) FROM deposit WHERE userid = :userid and status = "confirmed"' , array(':userid'=>$Ouserid));
                  foreach ($deposits as $depost) {
                    $depo = $depost['SUM(bitcoin_deposited)'];
                  }
                  $deposits_all_approved = DB::query('SELECT SUM(bitcoin_deposited) FROM deposit WHERE userid = :userid AND status = "confirmed"' , array(':userid'=>$Ouserid));
                  foreach ($deposits_all_approved as $depost) {
                    $depo_all_ap = $depost['SUM(bitcoin_deposited)'];
                  }
                 $deposits_all_bitcoin = DB::query('SELECT SUM(bitcoin_deposited) FROM deposit WHERE userid = :userid  AND deposit_type = "bitcoin" AND status = "confirmed" ' , array(':userid'=>$Ouserid));
                  foreach ($deposits_all_bitcoin as $depost) {
                    $depo_all_bitcoin = $depost['SUM(bitcoin_deposited)'];
                  }
                   $deposits_all = DB::query('SELECT SUM(bitcoin_deposited) FROM deposit WHERE userid = :userid' , array(':userid'=>$Ouserid));
                  foreach ($deposits_all as $depost) {
                    $depo_all = $depost['SUM(bitcoin_deposited)'];
                  }
                $investment = count(DB::query('SELECT amount FROM investment_history WHERE status = "active" AND userid = :userid ' , array(':userid'=>$userid))); 

                   $query = DB::query('SELECT SUM(ROI) FROM investment_history WHERE userid = :userid AND status = "active" AND investment_type = "bitcoin"' , array(':userid'=>$userid));
                  foreach ($query as $que) {
                    if ($que['SUM(ROI)'] == "" || $que['SUM(ROI)'] == 0) {
                    $bitcoin = 0; 
                    } else {
                  $bitcoin = $que['SUM(ROI)'];
                   }
                  }

                   $query_naira = DB::query('SELECT SUM(ROI) FROM investment_history WHERE userid = :userid AND status = "active" AND investment_type = "naira"' , array(':userid'=>$userid));
                  foreach ($query_naira as $que_naira) {
                    if ($que_naira['SUM(ROI)'] == "" || $que_naira['SUM(ROI)'] == 0) {
                    $naira_roi = 0; 
                    } else {
                  $naira_roi = $que_naira['SUM(ROI)'];
                   }
                  }
                  if (count( DB::query('SELECT available_balance FROM investment WHERE userid = :userid ' , array(':userid'=>$userid))) == 0) {
                  $balance = DB::query('SELECT SUM(bitcoin_deposited) FROM deposit WHERE userid = :userid AND status = "confirmed" AND deposit_type = "bitcoin"' , array(':userid'=>$userid));
                   foreach ($balance as $bal) {
                    if ($bal['SUM(bitcoin_deposited)'] == 0 ) {
                    $available_balance = 0;
                    } else {
                    $available_balance = $bal['SUM(bitcoin_deposited)'];
                    }
                  }
                  } else {
                  $available_balance = DB::query('SELECT available_balance FROM investment WHERE userid = :userid ' , array(':userid'=>$userid))[0]['available_balance'];
                  }
                  
                    if (count( DB::query('SELECT available_balance FROM cash_investment WHERE userid = :userid' , array(':userid'=>$userid))) == 0 ) {
                    
                  $balance_naira = DB::query('SELECT SUM(bitcoin_deposited) FROM deposit WHERE userid = :userid AND status = "confirmed" AND deposit_type = "naira"' , array(':userid'=>$userid));
                    if ($balance_naira == "" || $balance_naira == 0 ) {
                     $naira = 0;
                    } else {
                    foreach ($balance_naira as $bal_nai) {
                      $naira = $bal_nai['SUM(bitcoin_deposited)'];
                     }
                  }
                  } else {
                  $naira =  DB::query('SELECT available_balance FROM cash_investment WHERE userid = :userid' , array(':userid'=>$userid))[0]['available_balance'];
                  }

                  if (DB::query('SELECT userid FROM kyc WHERE userid= :userid',array(':userid'=>$Ouserid))) {
                    $kyc = DB::query('SELECT * FROM kyc WHERE userid =:userid',array(':userid'=>$Ouserid));
                  $Kyc_data = "
                    ".$kyc[0]['address']."<br>".$kyc[0]['SOR']."<br><img src='../image/".$kyc[0]['image']."' alt='Admin' class='rounded-circle' width='150'>
                  ";
                  } else {
                    $Kyc_data = "No KYC yet";
                  }

                  if (DB::query('SELECT userid FROM kyc WHERE userid= :userid',array(':userid'=>$Ouserid))) {
                    $address = DB::query('SELECT address FROM kyc WHERE userid =:userid',array(':userid'=>$Ouserid));
                  $addres = "
                    ".$kyc[0]['address']."
                    ";
                  } else {
                    $addres = "No address for this user because the kyc data is still pending ";
                  }

                     if ($user[0]['profileimg'] == "") {
                       $profile_img = "<img src='Profile-Icon.png' alt='Admin' class='rounded-circle' width='150'>";
                     } else {
                       $profile_img = "<img src='../image/".$user[0]['profileimg']."' alt='Admin' class='rounded-circle' width='150'>";
                     }
                   echo "
                  
                      <div class='row gutters-sm'>
                        <div class='col-md-4 mb-3'>
                          <div class='card'>
                            <div class='card-body'>
                              <div class='d-flex flex-column align-items-center text-center'>
                                ".$profile_img."
                                <div class='mt-3'>
                                  <h4>".$user[0]['first_name']." ".$user[0]['last_name']."</h4>
                                <!--  <p class='text-muted font-size-sm'>Bay Area, San Francisco, CA</p> -->
                                  <button  class='btn btn-primary' id='ver_btn' value='".$user[0]['id']."' onclick='javascript: var userid = this.value; $.ajax({ url : \"admin_controller.php\" , type: \"POST\" , data:{\"ver_id\":userid} , success: function(response){document.getElementById(\"status\").innerHTML = response;} })'>VERIFY USER</button>
                                  <h4  class='btn btn-outline-primary' >STATUS :</h4>
                                  <h4 id='status' class='btn btn-outline-primary' >".$user[0]['status']."</h4>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class='card mt-3'>
                          <ul class='list-group list-group-flush'>
                            <li class='list-group-item d-flex justify-content-between align-items-center flex-wrap'>
                              <h6 class='mb-0'><b>KYC</b></h6>
                    ".$Kyc_data."
                  </li>
                </ul>
              </div>
               <div class='col-md-16' >
                  <ul class='list-group tre'>
                    <li class='list-group-item blue' style='float: center;'>BALANCES</li>
                    <li class='list-group-item'>DEPOSITS (total): <span class='right_ni'>".round($depo_all)."</span></li>
                    <li class='list-group-item'>DEPOSITS (approved):<span class='right_ni'>".round($depo_all_ap)."</span></li>
                    <li class='list-group-item'>DEPOSITS (PRO):<span class='right_ni'>".round($depo_all_bitcoin)."</span></li>
                    <li class='list-group-item'>DEPOSITS (naira):<span class='right_ni'>".round($naira)."</span></li>
                    <li class='list-group-item'>INVESTMENTS(PRO):<span class='right_ni'>".round($available_balance)."</span></li>
                    <li class='list-group-item'>INVESTMENTS(naira):<span class='right_ni'>".round($naira)."</span></li>
                  </ul>
                </div>
            </div>


            
                


                <div class='col-md-8' >
                  <ul class='list-group tre'>
                    <li class='list-group-item blue' style='float: center;'> USER DETAILS  </li>
                    <li class='list-group-item'>USERNAME <span class='right_ni'>".$user[0]['username']."</span></li>
                    <li class='list-group-item'>FULL NAME <span class='right_ni'>".$user[0]['first_name']." ".$user[0]['last_name']."</span></li>
                    <li class='list-group-item'>EMAIL <span class='right_ni'>".$user[0]['email']."</span></li>
                    <li class='list-group-item'>PHONE NO <span class='right_ni'>".$user[0]['phone']."</span></li>
                    <li class='list-group-item'>ADDRESS <span class='right_ni'>".$addres."</span></li>
                  </ul>
                </div>

                  <div class='col-md-8' >
                  <ul class='list-group tre'>
                    <li class='list-group-item blue' style='float: center;'>RETURN ON INVESTMENTS (ROIs)</li>
                    <li class='list-group-item'>INVESTMENTS (PRO):<span class='right_ni'>".round($bitcoin)."</span></li>
                    <li class='list-group-item'>INVESTMENTS (naira):<span class='right_ni'>".round($naira_roi)."</span></li>
                  </ul>
                </div>
            </div>

               </div>
              </div>
            </div>
          </div>
        </div>
    </div><br>


                 <div id='myModal' class='modal'>
                    <!-- Modal content -->
                    <div class='modal-content'>
                      <span class='close'>&times;</span>
                       <div class='show_div placer' id='pre'>
                  <textarea rows='3' cols='40' id='text_for'>type your reason here </textarea><br>
                  <button value='".$user[0]['id']."' onclick='javascript: var userid = this.value; var text_for = document.getElementById(\"text_for\").value; $.ajax({url: \"admin_controller.php\" , type: \"POST\" , data: {\"ban_user\":userid , text_for:text_for} , success: function (response) {if(response==\"banned\"){document.getElementById(\"status\").innerHTML = \"banned\";} else {document.getElementById(\"status\").innerHTML = response; } alert(response);} , afterSend: function () {document.getElementByParentId(this).style.display= \"none\";}})'>BAN USER</button>
                     </div>
                    </div>

                  </div>


                    <!-- The Modal -->
                    <div id='myModal_edit' class='modal'>

                      <!-- Modal content -->
                      <div class='modal-content'>
                        <span class='close_edit'>&times;</span>
                          <div id='ver' class='show_div placer'>
                   <form id='edit_form' method = 'post' >
                     <input id='uss' name ='uss' style= 'display:none;'>
                   <label style = 'color: white;'>USERNAME</label>
                    <input id='usernames' name='usernames' type='text' >

                   <label style = 'color: white;'>FIRST NAME</label>
                    <input id='firstname' name='firstname' type='text' >

                   <label style = 'color: white;'>LAST NAME</label>
                    <input id='lastname' name='lastname' type='text' >

                   <label style = 'color: white;'>EMAIL</label>
                    <input id='email' name='email' type='text' >

                   <label style = 'color: white;'>PHONE</label>
                    <input id='phone' name='phone' type='text' >

                    <label style = 'color: white;'>STATUS</label>
                   <input id='statusS' name='statusS' type='text' ><br><br>

                    <button>UPDATE THIS USER PROFILE</button>
                   </form>
                     <script>
                      document.getElementById(\"uss\").defaultValue = \"".$user[0]['id']."\"
                      document.getElementById(\"usernames\").defaultValue = \"".$user[0]['username']."\"
                      document.getElementById(\"firstname\").defaultValue = \"".$user[0]['first_name']."\"
                      document.getElementById(\"lastname\").defaultValue = \"".$user[0]['last_name']."\"
                      document.getElementById(\"email\").defaultValue = \"".$user[0]['email']."\"
                      document.getElementById(\"phone\").defaultValue = \"".$user[0]['phone']."\"
                      document.getElementById(\"statusS\").defaultValue = \"".$user[0]['status']."\"
                     </script>
                     
                   </div>
                      </div>

                    </div>
                  ";
                 }

              ?>
           
              </div>
            </div>
            <!-- /content-panel -->
          </div>
          <!-- /col-lg-12 -->
        </div>
        <!-- /row -->
      </section>
      <!-- /wrapper -->
    </section>
    <!-- /MAIN CONTENT -->
    <!--main content end-->
    <!--footer start-->
    <footer class="site-footer">
      <script type="text/javascript">
       // document.getElementById("side_show").style.display = "none";
      </script>
      <div class="text-center">
        <p>
          &copy; Copyrights <strong>Dashio</strong>. All Rights Reserved
        </p>
        <div class="credits">
          <!--
            You are NOT allowed to delete the credit link to TemplateMag with free version.
            You can delete the credit link only if you bought the pro version.
            Buy the pro version with working PHP/AJAX contact form: https://templatemag.com/dashio-bootstrap-admin-template/
            Licensing information: https://templatemag.com/license/
          -->
          Created with Dashio template by <a href="https://templatemag.com/">TemplateMag</a>
        </div>
        <a href="responsive_table.html#" class="go-top">
          <i class="fa fa-angle-up"></i>
          </a>
      </div>
    </footer>
    <!--footer end-->
  </section>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="js/jquery.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="lib/jquery.scrollTo.min.js"></script>
  <script src="lib/jquery.nicescroll.js" type="text/javascript"></script>
  <!--common script for all pages-->
  <script src="lib/common-scripts.js"></script>


   
    <script type="text/javascript">
               $(document).ready(function() {



                $("#ban_btn").click(function () {
                  if ($("#ver").show()) {
                  $("#ver").hide()
                  $("#pre").toggle("slow", "linear")
                  }
                })
                $("#edit_btn").click(function(){
                  if ($("#pre").show()) {
                    $("#pre").hide()
                    $("#ver").toggle("slow", "swing")
                  }
                })
             


              $("#edit_form").submit(function (e) {
                e.preventDefault()
                $.ajax({
                  url: "admin_controller.php",
                  type: "POST",
                  data: new FormData(this),
                  cache: false,
                  contentType: false,
                  processData: false,
                  success:function(response){
                    if (response == "updated") {
                      alert("users details updated successfully")
                      location.reload()
                    }
                  }
                })
              })
              


              $("#ban_click").click(function(){
                $("#ban_btn").click()
              })

               })


               // Get the modal
              var modal = document.getElementById("myModal");

              // Get the button that opens the modal
              var btn = document.getElementById("myBtn");

              // Get the <span> element that closes the modal
              var span = document.getElementsByClassName("close")[0];

              // When the user clicks on the button, open the modal
              btn.onclick = function() {
                modal.style.display = "block";
              }

              // When the user clicks on <span> (x), close the modal
              span.onclick = function() {
                modal.style.display = "none";
              }

              // When the user clicks anywhere outside of the modal, close it
              window.onclick = function(event) {
                if (event.target == modal) {
                  modal.style.display = "none";
                }
              }



               var modal_edit = document.getElementById("myModal_edit");

              // Get the button that opens the modal
              var btn = document.getElementById("myBtn_edit");

              // Get the <span> element that closes the modal
              var span = document.getElementsByClassName("close_edit")[0];

              // When the user clicks on the button, open the modal
              btn.onclick = function() {
                modal_edit.style.display = "block";
              }

              // When the user clicks on <span> (x), close the modal_edit
              span.onclick = function() {
                modal_edit.style.display = "none";
              }

              // When the user clicks anywhere outside of the modal_edit, close it
              window.onclick = function(event) {
                if (event.target == modal_edit) {
                  modal_edit.style.display = "none";
                }
              }
              </script>




</body>

</html>
