
  <!-- bootstrap datepicker -->
  <link href="./public/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" tyoe="text/css" />


  <div class="modal fade" id="symodal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-aqua-active">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">ECCD Report - Development Center List</h4>
        </div>

        <form id="syform" role="form" action="./eccdreport.php" target="_blank" data-toggle="validator" method="get" accept-charset="utf-8" enctype="multipart/form-data" autocomplete="off">
          <div class="modal-body">
            <div class="form-group">
                <label for="sy">School Year</label>
                <select name="sy" class="form-control">
                  <option value="" disabled selected>Select sy...</option>
                  <?php for($y = date("Y"); $y >= 2015; $y--) : $x = $y + 1; ?>
                    <?= '<option value="' . $y . '-' . $x . '">' . $y . '-' . $x . '</option>' ?>
                  <?php endfor; ?>
                </select>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="reptype" value="cdclisting" />
            <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-flat">GENERATE REPORT</button>
          </div>
        </form>

      </div>
    </div>
  </div>


  <div class="modal fade" id="cdcmodal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-aqua-active">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">ECCD Report - Development Center Info</h4>
        </div>

        <form id="cdcform" role="form" action="./eccdreport.php" target="_blank" data-toggle="validator" method="get" accept-charset="utf-8" enctype="multipart/form-data" autocomplete="off">
          <div class="modal-body">
            <div class="form-group">
                <label for="cdc">Development Center</label>
                <select name="cdc" class="form-control">
                  <option value="" disabled selected>Select center...</option>
                  <?php $legend = ""; foreach($centers AS $c) :
                    if($legend == "") {
                      $legend = $c["cdc_brgy"];
                      echo '<optgroup label="' . $legend . '">';
                    } else {
                      if($legend <> $c["cdc_brgy"]) {
                        echo '</optgroup>';
                        $legend = $c["cdc_brgy"];
                        echo '<optgroup label="' . $legend . '">';
                      }
                    }
                  ?>
                    <?= '<option value="' . $c["cdc_id"] . '">' . $c["centername"] . '</option>' ?>
                  <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="sy">School Year</label>
                <select name="sy" class="form-control">
                  <option value="" disabled selected>Select sy...</option>
                  <?php for($y = date("Y"); $y >= 2015; $y--) : $x = $y + 1; ?>
                    <?= '<option value="' . $y . '-' . $x . '">' . $y . '-' . $x . '</option>' ?>
                  <?php endfor; ?>
                </select>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="reptype" value="cdcinfo" />
            <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-flat">GENERATE REPORT</button>
          </div>
        </form>

      </div>
    </div>
  </div>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        ECCD
        <small>Report</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>E-AMS Panabo</a></li>
        <li class="active">Applicant</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              <i class="fa fa-pie-chart"></i>

              <h3 class="box-title">Report</h3>
            </div>
            <div class="box-body">
              <p>Various types of report generation are available. For the mean time these are the available report generation feature you can use:</p>
              <div class="row">
                <div class="col-md-3">
                  <a href="#" data-toggle="modal" data-target="#symodal" class="btn btn-app btn-block">
                    <i class="fa fa-clone"></i> Development Center Listing Report
                  </a>
                </div>
                <div class="col-md-3">
                  <a href="#" data-toggle="modal" data-target="#cdcmodal" class="btn btn-app btn-block">
                    <i class="fa fa-home"></i> Development Center Specific Report
                  </a>
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

  <script src="./public/AdminLTE/plugins/webcamjs/webcam.min.js"></script>

  <!-- bootstrap datepicker -->
  <script src="./public/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

 <!-- javascripts here -->
	<script>
  $(function () {



  });
	</script>

  <script>
  $(function () {





  });
  </script>


  <?php
	// render footer 2
	require("./templates/layouts/footer_end.php");
  ?>
