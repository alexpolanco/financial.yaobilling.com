<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Routes_model extends CI_Model  { 
		
	public function __construct()
	{
		$this->load->database();
	}

	public function findAll()
	{
		$this->db->join('collector', 'collector.collector_id = routes.collector_id', 'left');
		$this->db->where('routes.company_id', $this->session->userdata('company_id'));
		return $this->db->get('routes')->result();
	}
	

	public function findAllWithDistrict()
	{
		$this->db->select('*');
		$this->db->from('routes');
		$this->db->join('collector', 'collector.collector_id = routes.collector_id', 'left');
		$this->db->join('loanstype', 'loanstype.loanstype_id = routes.loanstype_id', 'left');
		$this->db->join('district', 'district.district_id = routes.district_id', 'left');
		$this->db->join('cities', 'cities.cities_id = routes.cities_id', 'left');
		$this->db->where('routes.company_id', $this->session->userdata('company_id'));
		return $this->db->get()->result();
		
		/*$query = $this->db->query("SELECT * FROM routes LEFT JOIN district ON district.district_id = routes.parent_id;");
		return $query->result();*/
	}
		
	public function findOne($id)
	{
		//return $this->db->get('routes')->row_array();
		
		$this->db->select('*');
		$this->db->from('routes');
		$this->db->join('collector', 'collector.collector_id = routes.collector_id', 'left');
		$this->db->join('loanstype', 'loanstype.loanstype_id = routes.loanstype_id', 'left');
		$this->db->join('district', 'district.district_id = routes.district_id', 'left');
		$this->db->join('cities', 'cities.cities_id = routes.cities_id', 'left');
		$this->db->where('routes_id',$id);
		$this->db->where('routes.company_id', $this->session->userdata('company_id'));
		return $this->db->get()->row_array();
	}

	public function change_status($id,$mode)
	{
		$data=array('routes_is_active'=>$mode);
		$this->db->where('routes_id',$id);
		$this->db->where('routes.company_id', $this->session->userdata('company_id'));
		$this->db->update('routes',$data);
	}
		
	public function insert($id = 0)
	{
		$data = array(

		'routes_name' => $this->input->post('txt_routes_name'),
		'district_id' => $this->input->post('txt_district_id'),
		'cities_id' => $this->input->post('txt_cities_id'),
		'collector_id' => $this->input->post('txt_collector_id'),
		'collector_aux_id' => $this->input->post('txt_collector_aux_id'),
		'loanstype_id' => $this->input->post('txt_loanstype_id'),
		'routes_is_active' => $this->input->post('txt_routes_is_active'),
		'routes_description' => $this->input->post('txt_routes_description')
	
		);
		$this->db->where('routes.company_id', $this->session->userdata('company_id'));

		if ($id == 0) {
			return $this->db->insert('routes', $data);
		} else {
			$this->db->where('routes_id', $id);
			return $this->db->update('routes', $data);
		}
	}
	
	public function update_image_f($id,$file_name)
	{
		$data=array('routes_image'=>$file_name);
		$this->db->where('routes_id',$id);
		$this->db->update('routes',$data);
	}

	public function update($id)
	{
		$data = array(

		'routes_name' => $this->input->post('txt_routes_name'),
		'district_id' => $this->input->post('txt_district_id'),
		'cities_id' => $this->input->post('txt_cities_id'),
		'collector_id' => $this->input->post('txt_collector_id'),
		'collector_aux_id' => $this->input->post('txt_collector_aux_id'),
		'loanstype_id' => $this->input->post('txt_loanstype_id'),
		'routes_is_active' => $this->input->post('txt_routes_is_active'),
		'routes_description' => $this->input->post('txt_routes_description')
		
		);
		$this->db->where('routes.company_id', $this->session->userdata('company_id'));

		if ($id == 0) {
			return $this->db->insert('routes', $data);
		} else {
			$this->db->where('routes_id', $id);
			return $this->db->update('routes', $data);
		}
	}
		
	public function remove($ids)
	{
		$this->db->where('routes_id',$ids);
		$this->db->where('routes.company_id', $this->session->userdata('company_id'));
		$this->db->delete('routes');
	}
} 


?>