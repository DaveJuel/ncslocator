<?php
//login checking
$key = new user();
$business_key=new business;
$login_status = $key -> checkLogin();
if ($login_status != TRUE) {
	header("location:login.php");
}
?>
<!--THIS IS THE MAIN LAYOUT OF THE APPLICATION -->
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo $title ?></title>

  <!-- Bootstrap core CSS -->

  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="../css/animate.min.css" rel="stylesheet">
  <!-- Custom styling plus plugins -->
  <link href="../css/custom.css" rel="stylesheet">
  <script src="../js/jquery-2.2.1.min.js"></script>
  <script src="../js/nprogress.js"></script>
  <!--GOOGLE MAPS API-->  
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC3JHAgJE4WjO9aYZgJE0gdalCNnXtmSg&v=3.exp&sensor=false&callback=initialize"></script>

  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>
<body class="nav-md">

  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

          <?php
		include ("../content/header.php");
 ?>
          <!-- /menu prile quick info -->

          <br />

          <!-- sidebar menu -->
          <?php
		include ("../content/nav_bar.php");
  ?>         
          <!-- /sidebar menu -->          
        </div>
      </div>

      <!-- top navigation -->
      <?php
	include ("../content/head_bar.php");
 ?>
      <!-- /top navigation -->      
      <!-- page content -->
      <div class="right_col" role="main">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <?php echo $content; ?>
          </div>
        </div>
       
      </div>
      <!-- /page content -->

      <!-- footer content -->
      <footer>
      	<?php
		include ("../content/footer.php");
 ?>        
      </footer>
      <!-- /footer content -->
    </div>
  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>
  <script src="../js/bootstrap.min.js"></script>  
  <!-- bootstrap progress js --> 
  <!-- chart js -->
   <script src="../js/custom.js"></script>
   <script src="../js/main.js"></script>
  <!-- flot js --> 
  <!-- /datepicker -->
  <!-- /footer content -->
</body>
</html>