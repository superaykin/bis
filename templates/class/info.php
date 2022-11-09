<!-- bootstrap datepicker -->
<link href="./public/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" tyoe="text/css" />
<!-- DataTables -->
<link rel="stylesheet" href="./public/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="./public/AdminLTE/bower_components/select2/dist/css/select2.min.css">


<div class="modal fade" id="addstudent">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-aqua-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">ENROLL STUDENT</h4>
      </div>

      <form id="addstudentform" role="form" data-toggle="validator" method="post" accept-charset="utf-8" enctype="multipart/form-data" autocomplete="off">
        <div class="modal-body">
          <div class="form-group">
            <label>Student ID</label>
            <input type="text" name="studentidno" class="form-control" value="<?= create_child_id($info["cdc_id"]) ?>" readonly />
          </div>

          <div class="form-group">
            <label>Student</label>
            <select name="entityid" class="form-control select2" width="100%" required>
              <option value="" disabled selected>Select one...</option>
              <?php $legend = "";
              foreach($entity AS $e) : $fb = new DateTime($e["birthdate"]); $bdate = $fb->format("M d, Y"); $age = get_age($e["birthdate"]);
                if($legend == "") {
                  $legend = $e["lastname"][0];
                  echo '<optgroup label="' . $legend . '">';
                } else {
                  if($legend <> $e["lastname"][0]) {
                    echo '</optgroup>';
                    $legend = $e["lastname"][0];
                    echo '<optgroup label="' . $legend . '">';
                  }
                }
              ?>
                <?= '<option value="' . $e["eid"] . '">' . name_format($e["lastname"], $e["firstname"], $e["middlename"], $e["suffix"], "LF") . ' &ensp;&ensp;&ensp;&ensp; - &ensp;&ensp;&ensp;&ensp; Birthdate: ' . $bdate . ' &ensp;&ensp;&ensp; - &ensp;&ensp;&ensp; Age: ' . $age . '</option>' ?>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Remarks</label>
            <textarea class="form-control" name="remarks"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" value="<?= $info["cid"] ?>" name="class_id" />
          <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-flat">SUBMIT FORM</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="modal fade" id="eccdmodal">
  <div class="modal-dialog modal-cxl">
    <div class="modal-content">
      <div class="modal-header bg-aqua-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Early Childhood Care and Development</h4>
      </div>


        <div class="modal-body">

          <div class="row">
            <div class="col-md-12">
              <h1 class="text-red" id="childname"></h1>
            </div>
          </div>

          <div class="row">
            <div class="col-md-8 border-right">
              <h4 class="sheader bg-green">ECCD History</h4>
              <table id="eccdhistory" class="table table-border table-striped">
                <thead>
                  <th>Test Date</th>
                  <th>Standard</th>
                  <th>Scaled</th>
                  <th>Interpretation</th>
                  <th>Actor</th>
                  <th>Remarks</th>
                </thead>
                <tbody></tbody>
              </table>
            </div>
            <div class="col-md-4">
              <h4 class="sheader bg-orange">Form</h4>
              <?php if(is_class_teacher_allowed($info["cid"]) <> false) {
                // the login account is the teacher
                $d = "";
              } else {
                // set form to disabled
                $d = "disabled";
              } ?>
              <form id="eccdform" role="form" data-toggle="validator" method="post" accept-charset="utf-8" enctype="multipart/form-data" autocomplete="off">

                <div class="row">
                  <?php foreach($eccd AS $e) : ?>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label><?= $e["eccd_id"] ?></label>
                          <input type="number" class="form-control input-sm" name="eccd_score[]" placeholder="Enter score..." required <?= $d ?> />
                          <input type="hidden" class="form-control" name="eccd_id[]" value="<?= $e["eccd_id"] ?>" required />
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Date Tested</label>
                      <input type="date" class="form-control input-sm" name="testdate" required <?= $d ?> />
                    </div>
                  </div>
                  <!-- <div class="col-md-6">
                    <div class="form-group">
                      <label>Age Tested</label>
                      <input type="text" class="form-control input-sm" name="agetested" required <?= $d ?> />
                    </div>
                  </div> -->
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Remarks</label>
                      <textarea name="remarks" class="form-control" <?= $d ?>></textarea>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group pull-right">
                      <input type="hidden" id="t_sid" value="" name="sid" />
                      <input type="hidden" id="t_eid" value="" name="eid" />
                      <input type="hidden" value="<?= $info["cid"] ?>" name="class_id" />
                      <button type="submit" class="btn btn-primary btn-flat" <?= $d ?>>SUBMIT FORM</button>
                    </div>
                  </div>
                </div>

              </form>

            </div>
          </div>

        </div>


    </div>
  </div>
