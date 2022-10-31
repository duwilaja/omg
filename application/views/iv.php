<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$bu=base_url()."adminlte310";

$data["title"]="Vendor Invoice";
$data["menu"]="iv";
$data["pmenu"]="docs";
$data["session"]=$session;
$data["bu"]=$bu;

$sql="select invno,client,mp,mo,invdt as idt,supplier,curr,amt,attc,ssattc,ss,creator,rowid from t_invoices";
$cq="invno,client,mp,mo,invdt as idt,supplier,curr,amt,attc,ssattc,ss";
$c="invno,client,mp,mo,invdt,supplier,curr,amt,attc,ss,ssattc";
$t="t_invoices";

$sql="select * from q_iv";

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
            <h1 class="m-0 titel"><?php echo $data["title"]?></h1>
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
						<th>Amount exc.VAT</th>
						<th>Invoice Attachment</th>
						<th>Screenshot</th>
						<th>SS By</th>
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
		  <input type="hidden" name="ssattc" id="ssattc" value="">
		  
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
				  <select name="client" class="form-control form-control-sm select2" id="client" placeholder="..." onchange="clientChange(this.value);">
				  </select>
				</div>
			  </div>
			  <div class="form-group col-md-6">
				<label for="" class="col-form-label">Media Plan</label>
				<div class="input-group">
				  <select name="mp" class="form-control form-control-sm select2" id="mp" placeholder="...">
				  </select>
				</div>
			  </div>
			</div>
			<div class="row">
			  <div class="form-group col-md-6">
				<label for="" class="col-form-label">Supplier</label>
				<div class="input-group">
				  <select name="supplier" class="form-control form-control-sm select2" id="supplier" placeholder="...">
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
				<label for="" class="col-form-label">Amount exc.VAT</label>
				<div class="input-group">
				  <input type="text" name="amt" class="form-control form-control-sm" id="amt" placeholder="...">
				</div>
			  </div>
			</div>
			<div class="row">
			  <div class="form-group col-md-6">
				<label for="" class="col-form-label">Invoice Attachment</label>
				<div class="input-group">
				  <input type="file" name="uploadedfile" class="form-control form-control-sm" id="uploadedfile" placeholder="...">
				</div>
			  </div>
			  <div class="form-group col-md-6">
				<label for="" class="col-form-label">Screenshot</label>
				<div class="input-group">
				  <select name="ss" class="form-control form-control-sm select2" id="ss" placeholder="...">
				  </select>
				  <button type="button" onclick="klon()" class="btn hidden"><a class="fas fa-plus-circle text-success"></a></button>
				  <button type="button" onclick="removeclone()" class="btn hidden"><a class="fas fa-minus-circle text-danger"></a></button>
				</div>
				<div class="ssfilesx hidden">
					<div class="row ssfilex"><div class="col-md-12">
					  <input type="file" name="ssuploadedfile[]" class="form-control form-control-sm" placeholder="...">
					</div></div>
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


  <div class="modal fade" id="modal-frma">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div id="ovl-attach" class="overlay" style="display:none;">
			<i class="fas fa-2x fa-sync fa-spin"></i>
		</div>
		<div class="modal-header">
		  <h4 class="modal-title attach-title">Screenshot</h4>
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
		  <input type="hidden" name="table" value="<?php echo base64_encode($t)?>">
		  <input type="hidden" name="cols" value="<?php echo base64_encode("ssattc")?>">
		  
		  <input type="hidden" name="ssattc" value="">
		  
			<div class="card-body">
			  <div class="form-group row hidden">
				<label for="" class="col-sm-4 col-form-label">MP#</label>
				<div class="col-sm-8 input-group">
				  <input type="text" name="mp" readonly class="form-control form-control-sm" id="mp" placeholder="...">
				</div>
			  </div>
			  <div class="form-group row hidden">
				<label for="" class="col-sm-4 col-form-label">Doc. Name</label>
				<div class="col-sm-8 input-group">
				  <input type="text" name="doc" class="form-control form-control-sm" id="doc" placeholder="...">
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">File</label>
				<div class="input-group">
				  <button type="button" onclick="klon()" class="btn"><a class="fas fa-plus-circle text-success"></a></button>
				  <button type="button" onclick="removeclone()" class="btn"><a class="fas fa-minus-circle text-danger"></a></button>
				</div>
				<div class="ssfiles">
					<div class="row ssfile"><div class="col-md-12">
					  <input type="file" name="ssuploadedfile[]" class="form-control form-control-sm" placeholder="...">
					</div></div>
				</div>
			  </div>
			</div>
			<!-- /.card-body -->
		  </form>
		  </div>
		  <!-- /.card -->
		  
		</div>
		<div class="modal-footer pull-right">
		  <!--button type="button" id="btndela" class="btn btn-danger" onclick="savefa(true)">Delete</button-->
		  <button type="button" class="btn btn-primary btnsavea" onclick="savefa();">Save</button>
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

