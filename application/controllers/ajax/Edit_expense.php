<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// add customer
class edit_expense extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	     
    }

	// Show view Page
	public function index(){

		//$PaidDate = ($this->input->post('edit_PaidDate') != "") ? date('Y-m-d', strtotime($this->input->post('edit_PaidDate'))) : "";

		$id = $_GET['id'];
		$edit_Description = $_GET['edit_Description'];
		$edit_Amount = $_GET['edit_Amount'];
		$edit_PaidDate = $_GET['edit_PaidDate'];

		if($edit_Description != '' && $edit_Amount != '' && $PaidDate != '')
		{
			$q = "UPDATE expense SET Description = '".$edit_Description."',Amount = '".$edit_Amount."',PaidDate='".$PaidDate."' WHERE Expense_ID = ".$id;

			$this->db->query($q);
			if($this->db->affected_rows())
			{
				echo 'Gasto actualizado exitosamente';
			}

		}
	}

}
?>