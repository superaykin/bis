
<!-- DataTables -->
<link rel="stylesheet" href="./public/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Class
        <small>Listing</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>eCMS Panabo</a></li>
        <li class="active">Class</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
    		<div class="col-xs-12">
    			<div class="box box-widget">
    				<div class="box-header with-border bg-primary">

    				</div>
    				<!-- /.box-header -->
    				<div class="box-body">
              <div class="table-responsive">

                  <table id="classlist" class="table table-bordered table-hover">
        						<thead>
        							<tr>
                        <th>Center</th>
                        <th>Teacher</th>
                        <th>Class Code</th>
                        <th>Description</th>
                        <th>School Year</th>
                        <th></th>
        							</tr>
        						</thead>
        						<tbody>
                      <?php foreach($class AS $c) : ?>
                        <?= '<tr>' ?>
                          <?= '<td>' . $c["centername"] . '</td>' ?>
                          <?= '<td>' . $c["t_name"] . '</td>' ?>
                          <?= '<td>' . $c["class_name"] . '</td>' ?>
                          <?= '<td>' . $c["class_desc"] . '</td>' ?>
                          <?= '<td>' . $c["schoolyear"] . '</td>' ?>
                          <?= '<td><a href="./class.php?page=info&id=' . $c["cid"] . '" class="btn btn-xs btn-flat btn-block btn-primary">View</a></td>' ?>
                        <?= '</tr>' ?>
                      <?php endforeach; ?>
        						</tbody>
        					</table>
                </div>
      				</div>
      			</div>
      		</div>
       </div>

    <div class="row">
      <!-- BUTTONS AND CONTROLS AREA -->
      <div class="col-xs-3">
        <a href="./class.php?page=new" class="btn btn-flat btn-info btn-sm btn-block"><i class="fa fa-pencil"></i> ADD NEW ENTRY</a>
      </div>
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

    $('#classlist').DataTable({
      "order": [[ 4, "desc" ]]
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
