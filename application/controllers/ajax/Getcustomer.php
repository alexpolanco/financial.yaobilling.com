<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getcustomer extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
    }

	// Show view Page
	public function index(){

		$id = $this->input->get('id');
		
		$query = $this->db->query('select * from customer where company_id=' . $this->session->userdata('company_id') . ' AND customer_is_active = "yes"');

		foreach ($query->result() as $row)
		{
			echo '<a id="customer_'.$row->customer_id.'" class="btn btn-block table_row" onclick="setcustomer('.$row->customer_id.',\''.$row->customer_first_name.'\')">'.$row->customer_first_name.'</a>';
		}
	}
}

?>