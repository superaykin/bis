<!-- bootstrap datepicker -->
<link href="./public/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" tyoe="text/css" />
<!-- DataTables -->
<link rel="stylesheet" href="./public/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


<div class="modal fade" id="addteacher">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-aqua-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">ADD TEACHER</h4>
      </div>

      <form id="addteacherform" role="form" data-toggle="validator" method="post" accept-charset="utf-8" enctype="multipart/form-data" autocomplete="off">
        <div class="modal-body">
          <div class="form-group">
            <label>Teacher</label>
            <select name="userid" class="form-control" required>
              <option value="" disabled selected>Select one...</option>
              <?php $legend = "";
              foreach($avail_teacher AS $at) :
                if($legend == "") {
                  $legend = $at["lastname"][0];
                  echo '<optgroup label="' . $legend . '">';
                } else {
                  if($legend <> $at["lastname"][0]) {
                    echo '</optgroup>';
                    $legend = $at["lastname"][0];
                    echo '<optgroup label="' . $legend . '">';
                  }
                }
              ?>
                <?= '<option value="' . $at["uid"] . '">' . name_format($at["lastname"], $at["firstname"], $at["middlename"], $at["suffix"], "LF") . '</option>' ?>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Remarks</label>
            <textarea class="form-control" name="remarks"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" value="<?= $info["cdc_id"] ?>" name="center_id" />
          <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-flat">SUBMIT FORM</button>
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
        Center
        <small>Info</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>eCMS Panabo</a></li>
        <li class="active">Center</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
    		<div class="col-xs-12">
    			<div class="box box-widget">

            <?php if(lookup_role('SYS_ADMIN') <> false) : ?>
    				<div class="box-header with-border">
              <div class="row">
                  <div class="col-md-2">
                    <button type="button" class="btn btn-flat btn-block btn-sm btn-primary" data-toggle="modal" data-target="#addteacher">
                      <i class="fa fa-plus"></i> ADD TEACHER
                    </button>
                  </div>
              </div>
    				</div>
            <?php endif; ?>
    				<!-- /.box-header -->

    				<div class="box-body">
              <h4 class="sheader bg-primary">Development Center Information</h4>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["centername"] ?>" readonly />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Barangay</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["cdc_brgy"] ?>" readonly />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Added date</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["cdc_dateadded"] ?>" readonly />
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Remarks</label>
                    <textarea class="form-control input-sm" readonly ><?= $info["cdc_remarks"] ?></textarea>
                  </div>
                </div>
              </div>



              <h4 class="sheader bg-aqua">Registered CDC Teachers</h4>
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-striped table-bordered table-hover" id="teachertable">
                    <thead>
                      <th>ID</th>
                      <th width="30%">Name</th>
                      <th>Remarks</th>
                      <th>Status</th>
                      <th width="10%"></th>
                    </thead>
                    <tbody>
                      <?php foreach($teachers AS $t) : ?>
                        <?= '<tr>' ?>
                          <?= '<td>' . $t["teacher_idno"] . '</td>' ?>
                          <?= '<td>' . name_format($t["lastname"], $t["firstname"], $t["middlename"], $t["suffix"], "LF") . '</td>' ?>
                          <?= '<td>' . $t["ct_remarks"] . '</td>' ?>
                          <?= '<td>' . $t["ct_status"] . '</td>' ?>

                          <?php if(lookup_role('SYS_ADMIN') <> false) : ?>
                          <?= '<td>
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-info dropdown-toggle btn-xs btn-block" data-toggle="dropdown">Action
                                <span class="fa fa-caret-down"></span></button>
                              <ul class="dropdown-menu">
                                <li><a id="setstatus" href="#" class="text-orange"
                                          data-dtid="' . $t["ct_id"] . '" data-dts="' . $t["ct_status"] . '">
                                          <i class="fa fa-refresh"></i> Invert Status</a></li>
                                <li class="divider"></li>
                              </ul>
                            </div>
                          </td>' ?>
                        <?php else : ?>
                          <?= '<td>-</td>' ?>
                        <?php endif; ?>
                        <?= '</tr>' ?>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>


              <h4 class="sheader bg-green">Class List</h4>
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-striped table-bordered table-hover" id="classtable">
                    <thead>
                      <th>Code</th>
                      <th>Description</th>
                      <th>School Year</th>
                      <th>Teacher</th>
                      <th>Remarks</th>
                    </thead>
                    <tbody>
                      <?php foreach($class AS $c) : ?>
                        <?= '<tr>' ?>
                          <?= '<td>' . $c["class_name"] . '</td>' ?>
                          <?= '<td>' . $c["class_desc"] . '</td>' ?>
                          <?= '<td>' . $c["schoolyear"] . '</td>' ?>
                          <?= '<td>' . $c["teacher_name"] . '</td>' ?>
                          <?= '<td>' . $c["class_remarks"] . '</td>' ?>
                        <?= '</tr>' ?>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
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
    $('#addteacherform').submit(function(e) {
       e.preventDefault();
       swal({
         title: 'Submit',
         text: 'Are you sure you want to submit this form?',
         type: 'info',
         showCancelButton: true,
         confirmButtonText: 'Yes',
         cancelButtonText: 'Cancel'
       }).then((result) => {
         if (result.value) {
           $.ajax({
             type: 'post',
             url: './ajax/center/addteacher.php',
             data: $('#addteacherform').serialize(),
             success: function (results) {
               swal.close();
               console.log(results);
               var o = jQuery.parseJSON(results);
               if(o.result === "success") {
                 swal({title: "Submit success",
                   text: "Record has been successfully saved.",
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



	   $('#setstatus').click(function(e) {
        e.preventDefault();
        swal({
          title: 'Invert',
          text: 'Are you sure you want to invert the status of this teacher?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes',
          cancelButtonText: 'Cancel'
        }).then((result) => {
          if (result.value) {
            var ctid = $(this).data("dtid");
            var ctstat = $(this).data("dts");
            $.ajax({
              type: 'post',
              url: './ajax/center/statusinvert.php',
              data: { ctid : ctid, ctstat : ctstat },
              success: function (results) {
        				swal.close();
                console.log(results);
                var o = jQuery.parseJSON(results);
        				if(o.result === "success") {
                  swal({title: "Submit success",
                    text: "Status has been successfully inverted.",
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
