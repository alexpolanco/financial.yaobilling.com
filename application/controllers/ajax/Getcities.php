<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getcities extends CI_Controller {

	public function __construct() 
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
    }

	// Show view Page
	public function index(){

		$parent_id = empty($this->input->get('parent_id')) ? "1" : $this->input->get('parent_id');

		if($parent_id != '')
		{
			$query = $this->db->query('select *  from cities where cities_is_active = "yes" AND parent_id ='.$parent_id.' ');

			foreach ($query->result() as $row)
			{
				echo '<option value="'.$row->cities_id.'">'.$row->cities_name.'</option>';
			}
		}
	}
}

?>