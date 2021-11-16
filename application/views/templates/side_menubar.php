<aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
		<!--
		<?php
			$mainMenu=$this->session->userdata('mainMenu');
			$subMenu=$this->session->userdata('subMenu');
			$seg_array = $this->uri->segment_array();
			$url=implode("/",$seg_array);
			if(!empty($mainMenu)) {
			  foreach ($mainMenu as $value) {
				if ($value->has_sub == 0) {
				?>
					<li class="<?php echo $this->uri->segment(1) == $value->menu_path?'active':''; ?>">
                        <a   href="<?php echo base_url() . $value->menu_path; ?>">
                            <i class="<?php echo $value->menu_icon; ?>"></i>
                            <span><?php echo $value->menu_name; ?></span>
                        </a>
                    </li>
				<?php 
				}else{
					?>
						<li class="treeview <?php echo $this->uri->segment(1) == $value->menu_path?'active':'';  ?>" id="<?php echo $this->uri->segment(1);?>" >
							<a  href="">
								<i class="<?php echo $value->menu_icon; ?>"></i>
								<span><?php echo $value->menu_name; ?></span>
								 <span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								 </span>
							</a>
							<ul class="treeview-menu">
								<?php
									foreach ($subMenu as $sub_menu) {
										if ($sub_menu->menu_id == $value->menu_id) {
								?>
											<li class="<?php echo $url == $sub_menu->menu_path?'active':'';  ?>">
												<a  href="<?php echo base_url() . $sub_menu->menu_path; ?>"> 
													<i class="fa fa-circle-o"></i>
													<?php echo $sub_menu->menu_name; ?>
												</a>
											</li>
								<?php
										}
										
									}
								?>
							</ul>
						</li>
					<?php 
				}
			  }
			}
			
		?>
		
		-->
		
		
		
		
		
        <li id="dashboardMainMenu">
          <a href="<?php echo base_url('dashboard') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <?php if($user_permission): ?>
          <?php if(in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
           <li class="treeview" id="mainUserNav">
            <a href="#">
              <i class="fa fa-users"></i>
              <span>Users</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if(in_array('createUser', $user_permission)): ?>
              <li id="createUserNav"><a href="<?php echo base_url('users/create') ?>"><i class="fa fa-circle-o"></i> Add User</a></li>
              <?php endif; ?>

              <?php if(in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
              <li id="manageUserNav"><a href="<?php echo base_url('users') ?>"><i class="fa fa-circle-o"></i> Manage Users</a></li>
            <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>

          <?php if(in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
            <li class="treeview" id="mainGroupNav">
              <a href="#">
                <!--i class="fa fa-files-o"></i-->
				<i class="fa fa-google-plus-square"></i>
                <span>Groups</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createGroup', $user_permission)): ?>
                  <li id="addGroupNav"><a href="<?php echo base_url('groups/create') ?>"><i class="fa fa-circle-o"></i> Add Group</a></li>
                <?php endif; ?>
                <?php if(in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
                <li id="manageGroupNav"><a href="<?php echo base_url('groups') ?>"><i class="fa fa-circle-o"></i> Manage Groups</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>



          

          <?php if(in_array('createStore', $user_permission) || in_array('updateStore', $user_permission) || in_array('viewStore', $user_permission) || in_array('deleteStore', $user_permission)): ?>
            <li id="storeNav">
              <a href="<?php echo base_url('stores/') ?>">
                <i class="fa fa-files-o"></i> <span>Stores</span>
              </a>
            </li>
          <?php endif; ?>

          <?php if(in_array('createAttribute', $user_permission) || in_array('updateAttribute', $user_permission) || in_array('viewAttribute', $user_permission) || in_array('deleteAttribute', $user_permission)): ?>
          <li id="attributeNav">
            <a href="<?php echo base_url('attributes/') ?>">
              <i class="fa fa-files-o"></i> <span>Attributes</span>
            </a>
          </li>
          <?php endif; ?>
		
			<?php 
				if(in_array('createProduct', $user_permission) || 
					in_array('updateProduct', $user_permission) || 
					in_array('viewProduct', $user_permission) || 
					in_array('deleteProduct', $user_permission) ||
					in_array('createProductPrice', $user_permission) ||
					in_array('updateProductPrice', $user_permission) ||
					in_array('viewProductPrice', $user_permission) ||
					in_array('deleteProductPrice', $user_permission)
				):
			?>
           
		   <li class="treeview" id="mainProductNav">
              <a href="#">
                <i class="fa fa-cube"></i>
                <span>Products</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createProduct', $user_permission)): ?>
                  <li id="addProductNav"><a href="<?php echo base_url('products/create') ?>"><i class="fa fa-circle-o"></i> Add Product</a></li>
                <?php endif; ?>
               
			   <?php if(in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
                <li id="manageProductNav"><a href="<?php echo base_url('products') ?>"><i class="fa fa-circle-o"></i> Manage Products</a></li>
                <?php endif; ?>
				
				<?php if(in_array('updateProductPrice', $user_permission) || in_array('viewProductPrice', $user_permission) || in_array('deleteProductPrice', $user_permission)): ?>
                <li id="managePricesNav"><a href="<?php echo base_url('prices') ?>"><i class="fa fa-circle-o"></i> Manage Prices</a></li>
                <?php endif; ?>
				
              </ul>
            </li>
			
          <?php endif; ?> 
		  
		<!-- Product Receive start-->
		  <?php if(in_array('createProductReceive', $user_permission) || in_array('updateProductReceive', $user_permission) || in_array('viewProductReceive', $user_permission) || in_array('deleteProductReceive', $user_permission)): ?>
            <li class="treeview" id="mainProductReceiveNav">
              <a href="#">
                <i class="fa fa-cart-plus" aria-hidden="true"></i>
                <span>Receive Products</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createProductReceive', $user_permission)): ?>
                  <li id="createProductReceiveNav"><a href="<?php echo base_url('receive/create') ?>"><i class="fa fa-circle-o"></i>Product Receive</a></li>
                <?php endif; ?>
                <?php if(in_array('updateProductReceive', $user_permission) || in_array('viewProductReceive', $user_permission) || in_array('deleteProductReceive', $user_permission)): ?>
                <li id="manageProductReceiveNav"><a href="<?php echo base_url('receive') ?>"><i class="fa fa-circle-o"></i> Manage Product Receive</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>
		<!-- Product Receive end -->
		
		<!-- Demand Configuration start-->
		  <?php if(
				in_array('createDemand', $user_permission) || 
				in_array('updateDemand', $user_permission) || 
				in_array('viewDemand', $user_permission) || 
				in_array('deleteDemand', $user_permission) || 
				in_array('createDemandConfiguration', $user_permission) || 
				in_array('updateDemandConfiguration', $user_permission) || 
				in_array('viewDemandConfiguration', $user_permission) || 
				in_array('deleteDemandConfiguration', $user_permission)
			  
			  ): ?>
            <li class="treeview" id="mainDemandeNav">
              <a href="#">
                <i class="fa fa-plus"></i>
                <span>Demand</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createDemandConfiguration', $user_permission)): ?>
                  <li id="createDemandNav"><a href="<?php echo base_url('receive/create') ?>"><i class="fa fa-circle-o"></i>Create Demand</a></li>
                <?php endif; ?>
                <?php if(in_array('createDemandConfiguration', $user_permission) || in_array('updateDemandConfiguration', $user_permission) || in_array('viewDemandConfiguration', $user_permission) || in_array('deleteDemandConfiguration', $user_permission)): ?>
                <li id="manageDemandConfigurationNav"><a href="<?php echo base_url('demand/configurations') ?>"><i class="fa fa-circle-o"></i>Demand Configuration</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>
		<!-- Demand Configuration end -->

          <?php if(in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
            <li class="treeview" id="mainOrdersNav">
              <a href="#">
                <i class="fa fa-dollar"></i>
                <span>Orders</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createOrder', $user_permission)): ?>
                  <li id="addOrderNav"><a href="<?php echo base_url('orders/create') ?>"><i class="fa fa-circle-o"></i> Add Order</a></li>
                <?php endif; ?>
                <?php if(in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
                <li id="manageOrdersNav"><a href="<?php echo base_url('orders') ?>"><i class="fa fa-circle-o"></i> Manage Orders</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>

          <?php if(in_array('viewReports', $user_permission)): ?>
            <li id="reportNav">
              <a href="<?php echo base_url('reports/') ?>">
                <i class="glyphicon glyphicon-stats"></i> <span>Reports</span>
              </a>
            </li>
          <?php endif; ?>


          <?php if(in_array('updateCompany', $user_permission)): ?>
            <li id="companyNav"><a href="<?php echo base_url('company/') ?>"><i class="fa fa-files-o"></i> <span>Company</span></a></li>
          <?php endif; ?>

        
		<!-- All Settings-->
		 <?php if(in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
            <li class="treeview" id="mainSettingsNav">
              <a href="#">
                <!--i class="fa fa-files-o"></i-->
				<i class="fa fa-wrench"></i>
                <span>Settings</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
			  
              <ul class="treeview-menu">
				<!-- Manage Branch-->
                <?php if(in_array('createBranch', $user_permission) || in_array('updateBranch', $user_permission) || in_array('viewBranch', $user_permission) || in_array('deleteBranch', $user_permission)): ?>
                <li id="manageBranchNav"><a href="<?php echo base_url('branch/') ?>"><i class="fa fa-circle-o"></i> Manage Branches</a></li>
                <?php endif; ?>
				
                  <!-- Manage Brand -->
                  <?php if(in_array('createBrand', $user_permission) || in_array('updateBrand', $user_permission) || in_array('viewBrand', $user_permission) || in_array('deleteBrand', $user_permission)): ?>
                    <li id="manageBrandNav"><a href="<?php echo base_url('brands/') ?>"><i class="fa fa-circle-o"></i> Brands </a></li>
                  <?php endif; ?>
                  <!-- Manage Category-->
                  <?php if(in_array('createCategory', $user_permission) || in_array('updateCategory', $user_permission) || in_array('viewCategory', $user_permission) || in_array('deleteCategory', $user_permission)): ?>
                    <li id="manageCategoryNav">
                      <a href="<?php echo base_url('category/') ?>">
                      <i class="fa fa-circle-o"></i> <span>Category</span>
                      </a>
                    </li>
                  <?php endif; ?>
                  
                  <!-- Manage Business Group-->
                  <?php if(in_array('createBusinessGroup', $user_permission) || in_array('updateBusinessGroup', $user_permission) || in_array('viewBusinessGroup', $user_permission) || in_array('deleteBusinessGroup', $user_permission)): ?>
                    <li id="manageBusinessGroup">
                      <a href="<?php echo base_url('businessgroup/') ?>">
                      <i class="fa fa-circle-o"></i> <span>Business Group</span>
                      </a>
                    </li>
                  <?php endif; ?>

                  <!-- Manage Vendors/Suppliers -->
                  <?php if(in_array('createSupplier', $user_permission) || in_array('updateSupplier', $user_permission) || in_array('viewSupplier', $user_permission) || in_array('deleteSupplier', $user_permission)): ?>
                    <li id="manageVendors">
                      <a href="<?php echo base_url('suppliers/') ?>">
                      <i class="fa fa-circle-o"></i> <span>Manage Vendors</span>
                      </a>
                    </li>
                  <?php endif; ?>
				
              </ul>
            </li>
          <?php endif; ?>
		 <!-- All Settings End -->
		 
		  

        <!-- <li class="header">Settings</li> -->
		
        <?php if(in_array('viewProfile', $user_permission)): ?>
          <li><a href="<?php echo base_url('users/profile/') ?>"><i class="fa fa-user-o"></i> <span>Profile</span></a></li>
        <?php endif; ?>
        <?php if(in_array('updateSetting', $user_permission)): ?>
          <li><a href="<?php echo base_url('users/setting/') ?>"><i class="fa fa-wrench"></i> <span>Setting</span></a></li>
        <?php endif; ?>

        <?php endif; ?>
        <!-- user permission info -->
        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>Logout</span></a></li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>