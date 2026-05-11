<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getcollector extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
    }

	// Show view Page
	public function index(){

		$id = $this->input->get('id');
		
		$query = $this->db->query('select * from collector where company_id=' . $this->session->userdata('company_id') . ' AND collector_is_active = "yes"');

		foreach ($query->result() as $row)
		{
			echo '<a id="collector_'.$row->collector_id.'" class="btn btn-block table_row" onclick="setcollector('.$row->collector_id.',\''.$row->collector_first_name.'\')">'.$row->collector_first_name.'</a>';
		}
	}
}

?>