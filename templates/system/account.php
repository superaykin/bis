
<!-- DataTables -->
<link rel="stylesheet" href="./public/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


<!-- MODAL -->
<div class="modal fade" id="changepasswordmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-aqua-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Change Password</h4>
      </div>
      <form id="change_pass_form" method="post" autocomplete="off">
        <div class="modal-body">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" value="<?= $user["username"] ?>" readonly />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Old Password</label>
                <input type="password" class="form-control" name="oldpassword" required />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>New Password</label>
                <input type="password" class="form-control" name="password" required />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="form-control" name="confirmation" required />
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="userid" value="<?= $user["uid"] ?>" />
          <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info btn-flat">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="resetpasswordmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-aqua-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Reset Password</h4>
      </div>
      <form id="reset_pass_form" method="post" autocomplete="off">
        <div class="modal-body">

          <h1>Are you sure you want to reset the password?</h1>

        </div>
        <div class="modal-footer">
          <input type="hidden" name="userid" value="<?= $user["uid"] ?>" />
          <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info btn-flat">Yes, Continue</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- MODAL -->
<div class="modal fade" id="rolemodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-aqua-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">User Access</h4>
      </div>
      <form id="roleform" method="post" autocomplete="off">
        <div class="modal-body">

          <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" value="<?= $user["username"] ?>" readonly />
          </div>

          <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control" required>
              <option value="" disabled selected>Select role...</option>
              <?php $legend = "";
              foreach($available_roles AS $ar) :
                if($legend == "") {
                  $legend = $ar["role_type"];
                  echo '<optgroup label="' . $legend . '">';
                } else {
                  if($legend <> $ar["role_type"]) {
                    echo '</optgroup>';
                    $legend = $ar["role_type"];
                    echo '<optgroup label="' . $legend . '">';
                  }
                }
              ?>
                <?= '<option value="' . $ar["role_id"] . '">' . $ar["role_desc"] . '</option>' ?>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Remarks</label>
            <textarea class="form-control" name="remarks"></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <input type="hidden" name="userid" value="<?= $user["uid"] ?>" />
          <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info btn-flat">SUBMIT</button>
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
        <small>User Account</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>eCMS</a></li>
        <li class="active">System</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-12">
          <div class="box box-primary">


            <div class="box-body">
              <div class="row">
                <div class="col-md-2">
                  <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#changepasswordmodal" class="btn btn-info btn-flat btn-block">Change Password</a>
                </div>

                <?php if(lookup_role('SYS_ADMIN') <> false OR lookup_role('CARDINAL') <> false) : ?>
                  <div class="col-md-2">
                    <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#resetpasswordmodal" class="btn btn-warning btn-flat btn-block">Reset Password</a>
                  </div>
                  <div class="col-md-2">
                    <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#rolemodal" class="btn btn-success btn-flat btn-block">Set Role</a>
                  </div>
                <?php endif; ?>

              </div>

              <hr/>

              <h4 class="sheader bg-primary"><i class="fa fa-user"></i> Account details</h4>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Lastname</label>
                    <input type="text" class="form-control" value="<?= $user["lastname"] ?>" readonly />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Firstname</label>
                    <input type="text" class="form-control" value="<?= $user["firstname"] ?>" readonly />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Middlename</label>
                    <input type="text" class="form-control" value="<?= $user["middlename"] ?>" readonly />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Suffix</label>
                    <input type="text" class="form-control" value="<?= $user["suffix"] ?>" readonly />
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" value="<?= $user["username"] ?>" readonly />
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" value="<?= $user["userdesc"] ?>" readonly />
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>Status</label>
                    <input type="text" class="form-control" readonly value="<?= $user["userstatus"] ?>" />
                  </div>
                </div>
              </div>

              <h4 class="sheader bg-orange"><i class="fa fa-cog"></i> Account Role</h4>
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-striped table-border">
                    <thead>
                      <th>Role</th>
                      <th>Description</th>
                      <th>Status</th>
                    </thead>
                    <tbody>
                      <?php foreach($roles AS $r) : ?>
                        <?= '<tr>' ?>
                          <?= '<td>' . $r["role_id"] . '</td>' ?>
                          <?= '<td>' . $r["role_desc"] . '</td>' ?>
                          <?= '<td>' . $r["role_status"] . '</td>' ?>
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

      <?php if(lookup_role('SYS_ADMIN') <> false OR lookup_role('CARDINAL') <> false) : ?>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">

            <div class="box-body">
              <h4 class="sheader bg-primary"><i class="fa fa-list"></i> Action logs</h4>
              <div class="row">
                <div class="col-md-12">
                  <table id="actionlogstable" class="table table-striped table-border">
                    <thead>
                      <th width="17%">Date</th>
                      <th>Description</th>
                      <th width="20%">Session ID</th>
                    </thead>
                    <tbody>
                      <?php foreach($actions AS $a) : ?>
                        <?= '<tr>' ?>
                          <?= '<td>' . $a["log_date"] . '</td>' ?>
                          <?= '<td>' . $a["details"] . '</td>' ?>
                          <?= '<td>' . $a["session_code"] . '</td>' ?>
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
      <?php endif; ?>




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

      $('#actionlogstable').DataTable({
        "order": [[ 0, "desc" ]]
      });

        $('#change_pass_form').submit(function(e) {
            e.preventDefault();
            swal({
              title: 'Submit Data?',
              text: 'This form will be submitted. Are you sure you want to continue?',
              type: 'info',
              showCancelButton: true,
              confirmButtonText: 'Yes',
              cancelButtonText: 'Cancel'
            }).then((result) => {
              if (result.value) {

                $.ajax({
                    type: 'post',
                    url: './ajax/system/changepassword.php',
                    data: $('#change_pass_form').serialize(),
                    success: function (results) {
              				//console.log(results);
              				if(results === "success") {
                          swal({
                              title: "Update Success!",
                              text: "Password successfully updated!",
                              type: "success"
                          }).then(function() {
                            // Redirect the user
                            location.reload();
                          });
              				}
                      else if(results === "passwordnotmatch") {
                        swal({title: "Failed", text: "Passwords did not match", type: "error" });
                      }
                      else if(results === "passwordincorrect") {
                        swal({title: "Failed", text: "Old password is incorrect", type: "error" });
                      }
              				else {
                        swal({title: "Failed", text: results, type: "error" });
                        console.log(results);
              				}
                    },
              			error: function(results){
              				console.log(results);
              				swal("Error!", "Unexpected error occur!", "error");
              			}
                });
              }
            });
        });



        $('#reset_pass_form').submit(function(e) {
            e.preventDefault();
            swal({
              title: 'Submit Data?',
              text: 'This form will be submitted. Are you sure you want to continue?',
              type: 'info',
              showCancelButton: true,
              confirmButtonText: 'Yes',
              cancelButtonText: 'Cancel'
            }).then((result) => {
              if (result.value) {

                $.ajax({
                    type: 'post',
                    url: './ajax/system/resetpassword.php',
                    data: $('#reset_pass_form').serialize(),
                    success: function (results) {
              				//console.log(results);
              				if(results === "success") {
                          swal({
                              title: "Success!",
                              text: "Password reset completed!",
                              type: "success"
                          }).then(function() {
                            // Redirect the user
                            location.reload();
                          });
              				}
              				else {
                        swal({title: "Failed", text: results, type: "error" });
                        console.log(results);
              				}
                    },
              			error: function(results){
              				console.log(results);
              				swal("Error!", "Unexpected error occur!", "error");
              			}
                });
              }
            });
        });


        $('#roleform').submit(function(e) {
            e.preventDefault();
            swal({
              title: 'Submit Data?',
              text: 'This form will be submitted. Are you sure you want to continue?',
              type: 'info',
              showCancelButton: true,
              confirmButtonText: 'Yes',
              cancelButtonText: 'Cancel'
            }).then((result) => {
              if (result.value) {

                $.ajax({
                    type: 'post',
                    url: './ajax/system/setrole.php',
                    data: $('#roleform').serialize(),
                    success: function (results) {
              				//console.log(results);
              				if(results === "success") {
                          swal({
                              title: "Update Success!",
                              text: "Password successfully updated!",
                              type: "success"
                          }).then(function() {
                            // Redirect the user
                            location.reload();
                          });
              				}
                      else if(results === "passwordnotmatch") {
                        swal({title: "Failed", text: "Passwords did not match", type: "error" });
                      }
                      else if(results === "passwordincorrect") {
                        swal({title: "Failed", text: "Old password is incorrect", type: "error" });
                      }
              				else {
                        swal({title: "Failed", text: results, type: "error" });
                        console.log(results);
              				}
                    },
              			error: function(results){
              				console.log(results);
              				swal("Error!", "Unexpected error occur!", "error");
              			}
                });
              }
            });
        });

	  });
	</script>


  <?php
	// render footer 2
	require("./templates/layouts/footer_end.php");
  ?>
