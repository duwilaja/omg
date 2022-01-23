<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$bu=base_url()."adminlte310";

$data["title"]="Media Plan";
$data["menu"]="rmp";
$data["pmenu"]="reporting";
$data["session"]=$session;
$data["bu"]=$bu;

$this->load->view("_head",$data);
$this->load->view("_navbar",$data);
$this->load->view("_sidebar",$data);
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $data["title"]?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">Reporting</li>
              <li class="breadcrumb-item active">Media Plan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
	  
		<div class="card">
			<!--div class="card-header">
				<div class="card-tools">
					<button class="btn btn-success btn-sm" onclick="reloadTable()"><i class="fas fa-sync"></i></button>
					<button class="btn btn-primary btn-sm" onclick="openf()"><i class="fas fa-plus"></i></button>
				</div>
			</div-->
			<div class="card-body table-responsive">
                <table id="example1" class="table table-sm table-bordered table-striped">
                  <thead>
					  <tr>
						<th style="padding-right: 4px;"></th>
						<th style="padding-right: 4px;"></th>
						<th style="padding-right: 4px;"></th>
						<th style="padding-right: 4px;"></th>
						<th style="padding-right: 4px;"></th>
						<th style="padding-right: 4px;"></th>
						<th style="padding-right: 4px;"></th>
						<th style="padding-right: 4px;"></th>
					  </tr>
					  <tr>
						<th>MP#</th>
						<th>Client</th>
						<th>Product</th>
						<th>Start</th>
						<th>End</th>
						<th>Invoice#</th>
						<th>Screenshot</th>
						<th>Billing#</th>
					  </tr>
                  </thead>
                  <tbody>
				  </tbody>
				</table>
			</div>
		</div>

	  
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
$this->load->view("_foot",$data);

$sql="select * from q_rmp";
?>
<script>
var mytbl;
$(document).ready(function(){
	document_ready();
	mytbl = $("#example1").DataTable({
		serverSide: false,
		processing: true,
		buttons: ["copy", "excel"],
		ajax: {
			type: 'POST',
			url: bu+'r/datatable',
			data: function (d) {
				d.s= '<?php echo base64_encode($sql); ?>';
			}
		},
		initComplete: function(){
			filterDatatable(mytbl,[1,2]);
			mytbl.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
		}
	});
})
</script>
</body>
</html>
