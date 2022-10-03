
  <!-- bootstrap datepicker -->
  <link href="./public/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" tyoe="text/css" />




<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Class
        <small>New</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>eCMS Panabo</a></li>
        <li class="active">Class</li>
      </ol>
    </section>

    <section class="content">

  			<div class="box box-widget">
  				<!-- /.box-header -->

          <form id="addform" role="form" data-toggle="validator" method="post" accept-charset="utf-8" enctype="multipart/form-data" autocomplete="off">

  				<div class="box-body">

              <div class="col-md-12">
                <div class="callout callout-info">
                  <h4>A friendly reminder :)</h4>
                  <p>Some fields are required to be filed inorder to submit the form.</p>
                </div>

                <h4 class="rheader bg-primary">Class Information</h4>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="center">Development Center</label>
                        <select name="center" class="form-control" required>
                          <option value="" disabled selected>Select center...</option>
                          <?php foreach($centers AS $c) : ?>
                            <?= '<option value="' . $c["cdc_id"] . '">' . $c["centername"] . '</option>' ?>
                          <?php endforeach; ?>
                        </select>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="sy">School Year</label>
                        <select name="sy" class="form-control">
                          <option value="" disabled selected>Select sy...</option>
                          <?php for($y = date("Y"); $y >= 2015; $y--) : $x = $y + 1; ?>
                            <?= '<option value="' . $y . '-' . $x . '">' . $y . '-' . $x . '</option>' ?>
                          <?php endfor; ?>
                        </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="center">Center Teacher</label>
                        <input type="hidden" name="cdcteacher" value="<?= $GLOBALS["_uid"] ?>" />
                        <input type="text" class="form-control" name="" value="<?= $GLOBALS["_fullname"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="classdesc">Class Description</label>
                        <input type="text" class="form-control" name="classdesc" placeholder="..." required>
                    </div>
                  </div>
                </div>

                <div class="row">

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Notes and Remarks</label>
                      <textarea class="form-control" name="remarks"></textarea>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>

                </div>

            </div>


  				</div>

          <div class="box-footer">
            <div class="col-md-4">
              <button type="submit" class="btn btn-primary btn-flat btn-block">Submit</button>
            </div>
          </div>

        </form>

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
	<script>
  $(function () {



  });
	</script>

  <script>
  $(function () {

    // Get the form.
	   $('#addform').submit(function(e) {
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
              url: './ajax/class/new.php',
              data: $('#addform').serialize(),
              success: function (results) {
        				swal.close();
                console.log(results);
                var o = jQuery.parseJSON(results);
        				if(o.result === "success") {
                  swal({title: "Submit success",
                    text: "Record has been successfully saved.",
                    type:"success"})
                  .then(function () {
                    window.location.replace('./class.php?page=list');
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
