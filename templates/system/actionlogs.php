
<!-- DataTables -->
<link rel="stylesheet" href="./public/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


<!-- MODAL -->
<div class="modal fade" id="actioninfomodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-aqua-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Action Info</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>ID</label>
          <input type="text" id="r1" class="form-control" readonly />
        </div>
        <div class="form-group">
          <label>Details</label>
          <textarea id="r2" class="form-control" readonly></textarea>
        </div>
        <div class="form-group">
          <label>Date Time</label>
          <input type="text" id="r3" class="form-control" readonly />
        </div>
        <div class="form-group">
          <label>Remarks</label>
          <textarea id="r4" class="form-control" readonly></textarea>
        </div>
        <div class="form-group">
          <label>User ID</label>
          <input type="text" id="r5" class="form-control" readonly />
        </div>
        <div class="form-group">
          <label>Name</label>
          <input type="text" id="r6" class="form-control" readonly />
        </div>
      </div>
    </div>
  </div>
</div>




<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        System
        <small>Action Logs</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>MTOP</a></li>
        <li class="active">System</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Logs</h3>
            </div>
            <div class="box-body">

              <table id="actions-table" class="table table-bordered table-striped">
                <thead>
                  <th>Date</th>
                  <th>Log Details</th>
                  <th>Name</th>
                  <th></th>
                </thead>
                <tbody>
                </tbody>
              </table>

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
      $('#actions-table').DataTable({
        "processing": true,
        "serverSide": true,
        "deferRender": true,
        "ajax": "./ajax/system/get_action_logs.php",
        "order": [[ 0, "desc" ]]
      });


      $('#actioninfomodal').on('show.bs.modal', function (e) {
        var logid = $(e.relatedTarget).data('id');
        $.ajax({
          type : 'post',
          url : './ajax/system/get_action_logs_info.php',
          data :  { "id" : logid },
          success : function(res) {
            // get json data

            var obj = jQuery.parseJSON(res);
            if(obj.result === "SUCCESS") {
              $('#r1').val(obj.id);
              $('#r2').val(obj.log_details);
              $('#r3').val(obj.log_datetime);
              $('#r4').val(obj.remarks);
              $('#r5').val(obj.user_id);
              $('#r6').val(obj.user_fullname);
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
