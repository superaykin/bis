
<!-- DataTables -->
<link rel="stylesheet" href="./public/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile
        <small>Info</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>E-CMS Panabo</a></li>
        <li class="active">Profile</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">

              <a href="#" data-toggle="modal" data-target="#viewphotomodal">
                <img class="profile-user-img img-responsive img-circle" src="./public/images/main-avatar.png" alt="User profile picture">
              </a>
              <h3 class="profile-username text-center"></h3>
              <p class="text-muted text-center">
                <strong>
                  <?= name_format($info["lastname"], $info["firstname"], $info["middlename"], $info["suffix"], "LF") ?>
                </strong><br/>
              </p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Age</b> <span class="pull-right text-aqua"><?= get_age($info["birthdate"]) ?> yr/s old</span>
                </li>
                <li class="list-group-item">
                  <b>Registration date</b> <span class="pull-right text-aqua"><?= $info["registered"] ?></span>
                </li>
                <li class="list-group-item">
                  <b>Registered by</b> <span class="pull-right text-aqua"><?= $info["actor_name"] ?></span>
                </li>
              </ul>

              <?php if($info["profile_status"] == "LOCKED") : ?>
                <?php if(lookup_role('SYS_ADMIN') == true) : ?>
                  <button id="btnunlock" type="button" class="btn btn-danger btn-block" data-id="<?= $info["eid"] ?>"><b>Unlock</b></a>
                <?php endif; ?>
              <?php else : ?>
                <?php if($GLOBALS["_uid"] == $info["actor_id"] OR lookup_role('SYS_ADMIN') == true) : ?>
                  <a href="./entity.php?page=update&id=<?= $info["eid"] ?>" class="btn btn-primary btn-block"><b>Edit Profile</b></a>
                <?php endif; ?>
              <?php endif; ?>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div> <!---- PROFILE IMAGE --->

        <div class="col-md-9">

          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab1" data-toggle="tab">Personal Info</a></li>
              <li><a href="#tab2" data-toggle="tab">Class History</a></li>
              <li><a href="#tab3" data-toggle="tab">ECCD</a></li>
              <li><a href="#tab4" data-toggle="tab">Nutritional Status</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="tab1">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Lastname</label>
                      <input class="form-control" type="text" value="<?= $info["lastname"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Firstname</label>
                      <input class="form-control" type="text" value="<?= $info["firstname"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Middlename</label>
                      <input class="form-control" type="text" value="<?= $info["middlename"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Suffix</label>
                      <input class="form-control" type="text" value="<?= $info["suffix"] ?>" readonly />
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Sex</label>
                      <input class="form-control" type="text" value="<?= $info["sex"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="form-group">
                      <label>Home Address</label>
                      <?php
                      if(!empty($info["address_street"])) {
                        $ad = $info["address_street"] . ', BRGY. ' . $info["address_brgy"] . ', ' . $info["address_city"];
                      }
                      else {
                        $ad = 'BRGY. ' . $info["address_brgy"] . ', ' . $info["address_city"];
                      }
                      ?>
                      <input type="text" class="form-control" value="<?= $ad ?>" readonly />
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Date of Birth</label>
                      <input class="form-control" type="text" value="<?= $info["birthdate"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Birthplace</label>
                      <input class="form-control" type="text" value="<?= $info["birthplace"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Birth Registered</label>
                      <input class="form-control" type="text" value="<?= $info["birth_registered"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Birth order</label>
                      <input class="form-control" type="text" value="<?= $info["birthorder"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Ethnicity</label>
                      <input class="form-control" type="text" value="<?= $info["ethnicity"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Religion</label>
                      <input class="form-control" type="text" value="<?= $info["religion"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Contact No.</label>
                      <input class="form-control" type="text" value="<?= $info["contactno"] ?>" readonly />
                    </div>
                  </div>


                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Person w/ Disability</label>
                      <input class="form-control" type="text" value="<?= $info["pwd"] ?>" readonly />
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label>IPs Member</label>
                      <input class="form-control" type="text" value="<?= $info["ips"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>4Ps Member</label>
                      <input class="form-control" type="text" value="<?= $info["4ps"] ?>" readonly />
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Remarks</label>
                      <textarea class="form-control" rows="5" readonly><?= $info["profile_remarks"] ?></textarea>
                    </div>
                  </div>
                </div>


              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab2">


                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <th>Center</th>
                    <th>Class</th>
                    <th>Teacher</th>
                    <th>School Year</th>
                    <th></th>
                  </thead>
                  <tbody>
                    <?php foreach($class AS $c) : ?>
                      <?= '<tr>' ?>
                        <?= '<td class="text-orange">' . $c["centername"] . '</td>' ?>
                        <?= '<td>' . $c["class_name"] . '</td>' ?>
                        <?= '<td>' . $c["teacher_name"] . '</td>' ?>
                        <?= '<td>' . $c["schoolyear"] . '</td>' ?>
                        <?= '<td><a href="class.php?page=info&id=' . $c["cid"] . '" class="btn btn-xs btn-flat btn-primary">View</a>' ?>
                      <?= '</tr>' ?>
                    <?php endforeach; ?>
                  </tbody>
                </table>


              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab3">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <th>Test Date</th>
                    <th>Interpretation</th>
                    <th>Age Tested</th>
                    <th>Tested by</th>
                    <th>Remarks</th>
                    <th></th>
                  </thead>
                  <tbody>
                    <?php foreach($eccd AS $e) : ?>
                      <?= '<tr>' ?>
                        <?= '<td>' . $e["test_date"] . '</td>' ?>
                        <?= '<td>' . $e["interpretation"] . '</td>' ?>
                        <?= '<td>' . $e["age_tested"] . '</td>' ?>
                        <?= '<td>' . $e["actor_name"] . '</td>' ?>
                        <?= '<td>' . $e["remarks"] . '</td>' ?>
                        <?= '<td><a href="./eccd.php?page=test&id=' . $e["test_id"] . '" class="btn btn-xs btn-flat btn-primary">View</a>' ?>
                      <?= '</tr>' ?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>


              <div class="tab-pane" id="tab4">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <th>Test Date</th>
                    <th>Nutritional Status</th>
                    <th>Tested by</th>
                    <th>Remarks</th>
                  </thead>
                  <tbody>
                    <?php foreach($nstat AS $n) : if($n["nstat_id"] == "N") { $c = "label-success"; } else { $c = "label-danger"; } ?>
                      <?= '<tr>' ?>
                        <?= '<td>' . $n["ns_testdate"] . '</td>' ?>
                        <?= '<td><span class="label ' . $c . '">' . $n["nstat"] . '</span></td>' ?>
                        <?= '<td>' . $n["actor_name"] . '</td>' ?>
                        <?= '<td>' . $n["nstat_remarks"] . '</td>' ?>
                      <?= '</tr>' ?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
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
  <!-- DataTables -->
	<script src="./public/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="./public/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


 <!-- javascripts here -->

	<script>
	  $(function () {


      $('#btnunlock').click(function(e) {
         e.preventDefault();
         swal({
           title: 'Unlock',
           text: 'Are you sure you want to unlock this profile?',
           type: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Yes',
           cancelButtonText: 'Cancel'
         }).then((result) => {
           if (result.value) {

             var eid = $(this).data("id");
             $.ajax({
               type: 'post',
               url: './ajax/entity/unlock.php',
               data: { eid : eid },
               success: function (results) {
         				swal.close();
                 console.log(results);
                 var o = jQuery.parseJSON(results);
         				if(o.result === "success") {
                   swal({title: "Unlock success",
                     text: "Record has been successfully unlocked.",
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
