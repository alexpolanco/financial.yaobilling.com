<?php 

class Model_employee extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->USER_ID = $this->session->userdata('id');
	}

	public function getEmployeeData($EMP_ID = null) 
	{
		if($EMP_ID) {
			$sql = "SELECT * FROM employee WHERE USER_ID = $this->USER_ID AND EMP_ID = ?";
			$query = $this->db->query($sql, array($EMP_ID));
			return $query->row_array();
		}

		$sql = "SELECT * FROM employee WHERE USER_ID = $this->USER_ID ORDER BY EmployeeName";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

    public function getLastEmployeeID()
    {
		$sql = "SELECT MAX(EMP_ID) EMP_ID FROM employee WHERE USER_ID = $this->USER_ID";
		$query = $this->db->query($sql, array(1));
		return $query->row_array();
	}
    
	public function create($data = '')
	{
		if($data) {
			$create = $this->db->insert('employee', $data);

			$EMP_ID = $this->db->insert_id();

			return ($create == true) ? true : false;
		}
	}

	public function edit($id)
	{
		if($id) {
			
			// true case
			$data = array(
				'EmployeeName' => $this->input->post('name'),
				'PersonalId' => $this->input->post('personal_id'),
				'Address' => $this->input->post('address'),
				'Designation' => $this->input->post('designation'),
				'PhoneNo' => $this->input->post('phone'),
				'MobileNo' => $this->input->post('mobile'),
				'Email' => $this->input->post('email'),
				'Website' => $this->input->post('website'),
			);
			
			$this->db->where('USER_ID', $this->USER_ID);
			$this->db->where('EMP_ID', $id);
			$update = $this->db->update('employee', $data);
			//return ($update == true) ? true : false;	
			return true;	
		}
	}

	public function delete($id)
	{
		if($id) {
            $this->db->where('USER_ID', $this->USER_ID);
            $this->db->where('EMP_ID', $id);
            $delete = $this->db->delete('employee');
            return ($delete == true) ? true : false;
        }
	}

	public function countTotalEmployee()
	{
		$sql = "SELECT * FROM employee WHERE USER_ID = $this->USER_ID";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
}