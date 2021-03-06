<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Vendors</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Vendors</li>
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

        <?php if(in_array('createSupplier', $user_permission)): ?>
          <button class="btn btn-primary" data-toggle="modal" data-target="#addSupplierModel">Add Vendors</button>
          <br /> <br />
        <?php endif; ?>

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage Vendors</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Addrress</th>
                <th>Mobile</th>
                <th>Group Name</th>
                <th>Status</th>
                <?php if(in_array('updateSupplier', $user_permission) || in_array('deleteSupplier', $user_permission)): ?>
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

<?php if(in_array('createSupplier', $user_permission)): ?>
<!-- create Supplier modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addSupplierModel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Vendor</h4>
      </div>
      <form role="form" action="<?php echo base_url('suppliers/create') ?>" method="post" id="createSupplierForm">
        <div class="modal-body">
          <div class="form-group">
            <label for="vendor_name">Vendor Name</label>
            <input type="text" class="form-control" id="vendor_name" name="vendor_name" placeholder="Enter Vendor Name" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="vendor_email">Vendor Email</label>
            <input type="text" class="form-control" id="vendor_email" name="vendor_email" placeholder="Enter Vendor Email" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="address">Vendor Address</label>
            <textarea class="form-control" name="address" id="address" cols="10" rows="2"></textarea>
          </div>

          <div class="form-group">
            <label for="phone">Vendor Mobile No.</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Vendor Mobile No" autocomplete="off">
          </div>

			<div class="form-group">
			  <label for="group_code">Select Group</label>
			  <select class="form-control select_group" id="group_code" name="group_code" style="width: 100%; margin-top: -8px !important;" required>
				<option value="">Select Group</option>
				<?php foreach ($businessGroups as $k => $v): ?>
				  <option value="<?php echo $v['id'] ?>"><?php echo $v['group_name'] ?></option>
				<?php endforeach ?>
			  </select>
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

<?php if(in_array('updateSupplier', $user_permission)): ?>
<!-- edit Supplier modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editSupplierModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Vendor</h4>
      </div>
      <form role="form" action="<?php echo base_url('suppliers/update') ?>" method="post" id="updateSupplierForm">
        <div class="modal-body">
          <div id="messages"></div>

          <div class="form-group">
            <label for="edit_vendor_name">Vendor Name</label>
            <input type="text" class="form-control" id="edit_vendor_name" name="edit_vendor_name" placeholder="Enter Vendor Name" autocomplete="off">
            <input type="hidden" class="form-control" id="old_vendor_name" name="old_vendor_name"  autocomplete="off">
          </div>

          <div class="form-group">
            <label for="edit_vendor_email">Vendor Email</label>
            <input type="text" class="form-control" id="edit_vendor_email" name="edit_vendor_email" placeholder="Enter Vendor Email" autocomplete="off">
            <input type="hidden" class="form-control" id="old_vendor_email" name="old_vendor_email"  autocomplete="off">
          </div>

          <div class="form-group">
            <label for="edit_address">Vendor Address</label>
            <textarea class="form-control" name="edit_address" id="edit_address" cols="10" rows="2"></textarea>
          </div>

          <div class="form-group">
            <label for="edit_phone">Vendor Mobile No.</label>
            <input type="text" class="form-control" id="edit_phone" name="edit_phone" placeholder="Enter Phone Number" autocomplete="off">
          </div>
		  
		  	<div class="form-group">
			  <label for="edit_group_code">Select Group</label>
			  <select class="form-control select_group" id="edit_group_code" name="edit_group_code" style="width: 100%; margin-top: -8px !important;" required>
				<?php foreach ($businessGroups as $k => $v): ?>
				  <option value="<?php echo $v['id'] ?>"><?php echo $v['group_name'] ?></option>
				<?php endforeach ?>
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

<?php if(in_array('deleteSupplier', $user_permission)): ?>
<!-- remove Supplier modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeSupplierModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Supplier</h4>
      </div>
      <form role="form" action="<?php echo base_url('suppliers/remove') ?>" method="post" id="removeSupplierForm">
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
  $("#manageVendors").addClass('active');
$(".select_group").select2();
  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': 'fetchSupplierData',
    'order': []
  });

  // submit the create from 
  $("#createSupplierForm").unbind('submit').on('submit', function() {
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
          $("#addSupplierModel").modal('hide');

          // reset the form
          $("#createSupplierForm")[0].reset();
          $("#createSupplierForm .form-group").removeClass('has-error').removeClass('has-success');

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

function editSupplier(id)
{ 
  $.ajax({
    url: 'fetchSupplierDataById/'+id,
    type: 'post',
    dataType: 'json',
    success:function(response) {
		console.log(response.email);
      $("#edit_vendor_name").val(response.vendor_name);
      $("#old_vendor_name").val(response.vendor_name);
      $("#edit_vendor_email").val(response.vendor_email);
      $("#old_vendor_email").val(response.vendor_email);
      $("#edit_address").text(response.address);
      $("#edit_phone").val(response.phone);
      $("#edit_group_code").val(response.group_code);

      // submit the edit from 
      $("#updateSupplierForm").unbind('submit').bind('submit', function() {
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
              $("#editSupplierModal").modal('hide');
              // reset the form 
              $("#updateSupplierForm .form-group").removeClass('has-error').removeClass('has-success');

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

function removeSupplier(id)
{
  if(id) {
    $("#removeSupplierForm").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { supplier_id:id }, 
        dataType: 'json',
        success:function(response) {

          manageTable.ajax.reload(null, false); 

          if(response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');

            // hide the modal
            $("#removeSupplierModal").modal('hide');

          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
			 $("#removeSupplierModal").modal('hide');
          }
        }
      }); 

      return false;
    });
  }
}


</script>
