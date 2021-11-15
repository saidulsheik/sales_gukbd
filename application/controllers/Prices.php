<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Prices extends Admin_Controller 
{
	public function __construct(){
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Product Prices';
		$this->load->model('model_prices');
	}

	/* 
	* It only redirects to the manage Prices page and
	*/
	public function index()
	{
		if(!in_array('viewProductPrice', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$this->data['products']=$this->db->query("SELECT
													products.id,
													products.product_name,
													products.product_model,
													brands.brand_name,
													categories.category_name
												FROM
													products
												LEFT JOIN brands ON brands.id = products.brand_id
												LEFT JOIN categories ON categories.id = products.category_id
												WHERE
													products.id NOT IN(
													SELECT DISTINCT
														(product_id)
													FROM
														prices
												) AND products.status = 1")->result();
		$this->render_template('prices/index', $this->data);
	}

	/*
	* Fetches the brand data from the brand table 
	* this function is called from the datatable ajax function
	*/
	public function fetchProductPricesData(){
		$result = array('data' => array());
		$data = $this->model_prices->getProductPrices();
		$i=0;
		foreach ($data as $key => $value) {
			$i++;
			$buttons = '';
			if(in_array('viewProductPrice', $this->permission)) {
				$buttons .= '<a href="'.base_url().'prices/view_price_details/'.$value['product_id'].'" title="View Details" target="_blank" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a> ';	
			}
			
			if(in_array('updateProductPrice', $this->permission)) {
				$buttons .= ' <button type="button" title="Price Update"  class="btn btn-warning btn-xs" onclick="editProductPrice('.$value['price_id'].')" data-toggle="modal" data-target="#editPriceUpdateModal"><i class="fa fa-pencil"></i></button>';	
			}
			
			$result['data'][$key] = array(
				$i,
				$value['product_name'],
				$value['brand_name'],
				$value['price_from'],
				$value['category_name'],
				$value['purchase_price'],
				$value['sales_price'],
				$value['incentive_amt'],
				
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
	public function fetchPriceDataById($id)
	{
		if($id) {
			$data = $this->model_prices->getProductPrices($id);
			
			/* echo '<pre>';
			print_r($data);
			echo '</pre>';
			exit; */
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

		if(!in_array('createProductPrice', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$response = array();
		$this->form_validation->set_rules('product_id', 'product_id', 'trim|required|is_unique[prices.product_id]');
		$this->form_validation->set_rules('purchase_price', 'Purchase Price', 'trim|required');
		$this->form_validation->set_rules('sales_price', 'Sales Price', 'trim|required');
		$this->form_validation->set_rules('down_payment', 'Down Payment', 'trim|required');
		$this->form_validation->set_rules('loan_amount', 'Loan Amount', 'trim|required');
		$this->form_validation->set_rules('incentive_amt', 'Incentive Amount', 'trim|required');
		//$this->form_validation->set_rules('office_sale_price', 'Office Sales Price', 'trim|required');
		$this->form_validation->set_rules('price_from', 'Price Effective Date', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$created_by = $this->session->userdata('id');
	        	$data = array(
					'product_id' 		=> $this->input->post('product_id'),
					'purchase_price' 	=> $this->input->post('purchase_price'),
					'sales_price' 		=> $this->input->post('sales_price'),	
					'incentive_amt' 	=> $this->input->post('incentive_amt'),	
					'price_from' 		=> $this->input->post('price_from'),	
					'price_status' 		=> 1,
					'created_by' 		=> $created_by
				);
			/* echo '<pre>';
			print_r($data);
			exit; */
        	$create = $this->model_prices->create($data);
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
	public function update($price_id)
	{
		if(!in_array('updateProductPrice', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		
		/* echo '<pre>';
		print_r($_POST);
		echo '</pre>';
		exit; */
		$response = array();
		if($price_id) {
			$this->form_validation->set_rules('edit_purchase_price', 'Purchase Price', 'trim|required');
			$this->form_validation->set_rules('edit_sales_price', 'Sales Price', 'trim|required');
			$this->form_validation->set_rules('edit_incentive_amt', 'Incentive Amount', 'trim|required');
			$this->form_validation->set_rules('edit_price_from', 'Price Effective Date', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
				$created_by = $this->session->userdata('id');
	        	$data = array(
					'product_id' 		=> $this->input->post('edit_product_id'),
					'purchase_price' 	=> $this->input->post('edit_purchase_price'),
					'sales_price' 		=> $this->input->post('edit_sales_price'),	
					'incentive_amt' 	=> $this->input->post('edit_incentive_amt'),
					'price_from' 		=> $this->input->post('edit_price_from'),	
					'price_status' 		=> 1,
					'created_by' 		=> $created_by
				);
				
				/* first Update  Previous  Price*/
				
				$updatePriceData = array(
					'price_to' 			=> date('Y-m-d', strtotime('-1 day', strtotime($this->input->post('edit_price_from')))),
					'price_status' 		=> 0
				);
				
				$update = $this->model_prices->update($updatePriceData, $price_id);
				
				if($update){
					$create = $this->model_prices->create($data);
				}
	        	if($create == true) {
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
	
	/* Getting Product Price Details */
	
	public function view_price_details($id=null){
		if(!in_array('viewProductPrice', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		if($id){
			$this->data['page_title'] = 'Show Product Price Details';
			$this->data['price_details']=$this->model_prices->view_price_details($id);
			$this->render_template('prices/view_price_details', $this->data);
		}
	}
	
	

}