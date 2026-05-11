<?php 

class Model_suppliers extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->user_id = $this->session->userdata('id');
		$this->company_id = $this->session->userdata('company_id');
	}

	public function getSupplierData($supplierId = null) 
	{
		if($supplierId) {
			$sql = "SELECT * FROM suppliers WHERE company_id = $this->company_id AND supp_id = ?";
			$query = $this->db->query($sql, array($supplierId));
			return $query->row_array();
		}

		$sql = "SELECT * FROM suppliers WHERE company_id = $this->company_id ";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function getLastSupplierId()
	{
		$sql = "SELECT MAX(supp_id) supp_id FROM suppliers WHERE company_id = $this->company_id";
		$query = $this->db->query($sql, array(1));
		return $query->row_array();
	}

	public function create($data = '')
	{
		if($data) {
			$create = $this->db->insert('suppliers', $data);

			$supp_id = $this->db->insert_id();

			return ($create == true) ? true : false;
		}
	}

	public function edit($data = array(), $id = null)
	{
		$this->db->where('company_id', $this->company_id);
		$this->db->where('supp_id', $id);
		$update = $this->db->update('suppliers', $data);

		return ($update == true) ? true : false;	
	}

	public function delete($id)
	{
		if($id) {
			$this->db->where('company_id', $this->company_id);
			$this->db->where('supp_id', $id);
			$delete = $this->db->delete('suppliers');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalSuppliers()
	{
		$sql = "SELECT * FROM suppliers WHERE company_id = $this->company_id";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
}