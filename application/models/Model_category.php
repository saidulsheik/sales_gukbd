<?php 

class Model_category extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get active brand infromation */
	public function getActiveCategroy()
	{
		$sql = "SELECT * FROM categories WHERE status = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	/* get the brand data */
	public function getCategoryData($id = null){
		if($id) {
			$sql = "SELECT
						categories.id,
						categories.category_name,
						categories.group_code,
						categories.status,
						tbl_group_head.group_name
					FROM
						categories
					LEFT JOIN tbl_group_head ON tbl_group_head.id = categories.group_code WHERE categories.id=?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT
					categories.id,
					categories.category_name,
					categories.group_code,
					categories.status,
					tbl_group_head.group_name
				FROM
					categories
				LEFT JOIN tbl_group_head ON tbl_group_head.id = categories.group_code";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('categories', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('categories', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('categories');
			return ($delete == true) ? true : false;
		}
	}

}