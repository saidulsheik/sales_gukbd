<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_auth');
		$this->load->model('Model_softdate');
	}

	/* 
		Check if the login form is submitted, and validates the user credential
		If not submitted it redirects to the login page
	*/
	public function login()
	{

		
		/* echo '<pre>';
		print_r($_POST);
		echo '</pre>';
		exit; */
		$this->logged_in();
		$this->form_validation->set_rules('username', 'UserName', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            // true case
           	$username_exits = $this->model_auth->check_email($this->input->post('username'));

           	if($username_exits == TRUE) {
           		$login = $this->model_auth->login($this->input->post('username'), $this->input->post('password'));
				/* echo '<pre>';
				print_r($login);
				echo '</pre>';
				exit;  */
           		if($login) {
					//$menuArray = $this->model_auth->getRoleWiseMenu($login['role_id']);
					/* echo '<pre>';
					print_r($menuArray);
					echo '</pre>';
					exit;  */
					$get_soft_date_inv = $this->Model_softdate->software_date($login['branch_code'],$login['dept_id']);
					$soft_date_inv	= $get_soft_date_inv;
					
           			$logged_in_sess = array(
							'id' 						=> $login['id'],
							'role_id'  					=> $login['role_id'],
							'username'  				=> $login['username'],
							'zone_code'  				=> $login['zone_code'],
							'area_code'  				=> $login['area_code'],
							'branch_code'  				=> $login['branch_code'],
							'branch_name'  				=> $login['branch_name'],
							'dept_id'  					=> $login['dept_id'],
							'day_back_permission'  		=> $login['day_back_permission'],
							'soft_date_inv'  			=> $soft_date_inv,
							'can_transfer'  			=> $login['can_transfer'],
							'allow_transfer_branches'  	=> $login['allow_transfer_branches'],
							'logged_in' 				=> TRUE,
							/*'mainMenu' 					=> $menuArray['mainMenu'],
							'subMenu' 					=> $menuArray['subMenu'],
							'menuPermissionArray' 		=> $menuArray['menuPermissionArray']*/
					);
					/* echo '<pre>';
					print_r($logged_in_sess);
					echo '</pre>';
					exit; */
					$this->session->set_userdata($logged_in_sess);
           			redirect('dashboard', 'refresh');
           		}
           		else {
           			$this->data['errors'] = 'Incorrect username/password combination';
           			$this->load->view('login', $this->data);
           		}
           	}
           	else {
           		$this->data['errors'] = 'username does not exists';

           		$this->load->view('login', $this->data);
           	}	
        }
        else {
            // false case
            $this->load->view('login');
        }	
	}

	/*
		clears the session and redirects to login page
	*/
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth/login', 'refresh');
	}

}
