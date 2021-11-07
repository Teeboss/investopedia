
   $(document).ready(function() {


$("#login").submit(function(e) {
    e.preventDefault()

   var newuser  =  $("#username").val()
   var password  =  $("#password").val()

   if (newuser == "") {
   	$("#n_error").html("username must be add to continue")
   } else if(password == "") {
   	$("#p_error").html(" insert password for this admin  to continue")
   	$("#n_error").html("")
   } else {
   	$.ajax({
   		url: "../admin_controller.php",
   		type: "POST",
   		datatype: "JSON",
   		data: new FormData(this),
   		error: function () {
   			alert("could not connect to the internet  check your connections ")
   		},
   		success: function (data) {
         alert(data)
   		}
   	})
   }

})





})