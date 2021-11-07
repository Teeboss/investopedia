<!DOCTYPE html>
<html lang="en">
<head>
	<title>Samtos Global Loan</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

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
	<header>
        
    </header>
	<div class="limiter">
		<div class="container-login100">
			<div  class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
					<span class="login100-form-title p-b-33">
						Account Login
					</span>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="admin" id="admin" placeholder="your username">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="wrap-input100 rs1 validate-input">
						<input class="input100" type="password" name="password" id="password" placeholder="Password">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="container-login100-form-btn m-t-20">
						<button class="login100-form-btn" id="submit">
							LOGIN
						</button>
					</div>
			</div>
		</div>
	</div>

	<footer>
       
	</footer>
	

	
<!--===============================================================================================-->
	<script src="js/jquery.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
     <script type="text/javascript">
    $(document).ready(function() {


	  $("#submit").on("click", function(e) {
	    e.preventDefault()

	   var admin  =  $("#admin").val()
	   var password  =  $("#password").val()

	   if (admin == "") {
	   	alert("please input a  username")
	   } else if(password == "") {
	   alert("password field is empty")
	   } else {
	   	$.ajax({
	   		url: "admin_controller.php",
	   		type: "POST",
	   	 //   dataType: "JSON",
		    data: "admin="+admin+"&password="+password,
	   		error: function () {
	   		alert("an error ocurred while trying to connect to the internet try again")
	   		},
	   		success: function (data) {
	         if (data == "false_user") {
	         	alert("this user is not registered as an admin ")
	         } else if (data == "false_password") {
	            alert("invalid password check and try again thanks")
	         } else {
	         	 location.replace("dashboard_admin.php")
	         }
	   		}
	   	})
	   }

	})


})
     </script>
</body>
</html>