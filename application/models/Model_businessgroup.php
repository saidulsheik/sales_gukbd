<?php 

class Model_businessgroup extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get active Bunisess Group  infromation */
	public function getActiveBusinessGroup(){
		$sql = "SELECT * FROM tbl_group_head WHERE status = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}
	
	/* get the Business Group data */
	public function getBusinessGroup($id = null){
		if($id) {
			$sql = "SELECT * FROM tbl_group_head WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
		$sql = "SELECT * FROM tbl_group_head";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('tbl_group_head', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('tbl_group_head', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('tbl_group_head');
			return ($delete == true) ? true : false;
		}
	}

}