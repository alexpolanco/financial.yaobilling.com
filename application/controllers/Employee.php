<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'EMPLEADOS';
		
		$this->load->model('model_employee');
        $this->load->model('model_events');
        $this->load->model('model_company');		
		$this->data['unpaid_invoice'] = $this->model_company->unpaidInvoice();

		$this->user_id = $this->session->userdata('id');
	}

    /* 
    * It only redirects to the manage employee page
    */	
	public function index()
	{
		if(!in_array('viewEmployee', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
        
        $employee_data = $this->model_employee->getEmployeeData();

		$result = array() ;
		foreach ($employee_data as $k => $v) {
			$result[$k]['employee_info'] = $v;
		}

		$this->data['employee_data'] = $result;
		$this->render_template('employee/index', $this->data);
	}

    /*
	* Fetches the employee data from the employee table 
	* this function is called from the datatable ajax function
	*/
	public function fetchEmployeeData()
	{
		$result = array('data' => array());

		$data = $this->model_employee->getEmployeeData();

		foreach ($data as $key => $value) {

			$count_total_item = $this->model_employee->countTotalEmployee($value['EMP_ID']);

			// button
			$buttons = '';

			if(in_array('viewEmployee', $this->permission)) {
				$buttons = '<button type="button" onclick="viewEmployeeFunc('.$value['EMP_ID'].')" class="btn btn-warning btn-default" id="employee_'.$value['EMP_ID'].'" data-id="'.$value['EMP_ID'].'" data-toggle="modal" data-target="#viewEmployeeModal" data-toggle="tooltip" data-placement="bottom" title="Ver empleado"><i class="fa fa-eye"></i></button>';
			}

			if(in_array('updateEmployee', $this->permission)) {
				$buttons .= ' <a href="'.base_url('employee/edit/'.$value['EMP_ID']).'" class="btn btn-info btn-default" data-toggle="tooltip" data-placement="bottom" title="Editar empleado"><i class="fa fa-edit"></i></a>';
			}

			if(in_array('deleteEmployee', $this->permission)) {
				$buttons .= '  <button type="button" onclick="removeFunc('.$value['EMP_ID'].')" class="btn btn-danger btn-default" data-toggle="modal" data-target="#removeEmployeeModal" data-toggle="tooltip" data-placement="bottom" title="Eliminar empleado"><i class="fa fa-trash"></i></button>';
			}
            
            $result['data'][$key] = array(
				$value['EmployeeName'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
    
    /*
	* Fetches the employee data from the id in the employee table 
	* this function is called from the datatable ajax function
	*/
	public function fetchEmployeeDataByID($id = null)
	{
		$result = $this->model_employee->getEmployeeData($id);
        
        if($result) {
		  echo json_encode($result);
        }
	}
    
	public function create()
	{
		if(!in_array('createEmployee', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('name', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('personal_id', 'Cédula', 'trim|min_length[11]|max_length[13]');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');

        if ($this->form_validation->run() == TRUE) {
            // true case
            $new_employee_id = $this->model_employee->getLastEmployeeId();
        	$data = array(
        		'EMP_ID' => $new_employee_id['EMP_ID']+1,
        		'EmployeeName' => clean_data($this->input->post('name')),
        		'PersonalId' => clean_data($this->input->post('personal_id')),
        		'Address' => clean_data($this->input->post('address')),
        		'Designation' => clean_data($this->input->post('designation')),
        		'PhoneNo' => clean_data($this->input->post('phone')),
        		'MobileNo' => clean_data($this->input->post('mobile')),
        		'Email' => clean_data($this->input->post('email')),
        		'Website' => clean_data($this->input->post('website')),
        		'OpeningDate' => date('Y-m-d'),
        		'user_id' => $this->user_id,
        	);

        	$create = $this->model_employee->create($data);
        	if($create == true) {
				if($_FILES['employee_image']['size'] > 0) {
					$upload_image = $this->upload_employee_image();
					$upload_image = array('image' => $upload_image);

					$this->model_employee->edit($upload_image, $new_employee_id['EMP_ID']);
				}
                if (isset($_POST['save_more'])) {
                  $this->session->set_flashdata('success', 'Guardado éxitosamente');
        		  redirect('employee/create', 'refresh');
                } else {
                  $this->session->set_flashdata('success', 'Guardado éxitosamente');
        		  redirect('employee/', 'refresh');
                }
        	} else {
        		$this->session->set_flashdata('errors', 'Ocurrió un error!!');
        		redirect('employee/create', 'refresh');
        	}
        } else {
            // false case
            $this->render_template('employee/create', $this->data);
        }	

	}

    public function createModal()
	{
		if(!in_array('createEmployee', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

        $response = array();

		$this->form_validation->set_rules('name', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('personal_id', 'Cédula', 'trim|min_length[11]|max_length[13]');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');

        if ($this->form_validation->run() == TRUE) {
            $new_employee_id = $this->model_employee->getLastEmployeeId();
        	$data = array(
        		'EMP_ID' => $new_employee_id['EMP_ID']+1,
        		'EmployeeName' => clean_data($this->input->post('name')),
        		'PersonalId' => clean_data($this->input->post('personal_id')),
        		'Address' => clean_data($this->input->post('address')),
        		'Designation' => clean_data($this->input->post('designation')),
        		'PhoneNo' => clean_data($this->input->post('phone')),
        		'MobileNo' => clean_data($this->input->post('mobile')),
        		'Email' => clean_data($this->input->post('email')),
        		'Website' => clean_data($this->input->post('website')),
        		'OpeningDate' => date('Y-m-d'),
        		'user_id' => $this->user_id,
        	);
						
        	$create = $this->model_employee->create($data);
        	if($create == true ) {
                $new_employee_id = $this->model_employee->getLastEmployeeId();
				if($_FILES['employee_image']['size'] > 0) {
					$upload_image = $this->upload_employee_image();
					$upload_image = array('image' => $upload_image);

					$this->model_employee->edit($upload_image, $new_employee_id['EMP_ID']);
				}

        		$response['employee_id'] = $new_employee_id['EMP_ID'];
        		$response['name'] = $this->input->post('name');
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
		if(!in_array('updateEmployee', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		if(!$id) {
			$id = $this->input->post('emp_id');
			//redirect('employee', 'refresh');
		}
		
		$this->data['page_title'] = 'ACTUALIZAR EMPLEADO';

		$this->form_validation->set_rules('name', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('personal_id', 'Cédula', 'trim|min_length[11]|max_length[13]');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');

		if ($this->form_validation->run() === FALSE) {
			// false case
			$employee_data = $this->model_employee->getEmployeeData($id);

			$this->data['employee_data'] = $employee_data;

			$this->render_template('employee/edit', $this->data);	
		}
		else {
						
			$update = $this->model_employee->edit($id);
			if($update == true) {
				$this->session->set_flashdata('success', 'Guardado éxitosamente.');
				redirect('employee/', 'refresh');
			}
			else {
				$this->session->set_flashdata('errors', 'Ocurrió un error!!');
				redirect('employee/edit/'.$id, 'refresh');
			}
		}
	}

	public function delete($id)
	{
		if(!in_array('deleteEmployee', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if($id) {
			if($this->input->post('confirm')) {
					$delete = $this->model_employee->delete($id);
					if($delete == true) {
		        		$this->session->set_flashdata('success', 'Eliminado éxitosamente');
		        		redirect('employee/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('error', 'Ocurrió un error!!');
		        		redirect('employee/delete/'.$id, 'refresh');
		        	}

			}	
			else {
				$this->data['EMP_ID'] = $id;
				$this->render_template('employee/delete', $this->data);
			}	
		}
	}
    
    /*
	* It removes the data from the database
	* and it returns the response into the json format
	*/
	public function remove()
	{
		if(!in_array('deleteEmployee', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		$id = $this->input->post('emp_id');

        $response = array();
        if($id) {
            $delete = $this->model_employee->delete($id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Eliminado éxitosamente."; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Ocurrió un error.";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Inténtelo de nuevo.";
        }

        echo json_encode($response); 
	}

	public function profile($id)
	{
		if(!in_array('viewProfile', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
        
        if($id) {
            $employee_data = $this->model_employee->getEmployeeData($id);
            $this->data['employee_data'] = $employee_data;

            $this->render_template('employee/profile', $this->data);
        }
	}

	public function setting()
	{	
		if(!in_array('updateSetting', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$id = $this->session->userdata('id');

		if($id) {
			$this->form_validation->set_rules('name', 'Nombre', 'trim|required');
			$this->form_validation->set_rules('personal_id', 'Cédula', 'trim|min_length[11]|max_length[13]');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');


			if ($this->form_validation->run() == TRUE) {
	            // true case
		        if(empty($this->input->post('name')) && empty($this->input->post('personal_id'))) {
		        	$data = array(
						'EmployeeName' => clean_data($this->input->post('name')),
						'PersonalId' => clean_data($this->input->post('personal_id')),
						'Address' => clean_data($this->input->post('address')),
						'Designation' => clean_data($this->input->post('designation')),
						'PhoneNo' => clean_data($this->input->post('phone')),
						'MobileNo' => clean_data($this->input->post('mobile')),
						'Email' => clean_data($this->input->post('email')),
						'Website' => clean_data($this->input->post('website')),
		        	);

		        	$update = $this->model_employee->edit($data, $id);
		        	if($update == true) {
		        		$this->session->set_flashdata('success', 'Actualizado éxitosamente');
		        		redirect('employee/setting/', 'refresh');
		        	}
		        	else {
		        		$this->session->set_flashdata('errors', 'Ocurrió un error!!');
		        		redirect('employee/setting/', 'refresh');
		        	}
		        }
		        else {

					if($this->form_validation->run() == TRUE) {

						$data = array(
							'EmployeeName' => clean_data($this->input->post('name')),
							'PersonalId' => clean_data($this->input->post('personal_id')),
							'Address' => clean_data($this->input->post('address')),
							'Designation' => clean_data($this->input->post('designation')),
							'PhoneNo' => clean_data($this->input->post('phone')),
							'MobileNo' => clean_data($this->input->post('mobile')),
							'Email' => clean_data($this->input->post('email')),
							'Website' => clean_data($this->input->post('website')),
			        	);

			        	$update = $this->model_employee->edit($data, $id);
			        	if($update == true) {
			        		$this->session->set_flashdata('success', 'Actualizado éxitosamente');
			        		redirect('employee/setting/', 'refresh');
			        	}
			        	else {
			        		$this->session->set_flashdata('errors', 'Ocurrió un error!!');
			        		redirect('employee/setting/', 'refresh');
			        	}
					}
			        else {
			            // false case
			        	$employee_data = $this->model_employee->getEmployeeData($id);

			        	$this->data['employee_data'] = $employee_data;

						$this->render_template('employee/setting', $this->data);	
			        }	

		        }
	        }
	        else {
	            // false case
	        	$employee_data = $this->model_employee->getEmployeeData($id);

	        	$this->data['employee_data'] = $employee_data;

				$this->render_template('employee/setting', $this->data);	
	        }	
		}
	}

	/*
    * This function is invoked from another function to upload the employee image into the assets folder
    * and returns the image path
    */
	public function upload_employee_image()
    {
    	// assets/images/employee_image
        $config['upload_path'] = 'assets/images/employee_image';
        $config['file_name'] =  uniqid();
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1000';
        $config['overwrite'] = TRUE;

        //$config['max_width']  = '1024';
        //$config['max_height']  = '768';

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('employee_image'))
        {
            $error = $this->upload->display_errors();
            return $error;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $type = explode('.', $_FILES['employee_image']['name']);
            $type = $type[count($type) - 1];
            
            $path = $config['upload_path'].'/'.$config['file_name'].'.'.$type;
            return ($data == true) ? $path : false;            
        }
    }
}