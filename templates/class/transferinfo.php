<!-- bootstrap datepicker -->
<link href="./public/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" tyoe="text/css" />
<!-- DataTables -->
<link rel="stylesheet" href="./public/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">



<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Class Transfer
        <small>Info</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>eCMS Panabo</a></li>
        <li class="active">Class Transfer</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
    		<div class="col-xs-12">
    			<div class="box box-widget">

            <?php if((lookup_role('SYS_ADMIN') == true OR is_class_teacher($info["target_cid"]) == true) AND $info["transfer_status"] == "PENDING") : ?>
    				<div class="box-header with-border">
              <div class="row">
                  <div class="col-md-2">
                    <form id="approveform" role="form" data-toggle="validator" method="post" accept-charset="utf-8" enctype="multipart/form-data" autocomplete="off">
                      <input type="hidden" name="transfer_id" value="<?= $info["ctid"] ?>" />
                      <button type="submit" class="btn btn-flat btn-block btn-sm btn-success">
                        <i class="fa fa-check"></i> APPROVE TRANSFER
                      </button>
                    </form>
                  </div>
                  <div class="col-md-2">
                    <form id="cancelform" role="form" data-toggle="validator" method="post" accept-charset="utf-8" enctype="multipart/form-data" autocomplete="off">
                      <input type="hidden" name="transfer_id" value="<?= $info["ctid"] ?>" />
                      <button type="submit" class="btn btn-flat btn-block btn-sm btn-danger">
                        <i class="fa fa-remove"></i> DENY TRANSFER
                      </button>
                    </form>
                  </div>

                  <div class="col-md-2">
                    <a class="btn btn-flat btn-block btn-sm btn-primary" target="_blank" href="./entity.php?page=info&id=<?= $info["eid"] ?>">
                      <i class="fa fa-eye"></i> VIEW STUDENT INFO
                    </a>
                  </div>
              </div>
    				</div>
            <?php endif; ?>
    				<!-- /.box-header -->

    				<div class="box-body">
              <h4 class="sheader bg-primary">Class Transfer Request Information</h4>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Transfer Status</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["transfer_status"] ?>" readonly />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Requestor</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["requestor"] ?>" readonly />
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>Date of Request</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["transfer_date"] ?>" readonly />
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>Approval Date</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["approval_date"] ?>" readonly />
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>Acted by</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["approver"] ?>" readonly />
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Transfer Notes/Remarks</label>
                    <textarea class="form-control input-sm" readonly ><?= $info["transfer_notes"] ?></textarea>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Student Name</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["student"] ?>" readonly />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Student ID</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["student_no"] ?>" readonly />
                  </div>
                </div>



                <div class="col-md-12">
                  <div class="form-group">
                    <label>Transfer Notes</label>
                    <textarea class="form-control input-sm" readonly ><?= $info["transfer_notes"] ?></textarea>
                  </div>
                </div>
              </div>



              <h4 class="sheader bg-aqua">Origin Class Information</h4>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Class</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["origin_code"] ?>" readonly />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["origin_desc"] ?>" readonly />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Teacher</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["origin_teacher"] ?>" readonly />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Center</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["origin_center"] ?>" readonly />
                  </div>
                </div>
              </div>

              <h4 class="sheader bg-green">Target Class Information</h4>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Class</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["target_code"] ?>" readonly />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["target_desc"] ?>" readonly />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Teacher</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["target_teacher"] ?>" readonly />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Center</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["target_center"] ?>" readonly />
                  </div>
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
   <!-- DataTables -->
  <script src="./public/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="./public/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script>
  $(function () {



  });
	</script>

  <script>
  $(function () {

    $('#teachertable').DataTable({
      "order": [[ 1, "asc" ]]
    });

    $('#classtable').DataTable({
      "order": [[ 2, "desc" ]]
    });



    // Get the form.
    $('#approveform').submit(function(e) {
       e.preventDefault();
       swal({
         title: 'Request Approval',
         text: 'Are you sure you want to approve this class transfer request?',
         type: 'info',
         showCancelButton: true,
         confirmButtonText: 'Yes, continue',
         cancelButtonText: 'Cancel'
       }).then((result) => {
         if (result.value) {
           $.ajax({
             type: 'post',
             url: './ajax/class/transfer.php',
             data: $('#approveform').serialize(),
             success: function (results) {
               swal.close();
               console.log(results);
               var o = jQuery.parseJSON(results);
               if(o.result === "success") {
                 swal({title: "Transfer Approved",
                   text: "Request to transfer has been successfully approved.",
                   type:"success"})
                 .then(function () {
                   location.reload();
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


     $('#cancelform').submit(function(e) {
        e.preventDefault();
        swal({
          title: 'Deny request',
          text: 'Are you sure you want to deny this class transfer request? This action is not recoverable.',
          type: 'info',
          showCancelButton: true,
          confirmButtonText: 'Yes, continue',
          cancelButtonText: 'Cancel'
        }).then((result) => {
          if (result.value) {
            $.ajax({
              type: 'post',
              url: './ajax/class/transcancel.php',
              data: $('#cancelform').serialize(),
              success: function (results) {
                swal.close();
                console.log(results);
                var o = jQuery.parseJSON(results);
                if(o.result === "success") {
                  swal({title: "Transfer Cancelled",
                    text: "Request to transfer has been cancelled.",
                    type:"success"})
                  .then(function () {
                    location.reload();
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
