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
      <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> VIEW ALL USERS </h3>
        <div class="row mt">
          <div class="col-lg-12">
            <div class="content-panel">
              <h4><i class="fa fa-angle-right"></i>INVESTMENTS</h4>
              <section id="unseen">
                <table class="table table-bordered table-striped table-condensed">
                  <thead>
                    <tr>
                      <th>username</th>
                      <th>first name</th>
                      <th class="numeric">Amount</th>
                      <th class="numeric">investment Date</th>
                      <th class="numeric">ROI</th>
                      <th class="numeric">status</th>
                      <th class="numeric">CANCEL</th>
                    </tr>
                  </thead>
                  <tbody>
                 <div id="loader">

                    <?php

                  /*---------  pagination logic   ------ */

                  function timeline ($to , $nums) {

                   if ($to <= $nums)
                    return $to;
                   else
                     return $nums;
                  }
                  $page= $_GET['page'];
                  $item = $_GET['item'];

                  $pagination_from = $item * $page - ($item - 1);
                  $pagination_to = $item * $page;

                    
                   /* ---------- pagination logic ends here -----------*/

                    $piids = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                    $items =  DB::query("SELECT * FROM investment_history   ORDER BY id DESC LIMIT $item" ,  array());
                    $nums = count($items);
                    $count = $pagination_from;
                    $total = ceil($nums/$item);
                     foreach ($items as $depo) {
                       # code...
                      $user_id = $depo['userid'];
                      $uname = DB::query('SELECT username FROM users WHERE id = :user_id' , array(':user_id'=>$user_id))[0]['username'];
                      $fname = DB::query('SELECT first_name FROM users WHERE id = :user_id' , array(':user_id'=>$user_id))[0]['first_name'];
                      $piids = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $piid = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $pii = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $pi = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                       $p = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $po  = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      echo "
                    <tr>
                      <p id ='".$pi."' style = 'display:none;'>".$user_id."</p>
                      <td class='numeric'>".$uname."</td>
                      <td class='numeric'>".$fname."</td>
                      <td class='numeric'>".$depo['amount']."</td>
                      <td class='numeric'>".$depo['ROI']."</td>
                      <td class='numeric'>".$depo['investment_date']."</td>
                      <td class='numeric' id='".$piid."'>".$depo['status']."</td>
                      <td class='numeric'><button id='".$piids."' value = '".$depo['id']."' onclick = 'javascript: var s = document.getElementById(\"".$piid."\"); var invt_id = this.value; var userid = document.getElementById(\"".$pi."\").innerHTML; $.ajax({ url : \"admin_controller.php\" , type : \"POST\" , data: {invt_id:invt_id , userid:userid } , success : function (response) {s.innerHTML = response;} })'> cancel </button></td>
                      <td class='numeric'><button id='".$p."' onclick = 'javascript: document.getElementById(\"".$po."\").style.display = \"block\";'>EDIT INVESTMENT</button></td>
                    </tr>  
                      ";
                     }

                    ?>
                   </div>
                  </tbody>
                </table>
                <?php

                  
                  if ($pagination_from == 1) {
                    $pagination_from = $page + 1;
                      echo "<div class ='pagination w-75 p-3'><a href='investment_history.php?item=10&page=".$pagination_from."'><button class = 'next_button'>Next</button></a></div>"." ";
                     }  if ($pagination_from <  $nums) {
                    $pagination_from = $page + 1;
                    $mfrom = $page - 1;
                      echo "<div class='pagination w-75 p-3'><a href='investment_history.php?item=10&page=".$mfrom."'><button class = 'next_button'>Previous</button></a>"." "."<a href='investment_history.php?item=10&page=".$pagination_from."'><button class = 'next_button'>Next</button></a></div>"." " ;
                     } else  {
                     $mfrom = $page - 1;
                     echo  "<div class='pagination w-75 p-3'><a href='investment_history.php?item=10&page=".$mfrom."'><button class = 'next_button'>Previous</button></a></div>" ;
                     } 

                 
                ?>
              </section>
            </div>
            <!-- /content-panel -->
          </div>
          <!-- /col-lg-4 -->
        </div>
        <!-- /row -->
        
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
   <script type="text/javascript">
     $(document).ready(function (){


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




     document.getElementById("more").addEventListener("click" , function() {
        var log = $("#more").html()
        $("#loader").load("admin_controller.php" , {loadi : log })
      
      })
     })
    </script>
  <script src="lib/common-scripts.js"></script>
  <!--script for this page-->
</body>

</html>
