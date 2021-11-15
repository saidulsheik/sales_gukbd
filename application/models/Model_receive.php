<?php 

class Model_receive extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*get the active brands information*/
	public function getActiveBrands()
	{
		$sql = "SELECT * FROM brands WHERE status = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	/* get the brand data */
	public function getProductReceiveData($id = null)
	{
		if($id) {
			$sql = "SELECT
						inventory_buy_product.id,
						inventory_buy_product.branch_code,
						tbl_branch.branch_name,
						inventory_buy_product.voucher_no,
						inventory_buy_product.purchase_date,
						inventory_buy_product.approval_date,
						inventory_buy_product.total_voucher_amount,
						inventory_buy_product.product_status,
						vendors.vendor_name
					FROM
						`inventory_buy_product`
					LEFT JOIN tbl_branch ON tbl_branch.branch_code = inventory_buy_product.branch_code  
					LEFT JOIN vendors ON vendors.id = inventory_buy_product.vendor_id   WHERE inventory_buy_product.id=?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT
					inventory_buy_product.id,
					inventory_buy_product.branch_code,
					tbl_branch.branch_name,
					inventory_buy_product.voucher_no,
					inventory_buy_product.purchase_date,
					inventory_buy_product.approval_date,
					inventory_buy_product.total_voucher_amount,
					inventory_buy_product.product_status,
					vendors.vendor_name
				FROM
					inventory_buy_product
				LEFT JOIN tbl_branch ON tbl_branch.branch_code = inventory_buy_product.branch_code  
				LEFT JOIN vendors ON vendors.id = inventory_buy_product.vendor_id ORDER BY inventory_buy_product.purchase_date DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create(){
		$this->db->trans_begin();
		
		$is_serialised=$this->input->post('is_serialised');
					/* if($is_serialised){

					} */
		$user_id = $this->session->userdata('id');
		$purchase_id_prefix="PO-";
		$q4=$this->db->query("select coalesce(max(id),0)+1 as maxid from purchases");
		$maxid=$q4->row()->maxid;
		$purchase_code=str_pad($maxid, 6, '0', STR_PAD_LEFT);
		$purchase_id = $purchase_id_prefix.$purchase_code;
		
			$purchData = array(
				'purchase_id' => $purchase_id,
				'store_id' => 3,
				'chalan_no' => $this->input->post('chalan_no'),
				'vendor_id' => $this->input->post('vendor_id'),
				//'total_voucher_amount' => $this->input->post('total_voucher_amount'),
				'challan_date'=>$this->input->post('challan_date'),
				'receive_date' =>date('Y-m-d'),
				'status'=>0,
				'created_by'=>$user_id
			);
			$insert = $this->db->insert('purchases', $purchData);
			$purchase_id = $this->db->insert_id();
		if($is_serialised==1){
			$purchDetatilsData=array();

			
			if(!empty($this->input->post('serial'))){
				$serials=explode(',', $this->input->post('serial'));
			}
			$quantity=$this->input->post('quantity');
			$product_id=$this->input->post('product_id');

			for($i=0; $quantity>$i; $i++){
				$row_arr=array(
					'purchase_id'=>$purchase_id,
					'product_id'=>$this->input->post('product_id'),
					'quantity'=>1,
					'is_serialised'=>1,
					'purchase_price'=>$this->input->post('purchase_price')
				);
				array_push($purchDetatilsData,$row_arr);
			}
			$insert=$this->db->insert_batch('purchase_details', $purchDetatilsData);
				
			$first_id = $this->db->insert_id();
			$productSerialdata=array();
			for($i=0; $i<$quantity; $i++){
				$productSerialdata[$i]=array(
					'store_id'=>1,
					'product_id'=>$product_id,
					'product_serial'=>$serials[$i],
					'purch_details_id'=>$first_id+$i,
				);
			}
			$insert=$this->db->insert_batch('products_serial', $productSerialdata);
		}else{
			$purchDetatilsData=array();
			$purchDetatilsData=array(
				'purchase_id'=>$purchase_id,
				'product_id'=>$this->input->post('product_id'),
				'quantity'=>$this->input->post('quantity'),
				'purchase_price'=>$this->input->post('purchase_price')
			);
			$insert=$insert = $this->db->insert('purchase_details', $purchDetatilsData);
		}
		
		if ($this->db->trans_status() === FALSE)
		{
				$this->db->trans_rollback();
		}
		else
		{
				$this->db->trans_commit();
		}
		
		return ($insert) ? $insert : false;
	}


	public function createPurchaseDetails(){
		//$this->db->trans_begin();
		
		$is_serialised=$this->input->post('is_serialised');
		
		
			if(!empty($this->input->post('serial'))){
				$serials=explode(',', $this->input->post('serial'));
			}
			$quantity=$this->input->post('quantity');
			$product_id=$this->input->post('product_id');
				
			
			
			/* echo '<pre>';
			print_r($serials);
			print_r($data);
			print_r($_POST);
			echo '</pre>';
			exit; */
		
		if($is_serialised==1){
			$purchDetatilsData=array();
			$quantity=$this->input->post('quantity');
			for($i=0; $quantity>$i; $i++){
				$row_arr=array(
					'purchase_id'=>$this->input->post('id'),
					'product_id'=>$this->input->post('product_id'),
					'quantity'=>1,
					'is_serialised'=>1,
					'purchase_price'=>$this->input->post('purchase_price')
				);
				array_push($purchDetatilsData,$row_arr);
			}
			$insert=$this->db->insert_batch('purchase_details', $purchDetatilsData);
			count($purchDetatilsData);
			$first_id = $this->db->insert_id();
			$productSerialdata=array();
			for($i=0; $i<$quantity; $i++){
				$productSerialdata[$i]=array(
					'store_id'=>1,
					'product_id'=>$product_id,
					'product_serial'=>$serials[$i],
					'purch_details_id'=>$first_id+$i,
				);
			}
			$insert=$this->db->insert_batch('products_serial', $productSerialdata);
		}else{
			$purchDetatilsData=array();
			$purchDetatilsData=array(
				'purchase_id'=>$this->input->post('id'),
				'product_id'=>$this->input->post('product_id'),
				'quantity'=>$this->input->post('quantity'),
				'purchase_price'=>$this->input->post('purchase_price')
			);
			/* echo '<pre>';
			print_r($purchDetatilsData);
			echo '</pre>';
			exit; */
			$insert=$this->db->insert('purchase_details', $purchDetatilsData);
		}
		
		/*   */
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('brands', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('brands');
			return ($delete == true) ? true : false;
		}
	}

	public function temp_purchase($purchase_id=null){
		if(!empty($purchase_id)){
			$sql = "SELECT
						purchases.id,
						purchases.purchase_id,
						purchases.store_id,
						purchases.vendor_id,
						stores.store_name,
						tbl_branch.branch_name,
						purchases.chalan_no,
						purchases.total_voucher_amount,
						purchases.paid_amount,
						purchases.due_amount,
						purchases.total_discount,
						purchases.receive_date,
						purchases.challan_date,
						purchases.purchase_details,
						purchases.status,
						vendors.vendor_name
					FROM
						purchases
					LEFT JOIN stores ON stores.id = purchases.store_id  
					LEFT JOIN vendors ON vendors.id = purchases.vendor_id  WHERE purchases.id = ?";
			$query = $this->db->query($sql, array($purchase_id));
			return $query->result_array();
		}
			$sql = "SELECT
						purchases.id,
						purchases.purchase_id,
						purchases.store_id,
						purchases.vendor_id,
						stores.store_name,
						purchases.chalan_no,
						purchases.total_voucher_amount,
						purchases.paid_amount,
						purchases.due_amount,
						purchases.total_discount,
						purchases.receive_date,
						purchases.challan_date,
						purchases.purchase_details,
						purchases.status,
						vendors.vendor_name
					FROM
						purchases
					LEFT JOIN stores ON stores.id = purchases.store_id  
					LEFT JOIN vendors ON vendors.id = purchases.vendor_id  WHERE purchases.status = ?";
			$query = $this->db->query($sql, array(0));
			return $query->result_array();


	}

	public function temp_purchase_details($purchase_id=null){
		if(!empty($purchase_id)){
			$sql = "SELECT
						purchase_details.id,
						purchase_details.purchase_id,
						purchase_details.product_id,
						purchase_details.quantity,
						purchase_details.purchase_price,
						purchase_details.is_serialised,
						products.product_name,
						products.is_serialised,
						categories.category_name,
						brands.brand_name
					FROM
						purchase_details
					LEFT JOIN products ON products.id = purchase_details.product_id
					LEFT JOIN categories ON categories.id = products.category_id
					LEFT JOIN brands ON brands.id = products.brand_id WHERE purchase_details.purchase_id=? ORDER BY purchase_details.id DESC";
			$query = $this->db->query($sql, array($purchase_id));
			return $query->result_array();
		}
			$sql = "SELECT
						purchase_details.id,
						purchase_details.purchase_id,
						purchase_details.product_id,
						purchase_details.quantity,
						purchase_details.purchase_price,
						purchase_details.is_serialised,
						products.product_name,
						products.is_serialised,
						categories.category_name,
						brands.brand_name
					FROM
						purchase_details
					LEFT JOIN products ON products.id = purchase_details.product_id
					LEFT JOIN categories ON categories.id = products.category_id
					LEFT JOIN brands ON brands.id = products.brand_id WHERE purchase_details.purchase_id=(SELECT id FROM purchases WHERE status=0) ORDER BY purchase_details.id DESC";
			$query = $this->db->query($sql, array(0));
			return $query->result_array();


	}

	public function deletePurchaseDetailsByID($purchase_details_id=null, $serial_no=null){
		if(!empty($purchase_details_id)) {
			if($serial_no!=0){
					$this->db->where('purch_details_id', $purchase_details_id);
					$delete_product_serial = $this->db->delete('products_serial');
					if($delete_product_serial){
						$this->db->where('id', $purchase_details_id);
						$delete = $this->db->delete('purchase_details');
						return ($delete == true) ? true : false;
					}else{
						return false;
					}
			}else{
				$this->db->where('id', $purchase_details_id);
				$delete = $this->db->delete('purchase_details');
				return ($delete == true) ? true : false;
			}
		}
	}

	public function deletePurchaseByID($purchase_id=null){
		if(!empty($purchase_id)){
				$this->db->where('id', $purchase_id);
				$delete = $this->db->delete('purchases');
				return ($delete == true) ? true : false;
		}
	}

}