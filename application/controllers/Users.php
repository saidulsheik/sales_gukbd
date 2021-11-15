<?php 

class Users extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		$this->data['page_title'] = 'Users';
		$this->load->model('model_users');
		$this->load->model('model_groups');
		$this->load->model('model_branch');
		$this->load->model('model_area');
		$this->load->model('model_zone');
	}

	
	public function index()
	{
		if(!in_array('viewUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$group_data = $this->model_groups->getGroupData();
        $this->data['group_data'] = $group_data;
		$this->render_template('users/index', $this->data);
	}


	/*
	* It retrieves all the store data from the database 
	* This function is called from the datatable ajax function
	* The data is return based on the json format.
	*/
	public function fetchUserData()
	{
		$result = array('data' => array());
		$data =  $this->db->query("SELECT
									tbl_users.id,
									tbl_zone.zone_code,
									tbl_zone.zone_name,
									tbl_users.area_code,
									tbl_area.area_name,
									tbl_users.branch_code,
									tbl_branch.branch_name,
									tbl_users.dept_id,
									tbl_users.username,
									tbl_users.role_id,
									tbl_users.status,
									tbl_users.day_back_permission,
									tbl_users.can_transfer,
									tbl_users.allow_transfer_branches,
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
								LEFT JOIN tbl_branch AS allow_branch ON allow_branch.branch_code = tbl_users.allow_transfer_branches
								LEFT JOIN tbl_area ON tbl_area.area_code = tbl_branch.area_code
								LEFT JOIN tbl_zone ON tbl_zone.zone_code = tbl_area.zone_code")->result_array();
		foreach ($data as $key => $value) {
			// button
			$buttons = '';

			if(in_array('updateUser', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-default" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteUser', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			$can_transfer = ($value['can_transfer'] == 1) ? '<span class="label label-success">Yes</span>' : '<span class="label label-warning">No</span>';

			$result['data'][$key] = array(
				$value['zone_name'].'('.$value['zone_code'].')',
				$value['area_name'].'('.$value['area_code'].')',
				$value['branch_name'].'('.$value['branch_code'].')',
				$value['username'],
				$can_transfer,
				$value['allow_transfer'],
				$value['group_name'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
	
	/* Create User */
	public function create()
	{
		if(!in_array('createUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('groups', 'Group', 'required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|is_unique[users.username]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');
		$this->form_validation->set_rules('fname', 'First name', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            // true case
            $password = $this->md5($this->input->post('password'));
        	$data = array(
        		'username' => $this->input->post('username'),
        		'password' => $password,
        		'email' => $this->input->post('email'),
        		'firstname' => $this->input->post('fname'),
        		'lastname' => $this->input->post('lname'),
        		'phone' => $this->input->post('phone'),
        		'gender' => $this->input->post('gender'),
        	);

        	$create = $this->model_users->create($data, $this->input->post('groups'));
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('users/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('users/create', 'refresh');
        	}
        }
        else {
            // false case
        	$this->data['group_data'] = $this->model_groups->getGroupData();
        	$this->data['all_branch'] =  $this->model_branch->getBranches();
        	$this->data['all_area'] =  $this->model_area->getArea();
        	$this->data['all_zone'] =  $this->model_zone->getZone();
            $this->render_template('users/create', $this->data);
        }	

		
	}

	public function password_hash($pass = '')
	{
		if($pass) {
			$password = password_hash($pass, PASSWORD_DEFAULT);
			return $password;
		}
	}

	public function edit($id = null)
	{
		if(!in_array('updateUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if($id) {
			$this->form_validation->set_rules('groups', 'Group', 'required');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('fname', 'First name', 'trim|required');


			if ($this->form_validation->run() == TRUE) {
	            // true case
		        if(empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {
		        	$data = array(
		        		'username' => $this->input->post('username'),
		        		'email' => $this->input->post('email'),
		        		'firstname' => $this->input->post('fname'),
		        		'lastname' => $this->input->post('lname'),
		        		'phone' => $this->input->post('phone'),
		        		'gender' => $this->input->post('gender'),
		        	);

		        	$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
		        	if($update == true) {
		        		$this->session->set_flashdata('success', 'Successfully created');
		        		redirect('users/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('errors', 'Error occurred!!');
		        		redirect('users/edit/'.$id, 'refresh');
		        	}
		        }
		        else {
		        	$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
					$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');

					if($this->form_validation->run() == TRUE) {

						$password = $this->password_hash($this->input->post('password'));

						$data = array(
			        		'username' => $this->input->post('username'),
			        		'password' => $password,
			        		'email' => $this->input->post('email'),
			        		'firstname' => $this->input->post('fname'),
			        		'lastname' => $this->input->post('lname'),
			        		'phone' => $this->input->post('phone'),
			        		'gender' => $this->input->post('gender'),
			        	);

			        	$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
			        	if($update == true) {
			        		$this->session->set_flashdata('success', 'Successfully updated');
			        		redirect('users/', 'refresh');
			        	}
			        	else {
			        		$this->session->set_flashdata('errors', 'Error occurred!!');
			        		redirect('users/edit/'.$id, 'refresh');
			        	}
					}
			        else {
			            // false case
			        	$user_data = $this->model_users->getUserData($id);
			        	$groups = $this->model_users->getUserGroup($id);

			        	$this->data['user_data'] = $user_data;
			        	$this->data['user_group'] = $groups;

			            $group_data = $this->model_groups->getGroupData();
			        	$this->data['group_data'] = $group_data;

						$this->render_template('users/edit', $this->data);	
			        }	

		        }
	        }
	        else {
	            // false case
	        	$user_data = $this->model_users->getUserData($id);
	        	$groups = $this->model_users->getUserGroup($id);

	        	$this->data['user_data'] = $user_data;
	        	$this->data['user_group'] = $groups;

	            $group_data = $this->model_groups->getGroupData();
	        	$this->data['group_data'] = $group_data;

				$this->render_template('users/edit', $this->data);	
	        }	
		}	
	}

	public function delete($id)
	{
		if(!in_array('deleteUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if($id) {
			if($this->input->post('confirm')) {
					$delete = $this->model_users->delete($id);
					if($delete == true) {
		        		$this->session->set_flashdata('success', 'Successfully removed');
		        		redirect('users/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('error', 'Error occurred!!');
		        		redirect('users/delete/'.$id, 'refresh');
		        	}

			}	
			else {
				$this->data['id'] = $id;
				$this->render_template('users/delete', $this->data);
			}	
		}
	}

	public function profile()
	{
		if(!in_array('viewProfile', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$user_id = $this->session->userdata('id');

		$user_data = $this->model_users->getUserData($user_id);
		$this->data['user_data'] = $user_data;

		$user_group = $this->model_users->getUserGroup($user_id);
		$this->data['user_group'] = $user_group;

        $this->render_template('users/profile', $this->data);
	}

	public function setting()
	{	
		if(!in_array('updateSetting', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$id = $this->session->userdata('id');
		if($id){
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[100]');
			if(trim($this->input->post('email')) != trim($this->input->post('old_email'))){
				$this->form_validation->set_rules('email', 'USer Email', 'trim|required|is_unique[users.email]');
			} else {
				$this->form_validation->set_rules('email', 'USer Email', 'trim|required');
			}

			if ($this->form_validation->run() == TRUE) {
	            // true case
		        if(empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {
		        	$data = array(
		        		'username' => $this->input->post('username'),
		        		'email' => $this->input->post('email'),
		        		'phone' => $this->input->post('phone')
		        	);

		        	$update = $this->model_users->edit($data, $id);
		        	if($update == true) {
		        		$this->session->set_flashdata('success', 'Successfully updated');
		        		redirect('users/setting/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('errors', 'Error occurred!!');
		        		redirect('users/setting/', 'refresh');
		        	}
		        }
		        else {
		        	$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
					$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');

					if($this->form_validation->run() == TRUE) {

						$password = $this->password_hash($this->input->post('password'));

						$data = array(
			        		'username' => $this->input->post('username'),
			        		'password' => $password,
			        		'email' => $this->input->post('email'),
			        		'phone' => $this->input->post('phone')
			        	);

			        	$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
			        	if($update == true) {
			        		$this->session->set_flashdata('success', 'Successfully updated');
			        		redirect('users/setting/', 'refresh');
			        	}
			        	else {
			        		$this->session->set_flashdata('errors', 'Error occurred!!');
			        		redirect('users/setting/', 'refresh');
			        	}
					}
			        else {
			            // false case
			        	$user_data = $this->model_users->getUserData($id);
			        	$groups = $this->model_users->getUserGroup($id);
			        	$this->data['user_data'] = $user_data;
			        	$this->data['user_group'] = $groups;
			            $group_data = $this->model_groups->getGroupData();
			        	$this->data['group_data'] = $group_data;
						$this->render_template('users/setting', $this->data);	
			        }	

		        }
	        }
	        else {
	            // false case
	        	$user_data = $this->model_users->getUserData($id);
	        	$groups = $this->model_users->getUserGroup($id);

	        	$this->data['user_data'] = $user_data;
	        	$this->data['user_group'] = $groups;

	            $group_data = $this->model_groups->getGroupData();
	        	$this->data['group_data'] = $group_data;

				$this->render_template('users/setting', $this->data);	
	        }	
		}
	}


}