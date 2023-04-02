<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>BIS</title>
  <!-- Favicon-->
  <link rel="icon" href=".\public\images\bis.png" type="image/x-icon">
  <meta http-equiv="refresh" content="1200">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="./public/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./public/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="./public/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./public/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- Custom style -->
  <link rel="stylesheet" href="./public/AdminLTE/dist/css/custom.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="./public/AdminLTE/dist/css/skins/_all-skins.min.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="./public/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- Sweet Alert -->
  <link rel="stylesheet" href="./public/AdminLTE/plugins/sweetalert/sweetalert2.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition fixed skin-yellow-light sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>BIS</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>BIS</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <?php if(isset($_SESSION["bis"])) : ?>
            <!-- Messages: style can be found in dropdown.less-->
            <?php
            // $trans_req = get_transfer_request();
            // $rc = count($trans_req);
            ?>




          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- <img src="./AdminLTE/dist/img/user-avatar-trans.png" class="user-image" alt="User Image"> -->
	             <i class="fa fa-user"></i>
              <span class="hidden-xs">
      				      <?php echo strtoupper($_SESSION["bis"]["fullname"]); ?>
      			  </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="./public/AdminLTE/dist/img/user-avatar-trans.png" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION["bis"]["fullname"]; ?>
                  <small><?php echo $_SESSION["bis"]["userdesc"]; ?></small>
                </p>
              </li>


              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4">
                    <p>Server:</p>
                  </div>
                  <div class="col-xs-8">
                    <?php if($_SERVER["HTTP_HOST"] == "localhost") : ?>
                      <span class="text-red">LOCAL HOST</span>
                    <?php else : ?>
                      <span class="text-aqua">PRODUCTION</span>
                    <?php endif; ?>
                  </div>
                </div>
                <!-- /.row -->
                <div class="row">
                  <div class="col-xs-4">
                    <p>Account:</p>
                  </div>
                  <div class="col-xs-8">
                    <span class="text-green">ACTIVE</span>
                  </div>
                </div>
              </li>


              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="system.php?page=account&id=<?= $GLOBALS["_uid"] ?>" class="btn btn-default btn-flat">Account</a>
                </div>
                <div class="pull-right">
                  <a href="./logout.php" class="btn btn-primary btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
		  <?php else : ?>
		  <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!--<img src="./AdminLTE/dist/img/user-avatar-trans.png" class="user-image" alt="User Image">-->
			  <i class="fa fa-user"></i>
              <span class="hidden-xs">Welcome Guest!</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="./AdminLTE/dist/img/no-avatar.png" class="img-circle" alt="User Image">
                <p>
                  Please sign in to access other app features.
                </p>
              </li>

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="./login.php" class="btn btn-primary btn-flat">Sign In</a>
                </div>
              </li>
            </ul>
          </li>
		  <?php endif; ?>
          <li>
            <!--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a> -->
          </li>
        </ul>
      </div>
    </nav>


  </header>
