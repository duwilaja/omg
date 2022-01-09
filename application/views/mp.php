<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$bu=base_url()."adminlte310";

$data["title"]="Media Plan";
$data["menu"]="mp";
$data["pmenu"]="";
$data["session"]=$session;
$data["bu"]=$bu;

$t="t_mediaplans";
$sql="select mpnumber,client,product,campaign,po,FORMAT(startdt,'YYYY-MM-DD') as stdt,FORMAT(enddt,'YYYY-MM-DD') as endt,FORMAT(submitdt,'YYYY-MM-DD') as submdt,curr,stts,rowid from $t";
$cq="mpnumber,client,product,campaign,po,FORMAT(startdt,'YYYY-MM-DD') as stdt,FORMAT(enddt,'YYYY-MM-DD') as endt,FORMAT(submitdt,'YYYY-MM-DD') as submdt,curr,stts";

$sql="select mpnumber,client,product,campaign,po,startdt,enddt,submitdt,curr,stts,rowid from $t";
$cq="mpnumber,client,product,campaign,po,(startdt) as stdt,(enddt) as endt,(submitdt) as submdt,curr,stts";

$c="mpnumber,client,product,campaign,po,startdt,enddt,submitdt,curr,stts";

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
              <li class="breadcrumb-item"></li>
              <li class="breadcrumb-item active"></li>
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
					<button class="btn btn-success" onclick="reloadTable()"><i class="fas fa-sync"></i></button>
					<button class="btn btn-primary" onclick="openf()"><i class="fas fa-plus"></i></button>
				</div>
			</div>
			<div class="card-body">
                <table id="example1" class="table table-sm table-bordered table-striped">
                  <thead>
					  <tr>
						<th>MP#</th>
						<th>Client</th>
						<th>Product</th>
						<th>Campaign</th>
						<th>PO#</th>
						<th>Start</th>
						<th>End</th>
						<th>Submission</th>
						<th>Currency</th>
						<th>Status</th>
						<th>Attachments</th>
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
		  <h4 class="modal-title"><?php echo $data['title']?> Form</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span>
		  </button>
		</div>
		<div class="modal-body">
		  
		  <div class="card">
		  <!-- form start -->
		  <form id="myf" class="">
		  <input type="hidden" name="rowid" id="rowid" value="0">
		  <input type="hidden" name="flag" id="flag" value="SAVE">
		  <input type="hidden" name="table" value="<?php echo base64_encode($t)?>">
		  <input type="hidden" name="cols" value="<?php echo base64_encode($c)?>">
		  
			<div class="card-body">
				<div class="row">
				  <div class="form-group col-md-6">
					<label for="" class="col-form-label">MP#</label>
					<div class="input-group">
					  <input type="text" readonly name="mpnumber" class="form-control form-control-sm" id="mpnumber" placeholder="[auto]">
					</div>
				  </div>
				  <div class="form-group col-md-6">
					<label for="" class="col-form-label">Client</label>
					<div class="input-group">
					  <select name="client" class="form-control form-control-sm" id="client" placeholder="..." onchange="clientChange(this.value);">
					  </select>
					</div>
				  </div>
				</div>
				<div class="row">
				  <div class="form-group col-md-6">
					<label for="" class="col-form-label">Product</label>
					<div class="input-group">
					  <select name="product" class="form-control form-control-sm" id="product" placeholder="...">
					  </select>
					</div>
				  </div>
				  <div class="form-group col-md-6">
					<label for="" class="col-form-label">Campaign</label>
					<div class="input-group">
					  <input type="text" name="campaign" class="form-control form-control-sm" id="campaign" placeholder="...">
					</div>
				  </div>
				</div>
				<div class="row">
				  <div class="form-group col-md-6">
					<label for="" class="col-form-label">PO#</label>
					<div class="input-group">
					  <input type="text" name="po" class="form-control form-control-sm" id="po" placeholder="...">
					  <!--div class="input-group-append">
						<button class="input-group-text"><i class="fas fa-table"></i></button>
					  </div-->
					</div>
				  </div>
				  <div class="form-group col-md-6">
					<label for="" class="col-form-label">Period</label>
					<div class="row">
					<div id="periodstart" class="col-md-6 input-group date" data-target-input="nearest">
					  
                        <input type="text" name="startdt" id="stdt" class="form-control datetimepicker-input form-control-sm" data-target="#periodstart">
                        <div class="input-group-append" data-target="#periodstart" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                    
					</div>
					<div id="periodend" class="col-md-6 input-group date" data-target-input="nearest">
					  
                        <input type="text" name="enddt" id="endt" class="form-control datetimepicker-input form-control-sm" data-target="#periodend">
                        <div class="input-group-append" data-target="#periodend" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                    
					</div>
					</div>
				  </div>
				</div>
				<div class="row">
				  <div class="form-group col-md-4">
					<label for="" class="col-form-label">Submission Date</label>
					<div id="subdt" class="input-group date" data-target-input="nearest">
					  
                        <input type="text" name="submitdt" id="submdt" class="form-control datetimepicker-input form-control-sm" data-target="#subdt">
                        <div class="input-group-append" data-target="#subdt" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                    
					</div>
				  </div>
				  <div class="form-group col-md-4">
					<label for="" class="col-form-label">Currency</label>
					<div class="input-group">
					  <input type="text" name="curr" class="form-control form-control-sm" id="curr" placeholder="...">
					</div>
				  </div>
				  <div class="form-group col-md-4">
					<label for="" class="col-form-label">Status</label>
					<div class="input-group">
					  <!--input type="text" name="stts" class="form-control form-control-sm" id="stts" placeholder="..."-->
					  <select name="stts" class="form-control form-control-sm" id="stts" placeholder="...">
						<option value=""></option>
						<option value="Pending">Pending</option>
						<option value="Ongoing">Ongoing</option>
						<option value="Completed">Completed</option>
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

  <div class="modal fade" id="modal-attach">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">Attachments</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span>
		  </button>
		</div>
		<div class="modal-body">
			
			
			<table id="example2" class="table table-sm table-bordered table-striped" style="width:100%;">
			  <thead>
				  <tr>
					<th>MP#</th>
					<th>Version</th>
					<th>File</th>
				  </tr>
			  </thead>
			  <tbody>
			  </tbody>
			</table>
		</div>
		<div class="modal-footer">
			<button class="btn btn-success" onclick="mytbla.ajax.reload();"><i class="fas fa-sync"></i></button>
			<button class="btn btn-primary" onclick="openfa()"><i class="fas fa-plus"></i></button>
			
		</div>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
  </div>
  
  <div class="modal fade" id="modal-frma">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div id="ovl-attach" class="overlay" style="display:none;">
			<i class="fas fa-2x fa-sync fa-spin"></i>
		</div>
		<div class="modal-header">
		  <h4 class="modal-title">Attachment Form</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span>
		  </button>
		</div>
		<div class="modal-body">
		  
		  <div class="card">
		  <!-- form start -->
		  <form id="myfa" class="form-horizontal">
		  <input type="hidden" name="rowid" id="rowida" value="0">
		  <input type="hidden" name="flag" id="flaga" value="SAVE">
		  <input type="hidden" name="table" value="<?php echo base64_encode("t_mpversion")?>">
		  <input type="hidden" name="cols" value="<?php echo base64_encode("mp,ver,attc")?>">
		  
		  <input type="hidden" name="attc"  id="attc" value="">
		  
			<div class="card-body">
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">MP#</label>
				<div class="col-sm-8 input-group">
				  <input type="text" name="mp" readonly class="form-control form-control-sm" id="mp" placeholder="...">
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">Version</label>
				<div class="col-sm-8 input-group">
				  <input type="text" name="ver" class="form-control form-control-sm" id="ver" placeholder="...">
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">File</label>
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
		  <button type="button" id="btndela" class="btn btn-danger" onclick="savefa(true)">Delete</button>
		  <button type="button" class="btn btn-primary" onclick="savefa();">Save</button>
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
$cw="1=1";
$ccc="prodid as v,prodname as t";
$cct="t_products";
$pcc="ponumber as v,ponumber as t";
$pct="t_po";

