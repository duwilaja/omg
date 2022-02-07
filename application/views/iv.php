<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$bu=base_url()."adminlte310";

$data["title"]="Supplier's Invoice";
$data["menu"]="iv";
$data["pmenu"]="docs";
$data["session"]=$session;
$data["bu"]=$bu;

$sql="select invno,client,mp,mo,invdt as idt,supplier,curr,amt,attc,rowid from t_invoices";
$cq="invno,client,mp,mo,invdt as idt,supplier,curr,amt,attc,ss";
$c="invno,client,mp,mo,invdt,supplier,curr,amt,attc,ss";
$t="t_invoices";

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
              <li class="breadcrumb-item active">Supplier's Invoice</li>
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
						<th style="padding-right: 4px;"></th>
						<th style="padding-right: 4px;"></th>
						<th style="padding-right: 4px;"></th>
						<th style="padding-right: 4px;"></th>
					  </tr>
					  <tr>
						<th>Invoice#</th>
						<th>Client</th>
						<th>MP#</th>
						<th>MO#</th>
						<th>Date</th>
						<th>Supplier</th>
						<th>Currency</th>
						<th>Amount</th>
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
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div id="ovl" class="overlay" style="display:none;">
			<i class="fas fa-2x fa-sync fa-spin"></i>
		</div>
		<div class="modal-header">
		  <h4 class="modal-title"><?php echo $data['title']?> Details</h4>
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
			<div class="row">
			  <div class="form-group col-md-6">
				<label for="" class="col-form-label">Invoice#</label>
				<div class="input-group">
				  <input type="text" name="invno" class="form-control form-control-sm" id="invno" placeholder="...">
				</div>
			  </div>
			  <div class="form-group col-md-6">
				<label for="" class="col-form-label">Invoice Date</label>
				<div class="input-group date" id="idate"  data-target-input="nearest">
					    <input type="text" name="invdt" id="idt" class="form-control datetimepicker-input form-control-sm" data-target="#idate">
                        <div class="input-group-append" data-target="#idate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                        </div>
				</div>
			  </div>
			</div>
			<div class="row">
			  <div class="form-group col-md-6">
				<label for="" class="col-form-label">Client</label>
				<div class="input-group">
				  <select name="client" class="form-control form-control-sm" id="client" placeholder="..." onchange="clientChange(this.value);">
				  </select>
				</div>
			  </div>
			  <div class="form-group col-md-6">
				<label for="" class="col-form-label">Media Plan</label>
				<div class="input-group">
				  <select name="mp" class="form-control form-control-sm" id="mp" placeholder="...">
				  </select>
				</div>
			  </div>
			</div>
			<div class="row">
			  <div class="form-group col-md-6">
				<label for="" class="col-form-label">Supplier</label>
				<div class="input-group">
				  <select name="supplier" class="form-control form-control-sm" id="supplier" placeholder="...">
				  </select>
				</div>
			  </div>
			  <div class="form-group col-md-6">
				<label for="" class="col-form-label">MO#</label>
				<div class="input-group">
				  <input type="text" name="mo" class="form-control form-control-sm" id="mo" placeholder="...">
				</div>
			  </div>
			</div>
			<div class="row">
			  <div class="form-group col-md-6">
				<label for="" class="col-form-label">Currency</label>
				<div class="input-group">
				  <select name="curr" class="form-control form-control-sm" id="curr" placeholder="...">
					<option value=""></option>
					<option value="IDR">IDR</option>
					<option value="USD">USD</option>
					<option value="SGD">SGD</option>
				  </select>
				</div>
			  </div>
			  <div class="form-group col-md-6">
				<label for="" class="col-form-label">Amount</label>
				<div class="input-group">
				  <input type="text" name="amt" class="form-control form-control-sm" id="amt" placeholder="...">
				</div>
			  </div>
			</div>
			<div class="row">
			  <div class="form-group col-md-6">
				<label for="" class="col-form-label">Attachment</label>
				<div class="input-group">
				  <input type="file" name="uploadedfile" class="form-control form-control-sm" id="uploadedfile" placeholder="...">
				</div>
			  </div>
			  <div class="form-group col-md-6">
				<label for="" class="col-form-label">Screenshot User</label>
				<div class="input-group">
				  <select name="ss" class="form-control form-control-sm" id="ss" placeholder="...">
				  </select>
				</div>
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
			url: bu+'iv/datatable',
			data: function (d) {
				d.s= '<?php echo base64_encode($sql); ?>';
			}
		},
		initComplete: function () {
            filterDatatable(mytbl,[1,5]);
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
		  invdt: {
			required: true
		  },
		  invno: {
			required: true
		  },
		  mp: {
			required: true
		  },
		  mo:{
			required: true
		  },
		  ss:{
			required: true
		  },
		  curr: {
			required: true
		  },
		  amt: {
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
	getCombo("iv/gets",'<?php echo base64_encode($ct)?>','<?php echo base64_encode($cc)?>','<?php echo base64_encode($cw)?>','#client');
	getCombo("iv/gets",'<?php echo base64_encode($st)?>','<?php echo base64_encode($sc)?>','<?php echo base64_encode($sw)?>','#supplier');
	getCombo("md/gets",'<?php echo base64_encode("t_users")?>','<?php echo base64_encode("uid as v,uname as t")?>','<?php echo base64_encode(" 1=1 order by uname")?>','#ss');
	initDatePicker(["#idate"]);
});

function reloadTable(frm){
	mytbl.ajax.reload(function(){filterDatatable(mytbl,[1,5])},false);
}

function openf(id=0){
	$("#rowid").val(id);
	openForm('#myf','#modal-frm','iv/get','#ovl',id,'<?php echo base64_encode($t)?>','<?php echo base64_encode($cq)?>')
}
function savef(del=false){
	$("#flag").val('SAVE');
	if(del) $("#flag").val('DEL');
	saveForm('#myf','iv/sv','#ovl',del,'#modal-frm');
}


function clientChange(tv,dv='',dv2=''){
	var ccw=btoa("client='"+tv+"' order by mpnumber");
	getCombo("iv/gets",'<?php echo base64_encode("t_mediaplans")?>','<?php echo base64_encode("mpnumber as v,mpnumber as t")?>',ccw,'#mp',dv);
	//getCombo("md/gets",'<?php echo base64_encode("")?>','<?php echo base64_encode("")?>',ccw,'#po',dv2);
}
function formLoaded(frm,modal,overlay,data=""){
	if(frm=='#myf'){
		var dv='';
		if(data!="") {
			dv=data['mp'];
		}
		//log('dv='+dv);
		clientChange($('#client').val(),dv);
	}
}
</script>
</body>
</html>
