<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// get collector id
class get_collector_id extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	     
    }

	// Show view Page
	public function index(){
		$name = $_GET['name'];	

		if($name != '')
		{
		  $q = "SELECT collector_id,collector_first_name,collector_email,collector_address,collector_city,collector_zipcode,collector_phone,contact_person,contact_person_phone FROM collector WHERE collector_first_name = '".$name."'";
			$res = $this->db->query($q);

			foreach ($res->result() as $row)
			{
				$id = $row->collector_id;
				$name = $row->collector_first_name;
				$email = $row->collector_email;
				$addre = $row->collector_address;
				$city = $row->collector_city;
				$zip = $row->collector_zipcode;
				$pho = $row->collector_phone;
				$cp = $row->contact_person;
				$cpp = $row->contact_person_phone;
				
				echo "$name|$email|$addre|$city|$zip|$pho|$cp|$cpp|$id";
			}
			
		}
	}
}

		
?>