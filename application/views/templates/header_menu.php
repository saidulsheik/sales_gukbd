<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url('') ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SLDP</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>CDIP SLDP</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			<span class="sr-only">Toggle navigation</span> &nbsp;&nbsp;
			
		</a>
	<div>
		<h4 class="text-justify" style="color:white">
			<b>
				<?php echo 'Branch Name: ' .$this->session->userdata('branch_name'); ?>(<?php echo $this->session->userdata('branch_code'); ?>)
				<br><?php echo 'Software Date : '. date('d-m-Y', strtotime($this->session->userdata('soft_date_inv'))); ?>
			</b>
		</h4>
	</div>
    </nav>
  </header>
  
  <!-- Left side column. contains the logo and sidebar -->
  