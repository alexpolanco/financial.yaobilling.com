<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class District_model extends CI_Model  { 
 
		
	public function __construct()
    {
        $this->load->database();
    }
 		
	public function findAll()
	{
		//$this->db->where('district_id  !=','28');
		return $this->db->get('district')->result();
	}
		
	public function findOne($id)
	{
		$this->db->where('district_id',$id);
		return $this->db->get('district')->row_array();
	}

	public function change_status($id,$mode)
	{
		$data=array('district_is_active'=>$mode);
		$this->db->where('district_id',$id);
		$this->db->update('district',$data);
	}
		
	public function insert($id = 0)
	{
		$data = array(

		'district_name' => $this->input->post('txt_district_name'),
		'district_is_active' => $this->input->post('txt_district_is_active'),
		'district_description' => $this->input->post('txt_district_description')
		
        );
        
        if ($id == 0) {
            return $this->db->insert('district', $data);
        } else {
            $this->db->where('district_id', $id);
            return $this->db->update('district', $data);
        }
	}
	
	public function update_image_f($id,$file_name)
	{
		$data=array('district_image'=>$file_name);
		$this->db->where('district_id',$id);
		$this->db->update('district',$data);
	}

	public function update($id)
	{
		$data = array(

		'district_name' => $this->input->post('txt_district_name'),
		'district_description' => $this->input->post('txt_district_description')
		
        );
        
        if ($id == 0) {
            return $this->db->insert('district', $data);
        } else {
            $this->db->where('district_id', $id);
            return $this->db->update('district', $data);
        }
	}
		
	public function remove($ids)
	{
		$this->db->where('district_id',$ids);
		$this->db->delete('district');
	}
 } 
 

?>