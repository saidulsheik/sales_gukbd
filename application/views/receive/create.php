<style>
	 .bootstrap-tagsinput {
			background-color: #fff;
			border: 1px solid #ccc;
			box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			display: block;
			padding: 4px 6px;
			color: #555;
			vertical-align: middle;
			border-radius: 4px;
			max-width: 100%;
			line-height: 22px;
			cursor: text;
		}
		.bootstrap-tagsinput input {
			border: none;
			box-shadow: none;
			outline: none;
			background-color: transparent;
			padding: 0 6px;
			margin: 0;
			width: auto;
			max-width: inherit;
		}
		
			
		.bootstrap-tagsinput .tag [data-role="remove"] {
		  margin-left: 8px;
		  cursor: pointer;
		}
		.bootstrap-tagsinput .tag [data-role="remove"]:after {
		  content: "x";
		  padding: 0px 2px;
		}
		.bootstrap-tagsinput .tag [data-role="remove"]:hover {
		  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
		}
		.bootstrap-tagsinput .tag [data-role="remove"]:hover:active {
		  box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
		}
	input { 
		width:96%;
		padding:0 2%; 
	}
	.error{
		  color:red;
	  }
</style>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Accessories
				<small>Purchase</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Product Receive/Purchase</li>
			</ol>
		</section>
			<!-- Main content -->
		<section class="content">
			<!-- Small boxes (Stat box) -->
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<div id="messages"></div>
					<!-- <?php if($this->session->flashdata('success')): ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<?php echo $this->session->flashdata('success'); ?>
					</div>
					<?php elseif($this->session->flashdata('error')): ?>
					<div class="alert alert-error alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<?php echo $this->session->flashdata('error'); ?>
					</div>
					<?php endif; ?> -->

				<form role="form" action="<?php echo base_url('receive/createPurchase') ?>"  method="post" id="createPurchaseForm" class="form" onsubmit="return ValidationEvent()">>
						
					<div class="box box-primary">
						<div class="box-header">
						<h3 class="box-title">Add Purchase</h3>
						</div>
						<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<!-- <div class="col-md-12">
							<?php echo validation_errors('<h4 class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></h4>'); ?>
							</div> -->
						</div>
						<div class="row">
							<div class="form-group col-sm-3">
								<label for="vendor_id" class="col-sm-5 control-label">Select Suppliers</label>
								<?php
									if(!empty($temp_purchase[0]['vendor_id'])){
								?>
									<input type="text" class="form-control" name="vendor_name" value="<?php echo $temp_purchase[0]['vendor_name'];?>" readonly>
									<input type="text" name="vendor_id" value="<?php echo $temp_purchase[0]['vendor_id']; ?>">
									<input type="text" name="id" value="<?php echo $temp_purchase[0]['id']; ?>">
								<?php 
									}else{
								?>
								<select name="vendor_id" id="vendor_id" class="form-control select_group" required >
									<option value="">Select a Supplier</option>
									<?php 
									if(!empty($suppliers)){
										foreach($suppliers as $supplier):
									?>
									<option value="<?php echo $supplier['id']; ?>" <?php echo set_select('vendor_id', $supplier['id']);?> ><?php echo $supplier['vendor_name']; ?></option>
									<?php 
										endforeach;
									}else{
									?>
									<option value="">No Supplier Created</option>
									<?php } ?>
								</select>
								
								<span class="error"><?php echo form_error('vendor_id'); ?></span>
								<?php } ?>
							</div>
							<div class="form-group col-sm-4">
								<label for="chalan_no" class="col-sm-5 control-label">Supplier Invoice/Challan No</label>
								<?php 
									if(!empty($temp_purchase[0]['chalan_no'])){
								?>
									<input type="text" class="form-control" id="chalan_no"   name="chalan_no" value="<?php echo $temp_purchase[0]['chalan_no']; ?>" readonly placeholder="Enter Challan No"  autocomplete="Off">
								<?php 
									}else{

								?>
									<input type="text" class="form-control" id="chalan_no"   name="chalan_no" placeholder="Enter Challan No"  autocomplete="Off">
								<?php 
									}
								?>
								
								<span class="error"><?php echo form_error('chalan_no'); ?></span>
								<input type="hidden" name="is_serialised" id="is_serialised">
							</div>

							<div class="form-group col-sm-4">
								<label for="challan_date" class="col-sm-5 control-label">Supplier Invoice/Challan Date</label>
								<input type="date" name="challan_date" id="challan_date" value=""  class="form-control">
								<span class="error"><?php echo form_error('challan_date'); ?></span>
							</div>
						</div> 
						
							<?php 
								if(!empty($temp_purchase)){
								?>
									<input type="hidden" name="receive_date" value="<?php echo $temp_purchase[0]['receive_date']; ?>">
									<input type="hidden" name="challan_date" value="<?php echo $temp_purchase[0]['challan_date']; ?>">
									
								<?php 
									}else{
								?>
									<input type="hidden" name="receive_date" value="<?php echo date('Y-m-d'); ?>">
								<?php 
								}	
									/* echo '<pre>';
									print_r($temp_purchase);
									echo '</pre>';  */
							?>



						<?php 
						// echo '<pre>';
						// print_r($temp_purchase_details);
						// echo '</pre>';
						?>
						<table class="table table-bPurchaseed" id="product_info_table">
							<thead>
								<tr>
									<th style="width:20%">Product</th>
									<th style="width:10%">Qty</th>
									<th style="width:15%">Unit Price</th>
									<th style="width:10%">Sales Price</th>
									<!--th style="width:20%">Serial/IMEI</th-->
									<th style="width:10%">&nbsp;</th>
								</tr>
							</thead>

							<tbody>
								<tr id="row_1">
									<td>
										<select class="form-control select_group product" data-row-id="row_1" id="product_1" name="product_id" style="width:100%;" onchange="getProductInfo(1)" required>
											<option value="">Select Product</option>
											<?php foreach ($products as $k => $v): ?>
											<option value="<?php echo $v['id'] ?>"  <?php echo set_select('product', $v['id']);?> ><?php echo $v['product_name'] ?></option>
											<?php endforeach ?>
										</select>
										<span class="error"><?php echo form_error('product_id'); ?></span>
									</td>
									<td>
										<input type="text"  name="quantity" id="quantity_1" class="form-control" required  value="">
										<span class="error"><?php echo form_error('quantity'); ?></span>
									</td>
									<td>
										<input type="number" name="purchase_price" id="purchase_price_1" class="form-control" required readonly autocomplete="off">
										<input type="hidden" name="purchase_price_value" id="purchase_price_value_1" class="form-control"  autocomplete="off">
										<span class="error"><?php echo form_error('purchase_price'); ?></span>
									</td>
									<td>
										<input type="text" name="sales_price" id="sales_price_1" class="form-control" disabled required autocomplete="off">
										<input type="hidden" name="total_sales_price" id="sales_price_value_1" class="form-control" autocomplete="off">
										<span class="error"><?php echo form_error('sales_price'); ?></span>
									</td>
									<!--td>
										<input type="text" name="serial[]" id="serial_1" class="form-control serial_no"  autocomplete="off">
									</td-->
									<td><button type="submit" id="submitCreateOrrder" class="btn btn-primary">Add To Cart</button></td>
								</tr>
								<tr>
									<td colspan="4">
										<input type="text" name="serial" id="serial_1" class="form-control serialno" placeholder="Enter Product Serial No" data-role="tagsinput" value=""  autocomplete="off">
										<span class="error" id="no_of_serial_no"></span>
									</td>
									
								</tr>
							</tbody>
						</table>
						<br />
					</div>
					<!-- /.box-body -->
					</div>
				</form>
					<!-- /.box-body -->
					<!-- /.box -->
				</div>
				<!-- col-md-12 -->
			</div>
			<!-- /.row -->

			 <script>
					var vendor_id = document.getElementById("vendor_id").value = "<?php echo isset($temp_purchase[0]['vendor_id']) ? $temp_purchase[0]['vendor_id'] : ''; ?>";
					var chalan_no = document.getElementById("chalan_no").value = "<?php echo isset($temp_purchase[0]['chalan_no']) ? $temp_purchase[0]['chalan_no'] : ''; ?>";
					var challan_date = document.getElementById("challan_date").value = "<?php echo isset($temp_purchase[0]['challan_date']) ? $temp_purchase[0]['challan_date'] : date('Y-m-d'); ?>";
					var in_buy_id = "<?php echo isset($temp_purchase[0]['id']) ? $temp_purchase[0]['id'] : ''; ?>";
					if(vendor_id) {
						$('#vendor_id').attr("readonly", true); 
						//$('#vendor_id').css('pointer-events','none').attr("readonly","true");
						// $('#vendor_id').css('pointer-events','none').attr("readonly","true");
					}
					/* if(chalan_no) {
						$('#chalan_no').attr("disabled", true); 
						
					} */
              </script>





			<form role="form" action="<?php echo base_url('receive/savePurchase') ?>"  method="post"  class="form">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-primary">
							<div class="box-header">
								<h3 class="box-title">Purchase Details</h3>
							</div>
							<div class="box-body">
							<?php 
							if(!empty($temp_purchase)){
							?>
								<input type="hidden" name="receive_date" value="<?php echo $temp_purchase[0]['receive_date']; ?>">
								<input type="hidden" name="challan_date" value="<?php echo $temp_purchase[0]['challan_date']; ?>">
								<input type="hidden" name="id" value="<?php echo $temp_purchase[0]['id']; ?>">
							<?php 
								}else{
							?>
								<input type="hidden" name="receive_date" value="<?php echo date('Y-m-d'); ?>">
								<input type="hidden" name="id" value="<?php echo date('Y-m-d'); ?>">
							<?php 
							}	
								/* echo '<pre>';
								print_r($temp_purchase);
								echo '</pre>';  */
							?>
								<table class="table table-bordered table-hover" id="purchaseDetailsTable">
									<thead>
										<tr>
											<th>Brand Name</th>
											<th>Category Name</th>
											<th>Product Name</th>
											<th>Serial/IMEI</th>
											<th>Unit Price</th>
											<th>Quantity</th>
											<th>Total Price</th>
											<th>Action</th>
										</tr>
									</thead>

									<tbody>
										<?php 
										$grandTotal=0;
										$i=0;
										foreach($temp_purchase_details as $detailsValue){
										$i++;
										$grandTotal+=$detailsValue['quantity']*$detailsValue['purchase_price'];
										?>
										<tr>
											<td><?php echo $detailsValue['brand_name']; ?></td>
											<td><?php echo $detailsValue['category_name']; ?></td>
											<td>
												<?php echo $detailsValue['product_name']; ?>
												<input type="hidden" name="product[<?php echo $detailsValue['id']; ?>][purchase_detail_id]" value="<?php echo $detailsValue['id']; ?>" />
												<input type="hidden" name="product[<?php echo $detailsValue['id']; ?>][product_id]" value="<?php echo $detailsValue['product_id']; ?>" />
												
											</td>
											<?php 

											if($detailsValue['is_serialised']==1){
											?>
											<td>
												<input type="text" name="serial_no[]" id="serial_no<?php echo $i;?>" tabindex="<?php echo $i;?>" class="form-control serial_no" required>
											</td>
											<?php 
											}else{
											?>
												<td><input type="text" name="serial_no[]" class="form-control serial_no" tabindex="<?php echo $i;?>" readonly></td>
											<?php 
											}
											?>

											<td><?php echo $detailsValue['purchase_price']; ?></td>
											<td><?php echo $detailsValue['quantity']; ?></td>
											<td><?php echo $detailsValue['quantity']*$detailsValue['purchase_price']; ?></td>
											<td>
												<?php if(in_array('deleteProduct', $this->permission)) { ?>
												<a id="remevoserial"
													class="btn btn-sm btn-danger"
													data-purchase_id="<?php echo $detailsValue['purchase_id'];?>"
													data-id="<?php echo $detailsValue['id']; ?>" 
													data-option="<?php echo $detailsValue['serial_id']; ?>" 
													href="#" 
													onclick="goDoSomething(this.getAttribute('data-id'), this.getAttribute('data-option'), this.getAttribute('data-purchase_id'));">
														<i class="fa fa-times" aria-hidden="true"></i>
												</a>
												<?php }	?>
											</td>
										</tr>
										<?php 
										}
										?>
										<tr>
											<th colspan="6">Grand Total</th>
											<th><?php echo  $grandTotal;?></th>
                      						<input type="hidden" name="total_voucher_amount" value="<?php echo $grandTotal;?>">
										</tr>
									</tbody>
								</table>
							</div>
							<div class="box-footer">
								<div class="pull-right">
								<button type="submit" id="submitCreateOrrder" class="btn btn-primary">Save</button>
								<a href="<?php echo base_url('accessories/') ?>" class="btn btn-warning">Back</a>
								</div>
							</div>
						</div>  
					</div>
				</div>
			</form>
		</section>
	<!-- /.content -->
	</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function() {
   $('#is_serialised')
  
  $('#serial_1').on('change', function(){ 
	  
	   //alert(no_of_serial);
	   var qty=$("#quantity_1").val();
	    var no_of_serial = $("#serial_1").tagsinput('items').length;
		
	   $("#no_of_serial_no").html("Number of Product Serial must be equal to product quantity, given serial no : "+ no_of_serial);
	   if(qty<no_of_serial){
		   alert("Product Serial No Can't greater than product Qty");
		 	//$("#serial_1").val('');
			//$('#serial_1').tagsinput('remove',);
			$('#serial_1').tagsinput('removeAll');
		}
	   /* price = ''
	   if (items == 1){
		   price = 100;
	   }else{
		   price = parseInt(items)*70;
	   }
	   $('#totalpay').val(price) */
	});
  
  
  $("#product_info_table tr:last").hide();
    $(".select_group").select2();
    $("#mainProductReceiveNav").addClass('active');
    $("#createProductReceiveNav").addClass('active');
   // $('serial_no').focus();
  });
  
  
  
  function ValidationEvent() {
   var is_serialised = $('#is_serialised').val();
   if(is_serialised==1){
	   var no_of_serial = $("#serial_1").tagsinput('items').length;
		 var qty=$("#quantity_1").val();
		if(no_of_serial==qty){
			return true;
			
		}else{
			alert('No of Product Serial and Qty Should be equal');
			return false;
		}
	}else{
		return true;
	}
  	 
  
  
  
  }

  var base_url = "<?php echo base_url(); ?>";
  console.log(base_url);
  // get the product information from the server
  function getProductInfo(row_id) {
    var product_id = $("#product_"+row_id).val();    

    //alert(product_id);
    if(product_id == "") {
      $("#purchase_price_"+row_id).val("");
      $("#purchase_price_value_"+row_id).val("");
      $("#quantity_"+row_id).val("");  
      $("#sales_price_"+row_id).val("");
      $("#sales_price_value_"+row_id).val("");

    } else {
      $.ajax({
        url: base_url + 'receive/getProductInfo',
        type: 'post',
        data: {product_id : product_id},
        dataType: 'json',
        success:function(response) {
          console.log(response);
          $("#purchase_price_"+row_id).val(response[0].purchase_price);
          $("#purchase_price_value_"+row_id).val(response[0].purchase_price);
		  
		   if(response[0].is_serialised==1){
		   	//$('#product_info_table tr:last').after('<tr><td colspan="4"><div class="bootstrap-tagsinput"><input type="text" placeholder=""></div><input type="text" name="serial[]" id="serial_1" class="form-control serialno" data-role="tagsinput" value="" autocomplete="off" style="display: none;" required="required"></td></tr>');
		   	//$('#product_info_table tr:last').after('');
			$("#product_info_table tr:last").show();
             //$("#quantity_"+row_id).attr('readonly', 'readonly');
             $("#serial_"+row_id).attr('required', 'required');
          }else{
		  	$("#product_info_table tr:last").hide();
            $("#quantity_"+row_id).attr('readonly', false);
            $("#serial_"+row_id).attr('readonly', 'readonly');
          }
		  
          $("#is_serialised").val(response[0].is_serialised);
          $("#quantity_"+row_id).val(1);
          $("#quantity_value_"+row_id).val(1);
          $("#sales_price_"+row_id).val(response[0].sales_price);
		
        } // /success
      }); // /ajax function to fetch the product data 
    }
  }

  //remove functions 
  function goDoSomething(data_id, data_option,purchase_id){ 
      //alert(data_option);
			var x = confirm("Are you sure  want to delete?");
			if(x){
				$.ajax({
				url : "<?php echo base_url(); ?>/receive/deletePurchaseDetailsByID",
				type : "POST",
				data : {"purchase_details_id" : data_id, "serial_no" : data_option, "purchase_id" : purchase_id},
				dataType: 'json',
				success : function(response) {
          			console.log(response);
				   	location.reload();
					//$(".serial_no").focus();
				}
			});
			}else{
				return false;
			}
		   //alert("data-id:"+data_id+", data-option:"+data_option);
    }


		jQuery.fn.ForceNumericOnly =
		function()
		{
			return this.each(function()
			{
				$(this).keydown(function(e)
				{
					var key = e.charCode || e.keyCode || 0;
					// allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
					// home, end, period, and numpad decimal
					return (
						key == 8 || 
						key == 9 ||
						key == 13 ||
						key == 46 ||
						key == 110 ||
						key == 190 ||
						(key >= 35 && key <= 40) ||
						(key >= 48 && key <= 57) ||
						(key >= 96 && key <= 105));
				});
			});
		};
		$("#quantity_1").ForceNumericOnly();

		/* disable serial_no field pressing enter key */
		$('.serial_no').keypress(function(e){
			if ( e.which == 13 ) return false;
		});

		/* function find_duplicates(arr) {
			  var len=arr.length,
				  out=[],
				  counts={};

			  for (var i=0;i<len;i++) {
				var item = arr[i];
				var count = counts[item];
				counts[item] = counts[item] >= 1 ? counts[item] + 1 : 1;
			  }

			  for (var item in counts) {
				if(counts[item] > 1)
				  out.push(item);
			  }

			  return out;
			}
			
		$('.serial_no').keyup(function()
		{
			var listOfValues = [];

			$('.serial_no').each(function()
			{
				if($(this).val()!='')
					listOfValues.push($(this).val());
			});

			var duplicates = find_duplicates(listOfValues);
			if(duplicates.length>0)
			{
				//$('#result').html('Duplicates are:');
				//$('#result').append(JSON.stringify(duplicates));
				$(this).css("border-color", "red");
				alert("Serial No. cannot be duplicated");
				$(this).val('');
			}
			else
			{
				$(this).css("border-color", "");
				//$('#result').html('No Duplicates found');
			}
		}); */
</script>