$sc="suppid as v,suppname as t";
$st="t_suppliers";
$sw="1=1 order by suppname";

$where=' where 1=1';
if($session["ugrp"]!=""){
	$where=" where client in (".$session['ugrp'].")";
}

$ttl="";
switch($which){
	//case "": $where.=" or stts='Approved'"; break;
	case "c": $where.=" and ssattc<>''"; $ttl="(Completed)"; break;
	case "o": $where.=" and 0=1"; $ttl="(Ongoing)"; break; //always none
	case "p": $where.=" and ssattc=''"; $ttl="(Pending)"; break;
}
?>
<script>
var  mytbl;
var whoami='<?php echo $session["uid"]?>';

$(document).ready(function(){
	if("<?php echo $which?>"=="") { $("#df").val("<?php echo date('Y-m-').'01'?>"); $("#dt").val("<?php echo date('Y-m-t')?>"); }
	document_ready();
	$(".titel").html($(".titel").html()+' <?php echo $ttl?>');
	mytbl = $("#example1").DataTable({
		serverSide: false,
		processing: true,
		ajax: {
			type: 'POST',
			url: bu+'iv/datatable',
			data: function (d) {
				d.s= '<?php echo base64_encode($sql.$where); ?>',
				d.clnt=$("#clnt").val(),
				d.df= $("#df").val(),
				d.dt= $("#dt").val();
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
	getCombo("iv/gets",'<?php echo base64_encode($ct)?>','<?php echo base64_encode($cc)?>','<?php echo base64_encode($cw)?>','#clnt','','--- All ---');
	initDatePicker(["#idate","#dari","#sampai"]);
});

function reloadTable(frm){
	mytbl.ajax.reload(function(){filterDatatable(mytbl,[1,5])},false);
}

function klon(){
	$(".ssfile").clone().removeClass("ssfile").addClass("ssclone").appendTo(".ssfiles");
}
function removeclone(){
	$(".ssclone:last").remove();
}

function openf(id=0){
	$("#rowid").val(id);
	//$(".ssclone").remove();
	if(id==0){
		$("#attc").val("");
		$("#ssattc").val("");
	}
	openForm('#myf','#modal-frm','iv/get','#ovl',id,'<?php echo base64_encode("q_iv")?>','<?php echo base64_encode("*")?>')
}
function savef(del=false){
	$("#flag").val('SAVE');
	if(del) $("#flag").val('DEL');
	saveForm('#myf','iv/sv','#ovl',del,'#modal-frm');
}


function openfa(id=0){
	resetForm('#myfa');
	$('#modal-frma').modal('show');
	$("#rowida").val(id);
}
function savefa(del=false){
	$("#flaga").val('SAVE');
	saveForm('#myfa','iv/sv','#ovl-attach',del,'#modal-frma');
}

var curr_mp='';
function clientChange(tv,dv='',dv2=''){
	var ccw=btoa("client='"+tv+"' order by mpnumber");
	var dx='';
	dx=dv==''&&curr_mp!=''?curr_mp:dv;
	getCombo("iv/gets",'<?php echo base64_encode("t_mediaplans")?>','<?php echo base64_encode("mpnumber as v,mpnumber as t")?>',ccw,'#mp',dx);
	//getCombo("md/gets",'<?php echo base64_encode("")?>','<?php echo base64_encode("")?>',ccw,'#po',dv2);
}
function formLoaded(frm,modal,overlay,data=""){
	if(frm=='#myf'){
		var dv='';
		if(data!="") {
			dv=data['mp'];
			curr_mp=dv;
			if(whoami==data['ss']) $("#btndel").hide();
		}
		//log('dv='+dv);
		//clientChange($('#client').val(),dv);
		$("#client").trigger("change");
		$("#ss").trigger("change");
		$("#supplier").trigger("change");
	}
}
</script>
</body>
</html>
