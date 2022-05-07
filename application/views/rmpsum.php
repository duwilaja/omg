<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$bu=base_url()."adminlte310";

$data["title"]="Media Plan Summary";
$data["menu"]="rmpsum";
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
              <li class="breadcrumb-item active">Media Plan Summary</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
	  
		<div class="card"><div class="card-body">
			<div class="row">
			<div class="form-group col-md-6">
				<label for="" class="col-form-label">From - To</label>
				<div class="row">
				<div id="dari" class="col-md-5 input-group date" data-target-input="nearest">
				  
					<input type="text" id="df" class="form-control datetimepicker-input form-control-sm" data-target="#dari">
					<div class="input-group-append" data-target="#dari" data-toggle="datetimepicker">
						<div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
					</div>
				
				</div>
				<div id="sampai" class="col-md-5 input-group date" data-target-input="nearest">
				  
					<input type="text" id="dt" class="form-control datetimepicker-input form-control-sm" data-target="#sampai">
					<div class="input-group-append" data-target="#sampai" data-toggle="datetimepicker">
						<div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
					</div>
				
				</div>
				<div class="col-md-1">
					<button class="btn btn-success btn-sm" onclick="reloadTable()"><i class="fas fa-paper-plane"></i></button>
				</div>
				</div>
			</div>
			</div>
		</div></div>
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
						<th>Budget</th>
						<th>Invoice Amount</th>
						<th>Invoice Count</th>
						<th>Screenshot Count</th>
						<th>Billing Amount</th>
						<th>Billing Count</th>
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

$sql="select * from q_rmpsum";
?>
<script>
var mytbl;

function getW(){
	var w, df, dt;
	df=$("#df").val();dt=$("#dt").val(); w=[];
	if(df!="") w.push("subdt>='"+df+"'");
	if(dt!="") w.push("subdt<='"+dt+"'");
	
	return btoa(w.join(" and "));
}

$(document).ready(function(){
	$("#df").val("<?php echo date('Y-m-').'01'?>"); $("#dt").val("<?php echo date('Y-m-t')?>");
	document_ready();
	mytbl = $("#example1").DataTable({
		serverSide: false,
		processing: true,
		buttons: ["copy", "excel"],
		ajax: {
			type: 'POST',
			url: bu+'r/datatable',
			data: function (d) {
				d.s= '<?php echo base64_encode($sql); ?>',
				d.w= getW();
			}
		},
		initComplete: function(){
			filterDatatable(mytbl,[1,2]);
			mytbl.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
		},
		columnDefs: [{
			targets: [5,6,7,8,9,10],
			render: $.fn.dataTable.render.number(',','.',0,'')
		}]
	});
	initDatePicker(["#dari","#sampai"]);
})

function reloadTable(frm=''){
	mytbl.ajax.reload(function(){filterDatatable(mytbl,[1,2])},false);
}
</script>
</body>
</html>