</div>


<div class="modal fade" id="nutstatmodal">
  <div class="modal-dialog modal-cxl">
    <div class="modal-content">
      <div class="modal-header bg-green-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Child Nutritional Status</h4>
      </div>


        <div class="modal-body">

          <div class="row">
            <div class="col-md-12">
              <h1 class="text-red" id="ns_childname"></h1>
            </div>
          </div>

          <div class="row">
            <div class="col-md-7 border-right">
              <h4 class="sheader bg-purple">Nutritional Status History</h4>
              <table id="nstable" class="table table-border table-striped">
                <thead>
                  <th>Nutritional Status</th>
                  <th>Actor</th>
                  <th>Date</th>
                  <th>Remarks</th>
                </thead>
                <tbody></tbody>
              </table>
            </div>
            <div class="col-md-5">
              <h4 class="sheader bg-orange">Form</h4>

              <form id="nsform" role="form" data-toggle="validator" method="post" accept-charset="utf-8" enctype="multipart/form-data" autocomplete="off">

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Nutritional Status</label>
                      <select name="nutstat" class="form-control input-sm" required <?= $d ?>>
                        <option value="" disabled selected>Select one...</option>
                        <?php foreach($nstat AS $n) : ?>
                          <?= '<option value="' . $n["nstat_code"] . '">' . $n["nstat"] . '</option>' ?>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Date of testing</label>
                      <input type="date" class="form-control input-sm" name="testdate" <?= $d ?> />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Remarks</label>
                      <textarea name="remarks" class="form-control input-sm" <?= $d ?>></textarea>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group pull-right">
                      <input type="hidden" id="ns_eid" value="" name="eid" />
                      <input type="hidden" id="ns_sid" value="" name="sid" />
                      <input type="hidden" value="<?= $info["cid"] ?>" name="class_id" />
                      <button type="submit" class="btn btn-primary btn-flat" <?= $d ?>>SUBMIT FORM</button>
                    </div>
                  </div>
                </div>

              </form>

            </div>
          </div>

        </div>


    </div>
  </div>
</div>


