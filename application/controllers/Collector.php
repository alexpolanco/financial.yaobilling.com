<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');

class Collector extends MY_Controller  { 
 
		 
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
        $this->load->model('collector_model');
    }
 		
	// index method
	public function index()
	{
		$data['recored'] = $this->collector_model->findAll();
		$this->load->view('admin/collector/collector-list',$data);
	}
 	
	public function get_company_data()
	{
		return $this->db->get('company')->result();
	}
 		
	// pdf method
	public function pdf()
	{
		$data['recored'] = $this->collector_model->findAll();
		$this->load->view('admin/collector/collector-pdf',$data);
	}
 		
	// excel method
	public function excel()
	{
		$data['recored'] = $this->collector_model->findAll();
		$this->load->view('admin/collector/collector-excel',$data);
	}
		
	// Create method
	public function create()
	{
		$this->load->library('form_validation');


		$this->form_validation->set_rules('txt_collector_first_name', 'Nombre del cobrador', 'required');
		$this->form_validation->set_rules('txt_collector_email', 'Correo electrónico', 'required');
		$this->form_validation->set_rules('txt_collector_email', 'Correo electrónico válido', 'valid_email');
		$this->form_validation->set_rules('txt_collector_address', 'Dirección', 'required');
		$this->form_validation->set_rules('txt_collector_city', 'Ciudad', 'required');
		$this->form_validation->set_rules('txt_collector_phone', 'Teléfono', 'required');
		/*$this->form_validation->set_rules('txt_contact_person', 'Persona de contácto', 'required');
		$this->form_validation->set_rules('txt_contact_person_phone', 'Teléfono de la persona de contácto', 'required');*/

		$this->form_validation->set_rules('txt_collector_is_active', 'Está activo', 'required');
		
        
        if ($this->form_validation->run() === FALSE)
        {
			$this->load->view('admin/collector/collector-add');
		}
		else
		{
			$this->collector_model->insert();
			$this->session->set_flashdata('msg','Datos insertados exitosamente');
			$this->index();
		}
	}
		
	// update method
	public function update($id)
	{
		$this->collector_model->update($id);
		$this->session->set_flashdata('msg','Datos actualizados exitosamente');
		$this->index();
	}
		
	// edit method
	public function edit($id)
	{
		$data['recored'] = $this->collector_model->findOne($id);
		$this->load->view('admin/collector/collector-edit',$data);
	}
		
	// delete method
	public function delete($id)
	{
		
		if($this->session->userdata('userid') != 1)
	    {

			$rights = $this->check_rights();
			if(!in_array('collector/delete', $rights))
	    	{
	    		return redirect('access');
	    	}
	    	else
	    	{
	    		$this->collector_model->remove($id);
				$this->session->set_flashdata('msg','Datos eliminados exitosamente');
				return redirect('collector');
			}
		}
		else
		{
				$this->collector_model->remove($id);
				$this->session->set_flashdata('msg','Datos eliminados exitosamente');
				return redirect('collector');
		}
		
	}

	public function active_inactive($id,$mode)
	{
		$this->collector_model->change_status($id,$mode);
		return redirect('collector');
	}

 } 
 

?>