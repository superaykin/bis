
  <!-- bootstrap datepicker -->
  <link href="./public/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" tyoe="text/css" />
  <!-- DataTables -->
  <link rel="stylesheet" href="./public/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


  <div class="modal fade" id="verifymodal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-aqua-active">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">PROFILE VERIFICATION</h4>
        </div>

        <div class="modal-body">
          <!-- <h4 class="rheader bg-primary">SIMILAR PROFILES WITHIN THE SYSTEM</h4> -->
          <table id="restable" class="table table-striped table-border">
            <thead>
              <th>Lastname</th>
              <th>Firstname</th>
              <th>Middlename</th>
              <th>Suffix</th>
              <th>Birthdate</th>
              <th></th>
            </thead>
            <tbody id="resultstable">

            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile
        <small>Registration</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>BIS Panabo</a></li>
        <li class="active">Profile</li>
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

                <h4 class="rheader bg-primary">Basic Information</h4>
                <div class="row">

                  <div class="col-md-3">
                    <div id="fgrp" class="form-group">
                        <label for="firstname">Firstname</label>
                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Enter firstname..." required>
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div id="mgrp" class="form-group">
                        <label for="middlename">Middlename</label>
                        <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Enter middlename..." >
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div id="lgrp" class="form-group">
                        <label for="lastname">Lastname</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Enter lastname..." required>
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div id="sgrp" class="form-group">
                        <label for="suffix">Suffix</label>
                        <input type="text" class="form-control" name="suffix" id="suffix" placeholder="Enter suffix..." >
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>

                  <div class="col-md-1">
                    <div class="form-group">
                      <input type="hidden" name="etracs_objid" id="etracs_objid" required />
                      <label style="color:white;">Verify</label>
                      <button type="button" id="searchbtn" class="btn btn-block btn-flat btn-warning"><i class="fa fa-search"></i>Verify</button>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div id="ngrp" class="form-group">
                        <label for="nickname">Nickname</label>
                        <input type="text" class="form-control" name="nickname" id="nickname" placeholder="Enter nickname..." />
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>


                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="address">Address (City)</label>
                        <select id="city" name="city" class="form-control" required>
                          <option value="" disabled selected>Select city...</option>
                          <?php foreach($city AS $c) : ?>
                            <?= '<option value="' . $c["add_value"] . '">' . $c["add_value"] . ' (' . strtolower($c["add_type"]) . ')</option>' ?>
                          <?php endforeach; ?>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="brgy">Address (Barangay)</label>
                        <select name="brgy" id="brgy" class="form-control" required>
                          <option value="" disabled selected>Select brgy...</option>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="address">Home</label>
                        <input type="text" class="form-control" name="home" placeholder="House No./Purok/Street/Subd." required >
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>


                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="mtop">Sex</label>
                        <select name="sex" class="form-control" required>
                          <option value="" disabled selected>Select sex...</option>
                          <option value="MALE">MALE</option>
                          <option value="FEMALE">FEMALE</option>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control" name="dob" id="dob" placeholder="MM/DD/YYYY" required>
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="address">Place of Birth</label>
                        <input type="text" class="form-control" name="placeofbirth" placeholder="City, Province, Region..." required >
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="address">Birth order</label>
                        <input type="number" class="form-control" name="birthorder" required />
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label>Birth Registered</label>
                        <select name="birthregistered" class="form-control" required>
                          <option value="" disabled selected>Select one...</option>
                          <option value="YES">YES</option>
                          <option value="NO">NO</option>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label for="address">No of siblings</label>
                        <input type="number" class="form-control" name="siblings" required />
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                        <label>Religion</label>
                        <select name="religion" class="form-control" required>
                          <option value="" hidden disabled selected>Select religion...</option>

                          <?php $legend = "";
                            foreach($religion AS $rel) :
                              if($legend == "") {
                                $legend = $rel["religion"][0];
                                echo '<optgroup label="' . $legend . '">';
                              } else {
                                if($legend <> $rel["religion"][0]) {
                                  echo '</optgroup>';
                                  $legend = $rel["religion"][0];
                                  echo '<optgroup label="' . $legend . '">';
                                }
                              }
                          ?>

                            <?= '<option value="' . $rel["religion"] . '">' . $rel["religion"] . '</option>' ?>
                          <?php endforeach; ?>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label>Ethnicity</label>
                        <select name="ethnicity" class="form-control" required>
                          <option value="" hidden disabled selected>Select ethnic group...</option>
                          <optgroup label="UNCATEGORIZED">
                            <option value="">NO ETHNICITY</option>
                            <option value="">NOT AVAILABLE</option>
                          </optgroup>
                          <?php $legend = "";
                            foreach($ethnicity AS $e) :
                              if($legend == "") {
                                $legend = $e["ethnicity"][0];
                                echo '<optgroup label="' . $legend . '">';
                              } else {
                                if($legend <> $e["ethnicity"][0]) {
                                  echo '</optgroup>';
                                  $legend = $e["ethnicity"][0];
                                  echo '<optgroup label="' . $legend . '">';
                                }
                              }
                          ?>

                            <?= '<option value="' . $e["ethnicity"] . '">' . $e["ethnicity"] . '</option>' ?>
                          <?php endforeach; ?>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>



                </div>
                <h4 class="rheader bg-primary">Parents / Guardian Information</h4>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                        <label>Mother Name</label>
                        <input type="text" name="mothername" class="form-control" class="form-control" />
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label>Father Name</label>
                        <input type="text" name="fathername" class="form-control" class="form-control" />
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label>Guardian Name</label>
                        <input type="text" name="guardianname" class="form-control" class="form-control" />
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label>Contact No.</label>
                        <input type="text" name="contactno" class="form-control" class="form-control" placeholder="09XX-XXX-XXXX" />
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>



                <h4 class="rheader bg-primary">IP's / 4P's / PWD</h4>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                        <label>IPS Member</label>
                        <select name="ips" class="form-control" required>
                          <option value="" disabled selected>Select one...</option>
                          <option value="YES">YES</option>
                          <option value="NO">NO</option>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label>4PS Member</label>
                        <select name="fourps" class="form-control" required>
                          <option value="" disabled selected>Select one...</option>
                          <option value="YES">YES</option>
                          <option value="NO">NO</option>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label>PWD</label>
                        <select name="pwd" class="form-control" required>
                          <option value="" disabled selected>Select one...</option>
                          <option value="YES">YES</option>
                          <option value="NO">NO</option>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>



                <hr/>
                <div class="row">

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Profile Remarks</label>
                      <textarea class="form-control" name="remarks"></textarea>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>

                </div>

            </div>


  				</div>

          <div class="box-footer">
            <div class="col-md-3 pull-right">
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
  <!-- DataTables -->
	<script src="./public/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="./public/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

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
              url: './ajax/entity/register.php',
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
                    //window.location.replace('./applicant.php?page=list');
                    window.location.replace('./entity.php?page=info&id=' + o.eid);
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


      $(document).on('change','#city',function() {
       $('#brgy').empty();
       var city = $('#city').val();
       $.ajax({
           type: 'post',
           url: './ajax/get/get_add_child.php',
           data: { "city" : city },
           success: function (results) {
             //console.log(results);
             var r = jQuery.parseJSON(results);
             var te = '<option value="" disabled selected>Select brgy...</option>';
             if(r.status == "SUCCESS") {
               var legend = "";
               $.each(r.data, function(index, obj) {
                 if(legend == "") {
                   legend = obj.add_value.charAt(0);
                   te = te + '<optgroup label="' + legend + '">';
                 } else {
                   if(legend != obj.add_value.charAt(0)) {
                     te = te + '</optgroup>';
                     legend = obj.add_value.charAt(0);
                     te = te + '<optgroup label="' + legend + '">';
                   }
                 }
                 te = te + '<option value="' + obj.add_value + '">' + obj.add_value + '</option>';
               });
             } else {
               swal("Empty!", "No Results found in our database", "error");
             }
             // change the table element
             console.log(te);
             $('#brgy').html(te);
           },
          error: function(results) {
            console.log(results);
            swal("Error!", "Unexpected error occur!", "error");
          }
       });
     });


     $(document).on("click", "#searchbtn", function(e) {
          e.preventDefault();
          var ln = $('#lastname').val();
          var fn = $('#firstname').val();
          var mn = $('#middlename').val();

          $.ajax({
              type : 'post',
              url : './ajax/entity/lookup.php',
              data :  { ln : ln, fn : fn, mn : mn },
              success : function(res) {
                console.log(res);
                $('#verifymodal').modal('toggle');
                var r = jQuery.parseJSON(res);
                var te = '';
                if(r.status == "SUCCESS") {
                  $.each(r.data, function(index, obj) {
                    te = te + '<tr>';
                    te = te + '<td>' + obj.lastname  + '</td>';
                    te = te + '<td>' + obj.firstname  + '</td>';
                    te = te + '<td>' + obj.middlename  + '</td>';
                    te = te + '<td>' + obj.suffix  + '</td>';
                    te = te + '<td>' + obj.birthdate  + '</td>';
                    te = te + '<td><a href="./entity.php?page=info&id=' + obj.eid + '" target="_blank" class="btn btn-xs btn-primary btn-flat btn-block">View</a></td>';
                  });
                }

                $('#resultstable').html(te);

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
