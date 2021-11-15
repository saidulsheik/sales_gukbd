<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends Admin_Controller 
{
	public function __construct(){
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Manage Branch';
		$this->load->model('model_branch');
	}

	/* 
	* It only redirects to the manage Branch page 
	*/
	public function index()
	{
		if(!in_array('viewBranch', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$this->data['areas'] = $this->model_branch->getAllArea(); 
		$this->render_template('branch/index', $this->data);
	}

	/*
	* Fetches the Branch data from the tbl_branch table 
	* this function is called from the datatable ajax function
	*/
	public function fetchAllBranches(){
		$result = array('data' => array());
		$data = $this->model_branch->getBranches();
		foreach ($data as $key => $value) {
			$buttons = '';
			if(in_array('updateBranch', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editBranch('.$value['id'].')" data-toggle="modal" data-target="#editBranchModal"><i class="fa fa-pencil"></i></button>';	
			}
			if(in_array('deleteBrand', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeBranch('.$value['id'].')" data-toggle="modal" data-target="#removeBranchModal"><i class="fa fa-trash"></i></button>';
			}
			$status = ($value['status'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';
			$result['data'][$key] = array(
				$value['branch_code'],
				$value['branch_name'],
				$value['branch_name_bn'],
				$value['area_name'].'('.$value['area_code'].')',
				$value['zone_name'].'('.$value['zone_code'].')',
				$value['branch_contact_no'],
				//$value['branch_address'],
				$status,
				$buttons
			);
		}
		echo json_encode($result);
	}

	/*
	* It checks if it gets the brand id and retreives
	* the brand information from the brand model and 
	* returns the data into json format. 
	* This function is invoked from the view page.
	*/
	public function fetchBranchById($id)
	{
		if($id) {
			$data = $this->model_branch->getBranches($id);
			echo json_encode($data);
		}

		return false;
	}

	/*
	* Its checks the brand form validation 
	* and if the validation is successfully then it inserts the data into the database 
	* and returns the json format operation messages
	*/
	public function create()
	{

		if(!in_array('createBranch', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$response = array();
		$this->form_validation->set_rules('branch_code', 'Branch Code', 'trim|required|is_unique[tbl_branch.branch_code]');
		$this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required|is_unique[tbl_branch.branch_name]');
		$this->form_validation->set_rules('branch_name_bn', 'Branch Bangla Name', 'trim|required|is_unique[tbl_branch.branch_name_bn]');
		$this->form_validation->set_rules('area_code', 'Area Code', 'trim|required');
		$this->form_validation->set_rules('branch_contact_no', 'Branch Contact No', 'trim|required');
		$this->form_validation->set_rules('status', 'Active', 'trim|required');
		$this->form_validation->set_rules('branch_address', 'Branch Address', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		
        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'branch_code' => $this->input->post('branch_code'),
        		'branch_name' => $this->input->post('branch_name'),
        		'branch_name_bn' => $this->input->post('branch_name_bn'),
        		'area_code' => $this->input->post('area_code'),
        		'status' => $this->input->post('status'),
        		'branch_contact_no' => $this->input->post('branch_contact_no'),
        		'branch_address' => $this->input->post('branch_address'),
        		'status' => $this->input->post('status'),	
        		'created_by' => $_SESSION['id'],	
        	);
			
		
        	$create = $this->model_branch->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Succesfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the brand information';			
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
	* Its checks the brand form validation 
	* and if the validation is successfully then it updates the data into the database 
	* and returns the json format operation messages
	*/
	public function update($id){
	
		if(!in_array('updateBranch', $this->permission)){
			redirect('dashboard', 'refresh');
		}
		$response = array();
		if($id) {
		if(trim($this->input->post('edit_branch_name')) != trim($this->input->post('old_branch_name'))){
			$this->form_validation->set_rules('edit_branch_name', 'Branch Name', 'trim|required|is_unique[tbl_branch.store_code]');
		} else {
			$this->form_validation->set_rules('edit_branch_name', 'Branch Name', 'trim|required');
		}
	
		if(trim($this->input->post('edit_branch_name_bn')) != trim($this->input->post('old_branch_name_bn'))){
			$this->form_validation->set_rules('edit_branch_name_bn', 'Branch Name Bangla', 'trim|required|is_unique[tbl_branch.branch_name_bn]');
		} else {
			$this->form_validation->set_rules('edit_branch_name_bn', 'Branch Name Bangla', 'trim|required');
		}
		$this->form_validation->set_rules('edit_area_code', 'Area Code', 'trim|required');
		$this->form_validation->set_rules('edit_branch_contact_no', 'Branch Contact No', 'trim|required');
		$this->form_validation->set_rules('edit_status', 'Active', 'trim|required');
		$this->form_validation->set_rules('edit_branch_address', 'Branch Address', 'trim|required');
		
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		   if ($this->form_validation->run() == TRUE) {
	        	$data = array(
					'branch_code' => $this->input->post('edit_branch_code'),
					'branch_name' => $this->input->post('edit_branch_name'),
					'branch_name_bn' => $this->input->post('edit_branch_name_bn'),
					'area_code' => $this->input->post('edit_area_code'),
					'status' => $this->input->post('edit_status'),
					'branch_contact_no' => $this->input->post('edit_branch_contact_no'),
					'branch_address' => $this->input->post('edit_branch_address'),
					'status' => $this->input->post('edit_status'),	
					'updated_by' => $_SESSION['id'],		
	        	);
				
	        	$update = $this->model_branch->update($data, $id);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Succesfully updated';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updated the brand information';			
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
	* It removes the brand information from the database 
	* and returns the json format operation messages
	*/
	public function remove()
	{
		if(!in_array('deleteBranch', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$brand_id = $this->input->post('brand_id');
		$response = array();
		if($brand_id) {
			$delete = $this->model_brands->remove($brand_id);

			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Successfully removed";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the brand information";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Refersh the page again!!";
		}

		echo json_encode($response);
	}

}