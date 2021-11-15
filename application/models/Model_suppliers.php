<?php 

class Model_suppliers extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*get the active brands information*/
	public function getActiveBrands()
	{
		$sql = "SELECT * FROM suppliers WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	/* get the vendors/suppliers data */
	public function getSupplierData($id = null)
	{
		if($id) {
			$sql = "SELECT
						vendors.id,
						vendors.vendor_name,
						vendors.vendor_email,
						vendors.phone,
						vendors.address,
						vendors.status
					FROM
						vendors WHERE vendors.id=? ORDER BY vendors.id DESC";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT
					vendors.id,
					vendors.vendor_name,
					vendors.vendor_email,
					vendors.phone,
					vendors.address,
					vendors.status
				FROM
					vendors";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('vendors', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('vendors', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$return_array=array();
			$sql = "SELECT COUNT(*) as total FROM products WHERE vendor_id = ?";
			$query = $this->db->query($sql, array($id));
			$data=$query->result_array();
			
			if($data[0]['total'] > 0){
				return false;
			}else{
				$this->db->where('id', $id);
				$delete = $this->db->delete('vendors');
				return true;
				
			}
			
			
		}
	}

}