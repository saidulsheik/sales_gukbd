<?php
	


class Model_softdate extends CI_Model{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function software_date($branch_code,$dept_id)
	{

		$current_date = date('Y-m-d');
		$max_day_end = $this->select_max_dayend($branch_code,$dept_id);
		if(empty($max_day_end->day_end_date))
		{
			$last_day_end = date('Y-m-d',strtotime($current_date . "-1 days"));			
		}			
		else
		{
			$last_day_end = $max_day_end->day_end_date;
		}
			
		$next_holiday = $this->select_next_holiday($last_day_end,$branch_code);	
		
		$software_date = date('Y-m-d',strtotime($last_day_end . "+1 days"));
		
		if(empty($next_holiday))
		{
			$chk_friday = date('D', strtotime($software_date));
						
			if($chk_friday == 'Fri')
			{
				$software_date = date('Y-m-d',strtotime($software_date . "+2 days"));
			}
		}
		else
		{
			foreach($next_holiday as $v_next_holiday)
			{
				$chk_friday = date('D', strtotime($software_date));
				
				if($software_date == $v_next_holiday->holiday_date)
				{
					$software_date = date('Y-m-d',strtotime($software_date . "+1 days"));
					if($chk_friday == 'Fri')
					{
						$software_date = date('Y-m-d',strtotime($software_date . "+2 days"));
					}
				}			
				
				$chk_friday = date('D', strtotime($software_date));
							
				if($chk_friday == 'Fri')
				{
					$software_date = date('Y-m-d',strtotime($software_date . "+2 days"));
					
					if($software_date == $v_next_holiday->holiday_date)
					{
						$software_date = date('Y-m-d',strtotime($software_date . "+1 days"));
					}
				}
			}	
		}
		return $software_date;	
	}
	
	
	
	public function select_next_holiday($max_date,$branch_code)
	{			
		$current_year = date('Y');
		$this->db->select('holiday_date');
        $this->db->from('tbl_holidays');
		$this->db->where('holiday_date >',$max_date);
		$this->db->where('status',1);
		$this->db->where('effected_br_code',0);
		$this->db->or_where('effected_br_code',$branch_code);
        $query_result=$this->db->get();
        $result=$query_result->result();
        return $result;
	}
	
	
	public function select_max_dayend($branch_code,$dept_id)
	{
		$this->db->select_max('day_end_date');
		$this->db->from('tbl_day_end');
		//$this->db->where('day_end_br',$this->session->userdata('working_station'));
		//$this->db->where('sub_id',$this->session->userdata('sub_id'));
		$this->db->where('day_end_br',$branch_code);
		$this->db->where('day_end_status',1);
		$this->db->where('group_code',$dept_id);
		$query = $this->db->get(); 
		$result=$query->row();
        return $result;
		
	}		
	
	
	
}