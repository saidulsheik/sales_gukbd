

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Products Price</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Products Price</li>
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
        <?php endif; ?>

        <?php if(in_array('createBrand', $user_permission)): ?>
          <button class="btn btn-primary" data-toggle="modal" data-target="#addProductPriceModal">Add Price</button>
          <br /> <br />
        <?php endif; ?>

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage Product Prices</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
			<div class="table-responsive">
				<table id="manageTable" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Product Name</th>
							<th>Brand Name</th>
							<th>Price Effective Date</th>
							<th>Category Name</th>
							<th>Purchase Price</th>
							<th>Sales Price</th>
							<th>Down Payment</th>
							<th>Loan Amount</th>
							<th>Incentive Amount</th>
							<?php if(in_array('viewProductPrice', $user_permission) || in_array('updateProductPrice', $user_permission)): ?>
							  <th>Action</th>
							<?php endif; ?>
						</tr>
					</thead>
				</table>
			</div>
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

<?php if(in_array('createProductPrice', $user_permission)): ?>
<!-- create brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addProductPriceModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Product Price</h4>
      </div>

      <form role="form" action="<?php echo base_url('prices/create') ?>" method="post" id="createProductPrice">

        <div class="modal-body">
		<?php 
				/* echo '<pre>';
				print_r($products); */
		?>
         

          <div class="form-group">
            <label for="product_id">Select Product Name</label>
            <select class="form-control select_group" id="product_id" name="product_id" style="width: 100%; margin-top: -8px !important;" required>
              <option value="">Product Name</option>
              <?php foreach ($products as $k => $v): ?>
                <option value="<?php echo $v->id; ?>"><?php echo $v->product_name . '---' . $v->product_model. '---' . $v->brand_name ; ?></option>
              <?php endforeach ?>
            </select>
          </div> 
		  
		  <div class="form-group">
            <label for="purchase_price">Purchase Price</label>
           <input type="number" value="0" name="purchase_price" id="purchase_price" class="form-control" required>
          </div> 
		  
		   <div class="form-group">
            <label for="sales_price">Sales Price</label>
           <input type="number" value="0" name="sales_price" id="sales_price" class="form-control" required>
          </div> 

		  <div class="form-group">
            <label for="down_payment">Down Payment</label>
           <input type="number" value="0" name="down_payment" id="down_payment" class="form-control" required>
          </div>
		  
		   <div class="form-group">
            <label for="loan_amount">Loan Amount</label>
           <input type="number" value="0" name="loan_amount" id="loan_amount" class="form-control" required>
          </div>
		  
		  <div class="form-group">
            <label for="incentive_amt">Incentive Amount</label>
           <input type="number" value="0" name="incentive_amt" id="incentive_amt" class="form-control" required>
          </div>
		  
		  <div class="form-group">
            <label for="office_sale_price">Office Sales Price</label>
           <input type="number" value="0" name="office_sale_price" id="office_sale_price" class="form-control" required>
          </div>
		  
		  
          
		  <div class="form-group">
            <label for="price_from">Price Effective Date</label>
           <input type="date" name="price_from" id="price_from" min="<?php echo date('Y-m-d');?>" class="form-control" required>
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

