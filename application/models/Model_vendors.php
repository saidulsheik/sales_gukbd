<?php 

class Model_brands extends CI_Model
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
			$insert = $this->db->insert('brands', $data);
			return ($insert == true) ? true : false;
		}
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

}