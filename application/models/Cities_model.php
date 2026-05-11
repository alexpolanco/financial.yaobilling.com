<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Cities_model extends CI_Model  { 
 
		
	public function __construct()
    {
        $this->load->database();
    }
 		
	public function findAll()
	{
		return $this->db->get('cities')->result();
	}
 		
	public function findAllByDistrict($id)
	{
	    $this->db->select('*');
	    $this->db->from('cities');
		$this->db->where('parent_id',$id);
	    return $this->db->get()->result_array();
	}
 		
	public function findAllWithDistrict()
	{
	    $this->db->select('*');
	    $this->db->from('cities');
	    $this->db->join('district', 'district.district_id = cities.parent_id', 'left');
	    return $this->db->get()->result();
	    
	    /*$query = $this->db->query("SELECT * FROM cities LEFT JOIN district ON district.district_id = cities.parent_id;");
	    return $query->result();*/
	}
		
	public function findOne($id)
	{
		//return $this->db->get('cities')->row_array();
		
		$this->db->select('*');
	    $this->db->from('cities');
	    $this->db->join('district', 'district.district_id = cities.parent_id', 'left');
		$this->db->where('cities_id',$id);
	    return $this->db->get()->row_array();
	}

	public function change_status($id,$mode)
	{
		$data=array('cities_is_active'=>$mode);
		$this->db->where('cities_id',$id);
		$this->db->update('cities',$data);
	}
		
	public function insert($id = 0)
	{
		$data = array(

		'cities_name' => $this->input->post('txt_cities_name'),
		'parent_id' => $this->input->post('txt_district_id'),
		'cities_is_active' => $this->input->post('txt_cities_is_active'),
		'cities_description' => $this->input->post('txt_cities_description')
		
        );
        
        if ($id == 0) {
            return $this->db->insert('cities', $data);
        } else {
            $this->db->where('cities_id', $id);
            return $this->db->update('cities', $data);
        }
	}
	
	public function update_image_f($id,$file_name)
	{
		$data=array('cities_image'=>$file_name);
		$this->db->where('cities_id',$id);
		$this->db->update('cities',$data);
	}

	public function update($id)
	{
		$data = array(

		'cities_name' => $this->input->post('txt_cities_name'),
		'parent_id' => $this->input->post('txt_district_id'),
		'cities_is_active' => $this->input->post('txt_cities_is_active'),
		'cities_description' => $this->input->post('txt_cities_description')
		
        );
        
        if ($id == 0) {
            return $this->db->insert('cities', $data);
        } else {
            $this->db->where('cities_id', $id);
            return $this->db->update('cities', $data);
        }
	}
		
	public function remove($ids)
	{
		$this->db->where('cities_id',$ids);
		$this->db->delete('cities');
	}
 } 
 

?>