<?php if(in_array('updateProductPrice', $user_permission)): ?>
<!-- edit brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editPriceUpdateModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update Product Price</h4>
		<br>
        <h5 class="modal-title">Product Name: <span id="productName"></span></h6>
        <h5 class="modal-title">Brand Name: <span id="brandName"></span></h6>
        <h5 class="modal-title">Category Name: <span id="categoryName"></span></h6>
      </div>

      <form role="form" action="<?php echo base_url('prices/update') ?>" method="post" id="updateProductPriceForm">

        <div class="modal-body">
          <div id="messages"></div>
			<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th colspan="2" style="text-align:center;"> Existing Information 
							<input type="hidden" name="price_id" id="price_id">
							<input type="hidden" name="edit_product_id" id="edit_product_id">
						</th>
						<th>Update Information</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Purchase Price</td>
						<td>
							<div class="form-group">
								<input type="text" name="pre_purchase_price" id="pre_purchase_price" value="" class="form-control" readonly>
							</div>
						</td>
						<td style="vertical-align: middle;">
							<div class="form-group">
								<input type="number" value="" name="edit_purchase_price" id="edit_purchase_price" class="form-control" required>
							</div>
							
						</td>
					</tr>
					<tr>
						<td>Sales Price</td>
						<td>
							<div class="form-group">
								<input type="text" name="pre_sales_price" id="pre_sales_price" value="" class="form-control" readonly>
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="number" name="edit_sales_price" id="edit_sales_price" class="form-control" required>
							</div>
							
						</td>
					</tr>
					
					<tr>
						<td>Down Payment</td>
						<td>
							<div class="form-group">
								<input type="text" name="pre_down_payment" id="pre_down_payment" value="" class="form-control" readonly>
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="number" name="edit_down_payment" id="edit_down_payment" class="form-control" required>
							</div>
							
						</td>
					</tr>
					
					<tr>
						<td>Loan Amount</td>
						<td>
							<div class="form-group">
								<input type="text" value="1000" name="pre_loan_amount" id="pre_loan_amount" class="form-control" readonly>
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="number" name="edit_loan_amount" id="edit_loan_amount"  class="form-control" required>
							</div>
							
						</td>
					</tr>
					
					<tr>
						<td>Incentive Amount</td>
						<td>
								<div class="form-group">
									<input type="text"  name="pre_incentive_amt" id="pre_incentive_amt" class="form-control" readonly>
								</div>
							</td>
							<td>
								<div class="form-group">
									<input type="number" name="edit_incentive_amt" id="edit_incentive_amt" class="form-control" required>
								</div>
								
							</td>
					</tr>
					<tr>
						<td>Office Sales Price</td>
						<td>
							<div class="form-group">
								<input type="text" name="pre_office_sale_price" id="pre_office_sale_price" class="form-control" readonly>
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="number" name="edit_office_sale_price" id="edit_office_sale_price" class="form-control" required>
							</div>
							
						</td>
					</tr>
					<tr>
						<td>Price Effective Date</td>
						<td>
							<div class="form-group">
								<input type="date"  name="pre_price_from" id="pre_price_from" class="form-control" readonly>
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="date" name="edit_price_from" id="edit_price_from" min="<?php echo date('Y-m-d');?>" class="form-control" required>
							</div>
						</td>
					</tr>
					
					
					
				</tbody>
			</table>
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
var manageTable;

$(document).ready(function() {

	$("#mainProductNav").addClass('active');
	$("#managePricesNav").addClass('active');
   $(".select_group").select2();
  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
	"pageLength": 20,
    'ajax': 'prices/fetchProductPricesData',
    'order': []
  });

  // submit the create from 
  $("#createProductPrice").unbind('submit').on('submit', function() {
    var form = $(this);

    // remove the text-danger
    $(".text-danger").remove();

    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(), // /converting the form data into array and sending it to server
      dataType: 'json',
      success:function(response) {

        manageTable.ajax.reload(null, false); 

        if(response.success === true) {
          $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
          '</div>');


          // hide the modal
          $("#addProductPriceModal").modal('hide');

          // reset the form
          $("#createProductPrice")[0].reset();
          $("#createProductPrice .form-group").removeClass('has-error').removeClass('has-success');

        } else {

          if(response.messages instanceof Object) {
            $.each(response.messages, function(index, value) {
              var id = $("#"+index);

              id.closest('.form-group')
              .removeClass('has-error')
              .removeClass('has-success')
              .addClass(value.length > 0 ? 'has-error' : 'has-success');
              
              id.after(value);

            });
          } else {
            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>');
          }
        }
      }
    }); 

    return false;
  });


});

function editProductPrice(id)
{ 
  $.ajax({
    url: 'prices/fetchPriceDataById/'+id,
    type: 'post',
    dataType: 'json',
    success:function(response) {
      $("#productName").html(response.product_name);
      $("#categoryName").html(response.category_name);
      $("#brandName").html(response.brand_name);
      $("#edit_product_id").val(response.product_id);
      $("#price_id").val(response.price_id);
      $("#pre_purchase_price").val(response.purchase_price);
      $("#pre_sales_price").val(response.sales_price);
      $("#pre_down_payment").val(response.down_payment);
      $("#pre_loan_amount").val(response.loan_amount);
      $("#pre_incentive_amt").val(response.incentive_amt);
      $("#pre_office_sale_price").val(response.office_sale_price);
      $("#pre_price_from").val(response.price_from);
      // submit the edit from 
      $("#updateProductPriceForm").unbind('submit').bind('submit', function() {
        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action') + '/' + id,
          type: form.attr('method'),
          data: form.serialize(), // /converting the form data into array and sending it to server
          dataType: 'json',
          success:function(response) {

            manageTable.ajax.reload(null, false); 

            if(response.success === true) {
              $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
              '</div>');


              // hide the modal
              $("#editPriceUpdateModal").modal('hide');
              // reset the form 
              $("#updateProductPriceForm .form-group").removeClass('has-error').removeClass('has-success');

            } else {

              if(response.messages instanceof Object) {
                $.each(response.messages, function(index, value) {
                  var id = $("#"+index);

                  id.closest('.form-group')
                  .removeClass('has-error')
                  .removeClass('has-success')
                  .addClass(value.length > 0 ? 'has-error' : 'has-success');
                  
                  id.after(value);

                });
              } else {
                $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                '</div>');
              }
            }
          }
        }); 

        return false;
      });

    }
  });
}




</script>
