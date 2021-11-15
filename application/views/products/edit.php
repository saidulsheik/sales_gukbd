
	<style>
	  ul li a{
		cursor: pointer;
	  }
	  .required{
		  color:red;
	  }
	  .error{
		  color:red;
	  }
		.li_image li {
			float: left;
			display: inline;
		}
		
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
      Manage
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
        <?php endif; ?>
		

        <div class="box">
			<div class="box-header">
				<h3 class="box-title">Update Product</h3>
			</div>
			<?php 
				/* echo '<pre>';
				print_r($product_data);
				echo '</pre>'; */
			?>
          <!-- /.box-header -->
			<form role="form" action="<?php base_url('products/update') ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" id="id" value="<?php echo $product_data['id']; ?>">
				<div class="box-body">
					<div class="row">
						
						<div class="col-sm-4 col-md-4">
							<label for="category_id">Category <span class="error">*</span></label>
							<select class="form-control select_group" id="category_id" name="category_id">
								<option value="">Select Category</option>
								<?php foreach ($category_id as $k => $v): ?>
								  <option <?php echo $product_data['category_id']==$v['id']?"selected":"";?> value="<?php echo $v['id'] ?>" <?php echo set_select('category_id', $v['id']);?> ><?php echo $v['category_name'] ?></option>
								<?php endforeach ?>
							</select>
							<span class="error"><?php echo form_error('category_id'); ?></span>
						</div>
						
					
						<div class="col-sm-4 col-md-4">
							<label for="brand_id">Brands <span class="error">*</span></label>
							<select class="form-control select_group" id="brand_id" name="brand_id">
								<option value="">Select Brand</option>
								<?php foreach ($brand_id as $k => $v): ?>
								  <option <?php echo $product_data['brand_id']==$v['id']?"selected":"";?> value="<?php echo $v['id'] ?>" <?php echo set_select('brand_id', $v['id']);?> ><?php echo $v['brand_name'] ?></option>
								<?php endforeach ?>
							</select>
							<span class="error"><?php echo form_error('brand_id'); ?></span>
						</div>
						
						
						
						<div class="col-sm-4">
							<div class="form-group">	
								<label for="product_model">Product Model <span class="error">*</span></label>
								<input type="text" class="form-control" id="product_model" name="product_model" value="<?php echo set_value('product_model', $product_data['product_model']); ?>" placeholder="Enter Model" autocomplete="off" />
								<span class="error"><?php echo form_error('product_model'); ?></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4 col-md-4">
							<div class="form-group">	
								<label for="product_name">Product name <span class="error">*</span></label>
								<input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo set_value('product_name', $product_data['product_name']); ?>" placeholder="Enter product name" autocomplete="off"/>
								<span class="error"><?php echo form_error('product_name'); ?></span>
							</div>
						</div>
						
						<div class="col-sm-4 col-md-4">
							<label for="is_serialised">Is Serialised? <span class="error">*</span></label>
							<select class="form-control" id="is_serialised" name="is_serialised">
								<option <?php echo $product_data['is_serialised']==1?"selected":"";?> value="1">Yes</option>
								<option <?php echo $product_data['is_serialised']==0?"selected":"";?> value="0">No</option>
							</select>
							<span class="error"><?php echo form_error('is_serialised'); ?></span>
						</div>
					
					</div>
					
					
					
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
							  <label for="description">Description <span class="error">*</span></label>
							  <textarea type="text" class="form-control" id="description" name="description"  placeholder="Enter description" autocomplete="off"><?php echo  $product_data['description']; //set_value('description', $product_data['description']); ?> </textarea>
							  <span class="error"><?php echo form_error('description'); ?></span>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group" id="pre_vou_code1">
								<label for="files"> <b>Product Image</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="file" name="files[]" id="upload_files" class="form-control" value="Upload" multiple="multiple"> 
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="row" id="preview_file_div">
								<ul class="li_image">
									<?php 
										$dynm_id=0;
										foreach($products_images as $key=>$value){ 
																
									?> 
									
										<li id="<?php echo $dynm_id; ?>" >
											<div class='ic-sing-file'>
												<img id="<?php echo $dynm_id; ?>" src="<?php echo base_url();?>assets/images/product_image/<?php echo $value->image_name; ?>" title="name" height="80px" width="100px">
												<a id="<?php echo $dynm_id; ?>"  class="close"  data-id="<?php echo $value->id; ?>"    href="#" onclick="removeProductImage(this.getAttribute('data-id'));">
													  X
												</a>
											</div>
										</li>
										
									<?php 
											$dynm_id++;
										}
										
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
				  <!-- /.box-body -->
				  <div class="box-footer">
					<button type="submit" class="btn btn-primary">Save Changes</button>
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
    $("#description").wysihtml5();

	$("#mainProductNav").addClass('active');
	$("#manageProductNav").addClass('active');
    
    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
        'onclick="alert(\'Call your custom code here.\')">' +
        '<i class="glyphicon glyphicon-tag"></i>' +
        '</button>'; 
    $("#product_image").fileinput({
        overwriteInitial: true,
        maxFileSize: 1500,
        showClose: false,
        showCaption: false,
        browseLabel: '',
        removeLabel: '',
        browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-1',
        msgErrorClass: 'alert alert-block alert-danger',
        // defaultPreviewContent: '<img src="/uploads/default_avatar_male.jpg" alt="Your Avatar">',
        layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
        allowedFileExtensions: ["jpg", "png", "gif"]
    });
  });
  
  
	$(function () {
		var input_file = document.getElementById('upload_files');
		var deleted_file_ids = [];
		var dynm_id = 0;
		$("#upload_files").change(function (event) {
			var len = input_file.files.length;
			$('#preview_file_div ul').html("");
			for(var j=0; j<len; j++) {
				var src = "";
				var name = event.target.files[j].name;
				var mime_type = event.target.files[j].type.split("/");
				if(mime_type[0] == "image") {
				  src = URL.createObjectURL(event.target.files[j]);
				} else if(mime_type[0] == "video") {
				  src = 'icons/video.png';
				} else {
				  src = 'icons/file.png';
				}
				$('#preview_file_div ul').append("<li id='" + dynm_id + "'><div class='ic-sing-file'><img id='" + dynm_id + "' src='"+src+"' title='"+name+"' height='80px' width='100px'><p class='close' id='" + dynm_id + "'>X</p></div></li>");
				dynm_id++;
			}
		});
		$(document).on('click','p.close', function() {
			var id = $(this).attr('id');
			deleted_file_ids.push(id);
			$('li#'+id).remove();
			if(("li").length == 0) document.getElementById('upload_files').value="";
		});
	});
	
	
	/* OnClick Product Image Delete */
	function removeProductImage(data_id){   
		var x = confirm("Are you sure you want to delete?");
		 if(x){
			$.ajax({
			url : "<?php echo base_url();?>products/delete_product_image",
			type : "POST",
			data : {"id" : data_id},
			dataType: 'json',
			success : function(response) {
			   alert(response.messages);
			   location.reload();
			}
		});
		}else{
			return false;
		} 
	   //alert("data-id:"+data_id+", data-option:"+data_option);
	}
</script>