<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$bu=base_url()."adminlte310";

$data["title"]="Billing";
$data["menu"]="bp";
$data["pmenu"]="docs";
$data["session"]=$session;
$data["bu"]=$bu;

$sql="select billno,billdt,client,mp,curr,amt,attc,rowid from t_billings";
$cq="billno,billdt as bdt,client,mp,curr,amt,attc";
$c="billno,billdt,client,mp,curr,amt,attc";
$t="t_billings";

$sql="select * from q_bill";

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
              <li class="breadcrumb-item active">Billing</li>
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
			<div class="form-group col-md-4">
				<label for="" class="col-form-label">Client</label>
				<select class="form-control form-control-sm select2" id="clnt" placeholder="...">
				</select>
			</div>
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
					  </tr>
					  <tr>
						<th>Client Invoice#</th>
						<th>Date</th>
						<th>Client</th>
						<th>MP#</th>
						<th>Currency</th>
						<th>Amount exc.VAT</th>
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
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">Client Invoice#</label>
				<div class="col-sm-8 input-group">
				  <input type="text" name="billno" class="form-control form-control-sm" id="billno" placeholder="...">
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">Billing Date</label>
				<div class="col-sm-8 input-group date" id="bdate"  data-target-input="nearest">
					    <input type="text" name="billdt" id="bdt" class="form-control datetimepicker-input form-control-sm" data-target="#bdate">
                        <div class="input-group-append" data-target="#bdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                        </div>
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">Client</label>
				<div class="col-sm-8 input-group">
				  <select name="client" class="form-control form-control-sm select2" id="client" placeholder="..." onchange="clientChange(this.value);">
				  </select>
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">MP#</label>
				<div class="col-sm-8 input-group">
				  <select name="mp" class="form-control form-control-sm select2" id="mp" placeholder="...">
				  </select>
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">Currency</label>
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
				<label for="" class="col-sm-4 col-form-label">Amount exc.VAT</label>
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

  <div class="modal fade" id="modal-attach">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title attach-title">Attachments</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span>
		  </button>
		</div>
		<div class="modal-body table-responsive">
			
			
			<table id="example2" class="table table-sm table-bordered table-striped" style="width:100%;">
			  <thead>
				  <tr>
					<th>Client Invoice#</th>
					<th>Doc.</th>
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
		  <h4 class="modal-title attach-title">Attachments Form</h4>
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
		  <input type="hidden" name="table" value="<?php echo base64_encode("t_billdoc")?>">
		  <input type="hidden" name="cols" value="<?php echo base64_encode("billing,doc,attc")?>">
		  
		  <input type="hidden" name="attc"  id="attc" value="">
		  
			<div class="card-body">
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">Client Invoice#</label>
				<div class="col-sm-8 input-group">
				  <input type="text" name="billing" readonly class="form-control form-control-sm" id="billing" placeholder="...">
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">Doc. Name</label>
				<div class="col-sm-8 input-group">
				  <input type="text" name="doc" class="form-control form-control-sm" id="doc" placeholder="...">
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
$cw=$session['ugrp']==''?'1=1':"clientid in (".$session['ugrp'].")";
$cw.=" order by clientname";

$where=' where 1=1';
if($session["ugrp"]!=""){
	$where=" where client in (".$session['ugrp'].")";
}

$sc="suppid as v,suppname as t";
$st="t_suppliers";
$sw="1=1 order by suppname";

$sqla="select billing,doc,attc,rowid from t_billdoc";
?>
<script>
var  mytbl,mytbla;
var bnb='';
$(document).ready(function(){
	$("#df").val("<?php echo date('Y-m-').'01'?>"); $("#dt").val("<?php echo date('Y-m-t')?>");
	document_ready();
	mytbl = $("#example1").DataTable({
		serverSide: false,
		processing: true,
		ajax: {
			type: 'POST',
			url: bu+'bp/datatable',
			data: function (d) {
				d.s= '<?php echo base64_encode($sql); ?>',
				d.w= '<?php echo base64_encode($where); ?>',
				d.clnt=$("#clnt").val(),
				d.df= $('#df').val(),
				d.dt= $('#dt').val();
			}
		},
		initComplete: function () {
            filterDatatable(mytbl,[2,4]);
		}
	});
	/*mytbla = $("#example2").DataTable({
		serverSide: false,
		processing: true,
		ajax: {
			type: 'POST',
			url: bu+'bp/attachments',
			data: function (d) {
				d.w= bnb,
				d.s= '<?php echo base64_encode($sqla); ?>';
			}
		}
	});
	*/
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
		  billdt: {
			required: true
		  },
		  billno: {
			required: true
		  },
		  mp: {
			required: true
		  },
		  amt: {
			required: true
		  },
		  curr: {
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
		  doc: {
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
	getCombo("bp/gets",'<?php echo base64_encode($ct)?>','<?php echo base64_encode($cc)?>','<?php echo base64_encode($cw)?>','#client');
	getCombo("bp/gets",'<?php echo base64_encode($ct)?>','<?php echo base64_encode($cc)?>','<?php echo base64_encode($cw)?>','#clnt','','--- All ---');
	initDatePicker(["#bdate","#dari","#sampai"]);
});

function reloadTable(frm=''){
	if(frm=='#myf'||frm=='') mytbl.ajax.reload(function(){filterDatatable(mytbl,[2,4])},false);
//	if(frm=='#myfa') mytbla.ajax.reload();
}

function openf(id=0){
	$("#rowid").val(id);
	openForm('#myf','#modal-frm','bp/get','#ovl',id,'<?php echo base64_encode("q_bill")?>','<?php echo base64_encode("*")?>')
}
function savef(del=false){
	$("#flag").val('SAVE');
	if(del) $("#flag").val('DEL');
	saveForm('#myf','bp/sv','#ovl',del,'#modal-frm');
}

var curr_mp='';
function clientChange(tv,dv=''){
	var ccw=btoa("client='"+tv+"' order by mpnumber");
	var dx='';
	dx=dv==''&&curr_mp!=''?curr_mp:dv;
	getCombo("bp/gets",'<?php echo base64_encode("t_mediaplans")?>','<?php echo base64_encode("mpnumber as v,mpnumber as t")?>',ccw,'#mp',dx);
}
function formLoaded(frm,modal,overlay,data=""){
	if(frm=='#myf'){
		var dv='';
		if(data!="") {
			dv=data['mp'];
			curr_mp=dv;
		}
		//log('dv='+dv);
		//clientChange($("#client").val(),dv);
		$("#client").trigger("change");
	}
}

//attachments
function attach(mpn){
	//$(".attach-title").html(atob(camp));
	$("#modal-attach").modal("show");
	bnb=mpn;
	mytbla.ajax.reload();
}
function openfa(id=0){
	openForm('#myfa','#modal-frma','bp/get','#ovl-attach',id,'<?php echo base64_encode("t_billdoc")?>','<?php echo base64_encode("billing,doc,attc")?>');
	$("#billing").val(atob(bnb));
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
	saveForm('#myfa','bp/sva','#ovl-attach',del,'#modal-frma');
}

</script>
</body>
</html>