$sqla="select mp,ver,attc,rowid from t_mpversion";

?>
<script>
var  mytbl, mytbla;
var mpnb='';
$(document).ready(function(){
	document_ready();
	mytbl = $("#example1").DataTable({
		serverSide: false,
		processing: true,
		ajax: {
			type: 'POST',
			url: bu+'mp/datatable',
			data: function (d) {
				d.s= '<?php echo base64_encode($sql); ?>';
			}
		}
	});
	mytbla = $("#example2").DataTable({
		serverSide: false,
		processing: true,
		ajax: {
			type: 'POST',
			url: bu+'mp/attachments',
			data: function (d) {
				d.w= mpnb,
				d.s= '<?php echo base64_encode($sqla); ?>';
			}
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
		  product: {
			required: true
		  },
		  campaign: {
			required: true
		  },
		  uaccess: {
			required: true
		  },
		  umail: {
			  required: true,
			  email: true
		  }
		}
	});
	$("#myfa").validate({
	rules: {
		  ver: {
			required: true
		  },
		  uploadedfile:{
			  required: function(element){
					if($("#rowida").val()==0) return true;
					
					return false;
			  }
		  }
		}
	});
	
	getCombo("md/gets",'<?php echo base64_encode($ct)?>','<?php echo base64_encode($cc)?>','<?php echo base64_encode($cw)?>','#client');
	initDatePicker(["#periodend","#periodstart","#subdt"]);
});

