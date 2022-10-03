
  <!-- bootstrap datepicker -->
  <link href="./public/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" tyoe="text/css" />




<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Center
        <small>New</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>eCMS Panabo</a></li>
        <li class="active">Center</li>
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
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="centername">Center name</label>
                        <input type="text" class="form-control" name="centername" placeholder="Enter name..." required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="brgy">Barangay</label>
                        <select name="brgy" class="form-control" required >
                          <option value="" disabled selected>Select brgy...</option>
                          <?php foreach($brgy AS $b) :
                            if($legend == "") {
                              $legend = $b["add_value"][0];
                              echo '<optgroup label="' . $legend . '">';
                            } else {
                              if($legend <> $b["add_value"][0]) {
                                echo '</optgroup>';
                                $legend = $b["add_value"][0];
                                echo '<optgroup label="' . $legend . '">';
                              }
                            }

                            ?>
                            <?= '<option value="' . $b["add_value"] . '">' . $b["add_value"] . '</option>' ?>
                          <?php endforeach; ?>
                        </select>
                    </div>
                  </div>

                </div>

                <div class="row">

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Remarks</label>
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
              url: './ajax/center/new.php',
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
                    window.location.replace('./center.php?page=list');
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
