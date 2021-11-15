

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Branches</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Branches</li>
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
          <button class="btn btn-primary" data-toggle="modal" data-target="#addBrandModal">Add Branch</button>
          <br /> <br />
        <?php endif; ?>

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage Branch</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
			  
              <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Bangla Name</th>
                <th>Area</th>
                <th>Zone</th>
                <th>Contact</th>
                <!--th>Address</th-->
                <th>Status</th>
                <?php if(in_array('updateBrand', $user_permission) || in_array('deleteBrand', $user_permission)): ?>
                  <th>Action</th>
                <?php endif; ?>
              </tr>
              </thead>

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

<?php if(in_array('createBranch', $user_permission)): ?>
<!-- create brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addBrandModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Branch</h4>
      </div>
      <form role="form" action="<?php echo base_url('branch/create') ?>" method="post" id="createBranchForm">
       <div class="modal-body">
			<div id="messages"></div>

			<div class="form-group">
				<label for="area_code">Select Area</label>
				<select class="form-control select_group" id="area_code" name="area_code" style="width: 100%; margin-top: -8px !important;" required>
					<option value="">Select Area</option>
					<?php foreach ($areas as $k => $v): ?>
					  <option value="<?php echo $v['area_code'] ?>"><?php echo $v['area_name'] ?></option>
					<?php endforeach ?>
				</select>
			</div> 
      
			<div class="form-group">
				<label for="branch_code">Branch Code</label>
				<input type="text" class="form-control" id="branch_code" name="branch_code" placeholder="Enter Branch Code"  autocomplete="off">
			</div>

			<div class="form-group">
				<label for="brand_name">Branch Name</label>
				<input type="text" class="form-control" id="branch_name" name="branch_name" placeholder="Enter Branch name" autocomplete="off">
			</div>


			<div class="form-group">
				<label for="branch_name_bn">Branch Name Bangla</label>
				<input type="text" class="form-control" id="branch_name_bn" name="branch_name_bn" placeholder="Enter Bangla Branch Name" autocomplete="off">
			</div>

			<div class="form-group">
				<label for="branch_contact_no">Branch Contact No</label>
				<input type="text" class="form-control" id="branch_contact_no" name="branch_contact_no" placeholder="Enter Contact Name" autocomplete="off">
			</div>

			<div class="form-group">
				<label for="branch_address">Branch Address</label>
				<textarea name="branch_address" id="branch_address" class="form-control"></textarea>
			</div>

			<div class="form-group">
				<label for="status">Status</label>
				<select class="form-control" id="status" name="status">
				  <option value="1">Active</option>
				  <option value="0">Inactive</option>
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

<?php if(in_array('updateBranch', $user_permission)): ?>
<!-- edit brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editBranchModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Branch</h4>
      </div>

      <form role="form" action="<?php echo base_url('branch/update') ?>" method="post" id="updateBranchForm">

		<div class="modal-body">
			<div id="messages"></div>
			<div class="form-group">
				<label for="edit_area_code">Select Area</label>
				<select class="form-control select_group" id="edit_area_code" name="edit_area_code" style="width: 100%; margin-top: -8px !important;" required>
					<?php foreach ($areas as $k => $v): ?>
					  <option value="<?php echo $v['area_code'] ?>"><?php echo $v['area_name'] ?></option>
					<?php endforeach ?>
				</select>
			</div> 
			<div class="form-group">
				<label for="edit_branch_code">Branch Code</label>
				<input type="text" class="form-control" id="edit_branch_code" name="edit_branch_code" readonly autocomplete="off">
			</div>

			<div class="form-group">
				<label for="edit_brand_name">Branch Name</label>
				<input type="text" class="form-control" id="edit_branch_name" name="edit_branch_name" placeholder="Enter Branch name" autocomplete="off">
				<input type="hidden" class="form-control" id="old_branch_name" name="old_branch_name"  autocomplete="off">
			</div>


			<div class="form-group">
				<label for="edit_branch_name_bn">Branch Name Bangla</label>
				<input type="text" class="form-control" id="edit_branch_name_bn" name="edit_branch_name_bn" placeholder="Enter Branch Name" autocomplete="off">
				<input type="hidden" class="form-control" id="old_branch_name_bn" name="old_branch_name_bn"  autocomplete="off">
			</div>

			<div class="form-group">
				<label for="edit_branch_contact_no">Branch Contact No</label>
				<input type="text" class="form-control" id="edit_branch_contact_no" name="edit_branch_contact_no" placeholder="Enter Branch Name" autocomplete="off">
			</div>

			<div class="form-group">
				<label for="edit_branch_address">Branch Address</label>
				<textarea name="edit_branch_address" id="edit_branch_address" class="form-control"></textarea>
			</div>

			<div class="form-group">
				<label for="edit_status">Status</label>
				<select class="form-control" id="edit_status" name="edit_status">
				  <option value="1">Active</option>
				  <option value="0">Inactive</option>
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

<?php if(in_array('deleteBrand', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeBrandModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Brand</h4>
      </div>

      <form role="form" action="<?php echo base_url('branch/remove') ?>" method="post" id="removeBranchdForm">
        <div class="modal-body">
          <p>Do you really want to remove?</p>
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

 $("#mainSettingsNav").addClass('active');
 $("#manageBranchNav").addClass('active');
$(".select_group").select2();
  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
	"pageLength": 25,
    'ajax': 'fetchAllBranches',
    'order': []
  });

  // submit the create from 
  $("#createBranchForm").unbind('submit').on('submit', function() {
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
          $("#addBrandModal").modal('hide');

          // reset the form
          $("#createBranchForm")[0].reset();
          $("#createBranchForm .form-group").removeClass('has-error').removeClass('has-success');

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

function editBranch(id)
{ 
	
  $.ajax({
    url: 'fetchBranchById/'+id,
    type: 'post',
    dataType: 'json',
    success:function(response) {
		console.log(response);
      $("#edit_area_code").val(response[0].area_code);
      $("#edit_branch_code").val(response[0].branch_code);
      $("#edit_branch_code").val(response[0].branch_code);
      $("#edit_branch_name").val(response[0].branch_name);
      $("#old_branch_name").val(response[0].branch_name);
      $("#edit_branch_name_bn").val(response[0].branch_name_bn);
      $("#old_branch_name_bn").val(response[0].branch_name_bn);
      $("#edit_branch_contact_no").val(response[0].branch_contact_no);
      $("#edit_branch_address").val(response[0].branch_address);
      $("#edit_status").val(response[0].status);

      // submit the edit from 
      $("#updateBranchForm").unbind('submit').bind('submit', function() {
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
              $("#editBranchModal").modal('hide');
              // reset the form 
              $("#updateBranchForm .form-group").removeClass('has-error').removeClass('has-success');

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

function removeBranch(id)
{
  if(id) {
    $("#removeBranchdForm").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { brand_id:id }, 
        dataType: 'json',
        success:function(response) {

          manageTable.ajax.reload(null, false); 

          if(response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');

            // hide the modal
            $("#removeBrandModal").modal('hide');

          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
          }
        }
      }); 

      return false;
    });
  }
}


</script>
