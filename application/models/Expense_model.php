<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		//$this->USER_ID = $this->session->userdata('userid');
		//".$this->session->userdata('company_id')." = ".$this->session->userdata('company_id').";
	}

	public function findAll()
	{
		$this->db->select('expense.*');
		$this->db->from('expense');
		$this->db->where('expense.company_id', $this->session->userdata('company_id'));

		return $this->db->get()->result();
	}
		
	public function findOne($id)
	{
		$this->db->where('Expense_ID', $id);
		$this->db->where('company_id', $this->session->userdata('company_id'));
		return $this->db->get('expense')->row_array();
	}

	public function findNextexpenseID()
	{	
		$query = $this->db->query("SELECT MAX(Expense_ID) as next_id FROM expense WHERE company_id = '".$this->session->userdata('company_id')."'");
		$data = $query->row_array();

		return $data['next_id'] + 1;	
	}

	public function findExpense($dateform, $dateto)
	{
		$this->db->select('"'.$dateform.'" as datefrom, "'.$dateto.'" as dateto,
		expense.* FROM expense WHERE company_id="'.$this->session->userdata('company_id').'" AND PaidDate BETWEEN "'.$dateform.'" AND "'.$dateto.'" '); 

		return $this->db->get()->result();
	}

	public function change_status($id,$mode)
	{
		$data=array('expense_is_active'=>$mode);
		$this->db->where('Expense_ID',$id);
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->update('expense',$data);
	}

	/* get active brand infromation */
	public function getActiveExpense()
	{
		$sql = "SELECT * FROM expense WHERE company_id = ".$this->session->userdata('company_id')." ORDER BY PaidDate DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getLastExpenseId()
	{
		$sql = "SELECT MAX(Expense_ID) Expense_ID FROM expense WHERE company_id = ".$this->session->userdata('company_id')." ORDER BY PaidDate DESC";
		$query = $this->db->query($sql, array(1));
		return $query->row_array();
	}
	
	/* get the brand data */
	public function getExpenseData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM expense WHERE company_id = ".$this->session->userdata('company_id')." AND Expense_ID = ? ORDER BY PaidDate DESC";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM expense WHERE company_id = ".$this->session->userdata('company_id')." ORDER BY PaidDate DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getExpenseName($id = null)
	{
		$sql = "SELECT name FROM expense WHERE company_id = ".$this->session->userdata('company_id')." AND Expense_ID = ?";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('expense', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			//$this->db->where('USER_ID', $this->session->userdata('userid'));
			$this->db->where('Expense_ID', $id);
			$update = $this->db->update('expense', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove2($id)
	{
		if($id) {
			$this->db->where('USER_ID', $this->session->userdata('userid'));
			$this->db->where('Expense_ID', $id);
			$delete = $this->db->delete('expense');
			return ($delete == true) ? true : false;
		}
	}

	public function remove($ids)
	{
		$this->db->where('USER_ID', $this->session->userdata('userid'));;
		$this->db->where('Expense_ID',$ids);
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->delete('expense');
	}
}