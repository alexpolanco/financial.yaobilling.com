<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense extends MY_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->user_id = $this->session->userdata('userid');

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
		$this->load->model('expense_model');
	}

	/* 
	* It only redirects to the manage expense page
	*/
	public function index()
	{
		$data['recored'] = $this->expense_model->findAll();
		$this->load->view('admin/expense/expense-list',$data);
	}	

	public function get_company_data()
	{
		$this->db->where('company_id', $this->session->userdata('company_id'));
		return $this->db->get('company')->result();
	}

	/*
	* It checks if it gets the expense id and retreives
	* the expense information from the expense model and 
	* returns the data into json format. 
	* This function is invoked from the view page.
	*/
	public function edit($id) 
	{
		if($id) {
			$data = $this->expense_model->getExpenseData($id);
			echo json_encode($data);
		}

		return false;
	}

	/*
	* Fetches the expense value from the expense table 
	* this function is called from the datatable ajax function
	*/
	public function fetchExpenseData()
	{
		$result = array('data' => array());

		$data = $this->expense_model->getExpenseData();

		foreach ($data as $key => $value) {
			$date = date('d-m-Y',  strtotime($value['PaidDate']));

			// button
			$buttons = '';

			if(in_array('updateExpense', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunc('.$value['Expense_ID'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteExpense', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['Expense_ID'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			$result['data'][$key] = array(
				$date,
				$value['Description'],
				$value['Amount'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
	public function fetchExpenseDataById($id)
	{
		$result = array('data' => array());

		$data = $this->expense_model->getExpenseData($id);

		foreach ($data as $key => $value) {
			$date = date('d-m-Y',  strtotime($value['PaidDate']));

			// button
			$buttons = '';

			if(in_array('updateExpense', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunc('.$value['Expense_ID'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteExpense', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['Expense_ID'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			$result['data'][$key] = array(
				$date,
				$value['Description'],
				$value['Amount'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function pdf()
	{
		$sendserver = $this->uri->segment(1);
		$loanstype = $this->uri->segment(2);
		$dateform = $this->uri->segment(3);
		$dateto = $this->uri->segment(4);

		/* echo "sendserver ". $sendserver . " ";
		echo "loanstype ". $loanstype . " ";
		echo "dateform ". $dateform . " ";
		echo "dateto ". $dateto . " "; */

		$data['recored'] = $this->expense_model->findExpense($dateform, $dateto);

		$this->load->view('admin/expense/expense_pdf',$data);
	}

	/*
	* Its checks the expense form validation 
	* and if the validation is successfully then it inserts the data into the database 
	* and returns the json format operation messages
	*/
	public function create()
	{
		$this->load->library('form_validation');
		$response = array();

		$this->form_validation->set_rules('Description', 'Descripción', 'trim|required');
		$this->form_validation->set_rules('Amount', 'Monto', 'trim|required');
		$this->form_validation->set_rules('PaidDate', 'Fecha de pago', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		
		$PaidDate = ($this->input->post('PaidDate') != "") ? date('Y-m-d', strtotime($this->input->post('PaidDate'))) : "";

		if ($this->form_validation->run() == TRUE) {
			$new_Expense_ID = $this->expense_model->getLastExpenseId();
			$data = array(
				'Expense_ID' => $new_Expense_ID['Expense_ID']+1,
				'company_id' => $this->session->userdata('company_id'),
				'Description' => $this->input->post('Description'),
				'Amount' => $this->input->post('Amount'),
				'PaidDate' => $PaidDate,	
				'user_id' => $this->session->userdata('userid'),
			);

			$create = $this->expense_model->create($data);
			if($create == true) {
				$response['success'] = true;
				$response['messages'] = 'Guardado éxitosamente';
				$this->session->set_flashdata('msg','Datos guardados exitosamente');
			}
			else {
				$response['success'] = false;
				$response['messages'] = 'Ocurrió un error!!!';
				$this->session->set_flashdata('msg','Ocurrió un error!!!');
			}
		}
		else {
			$response['success'] = false;
			foreach ($_POST as $key => $value) {
				$response['messages'][$key] = form_error($key);
			}
		}
		
		echo json_encode($response);
		//return redirect('expense');
	}
	
	public function createModal()
	{
		$this->load->library('form_validation');
		$response = array();

		$this->form_validation->set_rules('Description', 'Descripción', 'trim|required');
		$this->form_validation->set_rules('Amount', 'Monto', 'trim|required');
		$this->form_validation->set_rules('PaidDate', 'Fecha de pago', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		
		$PaidDate = ($this->input->post('PaidDate') != "") ? date('Y-m-d', strtotime($this->input->post('PaidDate'))) : "";

		if ($this->form_validation->run() == TRUE) {
			$new_Expense_ID = $this->expense_model->getLastExpenseId();
			$data = array(
				'Expense_ID' => $new_Expense_ID['Expense_ID']+1,
				'company_id' => $this->session->userdata('company_id'),
				'Description' => $this->input->post('Description'),
				'Amount' => $this->input->post('Amount'),
				'PaidDate' => $PaidDate,	
				'user_id' => $this->session->userdata('userid'),
			);

			$create = $this->expense_model->create($data);
			if($create == true) {
				$new_Expense_ID = $this->expense_model->getLastExpenseId();
				
				$response['Expense_ID'] = $new_Expense_ID['Expense_ID'];
				$response['Description'] = $this->input->post('Description');
				$response['success'] = true;
				$response['messages'] = 'Guardado éxitosamente';
				$this->session->set_flashdata('msg','Datos guardados exitosamente');
			}
			else {
				$response['success'] = false;
				$response['messages'] = 'Ocurrió un error!!!';
				$this->session->set_flashdata('msg','Ocurrió un error!!!');
			}
		}
		else {
			$response['success'] = false;
			foreach ($_POST as $key => $value) {
				$response['messages'][$key] = form_error($key);
			}
		}

		echo json_encode($response);
		//return redirect('expense');
	}

	/*
	* Its checks the expense form validation 
	* and if the validation is successfully then it updates the data into the database 
	* and returns the json format operation messages
	*/
	public function update($id = null)
	{
		$this->load->library('form_validation');
		$response = array();

		$id = $this->input->post('expense_id');

		if($id) {
			$this->form_validation->set_rules('edit_Description', 'Descripción', 'trim|required');
			$this->form_validation->set_rules('edit_Amount', 'Monto', 'trim|required');
			$this->form_validation->set_rules('edit_PaidDate', 'Fecha de pago', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
			
			$PaidDate = ($this->input->post('edit_PaidDate') != "") ? date('Y-m-d', strtotime($this->input->post('edit_PaidDate'))) : "";

			if ($this->form_validation->run() == TRUE) {
				$data = array(
					'Description' => $this->input->post('edit_Description'),
					'Amount' => $this->input->post('edit_Amount'),
					'PaidDate' => $PaidDate,	
				);

				$update = $this->expense_model->update($data, $id);
				if($update == true) {
					$response['success'] = true;
					$response['messages'] = 'Actualizado éxitosamente';
					//$this->session->set_flashdata('msg','Datos actualizados exitosamente');
				}
				else {
					$response['success'] = false;
					$response['messages'] = 'Ocurrió un error';
					$this->session->set_flashdata('msg','Ocurrió un error!!!');
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
			$this->session->set_flashdata('msg','Ocurrió un error!!!');
		}
		return redirect('expense');

/* 		$data['data'] = json_encode($response);
		$this->load->view('admin/expense/expense-list',$data); */
	}

	/*
	* It removes the expense information from the database 
	* and returns the json format operation messages
	*/
	public function remove()
	{
	    $Expense_ID = $this->input->post('id');

		$response = array();
		if($Expense_ID) {
			$delete = $this->expense_model->remove($Expense_ID);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Eliminada éxitosamente";
				$this->session->set_flashdata('msg','Datos eliminados exitosamente');
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Ocurrió un error";
				$this->session->set_flashdata('msg','Ocurrió un error!!!');
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Inténtelo de nuevo!!";
			$this->session->set_flashdata('msg','Ocurrió un error!!!');
		}

		echo json_encode($response);
		return redirect('expense');
	}

	// delete method
	public function delete($id = null)
	{
		if($this->session->userdata('userid') != 1)
		{
			$rights = $this->check_rights();
			if(!in_array('expense/delete', $rights))
			{
				return redirect('access');
			}
			else
			{
				$cid = $this->input->post('id');

				$this->expense_model->remove($this->input->post('id'));
				$this->session->set_flashdata('msg','Datos eliminados exitosamente');

				return redirect('expense');
			}
		}
		else
		{
			$cid = $this->input->post('id');
			$this->expense_model->remove($this->input->post('id'));
			$this->session->set_flashdata('msg','Datos eliminados exitosamente');

			return redirect('expense');
		}
	}

	public function active_inactive($id,$mode)
	{
		$this->customer_model->change_status($id,$mode);
		return redirect('expense');
	}
}