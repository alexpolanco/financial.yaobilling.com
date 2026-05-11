<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Guarantor_model extends CI_Model  { 
		
	public function __construct()
	{
		$this->load->database();
	}
	
	public function findAll()
	{
		$this->db->select('guarantor.*');
		$this->db->from('guarantor');
		$this->db->join('cities', 'guarantor.guarantor_city = cities.cities_id', 'left');
		$this->db->where('guarantor.company_id', $this->session->userdata('company_id'));
		$this->db->order_by('guarantor.guarantor_first_name', 'ASC');

		return $this->db->get()->result();
		//return $this->db->get('guarantor')->result();
	}
		
	public function findOne($id)
	{
		$this->db->where('guarantor_id', $id);
		$this->db->where('company_id', $this->session->userdata('company_id'));
		return $this->db->get('guarantor')->row_array();
	}

	public function findNextGuarantorID()
	{	
		$query = $this->db->query("SELECT MAX(guarantor_id) as next_id FROM guarantor WHERE company_id = '". $this->session->userdata('company_id')."'");
		$data = $query->row_array();

		return $data['next_id'] + 1;	
	}

	public function change_status($id,$mode)
	{
		$data=array('guarantor_is_active'=>$mode);
		$this->db->where('guarantor_id',$id);
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->update('guarantor',$data);
	}
		
	public function insert($id = 0)
	{
		$new_guarantor_id = $this->findNextGuarantorID();

		$data = array(
			'company_id' => $this->session->userdata('company_id'),

			'guarantor_id' => $new_guarantor_id,
			'guarantor_first_name' => $this->input->post('txt_guarantor_first_name'),
			'guarantor_personalid' => $this->input->post('txt_guarantor_personal_id'),
			'guarantor_nickname' => $this->input->post('txt_guarantor_nickname'),
			'guarantor_gender' => $this->input->post('txt_guarantor_gender'),
			'guarantor_civilstatus' => $this->input->post('txt_guarantor_civilstatus'),
			'guarantor_email' => $this->input->post('txt_guarantor_email'),
			'guarantor_address' => $this->input->post('txt_guarantor_address'),
			'guarantor_nationality' => $this->input->post('txt_guarantor_nationality'),
			'guarantor_city' => $this->input->post('txt_guarantor_city'),
			'guarantor_zipcode' => $this->input->post('txt_guarantor_zipcode'),
			'guarantor_phone' => $this->input->post('txt_guarantor_phone'),
			
			'guarantor_occupation' => $this->input->post('txt_guarantor_occupation'),
			'guarantor_workplace' => $this->input->post('txt_guarantor_workplace'),
			'guarantor_workphone' => $this->input->post('txt_guarantor_workphone'),
			'guarantor_workaddress' => $this->input->post('txt_guarantor_workaddress'),
			
			'contact_person' => $this->input->post('txt_contact_person'),
			'guarantor_is_active' => $this->input->post('txt_guarantor_is_active'),
			'contact_person_phone' => $this->input->post('txt_contact_person_phone'),
			'guarantor_pin' => $this->input->post('txt_guarantor_pin')
		);
		
		//$this->db->where('company_id', $this->session->userdata('company_id'));

		if ($id == 0) {
			return $this->db->insert('guarantor', $data);
		} else {
			$this->db->where('guarantor_id', $id);
			return $this->db->update('guarantor', $data);
		}
	}
		
	public function update($id)
	{
		$data = array(

			'guarantor_first_name' => $this->input->post('txt_guarantor_first_name'),
			'guarantor_personalid' => $this->input->post('txt_guarantor_personal_id'),
			'guarantor_nickname' => $this->input->post('txt_guarantor_nickname'),

			'guarantor_email' => $this->input->post('txt_guarantor_email'),
			'guarantor_birthdate' => $this->input->post('txt_guarantor_birthdate'),
			'guarantor_gender' => $this->input->post('txt_guarantor_gender'),
			'guarantor_civilstatus' => $this->input->post('txt_guarantor_civilstatus'),
			'guarantor_nationality' => $this->input->post('txt_guarantor_nationality'),
			'guarantor_address' => $this->input->post('txt_guarantor_address'),
			'guarantor_city' => $this->input->post('txt_guarantor_city'),
			'guarantor_zipcode' => $this->input->post('txt_guarantor_zipcode'),
			'guarantor_phone' => $this->input->post('txt_guarantor_phone'),
			
			'guarantor_occupation' => $this->input->post('txt_guarantor_occupation'),
			'guarantor_workplace' => $this->input->post('txt_guarantor_workplace'),
			'guarantor_workphone' => $this->input->post('txt_guarantor_workphone'),
			'guarantor_workaddress' => $this->input->post('txt_guarantor_workaddress'),
			
			'contact_person' => $this->input->post('txt_contact_person'),
			'contact_person_phone' => $this->input->post('txt_contact_person_phone'),
			'guarantor_is_active' => $this->input->post('txt_guarantor_is_active'),
			'guarantor_pin' => $this->input->post('txt_guarantor_pin')

		);

		$this->db->where('company_id', $this->session->userdata('company_id'));

		if ($id == 0) {
			return $this->db->insert('guarantor', $data);
		} else {
			$this->db->where('guarantor_id', $id);
			return $this->db->update('guarantor', $data);
		}
	}
		
	public function remove($ids)
	{
		$this->db->where('guarantor_id',$ids);
		$this->db->where('company_id', $this->session->userdata('company_id'));

		$this->db->delete('guarantor');
	}
} 

?>