<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getexpense extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}

	// Show view Page
	public function index(){

		$id = $this->input->get('id');
		
		$sql = "SELECT * FROM expense WHERE company_id = ".$this->session->userdata('company_id')." AND Expense_ID = ? ORDER BY PaidDate DESC";
		$query = $this->db->query($sql, array($id));

		//$result = array('data' => array());

		foreach ($query->result() as $row)
		{
			$result['PaidDate'] = $row->PaidDate;
			$result['Description'] = $row->Description;
			$result['Amount'] = $row->Amount;
		}
		echo json_encode($result);
	}
}

?>