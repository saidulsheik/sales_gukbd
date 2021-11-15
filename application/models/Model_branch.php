<?php 

class Model_branch extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*get the active Branch information*/
	public function getBranches($id=null){
		if($id){
			$sql = "SELECT
						tbl_branch.id,
						tbl_branch.branch_code,
						tbl_branch.branch_name,
						tbl_branch.branch_name_bn,
						tbl_branch.branch_contact_no,
						tbl_branch.branch_address,
						tbl_branch.status,
						tbl_area.area_code,
						tbl_area.area_name,
						tbl_zone.zone_code,
						tbl_zone.zone_name
					FROM
						tbl_branch
					LEFT JOIN tbl_area ON tbl_area.area_code=tbl_branch.area_code
					LEFT JOIN tbl_zone ON tbl_zone.zone_code=tbl_area.zone_code
					WHERE tbl_branch.id=?
					ORDER BY
						id ASC";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}
		
		$sql = "SELECT
					tbl_branch.id,
					tbl_branch.branch_code,
					tbl_branch.branch_name,
					tbl_branch.branch_name_bn,
					tbl_branch.branch_contact_no,
					tbl_branch.branch_address,
					tbl_branch.status,
					tbl_area.area_code,
					tbl_area.area_name,
					tbl_zone.zone_code,
					tbl_zone.zone_name
				FROM
					tbl_branch
				LEFT JOIN tbl_area ON tbl_area.area_code=tbl_branch.area_code
				LEFT JOIN tbl_zone ON tbl_zone.zone_code=tbl_area.zone_code
				ORDER BY
					id ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/* get the brand data */
	public function getBrandData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM brands WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM brands";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('tbl_branch', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('tbl_branch', $data);
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
	
	public function getAllArea(){
		$sql = "SELECT * FROM tbl_area WHERE status = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}
	
	/* count all branch */
	public function countTotalbranches(){
		$sql = "SELECT IFNULL(COUNT(*),0) as total_branches FROM tbl_branch WHERE status=?";
		$query = $this->db->query($sql, array(1))->result();
		return $query[0]->total_branches;
	}
	/* count all zone */
	public function countTotalZone(){
		$sql = "SELECT IFNULL(COUNT(*),0) as total_zone FROM tbl_zone WHERE zone_code!=?";
		$query = $this->db->query($sql, array(9999))->result();
		return $query[0]->total_zone;
	}
	/* count all Area */
	public function countTotalArea(){
		$sql = "SELECT IFNULL(COUNT(*),0) as total_area FROM tbl_area WHERE area_code!=?";
		$query = $this->db->query($sql, array(9999))->result();
		return $query[0]->total_area;
	}

}