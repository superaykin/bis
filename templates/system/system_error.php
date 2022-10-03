
<!-- DataTables -->
<link rel="stylesheet" href="./public/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">



<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        System
        <small>Error</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>eCMS</a></li>
        <li class="active">System</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="error-page">
        <h1 class="headline text-red"><i class="fa fa-frown-o"></i></h1>

        <div class="error-content">
          <h2><i class="fa fa-warning text-red"></i> Oopss! Something went wrong.</h2>

          <p>
            The system detected some irregularities with the commands. Please try again.
            <br/>
            <br/>
            Meanwhile, you may <a href="./">return to dashboard</a> to access other features.
          </p>

        </div>
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
  </div>

  <?php
	// render footer
    require("./templates/layouts/footer.php");
  ?>
  <!-- DataTables -->
	<script src="./public/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="./public/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

  <?php
	// render footer 2
	require("./templates/layouts/footer_end.php");
  ?>
