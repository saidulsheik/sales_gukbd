<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Products';
		$this->load->model('model_products');
		$this->load->model('model_brands');
		$this->load->model('model_category');
		$this->load->model('model_stores');
		$this->load->model('model_attributes');
		$this->load->model('model_businessgroup');
		$this->load->model('model_suppliers');
	}

    /* 
    * It only redirects to the manage product page
    */
	public function index()
	{
        if(!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->render_template('products/index', $this->data);	
	}

    /*
    * It Fetches the products data from the product table 
    * this function is called from the datatable ajax function
    */
	public function fetchProductData()
	{
		$result = array('data' => array());
		$data = $this->model_products->getProductData();
		foreach ($data as $key => $value) {
			// button
            $buttons = '';
            if(in_array('updateProduct', $this->permission)) {
    			$buttons .= '<a href="'.base_url('products/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }
            if(in_array('deleteProduct', $this->permission)) { 
    			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }
			if(!empty($value['product_image'])){
				$image_url=base_url().'assets/'.$value['product_image'];
			}else{
				$image_url=base_url().'assets/images/product_image/demo.png';
			}
			
			$img = '<img src="'.$image_url.'" alt="'.$value['product_name'].'" class="img-circle" width="50" height="50" />';

            $status = ($value['status'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

            /* $qty_status = '';
            if($value['qty'] <= 10) {
                $qty_status = '<span class="label label-warning">Low !</span>';
            } else if($value['qty'] <= 0) {
                $qty_status = '<span class="label label-danger">Out of stock !</span>';
            } */


			$result['data'][$key] = array(
				$img,
				$value['product_name'],
				$value['product_short_name'],
				$value['product_model'],
				$value['product_code'],
				$value['brand_name'],
				$value['category_name'],
				$value['group_name'],
				$value['vendor_name'],
				$status,
				$buttons
			);
		}
		/* echo '<pre>';
		print_r($data);
		echo '</pre>';
		exit; */
		echo json_encode($result);
	}	

    /*
    * If the validation is not valid, then it redirects to the create page.
    * If the validation for each input field is valid then it inserts the data into the database 
    * and it stores the operation message into the session flashdata and display on the manage product page
    */
	public function create()
	{
		if(!in_array('createProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->form_validation->set_rules('group_code', 'Product Group Name', 'trim|required');
		$this->form_validation->set_rules('brand_id', 'Prodcut Brand Name', 'trim|required');
		$this->form_validation->set_rules('category_id', 'Prodcut Category Name', 'trim|required');
		$this->form_validation->set_rules('product_name', 'Product  Name', 'trim|required');
        $this->form_validation->set_rules('vendor_id', 'Vendor Name', 'trim|required');
		$this->form_validation->set_rules('product_short_name', 'Product Short Name', 'trim|required');
		$this->form_validation->set_rules('product_model', 'Product Model', 'trim|required');
		$this->form_validation->set_rules('reorder_level', 'Reorder Level', 'trim|required');
		//$this->form_validation->set_rules('product_color', 'Select Product Color', 'trim|required');
		$this->form_validation->set_rules('description', 'Product Description', 'trim|required');
		$this->form_validation->set_rules('is_serialised', 'Select Is Product Serialised?', 'trim|required');
			
		
        if ($this->form_validation->run() == TRUE) {
            // true case
        	$upload_image = $this->upload_image();

        	$data = array(
        		'product_name' 			=> $this->input->post('product_name'),
        		'product_short_name' 	=> $this->input->post('product_short_name'),
        		'product_model' 		=> $this->input->post('product_model'),
        		'product_code' 			=> substr(uniqid(time(), true), 0, 10),
        		'description' 			=> $this->input->post('description'),
        		'group_code' 			=> $this->input->post('group_code'),
        		'brand_id' 				=> $this->input->post('brand_id'),
        		'category_id' 			=> $this->input->post('category_id'),
        		'product_color' 		=> $this->input->post('product_color'),
        		'reorder_level' 		=> $this->input->post('reorder_level'),
        		'vendor_id' 		=> $this->input->post('vendor_id'),
        		'is_serialised' 		=> $this->input->post('is_serialised'),
				'created_on'			=> date("Y-m-d H:i:s A"),
				'created_by' 			=> $this->session->userdata('user_id'),
        	);

			$insert_id = $this->model_products->create($data);
        	if($insert_id == true) {
				// If files are selected to upload 
				if(!empty($_FILES['files']['name']) && count(array_filter($_FILES['files']['name'])) > 0){ 
					$filesCount = count($_FILES['files']['name']); 
					$uploadData=array();
					for($i = 0; $i < $filesCount; $i++){ 
						$_FILES['file']['name']     = $_FILES['files']['name'][$i]; 
						$_FILES['file']['type']     = $_FILES['files']['type'][$i]; 
						$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
						$_FILES['file']['error']     = $_FILES['files']['error'][$i]; 
						$_FILES['file']['size']     = $_FILES['files']['size'][$i]; 
						 
						// File upload configuration 
						$uploadPath = 'assets/images/product_image/';
						$config['upload_path'] = $uploadPath; 
						//$config['file_name'] =  substr(uniqid(time(), true), 0, 10);
						$config['file_name'] =  $insert_id.'_'.$i;
						$config['allowed_types'] = 'jpg|jpeg|png|gif'; 
						
						//$config['max_size']    = '100'; 
						//$config['max_width'] = '1024'; 
						//$config['max_height'] = '768'; 
						 
						// Load and initialize upload library 
						$this->load->library('upload', $config); 
						$this->upload->initialize($config); 
						
						// Upload file to server 
						if($this->upload->do_upload('file')){ 
							// Uploaded file data 
							$fileData = $this->upload->data(); 
							$uploadData[] = array(
								'product_id' => $insert_id,
								'image_name' => $fileData['file_name'],
								'uploaded_on' => date("Y-m-d H:i:s")
							);
						}else{  
							$errorUploadType .= $_FILES['file']['name'].' | ';  
						} 
						
					} 
					
					
					$errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
					if(!empty($uploadData)){ 
						$insert=$this->db->insert_batch('product_images',$uploadData);
						$statusMsg = $insert?'Files uploaded successfully!'.$errorUploadType:'Some problem occurred, please try again.'; 
					}else{ 
						$statusMsg = "Sorry, there was an error uploading your file.".$errorUploadType; 
					} 
				}
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('products/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('products/create', 'refresh');
        	}
        }
        else {
			/* $formData = array(
        		'product_name' 			=> $this->input->post('product_name'),
        		'product_short_name' 	=> $this->input->post('product_short_name'),
        		'product_model' 		=> $this->input->post('product_model'),
        		'product_code' 			=> substr(uniqid(time(), true), 0, 10),
        		'description' 			=> $this->input->post('description'),
        		'brand_id' 				=> $this->input->post('brand_id'),
        		'category_id' 			=> $this->input->post('category_id'),
        		'product_color' 		=> $this->input->post('product_color'),
        		'reorder_level' 		=> $this->input->post('reorder_level')
        	); */
			$this->data['brand_id'] = $this->model_brands->getActiveBrands();        	
			$this->data['category_id'] = $this->model_category->getActiveCategroy();        	
			$this->data['group_code'] = $this->model_businessgroup->getActiveBusinessGroup();        	
			$this->data['vendor_id'] = $this->model_suppliers->getSupplierData(); 
            $this->render_template('products/create', $this->data);
        }	
	}

    /*
    * This function is invoked from another function to upload the image into the assets folder
    * and returns the image path
    */
	public function upload_image()
    {
    	// assets/images/product_image
        $config['upload_path'] = 'assets/images/product_image';
        $config['file_name'] =  uniqid();
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1000';

        // $config['max_width']  = '1024';s
        // $config['max_height']  = '768';

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('product_image'))
        {
            $error = $this->upload->display_errors();
            return $error;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $type = explode('.', $_FILES['product_image']['name']);
            $type = $type[count($type) - 1];
            
            $path = $config['upload_path'].'/'.$config['file_name'].'.'.$type;
            return ($data == true) ? $path : false;            
        }
    }

    /*
    * If the validation is not valid, then it redirects to the edit product page 
    * If the validation is successfully then it updates the data into the database 
    * and it stores the operation message into the session flashdata and display on the manage product page
    */
	public function update($product_id){      
        if(!in_array('updateProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if(!$product_id) {
            redirect('dashboard', 'refresh');
        }
	
        $this->form_validation->set_rules('group_code', 'Product Group Name', 'trim|required');
		$this->form_validation->set_rules('brand_id', 'Prodcut Brand Name', 'trim|required');
		$this->form_validation->set_rules('category_id', 'Prodcut Category Name', 'trim|required');
		$this->form_validation->set_rules('product_name', 'Product  Name', 'trim|required');
        $this->form_validation->set_rules('vendor_id', 'Vendor Name', 'trim|required');
		$this->form_validation->set_rules('product_short_name', 'Product Short Name', 'trim|required');
		$this->form_validation->set_rules('product_model', 'Product Model', 'trim|required');
		$this->form_validation->set_rules('reorder_level', 'Reorder Level', 'trim|required');
		$this->form_validation->set_rules('description', 'Product Description', 'trim|required');
		$this->form_validation->set_rules('is_serialised', 'Select Is Product Serialised?', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            // true case
            
            $data = array(
        		'product_name' 			=> $this->input->post('product_name'),
        		'product_short_name' 	=> $this->input->post('product_short_name'),
        		'product_model' 		=> $this->input->post('product_model'),
        		'product_code' 			=> $this->input->post('product_code'),
        		'description' 			=> $this->input->post('description'),
				'group_code' 			=> $this->input->post('group_code'),
        		'brand_id' 				=> $this->input->post('brand_id'),
        		'category_id' 			=> $this->input->post('category_id'),
        		'product_color' 		=> $this->input->post('product_color'),
        		'reorder_level' 		=> $this->input->post('reorder_level'),
        		'vendor_id' 			=> $this->input->post('vendor_id'),
        		'is_serialised' 		=> $this->input->post('is_serialised'),
				'updated_at'			=> date("Y-m-d H:i:s A"),
				'updated_by' 			=> $this->session->userdata('user_id'),
        	);
			$update = $this->model_products->update($data, $product_id);
			//$update = 1;
			
			if($update){
				// If files are selected to upload 
				if(!empty($_FILES['files']['name']) && count(array_filter($_FILES['files']['name'])) > 0){  
					
					/* getting product images */
					$this->db->select('image_name');
					$this->db->from('product_images');
					$this->db->where('product_id', $product_id);
					$query_result=$this->db->get();
					$products_images=$query_result->result();
					foreach($products_images as $images){
						unlink("assets/images/product_image/".$images->image_name);
					}
					
					$this->db->where('product_id',$product_id);
					$delete=$this->db->delete('product_images');
					if($delete){
						$filesCount = count($_FILES['files']['name']); 
						$uploadData=array();
						for($i = 0; $i < $filesCount; $i++){ 
							$_FILES['file']['name']     = $_FILES['files']['name'][$i]; 
							$_FILES['file']['type']     = $_FILES['files']['type'][$i]; 
							$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
							$_FILES['file']['error']     = $_FILES['files']['error'][$i]; 
							$_FILES['file']['size']     = $_FILES['files']['size'][$i]; 
							 
							// File upload configuration 
							$uploadPath = 'assets/images/product_image/';
							$config['upload_path'] = $uploadPath; 
							//$config['file_name'] =  substr(uniqid(time(), true), 0, 10);
							$config['file_name'] =  $product_id.'_'.$i;
							$config['allowed_types'] = 'jpg|jpeg|png|gif'; 
							
							//$config['max_size']    = '100'; 
							//$config['max_width'] = '1024'; 
							//$config['max_height'] = '768'; 
							 
							// Load and initialize upload library 
							$this->load->library('upload', $config); 
							$this->upload->initialize($config); 
							
							// Upload file to server 
							if($this->upload->do_upload('file')){ 
								// Uploaded file data 
								$fileData = $this->upload->data(); 
								$uploadData[] = array(
									'product_id' => $product_id,
									'image_name' => $fileData['file_name'],
									'uploaded_on' => date("Y-m-d H:i:s")
								);
							}else{  
								$errorUploadType .= $_FILES['file']['name'].' | ';  
							} 
							
						}  
						
						
						$errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
						if(!empty($uploadData)){ 
							// Insert files data into the database 
							//$insert = $this->file->insert($uploadData); 
							//$insert=$this->db->insert_batch('product_images',$uploadData);
							$insert=$this->db->insert_batch('product_images',$uploadData);
							// Upload status message 
							$statusMsg = $insert?'Files uploaded successfully!'.$errorUploadType:'Some problem occurred, please try again.'; 
						}else{ 
							$statusMsg = "Sorry, there was an error uploading your file.".$errorUploadType; 
						} 
					}
					
					
				}
			}
            
           
            
            if($update == true) {
                $this->session->set_flashdata('success', '<b>Successfully updated '.'( Product ID: '.$product_id.')</b>');
                redirect('products/', 'refresh');
            }
            else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('products/update/'.$product_id, 'refresh');
            }
        }else {
		//false case
			/* $this->db->select('*');
			$this->db->from('product_images');
			$this->db->where('product_id', $product_id);
			$query_result=$this->db->get();
			$cdata['products_images']=$query_result->result(); */
			
			$this->data['brand_id'] = $this->model_brands->getActiveBrands();        	
			$this->data['category_id'] = $this->model_category->getActiveCategroy();        	
			$this->data['group_code'] = $this->model_businessgroup->getActiveBusinessGroup();        	
			$this->data['vendor_id'] = $this->model_suppliers->getSupplierData(); 
            $this->data['product_data'] = $this->model_products->getProductData($product_id);
            $this->data['products_images'] = $this->model_products->getProductImages($product_id);
            
            $this->render_template('products/edit', $this->data); 
        }   
	}

	/* Delete Prodcut Image */
	public function delete_product_image(){
		$id = $this->input->post('id');
		$response = array();
		if($id) {
			$delete = $this->model_products->delete_product_image($id);
			if($delete == true) {
			   $response['success'] = true;
				$response['messages'] = "Successfully removed";
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the product information";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Refersh the page again!!";
		}

		echo json_encode($response);
	}
		




    /*
    * It removes the data from the database
    * and it returns the response into the json format
    */
	public function remove()
	{
        if(!in_array('deleteProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $product_id = $this->input->post('product_id');

        $response = array();
        if($product_id) {
            $delete = $this->model_products->remove($product_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the product information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response);
	}

}