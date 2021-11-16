<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends Admin_Controller 
{
	public function __construct(){
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Suppliers';
		$this->load->model('model_suppliers');
		$this->load->model('model_businessgroup');
	}

	/* 
	* It only redirects to the manage Supplier page and
	*/
	public function index()
	{
		if(!in_array('viewSupplier', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$this->data['businessGroups'] =$this->model_businessgroup->getActiveBusinessGroup();
		$this->render_template('suppliers/index', $this->data);
	}

	/*
	* Fetches the supplier data from the supplier table 
	* this function is called from the datatable ajax function
	*/
	public function fetchSupplierData()
	{
		$result = array('data' => array());

        $data = $this->model_suppliers->getSupplierData();
       /*  echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit; */
		foreach ($data as $key => $value) {
			// button
			$buttons = '';
			if(in_array('viewSupplier', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editSupplier('.$value['id'].')" data-toggle="modal" data-target="#editSupplierModal"><i class="fa fa-pencil"></i></button>';	
			}
			if(in_array('deleteSupplier', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeSupplier('.$value['id'].')" data-toggle="modal" data-target="#removeSupplierModal"><i class="fa fa-trash"></i></button>
				';
			}				
			$status = ($value['status'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';
			$result['data'][$key] = array(
				$value['vendor_name'],
				$value['vendor_email'],
				$value['address'],
				$value['phone'],
				$value['group_name'],
				$status,
				$buttons
			); 
		} // /foreach

		echo json_encode($result);
	}

	/*
	* It checks if it gets the supplier id and retreives
	* the supplier information from the supplier model and 
	* returns the data into json format. 
	* This function is invoked from the view page.
	*/
	public function fetchSupplierDataById($id)
	{
		if($id) {
			$data = $this->model_suppliers->getSupplierData($id);
			echo json_encode($data);
		}

		return false;
	}

	/*
	* Its checks the supplier form validation 
	* and if the validation is successfully then it inserts the data into the database 
	* and returns the json format operation messages
	*/
	public function create(){
		if(!in_array('createSupplier', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$response = array();
		$this->form_validation->set_rules('vendor_name', 'Vendor Name', 'trim|required|is_unique[vendors.vendor_name]');
		$this->form_validation->set_rules('vendor_email', 'Vendor Email', 'trim|required');
		$this->form_validation->set_rules('address', 'Vendor Address', 'trim|required');
		$this->form_validation->set_rules('phone', 'Vendor Mobile', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'vendor_name' 		=> $this->input->post('vendor_name'),
        		'vendor_email' 	=> $this->input->post('vendor_email'),
        		'address' 	=> $this->input->post('address'),
        		'phone' 	=> $this->input->post('phone'),
        		'group_code' 	=> $this->input->post('group_code'),
        		'status' 	=> $this->input->post('status'),
        	);

        	$create = $this->model_suppliers->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Succesfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the supplier information';			
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }
        echo json_encode($response);
	}

	/*
	* Its checks the supplier form validation 
	* and if the validation is successfully then it updates the data into the database 
	* and returns the json format operation messages
	*/
	public function update($id){
		if(!in_array('updateSupplier', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$response = array();
		if($id) {
			
			if(trim($this->input->post('edit_vendor_name')) != trim($this->input->post('old_vendor_name'))){
				$this->form_validation->set_rules('edit_vendor_name', 'Vendor Name', 'trim|required|is_unique[vendors.vendor_name]');
			} else {
				$this->form_validation->set_rules('edit_vendor_name', 'Vendor Name', 'trim|required');
			}
			
			
			if(trim($this->input->post('edit_vendor_email')) != trim($this->input->post('old_vendor_email'))){
				$this->form_validation->set_rules('edit_vendor_email', 'Vendor Email', 'trim|required|is_unique[vendors.vendor_email]');
			} else {
				$this->form_validation->set_rules('edit_vendor_email', 'Vendor Email', 'trim|required');
			}
			$this->form_validation->set_rules('edit_address', 'Supplier Address', 'trim|required');
			$this->form_validation->set_rules('edit_phone', 'Supplier Mobile', 'trim|required');
			$this->form_validation->set_rules('edit_group_code', 'Group Code', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
				$data = array(
					'vendor_name' 		=> $this->input->post('edit_vendor_name'),
					'vendor_email' 	=> $this->input->post('edit_vendor_email'),
					'address' 	=> $this->input->post('edit_address'),
					'phone' 	=> $this->input->post('edit_phone'),
					'group_code' 	=> $this->input->post('edit_group_code'),
					'updated_at' 	=> date("Y-m-d H:i:s"),
				);
			
	        	$update = $this->model_suppliers->update($data, $id);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Succesfully updated';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updated the Supplier information';			
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Error please refresh the page again!!';
		}

		echo json_encode($response);
	}

	/*
	* It removes the Supplier information from the database 
	* and returns the json format operation messages
	*/
	public function remove(){
		if(!in_array('deleteSupplier', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$supplier_id = $this->input->post('supplier_id');
		$response = array();
		if($supplier_id) {
			$delete = $this->model_suppliers->remove($supplier_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Successfully removed";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Can't Delete Supplier information, this Supplier is used in Inventory";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Refersh the page again!!";
		}

		echo json_encode($response);
	}

}