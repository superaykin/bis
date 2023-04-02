<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>BIS | Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="./public/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./public/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="./public/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
  <!-- SweetAlert -->
  <link rel="stylesheet" href="./public/AdminLTE/plugins/sweetalert/sweetalert2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./public/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="./public/AdminLTE/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->


</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="./"><b>Brgy InfoSys</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form id="loginForm" method="post">
  		<div class="form-group has-feedback">
  			<input type="text" class="form-control" placeholder="Username" name="username" required="required" autofocus="on">
  			<span class="glyphicon glyphicon-user form-control-feedback"></span>
  		</div>
  		<div class="form-group has-feedback">
  			<input type="password" class="form-control" placeholder="Password" name="password" required="required">
  			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
  		</div>
  		<div class="row">
  			<div class="col-xs-8">
  				<div class="checkbox icheck">

  				</div>
  			</div>
  			<!-- /.col -->
  			<div class="col-xs-12">
  			  <button type="submit" class="btn btn-primary btn-block btn-flat" id="submitButton">Sign In</button>
  			</div>
  			<!-- /.col -->
  		</div>
    </form>


  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="./public/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="./public/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="./public/AdminLTE/plugins/iCheck/icheck.min.js"></script>
<!-- SweetAlert -->
<script src="./public/AdminLTE/plugins/sweetalert/sweetalert2.min.js"></script>
<script>
  $(function () {
    // Get the form.
			$('#loginForm').submit(function(e) {
			  e.preventDefault();
			  swal({title: "Please wait...", imageUrl: "./public/images/loader/green-loader.gif", showConfirmButton: false});

			  $.ajax({
				type: 'post',
				url: './ajax/system/login.php',
				data: $('#loginForm').serialize(),
				success: function (results) {
					swal.close();
					console.log(results);
					if(results === "usernotfound") {
						swal("Sorry!", "Username not found!", "error");
					}
					else if(results === "invalidpassword") {
						swal("Sorry!", "Password is incorrect!", "error");
					}
					else if(results === "accessgranted") {
						swal({
              title: "Login Success",
              text: "Welcome back, have a nice day!",
              type:"success"
            }).then(function() {
              // Redirect the user
              window.location.replace('./');
            });
					}
					else if(results === "notenoughprivilege") {
						swal({title: "Not enough privilege!",   text: "Account has not enough privilege to continue. Please contact your system administrator.", type:"info"});
					}
          else if(results === "invalidaccount") {
						swal({title: "Account Invalid",   text: "Account details provided is invalid. Please check the details and try again.", type:"error"});
					}
					else {
						swal("Sorry!", results, "error");
					}
				},
				error: function(results) {
					console.log(results);
					swal("Error!", "Unexpected error occur!", "error");
				}
			  });

			});
  });
</script>
</body>
</html>
