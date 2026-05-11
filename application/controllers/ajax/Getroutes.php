<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getroutes extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
    }

	// Show view Page
	public function index(){

		$query = $this->db->query('select * from routes left join collector on routes.collector_id=collector.collector_id where routes_is_active = "yes"');

		foreach ($query->result() as $row)
		{
			echo '<a id="routes_'.$row->routes_id.'" class="btn btn-block table_row" onclick="setroutes('.$row->routes_id.',\''.$row->routes_name.'\','.$row->collector_id.')">'.$row->routes_name.' - '.$row->collector_first_name.'</a>';
		}
	}
}

?>