<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$bu=base_url()."adminlte310";

$data["title"]="MP Numbering";
$data["menu"]="num";
$data["pmenu"]="setting";
$data["session"]=$session;
$data["bu"]=$bu;

$sql="select mpnumber,Format(submitdt,'YYYY-MM-DD') as sbdt,nr,rowid from t_mediaplans";
$c="mpnumber,Format(submitdt,'YYYY-MM-DD') as submdt,nr";
$t="t_mediaplans";

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
              <li class="breadcrumb-item">Setting</li>
              <li class="breadcrumb-item active">MP Numbering</li>
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
			<div class="card-header">
				<div class="card-tools">
					<button class="btn btn-success btn-sm" onclick="reloadTable()"><i class="fas fa-sync"></i></button>
					<!--button class="btn btn-primary btn-sm" onclick="openf()"><i class="fas fa-plus"></i></button-->
				</div>
			</div>
			<div class="card-body table-responsive">
                <table id="example1" class="table table-sm table-bordered table-striped">
                  <thead>
					  <tr>
						<th>MP Number</th>
						<th>Submit Date</th>
						<th>Counter</th>
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
		  <input type="hidden" name="cols" value="<?php echo base64_encode("submitdt,nr")?>">
		  
			<div class="card-body">
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">MP Number</label>
				<div class="col-sm-8 input-group">
				  <input readonly type="text" name="mpnumber" class="form-control form-control-sm" id="mpnumber" placeholder="...">
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">Submit Date</label>
				<div class="col-sm-8">
					<div id="subdt" class="input-group date" data-target-input="nearest">
					  
						<input type="text" name="submitdt" id="submdt" class="form-control datetimepicker-input form-control-sm" data-target="#subdt">
						<div class="input-group-append" data-target="#subdt" data-toggle="datetimepicker">
							<div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
						</div>
					
					</div>
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-4 col-form-label">Counter</label>
				<div class="col-sm-8 input-group">
				  <input type="text" name="nr" class="form-control form-control-sm number" id="nr" placeholder="...">
				</div>
			  </div>
			</div>
			<!-- /.card-body -->
		  </form>
		  </div>
		  <!-- /.card -->
		  
		</div>
		<div class="modal-footer pull-right">
		  <!--button type="button" id="btndel" class="btn btn-danger" onclick="savef(true)">Delete</button-->
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
var tm='<?php echo date('Y-m-').'01'?>';
var tt='<?php echo date('Y-m-t')?>';
var s='<?php echo base64_encode($sql); ?>';

function getS(){
	var w, df, dt, clnt;
	df=$("#df").val();dt=$("#dt").val(); w=[];
	clnt=$("#clnt").val();
	
	if(df==""){
		df=tm;
		$("#df").val(tm);
	}	
	w.push("Format(submitdt,'YYYY-MM-DD')>='"+df+"'");
	if(dt==""){
		dt=tt;
		$("#dt").val(tt);
	}
	w.push("Format(submitdt,'YYYY-MM-DD')<='"+dt+"'");
	//if(clnt!="") w.push("clientname='"+clnt+"'");
	
	return btoa(atob(s)+' WHERE '+w.join(" and "));
}

var  mytbl;
$(document).ready(function(){
	document_ready();
	mytbl = $("#example1").DataTable({
		serverSide: false,
		processing: true,
		ajax: {
			type: 'POST',
			url: bu+'md/datatable',
			data: function (d) {
				d.s= getS();
			}
		}
	});
	$("#myf").validate({
		rules: {
		  grpid: {
			required: true
		  },
		  upwd: {
			required: function(element){
					if($("#rowid").val()==0) return true;
					
					return false;
				}
		  },
		  grpname: {
			required: true
		  },
		  ugrp: {
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
	})
	
	//getCombo("md/gets",'<?php echo base64_encode($ct)?>','<?php echo base64_encode($cc)?>','<?php echo base64_encode($cw)?>','#grpname');
	initDatePicker(["#subdt","#dari","#sampai"]);
	
});

function reloadTable(frm){
	mytbl.ajax.reload();
}

function openf(id=0){
	$("#rowid").val(id);
	openForm('#myf','#modal-frm','md/get','#ovl',id,'<?php echo base64_encode($t)?>','<?php echo base64_encode($c)?>')
}
function savef(del=false){
	$("#flag").val('SAVE');
	if(del) $("#flag").val('DEL');
	saveForm('#myf','md/sv','#ovl',del,'#modal-frm');
}

function formLoaded(frm,modal,overlay,data=""){
	$("#grpname").trigger("change");
}
</script>
</body>
</html>
