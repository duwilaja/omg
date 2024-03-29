<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$bu=base_url()."adminlte310";

$data["title"]="Home";
$data["menu"]="home";
$data["pmenu"]="";
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
              <li class="breadcrumb-item"><a href="#"></a></li>
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
	  
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-tasks"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pending Tasks</span>
                <span class="info-box-number"><a href="<?php echo base_url()?>mp?w=p">MP <span id="pending">0</span></a></span>
				<span class="info-box-number"><a href="<?php echo base_url()?>iv?w=p">SS <span id="ss_pending">0</span></a></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-people-carry"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Ongoing Tasks</span>
                <span class="info-box-number"><a href="<?php echo base_url()?>mp?w=o">MP <span id="ongoing">0</span></a></span>
				<span class="info-box-number"><a href="<?php echo base_url()?>iv?w=o">SS <span id="ss_ongoing">0</span></a></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-money-check-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Completed Tasks</span>
                <span class="info-box-number"><a href="<?php echo base_url()?>mp?w=c">MP <span id="completed">0</span></a></span>
				<span class="info-box-number"><a href="<?php echo base_url()?>iv?w=c">SS <span id="ss_completed">0</span></a></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
		
        <div class="row">
          <div class="col-md-6">
            <!-- PIE CHART -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">MP Pending Tasks</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <!--button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button-->
				  <a class="btn btn-tool" title="More..." href="<?php echo base_url()?>mp?w=p">
                    <i class="fas fa-ellipsis-h"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-sm table-bordered table-striped">
				  <thead>
				  <tr>
					<th>MP#</th>
					<th>Client</th>
					<th>Product</th>
					<th>Approver</th>
				  </tr>
				  </thead>
				  <tbody>
				  <?php for($i=0;$i<count($pending);$i++){?>
				  <tr>
					<td><?php echo $pending[$i]["mpnumber"]?></td>
					<td><?php echo $pending[$i]["client"]?></td>
					<td><?php echo $pending[$i]["product"]?></td>
					<td><?php echo $pending[$i]["approver"]?></td>
				  </tr>
				  <?php }
				  if($i==0){
					  echo '<tr><td colspan="4" align="center">No data found</td></tr>';
				  }?>
				  </tbody>
				</table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-6">
            <!-- LINE CHART -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">MP Ongoing Tasks</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <!--button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button-->
				  <a class="btn btn-tool" title="More..." href="<?php echo base_url()?>mp?w=o">
                    <i class="fas fa-ellipsis-h"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-sm table-bordered table-striped">
				  <thead>
				  <tr>
					<th>MP#</th>
					<th>Client</th>
					<th>Product</th>
					<th>Approver</th>
				  </tr>
				  </thead>
				  <tbody>
				  <?php for($i=0;$i<count($ongoing);$i++){?>
				  <tr>
					<td><?php echo $ongoing[$i]["mpnumber"]?></td>
					<td><?php echo $ongoing[$i]["client"]?></td>
					<td><?php echo $ongoing[$i]["product"]?></td>
					<td><?php echo $ongoing[$i]["approver"]?></td>
				  </tr>
				  <?php }
				  if($i==0){
					  echo '<tr><td colspan="4" align="center">No data found</td></tr>';
				  }
				  ?>
				  </tbody>
				</table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
	  
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
$this->load->view("_foot",$data);
?>
<script>
var total=<?php echo json_encode($tot)?>;
var totss=<?php echo json_encode($totss)?>;
var pwd=<?php echo (date("Y-m-d",strtotime($session["lastupd"]))<=date("Y-m-d",strtotime("-3 month")))?"true":"false"; ?>;
//var line1="";
$(document).ready(function(){
	document_ready();
//	line();
//	pie();
	tot();
	if(pwd) {
		$("#modal-pwd").modal("show");
		alrt("Your password is expired, please change","warning");
	}
});
function tot(){
	$.each(total,function(key,val){
		$("#"+key).html(val);
	});
	for(var i=0;i<totss.length;i++){
		var x=totss[i]["stts"].replace(" ","_").toLowerCase();
		//log(x);
		$("#"+x).html(totss[i]["cnt"]);
	}
}
</script>
</body>
</html>
