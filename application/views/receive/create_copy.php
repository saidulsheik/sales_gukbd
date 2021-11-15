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
      <li class="active">Purchase Accessories</li>
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


        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Add Purchase</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php echo base_url('receive/createPurchase') ?>"  method="post" id="createPurchaseForm" class="form">
              <div class="box-body">

          <div class="row">
              <div class="col-md-12">
                  <?php echo validation_errors('<h4 class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></h4>'); ?>
              </div>
          </div>

					<div class="row">
						<div class="form-group col-sm-3">
							<label for="supplier_id" class="col-sm-5 control-label">Select Suppliers</label>
							<select name="supplier_id" id="supplier_id" class="form-control select_group" required >
								<option value="">Select a Supplier</option>
								<?php 
									if(!empty($suppliers)){
										foreach($suppliers as $supplier):
									?>
									<option value="<?php echo $supplier['id']; ?>" <?php echo set_select('supplier_id', $supplier['id']);?> ><?php echo $supplier['vendor_name']; ?></option>
									<?php 
										endforeach;
									}else{
									?>
									<option value="">No Supplier Created</option>
									<?php 
									}
								?>
							</select>
						</div>
					
					
					<?php 
						/* echo '<pre>';
						print_r($products);
						echo '</pre>';  */
						
					?>
					<div class="form-group col-sm-4">
						<label for="chalan_no" class="col-sm-5 control-label">Supplier Invoice/Challan No</label>
						<input type="text" class="form-control" id="chalan_no"   name="chalan_no" placeholder="Enter Challan No"  autocomplete="Off">
					</div>
					
          <div class="form-group col-sm-4">
						<label for="challan_date" class="col-sm-5 control-label">Supplier Invoice/Challan Date</label>
						<input type="date" name="challan_date" value="<?php echo !empty($challan_date)?$challan_date:date('Y-m-d'); ?>"  class="form-control" id="datepicker">
					</div>

					
				</div> 
				
                <table class="table table-bPurchaseed" id="product_info_table">
                  <thead>
                    <tr>
                      <th style="width:20%">Product</th>
                      <th style="width:10%">Qty</th>
                      <th style="width:15%">Rate</th>
                      <th style="width:10%">Amount</th>
                      <th style="width:20%">Serial/IMEI</th>
                      <th style="width:10%"><button type="button" id="add_row" class="btn btn-default"><i class="fa fa-plus"></i></button></th>
                    </tr>
                    
                  </thead>

                   <tbody>
                     <tr id="row_1">
                       <td>
                          <select class="form-control select_group product" data-row-id="row_1" id="product_1" name="product_id[]" style="width:100%;" onchange="getProductInfo(1)" required>
                              <option value="">Select Product</option>
                              <?php foreach ($products as $k => $v): ?>
                                <option value="<?php echo $v['id'] ?>"  <?php echo set_select('product', $v['id']);?> ><?php echo $v['product_name'] ?></option>
                              <?php endforeach ?>
                          </select>
                        </td>
                        <td><input type="text"  name="quantity[]" id="quantity_1" class="form-control" required onkeyup="getTotal(1)" value=""></td>
                        <td>
                          <input type="number" name="rate[]" id="rate_1" class="form-control" required readonly autocomplete="off">
                          <input type="hidden" name="rate_value[]" id="rate_value_1" class="form-control"  autocomplete="off">
                        </td>
                        <td>
                          <input type="text" name="amount[]" id="amount_1" class="form-control" disabled required autocomplete="off">
                          <input type="hidden" name="total_amount[]" id="amount_value_1" class="form-control" autocomplete="off">
                        </td>

                        <td>
                          <input type="text" name="serial[]" id="serial_1" class="form-control serialno" data-role="tagsinput" value="<?php echo set_value('tagsinput'); ?>"  autocomplete="off">
                        </td>
                        <td><button type="button" class="btn btn-default" onclick="removeRow('1')"><i class="fa fa-close"></i></button></td>
                     </tr>
                   </tbody>
                </table>

                <br />

                <div class="col-md-4 col-xs-12 pull pull-right">
                      <table class="table table-bPurchaseed">
                        <tr>
                          <th>Gross Amount</th>
                          <td>
                            <input type="text" class="form-control" id="gross_amount" name="gross_amount" disabled autocomplete="off">
                            <input type="hidden" class="form-control" id="gross_amount_value" name="gross_amount_value" autocomplete="off">
                          </td>
                        </tr>
                        <tr>
                          <th>Discount</th>
                          <td>
                            <input type="text" class="form-control" id="discount" name="discount" placeholder="Discount" onkeyup="subAmount()" autocomplete="off">
                          </td>
                        </tr>
                        <tr>
                          <th>Net Amount</th>
                          <td>
                            <input type="text" class="form-control" id="net_amount" name="net_amount" disabled autocomplete="off">
                            <input type="hidden" class="form-control" id="net_amount_value" name="net_amount_value" autocomplete="off">
                          </td>
                        </tr>
                        <tr>
                          <th>Note</th>
                          <td>
                            <input type="text" class="form-control" id="note" name="note">
                          </td>
                        </tr>
                      </table>
                </div>
				
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" id="submitCreateOrrder" class="btn btn-primary">Create Purchase</button>
                <a href="<?php echo base_url('accessories/') ?>" class="btn btn-warning">Back</a>
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
      /* $('#datepicker').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        orientation: "top",
        endDate: "today"

      }); */

