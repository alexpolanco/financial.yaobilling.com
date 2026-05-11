<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Users extends MY_Controller  { 
		
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Pdf_Library');
		$this->load->library('Excel_Library');
		if (!$this->session->userdata('logged_in'))
		{ 
			redirect('login');
		}
		else
		{
			if($this->session->userdata('userid') != 1)
			{
				$rights = $this->check_rights();
				$url = $this->uri->segment(1).'/'.$this->uri->segment(2);

				if($url != 'users/change_password'){
					if($url != 'users/c_password')
					{
						if(!in_array($url, $rights))
						{
							$this->load->view('admin/not_access');
						}
					}
				}
			}
		}
		
		$this->load->helper('form');
		$this->load->model('users_model');
		$this->load->model('cities_model');
	}
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/home
	 *	- or -
	 * 		http://example.com/index.php/home/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/home/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	

	// index method
	public function index()
	{
		$data['recored'] = $this->users_model->findAll();
		$this->load->view('admin/users/users-list',$data);
	}

	public function get_All_group()
	{
		return $data['group'] = $this->db->get('users_group')->result();
	}

	public function get_group_name($id)
	{
		$this->db->select('user_group_name');
		$this->db->where('user_group_id', $id);
		$data = $this->db->get('users_group')->row_array();
		return $data['user_group_name'];
	}

	public function get_component()
	{
		$data = $this->db->get('component')->result();
		return $data;
	}

	public function get_rights($id)
	{
	$query = $this->db->query("SELECT * FROM rights WHERE company_id = '". $this->session->userdata('company_id')."' AND user_id = ".$id);
	$data = $query->result();
	$right = array();
	foreach ($data as $value) {
		$right[] = $value->rights;
	}

	return $right;
	}
	

	public function check()
	{
	$this->load->view('admin/users/check');
	}

	// Create method
	public function create()
	{
		//print_r($_POST);
		$this->load->library('form_validation');

		$this->form_validation->set_rules('txt_user_group_id', 'Rol', 'required');
		$this->form_validation->set_rules('txt_user_name', 'Nombre de usuario', 'required');
		$this->form_validation->set_rules('txt_password', 'Contraseña', 'required');
		$this->form_validation->set_rules('txt_user_active', 'Está activo', 'required');
		$this->form_validation->set_rules('confirm_password', 'Confirmar contraseña', 'required|matches[txt_password]');
		
		$this->form_validation->set_rules('txt_user_fullname', 'Nombre del usuario', 'required');
		$this->form_validation->set_rules('txt_user_email', 'Correo electrónico', 'required');
		$this->form_validation->set_rules('txt_user_email', 'Correo electrónico válido', 'valid_email');
		$this->form_validation->set_rules('txt_user_address', 'Dirección', 'required');
		$this->form_validation->set_rules('txt_user_city', 'Ciudad', 'required');
		$this->form_validation->set_rules('txt_user_phone', 'Teléfono', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$data['cities'] = $this->cities_model->findAll();
			$this->load->view('admin/users/users-add');
		}
		else
		{
			$this->users_model->insert();

			$this->users_model->insert_rights($this->db->insert_id());

			$this->session->set_flashdata('msg','Datos insertados exitosamente');
			$this->index();
		}
	}
		
	// update method
	public function update($id)
	{
		$this->users_model->update($id);
		$this->users_model->insert_rights($id);
		$this->session->set_flashdata('msg','Datos actualizados exitosamente');
		$this->index();
	}
		
	// edit method
	public function edit($id)
	{
		$data['cities'] = $this->cities_model->findAll();
		$data['recored'] = $this->users_model->findOne($id);
		$this->load->view('admin/users/users-edit',$data);
	}
		
	// delete method
	public function delete($id)
	{
		if($this->session->userdata('userid') != 1)
		{
			$rights = $this->check_rights();
			if(!in_array('users/delete', $rights))
			{
				return redirect('access');
			}
			else
			{
				$this->users_model->remove($id);
				$this->session->set_flashdata('msg','Datos eliminados exitosamente');
				
				return redirect('users');
			}
		}
		else
		{
			$this->users_model->remove($id);
			$this->session->set_flashdata('msg','Datos eliminados exitosamente');
			
			return redirect('users');
		}
	}
		
	public function active_inactive($id,$mode)
	{
		$this->users_model->change_status($id,$mode);
		return redirect('users');
	}

	public function change_password()
	{
		$this->load->view('admin/users/user-password');
	}

	public function c_password()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('old_password', 'Contraseña anterior', 'required');
		$this->form_validation->set_rules('txt_password', 'Nueva contraseña', 'required');
		$this->form_validation->set_rules('confirm_password', 'Confirmar contraseña', 'required|matches[txt_password]');
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('admin/users/user-password');
		}
		else
		{
			$check = $this->users_model->change_password($this->session->userdata('userid'));

			if($check)
			{
				$this->session->set_flashdata('msg','Contraseña actualizada exitosamente');
			}
			else
			{
				$this->session->set_flashdata('msg','Contraseña anterior incorrecta');
			}
			$this->load->view('admin/users/user-password');
		}

		
		
	}

} 

?>