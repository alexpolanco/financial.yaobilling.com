<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');

class Opposition extends MY_Controller  { 

public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Pdf_Library');
		$this->load->library('Excel_Library');
		$this->load->library('NumeroALetras');
		$this->load->database();
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
		$this->load->model('company_model');
		$this->load->model('users_model');
		$this->load->model('routes_model');
		$this->load->model('collector_model');
		$this->load->model('loanstype_model');
		$this->load->model('opposition_model');

	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/home
	 *	- or -
	 * 		http://example.com/index.php/home/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/home/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	public static function convertNumDecimal($number)
	{
		$ci =& get_instance();

		$entero = intval($number);
		$decimal = " PESOS CON ". str_pad(($number - $entero) * 100,2,0,'0') . "/100";

		$result = $ci->convertNum(floatval($entero)) . $decimal;
		return $result;
	}
	
	public static function convertNum($value)
	{
		$ci =& get_instance();

		$num2Text='';
		//$value = bcdiv($value, 1, 2);
		$value = intval($value);
		
		if ($value == 0) $num2Text = "CERO";
		else if ($value == 1) $num2Text = "UNO";
		else if ($value == 2) $num2Text = "DOS";
		else if ($value == 3) $num2Text = "TRES";
		else if ($value == 4) $num2Text = "CUATRO";
		else if ($value == 5) $num2Text = "CINCO";
		else if ($value == 6) $num2Text = "SEIS";
		else if ($value == 7) $num2Text = "SIETE";
		else if ($value == 8) $num2Text = "OCHO";
		else if ($value == 9) $num2Text = "NUEVE";
		else if ($value == 10) $num2Text = "DIEZ";
		else if ($value == 11) $num2Text = "ONCE";
		else if ($value == 12) $num2Text = "DOCE";
		else if ($value == 13) $num2Text = "TRECE";
		else if ($value == 14) $num2Text = "CATORCE";
		else if ($value == 15) $num2Text = "QUINCE";
		else if ($value < 20) $num2Text = "DIECI" . $ci->convertNum($value - 10);
		else if ($value == 20) $num2Text = "VEINTE";
		else if ($value < 30) $num2Text = "VEINTI" . $ci->convertNum($value - 20);
		else if ($value == 30) $num2Text = "TREINTA";
		else if ($value == 40) $num2Text = "CUARENTA";
		else if ($value == 50) $num2Text = "CINCUENTA";
		else if ($value == 60) $num2Text = "SESENTA";
		else if ($value == 70) $num2Text = "SETENTA";
		else if ($value == 80) $num2Text = "OCHENTA";
		else if ($value == 90) $num2Text = "NOVENTA";
		else if ($value < 100) $num2Text =  $ci->convertNum($value / 10 * 10) /*"NOVENTA"*/ . " Y " . $ci->convertNum($value % 10);
		else if ($value == 100) $num2Text = "CIEN";
		else if ($value < 200) $num2Text = "CIENTO " . $ci->convertNum($value - 100);
		else if (($value == 200) || ($value == 300) || ($value == 400) || ($value == 600) || ($value == 800)) $num2Text = $ci->convertNum($value / 100) . "CIENTOS";
		else if ($value == 500) $num2Text = "QUINIENTOS";
		else if ($value == 700) $num2Text = "SETECIENTOS";
		else if ($value == 900) $num2Text = "NOVECIENTOS";
		else if ($value < 1000) $num2Text = $ci->convertNum($value / 100 * 100) /*"NOVECIENTOS"*/ . " " . $ci->convertNum($value % 100);
		else if ($value == 1000) $num2Text = "MIL";
		else if ($value < 2000) $num2Text = "MIL " . $ci->convertNum($value % 1000);
		else if ($value < 1000000)
		{
			$num2Text = $ci->convertNum($value / 1000) . " MIL";
			if (($value % 1000) > 0)
			{
					$num2Text = $num2Text . " " . $ci->convertNum($value % 1000);
			}
		}
		else if ($value == 1000000)
		{
			$num2Text = "UN MILLON";
		}
		else if ($value < 2000000)
		{
			$num2Text = "UN MILLON " . $ci->convertNum($value % 1000000);
		}
		else if ($value < 1000000000000)
		{
			$num2Text = $ci->convertNum($value / 1000000) . " MILLONES ";
			if (($value - $value / 1000000 * 1000000) > 0)
			{
					$num2Text = $num2Text . " " . $ci->convertNum($value - $value / 1000000 * 1000000);
			}
		}
		else if ($value == 1000000000000) $num2Text = "UN BILLÓN";
		else if ($value < 2000000000000) $num2Text = "UN BILLÓN " . $ci->convertNum($value - $value / 1000000000000 * 1000000000000);
		else
		{
			$num2Text = $ci->convertNum($value / 1000000000000) . " BILLONES";
			if (($value - $value / 1000000000000 * 1000000000000) > 0)
			{
					$num2Text = $num2Text . " " . $ci->convertNum($value - $value / 1000000000000 * 1000000000000);
			}
		}
		return $num2Text;
	}
		

	// index method
	public function index()
	{
		$data['recored'] = $this->opposition_model->findAll();
		$this->load->view('admin/opposition/loans-list',$data);
	}
	
