<!-- DataTables -->
<link rel="stylesheet" href="./public/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">



<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <!-- <small>Monitoring</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="./"><i class="fa fa-dashboard"></i> BIS</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">

      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?= $entitycount ?></h3>

              <p>Profile</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="./entity.php?page=list" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>0</h3>

              <p>------</p>
            </div>
            <div class="icon">
              <i class="fa fa-home"></i>
            </div>
            <a href="center.php?page=list" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>0</h3>

              <p>------</p>
            </div>
            <div class="icon">
              <i class="fa fa-list-alt"></i>
            </div>
            <a href="./class.php?page=list" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>0</h3>

              <p>-------</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->


      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Latest Profile Entries</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <div class="btn-group">
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table id="" class="table table-striped table-hover">
                <thead>
                  <th>Lastname</th>
                  <th>Firstname</th>
                  <th>Middlename</th>
                  <th>Date of Birth</th>
                  <th>Sex</th>
                  <th>Date registered</th>
                </thead>
                <tbody>
                  <?php foreach($latestprofiles AS $p) :
                    if($p["sex"] == "MALE") {
                      $sex = '<span class="label label-info">' . $p["sex"] . '</span>';
                    } else {
                      $sex = '<span class="label label-danger">' . $p["sex"] . '</span>';
                    }
                    ?>
                    <?= '<tr>' ?>
                      <?= '<td>' . $p["lastname"] . '</td>' ?>
                      <?= '<td>' . $p["firstname"] . ' ' . $p["suffix"] . '</td>' ?>
                      <?= '<td>' . $p["middlename"] . '</td>' ?>
                      <?= '<td>' . $p["birthdate"] . '</td>' ?>
                      <?= '<td>' . $sex . '</td>' ?>
                      <?= '<td>' . $p["registered"] . '</td>' ?>
                    <?= '</tr>' ?>
                  <?php endforeach; ?>
                </tbody>
              </table>

            </div>

            <div class="box-footer">
              <div class="row">
                <div class="col-md-3">
                  <a href="./entity.php?page=registration" class="btn btn-flat btn-block btn-sm btn-default">Add new entry</a>
                </div>
                <div class="col-md-3 pull-right">
                  <a href="./entity.php?page=list" class="btn btn-flat btn-block btn-sm btn-info">View all profile</a>
                </div>
              </div>
            </div>
          </div>
        </div>




      </div>




    </section>
    <!-- /.content -->
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
