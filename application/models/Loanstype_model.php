<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Loanstype_model extends CI_Model  { 
		
	public function __construct()
	{
		$this->load->database();
	}
	
	public function findAll()
	{
		$this->db->where('company_id', $this->session->userdata('company_id'));
		return $this->db->get('loanstype')->result();
	}
		
	public function findOne($id)
	{
		$this->db->select('*');
		$this->db->from('loanstype');
		$this->db->where('loanstype_id',$id);
		$this->db->where('company_id', $this->session->userdata('company_id'));
		return $this->db->get()->row_array();
	}

	public function change_status($id,$mode)
	{
		$data=array('loanstype_is_active'=>$mode);
		$this->db->where('loanstype_id',$id);
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->update('loanstype',$data);
	}
		
	public function insert($id = 0)
	{
		$data = array(

		'loanstype_name' => $this->input->post('txt_loanstype_name'),
		'loanstype_frequency' => $this->input->post('txt_loanstype_frequency'),
		'loanstype_interes' => $this->input->post('txt_loanstype_interes'),
		'loanstype_duration' => $this->input->post('txt_loanstype_duration'),
		'loanstype_type' => $this->input->post('txt_loanstype_type'),
		'loanstype_is_active' => $this->input->post('txt_loanstype_is_active'),

		);
		//$this->db->where('company_id', $this->session->userdata('company_id'));

		if ($id == 0) {
			return $this->db->insert('loanstype', $data);
		} else {
			$this->db->where('loanstype_id', $id);
			return $this->db->update('loanstype', $data);
		}
	}
	
	public function update_image_f($id,$file_name)
	{
		$data=array('loanstype_image'=>$file_name);
		$this->db->where('loanstype_id',$id);
		$this->db->update('loanstype',$data);
	}

	public function update($id)
	{
		$data = array(

		'loanstype_name' => $this->input->post('txt_loanstype_name'),
		'loanstype_frequency' => $this->input->post('txt_loanstype_frequency'),
		'loanstype_interes' => $this->input->post('txt_loanstype_interes'),
		'loanstype_duration' => $this->input->post('txt_loanstype_duration'),
		'loanstype_type' => $this->input->post('txt_loanstype_type'),
		'loanstype_is_active' => $this->input->post('txt_loanstype_is_active'),

		);
		$this->db->where('company_id', $this->session->userdata('company_id'));

		if ($id == 0) {
			return $this->db->insert('loanstype', $data);
		} else {
			$this->db->where('loanstype_id', $id);
			return $this->db->update('loanstype', $data);
		}
	}
		
	public function remove($ids)
	{
		$this->db->where('loanstype_id',$ids);
		$this->db->where('company_id', $this->session->userdata('company_id'));

		$this->db->delete('loanstype');
	}
} 


?>