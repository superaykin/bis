
<!-- DataTables -->
<link rel="stylesheet" href="./public/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<!-- MODAL -->
  <div class="modal fade" id="signmodal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-aqua-active">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Singatory Details</h4>
        </div>
        <form id="signatoryform" method="post" autocomplete="off">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" name="sname" id="sname" class="form-control" required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Position</label>
                  <input type="text" name="sposition" id="sposition" class="form-control" required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Type</label>
                  <select name="stype" id="stype" class="form-control" required>
                    <option value="" selected disable>Select type...</option>
                    <option value="PRIMARY">PRIMARY</option>
                    <option value="SECONDARY">SECONDARY</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Default</label>
                  <select name="sdefault" id="sdefault" class="form-control" required>
                    <option value="" selected disabled>Select default value...</option>
                    <option value="YES">YES</option>
                    <option value="NO">NO</option>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>Remarks</label>
                  <textarea name="sremarks" id="sremarks" class="form-control"></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" id="sid" name="sid" />
            <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-info btn-flat">Save changes</button>
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
        System
        <small>Signatory</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>MTOP</a></li>
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
              <table id="signatorytable" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Type</th>
                  <th>Default Value</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                  <?php foreach($signatories AS $sign) : ?>
                    <?= '<tr>' ?>
                      <?= '<td>' . $sign["sign_name"] . '</td>' ?>
                      <?= '<td>' . $sign["sign_position"] . '</td>' ?>
                      <?= '<td>' . $sign["sign_type"] . '</td>' ?>
                      <?= '<td>' . $sign["is_default"] . '</td>' ?>
                      <?= '<td><a href="#" class="btn btn-flat btn-xs btn-info" data-id="' . $sign["sign_id"] . '" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#signmodal">View</td>' ?>
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
              <h3 class="box-title">Add new</h3>
            </div>

            <div class="box-body">
              <form id="signform" method="post" autocomplete="off">
                <div class="form-group">
                  <label>Signatory Name</label>
                  <input type="text" class="form-control" name="signname" required />
                </div>
                <div class="form-group">
                  <label>Signatory Position</label>
                  <input type="text" class="form-control" name="signposition" required />
                </div>
                <div class="form-group">
                  <label>Sign Type</label>
                  <select name="signtype" class="form-control" required>
                    <option value="" disabled selected>Select Sign Type</option>
                    <option value="PRIMARY">PRIMARY</option>
                    <option value="SECONDARY">SECONDARY</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Remarks</label>
                  <textarea class="form-control" name="signremarks"></textarea>
                </div>
                <hr/>
                <button type="submit" class="btn btn-flat btn-info btn-block">Submit</button>

              </form>
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
  <!-- DataTables -->
	<script src="./public/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="./public/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


 <!-- javascripts here -->

	<script>
	  $(function () {
      $('#signatorytable').DataTable();

      // Get the form.
  		$('#signform').submit(function(e) {
          e.preventDefault();
    		  //swal({title: "Submit success",   text: "Form is submitted. Please wait a moment...", type:"success"});
    		  swal({title: "Please wait...", imageUrl: "./public/images/loader/green-loader.gif", showConfirmButton: false});

            $.ajax({
              type: 'post',
              url: './ajax/system/add_signatory.php',
              data: $('#signform').serialize(),
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


      // Get the form.
  		$('#signatoryform').submit(function(e) {
          e.preventDefault();
    		  //swal({title: "Submit success",   text: "Form is submitted. Please wait a moment...", type:"success"});
    		  swal({title: "Please wait...", imageUrl: "./public/images/loader/green-loader.gif", showConfirmButton: false});

            $.ajax({
              type: 'post',
              url: './ajax/system/update_signatory.php',
              data: $('#signatoryform').serialize(),
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

  <script>

  $(document).ready(function() {
    $('#signmodal').on('show.bs.modal', function (e) {
      var signatoryid = $(e.relatedTarget).data('id');

      $.ajax({
        type : 'post',
        url : './ajax/system/get_sign_info.php',
        data :  { "id" : signatoryid },
        success : function(res) {
          // get json data
          var obj = jQuery.parseJSON(res);
          if(obj.result === "SUCCESS") {
            $('#sid').val(obj.id);
            $('#sname').val(obj.name);
            $('#sposition').val(obj.position);
            $('#stype').val(obj.type);
            $('#sdefault').val(obj.default);
            $('#sremarks').val(obj.remarks);
          }
          else {
            swal("Error!", "Unexpected error occur!", "error");
          }
        },
        error: function(res) {
          console.log(res);
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
