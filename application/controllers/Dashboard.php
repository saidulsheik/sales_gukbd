<?php 

class Dashboard extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Dashboard';
		$this->load->model('model_products');
		$this->load->model('model_orders');
		$this->load->model('model_users');
		$this->load->model('model_branch');
	}

	/* 
	* It only redirects to the manage category page
	* It passes the total product, total paid orders, total users, and total stores information
	into the frontend.
	*/
	public function index()
	{
		$this->data['total_products'] = $this->model_products->countTotalProducts();
		/* $this->data['total_paid_orders'] = $this->model_orders->countTotalPaidOrders();
		$this->data['total_users'] = $this->model_users->countTotalUsers(); */
		$this->data['total_branches'] = $this->model_branch->countTotalbranches();
		$this->data['total_area'] = $this->model_branch->countTotalArea();
		$this->data['total_zone'] = $this->model_branch->countTotalZone();

		$role_id = $this->session->userdata('role_id');
		$is_admin = ($role_id == 1 || $role_id == 4 || $role_id == 12 ) ? true :false;

		$this->data['is_admin'] = $is_admin; 
		$this->render_template('dashboard', $this->data);
	}
}