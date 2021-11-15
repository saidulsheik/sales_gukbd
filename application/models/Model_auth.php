<?php 

class Model_auth extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* 
		This function checks if the email exists in the database
	*/
	public function check_email($username) 
	{
		if($username) {
			$sql = 'SELECT * FROM tbl_users WHERE username = ?';
			$query = $this->db->query($sql, array($username));
			$result = $query->num_rows();
			return ($result == 1) ? true : false;
		}

		return false;
	}

	/* 
		This function checks if the email and password matches with the database
	*/
	public function login($username, $password) {
		if($username && $password) {
			$sql = "SELECT
						tbl_users.*,
						tbl_zone.zone_code,
						tbl_zone.zone_name,
						tbl_area.area_name,
						tbl_branch.branch_name,
						allow_branch.branch_name AS allow_transfer,
						user_group.user_id,
						user_group.group_id,
						groups.group_name,
						groups.permission
					FROM
						tbl_users
					LEFT JOIN user_group ON user_group.user_id = tbl_users.id
					LEFT JOIN groups ON groups.id = user_group.group_id
					LEFT JOIN tbl_branch ON tbl_branch.branch_code = tbl_users.branch_code
					LEFT JOIN tbl_branch AS allow_branch
					ON
						allow_branch.branch_code = tbl_users.allow_transfer_branches
					LEFT JOIN tbl_area ON tbl_area.area_code = tbl_branch.area_code
					LEFT JOIN tbl_zone ON tbl_zone.zone_code = tbl_area.zone_code
					WHERE tbl_users.username=?";
			$query = $this->db->query($sql, array($username));
			if($query->num_rows() == 1) {
				$result = $query->row_array();
				$hash_password = md5($password);
				if($hash_password === $result['password']) {
					return $result;	
				}
				else {
					return false;
				}
			}
			else{
				return false;
			}
		}
	}
	
	/* Get Rule Wise Menu */
	
	public function getRoleWiseMenu($role_id){
		$menuArray=array();
		$mainMenu = $this->db->query("SELECT
											auth_assignment.menu_category,
											auth_assignment.menu_id,
											menu.menu_name,
											menu.menu_path,
											menu.has_sub,
											menu.create_path,
											menu.edit_path,
											menu.delete_path,
											menu.menu_icon,
											auth_assignment.action_view,
											auth_assignment.action_add,
											auth_assignment.action_edit,
											auth_assignment.action_delete
										FROM
											auth_assignment
										LEFT JOIN menu ON menu.menu_id = auth_assignment.menu_id
										WHERE
											auth_assignment.role_id = $role_id AND auth_assignment.menu_category = 1 AND(
												auth_assignment.action_view = 1 OR auth_assignment.action_add = 1 OR auth_assignment.action_edit = 1 OR auth_assignment.action_delete = 1
											) AND menu.menu_name!=''")->result();
		$subMenu = $this->db->query("SELECT
											auth_assignment.menu_category,
											menu_child.menu_id,
											menu_child.sub_menu_name as menu_name,
											menu_child.sub_menu_path as menu_path,
											menu_child.create_path as create_path,
											menu_child.edit_path as edit_path,
											menu_child.delete_path as delete_path,
											'Not Applicable' as menu_icon,
											auth_assignment.action_view,
											auth_assignment.action_add,
											auth_assignment.action_edit,
											auth_assignment.action_delete
										FROM
											auth_assignment
										LEFT JOIN menu_child ON menu_child.menu_child_id = auth_assignment.menu_id
										WHERE
											auth_assignment.role_id = $role_id AND auth_assignment.menu_category = 2 AND(
												auth_assignment.action_view = 1 OR auth_assignment.action_add = 1 OR auth_assignment.action_edit = 1 OR auth_assignment.action_delete = 1
											)")->result();
		
			$menuPermissionArray=array();
			foreach($mainMenu as $mainMenuValue){
				$menuPermissionArray[]=$mainMenuValue->menu_path;
			}
			foreach($subMenu as $subMenuValue){
				$menuPermissionArray[]=$subMenuValue->menu_path;
			}
		
		$menuArray=array(
			'mainMenu'=>$mainMenu,
			'subMenu'=>$subMenu,
			'subMenu'=>$subMenu,
			'menuPermissionArray'=>$menuPermissionArray
			
		);
		return $menuArray;
		
	}
	
	
	
	
	
	
	
}