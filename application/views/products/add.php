

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Add
      <small>Products</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Products</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

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
        <?php endif;  ?>


        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Add Product</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('products/addproduct') ?>" method="post" id="yourForm" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<h4 class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></h4>'); ?>
                    </div>
                </div>
                <div class="form-group">
                  <label for="sku">Product Model</label>
                  <select class="form-control select_group" name="product" style="width: 100%; margin-top: -8px !important;">
                    <option value="">Select Product</option>
                    <?php 
                        foreach($products as $product){
                    ?>
                        <option <?php echo !empty($this->session->userdata['form_data']['product_id'])?($this->session->userdata['form_data']['product_id']==$product['id']?'selected':''):'';?> value="<?php echo $product['id']; ?>"><?php echo $product['product_name']; ?></option>
                    <?php       
                        }
                    ?>
                  </select>
                 
                </div>
                
                <div class="form-group">
                  <label for="supplier_id">Supplier</label>
                  <select class="form-control select_group" name="supplier_id" style="width: 100%; margin-top: -8px !important;">
                    <option value="">Select Supplier</option>
                    <?php 
                        foreach($suppliers as $supplier):
                    ?>
                        <option  <?php echo !empty($this->session->userdata['form_data']['supplier_id'])?($this->session->userdata['form_data']['supplier_id']==$supplier['id']?'selected':''):'';?> value="<?php echo $supplier['id']; ?>"><?php echo $supplier['vendor_name']; ?></option>
                    <?php       
                        endforeach;
                    ?>
                  </select>
                 
                 </div>

                <!--div class="form-group">
                  <label for="product_name">Supplier Name</label>
                  <input type="text" class="form-control" id="supplier_name" name="supplier_name" value="<?php echo !empty($this->session->userdata['form_data']['supplier_name'])?$this->session->userdata['form_data']['supplier_name']:'';?>" placeholder="Enter Supplier Name" autocomplete="on"/>
                </div-->
                <div class="form-group">
                  <label for="product_name">Cost Price</label>
                  <input type="number" class="form-control" id="cost_price" name="cost_price" value="<?php echo !empty($this->session->userdata['form_data']['cost_price'])?$this->session->userdata['form_data']['cost_price']:'';?>"  placeholder="Enter Cost Price" autocomplete="off"/>
                </div>
                <div class="form-group">
                  <label for="product_name">Sale Price</label>
                  <input type="number" class="form-control" id="sale_price" name="sale_price" value="<?php echo !empty($this->session->userdata['form_data']['sale_price'])?$this->session->userdata['form_data']['sale_price']:'';?>"  placeholder="Enter Sale Price" autocomplete="off"/>
                </div>

                <div class="form-group">
                  <label for="product_name">Serial Number/Product IMEI</label>
                  <input type="text" class="form-control" id="serial_no" name="serial_no"  placeholder="Enter Prodcut Serial" autocomplete="off"/>
                        <span id="serial-availability-status"></span>
                  </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" id="btnSubmit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo base_url('products/') ?>" class="btn btn-warning">Back</a>
              </div>
            </form>
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

<script type="text/javascript">
  $(document).ready(function() {
    $(".select_group").select2();
    $("#mainProductReceiveNav").addClass('active');
    $("#addNewProductNav").addClass('active');
     $('#serial_no').focus();
    //$("#btnSubmit").attr("disabled", true);
  /*   $("#serial_no").blur(function(){
        $.ajax({
        url: '<?php echo base_url('products/check_availability'); ?>',
        data:'serial='+$("#serial_no").val(),
        type: "POST",
        success:function(data){
          $("#serial-availability-status").html(data);
         // $("#btnSubmit").attr("disabled", false);
        },
        error:function (){}
        });
     }); */
  });
  
  
</script>