<div class="modal fade" id="listmodal">
  <div class="modal-dialog modal-cxl">
    <div class="modal-content">
      <div class="modal-header bg-red-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">STUDENT LIST</h4>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Age</th>
            <th>Latest ECCD Result</th>
            <th>Latest Nutritional Stat</th>
            <th width="15%">Remarks</th>
          </thead>
          <tbody>
            <?php foreach($students AS $s) : $res = get_eccd_latest_result($s["entity_id"], $s["sid"]); $enstat = get_latest_nstat_result($s["entity_id"], $s["sid"]);
            if (strpos($res, 'AVERAGE') !== false) {
               $c = "label-warning"; }
            else if (strpos($res, 'HIGHLY') !== false) {
               $c = "label-info"; }
            else if (strpos($res, 'SLIGHTLY') !== false) {
               $c = "label-success"; }
            else {
               $c = "label-danger"; }

            if (strpos($enstat, 'NORMAL') !== false) {
               $c2 = "label-success"; }
            else if (strpos($enstat, 'SEVERE') !== false) {
               $c2 = "label-danger"; }
            else {
               $c2 = "label-warning"; }
            $lbl1 = '<span class="label ' . $c . '"><i class="fa fa-info"></i></span> ';
            $lbl2 = '<span class="label ' . $c2 . '"><i class="fa fa-info"></i></span> ';
            ?>
              <?= '<tr>' ?>
                <?= '<td class="text-purple">' . $s["student_idno"] . '</td>' ?>
                <?= '<td>' . name_format($s["lastname"], $s["firstname"], $s["middlename"], $s["suffix"], "LF") . '</td>' ?>
                <?= '<td>' . address_format($s["address_city"], $s["address_brgy"], $s["address_street"]) . '</td>' ?>
                <?= '<td>' . get_age($s["birthdate"]) . '</td>' ?>
                <?= '<td>' . $lbl1 . $res . '</td>' ?>
                <?= '<td>' . $lbl2 . $enstat . '</td>' ?>
                <?= '<td>' . $s["student_remarks"] . '</td>' ?>
              <?= '</tr>' ?>
            <?php endforeach; ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="classtransfermodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-orange-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">TRANSFER STUDENT</h4>
      </div>

      <form id="transferform" role="form" data-toggle="validator" method="post" accept-charset="utf-8" enctype="multipart/form-data" autocomplete="off">
        <div class="modal-body">
          <div class="form-group">
            <label>Student Name</label>
            <input type="text" class="form-control" id="trans_studentname" value="" readonly />
          </div>

          <div class="form-group">
            <label>Destination Class <small><?= '(SY: ' . $info["schoolyear"] . ')' ?></small></label>
            <select name="classid" class="form-control" required>
              <option value="" disabled selected>Select class...</option>
              <?php $legend = ""; foreach($av_class AS $c) :
                if($legend == "") {
                  $legend = $c["centername"];
                  echo '<optgroup label="' . $legend . '">';
                } else {
                  if($legend <> $c["centername"]) {
                    echo '</optgroup>';
                    $legend = $c["centername"];
                    echo '<optgroup label="' . $legend . '">';
                  }
                }
              ?>
                <?= '<option value="' . $c["cid"] . '">' . $c["class_name"] . ' - ' . $c["class_desc"] . '</option>' ?>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Notes/Remarks</label>
            <textarea class="form-control" name="remarks" required></textarea>
            <span class="help-block">Please state the reason of the transfer here. This note will serve as a guide for the acceptance of the transfer.</span>
          </div>

          <h4 class="sheader bg-red">Account Verification</h4>
          <div class="form-group">
            <span>Please enter your password for verification.</span>
            <input type="password" name="password" class="form-control" required>
          </div>

          <h4 class="sheader bg-aqua">System Note</h4>
          <span>After submission of this form, the request will be saved and will only take effect if the opposite party or a system administrator will accept the transfer request.</span>


        </div>
        <div class="modal-footer">
          <input type="hidden" name="class_id" value="<?= $info["cid"] ?>" />
          <input type="hidden" id="sid" name="sid" />
          <input type="hidden" id="trans_eid" name="eid" />
          <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-flat">SUBMIT REQUEST</button>
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
        Class
        <small>Info</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>eCMS Panabo</a></li>
        <li class="active">Class</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
    		<div class="col-xs-12">
    			<div class="box box-widget">
            <!-- box-header -->
    				<div class="box-header with-border">
              <div class="row">
                <?php if(is_class_teacher_allowed($info["cid"]) <> false) : ?>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-flat btn-block btn-sm btn-primary" data-toggle="modal" data-target="#addstudent">
                      <i class="fa fa-plus"></i> ENROLL STUDENT
                    </button>
                  </div>
                <?php endif; ?>

                <div class="col-md-2">
                  <button type="button" class="btn btn-flat btn-block btn-sm btn-success" data-toggle="modal" data-target="#listmodal">
                    <i class="fa fa-clone"></i> STUDENT INFO
                  </button>
                </div>

              </div>
    				</div>
    				<!-- /.box-header -->

    				<div class="box-body">

              <h4 class="sheader bg-purple">Class Information</h4>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Code</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["class_name"] ?>" readonly />
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["class_desc"] ?>" readonly />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>School Year</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["schoolyear"] ?>" readonly />
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>Teacher</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["t_name"] ?>" readonly />
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>Center</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["centername"] ?>" readonly />
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>Barangay</label>
                    <input type="text" class="form-control input-sm" value="<?= $info["cdc_brgy"] ?>" readonly />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Population</span>
                      <span class="info-box-number"><?= $stat["population"] ?></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-blue"><i class="ion ion-ios-people-outline"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Male</span>
                      <span class="info-box-number"><?= $stat["male"] ?></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-maroon"><i class="ion ion-ios-people-outline"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Female</span>
                      <span class="info-box-number"><?= $stat["female"] ?></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">IPS</span>
                      <span class="info-box-number"><?= $stat["ipscount"] ?></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <h4 class="sheader bg-orange">Enrolled students</h4>

              <div class="row">
                <div class="col-md-12">
                  <table class="table table-striped table-bordered table-hovered" id="enrolledlist">
                    <thead>
                      <th>Student ID</th>
                      <th>Lastname</th>
                      <th>First</th>
                      <th>Middle</th>
                      <th>Suffix</th>
                      <th>Date of Birth</th>
                      <th>Age</th>
                      <th>ECCD Test</th>
                      <th></th>
                      <th></th>
                    </thead>
                    <tbody>
                      <?php foreach($students AS $s) : $fd = new DateTime($s["birthdate"]); $dob = $fd->format("M d, Y"); ?>
                        <?= '<tr>' ?>
                          <?= '<td class="text-orange" data-original-title="' . $s["student_remarks"] . '" data-container="body" data-toggle="tooltip" data-placement="top"><b>' . $s["student_idno"] . '</b></td>' ?>
                          <?= '<td>' . $s["lastname"] . '</td>' ?>
                          <?= '<td>' . $s["firstname"] . '</td>' ?>
                          <?= '<td>' . $s["middlename"] . '</td>' ?>
                          <?= '<td>' . $s["suffix"] . '</td>' ?>
                          <?= '<td>' . $dob . '</td>' ?>
                          <?= '<td>' . get_age($s["birthdate"]) . ' y.o</td>' ?>
                          <?= '<td>' . get_eccd_test_count($s["entity_id"], $s["sid"]) . '</td>' ?>

                          <?php if(is_class_teacher($info["cid"]) <> false OR lookup_role('SYS_ADMIN') == true) : ?>
                            <?= '<td data-original-title="Press for controls" data-toggle="tooltip" data-placement="top" data-container="body">
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-info dropdown-toggle btn-xs btn-block" data-toggle="dropdown">Action
                                <span class="fa fa-caret-down"></span></button>
                              <ul class="dropdown-menu" style="background-color: #CFF2FC !important;">
                                <li><a href="#" class="text-orange" data-toggle="modal" data-target="#eccdmodal" data-backdrop="static"
                                          data-eid="' . $s["entity_id"] . '" data-ename="' . get_name($s["entity_id"]) . '" data-cid="' . $s["class_id"] . '"
                                          data-sid="' . $s["sid"] . '">
                                          <i class="fa fa-edit"></i> ECCD Test</a></li>
                                <li class="divider"></li>
                                <li><a href="#" class="text-green" data-toggle="modal" data-target="#nutstatmodal" data-backdrop="static"
                                          data-eid="' . $s["entity_id"] . '" data-ename="' . get_name($s["entity_id"]) . '" data-cid="' . $s["class_id"] . '"
                                          data-sid="' . $s["sid"] . '">
                                          <i class="fa fa-area-chart"></i> Nutritional Status</a></li>
                                <li class="divider"></li>
                                <li><a href="#" class="" data-toggle="modal" data-target="#classtransfermodal" data-backdrop="static"
                                          data-eid="' . $s["entity_id"] . '"
                                          data-sid="' . $s["sid"] . '" data-ename="' . get_name($s["entity_id"]) . '" data-cid="' . $s["class_id"] . '">
                                          <i class="fa fa-reply"></i> Transfer Class</a></li>
                              </ul>
                            </div>
                            </td>' ?>
                          <?php else : ?>
                            <?= '<td>-</td>' ?>
                          <?php endif; ?>

                          <?= '<td><a href="./entity.php?page=info&id=' . $s["eid"] . '" target="_blank" class="btn btn-xs btn-flat btn-primary"
                                  data-toggle="tooltip" data-placement="top" title="Navigate to profile"><i class="fa fa-user"></i></a></td>' ?>
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
  <!-- Select2 -->
  <script src="./public/AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>


	<script>
  $(function () {



  });
	</script>

  <script>
  $(function () {

    $("[data-toggle='tooltip']").tooltip();

    $('#enrolledlist').DataTable({
      "order": [[ 1, "asc" ]]
    });

    // Get the form.
	   $('#addstudentform').submit(function(e) {
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
              url: './ajax/class/addstudent.php',
              data: $('#addstudentform').serialize(),
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



      $('#eccdform').submit(function(e) {
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
               url: './ajax/eccd/eccdscore.php',
               data: $('#eccdform').serialize(),
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


      $('#eccdmodal').on('show.bs.modal', function (e) {
        var eid = $(e.relatedTarget).data('eid'); // entity id
        var ename = $(e.relatedTarget).data('ename');
        var cid = $(e.relatedTarget).data('cid'); // class id
        var sid = $(e.relatedTarget).data('sid'); // student id

        $('#childname').html(ename);
        $('#t_eid').val(eid);
        $('#t_sid').val(sid);

        $.ajax({
          type : 'post',
          url : './ajax/eccd/history.php',
          data :  { "eid" : eid, "cid" : cid, "sid" : sid },
          success : function(res) {
            //console.log(res);
            var r = jQuery.parseJSON(res);
            var te = '';
            if(r.status == "RESULTFOUND") {
              $.each(r.data, function(index, obj) {
                te = te + '<tr>';
                te = te + '<td><a href="./eccd.php?page=test&id=' + obj.test_id + '" target="_blank">' + obj.test_date + '</a></td>';
                te = te + '<td>' + obj.standard_score + '</td>';
                te = te + '<td>' + obj.scaled_score + '</td>';
                te = te + '<td>' + obj.interpretation + '</td>';
                te = te + '<td>' + obj.actor_name + '</td>';
                te = te + '<td>' + obj.remarks + '</td>';
                te = te + '</tr>';
              });
            }

            $('#eccdhistory > tbody').html(te);

          },
          error: function(res) {
            console.log(res);
            swal("Error!", "Unexpected error occur!", "error");
          }
        });
      });


      $('#nutstatmodal').on('show.bs.modal', function (e) {
        var eid = $(e.relatedTarget).data('eid'); // entity id
        var ename = $(e.relatedTarget).data('ename');
        var cid = $(e.relatedTarget).data('cid'); // class id
        var sid = $(e.relatedTarget).data('sid'); // student id

        $('#ns_childname').html(ename);
        $('#ns_eid').val(eid);
        $('#ns_sid').val(sid);

        $.ajax({
          type : 'post',
          url : './ajax/nstat/history.php',
          data :  { "eid" : eid, "cid" : cid, "sid" : sid },
          success : function(res) {
            console.log(res);
            var r = jQuery.parseJSON(res);
            var te = '';
            if(r.status == "RESULTFOUND") {
              $.each(r.data, function(index, obj) {
                te = te + '<tr>';
                te = te + '<td>' + obj.nstat + '</td>';
                te = te + '<td>' + obj.actor_name + '</td>';
                te = te + '<td>' + obj.ns_testdate + '</td>';
                te = te + '<td>' + obj.nstat_remarks + '</td>';
                te = te + '</tr>';
              });
            }

            $('#nstable > tbody').html(te);

          },
          error: function(res) {
            console.log(res);
            swal("Error!", "Unexpected error occur!", "error");
          }
        });

      });


      $('#classtransfermodal').on('show.bs.modal', function (e) {
        var sid = $(e.relatedTarget).data('sid'); // entity id
        var ename = $(e.relatedTarget).data('ename');
        var eid = $(e.relatedTarget).data('eid'); // entity id

        $('#trans_studentname').val(ename);
        $('#sid').val(sid);
        $('#trans_eid').val(eid);

      });



      $('#nsform').submit(function(e) {
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
               url: './ajax/nstat/record.php',
               data: $('#nsform').serialize(),
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


       $('#transferform').submit(function(e) {
          e.preventDefault();
          swal({
            title: 'Student Transfer',
            text: 'Are you sure you want to transfer student?',
            type: 'info',
            showCancelButton: true,
            confirmButtonText: 'Yes, continue',
            cancelButtonText: 'Cancel'
          }).then((result) => {
            if (result.value) {
              $.ajax({
                type: 'post',
                url: './ajax/class/transrequest.php',
                data: $('#transferform').serialize(),
                success: function (results) {
          				swal.close();
                  console.log(results);
                  var o = jQuery.parseJSON(results);
            				if(o.result === "success") {
                      swal({title: "Transfer is requested",
                        text: "Request of student transfer has been submitted. Please wait for the approval of the request.",
                        type:"success"})
                      .then(function () {
                        location.reload();
                      });
            				}
                    else if(o.result === "invalidcredentials") {
                      swal({
                        title: "Error!",
                        text: "Invalid account credential!",
                        type:"error"
                      });
                      console.log(results);
                    }
                    else if(o.result === "studenthaspendingtransfer") {
                      swal({
                        title: "Error!",
                        text: "Student has active transfer request. Please contact system administrator.",
                        type:"error"
                      });
                      console.log(results);
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
