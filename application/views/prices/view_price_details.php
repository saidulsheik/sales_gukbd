
<style>
	table, th, td {
	border: 1px  solid black;
	text-align:center;
	}
	table{
		width:100%;
	}
	
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Details
      <small>Products Price</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Details Products Price</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Details Product Price</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
			<div class="table-responsive">
				<table id="" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Sl No</th>
							<th>Product Name</th>
							<th>Brand Name</th>
							<th>Category Name</th>
							<th>Price From Date</th>
							<th>Price To Date</th>
							<th>Purchase Price</th>
							<th>Sales Price</th>
							
							<th>Incentive Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							
							$product_name="";
							$brand_name="";
							$category_name="";
							$rowSpan=count($price_details);
							$i=0;
							foreach($price_details as $value){
							$i++;
								if($product_name!=$value->product_name){
								$product_name=$value->product_name
						?>
							<tr>
								<td><?php echo $i;?></td>
								<td rowspan="<?php echo $rowSpan; ?>" style="text-align:center;  vertical-align: middle;"><?php echo $value->product_name;?></td>
								<td rowspan="<?php echo $rowSpan; ?>" style="text-align:center;  vertical-align: middle;"><?php echo $value->brand_name;?></td>
								<td rowspan="<?php echo $rowSpan; ?>" style="text-align:center;  vertical-align: middle;"><?php echo $value->category_name;?></td>
								<td><?php echo $value->price_from;?></td>
								<td><?php echo $value->price_to;?></td>
								<td><?php echo $value->purchase_price;?></td>
								<td><?php echo $value->sales_price;?></td>
								
								<td><?php echo $value->incentive_amt;?></td>
							</tr>
						<?php 
								}else{
						?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $value->price_from;?></td>
								<td><?php echo $value->price_to;?></td>
								<td><?php echo $value->purchase_price;?></td>
								<td><?php echo $value->sales_price;?></td>
								<td><?php echo $value->incentive_amt;?></td>
							</tr>
						<?php 
								}
							}
						?>
					
					</tbody>
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







	<script type="text/javascript">
		var manageTable;
		$(document).ready(function() {
			$("#mainProductNav").addClass('active');
			$("#managePricesNav").addClass('active');
			$(".select_group").select2();
			// initialize the datatable 
			manageTable = $('#manageTable').DataTable({
				"pageLength": 20
			});
		});
	</script>
