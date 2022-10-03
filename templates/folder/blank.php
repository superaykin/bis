
  <!-- bootstrap datepicker -->
  <link href="./public/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" tyoe="text/css" />


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        ECCD
        <small>Report</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>E-AMS Panabo</a></li>
        <li class="active">Applicant</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

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
        title: prompttitle,
        text: promptmessage,
        type: 'info',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            type: 'post',
            url: './ajax/applicant/add_new_applicant.php',
            data: $('#addform').serialize(),
            success: function (results) {
      				swal.close();
              var o = jQuery.parseJSON(results);
      				if(o.result === "success") {
                swal({title: "Submit success",
                  text: "Record has been successfully saved.",
                  type:"success"})
                .then(function () {
                  //window.location.replace('./applicant.php?page=list');
                  window.location.replace('./applicant.php?page=profile&id=' + o.applicantid);
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
