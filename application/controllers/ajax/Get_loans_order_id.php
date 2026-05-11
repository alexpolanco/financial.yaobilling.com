<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// user login check and bill number add		
class get_loans_order_id extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');

		$this->load->database();
	     
    }

	// Show view Page
	public function index(){


		$ad_id = $this->session->userdata('userid');
		$b_res = $this->db->query("SELECT loans_id, loans_no FROM loans WHERE user_id =".$ad_id." ORDER BY loans_id DESC LIMIT 1");

		foreach ($b_res->result() as $row)
		{
			echo $row->loans_no;
		}

	}

}
	
?>