	/*
	* If the validation is not valid, then it redirects to the edit orders page 
	* If the validation is successfully then it updates the data into the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/
	
	public function due()
	{
		$data['loansdue'] = 'saldados';
		$data['recored'] = $this->opposition_model->findAllDue();
		$this->load->view('admin/opposition/loans-list',$data);
	}
	
	public function receipt()
	{
		$datefrom = empty($this->input->post('txtfrom_date')) ? date("Y-m-d") : $this->input->post('txtfrom_date');
		$dateto = empty($this->input->post('txtto_date')) ? date("Y-m-d") : $this->input->post('txtto_date');

		$date1 = date("Y-m-d", strtotime($datefrom));
		$date2 = date("Y-m-d", strtotime($dateto));
		
		$data['date1'] = $date1;
		$data['date2'] = $date2;
	
		//$customer_field = $this->input->post('txt_customer_id');
		//$routes_field = $this->input->post('txt_routes_id');
		
		$customer_name_field = $_POST['txt_customer'];
		$customer_field = $_POST['txt_customer_id'];
		$routes_name_field = $_POST['txt_routes'];
		$routes_field = $_POST['txt_routes_id'];
		$paymentno_field = $_POST['txt_paymentno'];
		
		$receipt_paid = $_POST['receipt_paid'];
		$data['sendserver_pagados'] = $receipt_paid;
		
		$receipt_due = $_POST['receipt_due'];
		$data['sendserver_due'] = $receipt_due;

		$this->db->select("printed, con.due_date, opposition.loans_no, con.payment_no, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, FORMAT(opposition.loans_amount,2) loans_amount, FORMAT(opposition.cuota,2) cuota, lt.loanstype_name, opposition.entry_date, opposition.start_date, opposition.end_date, FORMAT(opposition.due_amount,2) due_amount, opposition.interes interes, FORMAT(con.capital,2) capital, FORMAT(con.payment,2) payment, a.routes_name,a.collector_id, IF(cob.collector_nickname='', cob.collector_first_name, CONCAT_WS(' ', cob.collector_first_name, '(', cob.collector_nickname, ')')) collector_first_name, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, '0' atraso, FORMAT(con.balance,2) balance, cli2.customer_address garante_address, cli2.customer_phone garante_phone, FORMAT(con.advance_amount,2) advance_amount");
		
		$this->db->join('customer cli', 'opposition.customer_id=cli.customer_id', 'left');
		$this->db->join('customer cli2', 'opposition.customer_id=cli2.customer_id', 'left');
		$this->db->join('routes a', 'opposition.routes_id=a.routes_id', 'left');
		$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
		$this->db->join('loanstype lt', 'opposition.loanstype_id=lt.loanstype_id', 'left');

		
		$this->db->where('cli.company_id', $this->session->userdata('company_id'));
		$this->db->where('cli2.company_id', $this->session->userdata('company_id'));
		$this->db->where('opposition.company_id', $this->session->userdata('company_id'));

		if(isset($receipt_due) && $receipt_due != "0"){
			$this->db->where('due_date <', date('Y-m-d'));
			$this->db->group_by('loans_no');
		}
		else {
			$this->db->where('con.due_date >=', $date1);
			$this->db->where('con.due_date <=', $date2);
		}
		
		if(isset($customer_field) && $customer_field != ""){
			$this->db->where('opposition.customer_id', $customer_field);
		}
		if(isset($routes_field) && $routes_field != ""){
			$this->db->where('opposition.routes_id', $routes_field);
		}
		if(isset($paymentno_field) && $paymentno_field != ""){
			$this->db->where('con.payment_no', $paymentno_field);
		}
		if(isset($receipt_paid) && $receipt_paid != "0"){
			$this->db->where('printed', 'yes');
		}
		else {
				$this->db->where('printed', 'no');
		}
		$this->db->where('return_p', 'no');
		$this->db->order_by('customer_first_name', 'ASC');
		
		$data['customer_name_field'] = $customer_name_field;
		$data['customer_field'] = $customer_field;
		
		$data['routes_name_field'] = $routes_name_field;
		$data['routes_field'] = $routes_field;
		$data['paymentno_field'] = $paymentno_field;
		
		$data['recored'] = $this->db->get('opposition')->result();
		$this->load->view('admin/opposition/loans-receipt',$data);
	}
	
	public function receipt_due()
	{
		$data['loansdue'] = 'saldados';
		
		$this->db->select("printed, con.due_date, opposition.loans_no, (lt.loanstype_duration + 1) payment_no, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, FORMAT(opposition.loans_amount,2) loans_amount, FORMAT(opposition.cuota,2) cuota, lt.loanstype_name, opposition.entry_date, opposition.start_date, opposition.end_date, FORMAT(opposition.due_amount,2) due_amount, opposition.interes interes, FORMAT(con.capital,2) capital, FORMAT(con.payment,2) payment, a.routes_name,a.collector_id, IF(cob.collector_nickname='', cob.collector_first_name, CONCAT_WS(' ', cob.collector_first_name, '(', cob.collector_nickname, ')')) collector_first_name, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, '0' atraso, FORMAT(con.balance,2) balance, cli2.customer_address garante_address, cli2.customer_phone garante_phone, FORMAT(con.advance_amount,2) advance_amount, '500.00' fee_payment");  
		
		$this->db->join('customer cli', 'opposition.customer_id=cli.customer_id', 'left');
		$this->db->join('customer cli2', 'opposition.customer_id=cli2.customer_id', 'left');
		$this->db->join('routes a', 'opposition.routes_id=a.routes_id', 'left');
		$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
		$this->db->join('loanstype lt', 'opposition.loanstype_id=lt.loanstype_id', 'left');
	
		$this->db->where('cli.company_id', $this->session->userdata('company_id'));
		$this->db->where('cli2.company_id', $this->session->userdata('company_id'));
		$this->db->where('opposition.company_id', $this->session->userdata('company_id'));

		$this->db->where('return_p', 'no');
		$this->db->where('due_date <', date('Y-m-d'));
		$this->db->where('due_date <', date('Y-m-d'));
		$this->db->where('printed', 'no');

		$this->db->group_by('loans_no');
		
		$data['recored'] = $this->db->get('opposition')->result();
		$this->load->view('admin/opposition/loans-receipt',$data);
	}

	public function return_loans()
	{
		$this->db->where('return_p','yes');
		$data['recored'] = $this->db->get('opposition')->result();
		$this->load->view('admin/opposition/loans-return-list',$data);
	}

	// order view
	public function loan_view()
	{
		$this->load->view('admin/opposition/loan-view');
	}

	// pdf method
	public function pdf($segment_1,$segment_2,$segment_3="",$segment_4="")
	{
		if($segment_1 == "loan_1" || $segment_1 == "loan_letter" || $segment_1 == "loan_contract" || $segment_1 == "loan_receipt")
		{
			if($segment_1 == "loan_receipt")
			{
				$this->printTransactionDiv($segment_2, $segment_3);
			}
			else if($segment_1 == "loan_letter")
			{
				$this->db->select(" opposition.opposition_no, opposition.opposition_date, opposition.loans_no, opposition.current_balance, cli.customer_gender, cli.customer_nationality, cli.customer_civilstatus, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, 
				
				g1.guarantor_gender guarantor1_gender, g1.guarantor_nationality guarantor1_nationality, g1.guarantor_civilstatus guarantor1_civilstatus, If(g1.guarantor_nickname ='', g1.guarantor_first_name, CONCAT_WS(' ', g1.guarantor_first_name, '(', g1.guarantor_nickname, ')')) AS guarantor1_first_name,  g1.guarantor_id guarantor1_id, g1.guarantor_personalid guarantor1_personalid, g1.guarantor_address guarantor1_address, g1.guarantor_phone guarantor1_phone, g1.guarantor_workplace guarantor1_workplace, g1.guarantor_occupation guarantor1_occupation, 
				
				g2.guarantor_gender guarantor2_gender, g2.guarantor_nationality guarantor2_nationality, g2.guarantor_civilstatus guarantor2_civilstatus, If(g2.guarantor_nickname ='', g2.guarantor_first_name, CONCAT_WS(' ', g2.guarantor_first_name, '(', g2.guarantor_nickname, ')')) AS guarantor2_first_name,  g2.guarantor_id guarantor2_id, g2.guarantor_personalid guarantor2_personalid, g2.guarantor_address guarantor2_address, g2.guarantor_phone guarantor2_phone, g2.guarantor_workplace guarantor2_workplace, g2.guarantor_occupation guarantor2_occupation,
				
				opposition.duration, opposition.interes_amount, FORMAT(opposition.loans_amount,2) loans_amount, FORMAT(opposition.cuota,2) cuota, lt.loanstype_name, lt.loanstype_frequency, opposition.contract_number, opposition.contract_folio1, opposition.contract_folio2, opposition.entry_date, opposition.create_date, opposition.entry_time, opposition.start_date, opposition.end_date, FORMAT(opposition.due_amount,2) due_amount, opposition.interes interes, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, '0' atraso, cli2.customer_address garante_address, cli2.customer_phone garante_phone ");
			
				$this->db->join('customer cli', 'opposition.customer_id=cli.customer_id', 'left');
				$this->db->join('customer cli2', 'opposition.customer_id=cli2.customer_id', 'left');
				$this->db->join('guarantor g1', 'opposition.guarantor1_id=g1.guarantor_id', 'left');
				$this->db->join('guarantor g2', 'opposition.guarantor2_id=g2.guarantor_id', 'left');
				//$this->db->join('routes a', 'opposition.routes_id=a.routes_id', 'left');
				//$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
				$this->db->join('loanstype lt', 'opposition.loanstype_id=lt.loanstype_id', 'left');
				
				$this->db->where('cli.company_id', $this->session->userdata('company_id'));
				$this->db->where('cli2.company_id', $this->session->userdata('company_id'));
				//$this->db->where('opposition_transactions.company_id', $this->session->userdata('company_id'));			
				$this->db->where('opposition.company_id', $this->session->userdata('company_id'));			
				$this->db->where('opposition.loans_no =', $segment_2);
						
				$this->db->order_by('customer_first_name', 'ASC');
				
				$data['order'] = $this->db->get('opposition')->result();
				$data['date1'] = $segment_2;
				$data['date2'] = $segment_3;
				$this->load->view('admin/opposition/'.$segment_1,$data);
			}
			else if($segment_1 == "loan_contract")
			{
				$this->db->select(" opposition.loans_no, opposition.current_balance, cli.customer_gender, cli.customer_nationality, cli.customer_civilstatus, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, 
				
				g1.guarantor_gender guarantor1_gender, g1.guarantor_nationality guarantor1_nationality, g1.guarantor_civilstatus guarantor1_civilstatus, If(g1.guarantor_nickname ='', g1.guarantor_first_name, CONCAT_WS(' ', g1.guarantor_first_name, '(', g1.guarantor_nickname, ')')) AS guarantor1_first_name,  g1.guarantor_id guarantor1_id, g1.guarantor_personalid guarantor1_personalid, g1.guarantor_address guarantor1_address, g1.guarantor_phone guarantor1_phone, g1.guarantor_workplace guarantor1_workplace, g1.guarantor_occupation guarantor1_occupation, 
				
				g2.guarantor_gender guarantor2_gender, g2.guarantor_nationality guarantor2_nationality, g2.guarantor_civilstatus guarantor2_civilstatus, If(g2.guarantor_nickname ='', g2.guarantor_first_name, CONCAT_WS(' ', g2.guarantor_first_name, '(', g2.guarantor_nickname, ')')) AS guarantor2_first_name,  g2.guarantor_id guarantor2_id, g2.guarantor_personalid guarantor2_personalid, g2.guarantor_address guarantor2_address, g2.guarantor_phone guarantor2_phone, g2.guarantor_workplace guarantor2_workplace, g2.guarantor_occupation guarantor2_occupation,
				
				opposition.duration, opposition.interes_amount, FORMAT(opposition.loans_amount,2) loans_amount, FORMAT(opposition.cuota,2) cuota, lt.loanstype_name, lt.loanstype_frequency, opposition.contract_number, opposition.contract_folio1, opposition.contract_folio2, opposition.entry_date, opposition.create_date, opposition.entry_time, opposition.start_date, opposition.end_date, FORMAT(opposition.due_amount,2) due_amount, opposition.interes interes, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, '0' atraso, cli2.customer_address garante_address, cli2.customer_phone garante_phone ");
			
				$this->db->join('customer cli', 'opposition.customer_id=cli.customer_id', 'left');
				$this->db->join('customer cli2', 'opposition.customer_id=cli2.customer_id', 'left');
				$this->db->join('guarantor g1', 'opposition.guarantor1_id=g1.guarantor_id', 'left');
				$this->db->join('guarantor g2', 'opposition.guarantor2_id=g2.guarantor_id', 'left');
				//$this->db->join('routes a', 'opposition.routes_id=a.routes_id', 'left');
				//$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
				$this->db->join('loanstype lt', 'opposition.loanstype_id=lt.loanstype_id', 'left');
				
				$this->db->where('cli.company_id', $this->session->userdata('company_id'));
				$this->db->where('cli2.company_id', $this->session->userdata('company_id'));
				//$this->db->where('opposition_transactions.company_id', $this->session->userdata('company_id'));			
				$this->db->where('opposition.company_id', $this->session->userdata('company_id'));			
				$this->db->where('opposition.loans_no =', $segment_2);
						
				$this->db->order_by('customer_first_name', 'ASC');
				
				$data['order'] = $this->db->get('opposition')->result();
				$data['date1'] = $segment_2;
				$data['date2'] = $segment_3;
				$this->load->view('admin/opposition/'.$segment_1,$data);
			}
			else
			{
				$this->db->select("printed, con.due_date, opposition.loans_no, opposition.current_balance, tra.payment_date, tra.transactions_type, tra.amount transactions_amount,  con.payment_no, cli.customer_gender, cli.customer_nationality, cli.customer_civilstatus, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, opposition.duration, opposition.interes_amount, FORMAT(opposition.loans_amount,2) loans_amount, FORMAT(opposition.cuota,2) cuota, lt.loanstype_name, lt.loanstype_frequency, opposition.contract_number, opposition.contract_folio1, opposition.contract_folio2, opposition.entry_date, opposition.create_date, opposition.entry_time, opposition.start_date, opposition.end_date, FORMAT(opposition.due_amount,2) due_amount, opposition.interes interes, FORMAT(con.capital,2) capital, FORMAT(con.payment,2) payment, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, '0' atraso, FORMAT(con.balance,2) balance, cli2.customer_address garante_address, cli2.customer_phone garante_phone, FORMAT(con.advance_amount,2) advance_amount");
			
				$this->db->join('customer cli', 'opposition.customer_id=cli.customer_id', 'left');
				$this->db->join('customer cli2', 'opposition.customer_id=cli2.customer_id', 'left');
				//$this->db->join('routes a', 'opposition.routes_id=a.routes_id', 'left');
				//$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
				$this->db->join('loanstype lt', 'opposition.loanstype_id=lt.loanstype_id', 'left');
				$this->db->join('opposition_transactions tra', 'tra.loans_no = opposition.loans_no', 'left outer');
				
				$this->db->where('cli.company_id', $this->session->userdata('company_id'));
				$this->db->where('cli2.company_id', $this->session->userdata('company_id'));
				//$this->db->where('opposition_transactions.company_id', $this->session->userdata('company_id'));			
				$this->db->where('opposition.company_id', $this->session->userdata('company_id'));			
				$this->db->where('opposition.loans_no =', $segment_2);
						
				$this->db->order_by('due_date', 'ASC');
				$this->db->order_by('customer_first_name', 'ASC');
				
				$data['order'] = $this->db->get('opposition')->result();
				$data['date1'] = $segment_2;
				$data['date2'] = $segment_3;
				$this->load->view('admin/opposition/'.$segment_1,$data);
			}
		}
		else
		{
			$receipt_due = $_POST['receipt_due'];

			$this->db->select("printed, con.due_date, opposition.loans_no, con.payment_no, cli.customer_gender, cli.customer_nationality, cli.customer_civilstatus, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, FORMAT(opposition.loans_amount,2) loans_amount, FORMAT(opposition.cuota,2) cuota, lt.loanstype_name, opposition.entry_date, opposition.create_date, opposition.start_date, opposition.end_date, FORMAT(opposition.due_amount,2) due_amount, opposition.interes interes, FORMAT(con.capital,2) capital, FORMAT(con.payment,2) payment, a.routes_name,a.collector_id, IF(cob.collector_nickname='', cob.collector_first_name, CONCAT_WS(' ', cob.collector_first_name, '(', cob.collector_nickname, ')')) collector_first_name, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, '0' atraso, FORMAT(con.balance,2) balance, cli2.customer_address garante_address, cli2.customer_phone garante_phone, FORMAT(con.advance_amount,2) advance_amount");
			
			$this->db->join('customer cli', 'opposition.customer_id=cli.customer_id', 'left');
			$this->db->join('customer cli2', 'opposition.customer_id=cli2.customer_id', 'left');
			$this->db->join('routes a', 'opposition.routes_id=a.routes_id', 'left');
			$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
			$this->db->join('loanstype lt', 'opposition.loanstype_id=lt.loanstype_id', 'left');
			
			$this->db->where('cli.company_id', $this->session->userdata('company_id'));
			$this->db->where('cli2.company_id', $this->session->userdata('company_id'));
			$this->db->where('opposition.company_id', $this->session->userdata('company_id'));

			if(isset($segment_4) && $segment_4 != ""){
				$this->db->where('due_date <', date('Y-m-d'));
			}
			else {
				$this->db->where('end_date >=', $segment_2);
				$this->db->where('end_date <=', $segment_3);
			}
			
			$this->db->where('printed', 'no');
			$this->db->where('return_p', 'no');
			
			$this->db->group_by('loans_no');
		
			$this->db->order_by('due_date', 'ASC');
			$this->db->order_by('customer_first_name', 'ASC');
			
			$data['order'] = $this->db->get('opposition')->result();
			$data['date1'] = $segment_2;
			$data['date2'] = $segment_3;
			$this->load->view('admin/opposition/'.$segment_1,$data);
		}
	}

	// excel method
	public function excel()
	{
		$data['recored'] = $this->opposition_model->findAll();
		$this->load->view('admin/opposition/loans-excel',$data);
	}
	
	public function get_grand_value($order_no)
	{
		$res = $this->db->query("select * from loans_grandtotal where grand_order_no='".$order_no."'");
		return $totrel = $res->row_array();
	}

	public function get_tmp_loans()
	{
		$query = $this->db->query('select DISTINCT(table_id) from loans_tmp where admin_id ='.$this->session->userdata('userid'));
		$table = array();
		foreach ($query->result() as $row)
		{
			$table[] = $row->table_id ;
		}
		
		return $table;
	}

	public function edit_data_get_product($s_no)
	{
		$query = $this->db->query("select product_serial_no,product_margin,product_actual_price,product_id,product_discount from product where product_serial_no = '".$s_no."'");
		return $query->row_array();
	}

	public function edit_data_get_option($con)
	{
		$query = $this->db->query("SELECT po.product_option_stock,po.option_parent_id,po.option_id,o.option_name,po.product_option_id FROM product_option po 
											INNER JOIN options o ON po.option_id=o.option_id
											WHERE product_option_id =".$con." ");
		return $query->row_array();
	}

	public function get_collector_data()
	{
		$this->db->where('company_id', $this->session->userdata('company_id'));
		return $this->db->get('collector')->result();
	}

	public function get_company_data()
	{
		$this->db->where('company_id', $this->session->userdata('company_id'));
		return $this->db->get('company')->result();
	}

	public function get_transactions_data($no)
	{
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->where('due_date <= ', 'NOW()', FALSE);
		$this->db->where('loans_no',$no);
		$query1 = $this->db->get('opposition_accounting')->result();

		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no',$no);
		$query2 = $this->db->get('opposition_transactions')->result();

		$transactions = array_merge($query1, $query2);

		return $transactions;
	}

	public function get_loan_number($no)
	{
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no',$no);
		$data = $this->db->get('opposition')->row_array();
		return  $data['loans_no'];
	}

	public function get_loan_date($no)
	{
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no',$no);
		$data = $this->db->get('opposition')->row_array();
		return  $data['create_date'];
	}
	//Get All loans 
	public function get_all_loans($customer_id = null)
	{
		$this->db->select('
		IFNULL(IF(loanscapital.current_balance > 0, loanscapital.due_amount, 0), 0) loanscapital_amount, loanscapital.loans_no loanscapital_no , 

		IFNULL(IF(loanschristmas.current_balance > 0, loanschristmas.due_amount, 0), 0) loanschristmas_amount, loanschristmas.loans_no loanschristmas_no,

		IFNULL(IF(loansfixed.current_balance > 0, loansfixed.due_amount, 0), 0) loansfixed_amount, loansfixed.loans_no loansfixed_no,

		IFNULL(IF(loansinversion.current_balance > 0, loansinversion.due_amount, 0), 0) loansinversion_amount, loansinversion.loans_no loansinversion_no,

		IFNULL(IF(loansquickbusiness.current_balance > 0, loansquickbusiness.due_amount, 0), 0) loansquickbusiness_amount, loansquickbusiness.loans_no loansquickbusiness_no ');

		$this->db->join('loansfixed', 'customer.customer_id = loansfixed.customer_id AND loansfixed.current_balance > 0', 'LEFT OUTER');

		$this->db->join('loanscapital', 'customer.customer_id = loanscapital.customer_id AND loanscapital.current_balance > 0', 'LEFT OUTER');

		$this->db->join('loansinversion', 'customer.customer_id = loansinversion.customer_id AND loansinversion.current_balance > 0', 'LEFT OUTER');

		$this->db->join('loansquickbusiness', 'customer.customer_id = loansquickbusiness.customer_id AND loansquickbusiness.current_balance > 0', 'LEFT OUTER');

		$this->db->join('loanschristmas', 'customer.customer_id = loanschristmas.customer_id AND loanschristmas.current_balance > 0', 'LEFT OUTER');

		$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->where('customer.customer_id', $customer_id);

		//$this->db->group_by('customer.customer_id');

		return $data['_loans'] = $this->db->get('customer')->result();
	}
	//Get All customer 
	public function get_all_customer()
	{
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->order_by('customer_first_name', 'ASC');
		return $data['_customer'] = $this->db->get('customer')->result();
	}
	//Get All guarantor 
	public function get_all_guarantor()
	{
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->order_by('guarantor_first_name', 'ASC');
		return $data['_guarantor'] = $this->db->get('guarantor')->result();
	}
	//Get All collector 
	public function get_all_collector()
	{
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->order_by('collector_first_name', 'ASC');
		return $data['_collector'] = $this->db->get('collector')->result();
	}
	//Get All routes 
	public function get_all_routes()
	{
		$this->db->join('collector', 'collector.collector_id = routes.collector_id', 'left');
		$this->db->where('routes.company_id', $this->session->userdata('company_id'));
		$this->db->order_by('routes_name', 'DESC');
		return $data['_routes'] = $this->db->get('routes')->result();
	}
	//Get All loanstype 
	public function get_all_loanstype()
	{
		$this->db->where('company_id', $this->session->userdata('company_id'));
		return $data['_loanstype'] = $this->db->get('loanstype')->result();
	}
	//Get All category 
	public function get_all_cat()
	{
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->where('parent_id !=','0');
		return $data['_cate'] = $this->db->get('category')->result();
	}


	// Create method
	public function create()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('txt_loans_amount', 'Monto prestado', 'required');
		//$this->form_validation->set_rules('txt_routes_id', 'Ruta', 'required');
		$this->form_validation->set_rules('txt_opposition_place', 'Lugar de la oposición', 'required');
		$this->form_validation->set_rules('txt_customer_id', 'Nombre del cliente', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('admin/opposition/loans-add');
		}
		else
		{
		    $create = $this->opposition_model->insert();
		    
		    if($create == true ) {				
				$this->session->set_flashdata('msg','Datos insertados exitosamente');
				return redirect('opposition');
			}
			else {
				$this->session->set_flashdata('msg','Oposición existe actualmente u ocurrió un error inesperado');
				return redirect('opposition');
			}
		}
	}
	
	public function get_product_option_bill($id)
	{
		$query = $this->db->query("SELECT po.product_option_stock,po.option_parent_id,po.option_id,o.option_name,po.product_option_id FROM product_option po  INNER JOIN options o ON po.option_id=o.option_id WHERE product_option_id =".$id);
		return $query->row_array();
	}

	//public pos function
	public function loan_print($no = null)
	{
		$this->db->join('customer', 'opposition.customer_id=customer.customer_id', 'left');
		$this->db->join('routes', 'opposition.routes_id=routes.routes_id', 'left');
		$this->db->join('collector', 'routes.collector_id=collector.collector_id', 'left');
		$this->db->join('loanstype', 'opposition.loanstype_id=loanstype.loanstype_id', 'left');
		$this->db->join('opposition_accounting la', 'opposition.loans_no=la.loans_no', 'left');

		$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->where('opposition.company_id', $this->session->userdata('company_id'));
		
		//$this->db->where('opposition.loans_no',$no);

		$data['opposition'] = $this->db->get('opposition')->result();
		
		//$this->load->view('admin/opposition/loan-pos-confirm',$data);
		//$this->load->view('admin/opposition/loan-print-confirm',$data);
		$this->load->view('admin/opposition/loan-report-confirm',$data);
	}

	// update method
	public function update($id)
	{		
		if(!isset($_POST['edit_new_interes_amount']) || !isset($_POST['edit_new_capital_amount']))
		{
			$this->opposition_model->update($id);
			return redirect('opposition');
		}
		else
		{
			$data=array('interes_paid'=>$_POST['edit_new_interes_amount'], 'capital_paid'=>$_POST['edit_new_capital_amount'], );
			$this->db->where('company_id', $this->session->userdata('company_id'));
			$this->db->where('transactions_no',$id);
			$this->db->update('opposition_transactions',$data);

			$this->logger->write( "Oposición", "edicion", 'Transaccion: ' . $id . ' nuevo valor interes: ' . $_POST['edit_new_interes_amount'] . ' nuevo valor capital: ' . $_POST['edit_new_capital_amount'] );
			
			return redirect('opposition');
		}
	
		/*if(isset($_POST['return']))
		{
			if($_POST['return'] == 'yes')
			{
				$data=array('return_p'=>'yes');
				$this->db->where('company_id', $this->session->userdata('company_id'));
				$this->db->where('loans_no',$id);
				$this->db->update('opposition',$data);
				
				return redirect('opposition');
			}
		}
		else
		{
			$this->db->where('company_id', $this->session->userdata('company_id'));
			$this->db->where('loans_no',$id);
			$this->db->delete('opposition');

			//$this->db->where('grand_order_no',$id);
			//$this->db->delete('loans_grandtotal');

			$data_ar = $this->opposition_model->insert();
			//echo $data_ar;
			//return redirect('opposition/loan_print/'.$data_ar);
			return redirect('opposition');
		}*/
	}
		
	// edit method
	public function edit($id = null)
	{		
		$response = array();
		$this->load->library('form_validation');

		$this->form_validation->set_rules('edit_date', 'Fecha del acto de oposición', 'trim|required');
		$this->form_validation->set_rules('edit_opposition_route', 'Lugar de la oposición', 'trim|required');
		$this->form_validation->set_rules('edit_opposition_no', 'Número de acto de oposición', 'trim|required|numeric');
		//$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		$id = $this->input->post('txt_loansno');
		$date = date('Y-m-d', strtotime($this->input->post('edit_date')));

		if ($this->form_validation->run() == TRUE) {
			$order_data = array(
				'routes_id'=> $this->input->post('edit_opposition_route'),
				'opposition_no'=> $this->input->post('edit_opposition_no'),
				'opposition_date'=> $date
			);

			$this->logger->write( "Oposición", "actualizada", 'Fecha: ' . $this->input->post('edit_date') . ' Número: ' . $this->input->post('edit_opposition_no') . ' Lugar: ' . $this->input->post('edit_opposition_route') );

			$create = $this->opposition_model->edit($order_data, $id);

			if($create == true ) {				
				$this->session->set_flashdata('msg','Datos actualizados exitosamente');
				return redirect('opposition');
			}
			else {
				$this->session->set_flashdata('msg','Ocurrió un error');
				return redirect('opposition');
			}
		}
		else {
			$this->session->set_flashdata('msg','Ocurrió un error');
			return redirect('opposition');

			$response['success'] = false;
			foreach ($_POST as $key => $value) {
				$response['messages'][$key] = form_error($key);
			}
		}
	}
		
	// renew method
	public function renew($id)
	{		
		$data['recored'] = $this->opposition_model->findOne($id);
		$this->load->view('admin/opposition/loans-renew',$data);
	}

	// delete method
	public function delete($id)
	{
		/*if($this->session->userdata('userid') != 1)
		{
			$rights = $this->check_rights();
			if(!in_array('opposition/delete', $rights))
			{
				return redirect('access');
			}
		}
		else
		{*/
			$orders = $this->opposition_model->getOrdersData($id);
			$_frequency = "";
			switch($orders['loanstype_id'])
			{
				case "1" : $_frequency = floatval($orders['duration']) == 1 ? "semana" : "semanas"; break;
				case "2" : $_frequency = floatval($orders['duration']) == 1 ? "día" : "días"; break;
				case "3" : $_frequency = floatval($orders['duration']) == 1 ? "mes" : "meses"; break;
				case "4" : $_frequency = floatval($orders['duration']) == 1 ? "quincena" : "quincenas"; break;
				case "5" : $_frequency = floatval($orders['duration']) == 1 ? "año" : "años"; break;
				default : $_frequency = floatval($orders['duration']) == 1 ? "mes" : "meses"; break;
			}

			$this->logger->write( "Oposición", "levantada", 'Prestamo del cliente: ' . $orders['customer_first_name'] . ' monto $' . $orders['current_balance'] . ' duración: ' . $orders['duration'] . ' ' . $_frequency . ' interes: ' . $orders['interes_amount']);

			$this->opposition_model->remove($id);
			$this->session->set_flashdata('msg','Datos levantados exitosamente');
			
			
			return redirect('opposition');
		//}
	}

	public function today()
	{
		$data['date1'] = date('Y-m-d');
		$data['date2'] = date('Y-m-d');
		
		$customer_field = $_POST['txt_customer_id'];
		$routes_field = $_POST['txt_routes_id'];
		$paymentno_field = $_POST['txt_paymentno'];
		$receipt_paid = $_POST['receipt_paid'];
		
		$this->db->select("printed, con.due_date, opposition.loans_no, con.payment_no, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, FORMAT(opposition.loans_amount,2) loans_amount, FORMAT(opposition.cuota,2) cuota, lt.loanstype_name, opposition.entry_date, opposition.start_date, opposition.end_date, FORMAT(opposition.due_amount,2) due_amount, opposition.interes interes, FORMAT(con.capital,2) capital, FORMAT(con.payment,2) payment, a.routes_name,a.collector_id, IF(cob.collector_nickname='', cob.collector_first_name, CONCAT_WS(' ', cob.collector_first_name, '(', cob.collector_nickname, ')')) collector_first_name, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, '0' atraso, FORMAT(con.balance,2) balance, cli2.customer_address garante_address, cli2.customer_phone garante_phone, FORMAT(con.advance_amount,2) advance_amount"); 
		$this->db->join('customer cli', 'opposition.customer_id=cli.customer_id', 'left');
		$this->db->join('customer cli2', 'opposition.customer_id=cli2.customer_id', 'left');
		$this->db->join('routes a', 'opposition.routes_id=a.routes_id', 'left');
		$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
		$this->db->join('loanstype lt', 'opposition.loanstype_id=lt.loanstype_id', 'left');
		
		$this->db->where('opposition.company_id', $this->session->userdata('company_id'));
		$this->db->where('due_date',date('Y-m-d'));

		if($customer_field != ""){
			$this->db->where('opposition.customer_id', $customer_field);
		}
		if(isset($routes_field) && $routes_field != ""){
			$this->db->where('opposition.routes_id', $routes_field);
		}
		if(isset($paymentno_field) && $paymentno_field != ""){
			$this->db->where('con.payment_no', $paymentno_field);
		}
		if(isset($receipt_paid) && $receipt_paid != ""){
			$this->db->where('printed', 'yes');
		}
		else {
			$this->db->where('printed', 'no');
		}
		
		$sendserver_pagados = $_POST['receipt_paid'];
		$data['sendserver_pagados'] = $sendserver_pagados;
		
		$data['customer_name_field'] = $customer_name_field;
		$data['customer_field'] = $customer_field;
		
		$data['recored'] = $this->db->get('opposition')->result();
		$this->load->view('admin/opposition/loans-receipt',$data);	
	}

	public function weekly()
	{
		//$date1=date('Y-m-d',strtotime(date("Y-m-d")."-6 day"));
		//$date2=date('Y-m-d');
		$date2=date('Y-m-d',strtotime(date("Y-m-d")." last monday"));
		$date1=date('Y-m-d',strtotime(date($date2)." -6 day"));

		$data['date1'] = $date1;
		$data['date2'] = $date2;

		$this->db->select("printed, con.due_date, opposition.loans_no, con.payment_no, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, FORMAT(opposition.loans_amount,2) loans_amount, FORMAT(opposition.cuota,2) cuota, lt.loanstype_name, opposition.entry_date, opposition.start_date, opposition.end_date, FORMAT(opposition.due_amount,2) due_amount, opposition.interes interes, FORMAT(con.capital,2) capital, FORMAT(con.payment,2) payment, a.routes_name,a.collector_id, IF(cob.collector_nickname='', cob.collector_first_name, CONCAT_WS(' ', cob.collector_first_name, '(', cob.collector_nickname, ')')) collector_first_name, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, '0' atraso, FORMAT(con.balance,2) balance, cli2.customer_address garante_address, cli2.customer_phone garante_phone, FORMAT(con.advance_amount,2) advance_amount"); 
		$this->db->where('due_date >=', $date1);
		$this->db->where('due_date <=', $date2);
		$this->db->join('customer cli', 'opposition.customer_id=cli.customer_id', 'left');
		$this->db->join('customer cli2', 'opposition.customer_id=cli2.customer_id', 'left');
		$this->db->join('routes a', 'opposition.routes_id=a.routes_id', 'left');
		$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
		$this->db->join('loanstype lt', 'opposition.loanstype_id=lt.loanstype_id', 'left');
		
		$this->db->where('opposition.company_id', $this->session->userdata('company_id'));

		$data['recored'] = $this->db->get('opposition')->result();
		$this->load->view('admin/opposition/loans-receipt',$data);	
	}

	public function monthly()
	{
		$start_date=date('Y-m-01'); // Month Starting Date
		$end_date=date('Y-m-t');  // Month Ending Date
		
		$data['date1'] = $start_date;
		$data['date2'] = $end_date;

		$this->db->select("printed, con.due_date, opposition.loans_no, con.payment_no, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, FORMAT(opposition.loans_amount,2) loans_amount, FORMAT(opposition.cuota,2) cuota, lt.loanstype_name, opposition.entry_date, opposition.start_date, opposition.end_date, FORMAT(opposition.due_amount,2) due_amount, opposition.interes interes, FORMAT(con.capital,2) capital, FORMAT(con.payment,2) payment, a.routes_name,a.collector_id, IF(cob.collector_nickname='', cob.collector_first_name, CONCAT_WS(' ', cob.collector_first_name, '(', cob.collector_nickname, ')')) collector_first_name, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, '0' atraso, FORMAT(con.balance,2) balance, cli2.customer_address garante_address, cli2.customer_phone garante_phone, FORMAT(con.advance_amount,2) advance_amount");  
		$this->db->where('due_date >=', $start_date);
		$this->db->where('due_date <=', $end_date);
		$this->db->join('customer cli', 'opposition.customer_id=cli.customer_id', 'left');
		$this->db->join('customer cli2', 'opposition.customer_id=cli2.customer_id', 'left');
		$this->db->join('routes a', 'opposition.routes_id=a.routes_id', 'left');
		$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
		$this->db->join('loanstype lt', 'opposition.loanstype_id=lt.loanstype_id', 'left');

		$this->db->where('opposition.company_id', $this->session->userdata('company_id'));

		$data['recored'] = $this->db->get('opposition')->result();
		$this->load->view('admin/opposition/loans-receipt',$data);	
	}

	public function yearly()
	{
		$start_date=date('Y-01-d'); // year Starting Date
		$end_date=date('Y-12-d');  // year Ending Date
		
		$data['date1'] = $start_date;
		$data['date2'] = $end_date;

		$this->db->select("printed, con.due_date, opposition.loans_no, con.payment_no, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, FORMAT(opposition.loans_amount,2) loans_amount, FORMAT(opposition.cuota,2) cuota, lt.loanstype_name, opposition.entry_date, opposition.start_date, opposition.end_date, FORMAT(opposition.due_amount,2) due_amount, opposition.interes interes, FORMAT(con.capital,2) capital, FORMAT(con.payment,2) payment, a.routes_name,a.collector_id, IF(cob.collector_nickname='', cob.collector_first_name, CONCAT_WS(' ', cob.collector_first_name, '(', cob.collector_nickname, ')')) collector_first_name, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, '0' atraso, FORMAT(con.balance,2) balance, cli2.customer_address garante_address, cli2.customer_phone garante_phone, FORMAT(con.advance_amount,2) advance_amount");  
		$this->db->where('due_date >=', $start_date);
		$this->db->where('due_date <=', $end_date);
		$this->db->join('customer cli', 'opposition.customer_id=cli.customer_id', 'left');
		$this->db->join('customer cli2', 'opposition.customer_id=cli2.customer_id', 'left');
		$this->db->join('routes a', 'opposition.routes_id=a.routes_id', 'left');
		$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
		$this->db->join('loanstype lt', 'opposition.loanstype_id=lt.loanstype_id', 'left');

		$this->db->where('opposition.company_id', $this->session->userdata('company_id'));

		$data['recored'] = $this->db->get('opposition')->result();
		$this->load->view('admin/opposition/loans-receipt',$data);	
	}

	public function search($datefrom = '',$dateto = '')
	{
		$datefrom = $this->input->post('txtfrom_date');
		$dateto = $this->input->post('txtto_date');
		
		$date1 = date("Y-m-d", strtotime($datefrom));
		$date2 = date("Y-m-d", strtotime($dateto));
		
		$data['date1'] = $date1;
		$data['date2'] = $date2;
		
		//$customer_field = $this->input->post('txt_customer_id');
		//$routes_field = $this->input->post('txt_routes_id');
		
		$customer_name_field = $_POST['txt_customer'];
		$customer_field = $_POST['txt_customer_id'];
		$routes_name_field = $_POST['txt_routes'];
		$routes_field = $_POST['txt_routes_id'];
		$paymentno_field = $_POST['txt_paymentno'];
		$receipt_paid = $_POST['receipt_paid'];

		$this->db->select("printed, con.due_date, opposition.loans_no, con.payment_no, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, FORMAT(opposition.loans_amount,2) loans_amount, FORMAT(opposition.cuota,2) cuota, lt.loanstype_name, opposition.entry_date, opposition.start_date, opposition.end_date, FORMAT(opposition.due_amount,2) due_amount, opposition.interes interes, FORMAT(con.capital,2) capital, FORMAT(con.payment,2) payment, a.routes_name,a.collector_id, IF(cob.collector_nickname='', cob.collector_first_name, CONCAT_WS(' ', cob.collector_first_name, '(', cob.collector_nickname, ')')) collector_first_name, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, '0' atraso, FORMAT(con.balance,2) balance, cli2.customer_address garante_address, cli2.customer_phone garante_phone, FORMAT(con.advance_amount,2) advance_amount");
		
		$this->db->join('customer cli', 'opposition.customer_id=cli.customer_id', 'left');
		$this->db->join('customer cli2', 'opposition.customer_id=cli2.customer_id', 'left');
		$this->db->join('routes a', 'opposition.routes_id=a.routes_id', 'left');
		$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
		$this->db->join('loanstype lt', 'opposition.loanstype_id=lt.loanstype_id', 'left');

		$this->db->where('opposition.company_id', $this->session->userdata('company_id'));
		$this->db->where('con.due_date >=', $date1);
		$this->db->where('con.due_date <=', $date2);
		
		if(isset($customer_field) && $customer_field != ""){
			$this->db->where('opposition.customer_id', $customer_field);
		}
		if(isset($routes_field) && $routes_field != ""){
			$this->db->where('opposition.routes_id', $routes_field);
		}
		if(isset($paymentno_field) && $paymentno_field != ""){
			$this->db->where('con.payment_no', $paymentno_field);
		}
		if(isset($receipt_paid) && $receipt_paid != "0"){
			$this->db->where('printed', 'yes');
		}
		else {
			$this->db->where('printed', 'no');
		}
		$this->db->where('return_p', 'no');
		$this->db->order_by('customer_first_name', 'ASC');
		
		$sendserver_pagados = $_POST['receipt_paid'];
		$data['sendserver_pagados'] = $sendserver_pagados;
		
		$data['customer_name_field'] = $customer_name_field;
		$data['customer_field'] = $customer_field;
		
		$data['routes_name_field'] = $routes_name_field;
		$data['routes_field'] = $routes_field;
		$data['paymentno_field'] = $paymentno_field;
		
		$data['recored'] = $this->db->get('opposition')->result();
		$this->load->view('admin/opposition/loans-receipt',$data);
	}
		
	public function active_inactive($id,$mode)
	{
		$this->opposition_model->change_status($id,$mode);
		return redirect('opposition');
	}

	
	/*
	* It gets the product id and fetch the order data. 
	* The order print logic is done here 
	*/
	public function printTransactionDiv($order_id, $id)
	{
		if($id) {
			$transaction = $this->opposition_model->getTransactionByID($id);
			$order_data = $this->opposition_model->getOrdersData($order_id);
			$company_info = $this->company_model->findOne($this->session->userdata('company_id'));

			$order_date = date("d-m-Y", strtotime($transaction['creation_date']) );
			$transaction_date = date("d-m-Y", strtotime($transaction['payment_date']) );
			$paid_status = ($order_data['current_balance'] > 0) ? "A CRÉDITO" : "SALDADA";
						
			$CI =& get_instance();
			$company = $CI->get_company_data(); 

			// create new PDF document
			//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf = new TCPDF('L', 'mm', array(215.9, 93.21), true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor(' powered by PBwDesign');
			$pdf->SetTitle('Reporte de Préstamos');
			$pdf->SetSubject('PDF');
			$pdf->SetKeywords('TCPDF, PDF, Reporte de Préstamos, Préstamos, Pagos, Reporte');

			// remove default header/footer
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);

			$this->pageWidth=421;                     
			$this->pageHeight=595;

			// set header and footer fonts
			//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set margins
			$pdf->SetMargins(10, $transaction['transactions_type'] == "CAPITAL" ? 4 : 8, 10, 0);
			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
						
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------

			// set font
			$pdf->SetFont("helvetica", "",11);

			// add a page
			$pdf->AddPage();

			setlocale(LC_MONETARY,"es_DO");
			$base_url = base_url();
			$user_data = $this->users_model->findOne($this->session->userdata('userid'));
			$id_pad = str_pad($id, 8, "0", STR_PAD_LEFT);
			$transaction_amount = sprintf("%1\$.2F", $transaction['amount']);

			$customer_first_name = rtrim($order_data['customer_first_name'], ' ');
			
			$original_loan_amount = $transaction['transactions_type'] == "CAPITAL" ? '<tr>
				<td class="text-left" colspan="2" border="1">CAPITAL PRESTADO</td>
				<td class="text-right" border="1">'.$order_data['loans_amount'].'</td>
			</tr>' : "";
			$transaction_detail = '<tr>
				<td class="text-left" colspan="2" border="1">'.($transaction['transactions_type'] == "CAPITAL" ? 'ABONO AL '.$transaction['transactions_type'] : $transaction['transactions_type']).'</td>
				<td class="text-right" border="1">'.$transaction_amount.'</td>
			</tr>';
			$current_loan_amount = $transaction['transactions_type'] == "CAPITAL" ? '<tr>
				<td class="text-left" colspan="2" border="1">BALANCE</td>
				<td class="text-right" border="1">'.$order_data['current_balance'].'</td>
			</tr>' : "";

			$bootstrap_css = '<style>'.file_get_contents('https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css').'</style>';

			$output = <<<EOF
			<!-- EXAMPLE OF CSS STYLE -->
			{$bootstrap_css}
			<style>
			#invoice{overflow: hidden;padding:10px 30px}.invoice{position:relative;background-color:#fff;min-height:380px;padding:1px}.invoice header{padding:0;margin-bottom:10px;border-bottom:1px solid #3989c6} .company-details{text-align:left}.company-details .name{margin-top:0;margin-bottom:0} .contacts{margin-bottom:10px}.invoice-to{text-align:left}.to{font-size: x-large;margin-top:0;margin-bottom:0;text-transform: uppercase;}.invoice-details{text-align:right} .invoice-id{font-size: xx-large;margin-top:0;color:#3989c6}main .thanks{margin-top:10px;}main .notices{padding-left:6px;border-left:6px solid #3989c6}main .notices .notice{font-size:1.2em}table{width:100%;border-collapse:collapse;border-spacing:0;margin-bottom:0}table td,table th{padding:3px;background:#eee;border-bottom:1px solid #fff}table th{white-space:nowrap;font-weight:400;font-size:16px}table td h3{margin:0;font-weight:400;color:#3989c6;font-size:1.2em}table .qty,table .total,table .unit{text-align:right;font-size:1.2em}table .no{color:#fff;font-size:1.6em;background:#3989c6}table .unit{background:#ddd}table .total{background:#3989c6;color:#fff}table tbody tr:last-child td{border:none}table tfoot td{background:0 0;border-bottom:none;white-space:nowrap;text-align:right;padding:0;border-top:1px solid #aaa}table tfoot tr:first-child td{border-top:none}table tfoot tr:last-child td{color:#3989c6;border-top:1px solid #3989c6}table tfoot tr td:first-child{border:none}footer{width:100%;text-align:center;color:#777;padding:0}
			</style>
			<table width="100%" class="display" style="font-size:10px">
				<tr style="">
					<td width="68%">
						<div><span style="font-size:22px;font-weight:900;">{$company[0]->company_name}</span><br>
						{$company[0]->company_address}{$company[0]->company_city}<br>&nbsp;{$company[0]->company_phone} • {$company[0]->company_email}<br>Fecha: {$order_date}</div>
					</td>
					<td width="32%" style="text-align:center"><img src="{$base_url}file/company/{$company[0]->company_image}" height="80" width="80" /></td>
				</tr>
				<tr><td colspan="2"><hr></td></tr>
				<tr>
					<td>
						<div><span class="text-gray-light">CLIENTE:</span><br>
						<span class="to">{$customer_first_name}</span><br>
						{$order_data['customer_address']}<br>{$order_data['customer_phone']}</div>
					</td>
					<td>
						<div><span class="to">RECIBO DE PAGO</span>
						<br>Recibo No.: {$id_pad}<br>Fecha de pago: {$transaction_date}<br>Atendido por: {$user_data['user_fullname']}</div>
					</td>
				</tr>
				</table>
				
				<table width="100%" class="" style="border:1px solid #000;font-size:10px" border="1" cellspacing="1" cellpadding="1">
				<thead>
				<tr>
					<th class="text-left" colspan="2" border="1"><b>CONCEPTO</b></th>
					<th class="text-right" border="1"><b>VALOR</b></th>
				</tr>
				</thead>
				<tbody>
				{$original_loan_amount}
				{$transaction_detail}
				{$current_loan_amount}
				</tbody>
			</table>
			<span class="thanks" style="font-size:10px;text-align:center">{$company_info['company_slogan']}</span>
			EOF;			

			//echo $output;
			// output the HTML content
			$pdf->writeHTML($output, true, false, true, false, '');

			//Close and output PDF document
			$pdf->Output('Recibo_de_Pago.pdf', 'I');

			//============================================================+
			// END OF FILE
			//============================================================+
		}
	}
	public function printTransactionDivBackup($order_id, $id)
	{
		if($id) {
			$transaction = $this->opposition_model->getTransactionByID($id);
			$order_data = $this->opposition_model->getOrdersData($order_id);
			$company_info = $this->company_model->findOne($this->session->userdata('company_id'));

			$order_date = date("d-m-Y", strtotime($transaction['creation_date']) );
			$transaction_date = date("d-m-Y", strtotime($transaction['payment_date']) );
			$paid_status = ($order_data['current_balance'] > 0) ? "A CRÉDITO" : "SALDADA";
			
			setlocale(LC_MONETARY,"es_DO");
			$html = '<!-- Main content -->
			<!DOCTYPE html>
			<html>
			<head>
				<meta charset="utf-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<title>'.$company_info['company_name'].' | Factura</title>
				<!-- Tell the browser to be responsive to screen width -->
				<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
				<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
				<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
				<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
				<style>
				#invoice{overflow: hidden;padding:10px 30px}.invoice{position:relative;background-color:#fff;min-height:380px;padding:1px}.invoice header{padding:0;margin-bottom:10px;border-bottom:1px solid #3989c6}.invoice .company-details{text-align:left}.invoice .company-details .name{margin-top:0;margin-bottom:0}.invoice .contacts{margin-bottom:10px}.invoice .invoice-to{text-align:left}.invoice .invoice-to .to{font-size: x-large;margin-top:0;margin-bottom:0;text-transform: uppercase;}.invoice .invoice-details{text-align:right}.invoice .invoice-details .invoice-id{font-size: xx-large;margin-top:0;color:#3989c6}.invoice main .thanks{margin-top:10px;}.invoice main .notices{padding-left:6px;border-left:6px solid #3989c6}.invoice main .notices .notice{font-size:1.2em}.invoice table{width:100%;border-collapse:collapse;border-spacing:0;margin-bottom:0}.invoice table td,.invoice table th{padding:3px;background:#eee;border-bottom:1px solid #fff}.invoice table th{white-space:nowrap;font-weight:400;font-size:16px}.invoice table td h3{margin:0;font-weight:400;color:#3989c6;font-size:1.2em}.invoice table .qty,.invoice table .total,.invoice table .unit{text-align:right;font-size:1.2em}.invoice table .no{color:#fff;font-size:1.6em;background:#3989c6}.invoice table .unit{background:#ddd}.invoice table .total{background:#3989c6;color:#fff}.invoice table tbody tr:last-child td{border:none}.invoice table tfoot td{background:0 0;border-bottom:none;white-space:nowrap;text-align:right;padding:0;border-top:1px solid #aaa}.invoice table tfoot tr:first-child td{border-top:none}.invoice table tfoot tr:last-child td{color:#3989c6;border-top:1px solid #3989c6}.invoice table tfoot tr td:first-child{border:none}.invoice footer{width:100%;text-align:center;color:#777;padding:0}@media print{.invoice{font-size:11px!important;overflow:hidden!important}.invoice footer{position:absolute;bottom:0;page-break-after:always}.invoice>div:last-child{page-break-before:always}}
				</style>
				<style>
				@media print {
					@page {
						size: auto;
						margin: 0;
					}					
					@page :first {
						//used for the first page.;
						//margin: 1cm 2cm;
					}
					.noPrint{ display:none;
					body { line-height: 1.0; }
				}
				</style>
			</head>
			<body onload="window.print();">
			<div class="wrapper">
				<div id="invoice">
					<div class="invoice overflow-auto">
						<div style="min-width: 600px">
								<header>
									<div class="row">
										<div class="col company-details">
											<h2 class="name">'.$company_info['company_name'].'</h2>
											<div>'.$company_info['company_address'].'</div>
											<div>'.$company_info['company_phone'].' • '.$company_info['company_email'].'</div>
											<div>Fecha: '.$order_date.'</div>
										</div>
										<div class="col">
											<a target="_blank" href="#" style="float: right;">
													<img src="'.base_url().'file/company/'.$company_info['company_image'].'" width="100" height="100" class="img-circle">
													</a>
										</div>
									</div>
								</header>
								<main>
										<div class="row contacts">
											<div class="col-7 invoice-to">
												<div class="text-gray-light">CLIENTE:</div>
												<h2 class="to">'.$order_data['customer_first_name'].'</h2>
												<div class="address">'.$order_data['customer_address'].'</div>
												<div class="email">'.$order_data['customer_phone'].'</div>
											</div>
											<div class="col invoice-details">';
										$user_data = $this->users_model->findOne($this->session->userdata('userid'));
										$html .= '
												<h1 class="invoice-id">RECIBO DE PAGO</h1>
												<div class="date">Recibo No.: '.str_pad($id, 8, "0", STR_PAD_LEFT).' Fecha de pago: '.$transaction_date.'</div>
												<div class="date">Atendido por: '.$user_data['user_fullname'].'</div>
											</div>
										</div>
										<table border="0" cellspacing="0" cellpadding="0">
											<thead>
												<tr>
														<th class="text-left" colspan="2">CONCEPTO</th>
														<th class="text-right">VALOR</th>
												</tr>
											</thead>
											<tbody>
											<tr>
												<td class="text-left" colspan="2"><h3>'.$transaction['transactions_type'].'</h3></td>
												<td class="text-right">'.sprintf("%1\$.2F", $transaction['amount']).'</td>
											</tr>
											</tbody>
											<tfoot>';
																							
												/* $html .= '
												<tr>
													<td rowspan="3">'.$company_info['company_slogan'].'</td>
													<td>MONTO PRESTADO:</td>
													<td>'. $order_data['loans_amount'] .'</td>
												</tr>';

											$total_capital_paid = $this->opposition_model->countTotalPaidTransaction($order_id, $transaction['transactions_type']);
											if( floatval($total_capital_paid['amount']) > 0){
												$html .= '
												<tr>
													<td>TOTAL PAGOS DE '.$transaction['transactions_type'].':</td>
													<td>';
												$html .= sprintf("%1\$.2F", $total_capital_paid['amount']);
												$html .= '</td>
												</tr>';
											}
												$html = '
												<tr>
													<td>BALANCE:</td>
													<td>';
												$balance = $order_data['interes'] - $discount - $total_paid['amount'];
												$html .= sprintf("%1\$.2F", $balance).'</td>
												</tr>'; */

												$html .= '
											</tfoot>
											</table>
									<footer>
										<div class="thanks">'.$company_info['company_slogan'].'</div>
									</footer>
								</main>
								<a href="'.base_url().'opposition/" class="text-center btn btn-outline-primary hidden-print noPrint">Regresar</a>
							</div>
						</div>
					</div>
				</div>
			</body>
			</html>';

			echo $html;
		}
	}

	public function printPaymentReceipt($id, $order_id)
	{
		if($id) {
			$transaction = $this->opposition_model->getTransactionByID($id);
			$order_data = $this->opposition_model->getOrdersData($order_id);
			$company_info = $this->company_model->findOne($this->session->userdata('company_id'));

			$order_date = date("d-m-Y", strtotime($order_data['entry_date']) );
			$transaction_date = date("d-m-Y", strtotime($transaction['creation_date']) );
			$paid_status = ($order_data['current_balance'] > 0) ? "A CRÉDITO" : "SALDADA";

			setlocale(LC_MONETARY,"es_DO");
			$o_date = date('Y-m-d',strtotime($order_date));
			$t_date = date('Y-m-d',strtotime($transaction_date));
			$html = '<!-- Main content -->
			<!DOCTYPE html>
			<html>
			<head>
				<meta charset="utf-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<title>'.$company_info['company_name'].' | Factura</title>
				<!-- Tell the browser to be responsive to screen width -->
				<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
				<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
				<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
				<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
			</head>
			<body onload="window.print();">
			<div class="container">
				<div class="row">
					<div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6">
								<address>
									<strong>'.$company_info['company_name'].'</strong>
									<br>
									RNC '.$company_info['company_rnc'].'
									<br>
									'.$company_info['company_address'].'
									<br>
									<abbr title="Teléfono">T:</abbr> '.$company_info['company_phone'].'
									<br>
									<abbr title="Email">E:</abbr> '.$company_info['company_email'].'
								</address>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 text-right">
								<p><em>Fecha: '.$transaction_date.'</em></p>
								<p><em>Recibo #: '.str_pad($id, 8, "0", STR_PAD_LEFT).'</em></p>
											<p>'; $user_data = $this->users_model->findOne($this->session->userdata('userid'));
										$html .= ' <em>Atendido por: '.$user_data['user_fullname'].'</em> </p>
							</div>
						</div>
						<div class="row">
							<div class="text-center">
								<img src="'.base_url().'file/company/'.$company_info['company_image'].'" width="100" height="100" class="img-circle">
								<h1>RECIBO DE PAGO</h1>
								<div class="row contacts">
									<div class="col invoice-to">
										<div class="text-gray-light">CLIENTE:</div>
										<h2 class="to">'.$order_data['customer_first_name'].'</h2>
										<div class="address">'.$order_data['customer_address'].'</div>
										<div class="email">'.$order_data['customer_phone'].'</div>
									</div>
								</div>
							
							</div>
							</span>
							<table class="table table-hover">
								<thead>
									<tr>
										<th>CONCEPTO</th>
										<th class="text-right">MONTO</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="col-md-10"><em>'.$transaction['concept'].'</em></td>
										<td class="col-md-2 text-right">'.sprintf("%1\$.2F", $transaction['amount']).'</td>
									</tr>
									<tr>
										<td class="text-right">
										<p><strong>Total facturado: </strong></p>
										<p><strong>Descuento: </strong></p>
										<p><strong>Total pagado a la fecha: </strong></p></td>
										<td class="text-right">
										<p><strong>'.sprintf("%1\$.2F", $order_data['gross_amount']).'</strong></p>
										<p><strong>'; $discount = $order_data['discount'] ? $order_data['discount']:0; $html .= sprintf("%1\$.2F", $discount).'</strong></p>
										<p><strong>'; $total_paid = $this->opposition_model->countTotalPaidOrdersTransactionByDate($order_id); $html .= sprintf("%1\$.2F", $total_paid['amount']).'</strong></p></td>
									</tr>
									<tr>
										<td class="text-right"><h4><strong>Balance: </strong></h4></td>
										<td class="text-right text-danger"><h4><strong>';
												$balance = $order_data['gross_amount'] - $discount - $total_paid['amount'];
												$html .= sprintf("%1\$.2F", $balance).'</strong></h4></td>
									</tr>
								</tbody>
							</table>
							<div>
								<h1 style="text-align:center;">¡Gracias por su pago!</h1>
								<p>'.$company_info['company_slogan'].'</p>
							</div>
						</div>
					</div>		
				</div>
			</body>
		</html>';

			echo $html;
		}
	}

	/*
	* It gets the product id and fetch the order data. 
	* The order print logic is done here 
	*/
	public function printDiv($id)
	{
		if($id) {
			$order_data = $this->opposition_model->getOrdersData($id);
			$company_info = $this->company_model->findOne($this->session->userdata('company_id'));

			$order_date = $order_data['entry_date'];
			$paid_status = ($order_data['current_balance'] > 0) ? "A CRÉDITO" : "SALDADA";

			setlocale(LC_MONETARY,"es_DO");

			$html = '<!-- Main content -->
			<!DOCTYPE html>
			<html>
			<head>
				<meta charset="utf-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<title>'.$company_info['company_name'].' | Factura</title>
				<!-- Tell the browser to be responsive to screen width -->
				<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
				<!-- Bootstrap 3.3.7 -->
				<link rel="stylesheet" href="'.base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css').'">
				<!-- Font Awesome -->
				<link rel="stylesheet" href="'.base_url('assets/bower_components/font-awesome/css/font-awesome.min.css').'">
				<link rel="stylesheet" href="'.base_url('assets/dist/css/AdminLTE.min.css').'">
					<style>.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{padding:0}</style>
			</head>
			<body onload="window.print();">
			
			<div class="wrapper">
				<section class="invoice">
					<!-- title row -->
					<div class="row">
					<div class="col-xs-12">
						<h2 class="page-header" style="text-align:center">
							<img src="'.base_url().'file/company/'.$company_info['company_image'].'" width="100" height="100" class="img-circle"><br>
								'.$company_info['company_name'].'<br>
							<small>
							<span style="font-style:italic">'.$company_info['company_slogan'].'</span><br>   
							'.$company_info['company_address'].'<br>
							TEL.'.$company_info['company_phone'].'<br>
							</small>
						</h2>
					</div>
					<!-- /.col -->
					</div>
						<div class="row">
					<div class="col-xs-12">';
							$user_data = $this->users_model->findOne($this->session->userdata('userid'));
						
						$html .= '<small class="pull-left"><b>LE ATENDIÓ:</b> '.$user_data['user_fullname'].'</small>
						<small class="pull-right"><b>FECHA:</b> '.$order_date.'</small>
					</div>
					<!-- /.col -->
					</div>
					<!-- info row -->
					<div class="row invoice-info">
					
					<div class="col-xs-12">
						<br>
						<b>FACTURA NO:</b> '.$order_data['loans_no'].'<br>
						<b>CLIENTE:</b> '.$order_data['customer_first_name'].'<br>
							<b>CÉDULA:</b> ' .$order_data['customer_personalid'].'<br>
						<b>DIRECCIÓN:</b> '.$order_data['customer_phone'].'<br>
						<b>TELÉFONO:</b> '.$order_data['customer_address'].'
					</div>
					<!-- /.col -->
					</div>
					<!-- /.row -->

					<div class="row invoice-info">
					<div class="col-xs-12 col-sm-12">
						<hr class="">
						<p style="font-weight:600;text-align:center">FACTURA PARA CONSUMIDOR FINAL</p>
						<hr class="">
					</div>
					<!-- /.col -->
					</div>                  
					<!-- /.row -->

					<!-- Table row -->
					<div class="row">
					<div class="col-xs-12 table-responsive">
						<table class="table table-striped">
							<thead>
							<tr>
							<th>CANT.</th>
							<th>CONCEPTO</th>
							<th>PRECIO</th>
							<th>MONTO</th>
							</tr>
							</thead>
							<tbody>';
							
							$html .= '<tr>
								<td>'.$order_data['cuota'].'</td>
								<td>'.$order_data['customer_first_name'].'</td>
								<td>'.sprintf("%1\$.2F", $order_data['interes']).'</td>
								<td>'.sprintf("%1\$.2F", $order_data['amount']).'</td>
							</tr>';
							
							$html .= '</tbody>
						</table>
					</div>
					<!-- /.col -->
					</div>
					<!-- /.row -->

					<div class="row">

					<div class="col-sm-6 pull pull-right">

						<div class="table-responsive">
							<table class="table">
							<tr>
								<th style="width:50%">SUB-TOTAL:</th>
								<td>'.sprintf("%1\$.2F", $order_data['gross_amount']).'</td>
							</tr>';

							if($order_data['service_charge'] > 0) {
								$html .= '<tr>
									<th>Otros ('.$order_data['service_charge_rate'].'%)</th>
									<td>'.sprintf("%1\$.2F", $order_data['service_charge']).'</td>
								</tr>';
							}

							if($order_data['vat_charge'] > 0) {
								$html .= '<tr>
									<th>ITBIS ('.$order_data['vat_charge_rate'].'%)</th>
									<td>'.sprintf("%1\$.2F", $order_data['vat_charge']).'</td>
								</tr>';
							}
							
							if($order_data['discount'] > 0) {			            
										$html .= '<tr>
										<th>DESCUENTO:</th>
										<td>'.sprintf("%1\$.2F", $order_data['discount']).'</td>
										</tr>';
							}

							$html .= '<tr>
								<th>TOTAL:</th>
								<td>'.sprintf("%1\$.2F", $order_data['loans_amount']).'</td>
							</tr>
								<tr>
								<th>TOTAL PAGADO:</th>
								<td>'.sprintf("%1\$.2F", $order_data['due_amount']).'</td>
							</tr>
								<tr>
								<th>BALANCE:</th>
								<td>'.sprintf("%1\$.2F", $order_data['current_balance']).'</td>
							</tr>                        
							</table>
						</div>
					</div>
					<!-- /.col -->
					</div>
					<!-- /.row -->
					<div class="row invoice-info">
					<div class="col-xs-12">
						<b>NOTA/OBS:</b> FACTURA '.$paid_status.'. '.$order_data['notes'].'<br>
					</div>
					<!-- /.col -->
					</div>                  
					<!-- /.row -->
					<div class="row invoice-info">
					<div class="col-xs-12">
						<hr class=""><div style="text-align:center">'.$company_info['company_slogan'].'</div>
					</div>
					<!-- /.col -->
					</div>                  
					<!-- /.row -->
						
				</section>
				<!-- /.content -->
			</div>
		</body>
	</html>';

			echo $html;
		}
	}

	/*
	* It gets the product id and fetch the order data. 
	* The order print logic is done here 
	*/
	public function posReceiptInvoice($id)
	{
		if($id) {
			$order_data = $this->opposition_model->getOrdersData($id);
			$company_info = $this->company_model->findOne($this->session->userdata('company_id'));

			$order_date = date("d-m-Y", strtotime($order_data['entry_date']) );
			$paid_status = ($order_data['current_balance'] > 0) ? "A CRÉDITO" : "SALDADA";

			setlocale(LC_MONETARY,"es_DO");
			
			$html = '<!-- Main content -->
			<!DOCTYPE html>
			<html>
			<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<title>'.$company_info['company_name'].' | Factura</title>
			<!-- Tell the browser to be responsive to screen width -->
			<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
			<style>body{font-family: monospace;}#invoice-POS {box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);padding: 2mm;margin: 0 auto;width: 44mm;background: #FFF;}#invoice-POS ::selection {background: #f31544;color: #FFF;}#invoice-POS ::moz-selection {background: #f31544;color: #FFF;}#invoice-POS h1 {font-size: 1.5em;color: #222;}#invoice-POS h2 {font-size: .9em;}#invoice-POS h3 {font-size: .7em;font-weight: 300;}#invoice-POS p {font-size: .7em;color: #666;line-height: 1.2em;}#invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {border-bottom: 1px solid #EEE;}#invoice-POS #top {min-height: 100px;}#invoice-POS #mid {min-height: 80px;}#invoice-POS #bot {min-height: 50px;}#invoice-POS #top .company_image {height: 60px;width: 60px;background: url("'.base_url('file/company/'.$company_info['company_image']).'") no-repeat;background-size: 60px 60px;}#invoice-POS .clientlogo {float: left;height: 60px;width: 60px;background: url("'.base_url('assets/images/User-64.png').'") no-repeat;background-size: 60px 60px;border-radius: 50px;}#invoice-POS .info {display: block;margin-left: 0;}#invoice-POS .title {float: right;}#invoice-POS .title p {text-align: right;}#invoice-POS table {width: 100%;border-collapse: collapse;}#invoice-POS .tabletitle {font-size: .5em;background: #EEE;}#invoice-POS .tabletitle .Rate {padding: 0 7px;}#invoice-POS .service {border-bottom: 1px solid #EEE;}#invoice-POS .item {width: 24mm;}#invoice-POS .itemtext {font-size: .5em;}#invoice-POS .itemnumber {text-align:right;}#invoice-POS #legalcopy {margin-top: 5mm;text-align:center;}</style>
			</head>
			<body>
				<div id="invoice-POS">

					<center id="top">
						<div class="logo"></div>
						<div class="info"> 
						<h2 class="name">
							<a target="_blank" href="'.base_url().'">
							'.$company_info['company_name'].'
							</a><br><span style="font-style:italic;font-size:small;">'.$company_info['company_slogan'].'</span>
						</h2>
						<p>
							RNC '.$company_info['company_rnc'].'</br>
							'.$company_info['company_address'].'</br>
							'.$company_info['company_phone'].' • '.$company_info['company_email'].'</br>
						</p>
						</div><!--End Info-->
					</center><!--End InvoiceTop-->

					<div id="mid">
						<div class="info">
						<h3 class="invoice-id" style="border:double #666;padding:.2em;text-align: center;">Factura a Consumidores</h3>
						<p class="">';
						$user_data = $this->users_model->findOne($this->session->userdata('userid'));
						$html .= '
							Factura No.: '.$order_data['loans_no'].'</br>
							Fecha: '.$order_date.'</br>
							Atendido por: '.$user_data['user_fullname'].'</br>
						</p>
						</div>
						<div class="info">
						<h3>CLIENTE</h3>
						<p> 
							<strong>'.$order_data['customer_first_name'].'</strong></br>';
							if(!isset($order_data['customer_address'])) { $html .= $order_data['customer_address'].'</br>'; }
							if(!isset($order_data['customer_phone'])) { $html .= $order_data['customer_phone'].'</br>'; }
						$html .= '</p>
						</div>
					</div><!--End Invoice Mid-->

					<div id="bot">
						<div id="table">
							<table>
								<tr class="tabletitle">
									<td class="Rate"><h2>#</h2></td>
									<td class="item"><h2>Concepto</h2></td>
									<td class="Rate"><h2>Precio</h2></td>
									<td class="Rate"><h2>Subtotal</h2></td>
								</tr>								
								';
								
								$html .= '<tr class="service">
										<td class="tableitem"><p class="itemtext">'.$order_data['cuota'].'</p></td>
										<td class="tableitem"><p class="itemtext">'.$order_data['customer_first_name'].'</p></td>
										<td class="tableitem"><p class="itemtext">'.sprintf("%1\$.2F", $order_data['interes']).'</p></td>
										<td class="itemnumber"><p class="itemtext">'.sprintf("%1\$.2F", $order_data['payment']).'</p></td>
								</tr>';
								
								$html .= '
								<tr class="tabletitle">
									<td colspan="2"></td>
									<td class="Rate"><h2>SUBTOTAL</h2></td>
									<td class="itemnumber"><h2>'.sprintf("%1\$.2F", $order_data['gross_amount']).'</h2></td>
								</tr>';

								if($order_data['service_charge'] > 0) {
									$html .= '<tr class="tabletitle">
										<td colspan="2"></td>
										<td class="Rate"><h2>Otros ('.$order_data['service_charge_rate'].'%)</h2></td>
										<td class="itemnumber"><h2>'.sprintf("%1\$.2F", $order_data['service_charge']).'</h2></td>
									</tr>';
								}

								if($order_data['vat_charge'] > 0) {
									$html .= '<tr class="tabletitle">
										<td colspan="2"></td>
										<td class="Rate"><h2>ITBIS ('.$order_data['vat_charge_rate'].'%)</h2></td>
										<td class="itemnumber"><h2>'.sprintf("%1\$.2F", $order_data['vat_charge']).'</h2></td>
									</tr>';
								}

								if($order_data['discount'] > 0) {			            
									$html .= '<tr class="tabletitle">
										<td colspan="2"></td>
										<td class="Rate"><h2>DESCUENTO:</h2></td>
										<td class="itemnumber"><h2>'.sprintf("%1\$.2F", $order_data['discount']).'</h2></td>
									</tr>';
								}

								$html .= '<tr class="tabletitle">
									<td colspan="2"></td>
									<td class="Rate"><h2>TOTAL:</h2></td>
									<td class="itemnumber"><h2>'.sprintf("%1\$.2F", $order_data['loans_amount']).'</h2></td>
								</tr>
								<tr class="tabletitle">
									<td colspan="2"></td>
									<td class="Rate"><h2>TOTAL PAGADO:</h2></td>
									<td class="itemnumber"><h2>'.sprintf("%1\$.2F", $order_data['due_amount']).'</h2></td>
								</tr>
								<tr class="tabletitle">
									<td colspan="2"></td>
									<td class="Rate"><h2>BALANCE:</h2></td>
									<td class="itemnumber"><h2>'.sprintf("%1\$.2F", $order_data['current_balance']).'</h2></td>
								</tr>
							</table>
						</div><!--End Table-->

						<div id="legalcopy">
							<p class="legal"><strong>FACTURA '.$paid_status.'.</strong></p>
							<p class="info">🖶 '.date('d-m-Y h:i a').'</p>
							<p class="info"><strong>¡Gracias por preferirnos!</strong></p>
							<p class="info">'.$order_data['notes'].'</p>
							<div style="font-size: .6em;">'.$company_info['company_slogan'].'</div>
						</div>

					</div><!--End InvoiceBot-->
				</div><!--End Invoice-->
			</body>
		</html>';

			echo $html;
		}
	}

	public function printResponsiveInvoice($id)
	{
		if($id) {
			$order_data = $this->opposition_model->getOrdersData($id);
			$company_info = $this->company_model->findOne($this->session->userdata('company_id'));

			$order_date = date("d-m-Y", strtotime($order_data['entry_date']) );
			$paid_status = ($order_data['current_balance'] > 0) ? "A CRÉDITO" : "SALDADA";

			setlocale(LC_MONETARY,"es_DO");

			$html = '<!-- Main content -->
			<!DOCTYPE html>
			<html>
			<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<title>'.$company_info['company_name'].' | Factura</title>
			<!-- Tell the browser to be responsive to screen width -->
			<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
			<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
			<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
			<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
			<style>
			#invoice{padding:10px 30px}.invoice{position:relative;background-color:#fff;min-height:380px;padding:5px}.invoice header{padding:0;margin-bottom:10px;border-bottom:1px solid #3989c6}.invoice .company-details{text-align:left}.invoice .company-details .name{margin-top:0;margin-bottom:0}.invoice .contacts{margin-bottom:10px}.invoice .invoice-to{text-align:left}.invoice .invoice-to .to{font-size: x-large;margin-top:0;margin-bottom:0;text-transform:uppercase;}.invoice .invoice-details{text-align:right}.invoice .invoice-details .invoice-id{font-size: xx-large;margin-top:0;color:#3989c6}.invoice main .thanks{margin-top:10px;}.invoice main .notices{padding-left:6px;border-left:6px solid #3989c6}.invoice main .notices .notice{font-size:1.2em}.invoice table{width:100%;border-collapse:collapse;border-spacing:0;margin-bottom:0}.invoice table td,.invoice table th{padding:3px;background:#eee;border-bottom:1px solid #fff}.invoice table th{white-space:nowrap;font-weight:400;font-size:16px}.invoice table td h3{margin:0;font-weight:400;color:#3989c6;font-size:1.2em}.invoice table .qty,.invoice table .total,.invoice table .unit{text-align:right;font-size:1.2em}.invoice table .no{color:#fff;font-size:1.6em;background:#3989c6}.invoice table .unit{background:#ddd}.invoice table .total{background:#3989c6;color:#fff}.invoice table tbody tr:last-child td{border:none}.invoice table tfoot td{background:0 0;border-bottom:none;white-space:nowrap;text-align:right;padding:0;border-top:1px solid #aaa}.invoice table tfoot tr:first-child td{border-top:none}.invoice table tfoot tr:last-child td{color:#3989c6;border-top:1px solid #3989c6}.invoice table tfoot tr td:first-child{border:none}.invoice footer{width:100%;text-align:center;color:#777;padding:0}@media print{.invoice{font-size:11px!important;overflow:hidden!important}.invoice footer{position:absolute;bottom:0;page-break-after:always}.invoice>div:last-child{page-break-before:always}}
			</style>
			</head>
			<body onload="window.print();">

			<div class="wrapper">
				<!--Author      : @arboshiki-->
				<div id="invoice">
						<div class="invoice overflow-auto">
							<div style="min-width: 600px">
								<header>
										<div class="row">
											<div class="col company-details">
												<h2 class="name">
													'.$company_info['company_name'].'
													<br><small><span style="font-style:italic;font-size:large;">'.$company_info['company_slogan'].'</span></small>
												</h2>
												<div>RNC '.$company_info['company_rnc'].'</div>
												<div>'.$company_info['company_address'].'</div>
												<div>'.$company_info['company_phone'].' • '.$company_info['company_email'].'</div>
											</div>
											<div class="col">
												<a target="_blank" href="#" style="float: right;">
													<img src="'.base_url().'file/company/'.$company_info['company_image'].'" width="100" height="100" class="img-circle">
													</a>
											</div>
										</div>
								</header>
								<main>
										<div class="row contacts">
											<div class="col invoice-to">
												<div class="text-gray-light">CLIENTE:</div>
												<h2 class="to">'.$order_data['customer_first_name'].'</h2>
												<div class="address">'.$order_data['customer_address'].'</div>
												<div class="email">'.$order_data['customer_phone'].'</div>
											</div>
											<div class="col invoice-details">';
										$user_data = $this->users_model->findOne($this->session->userdata('userid'));
										$html .= '
												<h1 class="invoice-id">'.$order_data['loans_no'].'</h1>
												<div class="date">Fecha: '.$order_date.'</div>
												<div class="date">Atendido por: '.$user_data['user_fullname'].'</div>
											</div>
										</div>
										<table border="0" cellspacing="0" cellpadding="0">
											<thead>
												<tr>
													<th>#</th>
													<th class="text-left">CONCEPTO</th>
													<th class="text-right">PRECIO</th>
													<th class="text-right">TOTAL</th>
												</tr>
											</thead>
											<tbody>';
												
												$html .= '<tr>
													<td class="no">'.$order_data['cuota'].'</td>
													<td class="text-left"><h3>'.$order_data['customer_first_name'].'</h3></td>
													<td class="unit">'.sprintf("%1\$.2F", $order_data['interes']).'</td>
													<td class="total">'.sprintf("%1\$.2F", $order_data['payment']).'</td>
												</tr>';
												
												$html .= '</tbody>
											<tfoot>
												<tr>
													<td colspan="2"></td>
													<td>SUBTOTAL</td>
													<td>'.sprintf("%1\$.2F", $order_data['gross_amount']).'</td>
												</tr>';

											if($order_data['service_charge'] > 0) {
												$html .= '<tr>
													<td colspan="2"></td>
													<td>Otros ('.$order_data['service_charge_rate'].'%)</td>
													<td>'.sprintf("%1\$.2F", $order_data['service_charge']).'</td>
												</tr>';
											}

											if($order_data['vat_charge'] > 0) {
												$html .= '<tr>
													<td colspan="2"></td>
													<td>ITBIS ('.$order_data['vat_charge_rate'].'%)</td>
													<td>'.sprintf("%1\$.2F", $order_data['vat_charge']).'</td>
												</tr>';
											}

											if($order_data['discount'] > 0) {			            
												$html .= '<tr>
													<td colspan="2"></td>
													<td>DESCUENTO:</td>
													<td>'.sprintf("%1\$.2F", $order_data['discount']).'</td>
												</tr>';
											}

											$html .= '<tr>
												<td colspan="2"></td>
												<td>TOTAL:</td>
												<td>'.sprintf("%1\$.2F", $order_data['loans_amount']).'</td>
											</tr>
											<tr>
												<td colspan="2"></td>
												<td>TOTAL PAGADO:</td>
												<td>'.sprintf("%1\$.2F", $order_data['due_amount']).'</td>
											</tr>
											<tr>
												<td colspan="2"></td>
												<td>BALANCE:</td>
												<td>'.sprintf("%1\$.2F", $order_data['current_balance']).'</td>
											</tr>
										</tfoot>
									</table>
									<div class="thanks">¡Gracias por preferirnos!</div>
									<div class="notices">
										<div>NOTA:</div>
										<div class="notice">FACTURA '.$paid_status.'. '.$order_data['notes'].'</div>
									</div>
								</main>
								<footer>
									'.$company_info['company_slogan'].'
								</footer>
							</div>
							<!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
							<div></div>
						</div>
				</div>
			</div>
		</body>
	</html>';

			echo $html;
		}
	}

} 

?>