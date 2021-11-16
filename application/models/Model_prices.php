<?php 

class Model_prices extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*get Product Prices*/
	public function getProductPrices($id=null){
		if($id) {
			$sql = "SELECT
						products.product_name,
						brands.brand_name,
						categories.category_name,
						prices.product_id,
						prices.purchase_price,
						prices.sales_price,
						prices.down_payment,
						prices.loan_amount,
						prices.incentive_amt,
						prices.price_from,
						prices.price_id,
						prices.office_sale_price
					FROM
						prices
					LEFT JOIN products ON products.id = prices.product_id
					LEFT JOIN brands ON brands.id = products.brand_id
					LEFT JOIN categories ON categories.id = products.category_id
					WHERE prices.price_id=?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
		$sql = "SELECT
					products.product_name,
					brands.brand_name,
					categories.category_name,
					prices.product_id,
					prices.purchase_price,
					prices.sales_price,
					prices.down_payment,
					prices.loan_amount,
					prices.incentive_amt,
					prices.price_from,
					prices.price_id,
					prices.office_sale_price
				FROM
					prices
				LEFT JOIN products ON products.id = prices.product_id
				LEFT JOIN brands ON brands.id = products.brand_id
				LEFT JOIN categories ON categories.id = products.category_id
				WHERE prices.price_status = ? AND products.status=1 AND brands.status=1";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	/* get the brand data */
	public function getBrandData($id = null)
	{
		if($id) {
			$sql = "SELECT
					brands.id,
					brands.brand_name,
					brands.group_code,
					brands.status,
					tbl_group_head.group_name
				FROM
					brands
				LEFT JOIN tbl_group_head ON tbl_group_head.id = brands.group_code WHERE brands.id=?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT
					brands.id,
					brands.brand_name,
					brands.group_code,
					brands.status,
					tbl_group_head.group_name
				FROM
					brands
				LEFT JOIN tbl_group_head ON tbl_group_head.id = brands.group_code ORDER BY brands.id ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('prices', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('price_id', $id);
			$update = $this->db->update('prices', $data);
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
	
	
	/*get Product Prices details*/
	public function view_price_details($id=null){
		$sql = "SELECT
					products.product_name,
					brands.brand_name,
					categories.category_name,
					prices.product_id,
					prices.purchase_price,
					prices.sales_price,
					prices.down_payment,
					prices.loan_amount,
					prices.incentive_amt,
					prices.price_from,
					prices.price_to,
					prices.price_status
				FROM
					prices
				LEFT JOIN products ON products.id = prices.product_id
				LEFT JOIN brands ON brands.id = products.brand_id
				LEFT JOIN categories ON categories.id = products.category_id
				WHERE prices.product_id=$id ORDER BY prices.price_id DESC";
		$query = $this->db->query($sql, array($id));
		return $query->result();
	}
	

}