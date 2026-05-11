<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getloanstype extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
    }

	// Show view Page
	public function index(){

		$query = $this->db->query('select * from loanstype where  company_id=' . $this->session->userdata('company_id') . ' AND loanstype_is_active = "yes"');

		foreach ($query->result() as $row)
		{
		echo '<a id="loanstype_'.$row->loanstype_id.'" class="btn btn-block table_row" onclick="setloanstype('.$row->loanstype_id.',\''.$row->loanstype_name.'\','.$row->loanstype_duration.',\''.$row->loanstype_frequency.'\','.$row->loanstype_interes.')">'.$row->loanstype_name.'</a>';
		}
	}
}

?>