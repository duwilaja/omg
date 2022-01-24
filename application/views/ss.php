<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$bu=base_url()."adminlte310";

$data["title"]="Screenshot";
$data["menu"]="ss";
$data["pmenu"]="docs";
$data["session"]=$session;
$data["bu"]=$bu;

$sql="select client,supplier,invoice,dsc,attc,rowid from t_screenshots";
$cq="client,supplier,invoice,dsc,attc";
$c="client,supplier,invoice,dsc,attc";
$t="t_screenshots";

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
              <li class="breadcrumb-item">Supporting Docs</li>
              <li class="breadcrumb-item active">Screenshot</li>
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
			<div class="card-header">
				<div class="card-tools">
					<button class="btn btn-success btn-sm" onclick="reloadTable()"><i class="fas fa-sync"></i></button>
					<button class="btn btn-primary btn-sm" onclick="openf()"><i class="fas fa-plus"></i></button>
				</div>
			</div>
			<div class="card-body table-responsive">
                <table id="example1" class="table table-sm table-bordered table-striped">
                  <thead>
					  <tr>
						<th style="padding-right: 4px;"></th>
						<th style="padding-right: 4px;"></th>
						<th style="padding-right: 4px;"></th>
						<th style="padding-right: 4px;"></th>
						<th style="padding-right: 4px;"></th>
					  </tr>
					  <tr>
						<th>Client</th>
						<th>Supplier</th>
						<th>Invoice#</th>
						<th>Description</th>
						<th>Attachment</th>
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

  <div class="modal fade" id="modal-frm">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div id="ovl" class="overlay" style="display:none;">
			<i class="fas fa-2x fa-sync fa-spin"></i>
		</div>
		<div class="modal-header">
		  <h4 class="modal-title"><?php echo $data['title']?> Form</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span>
		  </button>
		</div>
		<div class="modal-body">
		  
		  <div class="card">
		  <!-- form start -->
		  <form id="myf" class="form-horizontal">
		  <input type="hidden" name="rowid" id="rowid" value="0">
		  <input type="hidden" name="flag" id="flag" value="SAVE">
		  <input type="hidden" name="table" value="<?php echo base64_encode($t)?>">
		  <input type="hidden" name="cols" value="<?php echo base64_encode($c)?>">
		  
		  <input type="hidden" name="attc" id="attc" value="">
		  
			<div class="card-body">
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">Client</label>
				<div class="col-sm-8 input-group">
				  <select name="client" class="form-control form-control-sm" id="client" placeholder="..." onchange="csChange();">
				  </select>
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">Supplier</label>
				<div class="col-sm-8 input-group">
				  <select name="supplier" class="form-control form-control-sm" id="supplier" placeholder="..." onchange="csChange();">
				  </select>
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">Invoice#</label>
				<div class="col-sm-8 input-group">
				  <select name="invoice" class="form-control form-control-sm" id="invoice" placeholder="...">
				  </select>
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">Description</label>
				<div class="col-sm-8 input-group">
				  <input type="text" name="dsc" class="form-control form-control-sm" id="dsc" placeholder="...">
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">Attachment</label>
				<div class="col-sm-8 input-group">
				  <input type="file" name="uploadedfile" class="form-control form-control-sm" id="uploadedfile" placeholder="...">
				</div>
			  </div>
			</div>
			<!-- /.card-body -->
		  </form>
		  </div>
		  <!-- /.card -->
		  
		</div>
		<div class="modal-footer pull-right">
		  <button type="button" id="btndel" class="btn btn-danger" onclick="savef(true)">Delete</button>
		  <button type="button" class="btn btn-primary" onclick="savef();">Save</button>
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
  </div>

  
<?php
$this->load->view("_foot",$data);
$cc="clientid as v,clientname as t";
$ct="t_clients";
$cw="1=1 order by clientname";
$sc="suppid as v,suppname as t";
$st="t_suppliers";
$sw="1=1 order by suppname";
?>
<script>
var  mytbl;
$(document).ready(function(){
	document_ready();
	mytbl = $("#example1").DataTable({
		serverSide: false,
		processing: true,
		ajax: {
			type: 'POST',
			url: bu+'ss/datatable',
			data: function (d) {
				d.s= '<?php echo base64_encode($sql); ?>';
			}
		},
		initComplete: function () {
            filterDatatable(mytbl,[0,1]);
		}
	});
	$("#myf").validate({
		rules: {
		  client: {
			required: true
		  },
		  upwd: {
			required: function(element){
					if($("#rowid").val()==0) return true;
					
					return false;
				}
		  },
		  invoice: {
			required: true
		  },
		  invno: {
			required: true
		  },
		  mp: {
			required: true
		  },
		  dsc: {
			required: true
		  },
		  supplier: {
			required: true
		  },
		  umail: {
			  required: true,
			  email: true
		  }
		}
	});
	getCombo("ss/gets",'<?php echo base64_encode($ct)?>','<?php echo base64_encode($cc)?>','<?php echo base64_encode($cw)?>','#client');
	getCombo("ss/gets",'<?php echo base64_encode($st)?>','<?php echo base64_encode($sc)?>','<?php echo base64_encode($sw)?>','#supplier');
	initDatePicker(["#idate"]);
});

function reloadTable(frm){
	mytbl.ajax.reload(function(){filterDatatable(mytbl,[0,1])},false);
}

function openf(id=0){
	$("#rowid").val(id);
	openForm('#myf','#modal-frm','ss/get','#ovl',id,'<?php echo base64_encode($t)?>','<?php echo base64_encode($cq)?>')
}
function savef(del=false){
	$("#flag").val('SAVE');
	if(del) $("#flag").val('DEL');
	saveForm('#myf','ss/sv','#ovl',del,'#modal-frm');
}


function csChange(dv=''){
	var c=$("#client").val();
	var s=$("#supplier").val();
	if(c!="" && s!=""){
	var ccw=btoa("client='"+c+"' and supplier='"+s+"' order by invno");
		getCombo("ss/gets",'<?php echo base64_encode("t_invoices")?>','<?php echo base64_encode("invno as v,invno as t")?>',ccw,'#invoice',dv);
	}
}
function formLoaded(frm,modal,overlay,data=""){
	if(frm=='#myf'){
		var dv='';
		if(data!="") {
			dv=data['invoice'];
		}
		//log('dv='+dv);
		csChange(dv);
	}
}
</script>
</body>
</html>
