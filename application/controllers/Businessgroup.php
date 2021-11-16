<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Businessgroup extends Admin_Controller 
{
	public function __construct(){
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Business Group';
		$this->load->model('model_businessgroup');
	}

	/* 
	* It only redirects to the manage Business Group page
	*/
	public function index(){
		if(!in_array('viewBusinessGroup', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$this->render_template('businessgroup/index', $this->data);	
	}	

	/*
	* It checks if it gets the Business Group id and retreives
	* the Business Group information from the Business Group model and 
	* returns the data into json format. 
	* This function is invoked from the view page.
	*/
	public function fetchBusinessGroupById($id) 
	{
		if($id) {
			$data = $this->model_businessgroup->getBusinessGroup($id);
			echo json_encode($data);
		}

		return false;
	}

	/*
	* Fetches the Business Group value from the Business Group table 
	* this function is called from the datatable ajax function
	*/
	public function fetchBusinessGroupData()
	{
		$result = array('data' => array());

		$data = $this->model_businessgroup->getBusinessGroup();

		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			if(in_array('updateCategory', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
			}
			if(in_array('deleteCategory', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
			$status = ($value['status'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['group_name'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	* Its checks the Business Group form validation 
	* and if the validation is successfully then it inserts the data into the database 
	* and returns the json format operation messages
	*/
	public function create()
	{
		if(!in_array('createBusinessGroup', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('group_name', 'Group Name', 'trim|required|is_unique[tbl_group_head.group_name]');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'group_name' => $this->input->post('group_name'),
        		'status' => $this->input->post('status'),	
        	);

        	$create = $this->model_businessgroup->create($data);
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
	* Its checks the Business Group form validation 
	* and if the validation is successfully then it updates the data into the database 
	* and returns the json format operation messages
	*/
	public function update($id)
	{

		if(!in_array('updateBusinessGroup', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {
			if(trim($this->input->post('edit_group_name')) != trim($this->input->post('old_group_name'))){
				$this->form_validation->set_rules('edit_group_name', 'Group Name', 'trim|required|is_unique[tbl_group_head.group_name]');
			} else {
				$this->form_validation->set_rules('edit_group_name', 'Group Name', 'trim|required');
			}
			$this->form_validation->set_rules('edit_status', 'Status', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'group_name' => $this->input->post('edit_group_name'),
	        		'status' => $this->input->post('edit_status'),	
	        	);

	        	$update = $this->model_businessgroup->update($data, $id);
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
	* It removes the Business Group information from the database 
	* and returns the json format operation messages
	*/
	public function remove()
	{
		if(!in_array('deleteCategory', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$category_id = $this->input->post('category_id');

		$response = array();
		if($category_id) {
			$delete = $this->model_businessgroup->remove($category_id);
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