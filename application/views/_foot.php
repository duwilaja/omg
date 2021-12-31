<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

      <div class="modal fade" id="modal-pwd">
        <div class="modal-dialog">
          <div class="modal-content">
            <div id="ovl" class="overlay" style="display:none;">
                <i class="fas fa-2x fa-sync fa-spin"></i>
            </div>
            <div class="modal-header">
              <h4 class="modal-title">Change Password</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              
              <div class="card">
              <!-- form start -->
              <form id="fpwd" class="form-horizontal">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="opwd" class="col-sm-4 col-form-label">Old Password</label>
                    <div class="col-sm-8 input-group">
                      <input type="password" name="opwd" class="form-control form-control-sm" id="opwd" placeholder="...">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="npwd" class="col-sm-4 col-form-label">New Password</label>
                    <div class="col-sm-8 input-group">
                      <input type="password" name="npwd" class="form-control form-control-sm" id="npwd" placeholder="...">
                    </div>
                  </div>
				  <div class="form-group row">
                    <label for="rpwd" class="col-sm-4 col-form-label">Retype</label>
                    <div class="col-sm-8 input-group">
                      <input type="password" name="rpwd" class="form-control form-control-sm" id="rpwd" placeholder="...">
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </form>
			  </div>
              <!-- /.card -->
              
            </div>
            <div class="modal-footer pull-right">
              <button type="button" class="btn btn-primary" onclick="saveForm('#fpwd','sign/pwd','#ovl');">Change</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Media Plan Workflow
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2021-2022.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?php echo $bu;?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo $bu;?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- jquery-validation -->
<script src="<?php echo $bu;?>/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo $bu;?>/plugins/jquery-validation/additional-methods.min.js"></script>

<!-- SweetAlert2 -->
<script src="<?php echo $bu;?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>

<!-- ChartJS -->
<script src="<?php echo $bu;?>/plugins/chart.js/Chart.min.js"></script>


<!-- DataTables  & Plugins -->
<script src="<?php echo $bu;?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $bu;?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $bu;?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo $bu;?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo $bu;?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo $bu;?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo $bu;?>/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo $bu;?>/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo $bu;?>/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo $bu;?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo $bu;?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo $bu;?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- AdminLTE App -->
<script src="<?php echo $bu;?>/dist/js/adminlte.min.js"></script>

<!-- Custom -->
<script src="<?php echo $bu;?>/my/js/custom.js"></script>
<script>
var bu="<?php echo base_url()?>";
var menuc=".<?php echo $menu?>";
var pmenuc=".<?php echo $pmenu?>";
</script>
