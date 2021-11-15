<?php 

class Model_demand extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*get the active brands information*/
	public function getActiveDemandConfiguration()
	{
		$sql = "SELECT * FROM demand_config WHERE status = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	/* get the brand data */
	public function getDemandConfigurationsData($id = null){
		if($id) {
			$sql = "SELECT * FROM demand_config WHERE id=?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM demand_config ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data){
		if($data) {
			$updateData=array(
				'status' =>0
			);
			$this->db->where('status', 1);
			$update = $this->db->update('demand_config', $updateData);
			$insert = $this->db->insert('demand_config', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id){
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('demand_config', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id){
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('demand_config');
			return ($delete == true) ? true : false;
		}
	}
	
	
	
	
	/* check demand date if exits */
	
	/* function demanddate_exists($columnName, $date){
		$this->db->where($columnName,$date);
		$query = $this->db->get('demand_config');
		if ($query->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	} */

}