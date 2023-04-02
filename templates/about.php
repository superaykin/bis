<!-- DataTables -->
<link rel="stylesheet" href="./public/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">



<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        System Information
        <!-- <small>Monitoring</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="./"><i class="fa fa-dashboard"></i> BIS</a></li>
        <li class="active">SysInfo</li>
      </ol>
    </section>

    <div class="pad margin no-print">
      <div class="callout callout-info" style="margin-bottom: 0!important;">
        <h4><i class="fa fa-info"></i> Note:</h4>
        This system is the enhanced version of the Child Center Management System (CCMS).
      </div>
    </div>

    <!-- Main content -->
    <section class="invoice">

      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Barangay Information System
            <small class="pull-right">Version: 1</small>
          </h2>
        </div>
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <span>
            Butangi diri char2x sa inyuhang system hahahahaha
          </span>
        </div>
      </div>

      <hr/>

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          <p class="lead">System Modules</p>
        </div>
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th width="20%">Module</th>
                <th>Description</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Profiling</td>
                <td>Allows the system user to manage each encoded information efficiently. The users will have control of the management and viewing of history for a specific profile.</td>
              </tr>
              <tr>
                <td>Center</td>
                <td>This module is the additional module of this version. This allow the user to manange development center teachers and classes. The classes is another feature added into the system
                which will allow the cdc teacher to manage the ECCD and nutritional scores of each child.</td>
              </tr>
              <tr>
                <td>Report Generation</td>
                <td>This module allows the system users to generate various reports such as ECCD scores, and many more.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>







    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>

  <?php
	// render footer
    require("./templates/layouts/footer.php");
  ?>

  <script src="./public/AdminLTE/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
  <script src="./public/AdminLTE/bower_components/Chart.js/Chart.js"></script>
  <!-- DataTables -->
  <script src="./public/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="./public/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <!-- javascripts here -->
  <script>
  $(function () {

    $('#cdcbrgytable').DataTable({
      "order": [[ 0, "asc" ]]
    });

  });

  </script>

  <?php
	// render footer 2
	require("./templates/layouts/footer_end.php");
  ?>
