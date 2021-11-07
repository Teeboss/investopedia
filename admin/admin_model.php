<?php

  
 // include("../model/DB.php");
 include("../model/controller.php");
 include("../model/DB.php");

 class ADMIN extends api {





   
   public static function add_admin($username , $password , $type) {

   	if (!DB::query('SELECT username FROM admin WHERE username = :username ' , array(':username'=>$username))) {
   		if (strlen($password) > 6 ) {
   			DB::query('INSERT INTO admin VALUES (\'\' , :username ,:password , :type)' , array(':username'=>"ADMIN-".$username , ':password'=>password_hash($password, PASSWORD_DEFAULT) , ':type'=>$type));
   			echo "yeske";
   		} else {
   		echo "password_short"; 		
   		}
   	} else {
   		echo  "username_taken";
   	}
     }














 }



?>