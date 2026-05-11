<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('form');
			$this->load->model('login_model');
	}

	public function index()
	{
		$this->load->view('admin/login');
	}
	
	public function support()
	{
		$this->load->view('admin/support');
	}

	public function check()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('user_name', 'Nombre de usuario', 'required');
		$this->form_validation->set_rules('password', 'Contraseña', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('admin/login');
		}
		else
		{
			$data = $this->login_model->check();
			if(empty($data))
			{
				$this->session->set_flashdata('msg','¡Favor corregir su nombre de usuario o contraseña!');
				redirect('login');
			}
			else
			{
				$newdata = array(
					'user'  => $data['user_fullname'],
					'username'  => $data['user_name'].'@yaobilling.com',
					'company_id'  => $data['company_id'],
					'companyid'  => $data['company_id'],
					'storename'  => $data['store_name'],
					'userid'     => $data['user_id'],
					'logged_in' => TRUE
				);

				$this->session->set_userdata($newdata);
				redirect('welcome');
			}
			
		}
	}

	public function logout()
	{
		$array_items = array('user', 'username', 'company_id', 'companyid', 'storename', 'userid','logged_in');
		$this->session->unset_userdata($array_items);
		$this->session->set_flashdata('logout_msg','Sesión cerrada exitosamente, <br /> Inicie sesión nuevamente para continuar.');
		
		$myfile = fopen("company.txt", "w") or die("Unable to open file!");
		fwrite($myfile, "");
		fclose($myfile);

		redirect('login');
	}
}
