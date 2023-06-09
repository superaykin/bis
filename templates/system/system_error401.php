
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
        <li><a href="#"><i class="fa fa-dashboard"></i>BIS</a></li>
        <li class="active">System</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="error-page">
        <h1 class="headline text-red">401</h1>

        <div class="error-content">
          <h2><i class="fa fa-warning text-red"></i> Invalid or Unauthorized access.</h2>

          <p>
            Seems like you have accessed an invalid link or function. Please contact the system administrator for this matter.
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
