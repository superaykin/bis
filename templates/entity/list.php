
<!-- DataTables -->
<link rel="stylesheet" href="./public/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile
        <small>Listing</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>BIS Panabo</a></li>
        <li class="active">Profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-male"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">MALE</span>
              <span class="info-box-number"><?= $sexcount[0]["male"] ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-maroon color-pallete">
            <span class="info-box-icon"><i class="fa fa-female"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">FEMALE</span>
              <span class="info-box-number"><?= $sexcount[0]["female"] ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-male"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">IPS</span>
              <span class="info-box-number"><?= $ipscount ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-male"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">4PS</span>
              <span class="info-box-number"><?= $fourpscount ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      </div>

      <div class="row">
    		<div class="col-xs-12">
    			<div class="box box-widget">
    				<div class="box-header with-border bg-primary">

    				</div>
    				<!-- /.box-header -->
    				<div class="box-body">
              <div class="table-responsive">

                  <table id="entitytable" class="table table-bordered table-hover">
        						<thead>
        							<tr>
                        <th>Lastname</th>
                        <th>Firstname</th>
                        <th>Middlename</th>
                        <th>Suffix</th>
        								<th>Sex</th>
                        <th>Birthdate</th>
                        <th></th>
        							</tr>
        						</thead>
        						<tbody>
        						</tbody>
        					</table>
                </div>


      				</div>
      			</div>
      		</div>
	  </div>

    <div class="row">
      <!-- BUTTONS AND CONTROLS AREA -->
      <?php if(lookup_role('ENTITY_USER') == true OR lookup_role('ENTITY_ADMIN') == true) : ?>
        <div class="col-xs-3">
          <a href="./entity.php?page=registration" class="btn btn-flat btn-info btn-sm btn-block"><i class="fa fa-pencil"></i> ADD NEW ENTRY</a>
        </div>
      <?php endif; ?>
    </div>


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

 <!-- javascripts here -->
	<script>
  $(function () {



  });
	</script>

  <script>
  $(function () {

    $('#entitytable').DataTable({
      "processing": true,
      "serverSide": true,
      "deferRender": true,
      "ajax": "./ajax/entity/getlist.php",
      "order": [[ 0, "asc" ]]
    });

    // Get the form.
	   $('#addform').submit(function(e) {

      e.preventDefault();
      swal({
        title: prompttitle,
        text: promptmessage,
        type: 'info',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            type: 'post',
            url: './ajax/applicant/add_new_applicant.php',
            data: $('#addform').serialize(),
            success: function (results) {
      				swal.close();
              var o = jQuery.parseJSON(results);
      				if(o.result === "success") {
                swal({title: "Submit success",
                  text: "Record has been successfully saved.",
                  type:"success"})
                .then(function () {
                  //window.location.replace('./applicant.php?page=list');
                  window.location.replace('./applicant.php?page=profile&id=' + o.applicantid);
                });
      				}
              else if(o.result === "alreadyexist") {
                swal({
                  title: "Error!",
                  text: "This applicant info is already in our database!",
                  type:"error"
                });
              }
              else {
                swal({
                  title: "Error!",
                  text: "Sorry! Something is wrong with the submission of data!",
                  type:"error"
                });
                console.log(results);
              }
            },
      			error: function(results) {
      				console.log(results);
      				swal("Error!", "Unexpected error occur!", "error");
      			}
          });
          // --- end of ajax
        }
      });
    });






  });
  </script>


  <?php
	// render footer 2
	require("./templates/layouts/footer_end.php");
  ?>
