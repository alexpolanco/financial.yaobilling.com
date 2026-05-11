<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');

class Guarantor extends MY_Controller 
{ 
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
				if(!in_array($url, $rights))
				{
					$this->load->view('admin/not_access');
				}
			}
		}

		$this->load->helper('form');
		$this->load->model('guarantor_model');
		$this->load->model('cities_model');
	}
	
	// index method
	public function index()
	{
		$data['recored'] = $this->guarantor_model->findAll();
		$this->load->view('admin/guarantor/guarantor-list',$data);
	}

	public function get_company_data()
	{
		return $this->db->get('company')->result();
	}

	// pdf method
	public function pdf()
	{
		$data['cities'] = $this->cities_model->findAll();
		$data['recored'] = $this->guarantor_model->findAll();
		$this->load->view('admin/guarantor/guarantor-pdf',$data);
	}

	// excel method
	public function excel()
	{
		$data['cities'] = $this->cities_model->findAll();
		$data['recored'] = $this->guarantor_model->findAll();
		$this->load->view('admin/guarantor/guarantor-excel',$data);
	}
		
	// Create method
	public function create()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('txt_guarantor_first_name', 'Nombre del garante', 'required');
		$this->form_validation->set_rules('txt_guarantor_personal_id', 'Cédula del garante', 'required');
		$this->form_validation->set_rules('txt_guarantor_email', 'Correo electrónico', 'required');
		$this->form_validation->set_rules('txt_guarantor_email', 'Correo electrónico válido', 'valid_email');
		$this->form_validation->set_rules('txt_guarantor_address', 'Dirección', 'required');
		$this->form_validation->set_rules('txt_guarantor_city', 'Ciudad', 'required');
		$this->form_validation->set_rules('txt_guarantor_phone', 'Teléfono', 'required');
		/*$this->form_validation->set_rules('txt_contact_person', 'Persona de contácto', 'required');
		$this->form_validation->set_rules('txt_contact_person_phone', 'Teléfono de la persona de contácto', 'required');*/

		$this->form_validation->set_rules('txt_guarantor_is_active', 'Está activo', 'required');
		
		
		if ($this->form_validation->run() === FALSE)
		{
			$data['cities'] = $this->cities_model->findAll();
			$this->load->view('admin/guarantor/guarantor-add', $data);
		}
		else
		{
			$this->logger->write( "garantes", "agregado", 'Garante: ' . $this->input->post('txt_guarantor_first_name') . ' ' . $this->input->post('txt_guarantor_personal_id') );

			$this->guarantor_model->insert();
			$this->session->set_flashdata('msg','Datos insertados exitosamente');
			$this->index();
		}
	}
		
	// update / edit method
	public function edit($id)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('txt_guarantor_first_name', 'Nombre del garante', 'required');
		$this->form_validation->set_rules('txt_guarantor_personal_id', 'Cédula del garante', 'required');
		$this->form_validation->set_rules('txt_guarantor_email', 'Correo electrónico', 'required');
		$this->form_validation->set_rules('txt_guarantor_email', 'Correo electrónico válido', 'valid_email');
		$this->form_validation->set_rules('txt_guarantor_address', 'Dirección', 'required');
		$this->form_validation->set_rules('txt_guarantor_city', 'Ciudad', 'required');
		$this->form_validation->set_rules('txt_guarantor_phone', 'Teléfono', 'required');
		/*$this->form_validation->set_rules('txt_contact_person', 'Persona de contácto', 'required');
		$this->form_validation->set_rules('txt_contact_person_phone', 'Teléfono de la persona de contácto', 'required');*/

		$this->form_validation->set_rules('txt_guarantor_is_active', 'Está activo', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$data['cities'] = $this->cities_model->findAll();
			$data['recored'] = $this->guarantor_model->findOne($id);
			$this->load->view('admin/guarantor/guarantor-edit',$data);
		}
		else
		{
			$this->logger->write( "garantes", "actualizado", 'Garante: ' . $this->input->post('txt_guarantor_first_name') . ' ' . $this->input->post('txt_guarantor_personal_id') );
			$this->guarantor_model->update($id);
			$this->session->set_flashdata('msg','Datos actualizados exitosamente');
			$this->index();
		}
	}
		
	// delete method
	public function delete($id)
	{
		if($this->session->userdata('userid') != 1)
		{

			$rights = $this->check_rights();
			$url = $this->uri->segment(1).'/'.$this->uri->segment(2);
			if(!in_array($url, $rights))
			{
				return redirect('access');
			}
			else
			{
				$this->logger->write( "garantes", "eliminado", ' Código garante: ' . $this->uri->segment(2));

				$this->guarantor_model->remove($id);
				$this->session->set_flashdata('msg','Datos eliminados exitosamente');
				return redirect('guarantor');
			}
		}
		else
		{
			$this->logger->write( "garantes", "eliminado", ' Código garante: ' . $this->uri->segment(2));

				$this->guarantor_model->remove($id);
				$this->session->set_flashdata('msg','Datos eliminados exitosamente');
				return redirect('guarantor');
		}
		
	}

	public function active_inactive($id,$mode)
	{
		$this->guarantor_model->change_status($id,$mode);
		return redirect('guarantor');
	}

} 

?>