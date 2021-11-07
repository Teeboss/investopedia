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
              <h4><i class="fa fa-angle-right"></i>Lastest: DEPOSITS</h4>
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
                 <div id="loader">

                    <?php
                    $piids = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                    $depositusers =  DB::query("SELECT * FROM deposit  ORDER BY id DESC LIMIT 5 " ,  array());
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
                    <button><a href="deposit_history.php?page=1&item=10">CLICK TO VIEW ALL DEPOSIT</a></button>
              </section>
            </div>
            <!-- /content-panel -->
          </div>
          <!-- /col-lg-4 -->
        </div>
        <!-- /row -->
        <div class="row mt">
          <div class="col-lg-12">
            <div class="content-panel">
              <h4><i class="fa fa-angle-right"></i> Latest: INVESTMENTS</h4>
              <section id="no-more-tables">
                <table class="table table-bordered table-striped table-condensed cf">
                  <thead class="cf">
                    <tr>
                      <th>username</th>
                      <th>first name</th>
                      <th class="numeric">Amount</th>
                      <th class="numeric">investment Date</th>
                      <th class="numeric">ROI</th>
                      <th class="numeric">status</th>
                      <th class="numeric">CANCEL</th>
                      <th class="numeric">EDIT</th>
                    </tr>
                  </thead>
                  <tbody>   

                    <?php
                    
                    $piids = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                  $investments =  DB::query('SELECT * FROM investment_history  ORDER BY id DESC LIMIT 10 ' ,  array());
                    foreach ($investments as $invt) {
                      $user_id = $invt['userid'];
                      $uname = DB::query('SELECT username FROM users WHERE id = :user_id' , array(':user_id'=>$user_id))[0]['username'];
                      $fname = DB::query('SELECT first_name FROM users WHERE id = :user_id' , array(':user_id'=>$user_id))[0]['first_name'];
                      $piids = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $piid = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $pii = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $pi = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $uss = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $form_id = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $showmi = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $amount_default = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $close = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $status_default = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $status_id = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $amount_id = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $p = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      $po  = str_shuffle(time()."tieruierjvbnfndfjdfkjkdf");
                      echo "
                    <tr>
                      <p id ='".$pi."' style = 'display:none;'>".$user_id."</p>
                      <td class='numeric'>".$uname."</td>
                      <td class='numeric'>".$fname."</td>
                      <td class='numeric' id='".$amount_id."'>".$invt['amount']."</td>
                      <td class='numeric'>".$invt['investment_date']."</td>
                      <td class='numeric'>".$invt['ROI']."</td>
                      <td class='numeric' id='".$piid."'>".$invt['status']."</td>
                      <td class='numeric'><button id='".$piids."' value = '".$invt['id']."' onclick = 'javascript: var s = document.getElementById(\"".$piid."\"); var invt_id = this.value; var userid = document.getElementById(\"".$pi."\").innerHTML; $.ajax({ url : \"admin_controller.php\" , type : \"POST\" , data: {invt_id:invt_id , userid:userid } , success : function (response) {s.innerHTML = response;} })'> cancel </button></td>
                      <td class='numeric'><button id='".$p."' onclick = 'javascript: document.getElementById(\"".$po."\").style.display = \"block\";'>EDIT INVESTMENT</button></td>
                    </tr>  
                        





                    <div id='".$po."' class='modal'>
                          <span  id= '".$showmi."'></span>
                      <div class='modal-content'>
                            <button class='close' id='".$close."' onclick='javascript: var closer = document.getElementById(\"".$showmi."\").parentElement;  closer.style.display = \"none\"; '>&times;</button>
                          <div id='ver' class='show_div placer'>
                           <input id='".$uss."' name ='iuss' style= 'display:none;'>
                         <label style = 'color: white;'>AMOUNT</label>
                          <input id='".$amount_default."' name='amount' type='text' >

                         <label style = 'color: white;'>STATUS</label>
                          <input id='".$status_default."' name='status' type='text' ><br><br>

                          <button id='".$form_id."' value='".$invt['id']."' name = 'investment_button' onclick='javascript: var datas = this.value; var amount = document.getElementById(\"".$amount_default."\").value; var status = document.getElementById(\"".$status_default."\").value ; $.ajax({url: \"admin_controller.php\" , type : \"POST\", data : {datas:datas , amount:amount , status:status } , success: function(data) {alert(\"the record has been updated\"); document.getElementById(\"".$showmi."\").parentElement.style.display = \"none\"; document.getElementById(\"".$amount_id."\").innerHTML = amount; document.getElementById(\"".$piid."\").innerHTML = status;  } })'>UPDATE THIS VALUE</button>
                           <script>
                            document.getElementById(\"".$uss."\").defaultValue = \"".$invt['id']."\"
                            document.getElementById(\"".$amount_default."\").defaultValue = \"".$invt['amount']."\"
                            document.getElementById(\"".$status_default."\").defaultValue = \"".$invt['status']."\"
                           </script>   
                      </div>
                    </div>

                  </div>

                      ";  
                    }
                 
                    ?>                 
                   
                  </tbody>
                </table>
                    <button><a href="investment_history.php?page=1&item=10">CLICK TO VIEW ALL INVESTMENT</a></button>
              </section>
            </div>
            <!-- /content-panel -->
          </div>
          <!-- /col-lg-12 -->
        </div>


               
        <div class="row mt">
          <div class="col-lg-12">
            <div class="content-panel">
              <h4><i class="fa fa-angle-right"></i>UPDATE THE PLANS </h4>
              <h5><i class="fa fa-angle-right"></i>make sure this value is the weekly value</h5>
              <section >
                <input type="number" name="investment">
                <select id="plans">
                  <option value="PRO">PRO</option>
                  <option value="BUS">BUSINESS</option>
                </select><br><br>
                  <button onclick=" javascript: var see = document.getElementById('plans').value; $.ajax({url :'admin_controller.php' , type: 'POST' , data: {see: see } , success : (data) => {alert(data);} }); ">update this value</button>
              </section>
            </div>
            <!-- /content-panel -->
          </div>
          <!-- /col-lg-4 -->
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


      })



    



        // Get the modal
              var modal = document.getElementById(<?php $po; ?>);

              // Get the button that opens the modal

              // Get the <span> element that closes the modal
              var spans = document.getElementsByClassName("close")[0];
              var span = document.getElementById(<?php echo $close; ?>)[0];

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
    </script>
  <script src="lib/common-scripts.js"></script>
  <!--script for this page-->
</body>

</html>
