
<!-- DataTables -->
<link rel="stylesheet" href="./public/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Class Transfer
        <small>List</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>eCMS Panabo</a></li>
        <li class="active">Class Transfer</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
    		<div class="col-xs-12">
    			<div class="box box-widget">
    				<div class="box-header with-border bg-primary">

    				</div>
    				<!-- /.box-header -->
    				<div class="box-body">
              <div class="table-responsive">

                  <table id="translist" class="table table-bordered table-hover">
        						<thead>
        							<tr>
                        <th>Requestor</th>
                        <th>Student Name</th>
                        <th>Origin Class</th>
                        <th>Target Class</th>
                        <th>Request Date</th>
                        <th></th>
        							</tr>
        						</thead>
        						<tbody>
                      <?php foreach($requests AS $r) : ?>
                        <?= '<tr>' ?>
                          <?= '<td>' . $r["requestor"] . '</td>' ?>
                          <?= '<td>' . $r["student"] . '</td>' ?>
                          <?= '<td>' . $r["origin_code"] . '</td>' ?>
                          <?= '<td>' . $r["target_code"] . '</td>' ?>
                          <?= '<td>' . $r["transfer_date"] . '</td>' ?>
                          <?= '<td><a href="./class.php?page=transreqinfo&tid=' . $r["ctid"] . '" class="btn btn-xs btn-flat btn-block btn-primary">View</a></td>' ?>
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



  });
	</script>

  <script>
  $(function () {

    $('#classlist').DataTable({
      "order": [[ 4, "desc" ]]
    });




  });
  </script>


  <?php
	// render footer 2
	require("./templates/layouts/footer_end.php");
  ?>
