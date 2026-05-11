<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Users_model extends CI_Model  { 
		
	public function __construct()
	{
		$this->load->database();
	}
	
	public function findAll()
	{
		//$this->db->where('user_id !=',1);
		$this->db->join('cities', 'users.user_city = cities.cities_id and users.company_id = cities.company_id', 'left');
		
		if ($this->session->userdata('company_id') != 1) {
			$this->db->where('users.company_id', $this->session->userdata('company_id'));
		}

		return $this->db->get('users')->result();
	}
		
	public function findOne($id)
	{
		$this->db->where('user_id',$id);
		if ($this->session->userdata('company_id') != 1) {
			$this->db->where('users.company_id', $this->session->userdata('company_id'));
		}
		return $this->db->get('users')->row_array();
	}
		
	public function change_status($id,$mode)
	{
		$data=array('user_active'=>$mode);
		$this->db->where('user_id',$id);

		if ($this->session->userdata('company_id') != 1) {
			$this->db->where('users.company_id', $this->session->userdata('company_id'));
		}
		
		$this->db->update('users',$data);
	}
		
	public function change_password($id)
	{
		$data=array('password'=>base64_encode($this->input->post('txt_password')));
		$this->db->where('password',base64_encode($this->input->post('old_password')));
		$this->db->where('user_id',$id);

		if ($this->session->userdata('company_id') != 1) {
			$this->db->where('users.company_id', $this->session->userdata('company_id'));
		}

		$this->db->update('users',$data);
	}

	public function insert($id = 0)
	{
		$data = array(

		'company_id' => $this->session->userdata('company_id'),
		'user_group_id' => $this->input->post('txt_user_group_id'),
		'user_name' => $this->input->post('txt_user_name'),
		'password' => base64_encode($this->input->post('txt_password')),
		'user_active' => $this->input->post('txt_user_active'),
		
		'user_fullname' => $this->input->post('txt_user_fullname'),
		'user_personalid' => $this->input->post('txt_user_personal_id'),
		'user_nickname' => $this->input->post('txt_user_nickname'),
		'user_email' => $this->input->post('txt_user_email'),
		'user_address' => $this->input->post('txt_user_address'),
		'user_city' => $this->input->post('txt_user_city'),
		//'user_zipcode' => $this->input->post('txt_user_zipcode'),
		'user_phone' => $this->input->post('txt_user_phone'),
		
		'user_occupation' => $this->input->post('txt_user_occupation'),
		'user_workplace' => $this->input->post('txt_user_workplace'),
		'user_workphone' => $this->input->post('txt_user_workphone'),
		'user_workaddress' => $this->input->post('txt_user_workaddress'),
		
		'contact_person' => $this->input->post('txt_contact_person'),
		'contact_person_phone' => $this->input->post('txt_contact_person_phone')
		
		);

		if ($this->session->userdata('company_id') != 1) {
			$this->db->where('users.company_id', $this->session->userdata('company_id'));
		}

		if ($id == 0) {
			return $this->db->insert('users', $data);
		} else {
			$this->db->where('user_id', $id);
			return $this->db->update('users', $data);
		}
	}

	public function insert_rights($id)
	{
		$this->db->where('user_id',$id);
		if ($this->session->userdata('company_id') != 1) {
			$this->db->where('users.company_id', $this->session->userdata('company_id'));
		}
		$this->db->delete('rights');
		
		$component_count = 24;
		for($i=1;$i<=$component_count;$i++)
		{
			for($j=1;$j<=10;$j++)
			{
				if(isset($_POST['chk'.$j.'_'.$i]) && $_POST['chk'.$j.'_'.$i] != "")
				{

					if ($this->session->userdata('company_id') != 1) {
						$data = array(
							'user_id' => $id,
							'company_id' => $this->session->userdata('company_id'),
							'rights' => $this->input->post('chk'.$j.'_'.$i),
						);
					}
					else {
						$data = array(
							'user_id' => $id,
							'rights' => $this->input->post('chk'.$j.'_'.$i),
						);
					}
					
					$this->db->insert('rights', $data);
				}
			}
		}

	}
		
	public function update($id)
	{
		$data = array(

		'user_group_id' => $this->input->post('txt_user_group_id'),
		'user_name' => $this->input->post('txt_user_name'),
		'user_active' => $this->input->post('txt_user_active'),
		
		'user_fullname' => $this->input->post('txt_user_fullname'),
		'user_personalid' => $this->input->post('txt_user_personal_id'),
		'user_nickname' => $this->input->post('txt_user_nickname'),
		'user_email' => $this->input->post('txt_user_email'),
		'user_address' => $this->input->post('txt_user_address'),
		'user_city' => $this->input->post('txt_user_city'),
		//'user_zipcode' => $this->input->post('txt_user_zipcode'),
		'user_phone' => $this->input->post('txt_user_phone'),
		
		'user_occupation' => $this->input->post('txt_user_occupation'),
		'user_workplace' => $this->input->post('txt_user_workplace'),
		'user_workphone' => $this->input->post('txt_user_workphone'),
		'user_workaddress' => $this->input->post('txt_user_workaddress'),
		
		'contact_person' => $this->input->post('txt_contact_person'),
		'contact_person_phone' => $this->input->post('txt_contact_person_phone')
		
		);
		
		if ($this->session->userdata('company_id') != 1) {
			$this->db->where('users.company_id', $this->session->userdata('company_id'));
		}
		
		if ($id == 0) {
			return $this->db->insert('users', $data);
		} else {
			$this->db->where('user_id', $id);
			return $this->db->update('users', $data);
		}
	}

	public function remove($ids)
	{
		$this->db->where('user_id',$ids);
		if ($this->session->userdata('company_id') != 1) {
			$this->db->where('users.company_id', $this->session->userdata('company_id'));
		}
		$this->db->delete('rights');

		$this->db->where('user_id',$ids);
		if ($this->session->userdata('company_id') != 1) {
			$this->db->where('users.company_id', $this->session->userdata('company_id'));
		}
		$this->db->delete('users');
	}
} 


?>