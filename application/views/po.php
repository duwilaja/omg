<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$bu=base_url()."adminlte310";

$data["title"]="Client's PO";
$data["menu"]="po";
$data["pmenu"]="docs";
$data["session"]=$session;
$data["bu"]=$bu;

$sql="select ponumber,client,mp,podt as pdt,curr,amt,attc,rowid from t_po";
$cq="ponumber,client,mp,podt as pdt,curr,amt,attc";
$c="ponumber,client,mp,podt,curr,amt,attc";
$t="t_po";

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
              <li class="breadcrumb-item active">Client's PO</li>
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
					  </tr>
					  <tr>
						<th>PO#</th>
						<th>Client</th>
						<th>MP#</th>
						<th>Date</th>
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
				<label for="" class="col-sm-4 col-form-label">PO#</label>
				<div class="col-sm-8 input-group">
				  <input type="text" name="ponumber" class="form-control form-control-sm" id="ponumber" placeholder="...">
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">Client</label>
				<div class="col-sm-8 input-group">
				  <select name="client" class="form-control form-control-sm" id="client" placeholder="..." onchange="clientChange(this.value);">
				  </select>
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">Media Plan</label>
				<div class="col-sm-8 input-group">
				  <select name="mp" class="form-control form-control-sm" id="mp" placeholder="...">
				  </select>
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">PO Date</label>
				<div class="col-sm-8 input-group date" id="podate"  data-target-input="nearest">
					    <input type="text" name="podt" id="pdt" class="form-control datetimepicker-input form-control-sm" data-target="#podate">
                        <div class="input-group-append" data-target="#podate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                        </div>
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">Currency#</label>
				<div class="col-sm-8 input-group">
				  <select name="curr" class="form-control form-control-sm" id="curr" placeholder="...">
					<option value=""></option>
					<option value="IDR">IDR</option>
					<option value="USD">USD</option>
					<option value="SGD">SGD</option>
				  </select>
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">Amount</label>
				<div class="col-sm-8 input-group">
				  <input type="text" name="amt" class="form-control form-control-sm" id="amt" placeholder="...">
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
			url: bu+'po/datatable',
			data: function (d) {
				d.s= '<?php echo base64_encode($sql); ?>';
			}
		},
		initComplete: function(){
			filterDatatable(mytbl,[1,4]);
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
		  ponumber: {
			required: true
		  },
		  mp: {
			required: true
		  },
		  curr: {
			required: true
		  },
		  podt: {
			required: true
		  },
		  amt: {
			required: true
		  },
		  umail: {
			  required: true,
			  email: true
		  }
		}
	});
	getCombo("po/gets",'<?php echo base64_encode($ct)?>','<?php echo base64_encode($cc)?>','<?php echo base64_encode($cw)?>','#client');
	initDatePicker(["#podate"]);
});

function reloadTable(frm=''){
	mytbl.ajax.reload(function(){filterDatatable(mytbl,[1,4])},false);
}

function openf(id=0){
	$("#rowid").val(id);
	openForm('#myf','#modal-frm','po/get','#ovl',id,'<?php echo base64_encode($t)?>','<?php echo base64_encode($cq)?>')
}
function savef(del=false){
	$("#flag").val('SAVE');
	if(del) $("#flag").val('DEL');
	saveForm('#myf','po/sv','#ovl',del,'#modal-frm');
}

function clientChange(tv,dv=''){
	var ccw=btoa("client='"+tv+"' order by mpnumber");
	getCombo("mo/gets",'<?php echo base64_encode("t_mediaplans")?>','<?php echo base64_encode("mpnumber as v,mpnumber as t")?>',ccw,'#mp',dv);
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
