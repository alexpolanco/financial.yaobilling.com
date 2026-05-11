<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->not_logged_in();
		
		$this->data['page_title'] = 'PROVEEDORES';
		
		$this->load->model('model_suppliers');
		$this->load->model('model_events');
		$this->load->model('model_company');		
		$this->data['unpaid_invoice'] = $this->model_company->unpaidInvoice();

		$this->user_id = $this->session->userdata('id');
		$this->company_id = $this->session->userdata('company_id');
	}

	/* 
    * It only redirects to the manage suppliers page
    */	
	public function index()
	{
		if(!in_array('viewSupplier', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$supplier_data = $this->model_suppliers->getSupplierData();

		$result = array() ;
		foreach ($supplier_data as $k => $v) {
			$result[$k]['supplier_info'] = $v;
		}

		$this->data['supplier_data'] = $result;
		$this->render_template('suppliers/index', $this->data);
	}

	/*
	* Fetches the supplier data from the supplier table 
	* this function is called from the datatable ajax function
	*/
	public function fetchSuppliersData()
	{
		$result = array('data' => array());
		$data = $this->model_suppliers->getSupplierData();

		foreach ($data as $key => $value) {
			$count_total_item = $this->model_suppliers->countTotalSuppliers($value['supp_id']);

			// button
			$buttons = '';

			if(in_array('viewSupplier', $this->permission)) {
				$buttons = '<button type="button" onclick="viewSupplierFunc('.$value['supp_id'].')" class="btn btn-warning btn-default" id="order_'.$value['supp_id'].'" data-id="'.$value['supp_id'].'" data-toggle="modal" data-target="#viewSupplierModal" data-toggle="tooltip" data-placement="bottom" title="Ver proveedor"><i class="fa fa-eye"></i></button>';
			}

			if(in_array('updateSupplier', $this->permission)) {
				$buttons .= ' <a href="'.base_url('suppliers/edit/'.$value['supp_id']).'" class="btn btn-info btn-default" data-toggle="tooltip" data-placement="bottom" title="Editar proveedor"><i class="fa fa-edit"></i></a>';
			}

			if(in_array('deleteSupplier', $this->permission)) {
				$buttons .= '  <button type="button" onclick="removeFunc('.$value['supp_id'].')" class="btn btn-danger btn-default" data-toggle="modal" data-target="#removeSupplierModal" data-toggle="tooltip" data-placement="bottom" title="Eliminar proveedor"><i class="fa fa-trash"></i></button>';
			}

			$result['data'][$key] = array(
				$value['suppliername'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	* Fetches the supplier data from the id in the supplier table 
	* this function is called from the datatable ajax function
	*/
	public function fetchSuppliersDataByID($id = null)
	{
		$result = $this->model_suppliers->getSupplierData($id);

		if($result) {
			echo json_encode($result);
		}
	}

	public function create()
	{
		if(!in_array('createSupplier', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('suppliername', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('rnc', 'RNC', 'trim|min_length[11]|max_length[13]');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');

		if ($this->form_validation->run() == TRUE) {
			// true case
			$new_supplier_id = $this->model_suppliers->getLastSupplierId();
			$data = array(
				'supp_id' => $new_supplier_id['supp_id']+1,
				'suppliername' => clean_data($this->input->post('suppliername')),
				'rnc' => clean_data($this->input->post('rnc')),
				'address' => clean_data($this->input->post('address')),
				'legalname' => clean_data($this->input->post('legalname')),
				'phone' => clean_data($this->input->post('phone')),
				'fax' => clean_data($this->input->post('fax')),
				'email' => clean_data($this->input->post('email')),
				'website' => clean_data($this->input->post('website')),
				'bank_account' => clean_data($this->input->post('bank_account')),
				'notes' => clean_data($this->input->post('notes')),
				'register_date' => date('Y-m-d'),
				'user_id' => $this->user_id,
				'company_id' => $this->company_id,
			);

			if($_FILES['supplier_image']['size'] > 0)
			{
				$upload_supplier_photo = $this->upload_supplier_photofilename();
				$upload_supplier_photo = array('photofilename' => $upload_supplier_photo);

				$this->model_suppliers->edit($upload_supplier_photo, $id);
			}
			if($_FILES['supplier_catalog1']['size'] > 0)
			{
				$upload_supplier_catalog1 = $this->upload_supplier_catalogfile('supplier_catalog1');
				$upload_supplier_catalog1 = array('catalogfile1' => $upload_supplier_catalog1);

				$this->model_suppliers->edit($upload_supplier_catalog1, $id);
			}
			if($_FILES['supplier_catalog2']['size'] > 0)
			{
				$upload_supplier_catalog2 = $this->upload_supplier_catalogfile('supplier_catalog2');
				$upload_supplier_catalog2 = array('catalogfile2' => $upload_supplier_catalog2);

				$this->model_suppliers->edit($upload_supplier_catalog2, $id);
			}

			$create = $this->model_suppliers->create($data);
			if($create == true) {
				if (isset($_POST['save_more'])) {
					$this->session->set_flashdata('success', 'Guardado éxitosamente');
					redirect('suppliers/create', 'refresh');
				} else {
						$this->session->set_flashdata('success', 'Guardado éxitosamente');
					redirect('suppliers/', 'refresh');
				}
			} else {
				$this->session->set_flashdata('errors', 'Ocurrió un error!!');
				redirect('suppliers/create', 'refresh');
			}
		} else {
			// false case
			$this->render_template('suppliers/create', $this->data);
		}	
	}

	public function createModal()
	{
		if(!in_array('createSupplier', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('suppliername', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('rnc', 'RNC', 'trim|min_length[11]|max_length[13]');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');

		if ($this->form_validation->run() == TRUE) {
			$new_supplier_id = $this->model_suppliers->getLastSupplierId();
			$data = array(
				'supp_id' => $new_supplier_id['supp_id']+1,
				'suppliername' => clean_data($this->input->post('suppliername')),
				'rnc' => clean_data($this->input->post('rnc')),
				'address' => clean_data($this->input->post('address')),
				'legalname' => clean_data($this->input->post('legalname')),
				'phone' => clean_data($this->input->post('phone')),
				'fax' => clean_data($this->input->post('fax')),
				'email' => clean_data($this->input->post('email')),
				'website' => clean_data($this->input->post('website')),
				'bank_account' => clean_data($this->input->post('bank_account')),
				'notes' => clean_data($this->input->post('notes')),
				'register_date' => date('Y-m-d'),
				'user_id' => $this->user_id,
				'company_id' => $this->company_id,
			);

			if($_FILES['supplier_image']['size'] > 0)
			{
				$upload_supplier_photo = $this->upload_supplier_photofilename();
				$upload_supplier_photo = array('photofilename' => $upload_supplier_photo);

				$this->model_suppliers->edit($upload_supplier_photo, $id);
			}
			if($_FILES['supplier_catalog1']['size'] > 0)
			{
				$upload_supplier_catalog1 = $this->upload_supplier_catalogfile('supplier_catalog1');
				$upload_supplier_catalog1 = array('catalogfile1' => $upload_supplier_catalog1);

				$this->model_suppliers->edit($upload_supplier_catalog1, $id);
			}
			if($_FILES['supplier_catalog2']['size'] > 0)
			{
				$upload_supplier_catalog2 = $this->upload_supplier_catalogfile('supplier_catalog2');
				$upload_supplier_catalog2 = array('catalogfile2' => $upload_supplier_catalog2);

				$this->model_suppliers->edit($upload_supplier_catalog2, $id);
			}
			
			$create = $this->model_suppliers->create($data);
			if($create == true ) {
				$new_supplier_id = $this->model_suppliers->getLastSupplierId();
				$response['supp_id'] = $new_supplier_id['supp_id'];
				$response['suppliername'] = $this->input->post('suppliername');
				$response['success'] = true;
				$response['messages'] = 'Guardado éxitosamente';
			} else {
				$response['success'] = false;
				$response['messages'] = 'Ocurrió un error';			
			}
		} else {
			$response['success'] = false;
			foreach ($_POST as $key => $value) {
				$response['messages'][$key] = form_error($key);
			}
		}

		echo json_encode($response);
	}

	public function edit($id = null)
	{
		if(!in_array('updateSupplier', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if($id) {
			$this->form_validation->set_rules('suppliername', 'Nombre', 'trim|required');
			$this->form_validation->set_rules('rnc', 'RNC', 'trim|min_length[11]|max_length[13]');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');

			if ($this->form_validation->run() == TRUE) {
				// true case
				if(empty($this->input->post('suppliername')) && empty($this->input->post('rnc'))) {

					$data = array(
						'suppliername' => clean_data($this->input->post('suppliername')),
						'rnc' => clean_data($this->input->post('rnc')),
						'address' => clean_data($this->input->post('address')),
						'legalname' => clean_data($this->input->post('legalname')),
						'phone' => clean_data($this->input->post('phone')),
						'fax' => clean_data($this->input->post('fax')),
						'email' => clean_data($this->input->post('email')),
						'website' => clean_data($this->input->post('website')),
						'bank_account' => clean_data($this->input->post('bank_account')),
        				'notes' => clean_data($this->input->post('notes')),
					);

					if($_FILES['supplier_image']['size'] > 0)
					{
						$upload_supplier_photo = $this->upload_supplier_photofilename();
						$upload_supplier_photo = array('photofilename' => $upload_supplier_photo);

						$this->model_suppliers->edit($upload_supplier_photo, $id);
					}
					if($_FILES['supplier_catalog1']['size'] > 0)
					{
						$upload_supplier_catalog1 = $this->upload_supplier_catalogfile('supplier_catalog1');
						$upload_supplier_catalog1 = array('catalogfile1' => $upload_supplier_catalog1);

						$this->model_suppliers->edit($upload_supplier_catalog1, $id);
					}
					if($_FILES['supplier_catalog2']['size'] > 0)
					{
						$upload_supplier_catalog2 = $this->upload_supplier_catalogfile('supplier_catalog2');
						$upload_supplier_catalog2 = array('catalogfile2' => $upload_supplier_catalog2);

						$this->model_suppliers->edit($upload_supplier_catalog2, $id);
					}

					$update = $this->model_suppliers->edit($data, $id);
					if($update == true) {
						$this->session->set_flashdata('success', 'Guardado éxitosamente');
						redirect('suppliers/', 'refresh');
					}
					else {
						$this->session->set_flashdata('errors', 'Ocurrió un error!!');
						redirect('suppliers/edit/'.$id, 'refresh');
					}
				}
				else {
					if($this->form_validation->run() == TRUE) {
						$data = array(
							'suppliername' => clean_data($this->input->post('suppliername')),
							'rnc' => clean_data($this->input->post('rnc')),
							'address' => clean_data($this->input->post('address')),
							'legalname' => clean_data($this->input->post('legalname')),
							'phone' => clean_data($this->input->post('phone')),
							'fax' => clean_data($this->input->post('fax')),
							'email' => clean_data($this->input->post('email')),
							'website' => clean_data($this->input->post('website')),
							'bank_account' => clean_data($this->input->post('bank_account')),
            				'notes' => clean_data($this->input->post('notes')),
						);

						if($_FILES['supplier_image']['size'] > 0)
						{
							$upload_supplier_photo = $this->upload_supplier_photofilename();
							$upload_supplier_photo = array('photofilename' => $upload_supplier_photo);

							$this->model_suppliers->edit($upload_supplier_photo, $id);
						}
						if($_FILES['supplier_catalog1']['size'] > 0)
						{
							$upload_supplier_catalog1 = $this->upload_supplier_catalogfile('supplier_catalog1');
							$upload_supplier_catalog1 = array('catalogfile1' => $upload_supplier_catalog1);

							$this->model_suppliers->edit($upload_supplier_catalog1, $id);
						}
						if($_FILES['supplier_catalog2']['size'] > 0)
						{
							$upload_supplier_catalog2 = $this->upload_supplier_catalogfile('supplier_catalog2');
							$upload_supplier_catalog2 = array('catalogfile2' => $upload_supplier_catalog2);

							$this->model_suppliers->edit($upload_supplier_catalog2, $id);
						}

						$update = $this->model_suppliers->edit($data, $id);
						if($update == true) {
							$this->session->set_flashdata('success', 'Actualizado éxitosamente');
							redirect('suppliers/', 'refresh');
						}
						else {
							$this->session->set_flashdata('errors', 'Ocurrió un error!!');
							redirect('suppliers/edit/'.$id, 'refresh');
						}
					}
					else {
						// false case
						$supplier_data = $this->model_suppliers->getSupplierData($id);
						$this->data['supplier_data'] = $supplier_data;
						$this->render_template('suppliers/edit', $this->data);	
					}	
				}
			}
			else {
				// false case
				$supplier_data = $this->model_suppliers->getSupplierData($id);
				$this->data['supplier_data'] = $supplier_data;
				$this->render_template('suppliers/edit', $this->data);	
			}	
		}	
	}

	public function delete($id)
	{
		if(!in_array('deleteSupplier', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if($id) {
			if($this->input->post('confirm')) {
				$delete = $this->model_suppliers->delete($id);
				if($delete == true) {
					$this->session->set_flashdata('success', 'Eliminado éxitosamente');
					redirect('suppliers/', 'refresh');
				}
				else {
					$this->session->set_flashdata('error', 'Ocurrió un error!!');
					redirect('suppliers/delete/'.$id, 'refresh');
				}

			}	
			else {
				$this->data['supp_id'] = $id;
				$this->render_template('suppliers/delete', $this->data);
			}	
		}
	}

	/*
	* It removes the data from the database
	* and it returns the response into the json format
	*/
	public function remove()
	{
		if(!in_array('deleteSupplier', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$id = $this->input->post('id');

		$response = array();
		if($id) {
			$delete = $this->model_suppliers->delete($id);
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

	public function profile($id)
	{
		if(!in_array('viewProfile', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if($id) {
			$supplier_data = $this->model_suppliers->getSupplierData($id);
			$this->data['supplier_data'] = $supplier_data;
			$this->render_template('suppliers/profile', $this->data);
		}
	}

	/*
	* This function is invoked from another function to upload the image into the assets folder
	* and returns the image path
	*/
	public function upload_supplier_photofilename()
	{
		// assets/images/supplier_image
		$config['upload_path'] = 'assets/images/supplier_image';
		$config['file_name'] =  uniqid();
		$config['allowed_types'] = 'gif|jpg|jfif|jpeg|png';
		$config['max_size'] = '1500';
		$config['overwrite'] = TRUE;

		// $config['max_width']  = '1024';
		// $config['max_height']  = '768';

		$this->load->library('upload', $config);
		if ( !$this->upload->do_upload('supplier_image'))
		{
			$error = $this->upload->display_errors();
			return $error;
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$type = explode('.', $_FILES['supplier_image']['name']);
			$type = $type[count($type) - 1];
			
			$path = $config['upload_path'].'/'.$config['file_name'].'.'.$type;
			return ($data == true) ? $path : false;            
		}
	}

	public function upload_supplier_catalogfile($catalogfile)
	{
		// assets/images/supplier_image
		$config['upload_path'] = 'assets/images/supplier_catalog';
		$config['file_name'] =  uniqid();
		$config['allowed_types'] = 'pdf|txt|gif|jpg|jfif|jpeg|png';
		$config['max_size'] = '3072';
		$config['overwrite'] = TRUE;

		// $config['max_width']  = '1024';
		// $config['max_height']  = '768';

		$this->load->library('upload', $config);
		if ( !$this->upload->do_upload($catalogfile))
		{
			$error = $this->upload->display_errors();
			return $error;
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$type = explode('.', $_FILES[$catalogfile]['name']);
			$type = $type[count($type) - 1];
			
			$path = $config['upload_path'].'/'.$config['file_name'].'.'.$type;
			return ($data == true) ? $path : false;            
		}
	}
}