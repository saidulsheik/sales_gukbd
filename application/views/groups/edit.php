

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage <small>Groups</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url('groups/') ?>">Groups</a></li>
			<li class="active">Edit</li>
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
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Edit Group</h3> </div>
								<form role="form" action="<?php base_url('groups/update') ?>" method="post">
									<div class="box-body">
										<?php echo validation_errors(); ?>
											<div class="form-group">
												<label for="group_name">Group Name</label>
												<input type="text" class="form-control" id="group_name" name="group_name" placeholder="Enter group name" value="<?php echo $group_data['group_name']; ?>"> </div>
											<div class="form-group">
												<label for="permission">Permission</label>
												<?php $serialize_permission = unserialize($group_data['permission']); ?>
													<table class="table table-bordered table-striped table-responsive">
														<thead>
															<tr>
																<th></th>
																<th>Create</th>
																<th>Update</th>
																<th>View</th>
																<th>Delete</th>
															</tr>
															<tr>
																<td></td>
																<td>
																	<input type="checkbox" value="all_view" id="all_view">
																</td>
																<td>
																	<input type="checkbox" value="all_add" id="all_add">
																</td>
																<td>
																	<input type="checkbox" value="all_edit" id="all_edit">
																</td>
																<td>
																	<input type="checkbox" value="all_delete" id="all_delete">
																</td>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Users</td>
																<td>
																	<input type="checkbox" class="minimal" name="permission[]" id="permission" class="minimal" value="createUser" <?php if($serialize_permission) { if(in_array( 'createUser', $serialize_permission)) { echo "checked"; } } ?>> </td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateUser" <?php if($serialize_permission) { if(in_array( 'updateUser', $serialize_permission)) { echo "checked"; } } ?>> </td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewUser" <?php if($serialize_permission) { if(in_array( 'viewUser', $serialize_permission)) { echo "checked"; } } ?>> </td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteUser" <?php if($serialize_permission) { if(in_array( 'deleteUser', $serialize_permission)) { echo "checked"; } } ?>> </td>
															</tr>
															<tr>
																<td>Groups</td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="createGroup" <?php if($serialize_permission) { if(in_array( 'createGroup', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateGroup" <?php if($serialize_permission) { if(in_array( 'updateGroup', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewGroup" <?php if($serialize_permission) { if(in_array( 'viewGroup', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteGroup" <?php if($serialize_permission) { if(in_array( 'deleteGroup', $serialize_permission)) { echo "checked"; } } ?>></td>
															</tr>
															<tr>
																<td>Brands</td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="createBrand" <?php if($serialize_permission) { if(in_array( 'createBrand', $serialize_permission)) { echo "checked"; } } ?>></td>
																	<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateBrand" <?php if($serialize_permission) { if(in_array( 'updateBrand', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewBrand" <?php if($serialize_permission) { if(in_array( 'viewBrand', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteBrand" <?php if($serialize_permission) { if(in_array( 'deleteBrand', $serialize_permission)) { echo "checked"; } } ?>></td>
															</tr>
															<tr>
																<td>Category</td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="createCategory" <?php if($serialize_permission) { if(in_array( 'createCategory', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateCategory" <?php if($serialize_permission) { if(in_array( 'updateCategory', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewCategory" <?php if($serialize_permission) { if(in_array( 'viewCategory', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteCategory" <?php if($serialize_permission) { if(in_array( 'deleteCategory', $serialize_permission)) { echo "checked"; } } ?>></td>
															</tr>
															<tr>
																<td>Stores</td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="createStore" <?php if($serialize_permission) { if(in_array( 'createStore', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateStore" <?php if($serialize_permission) { if(in_array( 'updateStore', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewStore" <?php if($serialize_permission) { if(in_array( 'viewStore', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteStore" <?php if($serialize_permission) { if(in_array( 'deleteStore', $serialize_permission)) { echo "checked"; } } ?>></td>
															</tr>
															<tr>
																<td>Attributes</td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="createAttribute" <?php if($serialize_permission) { if(in_array( 'createAttribute', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateAttribute" <?php if($serialize_permission) { if(in_array( 'updateAttribute', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewAttribute" <?php if($serialize_permission) { if(in_array( 'viewAttribute', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteAttribute" <?php if($serialize_permission) { if(in_array( 'deleteAttribute', $serialize_permission)) { echo "checked"; } } ?>></td>
															</tr>
															<tr>
																<td>Products</td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="createProduct" <?php if($serialize_permission) { if(in_array( 'createProduct', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateProduct" <?php if($serialize_permission) { if(in_array( 'updateProduct', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewProduct" <?php if($serialize_permission) { if(in_array( 'viewProduct', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteProduct" <?php if($serialize_permission) { if(in_array( 'deleteProduct', $serialize_permission)) { echo "checked"; } } ?>></td>
															</tr>
															<tr>
																<td>Orders</td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="createOrder" <?php if($serialize_permission) { if(in_array( 'createOrder', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateOrder" <?php if($serialize_permission) { if(in_array( 'updateOrder', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewOrder" <?php if($serialize_permission) { if(in_array( 'viewOrder', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteOrder" <?php if($serialize_permission) { if(in_array( 'deleteOrder', $serialize_permission)) { echo "checked"; } } ?>></td>
															</tr>
															<!-- Branch Permission Edit -->
															
															
															
															<tr>
																<td>Branches</td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="createBranch" <?php if($serialize_permission) { if(in_array( 'createBranch', $serialize_permission)) { echo "checked"; } } ?>> </td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateBranch" <?php if($serialize_permission) { if(in_array( 'updateBranch', $serialize_permission)) { echo "checked"; } } ?>> </td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewBranch" <?php if($serialize_permission) { if(in_array( 'viewBranch', $serialize_permission)) { echo "checked"; } } ?>> </td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteBranch" <?php if($serialize_permission) { if(in_array( 'deleteBranch', $serialize_permission)) { echo "checked"; } } ?>> </td>
															</tr>
															<!-- Branch Permission Edit End -->
															<!-- Business Group Permission -->
															<tr>
																<td>Business Group</td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="createBusinessGroup" <?php if($serialize_permission) { if(in_array( 'createBusinessGroup', $serialize_permission)) { echo "checked"; } } ?>> </td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateBusinessGroup" <?php if($serialize_permission) { if(in_array( 'updateBusinessGroup', $serialize_permission)) { echo "checked"; } } ?>> </td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewBusinessGroup" <?php if($serialize_permission) { if(in_array( 'viewBusinessGroup', $serialize_permission)) { echo "checked"; } } ?>> </td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteBusinessGroup" <?php if($serialize_permission) { if(in_array( 'deleteBusinessGroup', $serialize_permission)) { echo "checked"; } } ?>> </td>
															</tr>
															<!-- Business Group Permission End-->
															
															<!-- Vendors Permission -->
															<tr>
																<td>Vendors</td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="createVendors" <?php if($serialize_permission) { if(in_array( 'createVendors', $serialize_permission)) { echo "checked"; } } ?>> </td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateVendors" <?php if($serialize_permission) { if(in_array( 'updateVendors', $serialize_permission)) { echo "checked"; } } ?>> </td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewVendors" <?php if($serialize_permission) { if(in_array( 'viewVendors', $serialize_permission)) { echo "checked"; } } ?>> </td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteVendors" <?php if($serialize_permission) { if(in_array( 'deleteVendors', $serialize_permission)) { echo "checked"; } } ?>> </td>
															</tr>
															<!-- Vendors Permission End-->
															
															 <!-- Supplier Edit Start-->
														<tr>
															<td>Suppliers</td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createSupplier" <?php if($serialize_permission) {
															  if(in_array('createSupplier', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateSupplier" <?php if($serialize_permission) {
															  if(in_array('updateSupplier', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewSupplier" <?php if($serialize_permission) {
															  if(in_array('viewSupplier', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteSupplier" <?php if($serialize_permission) {
															  if(in_array('deleteSupplier', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
														  </tr>
														  <!-- Supplier Edit End-->
															
															
														<!-- Product Receive Start-->
														<tr>
															<td>Product Receive</td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createProductReceive" <?php if($serialize_permission) {
															  if(in_array('createProductReceive', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateProductReceive" <?php if($serialize_permission) {
															  if(in_array('updateProductReceive', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewProductReceive" <?php if($serialize_permission) {
															  if(in_array('viewProductReceive', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteProductReceive" <?php if($serialize_permission) {
															  if(in_array('deleteProductReceive', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
														</tr>
														<!-- Product Receive End-->
														
														<!-- Product Price Setup Start-->
														<tr>
															<td>Price Setup</td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createProductPrice" <?php if($serialize_permission) {
															  if(in_array('createProductPrice', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateProductPrice" <?php if($serialize_permission) {
															  if(in_array('updateProductPrice', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewProductPrice" <?php if($serialize_permission) {
															  if(in_array('viewProductPrice', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteProductPrice" <?php if($serialize_permission) {
															  if(in_array('deleteProductPrice', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
														</tr>
														<!-- Product Price Setup End-->
														
														<!-- Demand-->
														<tr>
															<td>Demand</td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createDemand" <?php if($serialize_permission) {
															  if(in_array('createDemand', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateDemand" <?php if($serialize_permission) {
															  if(in_array('updateDemand', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewDemand" <?php if($serialize_permission) {
															  if(in_array('viewDemand', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteDemand" <?php if($serialize_permission) {
															  if(in_array('deleteDemand', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
														</tr>
														<!--Demand Configuration End-->
														
														<!-- Demand Configuration Start-->
														<tr>
															<td>Demand Configuration</td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createDemandConfiguration" <?php if($serialize_permission) {
															  if(in_array('createDemandConfiguration', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateDemandConfiguration" <?php if($serialize_permission) {
															  if(in_array('updateDemandConfiguration', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewDemandConfiguration" <?php if($serialize_permission) {
															  if(in_array('viewDemandConfiguration', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
															<td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteDemandConfiguration" <?php if($serialize_permission) {
															  if(in_array('deleteDemandConfiguration', $serialize_permission)) { echo "checked"; } 
															} ?>></td>
														</tr>
														<!--Demand Configuration End-->
															
														
															<tr>
																<td>Reports</td>
																<td> - </td>
																<td> - </td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewReports" <?php if($serialize_permission) { if(in_array( 'viewReports', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td> - </td>
															</tr>
															<tr>
																<td>Company</td>
																<td> - </td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateCompany" <?php if($serialize_permission) { if(in_array( 'updateCompany', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td> - </td>
																<td> - </td>
															</tr>
															<tr>
																<td>Profile</td>
																<td> - </td>
																<td> - </td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewProfile" <?php if($serialize_permission) { if(in_array( 'viewProfile', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td> - </td>
															</tr>
															<tr>
																<td>Setting</td>
																<td>-</td>
																<td>
																	<input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateSetting" <?php if($serialize_permission) { if(in_array( 'updateSetting', $serialize_permission)) { echo "checked"; } } ?>></td>
																<td> - </td>
																<td> - </td>
															</tr>
														</tbody>
													</table>
											</div>
									</div>
									<!-- /.box-body -->
									<div class="box-footer">
										<button type="submit" class="btn btn-primary">Update Changes</button> <a href="<?php echo base_url('groups/') ?>" class="btn btn-warning">Back</a> </div>
								</form>
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
<script type="text/javascript">
$(document).ready(function() {
	$("#mainGroupNav").addClass('active');
	$("#manageGroupNav").addClass('active');
	$('input[type="checkbox"].minimal').iCheck({
		checkboxClass: 'icheckbox_minimal-blue',
		radioClass: 'iradio_minimal-blue'
	});
});
</script>