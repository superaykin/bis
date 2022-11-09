
  <!-- bootstrap datepicker -->
  <link href="./public/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" tyoe="text/css" />




<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        ECCD
        <small>Test Information</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>eCMS Panabo</a></li>
        <li class="active">ECCD</li>
      </ol>
    </section>

    <section class="content">

  			<div class="box box-widget">
  				<!-- /.box-header -->


  				<div class="box-body">
            <form id="editform" role="form" data-toggle="validator" method="post" accept-charset="utf-8" enctype="multipart/form-data" autocomplete="off">
              <div class="col-md-12">

                <div class="alert alert-info alert-dismissible">
                  <h4><i class="icon fa fa-info"></i> A friendly reminder.</h4>
                  In case of wrong input, please contact the CSWDO system administrator for the edit of the submitted scores.
                </div>

                <h4 class="rheader bg-primary">Child Information</h4>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="classname">Lastname</label>
                        <input type="text" class="form-control input-sm" value="<?= $info["lastname"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="classname">Firstname</label>
                        <input type="text" class="form-control input-sm" value="<?= $info["firstname"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="classname">Middlename</label>
                        <input type="text" class="form-control input-sm" value="<?= $info["middlename"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="classname">Suffix</label>
                        <input type="text" class="form-control input-sm" value="<?= $info["suffix"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="classname">Sex</label>
                        <input type="text" class="form-control input-sm " value="<?= $info["sex"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="classname">Date of Birth</label>
                        <input type="date" class="form-control input-sm" value="<?= $info["birthdate"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="classname">Address</label>
                        <input type="text" class="form-control input-sm" value="<?= get_address_bydata($info); ?>" readonly />
                    </div>
                  </div>

                </div>

                <h4 class="rheader bg-primary">ECCD Test Information</h4>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="classname">Center</label>
                        <input type="text" class="form-control input-sm" value="<?= $classinfo["centername"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="classname">Tested by</label>
                        <input type="text" class="form-control input-sm" value="<?= $eccdinfo["actor_name"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="classname">Date of testing</label>
                        <input type="date" class="form-control input-sm editable" name="testdate" value="<?= $eccdinfo["test_date"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="classname">Age during Testing</label>
                        <input type="text" class="form-control input-sm editable" name="agetested" value="<?= $eccdinfo["age_tested"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="classname">Standard Score</label>
                        <input type="text" class="form-control input-sm" value="<?= $eccdinfo["standard_score"] ?>" readonly />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="classname">Scaled Score</label>
                        <input type="text" class="form-control input-sm" value="<?= $eccdinfo["scaled_score"] ?>" readonly />
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Test Remarks</label>
                      <textarea class="form-control input-sm remarks" name="remarks" readonly><?= $eccdinfo["remarks"] ?></textarea>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>



                </div>



                <?php $c = ""; $a = $eccdinfo["interpretation"];
                if (strpos($a, 'AVERAGE') !== false) { $c = "callout-warning"; }
                else if (strpos($a, 'HIGHLY') !== false) { $c = "callout-info"; }
                else if (strpos($a, 'SLIGHTLY') !== false) { $c = "callout-success"; }
                else { $c = "callout-danger"; }
                ?>
                <div class="callout <?= $c ?> text-center">
                  <h4><?= $a ?></h4>
                  <p>Interpretation</p>
                </div>

                <div class="row">
                  <?php foreach($eccdscore AS $es) : ?>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label><?= $es["eccd_id"] ?></label>
                        <input type="hidden" value="<?= $es["es_id"] ?>" name="eccd_score_id[]" />
                        <input type="number" class="form-control input-sm editable" name="eccd_score[]" value="<?= $es["score"] ?>" readonly />
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>




                <?php if(lookup_role('CLASS_ADMIN') <> false) : ?>
                  <hr/>
                  <div class="row">

                    <div class="col-md-3" id="editdiv">
                      <div class="form-group">
                        <button type="button" id="editbtn" class="btn btn-warning btn-flat btn-block">Edit scores</button>
                      </div>
                    </div>

                    <div class="col-md-3 pull-right" id="submitdiv" style="display:none;">
                      <div class="form-group">
                        <input type="hidden" name="test_id" value="<?= $eccdinfo["test_id"] ?>" />
                        <input type="hidden" name="studentid" value="<?= $info["eid"] ?>" />
                        <button type="submit" class="btn btn-primary btn-flat btn-block">Submit</button>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>

              </div>


            </form>

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
	<script>
  $(function () {



  });
	</script>

  <script>
  $(function () {

    // Get the form.
	   $('#editform').submit(function(e) {
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
              url: './ajax/eccd/edit.php',
              data: $('#editform').serialize(),
              success: function (results) {
        				swal.close();
                console.log(results);
                var o = jQuery.parseJSON(results);
        				if(o.result === "success") {
                  swal({title: "Submit success",
                    text: "Record has been successfully updated.",
                    type:"success"})
                  .then(function () {
                    location.reload();
                  });
        				}
                else if(o.result === "failed") {
                  swal({
                    title: "Error!",
                    text: "errrooooooooooooooooooooooorrrr!",
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


      $('#editbtn').on('click', function(e) {
        e.preventDefault();

        $('.editable').prop('readonly', false);
        $('.remarks').prop('readonly', false);
        $('.editable').prop('required', true);
        $('#editdiv').hide();
        $('#submitdiv').css('display', 'block');
      });





  });
  </script>


  <?php
	// render footer 2
	require("./templates/layouts/footer_end.php");
  ?>
