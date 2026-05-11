<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Loans_model extends CI_Model  { 

		
	public function __construct()
	{
		$this->load->database();
	}
	
	public function findAll()
	{
		$this->db->join('customer', 'loans.customer_id=customer.customer_id', 'left');
		$this->db->where('loans.company_id', $this->session->userdata('company_id'));
		$this->db->where('return_p =','no');
		$this->db->where('CURDATE() <','end_date', FALSE);
		$this->db->where('FechaFinalizado is NULL', NULL, FALSE);
		$this->db->order_by("loans_id", "desc");
		return $this->db->get('loans')->result();
	}
	
	public function findAllDue()
	{
		$this->db->join('customer', 'loans.customer_id=customer.customer_id', 'left');
		$this->db->where('loans.company_id', $this->session->userdata('company_id'));
		$this->db->where('return_p','no');
		$this->db->where('end_date <','CURDATE()', FALSE);
		//$this->db->where('FechaFinalizado is NOT NULL', NULL, FALSE);
		$this->db->order_by("loans_id", "desc");
		return $this->db->get('loans')->result();
	}
	
	public function findOne($id)
	{
		$this->db->join('customer', 'loans.customer_id=customer.customer_id', 'left');
		$this->db->join('routes', 'loans.routes_id=routes.routes_id', 'left');
		$this->db->join('collector', 'routes.collector_id=collector.collector_id', 'left');
		$this->db->join('loanstype', 'loans.loanstype_id=loanstype.loanstype_id', 'left');
		$this->db->where('loans.company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no',$id);
		return $this->db->get('loans')->result();
	}
		
	public function change_status($id,$mode)
	{
		$data=array('loans_is_active'=>$mode);
		$this->db->where('loans.company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_id',$id);
		$this->db->update('loans',$data);
	}
	public function delete_tmp_data($table_id)
	{
		$this->db->query("delete from loans_tmp WHERE table_id =". $table_id." AND admin_id =".$this->session->userdata('userid'));
	}
		
	public function insert($id = 0)
	{
		$loanstype_id = $_POST['txt_loanstype_id'];
		$loanstype_duration = $_POST['txt_loanstype_duration'];
		$loanstype_frequency = $_POST['txt_loanstype_frequency'];
		$entry_date = date('Y-m-d',  strtotime($_POST['txt_entry_date']));
		$start_date = date('Y-m-d',  strtotime($_POST['txt_start_date']));
		$loans_amount = $_POST['txt_loans_amount'];
		$end_date = date('Y-m-d',  strtotime($_POST['txt_end_date']));
		$due_amount = $_POST['txt_loans_total'];
		$cuota = $_POST['txt_cuota'];
		$capital = $_POST['txt_capital'];
		$interes = $_POST['txt_loanstype_interes'];
		$interes_amount = $_POST['txt_interes_amount'];
		//$interes_nogain = $_POST['txt_interes_nogain'];
		//$interes_gain = $_POST['txt_interes_gain'];
		$customer_id = $_POST['txt_customer_id'];
		$routes_id = $_POST['txt_routes_id'];
		$collector_id = $_POST['txt_collector_id'];

		$search="SELECT IFNULL((MAX(loans_no),0)+1) loans_no FROM loans WHERE company_id=".$this->session->userdata('company_id');
		$row = $this->db->query($search)->row_array();
		if(is_array($row))
		{ $_order_no=$row['loans_no']; }
		else
		{ $_order_no=1;}
		//$_order_no = date('HisdmY');
		
		$data = array(

			'user_id' => $this->session->userdata('userid'),
			'loans_no' => $_order_no,
			'entry_date' => $entry_date,
			'loanstype_id' => $loanstype_id,
			'duration' => $loanstype_duration,
			'start_date' => $start_date,
			'loans_amount' => $loans_amount,
			'end_date' => $end_date,
			'due_amount' => $due_amount,
			'cuota' => $cuota,
			'capital' => $capital,
			'interes' => $interes,
			'interes_amount' => $interes_amount,
			//'interes_nogain' => $interes_nogain,
			//'interes_gain' => $interes_gain,
			'customer_id' => $customer_id,
			'routes_id' => $routes_id,
			'collector_id' => $collector_id,
			'create_date' => date("Y-m-d"),
			'active' => 'yes',

		);

		$this->db->insert('loans', $data);

		/*
		$search="select * from customer where customer_first_name='".$_POST['txt_customer']."'";
			$row = $this->db->query($search)->row_array();
			$mobile =null;
			if(is_array($row))
			{
				$party_id=$row['customer_id'];
				$address=$row['customer_address'];
				$city=$row['customer_city'];
				$zipcode=$row['customer_zipcode'];
				$mobile=$row['customer_phone'];
				$email=$row['customer_email'];
				$gender=$row['customer_gender'];
				
			}
			$query = $this->db->query("select sms,sms_api from company where company_id = 1 ");
			$objcompany = $query->row_array();

			if($objcompany['sms'] == 'yes' && $objcompany['sms_api'] != '' ){
				//echo 'Hola';exit;
				$mo = $mobile;
				$mo=!empty($mo)?$mo:9979105467;
				$message = 'Estimado '.$_POST['txt_customer'].' Su prestamo ha sido registrado con nosotros exitosamente! Monto prestado : '.number_format($loans_amount,0).' ';
				$message = urlencode($message);
				$api =  $objcompany['sms_api'];
				$api = str_replace('xxxx',$mo,$api);
				$api = str_replace('yyyy',$message,$api);
				//echo $api;exit;
				
				$ch = curl_init($api);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$output = curl_exec($ch);      
				curl_close($ch); 
			}

		$q = 'UPDATE loan_number SET loan_perant_id= loan_perant_id + 1 WHERE loans_id = '.$billid.'';
		$this->db->query($q);*/
		
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no',$_order_no);
		$this->db->delete('loans_accounting');

		$_order_no;
		$grand_total = $due_amount;
		$updated_date = date("Y-m-d");
		
		switch ($loanstype_frequency) {
			case "Diario":
			$days = 1;
			break;
			case "Semanal":
			$days = 7;
			break;
			case "Quincenal":
			$days = 15;
			break;
			case "Mensual":
			$days = 1;
			break;
			case "Anual":
			$days = 365;
		}
		
		$end_date = new DateTime();
		
		for ($i = 1; $i <= $loanstype_duration; $i++) {
			
			if($loanstype_frequency == "Mensual"){
					date_add($end_date,date_interval_create_from_date_string("$days months"));
			} 
			else {
					date_add($end_date,date_interval_create_from_date_string("$days days"));
			}
		
			$data_g = array(

				'company_id' => $this->session->userdata('company_id'),
				'loans_no' => $_order_no,
				'payment_no' => $i,
				'due_date' => date_format($end_date,"Y-m-d"),
				'due_amount' => $grand_total ,
				'cuota' => $cuota,
				'capital' => $capital,
				'interes' => $interes_amount,
				//'fee_amount' => 0,
				//'advance_payment' => 0,
				//'payment' => 0,
				'balance' => ($grand_total - $cuota),
				'printed' => 'No',
				//'updated_date' => $updated_date
					
			);
			
			$grand_total -= $cuota;

			$this->db->insert('loans_accounting', $data_g);
		}

		return $_order_no;
	}
		
	public function update($id)
	{
		$loanstype_id = $_POST['txt_loanstype_id'];
		$loanstype_duration = $_POST['txt_loanstype_duration'];
		$entry_date = date('Y-m-d',  strtotime($_POST['txt_entry_date']));
		$start_date = date('Y-m-d',  strtotime($_POST['txt_start_date']));
		$loans_amount = $_POST['txt_loans_amount'];
		$end_date = date('Y-m-d',  strtotime($_POST['txt_end_date']));
		$due_amount = $_POST['txt_loans_total'];
		$cuota = $_POST['txt_cuota'];
		$capital = $_POST['txt_capital'];
		$interes = $_POST['txt_loanstype_interes'];
		$interes_amount = $_POST['txt_interes_amount'];
		//$interes_nogain = $_POST['txt_interes_nogain'];
		//$interes_gain = $_POST['txt_interes_gain'];
		$customer_id = $_POST['txt_customer_id'];
		$routes_id = $_POST['txt_routes_id'];
		$collector_id = $_POST['txt_collector_id'];

		$_order_no = date('HisdmY');
		
		$data = array(
			
			'user_id' => $this->session->userdata('userid'),
			'loans_no' => $_order_no,
			'entry_date' => $entry_date,
			'loanstype_id' => $loanstype_id,
			'duration' => $loanstype_duration,
			'start_date' => $start_date,
			'loans_amount' => $loans_amount,
			'end_date' => $end_date,
			'due_amount' => $due_amount,
			'cuota' => $cuota,
			'capital' => $capital,
			'interes' => $interes,
			'interes_amount' => $interes_amount,
			//'interes_nogain' => $interes_nogain,
			//'interes_gain' => $interes_gain,
			'customer_id' => $customer_id,
			'routes_id' => $routes_id,
			'collector_id' => $collector_id,
			'create_date' => $this->input->post('txt_create_date'),
			'active' => $this->input->post('txt_active'),

		);
		
		if ($id == 0) {
			return $this->db->insert('loans', $data);
		} else {
		$this->db->where('loans.company_id', $this->session->userdata('company_id'));
			$this->db->where('loans_id', $id);
			return $this->db->update('loans', $data);
		}
	}
		
	public function remove($ids)
	{
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no',$ids);
		$this->db->delete('loans');

		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no',$ids);
		$this->db->delete('loans_accounting');
	}
} 

?>