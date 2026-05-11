<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Customer_model extends CI_Model  { 
		
	public function __construct()
	{
		$this->load->database();
	}
	
	public function findAll()
	{
		$this->db->select('customer.*');
		$this->db->from('customer');
		$this->db->join('cities', 'customer.customer_city = cities.cities_id', 'left');
		$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->order_by('customer.customer_first_name', 'ASC');

		return $this->db->get()->result();
		//return $this->db->get('customer')->result();
	}
		
	public function findOne($id)
	{
		$this->db->where('customer_id', $id);
		$this->db->where('company_id', $this->session->userdata('company_id'));
		return $this->db->get('customer')->row_array();
	}

	public function findNextCustomerID()
	{	
		$query = $this->db->query("SELECT MAX(customer_id) as next_id FROM customer WHERE company_id = '". $this->session->userdata('company_id')."'");
		$data = $query->row_array();

		return $data['next_id'] + 1;	
	}

	public function change_status($id,$mode)
	{
		$data=array('customer_is_active'=>$mode);
		$this->db->where('customer_id',$id);
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->update('customer',$data);
	}
		
	public function insert($id = 0)
	{
		$new_customer_id = $this->findNextCustomerID();

		$data = array(
			'company_id' => $this->session->userdata('company_id'),

			'customer_id' => $new_customer_id,
			'customer_first_name' => $this->input->post('txt_customer_first_name'),
			'customer_personalid' => $this->input->post('txt_customer_personal_id'),
			'customer_nickname' => $this->input->post('txt_customer_nickname'),
			'customer_gender' => $this->input->post('txt_customer_gender'),
			'customer_civilstatus' => $this->input->post('txt_customer_civilstatus'),
			'customer_email' => $this->input->post('txt_customer_email'),
			'customer_address' => $this->input->post('txt_customer_address'),
			'customer_nationality' => $this->input->post('txt_customer_nationality'),
			'customer_city' => $this->input->post('txt_customer_city'),
			'customer_zipcode' => $this->input->post('txt_customer_zipcode'),
			'customer_phone' => $this->input->post('txt_customer_phone'),
			
			'customer_occupation' => $this->input->post('txt_customer_occupation'),
			'customer_workplace' => $this->input->post('txt_customer_workplace'),
			'customer_workphone' => $this->input->post('txt_customer_workphone'),
			'customer_workaddress' => $this->input->post('txt_customer_workaddress'),
			
			'contact_person' => $this->input->post('txt_contact_person'),
			'customer_is_active' => $this->input->post('txt_customer_is_active'),
			'contact_person_phone' => $this->input->post('txt_contact_person_phone'),
			'customer_pin' => $this->input->post('txt_customer_pin')
		);
		
		//$this->db->where('company_id', $this->session->userdata('company_id'));

		if ($id == 0) {
			return $this->db->insert('customer', $data);
		} else {
			$this->db->where('customer_id', $id);
			return $this->db->update('customer', $data);
		}
	}
		
	public function update($id)
	{
		$data = array(

			'customer_first_name' => $this->input->post('txt_customer_first_name'),
			'customer_personalid' => $this->input->post('txt_customer_personal_id'),
			'customer_nickname' => $this->input->post('txt_customer_nickname'),

			'customer_email' => $this->input->post('txt_customer_email'),
			'customer_birthdate' => $this->input->post('txt_customer_birthdate'),
			'customer_gender' => $this->input->post('txt_customer_gender'),
			'customer_civilstatus' => $this->input->post('txt_customer_civilstatus'),
			'customer_nationality' => $this->input->post('txt_customer_nationality'),
			'customer_address' => $this->input->post('txt_customer_address'),
			'customer_city' => $this->input->post('txt_customer_city'),
			'customer_zipcode' => $this->input->post('txt_customer_zipcode'),
			'customer_phone' => $this->input->post('txt_customer_phone'),
			
			'customer_occupation' => $this->input->post('txt_customer_occupation'),
			'customer_workplace' => $this->input->post('txt_customer_workplace'),
			'customer_workphone' => $this->input->post('txt_customer_workphone'),
			'customer_workaddress' => $this->input->post('txt_customer_workaddress'),
			
			'contact_person' => $this->input->post('txt_contact_person'),
			'contact_person_phone' => $this->input->post('txt_contact_person_phone'),
			'customer_is_active' => $this->input->post('txt_customer_is_active'),
			'customer_pin' => $this->input->post('txt_customer_pin')

		);

		$this->db->where('company_id', $this->session->userdata('company_id'));

		if ($id == 0) {
			return $this->db->insert('customer', $data);
		} else {
			$this->db->where('customer_id', $id);
			return $this->db->update('customer', $data);
		}
	}
		
	public function remove($ids)
	{
		$this->db->where('customer_id',$ids);
		$this->db->where('company_id', $this->session->userdata('company_id'));

		$this->db->delete('customer');
	}
} 

?>