<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$bu=base_url()."adminlte310";

$data["title"]="My Task";
$data["menu"]="task";
$data["pmenu"]="";
$data["session"]=$session;
$data["bu"]=$bu;

$t="t_tasks";
$sql="select mpnumber,client,product,campaign,placement,po,FORMAT(startdt,'YYYY-MM-DD') as stdt,FORMAT(enddt,'YYYY-MM-DD') as endt,FORMAT(submitdt,'YYYY-MM-DD') as submdt,curr,rowid from $t";
$cq="mpnumber,client,product,campaign,placement,po,FORMAT(startdt,'YYYY-MM-DD') as stdt,FORMAT(enddt,'YYYY-MM-DD') as endt,FORMAT(submitdt,'YYYY-MM-DD') as submdt,curr";

$sql="select dtm,taskname,assignedby,assignedto,objname,objid,stts,rowid from $t";
$cq="";

$c="stts,objid,nexttask";

if($session["uaccess"]!="ADM"){
	$sql.=" where assignedto='".$session["uid"]."' or assignedby='".$session["uid"]."'";
}

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
					<button class="btn btn-success btn-sm" onclick="reloadTable()"><i class="fas fa-sync"></i></button>
					<!--button class="btn btn-primary" onclick="openf()"><i class="fas fa-plus"></i></button-->
				</div>
			</div>
			<div class="card-body">
                <table id="example1" class="table table-sm table-bordered table-striped">
                  <thead>
					  <tr>
						<th></th>
						<th style="padding-right: 4px;"></th>
						<th style="padding-right: 4px;"></th>
						<th></th>
						<th></th>
						<th style="padding-right: 4px;"></th>
						<th style="padding-right: 4px;"></th>
						<th></th>
					  </tr>
					  <tr>
						<th>Date/Time</th>
						<th>Task</th>
						<th>Assigned By</th>
						<th>Assigned To</th>
						<th>Subject</th>
						<th>#</th>
						<th>Status</th>
						<th>Action</th>
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
		  
		  <input type="hidden" name="stts" value="Completed">
		  
		  <div class="card-body">
				<div class="row">
				  <div class="form-group col-md-6">
					<label for="" class="col-form-label">Task </label>
					<div class="input-group">
					  <input type="text" readonly name="taskname" class="form-control form-control-sm" id="taskname" placeholder="[auto]">
					</div>
				  </div>
				  <div class="form-group col-md-6">
					<label for="" class="col-form-label">Assigned By </label>
					<div class="input-group">
					  <input type="text" readonly name="assignedby" class="form-control form-control-sm" id="assignedby" placeholder="[auto]">
					</div>
				  </div>
				</div>
				<div class="row">
				  <div class="form-group col-md-6">
					<label for="" class="col-form-label">Subject </label>
					<div class="input-group">
					  <input type="text" readonly name="objname" class="form-control form-control-sm" id="objname" placeholder="[auto]">
					</div>
				  </div>
				  <div class="form-group col-md-6">
					<label for="" class="col-form-label">#</label>
					<div class="input-group">
					  <input type="text" readonly name="objid" class="form-control form-control-sm" id="objid" placeholder="[auto]">
					</div>
				  </div>
				</div>
				<div class="row">
				  <div class="form-group col-md-6">
					<label for="" class="col-form-label">Next Task </label>
					<div class="input-group">
					  <input type="text" readonly name="nexttask" class="form-control form-control-sm" id="nexttask" placeholder="-">
					</div>
				  </div>
				  <div class="form-group col-md-6 assignedto">
					<label for="" class="col-form-label">Assigned To</label>
					<div class="input-group">
					  <select name="assignedto" class="form-control form-control-sm" id="assignedto" placeholder="...">
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
$cc="uid as v,uname as t";
$ct="t_users";
$cw="1=1";
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
			url: bu+'task/datatable',
			data: function (d) {
				d.s= '<?php echo base64_encode($sql); ?>';
			}
		},
		initComplete: function () {
            this.api().columns().every( function () {
				var column = this;
				var coln=column[0][0];
				if(coln==6){
					var select = $('<select class="form-control form-control-sm"><option value=""></option></select>')
						//.appendTo( $(column.footer()).empty() )
						.appendTo( $("#example1 thead tr:eq(0) th")[coln] )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
	 
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );
	 
					column.data().unique().sort().each( function ( d, j ) {
						select.append( '<option value="'+d+'">'+d+'</option>' )
					} );
				}
            } );
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
		  curr: {
			required: true
		  },
		  submitdt: {
			required: true
		  },
		  placement: {
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
	
	getCombo("md/gets",'<?php echo base64_encode($ct)?>','<?php echo base64_encode($cc)?>','<?php echo base64_encode($cw)?>','#assignedto');
});

function reloadTable(frm=''){
	mytbl.ajax.reload();
}
function openf(id=0){
	$("#rowid").val(id);
	openForm('#myf','#modal-frm','task/get','#ovl',id,'<?php echo base64_encode($t)?>','<?php echo base64_encode($cq)?>')
}
function formLoaded(frm,modal,overlay,data){
	$(".assignedto").show();
	if(data['nexttask']=='') $(".assignedto").hide();
}
function savef(del=false){
	$("#flag").val('SAVE');
	if(del) $("#flag").val('DEL');
	saveForm('#myf','task/sv','#ovl',del,'#modal-frm');
}
function upd(id,st){
	sendData('upd','task/upd',{rowid:id,stts:st});
}
</script>
</body>
</html>
