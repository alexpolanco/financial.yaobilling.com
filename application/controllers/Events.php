<?php
// Fichero: application/controllers/event.php
class Events extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('logged_in'))
		{ 
			redirect('login');
		}
		else
		{
			if($this->session->userdata('userid') != 1)
			{
				$rights = $this->check_rights();
				$url = $this->uri->segment(1).'/'.$this->uri->segment(2);
				if(!in_array($url, $rights))
				{
					$this->load->view('admin/not_access');
				}
			}
		}

		$this->load->helper('form');
		$this->load->model('expense_model');

		$this->load->model('events_model');
		$this->load->model('loansfixed_model');
		$this->load->model('loanscapital_model');
		$this->load->model('loansinversion_model');
		$this->load->model('loansquickbusiness_model');
		$this->load->model('loanschristmas_model');
		$this->load->model('customer_model');
		$this->load->model('company_model');		
		//$this->data['unpaid_invoice'] = $this->company->unpaidInvoice();

		$user_id = $this->session->userdata('userid');
	}

	public function index() {
		$date = date('Y-m-d');
		$data['events'] = $this->events_model->getLoansDataByDate($date);
		$this->load->view('admin/events',$data);
	}	

	public function payments() {
		$date = date('Y-m-d');
		$data['events'] = $this->events_model->getLoansPaymentsDataByDate($date);
		$this->load->view('admin/events',$data);
	}	

	public function due() {
		$date = date('Y-m-d');
		$data['events'] = $this->events_model->getLoansDueDataByDate($date);
		$this->load->view('admin/events',$data);
	}	

	public function get_company_data()
	{
		$this->db->where('company_id', $this->session->userdata('company_id'));
		return $this->db->get('company')->result();
	}
	
	/*
	* Fetches the events data from the orders table and reservations table
	* this function is called from the datatable ajax function
	*/
	public function fetchLoansDataByDate($currentDate = null, $dateType = null, $onTime = null)
	{
		$response = array();
		$data['events'] = $this->events->getLoansDataByDate($currentDate, $dateType, $onTime);
		
		echo json_encode($response['data']);

		/*$events = $this->events->getLoansDataByDate();
		$data_events = array();

		foreach($events as $r) { 

				$data_events[] = array(
					"session_type" => $r->session_type,
					"session_place" => $r->session_place,
					"orderYear" => $r->orderYear,
					"orderMonth" => $r->orderMonth,
					"orderDay" => $r->orderDay,
					"name" => $r->name,
					"color" => $r->color
				);
		}

		echo json_encode(array("events" => $data_events));*/
	}
	
	public function convertLoansDataByDate($currentDate, $dateType, $onTime = null)
	{
		$response = array();
		//$response = $this->events->getLoansDataByDate($onDate);
		$response['data'] = $this->events->getLoansDataByDate($currentDate, $dateType, $onTime);
		
		echo json_encode($response['data']);
	}

}
?>