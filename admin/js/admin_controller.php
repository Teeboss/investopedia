<?php
 include("admin_model.php");
  if (isset($_POST['username'])) {
  	$username = $_POST['username'];
  	$password = $_POST['password'];
  	$type = $_POST['type'];
     
     ADMIN::add_admin($username , $password ,$type);

  }



?>