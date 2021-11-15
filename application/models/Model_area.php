<?php 

class Model_area extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*get the active Branch information*/
	public function getArea($id=null){
		if($id){
			$sql = "SELECT
						tbl_area.id,
						tbl_area.area_code,
						tbl_area.area_name,
						tbl_area.area_name_bn,
						tbl_area.area_contact_no,
						tbl_area.zone_code,
						tbl_zone.zone_name
					FROM
						tbl_area
					LEFT JOIN tbl_zone ON tbl_zone.zone_code = tbl_area.area_code WHERE tbl_area.id=?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}
		
		$sql = "SELECT
					tbl_area.id,
					tbl_area.area_code,
					tbl_area.area_name,
					tbl_area.area_name_bn,
					tbl_area.area_contact_no,
					tbl_area.zone_code,
					tbl_zone.zone_name
				FROM
					tbl_area
				LEFT JOIN tbl_zone ON tbl_zone.zone_code = tbl_area.area_code";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	
	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('tbl_area', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('tbl_area', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('tbl_area');
			return ($delete == true) ? true : false;
		}
	}
	
	
	/* count all Area */
	public function countTotalArea(){
		$sql = "SELECT IFNULL(COUNT(*),0) as total_area FROM tbl_area WHERE area_code!=?";
		$query = $this->db->query($sql, array(9999))->result();
		return $query[0]->total_area;
	}

}