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
            <a href="#">
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
        <h3><i class="fa fa-angle-right"></i> VIEW ALL USERS </h3>
        <input type="text" class="input-find" placeholder="quick search users with thier unique username" id="search" value="" name="search" autocomplete="off" >

        <div id="result" class="result"></div>
        <div class="clearfix"></div>
          <br><br>
        <div class="row mt">
          <div class="col-lg-12">
            <div class="content-panel">
              <h4><i class="fa fa-angle-right"></i>Quick Reference</h4>
              <section id="unseen">
                <table class="table table-bordered table-striped table-condensed">
                  <thead>
                    <tr>
                      <th>username</th>
                      <th>first name</th>
                      <th class="numeric">Last name</th>
                      <th class="numeric">email</th>
                      <th class="numeric">phone</th>
                      <th class="numeric">status</th>
                      <th class="numeric">view user</th>
                    </tr>
                  </thead>
                  <tbody>
              <?php
               $users = DB::query('SELECT * FROM users', array());
               foreach ($users as $user) {
               echo "
                 <tr>
                 <td class = 'numeric'>".$user['username']."</td>
                 <td class = 'numeric'>".$user['first_name']."</td>
                 <td class = 'numeric'>".$user['last_name']."</td>
                 <td class = 'numeric'>".$user['email']."</td>
                 <td class = 'numeric'>".$user['phone']."</td>
                 <td class = 'numeric'>".$user['status']."</td>
                 <td class = 'numeric'><button title = 'click to view more about this user'><a  href='view_user.php?userid=".$user['id']."'> view user</a></button></td>                 
                 </tr>
               ";  
               }
              ?>
               </tbody>
              </table>
              </section>
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
            <script src="js/jquery.js"></script>

          Created with Dashio template by <a href="https://templatemag.com/">TemplateMag</a>
        </div>
        <a href="responsive_table.html#" class="go-top">
          <i class="fa fa-angle-up"></i>
          </a>
      </div>
    </footer>
    <script type="text/javascript">
     $("#search").keyup(function(){
      var c = $("#search").val()
      if (c != "") {
        $.ajax({
          url: "admin_controller.php",
          type: "POST",
          data: {c : c},
          success: function (data) {
            $("#result").html(data).show()
          } 
        })
      } else {
      $("#result").html("").hide()    
      }
     })



    </script>
    <!--footer end-->
  </section>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="lib/jquery.scrollTo.min.js"></script>
  <script src="lib/jquery.nicescroll.js" type="text/javascript"></script>
  <!--common script for all pages-->
  <script src="lib/common-scripts.js"></script>
  <!--script for this page-->
</body>

</html>
