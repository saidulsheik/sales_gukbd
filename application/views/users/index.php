

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage
        <small>Users</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">

          <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('success'); ?>
            </div>
          <?php elseif($this->session->flashdata('error')): ?>
            <div class="alert alert-error alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('error'); ?>
            </div>
          <?php endif; ?>
          
		  
		<?php if(in_array('createUser', $user_permission)): ?>
          <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add User</button>
          <br /> <br />
		<?php endif; ?>
		
          <?php if(in_array('createUser', $user_permission)): ?>
            <!--a href="<?php //echo base_url('users/create') ?>" class="btn btn-primary">Add User</a>
            <br /> <br /-->
          <?php endif; ?>


          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Manage Users</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="userTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Zone</th>
                  <th>Area</th>
                  <!--th>Name</th-->
                  <th>Branch</th>
                  <th>User Name</th>
                  <th>Can Transfer</th>
                  <th>Allow Branch</th>
                  <th>Role Name</th>
                  <?php if(in_array('updateUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
                  <th>Action</th>
                  <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                 
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php if(in_array('createUser', $user_permission)): ?>
<!-- create brand modal -->
<div class="modal fade" tabindex="" role="dialog" id="addModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add New User</h4>
      </div>
		<?php 
		  /* echo '<pre>';
		  print_r($stores);
		  echo '</pre>'; */
		?>
      <form role="form" action="<?php echo base_url('users/create') ?>" method="post" id="createForm" autocomplete="off" >
        <div class="modal-body">
		
			<div class="form-group">
			   <label for="group_id">Groups</label>
			   <select class="form-control select_group" id="group_id" name="group_id" style="width: 100%; margin-top: -8px !important;" required>
				<option value="">Select Groups</option>
				<?php foreach ($group_data as $k => $v): ?>
				  <option value="<?php echo $v['id'] ?>"><?php echo $v['group_name'] ?></option>
				<?php endforeach ?>
			   </select>
			</div> 
		  
		 
			<!--div class="form-group">
				<label for="store_id">Default Store</label>
				<select class="form-control select_group" id="store_id" name="store_id" style="width: 100%; margin-top: -8px !important;" required>
					<option value="">Selet Default Store</option>
					<?php foreach($stores as $key=>$value){ ?>
						<option value="<?php echo $value['id']; ?>"><?php echo $value['store_code']; ?></option>
					<?php } ?>
					
				</select>
			</div-->
		  
			<div class="form-group">
				<label for="store_name">User Name</label>
				<input type="text" class="form-control" id="store_name" name="store_name" placeholder="Enter store name" autocomplete="off">
			</div>

			<div class="form-group">
				<label for="store_email">User Email</label>
				<input type="email" class="form-control" id="store_email" name="store_email" placeholder="Enter store email address" autocomplete="off">
			</div>
		  
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off">
			</div>

			<div class="form-group">
				<label for="cpassword">Confirm password</label>
				<input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password" autocomplete="off">
			</div>
			  
			<div class="form-group">
				<label for="active">Status</label>
				<select class="form-control" id="active" name="active">
				  <option value="1">Active</option>
				  <option value="2">Inactive</option>
				</select>
			</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>













	
  <script type="text/javascript">
    $(document).ready(function() {
		var manageTable;
		var base_url = "<?php echo base_url(); ?>";
		$(".select_group").select2();
		manageTable = $('#userTable').DataTable({
			'ajax': base_url + 'users/fetchUserData',
			'order': []
		}); 

		$("#mainUserNav").addClass('active');
		$("#manageUserNav").addClass('active');
    });
  </script>
