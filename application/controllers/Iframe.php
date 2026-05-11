<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');

class Iframe extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->database(); 

		if (!$this->session->userdata('logged_in'))
		{ 
			redirect('login');
		}

		$this->user_id = $this->session->userdata('userid');
		$this->company_id = $this->session->userdata('company_id');

		$this->load->helper('form');
		$this->load->model('login_model');
	}

	public function index()
	{
		$this->load->view('admin/iframe');
	}
	public function gmail()
	{
		$data['recored'] = "gmail";
		$this->load->view('admin/iframe', $data);
	}
	public function datacredito()
	{
		$data['recored'] = "datacredito";
		$this->load->view('admin/iframe', $data);
	}
	public function transunion()
	{
		$data['recored'] = "transunion";
		$this->load->view('admin/iframe', $data);
	}

}
