<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Demand extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Brands';
		$this->load->model('model_demand');
		$this->load->model('model_brands');
		$this->load->model('model_businessgroup');
	}

	/* 
	* It only redirects to the manage product page and
	*/
	public function index()
	{
		if(!in_array('viewBrand', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->data['businessGroups'] =$this->model_businessgroup->getActiveBusinessGroup();
		$this->render_template('brands/index', $this->data);
	}



	/* Configuration lists */

	public function configurations(){
		
		if(!in_array('viewDemandConfiguration', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->data['businessGroups'] =$this->model_businessgroup->getActiveBusinessGroup();
		$this->render_template('demand/demand_configuration', $this->data);
	}




	/*
	* Fetches the demand configurations data from the demand_config table 
	* this function is called from the datatable ajax function
	*/
	
	public function fetchDemandConfigurations(){
		$result = array('data' => array());
		$data = $this->model_demand->getDemandConfigurationsData();
		$i=0;
		foreach ($data as $key => $value){
			$i++;
			$buttons = '';
			if(in_array('updateDemandConfiguration', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunction('.$value['id'].')" data-toggle="modal" data-target="#editDemandConfigarationModal"><i class="fa fa-pencil"></i></button>';	
			}
			if(in_array('deleteDemandConfiguration', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunction('.$value['id'].')" data-toggle="modal" data-target="#removeDemandConfigarationModal"><i class="fa fa-trash"></i></button>';
			}	
			$status = ($value['status'] == 1) ? '<span class="label label-success">Running</span>' : '<span class="label label-warning">Expired</span>';
			$result['data'][$key] = array(
				$i,
				$value['demand_id'],
				date('d-M-Y', strtotime($value['from_date'])),
				date('d-M-Y', strtotime($value['to_date'])),
				$status,
				$buttons
			);
		} 
		echo json_encode($result);
	}
	
	/*
	* Fetches the brand data from the brand table 
	* this function is called from the datatable ajax function
	*/
	
	public function fetchBrandData()
	{
		$result = array('data' => array());

		$data = $this->model_brands->getBrandData();
		$i=0;
		foreach ($data as $key => $value) {
			$i++;
			// button
			$buttons = '';
			if(in_array('viewBrand', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editBrand('.$value['id'].')" data-toggle="modal" data-target="#editBrandModal"><i class="fa fa-pencil"></i></button>';	
			}
			if(in_array('deleteBrand', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeBrand('.$value['id'].')" data-toggle="modal" data-target="#removeBrandModal"><i class="fa fa-trash"></i></button>
				';
			}	
			$status = ($value['status'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';
			$result['data'][$key] = array(
				$i,
				$value['brand_name'].'('.$value['id'].')',
				$value['group_name'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	* It checks if it gets the brand id and retreives
	* the brand information from the brand model and 
	* returns the data into json format. 
	* This function is invoked from the view page.
	*/
	public function fetchBrandDataById($id)
	{
		if($id) {
			$data = $this->model_brands->getBrandData($id);
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

		if(!in_array('createBrand', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$response = array();
		
		//$this->form_validation->set_rules('username', 'Username', 'callback_demanddate_exists');
		
		$this->form_validation->set_rules('from_date', 'Select From Date', 'trim|required');
		$this->form_validation->set_rules('to_date', 'Select To Date', 'trim|required');
		$this->form_validation->set_rules('status', 'status', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
			$yearMonth=date('Ym');
			$query = $this->db->query("SELECT IFNULL(MAX(demand_id),0) AS demand_id FROM demand_config WHERE demand_id LIKE '%".$yearMonth."%'")->result();
			$demand_id=$query[0]->demand_id==0?$yearMonth.'01':$query[0]->demand_id+1;
        	$data = array(
				'demand_id' => $demand_id,
        		'from_date' => $this->input->post('from_date'),
        		'to_date' 	=> $this->input->post('to_date'),	
        		'status' 	=> $this->input->post('status'),	
        	);

        	$create = $this->model_demand->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Succesfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the Demand Configuration';			
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
	public function update($id)
	{
		if(!in_array('updateBrand', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_brand_name', 'Brand name', 'trim|required');
			if(trim($this->input->post('edit_brand_name')) != trim($this->input->post('old_brand_name'))){
				$this->form_validation->set_rules('edit_brand_name', 'Brand name', 'trim|required|is_unique[brands.brand_name]');
			} else {
				$this->form_validation->set_rules('edit_brand_name', 'Brand name', 'trim|required');
			}

			$this->form_validation->set_rules('edit_status', 'status', 'trim|required');
			$this->form_validation->set_rules('edit_group_code', 'group_code', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
					'brand_name' => $this->input->post('edit_brand_name'),
					'group_code' => $this->input->post('edit_group_code'),	
					'status' => $this->input->post('edit_status'),	
				);

	        	$update = $this->model_brands->update($data, $id);
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
		if(!in_array('deleteBrand', $this->permission)) {
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
	
	/* check demand date exits in database */
	/* function demanddate_exists($columnName,$date){
		$this->model_demand->demanddate_exists($date);
	} */

}