
<!-- DataTables -->
<link rel="stylesheet" href="./public/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">



<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        System
        <small>Location</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>BIS</a></li>
        <li class="active">System</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-8">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">List</h3>
            </div>
            <div class="box-body">
              <table id="addresstable" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                  <th>Value</th>
                  <th>Type</th>
                  <th>Parent</th>
                  <th>Remarks</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                  <?php foreach($locations AS $loc) : ?>
                    <?= '<tr>' ?>
                      <?= '<td>' . $loc["add_value"] . '</td>' ?>
                      <?= '<td>' . $loc["add_type"] . '</td>' ?>
                      <?= '<td>' . $loc["add_parent"] . '</td>' ?>
                      <?= '<td>' . $loc["add_remarks"] . '</td>' ?>
                      <?= '<td><a href="" class="btn btn-xs btn-flat btn-info">View</a></td>' ?>
                    <?= '</tr>' ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">New Location</h3>
            </div>

            <form id="addlocationform" method="post" autocomplete="off">
              <div class="box-body">
                <div class="form-group">
                  <label>Value</label>
                  <input type="text" class="form-control" name="addvalue" required />
                </div>
                <div class="form-group">
                  <label>Type</label>
                  <select name="loctype" id="loctype" class="form-control" required>
                    <option value="" selected disabled>Select type...</option>
                    <option value="BRGY">BARANGAY</option>
                    <option value="CITY">CITY</option>
                    <option value="MUN">MUNICIPALITY</option>
                    <option value="PROV">PROVINCE</option>
                  </select>
                </div>
                <div id="parentdiv" class="form-group">
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-flat btn-info btn-block">Submit</button>
              </div>
            </form>


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
  <!-- DataTables -->
	<script src="./public/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="./public/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


 <!-- javascripts here -->

	<script>
	  $(function () {

      $('#addresstable').DataTable();


      $(document).on('change','#loctype',function() {
        var loctype = $('#loctype').val();
        $.ajax({
            type: 'post',
            url: './ajax/system/get_location_parent.php',
            data: { "loctype" : loctype },
            success: function (results) {
              document.getElementById('parentdiv').innerHTML = results;
            },
           error: function(results){
             console.log(results);
             swal("Error!", "Unexpected error occur!", "error");
           }
        });
      });



      // Get the form.
  		$('#addlocationform').submit(function(e) {
          e.preventDefault();
    		  //swal({title: "Submit success",   text: "Form is submitted. Please wait a moment...", type:"success"});
    		  swal({title: "Please wait...", imageUrl: "./public/images/loader/green-loader.gif", showConfirmButton: false});

            $.ajax({
              type: 'post',
              url: './ajax/system/add_location.php',
              data: $('#addlocationform').serialize(),
              success: function (results) {
        				swal.close();
        				//console.log(results);
        				if(results === "success") {
                  swal({title: "Submit success",   text: "Record has been successfully saved.", type:"success"}).then(function () {
                    location.reload();
                  });
        				}
        				else {
                  console.log(results);
        				}
              },
        			error: function(results){
        				console.log(results);
        				swal("Error!", "Unexpected error occur!", "error");
        			}
          });
      });

	  });
	</script>

  <?php
	// render footer 2
	require("./templates/layouts/footer_end.php");
  ?>
