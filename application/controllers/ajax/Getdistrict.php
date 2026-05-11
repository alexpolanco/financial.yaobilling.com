<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getdistrict extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
    }

	// Show view Page
	public function index(){

		$id = $this->input->get('id');
		
		$query = $this->db->query('select * from district where district_is_active = "yes"');

		foreach ($query->result() as $row)
		{
			echo '<a id="district_'.$row->district_id.'" class="btn btn-app table_row" onclick="getdistrict('.$id.','.$row->district_id.')">'.$row->district_name.'</a>';
		}
	}
}

?>