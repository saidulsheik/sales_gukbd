<?php 

class Model_zone extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*get the active Branch information*/
	public function getZone($id=null){
		if($id){
			$sql = "SELECT * FROM tbl_zone WHERE tbl_zone.id=? ORDER BY id ASC";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}
		
		$sql = "SELECT * FROM tbl_zone";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('tbl_zone', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('tbl_zone', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('tbl_zone');
			return ($delete == true) ? true : false;
		}
	}
	
	
	/* count all zone */
	public function countTotalZone(){
		$sql = "SELECT IFNULL(COUNT(*),0) as total_zone FROM tbl_zone WHERE zone_code!=?";
		$query = $this->db->query($sql, array(9999))->result();
		return $query[0]->total_zone;
	}
	

}