function reloadTable(frm=''){
	if(frm=='#myf'||frm=='') mytbl.ajax.reload();
	if(frm=='#myfa') mytbla.ajax.reload();
}
function openf(id=0){
	$("#rowid").val(id);
	openForm('#myf','#modal-frm','mp/get','#ovl',id,'<?php echo base64_encode($t)?>','<?php echo base64_encode($cq)?>')
}
function savef(del=false){
	$("#flag").val('SAVE');
	if(del) $("#flag").val('DEL');
	saveForm('#myf','mp/sv','#ovl',del,'#modal-frm');
}
function clientChange(tv,dv='',dv2=''){
	var ccw=btoa("client='"+tv+"'");
	getCombo("md/gets",'<?php echo base64_encode($cct)?>','<?php echo base64_encode($ccc)?>',ccw,'#product',dv);
	//getCombo("md/gets",'<?php echo base64_encode($pct)?>','<?php echo base64_encode($pcc)?>',ccw,'#po',dv2);
}
function formLoaded(frm,modal,overlay,data=""){
	if(frm=='#myf'){
		var dv='';
		var dv2='';
		if(data!="") {
			dv=data['product'];
			dv2=data['po'];
		}
		//log('dv='+dv);
		clientChange($('#client').val(),dv,dv2);
	}
}

//attachments
function attach(mpn){
	$("#modal-attach").modal("show");
	mpnb=mpn;
	mytbla.ajax.reload();
}
function openfa(id=0){
	openForm('#myfa','#modal-frma','mp/get','#ovl-attach',id,'<?php echo base64_encode("t_mpversion")?>','<?php echo base64_encode("mp,ver,attc")?>');
	$("#mp").val(mpnb);
	$("#rowida").val(id);
	if(id==0){
		$("#btndela").hide();
	}else{
		$("#btndela").show();
	}
}
function savefa(del=false){
	$("#flaga").val('SAVE');
	if(del) $("#flaga").val('DEL');
	saveForm('#myfa','mp/sva','#ovl-attach',del,'#modal-frma');
}
</script>
</body>
</html>
