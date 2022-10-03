
<!-- DataTables -->
<link rel="stylesheet" href="./public/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">



<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        System
        <small>Users</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>CCMS</a></li>
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
              <table id="usertable" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                  <th>Username</th>
                  <th>Full Name</th>
                  <th>Description</th>
                  <th>Status</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                  <?php foreach($users AS $user) : ?>
                    <?= '<tr>' ?>
                      <?= '<td class="text-green">' . $user["username"] . '</td>' ?>
                      <?= '<td>' . name_format($user["lastname"], $user["firstname"], $user["middlename"], $user["suffix"]) . '</td>' ?>
                      <?= '<td>' . $user["userdesc"] . '</td>' ?>
                      <?= '<td>' . $user["userstatus"] . '</td>' ?>
                      <?= '<td><a href="./system.php?page=account&id=' . $user["uid"] . '" class="btn btn-flat btn-xs btn-primary">View</a>' ?>
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
              <form id="add_user_form" method="post" autocomplete="off">
                <div class="form-group">
                  <label>Lastname</label>
                  <input type="text" name="lastname" class="form-control input-sm" required />
                </div>
                <div class="form-group">
                  <label>Firstname</label>
                  <input type="text" name="firstname" class="form-control input-sm" required />
                </div>
                <div class="form-group">
                  <label>Middlename</label>
                  <input type="text" name="middlename" class="form-control input-sm" />
                </div>
                <div class="form-group">
                  <label>Suffix</label>
                  <input type="text" name="suffix" class="form-control input-sm" />
                </div>


                <div class="form-group">
                  <label>Remarks</label>
                  <textarea name="remarks" class="form-control input-sm"></textarea>
                </div>

                <div class="form-group">
                  <span>Default initial password: <em class="label label-danger">secret</em></span>
                </div>

                <hr/>
                <div class="form-group">
                  <button type="submit" class="btn btn-flat btn-block btn-info">Submit</button>
                </div>

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

      $('#user_name').on('keypress', function(e) {
          if (e.which == 32){
              alert('No space allowed in username');
              return false;
          }
      });




      $('#usertable').DataTable({
        "order": [[ 0, "asc" ]]
      });

      // add new user / insert
      $('#add_user_form').submit(function(e) {
        e.preventDefault();
        swal({title: "Please wait...", imageUrl: "./public/images/loader/green-loader.gif", showConfirmButton: false});
        $.ajax({
          type: 'post',
          url: './ajax/system/register.php',
          data: $('#add_user_form').serialize(),
          success: function (results) {
            swal.close();
            if(results === "success") {
              swal({title: "Submit success",   text: "Record has been successfully saved.", type:"success"}).then(function () {
                location.reload();
              });
            }
            else {
              swal({title: "Ops", text: results, type: "info"});
            }
          },
          error: function(results) {
            console.log(results);
            swal("Error!", "Unexpected error occur!", "error");
          }
        });
      });


      $('#update_user_form').submit(function(e) {
        e.preventDefault();
        swal({title: "Please wait...", imageUrl: "./public/images/loader/green-loader.gif", showConfirmButton: false});
        $.ajax({
          type: 'post',
          url: './ajax/system/update_user.php',
          data: $('#update_user_form').serialize(),
          success: function (results) {
            swal.close();
            console.log(results);
            if(results === "success") {
              swal({title: "Update success",   text: "Record has been successfully updated.", type:"success"})
              .then(function () {
                location.reload();
              });
            }
            else if(results === "generatefailed") {
              swal({title: "Failed", text: "Generated ID failed.", type:"error"});
            }
            else {
              swal({title: "Ops", text: results, type: "info"});
            }
          },
          error: function(results) {
            console.log(results);
            swal("Error!", "Unexpected error occur!", "error");
          }
        });
      });


      $('#reset_pass_form').submit(function(e) {
        e.preventDefault();
        swal({title: "Please wait...", imageUrl: "./public/images/loader/green-loader.gif", showConfirmButton: false});
        $.ajax({
          type: 'post',
          url: './ajax/system/resetpassword.php',
          data: $('#reset_pass_form').serialize(),
          success: function (results) {
            swal.close();
            if(results === "success") {
              swal({title: "Update success",   text: "Record has been successfully updated.", type:"success"}).then(function () {
                location.reload();
              });
            }
            else {
              swal({title: "Ops", text: results, type: "info"});
            }
          },
          error: function(results) {
            console.log(results);
            swal("Error!", "Unexpected error occur!", "error");
          }
        });
      });


	  });
	</script>


  <script>

  $(document).ready(function() {
    $('#usermodal').on('show.bs.modal', function (e) {
      var userid = $(e.relatedTarget).data('id');

      $.ajax({
        type : 'post',
        url : './ajax/system/get_user_info.php',
        data :  { "id" : userid },
        success : function(res) {
          // get json data
          var obj = jQuery.parseJSON(res);

          if(obj.result === "SUCCESS") {
            $('#userid').val(obj.id);
            $('#username').val(obj.username);
            $('#fullname').val(obj.lastname);
            $('#userlevel').val(obj.userlevel);
            $('#remarks').val(obj.remarks);
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


     $('#resetmodal').on('show.bs.modal', function (e) {
       var userid = $(e.relatedTarget).data('id');
       $('#resetuserid').val(userid);
     });


  });
  </script>



  <?php
	// render footer 2
	require("./templates/layouts/footer_end.php");
  ?>
