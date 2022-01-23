<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$bux=base_url();
?>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo --
    <a href="welcome/home" class="brand-link">
      <img src="<?php echo $bu;?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">MP Workflow</span>
    </a-->
	<a href="" class="brand-link navbar-light">
		<img src="<?php echo $bu;?>/my/img/logo.png" alt="Omnicon Media Global" class="brand-image" />
	</a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) --
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $bu;?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div-->

      <!-- SidebarSearch Form --
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div-->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?php echo $bux;?>welcome/home" class="nav-link home">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Home
              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="<?php echo $bux;?>mp" class="nav-link mp">
              <i class="nav-icon fas fa-ad"></i>
              <p>
                Media Plan
              </p>
            </a>
          </li>
		  <!--li class="nav-item">
            <a href="<?php echo $bux;?>task" class="nav-link task">
              <i class="nav-icon fas fa-tasks"></i>
              <p>
                My Task
              </p>
            </a>
          </li-->
		  <li class="nav-item docs">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Supporting Docs
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $bux?>po" class="nav-link po">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Client's PO</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $bux?>mo" class="nav-link mo">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Media Order</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo $bux?>iv" class="nav-link iv">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Supplier Invoice</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo $bux?>ss" class="nav-link ss">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Screenshot</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $bux?>bp" class="nav-link bp">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Billing</p>
                </a>
              </li>
            </ul>
          </li>
		  <li class="nav-item master">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Master Data
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $bux?>md/?p=clients" class="nav-link clients">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Client</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $bux?>md/?p=products" class="nav-link products">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $bux?>md/?p=suppliers" class="nav-link suppliers">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Supplier</p>
                </a>
              </li>
            </ul>
          </li>
          <!--li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Simple Link
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li-->
		  <li class="nav-item reporting">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Reporting
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $bux;?>r/?v=rmp" class="nav-link rmp">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Media Plan</p>
                </a>
              </li>
              <!--li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Statistic</p>
                </a>
              </li-->
            </ul>
          </li>
		  <!--li class="nav-item setting">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $bux?>md/?p=usergrps" class="nav-link usergrps">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>User Group</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Workflow</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Notification</p>
                </a>
              </li>
            </ul>
          </li-->
		
		</ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark ">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5><?php echo $session["uname"]?></h5>
      <p><?php echo $session["ugrp"]?></p>
    </div>
	<nav class="mt-2">
		<ul class="nav nav-sidebar flex-column">
		  <li class="nav-item">
			<a href="<?php echo $bux?>md/?p=users" class="nav-link users">
			  <i class="nav-icon fas fa-users"></i>
			  <p>
				User List
			  </p>
			</a>
		  </li>
		  <li class="nav-item">
			<a href="#" onclick="resetForm('#fpwd')" data-toggle="modal" data-target="#modal-pwd" class="nav-link">
			  <i class="nav-icon fas fa-user-lock"></i>
			  <p>
				Change Password
			  </p>
			</a>
		  </li>
		  <li class="nav-item">
			<a href="<?php echo $bux?>sign/out" class="nav-link">
			  <i class="nav-icon fas fa-sign-out-alt"></i>
			  <p>
				Sign Out
			  </p>
			</a>
		  </li>
		</ul>
	</nav>
  </aside>
  <!-- /.control-sidebar -->
  
  