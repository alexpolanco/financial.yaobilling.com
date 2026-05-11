<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Collector_model extends CI_Model  { 

		
	public function __construct()
	{
		$this->load->database();
	}

	public function findAll()
	{
		$this->db->where('company_id', $this->session->userdata('company_id'));
		return $this->db->get('collector')->result();
	}
		
	public function findOne($id)
	{
		$this->db->where('collector_id',$id);
		$this->db->where('company_id', $this->session->userdata('company_id'));
		return $this->db->get('collector')->row_array();
	}

	public function change_status($id,$mode)
	{
		$data=array('collector_is_active'=>$mode);
		$this->db->where('collector_id',$id);
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->update('collector',$data);
	}
		
	public function insert($id = 0)
	{
		$data = array(

		'collector_first_name' => $this->input->post('txt_collector_first_name'),
		'collector_personalid' => $this->input->post('txt_collector_personal_id'),
		'collector_nickname' => $this->input->post('txt_collector_nickname'),
		'collector_email' => $this->input->post('txt_collector_email'),
		'collector_address' => $this->input->post('txt_collector_address'),
		'collector_city' => $this->input->post('txt_collector_city'),
		'collector_zipcode' => $this->input->post('txt_collector_zipcode'),
		'collector_phone' => $this->input->post('txt_collector_phone'),
		
		'collector_occupation' => $this->input->post('txt_collector_occupation'),
		'collector_workplace' => $this->input->post('txt_collector_workplace'),
		'collector_workphone' => $this->input->post('txt_collector_workphone'),
		'collector_workaddress' => $this->input->post('txt_collector_workaddress'),
		
		'contact_person' => $this->input->post('txt_contact_person'),
		'collector_is_active' => $this->input->post('txt_collector_is_active'),
		'contact_person_phone' => $this->input->post('txt_contact_person_phone')
		
		);
		$this->db->where('company_id', $this->session->userdata('company_id'));

		if ($id == 0) {
			return $this->db->insert('collector', $data);
		} else {
			$this->db->where('collector_id', $id);
			return $this->db->update('collector', $data);
		}
	}
		
	public function update($id)
	{
		$data = array(

		'collector_first_name' => $this->input->post('txt_collector_first_name'),
		'collector_personalid' => $this->input->post('txt_collector_personal_id'),
		'collector_nickname' => $this->input->post('txt_collector_nickname'),

		'collector_email' => $this->input->post('txt_collector_email'),
		'collector_birthdate' => $this->input->post('txt_collector_birthdate'),
		'collector_address' => $this->input->post('txt_collector_address'),
		'collector_city' => $this->input->post('txt_collector_city'),
		'collector_zipcode' => $this->input->post('txt_collector_zipcode'),
		'collector_phone' => $this->input->post('txt_collector_phone'),
		
		'collector_occupation' => $this->input->post('txt_collector_occupation'),
		'collector_workplace' => $this->input->post('txt_collector_workplace'),
		'collector_workphone' => $this->input->post('txt_collector_workphone'),
		'collector_workaddress' => $this->input->post('txt_collector_workaddress'),
		
		'contact_person' => $this->input->post('txt_contact_person'),
		'contact_person_phone' => $this->input->post('txt_contact_person_phone'),
		'collector_is_active' => $this->input->post('txt_collector_is_active')

	);
	$this->db->where('company_id', $this->session->userdata('company_id'));

		if ($id == 0) {
			return $this->db->insert('collector', $data);
		} else {
			$this->db->where('collector_id', $id);
			return $this->db->update('collector', $data);
		}
	}
		
	public function remove($ids)
	{
		$this->db->where('collector_id',$ids);
		$this->db->delete('collector');
	}
} 

?>