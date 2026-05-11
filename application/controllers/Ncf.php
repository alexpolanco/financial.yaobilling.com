<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ncf extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'NCF';

		$this->load->model('model_ncf');
        $this->load->model('model_events');
        $this->load->model('model_company');		
		$this->data['unpaid_invoice'] = $this->model_company->unpaidInvoice();
	}

    /* 
    * It redirects to the NCF page and displays all the NCF information
    * It also updates the NCF information into the database if the 
    * validation for each input field is successfully valid
    */
	public function index()
	{  
        if(!in_array('viewNCF', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $result = $this->model_ncf->getNCFData();

		$this->data['results'] = $result;

		$this->render_template('ncf/index', $this->data);
        
        }

	/*
	* Fetches the NCF data from the NCF table 
	* this function is called from the datatable ajax function
	*/
	public function fetchNCFData()
	{
		$result = array('data' => array());

		$data = $this->model_ncf->getNCFData();
		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			if(in_array('viewNCF', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editNCF('.$value['id'].')" data-toggle="modal" data-target="#editNCFModal"><i class="fa fa-pencil"></i></button>';	
			}
			
			if(in_array('deleteNCF', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeNCF('.$value['id'].')" data-toggle="modal" data-target="#removeNCFModal"><i class="fa fa-trash"></i></button>
				';
			}				

			$status = ($value['active'] == 1) ? '<span class="label label-success">ACTIVO</span>' : '<span class="label label-warning">INACTIVO</span>';

			$result['data'][$key] = array(
				$value['name']. " " . $status,
				$value['serie'].$value['sequence'],
                $value['serie'].$value['last_ncf'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	* It checks if it gets the NCF id and retreives
	* the NCF information from the NCF model and 
	* returns the data into json format. 
	* This function is invoked from the view page.
	*/
	public function fetchNCFDataById($id)
	{
		if($id) {
			$data = $this->model_ncf->getNCFData($id);
			echo json_encode($data);
		}

		return false;
	}

	/*
	* Its checks the NCF form validation 
	* and if the validation is successfully then it inserts the data into the database 
	* and returns the json format operation messages
	*/
	public function create()
	{

		if(!in_array('createNCF', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

        $this->form_validation->set_rules('ncf_name', 'Nombre del comprobante', 'trim|required');
		$this->form_validation->set_rules('ncf_serie', 'Serie del comprobante', 'trim');
		$this->form_validation->set_rules('ncf_sequence', 'Secuencia del comprobante', 'trim|integer');
        $this->form_validation->set_rules('sequence_due_date', 'Fecha', 'trim');
		$this->form_validation->set_rules('last_ncf', 'Último comprabante utilizado', 'trim|integer');
        $this->form_validation->set_rules('active', 'Activo', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
            // true case

        	$data = array(
        		'name' => $this->input->post('ncf_name'),
        		'serie' => $this->input->post('ncf_serie'),
        		'sequence' => $this->input->post('ncf_sequence'),
        		'sequence_due_date' => $this->input->post('sequence_due_date'),
        		'last_ncf' => $this->input->post('last_ncf'),
        		'active' => $this->input->post('active')
        	);
            
        	$create = $this->model_ncf->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Guardado éxitosamente';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Ocurrió un error';			
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);

	}

	/*
	* Its checks the NCF form validation 
	* and if the validation is successfully then it updates the data into the database 
	* and returns the json format operation messages
	*/
	public function update($id)
	{
		if(!in_array('updateNCF', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_ncf_name', 'Nombre del comprobante', 'trim|required');
            $this->form_validation->set_rules('edit_ncf_serie', 'Serie del comprobante', 'trim');
            $this->form_validation->set_rules('edit_ncf_sequence', 'Secuencia del comprobante', 'trim|integer');
		    $this->form_validation->set_rules('edit_sequence_due_date', 'Fecha', 'trim');
            $this->form_validation->set_rules('edit_last_ncf', 'Último comprabante utilizado', 'trim|integer');
			$this->form_validation->set_rules('edit_active', 'Activo', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
                    'name' => $this->input->post('edit_ncf_name'),
                    'serie' => $this->input->post('edit_ncf_serie'),
                    'sequence' => $this->input->post('edit_ncf_sequence'),
                    'last_ncf' => $this->input->post('edit_last_ncf'),
                    'sequence_due_date' => $this->input->post('edit_sequence_due_date'),
        		    'active' => $this->input->post('edit_active')
                );

	        	$update = $this->model_ncf->update($data, $id);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Actualizado éxitosamente';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Ocurrió un error';			
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Inténtelo de nuevo!!';
		}

		echo json_encode($response);
	}

	/*
	* It removes the NCF information from the database 
	* and returns the json format operation messages
	*/
	public function remove()
	{
		if(!in_array('deleteNCF', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$ncf_id = $this->input->post('ncf_id');
		$response = array();
		if($ncf_id) {
			$delete = $this->model_ncf->remove($ncf_id);

			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Eliminado éxitosamente";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Ocurrió un error";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Inténtelo de nuevo!!";
		}

		echo json_encode($response);
	}
   
}