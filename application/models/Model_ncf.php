<?php 

class Model_ncf extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
    
	/*get the active NCF information*/
	public function getActiveNCF()
	{
		$sql = "SELECT * FROM ncf WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	/* get the NCF data */
	public function getNCFData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM ncf WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM ncf";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('ncf', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('ncf', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('ncf');
			return ($delete == true) ? true : false;
		}
	}
    
}