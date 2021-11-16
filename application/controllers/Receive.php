<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Receive extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Product Receive';
		$this->load->model('model_brands');
		$this->load->model('model_receive');
		$this->load->model('model_category');
		$this->load->model('model_suppliers');
		$this->load->model('model_products');
	}

	/* 
	* It only redirects to the manage product page and
	*/
	public function index()
	{
		if(!in_array('viewProductReceive', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$this->render_template('receive/index', $this->data);
	}

	/*
	* Fetches the brand data from the brand table 
	* this function is called from the datatable ajax function
	*/
	public function fetchProductReceiveData()
	{
		$result = array('data' => array());

		$data = $this->model_receive->getProductReceiveData();
		$i=0;
		foreach ($data as $key => $value) {
			$i++;
			// button
			$buttons = '';
			if(in_array('viewProductReceive', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editBrand('.$value['id'].')" data-toggle="modal" data-target="#editBrandModal"><i class="fa fa-pencil"></i></button>';	
			}
			if(in_array('deleteProductReceive', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeBrand('.$value['id'].')" data-toggle="modal" data-target="#removeBrandModal"><i class="fa fa-trash"></i></button>
				';
			}	
			$status = ($value['product_status'] == 1) ? '<span class="label label-success">Completed</span>' : '<span class="label label-warning">Incomplete</span>';
				$result['data'][$key] = array(
					$i,
					$value['id'],
					$value['voucher_no'],
					$value['purchase_date'],
					$value['vendor_name'],
					$value['branch_name'],
					$value['total_voucher_amount'],
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
		$this->data['page_title'] = 'Product Receive';

		if ($this->uri->segment('3')) {
            $purchase_id = $this->uri->segment('3');
        }

		if (!empty($purchase_id)) {
            $this->data['temp_purchase'] = $this->model_receive->temp_purchase($temp_purchase);
            $this->data['temp_purchase_details'] = $this->model_receive->temp_purchase_details($purchase_id);
		} else {
            $this->data['temp_purchase'] = $this->model_receive->temp_purchase();
			
            $this->data['temp_purchase_details'] = $this->model_receive->temp_purchase_details();
        }


		$this->data['suppliers'] = $this->model_suppliers->getSupplierData(); 
		$this->data['products'] = $this->model_products->getProductData(); 
		$this->render_template('receive/create', $this->data);
	}

	/*
	* It gets the all the active product inforamtion from the product table 
	* This function is used in the order page, for the product selection in the table
	* The response is return on the json format.
	*/
	public function getTableProductRow()
	{
		$products = $this->model_products->getProductData();
		echo json_encode($products);
	}

	/*get customer information*/
	public function getProductInfo(){
		$product_id=$this->input->post('product_id');
		$result=$this->db->query("SELECT
										products.id AS product_id,
										products.product_name AS product_name,
										products.is_serialised AS is_serialised
									FROM
										products
									WHERE
										id = $product_id")->result_array();
		
		$result1=$this->db->query("SELECT
										product_id,
										purchase_price,
										sales_price,
										incentive_amt
									FROM
										prices
									WHERE
										price_id =(
										SELECT
											MAX(price_id) AS price_id
										FROM
											prices
										WHERE
											product_id = $product_id)")->result_array();
						if(!empty($result1)){
							$purchase_price=$result1[0]['purchase_price'];
							$sales_price=$result1[0]['sales_price'];
							$incentive_amt=$result1[0]['incentive_amt'];
						}else{
							$purchase_price=0;
							$sales_price=0;
							$incentive_amt=0;
						}		 
						$data[]=array(
							'product_id' => $result[0]['product_id'],
							'product_name'=>$result[0]['product_name'],
							'is_serialised'=>$result[0]['is_serialised'],
							'purchase_price'=>$result1[0]['purchase_price'],
							'sales_price'=>$result1[0]['sales_price'],
							'incentive_amt'=>$result1[0]['incentive_amt']
						);
		echo json_encode($data);
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


		public function createPurchase(){
			if(!in_array('createOrder', $this->permission)) {
				redirect('dashboard', 'refresh');
			}

		
			$this->data['page_title'] = 'Product Receive';
			$this->form_validation->set_rules('vendor_id', 'Vendor name', 'trim|required');
			$this->form_validation->set_rules('product_id', 'Product name', 'trim|required');
			$this->form_validation->set_rules('quantity', 'Product Quantiry ', 'required|trim');
			$this->form_validation->set_rules('purchase_price', 'Product Purchase Price', 'required|trim');
			$this->form_validation->set_rules('chalan_no', 'Chalan No', 'required|trim');

			
			if ($this->form_validation->run() == TRUE) { 
				$id =$this->input->post('id');
				if(!empty($id)){
					$createPurchase = $this->model_receive->createPurchaseDetails();
					if($createPurchase) {
						$this->session->set_flashdata('success', 'Successfully created');
						redirect('receive/create/', 'refresh');
					}else {
						$this->session->set_flashdata('errors', 'Error occurred!!');
						redirect('receive/create/', 'refresh');
					}
				}else{
					
					$createPurchase = $this->model_receive->create();
					if($createPurchase) {
						$this->session->set_flashdata('success', 'Successfully created');
						redirect('receive/create/', 'refresh');
					}else {
						$this->session->set_flashdata('errors', 'Error occurred!!');
						redirect('receive/create/', 'refresh');
					}
				}
				
			}
			else {
				if ($this->uri->segment('3')) {
					$purchase_id = $this->uri->segment('3');
				}
				if (!empty($purchase_id)) {
					$this->data['temp_purchase'] = $this->model_receive->temp_purchase($temp_purchase);
					$this->data['temp_purchase_details'] = $this->model_receive->temp_purchase_details($purchase_id);
				} else {
					$this->data['temp_purchase'] = $this->model_receive->temp_purchase();
					$this->data['temp_purchase_details'] = $this->model_receive->temp_purchase_details();
				}
				$this->data['suppliers'] = $this->model_suppliers->getSupplierData(); 
				$this->data['products'] = $this->model_products->getProductData();   
				
				$this->render_template('receive/create', $this->data);
			} 
			
		}

		public function savePurchase(){
			if(!in_array('createOrder', $this->permission)) {
				redirect('dashboard', 'refresh');
			}
			$this->data['page_title'] = 'Product Purchase';
			
			if(!empty($this->input->post('id'))){
				$id=$this->input->post('id');
				if(!empty($this->input->post('detailinformation'))){
					$detailsArray=$this->input->post('detailinformation');
					$updateArray=array();
					for($i=0; $i<count($detailsArray); $i++){
					$row_arr=json_decode($detailsArray[$i]);
					array_push($updateArray,$row_arr);
					}
					$this->db->update_batch('purchase_details', $updateArray, 'id'); 
				}
				$purchaseData=array(
					'total_voucher_amount'=>$this->input->post('total_voucher_amount'),
					'status'=>1,
				);
				$this->db->where('id', $id);
				$update = $this->db->update('purchases', $purchaseData);
				$this->session->set_flashdata('success', 'Successfully created');
				
				redirect('receive');
				
			}
			
			
			
			
			

		}

		/* Delete from purchase details*/

		public function deletePurchaseDetailsByID(){
			if(!in_array('deleteProduct', $this->permission)) {
				redirect('dashboard', 'refresh');
			}
			
			/* echo '<pre>';
			print_r($_POST);
			echo '</pre>';
			exit; */
			$purchase_details_id = $this->input->post('purchase_details_id');
			$is_serialised = $this->input->post('is_serialised');
			$purchase_id = $this->input->post('purchase_id');

			$countPurchaseDetailsData=$this->db->query("SELECT COUNT(*) AS total_row FROM purchase_details WHERE purchase_id=$purchase_id GROUP BY purchase_id")->row();

			if($countPurchaseDetailsData->total_row>1){
				if(!empty($purchase_details_id)){
						$response = array();
						$delete = $this->model_receive->deletePurchaseDetailsByID($purchase_details_id,$is_serialised);
						if($delete == true) {
						$response['success'] = true;
							$response['messages'] = "Successfully removed";
							//$response="Successfully deleted ";
						}
						else {
							$response['success'] = false;
							$response['messages'] = "Error in the database while removing the product information";
						}
					echo json_encode($response);
				}else{
					$response['success'] = false;
					$response['messages'] = "Product Not Deleted!!";
					echo json_encode($response);
				}
			}else{
				$response = array();
				$delete = $this->model_receive->deletePurchaseDetailsByID($purchase_details_id);
				if($delete == true) {
					$delete_purchase_table_info = $this->model_receive->deletePurchaseByID($purchase_id);
					$response['success'] = true;
					$response['messages'] = "Successfully removed";
				}
				else {
					$response['success'] = false;
					$response['messages'] = "Error in the database while removing the product information";
				}
				echo json_encode($response);
			}
			
		}

}