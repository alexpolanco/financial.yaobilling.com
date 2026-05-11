<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');

class Cities extends MY_Controller  { 

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
		$this->load->model('cities_model');
		$this->load->model('district_model');
	}

	// index method
	public function index()
	{
		$data['recored'] = $this->cities_model->findAllWithDistrict();
		$this->load->view('admin/cities/cities-list',$data);
	}
	
	public function district($id)
	{
		$data['data'] = $this->cities_model->findAllByDistrict($id);
		//return json_encode($data);
		return $data;
	}

	// pdf method
	public function pdf()
	{
		$data['recored'] = $this->cities_model->findAllWithDistrict();
		$this->load->view('admin/cities/cities-pdf',$data);
	}

	// excel method
	public function excel()
	{
		$data['recored'] = $this->cities_model->findAllWithDistrict();
		$this->load->view('admin/cities/cities-excel',$data);
	}

	// Create method
	public function create()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('txt_cities_name', 'Ciudad', 'required');
		$this->form_validation->set_rules('txt_cities_is_active', 'Está activa', 'required');

		if ($this->form_validation->run() === FALSE)
		{
		    $data['district'] = $this->district_model->findAll();
			$this->load->view('admin/cities/cities-add', $data);
		}
		else
		{
			$this->cities_model->insert();
			$this->session->set_flashdata('msg','Datos actualizados exitosamente');
			$this->index();

			/*$file_info = $this->file_upload_m('txt_cities_image',$this->db->insert_id());
			if(is_array($file_info))
			{
				$file_name = $file_info['file_name'];
				if($file_name != ''){
					$this->cities_model->update_image_f($this->db->insert_id(),$file_name);
				}
				$this->session->set_flashdata('msg','Datos actualizados exitosamente');
				$this->index();
			}
			else
			{
				$error = $file_info;
				$data['error'] = $error;
				$this->load->view('admin/cities/cities-add',$data);
			}*/
		}
	}

	// update method
	public function update($id)
	{
		$this->cities_model->update($id);
		$this->session->set_flashdata('msg','Datos actualizados exitosamente');
		$this->index();
		
		/*$file_info =$this->file_upload_m('txt_cities_image',$id);
		if(is_array($file_info))
		{
			$file_name = $file_info['file_name'];
			if($file_name != ''){
				$this->cities_model->update_image_f($id,$file_name);
			}
			$this->session->set_flashdata('msg','Datos actualizados exitosamente');
			$this->index();
		}
		else
		{
			$error = $file_info;
			$data['recored'] = $this->cities_model->findOne($id);
			$data['error'] = $error;
			$this->load->view('admin/cities/cities-edit',$data);
		}*/
	}

	//get_name_sub
	public function get_name_sub($id)
	{
		$data['sin']=$this->cities_model->findOne($id);
		return $data['sin']['cities_name'];
	}

	// edit method
	public function edit($id)
	{
		$data['district'] = $this->district_model->findAll();
		$data['recored'] = $this->cities_model->findOne($id);
		$this->load->view('admin/cities/cities-edit',$data);
	}

	// delete method
	public function delete($id)
	{
		if($this->session->userdata('userid') != 1)
		{
			$rights = $this->check_rights();
			if(!in_array('cities/delete', $rights))
			{
				return redirect('access');
			}
			else
			{
				$this->cities_model->remove($id);
				$this->session->set_flashdata('msg','Datos eliminados exitosamente');

				return redirect('cities');
			}
		}
		else
		{
			$this->cities_model->remove($id);
			$this->session->set_flashdata('msg','Datos eliminados exitosamente');

			return redirect('cities');
		}
	}


	public function active_inactive($id,$mode)
	{
		$this->cities_model->change_status($id,$mode);
		return redirect('cities');
	}

	public function file_upload_m($file_name,$new_name)
	{
		$config['upload_path']          = './file/subcities/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['file_name'] 			= $new_name;
		$config['overwrite'] 		= TRUE;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($file_name))
		{
			return  $data = $this->upload->display_errors();
		}
		else
		{
			return  $data = $this->upload->data();
		}
		
	}
} 
?>