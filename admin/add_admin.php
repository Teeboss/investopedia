
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
  <!--external css-->
  <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet">
  <link href="css/table-responsive.css" rel="stylesheet">

 
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="login/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/css/util.css">
	<link rel="stylesheet" type="text/css" href="login/css/main.css">
<!--===============================================================================================-->
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
            <a href="withdrawal_history.php?page=1&item=10">
              <i class="fa fa-dashboard"></i>
              <span>WITHDRAWALS</span>
              </a>
          </li>
           <li class="mt">
            <a href="investment_history.php?page=1&item=10">
              <i class="fa fa-dashboard"></i>
              <span>INVESTMENTS</span>
              </a>
          </li>
           <li class="mt">
            <a href="deposit_history.php?page=1&item=10">
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

     	<header>
        
    </header>
	<div class="limiter">
		<div class="container-login100">
			<div  class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
					<span class="login100-form-title p-b-33">
						ADD A NEW ADMIN
					</span>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="username" id="username" placeholder="Admin user name">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
						<span class="focus-input100-2" id="n_error"></span>

					</div>

					<div class="wrap-input100 rs1 validate-input">
						<input class="input100" type="password" name="password" id="password"  placeholder=" Admin Password">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
						<span class="focus-input100-2" id="p_error"></span>
					</div>


					<div class="wrap-input100 rs1 validate-input">
                    <select id="type" name="type" >
                    	<option></option>
                    	<option>normal</option>
                    	<option>super</option>
                    </select>
				    <span class="focus-input100-2" id="t_error"></span>
					</div>
					<div class="container-login100-form-btn m-t-20">
						<button class="login100-form-btn" id="submit">
							Add this admin
						</button>
					</div>
			</div>
		</div>
	</div>  
    </section>
   
  </section>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="js/jquery.js"></script>
 <!-- <script src="js/main.js"></script> --->
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="lib/jquery.scrollTo.min.js"></script>
  <script src="lib/jquery.nicescroll.js" type="text/javascript"></script>
  <!--common script for all pages-->
  <script src="lib/common-scripts.js"></script>
  <script type="text/javascript">
  	

   $(document).ready(function() {


$("#submit").on("click", function(e) {
    e.preventDefault()

   var newuser  =  $("#username").val()
   var password  =  $("#password").val()
   var type  =  $("#type").val()

   if (newuser == "") {
   	$("#n_error").html("username must be add to continue")
   } else if(password == "") {
   	$("#p_error").html(" insert password for this admin  to continue")
   	$("#n_error").html("")
   } else if (type == "") {
   alert("pick the type of admin")
   	$("#p_error").html("")
   } else {
   	$.ajax({
   		url: "admin_controller.php",
   		type: "POST",
   	 //   dataType: "JSON",
	    data: "username="+newuser+"&password="+password+"&type="+type,
   		error: function () {
   		alert("an error ocurred while trying to connect to the internet try again")
   		},
   		success: function (data) {
         if (data == "password_short") {
         	alert("password is too short ")
         } else if (data == "username_taken") {
            alert("user name has already been taken by another admin")
         }else {
         	alert("admin added successfully thanks")
         }
   		}
   	})
   }

})


})

  </script>
  <div id="myModal" class="modal">
  <span class="close" id="close">&times;</span>
  <div class="modal-content" > <br>
  	<p></p>
  <button id="colapse">ok</button>

  </div>
  <div id="caption"></div>
</div>
 

<script type="text/javascript">
 var x =  document.getElementById("close");
 x.onclick = function (){
  document.getElementById("myModal").style.display = "none"
 }
var z = document.getElementById("colapse");
x.onclick = function () {
	document.getElementById("myModal").style.display = "none"
}
</script>
  <!--script for this page-->
</body>

</html>
<?php ?>