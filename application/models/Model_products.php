<?php 

class Model_products extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the product data */
	public function getProductData($id = null){
		if($id) {
			$sql = "SELECT
						products.id,
						products.product_name,
						products.product_model,
						products.description,
						products.is_serialised,
						brands.id as brand_id,
						brands.brand_name,
						categories.id as category_id,
						categories.category_name,
						products.product_image,
						products.status
					FROM
						products
					LEFT JOIN brands ON brands.id = products.brand_id
					LEFT JOIN categories ON categories.id = products.category_id where products.id = ? ORDER BY products.id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT
						products.id,
						products.product_name,
						products.product_model,
						products.description,
						products.is_serialised,
						brands.id as brand_id,
						brands.brand_name,
						categories.id as category_id,
						categories.category_name,
						products.product_image,
						products.status
				FROM
					products
				LEFT JOIN brands ON brands.id = products.brand_id
				LEFT JOIN categories ON categories.id = products.category_id
				ORDER BY products.id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/* get product images */
	public function getProductImages($product_id = null){
		if($product_id) {
			return $this->db->query("SELECT id, product_id, image_name FROM product_images WHERE product_id=?", array($product_id))->result();
		}
	}
	/* DELETE Product Image By OnClick */
	public function delete_product_image($id){
		if($id) {
			$products_image = $this->db->query("SELECT image_name FROM product_images WHERE id=?", array($id))->row();
			$unlinkImage=unlink("assets/images/product_image/".$products_image->image_name);
			if($unlinkImage){
				$delete = $this->db->query("DELETE FROM product_images where id = ?", array($id));
				return ($delete == true) ? true : false;
			}else{
				return false;
			}
			
		}else{
			return false;
		}
	}

	public function getActiveProductData()
	{
		$sql = "SELECT * FROM products WHERE status = ? ORDER BY id DESC";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('products', $data);
			$insert_id = $this->db->insert_id();
			return ($insert_id) ? $insert_id : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('products', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('products');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalProducts()
	{
		$sql = "SELECT IFNULL(COUNT(*),0) as total_products FROM products WHERE status=?";
		$query = $this->db->query($sql, array(1))->result();
		return $query[0]->total_products;
	}


	

}