$('input[name="quantity[]"]').keyup(function(e){
  if (/\D/g.test(this.value)) {
    // Filter non-digits from input value.
    this.value = this.value.replace(/\D/g, '');
  }
});


  var base_url = "<?php echo base_url(); ?>";
  console.log(base_url);

  $(document).ready(function() {
    
    $(".select_group").select2();
    // $("#description").wysihtml5();

   $("#mainProductReceiveNav").addClass('active');
    $("#createProductReceiveNav").addClass('active');
    
    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
        'onclick="alert(\'Call your custom code here.\')">' +
        '<i class="glyphicon glyphicon-tag"></i>' +
        '</button>'; 
  
    // Add new row in the table 
    $("#add_row").unbind('click').bind('click', function() {
      
      var table = $("#product_info_table");
      var count_table_tbody_tr = $("#product_info_table tbody tr").length;
      var row_id = count_table_tbody_tr + 1;
     /*  var selected_product=$("#product_"+row_id).val();
      alert(selected_product); */
      $.ajax({
          url: base_url + '/receive/getTableProductRow/',
          type: 'post',
          dataType: 'json',
          success:function(response) {
              // console.log(reponse.x);
             
               var html = '<tr id="row_'+row_id+'">'+
                   '<td>'+ 
                    '<select class="form-control select_group product" data-row-id="'+row_id+'" id="product_'+row_id+'" name="product_id[]" style="width:100%;" onchange="getProductInfo('+row_id+')">'+
                        '<option value="">Select Product</option>';
                        $.each(response, function(index, value) {
                          
                          var serial=value.is_serialised;
                          html += '<option value="'+value.id+'">'+value.product_name+'</option>';             
                        });
                      html += '</select>'+
                    '</td>'+ 
                    '<td><input type="number"  name="quantity[]" id="quantity_'+row_id+'" value="" class="form-control" onkeyup="getTotal('+row_id+')"></td>'+
                    '<td><input type="number" name="rate[]" id="rate_'+row_id+'" readonly class="form-control"><input type="hidden" name="rate_value[]" id="rate_value_'+row_id+'" class="form-control"></td>'+
                    '<td><input type="text" name="amount[]" id="amount_'+row_id+'" class="form-control" disabled><input type="hidden" name="total_amount[]" id="amount_value_'+row_id+'" class="form-control"></td>'+
                    '<td><input type="text" name="serial[]" id="serial_'+row_id+'" class="form-control serialno"  onkeyup="myFunction()"  autocomplete="off"></td>'+
                    '<td><button type="button" class="btn btn-default" onclick="removeRow(\''+row_id+'\')"><i class="fa fa-close"></i></button></td>'+
                    '</tr>';
                    if(count_table_tbody_tr >= 1) {
					              $("#product_info_table tbody tr:last").after(html);  
                    }else {
                      $("#product_info_table tbody").html(html);
                    }


                    
                    // if(row_id>1){
                    //   var options = document.getElementById("product_"+row_id).getElementsByTagName("option");
                    //     var selectobject = document.getElementById("product_"+row_id);
                    //     for(i = 1; i < row_id; i++){
                    //       // $("#product_"+row_id).
                    //       var pre_product_no = $("#product_"+i).val();
                    //       console.log(selectobject.length);
                    //       for (var j=0; j<selectobject.length; j++) {
                    //           if (selectobject.options[j].value == pre_product_no){
                    //               selectobject.remove(j);
                    //               break;
                    //           }
                    //       }
                    //     }
                    // }
                      
                  $(".product").select2();

                 }



            });

      return false;
    });


	//reset form value
	$("#submitCreateOrrder").click(function () {
        $("createPurchaseForm").trigger("reset");
    });




  }); // /document

  function getTotal(row = null) {
    if(row) {
      var total = Number($("#rate_value_"+row).val()) * Number($("#quantity_"+row).val());
      total = total.toFixed(2);
      $("#amount_"+row).val(total);
      $("#amount_value_"+row).val(total);
      
      subAmount();

    } else {
      alert('no row !! please refresh the page');
    }
  }

  
  
 /* get product imei when select product */




  // calculate the total amount of the Purchase
  function subAmount() {
    var tableProductLength = $("#product_info_table tbody tr").length;
    var totalSubAmount = 0;
    for(x = 0; x < tableProductLength; x++) {
      var tr = $("#product_info_table tbody tr")[x];
      var count = $(tr).attr('id');
      count = count.substring(4);
      totalSubAmount = Number(totalSubAmount) + Number($("#amount_"+count).val());
    } // /for

    totalSubAmount = totalSubAmount.toFixed(2);

    // sub total
    $("#gross_amount").val(totalSubAmount);
    $("#gross_amount_value").val(totalSubAmount);
    // total amount
    var totalAmount = (Number(totalSubAmount));
    totalAmount = totalAmount.toFixed(2);
    // $("#net_amount").val(totalAmount);
    // $("#totalAmountValue").val(totalAmount);

    var discount = $("#discount").val();
    if(discount) {
      var grandTotal = Number(totalAmount) - Number(discount);
      grandTotal = grandTotal.toFixed(2);
      $("#net_amount").val(grandTotal);
      $("#net_amount_value").val(grandTotal);
    } else {
      $("#net_amount").val(totalAmount);
      $("#net_amount_value").val(totalAmount);
      
    } // /else discount 

  } // /sub total amount
	//remove Purchase table row
  function removeRow(tr_id){
    $("#product_info_table tbody tr#row_"+tr_id).remove();
    subAmount();
  }
  //remove payment table row
  function removePaymentRow(tr_id){
    $("#payment_info_table tbody tr#row_"+tr_id).remove();
  }
  


  // get the product information from the server
  function getProductInfo(row_id) {
    var product_id = $("#product_"+row_id).val();    

    //alert(product_id);
    if(product_id == "") {
      $("#rate_"+row_id).val("");
      $("#rate_value_"+row_id).val("");
      $("#quantity_"+row_id).val("");  
      $("#amount_"+row_id).val("");
      $("#amount_value_"+row_id).val("");

    } else {
      $.ajax({
        url: base_url + 'receive/getProductInfo',
        type: 'post',
        data: {product_id : product_id},
        dataType: 'json',
        success:function(response) {
          console.log(response);
          $("#rate_"+row_id).val(response[0].purchase_price);
          $("#rate_value_"+row_id).val(response[0].purchase_price);
          if(response[0].is_serialised==1){
             $("#quantity_"+row_id).attr('readonly', 'readonly');
             $("#serial_"+row_id).attr('required', 'required');
          }else{
            $("#quantity_"+row_id).attr('readonly', false);
            $("#serial_"+row_id).attr('readonly', 'readonly');
          }
          $("#quantity_"+row_id).val(1);
          $("#quantity_value_"+row_id).val(1);
          var total = Number(response[0].purchase_price) * 1;
          total = total.toFixed(2);
          $("#amount_"+row_id).val(total);
          $("#amount_value_"+row_id).val(total);
          subAmount();
        } // /success
      }); // /ajax function to fetch the product data 
    }
  }



function myFunction() {
 
  var listOfValues = [];

	$('.serialno').each(function()
	{
		if($(this).val()!='')
			listOfValues.push($(this).val());
	});

  console.log(listOfValues);
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
}


    function find_duplicates(arr) {
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
</script>
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>