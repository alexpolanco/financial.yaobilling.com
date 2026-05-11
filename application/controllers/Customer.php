<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller 
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
		$this->load->model('customer_model');
		$this->load->model('cities_model');
	}
	
	// index method
	public function index()
	{
		$data['recored'] = $this->customer_model->findAll();
		$this->load->view('admin/customer/customer-list',$data);
	}

	public function get_company_data()
	{
		return $this->db->get('company')->result();
	}

	// pdf method
	public function pdf()
	{
		$data['cities'] = $this->cities_model->findAll();
		$data['recored'] = $this->customer_model->findAll();
		$this->load->view('admin/customer/customer-pdf',$data);
	}

	// excel method
	public function excel()
	{
		$data['cities'] = $this->cities_model->findAll();
		$data['recored'] = $this->customer_model->findAll();
		$this->load->view('admin/customer/customer-excel',$data);
	}
		
	// Create method
	public function create()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('txt_customer_first_name', 'Nombre del cliente', 'required');
		$this->form_validation->set_rules('txt_customer_email', 'Correo electrónico', 'required');
		$this->form_validation->set_rules('txt_customer_email', 'Correo electrónico válido', 'valid_email');
		$this->form_validation->set_rules('txt_customer_address', 'Dirección', 'required');
		$this->form_validation->set_rules('txt_customer_city', 'Ciudad', 'required');
		$this->form_validation->set_rules('txt_customer_phone', 'Teléfono', 'required');
		/*$this->form_validation->set_rules('txt_contact_person', 'Persona de contácto', 'required');
		$this->form_validation->set_rules('txt_contact_person_phone', 'Teléfono de la persona de contácto', 'required');*/

		$this->form_validation->set_rules('txt_customer_is_active', 'Está activo', 'required');
		
		
		if ($this->form_validation->run() === FALSE)
		{
			$data['cities'] = $this->cities_model->findAll();
			$this->load->view('admin/customer/customer-add', $data);
		}
		else
		{
			$this->logger->write( "clientes", "agregado", 'Cliente: ' . $this->input->post('txt_customer_first_name') . ' ' . $this->input->post('txt_customer_personal_id') );

			$this->customer_model->insert();
			$this->session->set_flashdata('msg','Datos insertados exitosamente');
			$this->index();
		}
	}
		
	// update / edit method
	public function edit($id)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('txt_customer_first_name', 'Nombre del cliente', 'required');
		$this->form_validation->set_rules('txt_customer_email', 'Correo electrónico', 'required');
		$this->form_validation->set_rules('txt_customer_email', 'Correo electrónico válido', 'valid_email');
		$this->form_validation->set_rules('txt_customer_address', 'Dirección', 'required');
		$this->form_validation->set_rules('txt_customer_city', 'Ciudad', 'required');
		$this->form_validation->set_rules('txt_customer_phone', 'Teléfono', 'required');
		/*$this->form_validation->set_rules('txt_contact_person', 'Persona de contácto', 'required');
		$this->form_validation->set_rules('txt_contact_person_phone', 'Teléfono de la persona de contácto', 'required');*/

		$this->form_validation->set_rules('txt_customer_is_active', 'Está activo', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$data['cities'] = $this->cities_model->findAll();
			$data['recored'] = $this->customer_model->findOne($id);
			$this->load->view('admin/customer/customer-edit',$data);
		}
		else
		{
			$this->logger->write( "clientes", "actualizado", 'Cliente: ' . $this->input->post('txt_customer_first_name') . ' ' . $this->input->post('txt_customer_personal_id') );
			$this->customer_model->update($id);
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
				$this->logger->write( "clientes", "eliminado", ' Código cliente: ' . $this->uri->segment(2));

				$this->customer_model->remove($id);
				$this->session->set_flashdata('msg','Datos eliminados exitosamente');
				return redirect('customer');
			}
		}
		else
		{
			$this->logger->write( "clientes", "eliminado", ' Código cliente: ' . $this->uri->segment(2));

				$this->customer_model->remove($id);
				$this->session->set_flashdata('msg','Datos eliminados exitosamente');
				return redirect('customer');
		}
		
	}

	public function active_inactive($id,$mode)
	{
		$this->customer_model->change_status($id,$mode);
		return redirect('customer');
	}

} 

?>