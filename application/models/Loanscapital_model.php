<?php
defined('BASEPATH') OR exit('No direct script access allowed');
			
class Loanscapital_model extends CI_Model  
{ 
	
	public function __construct()
	{
		$this->load->database();
	}

	public function findAll()
	{
		$this->db->select('*, loanscapital.interes, loanscapital.capital, loanscapital.due_amount, 
		IFNULL((SELECT SUM(loanscapital_transactions.amount) FROM loanscapital_transactions WHERE loanscapital_transactions.loans_no=loanscapital.loans_no AND (loanscapital_transactions.transactions_type="CAPITAL" OR loanscapital_transactions.transactions_type="INTERES" OR loanscapital_transactions.transactions_type="CUOTA" OR loanscapital_transactions.transactions_type="PAGO IRREGULAR")),0) AS amount_paid, 
		IFNULL((SELECT SUM(IF(t.concept="ABONO PAGO IRREGULAR", -t.amount, loanscapital.interes_amount - t.amount)) FROM loanscapital_transactions t WHERE t.loans_no=loanscapital.loans_no AND t.transactions_type="PAGO IRREGULAR" AND t.amount != 0),0) unpaid_payments, 
		IFNULL((SELECT SUM(t.amount) FROM loanscapital_transactions t WHERE t.loans_no=loanscapital.loans_no AND t.transactions_type="ADICIONAL" AND t.amount != 0),0) aditional_amount, 
		IFNULL((SELECT SUM(t.interes_paid) FROM loanscapital_transactions t WHERE t.loans_no=loanscapital.loans_no AND t.amount != 0),0) interes_paid, 
		IFNULL((SELECT SUM(t.capital_paid) FROM loanscapital_transactions t WHERE t.loans_no=loanscapital.loans_no AND t.amount != 0),0) total_capital_paid,

		IFNULL((SELECT (TIMESTAMPDIFF(MONTH, t.payment_date, CURDATE()) * IF(loanscapital.loanstype_id=4,2,1)) FROM loanscapital_transactions t LEFT JOIN loanstype lt ON lt.loanstype_id=loanscapital.loanstype_id WHERE t.loans_no=loanscapital.loans_no ORDER BY t.payment_date DESC LIMIT 1), 0) loanscapital_unpay_qty,
		IFNULL((SELECT (TIMESTAMPDIFF(MONTH, t.payment_date, CURDATE()) * IF(loanscapital.loanstype_id=4,2,1) * loanscapital.interes) FROM loanscapital_transactions t LEFT JOIN loanstype lt ON lt.loanstype_id=loanscapital.loanstype_id WHERE t.loans_no=loanscapital.loans_no ORDER BY t.payment_date DESC LIMIT 1), 0) total_unpay', FALSE);

		$this->db->join('loanscapital_accounting', 'loanscapital_accounting.loans_no=loanscapital.loans_no', 'left');
		$this->db->join('customer', 'loanscapital.customer_id=customer.customer_id', 'left');
		$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->where('loanscapital.company_id', $this->session->userdata('company_id'));
		$this->db->where('loanscapital.current_balance >','0');

		$this->db->group_by("loanscapital.loans_no");
		$this->db->order_by("loanscapital.loans_no", "desc");
		return $this->db->get('loanscapital')->result();
	}
	public function getLoansDetails($id, $customer_id)
	{
		$this->db->select(' loanscapital.interes, loanscapital.capital, loanscapital.due_amount, IFNULL((SELECT SUM(loanscapital_transactions.amount) FROM loanscapital_transactions WHERE loanscapital_transactions.loans_no=loanscapital.loans_no AND (loanscapital_transactions.transactions_type="CAPITAL" OR loanscapital_transactions.transactions_type="INTERES" OR loanscapital_transactions.transactions_type="CUOTA" OR loanscapital_transactions.transactions_type="PAGO IRREGULAR")),0) AS amount_paid, 
		IFNULL((SELECT (TIMESTAMPDIFF(MONTH, t.payment_date, CURDATE()) * IF(loanscapital.loanstype_id=4,2,1) * loanscapital.interes) FROM loanscapital_transactions t LEFT JOIN loanstype lt ON lt.loanstype_id=loanscapital.loanstype_id WHERE t.loans_no=loanscapital.loans_no ORDER BY t.payment_date DESC LIMIT 1), 0) unpaid_payments, 
		(SELECT SUM(t.amount) FROM loanscapital_transactions t WHERE t.loans_no=loanscapital.loans_no AND t.transactions_type="ADICIONAL" AND t.amount != 0) aditional_amount, (SELECT SUM(t.interes_paid) FROM loanscapital_transactions t WHERE t.loans_no=loanscapital.loans_no AND t.amount != 0) interes_paid, 
		(SELECT SUM(t.capital_paid) FROM loanscapital_transactions t WHERE t.loans_no=loanscapital.loans_no AND t.amount != 0) total_capital_paid', FALSE);

		$this->db->where('loanscapital.company_id', $this->session->userdata('company_id'));
		//$this->db->where('loanscapital.current_balance >','0');
		$this->db->where('loanscapital.customer_id', $customer_id);
		$this->db->where('loanscapital.loans_no', $id);
		
		return $this->db->get('loanscapital')->result();
	}
	
	public function findAllDue()
	{
		$this->db->join('loanscapital_accounting', 'loanscapital_accounting.loans_no=loanscapital.loans_no', 'left');
		$this->db->join('customer', 'loanscapital.customer_id=customer.customer_id', 'left');
		$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->where('loanscapital.company_id', $this->session->userdata('company_id'));
		$this->db->where('loanscapital.current_balance <=','0');

		$this->db->group_by("loanscapital.loans_no");
		$this->db->order_by("loanscapital.loans_no", "desc");
		return $this->db->get('loanscapital')->result();
	}
	
	public function findOne($id)
	{
		$this->db->select('*, guarantor1.guarantor_id guarantor1_id, guarantor1.guarantor_first_name guarantor1_first_name, guarantor2.guarantor_id guarantor2_id, guarantor2.guarantor_first_name guarantor2_first_name, (SELECT SUM(t.amount) FROM loanscapital_transactions t WHERE t.loans_no=loanscapital.loans_no AND t.transactions_type="ADICIONAL" AND t.amount != 0) additional_amount ', FALSE);

		$this->db->join('customer', 'loanscapital.customer_id=customer.customer_id', 'left');
		$this->db->join('guarantor guarantor1', 'loanscapital.guarantor1_id=guarantor1.guarantor_id', 'left');
		$this->db->join('guarantor guarantor2', 'loanscapital.guarantor2_id=guarantor2.guarantor_id', 'left');

		//$this->db->join('routes', 'loanscapital.routes_id=routes.routes_id', 'left');
		//$this->db->join('collector', 'routes.collector_id=collector.collector_id', 'left');
		$this->db->join('loanstype', 'loanscapital.loanstype_id=loanstype.loanstype_id', 'left');
		
		$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->where('loanscapital.company_id', $this->session->userdata('company_id'));
		$this->db->where('loanscapital.loans_no',$id);
		$this->db->group_by("loanscapital.loans_no");
		return $this->db->get('loanscapital')->result();
	}

	public function CheckEndLoan($id)
	{
		$this->db->join('loanscapital_transactions', 'loanscapital_transactions.loans_no=loanscapital.loans_no', 'left');
		$this->db->where('loanscapital_transactions.company_id', $this->session->userdata('company_id'));

		$this->db->having('(SELECT SUM(lc.amount) FROM loanscapital_transactions lc WHERE lc.loans_no=loanscapital.loans_no) = (interes_amount*duration)');

		$this->db->where('loanscapital.company_id', $this->session->userdata('company_id'));
		$this->db->where('loanscapital.loans_no',$id);
		$this->db->limit(1);
		return $this->db->get('loanscapital')->result();
	}
		
	/* get the orders data */
	public function getOrdersData($id = null)
	{
		if($id) {
			$sql = "SELECT c.customer_first_name, c.customer_personalid, c.customer_address, c.customer_phone, IFNULL((SELECT SUM(t.amount) FROM loanscapital_transactions t WHERE t.loans_no=o.loans_no AND t.transactions_type='ADICIONAL' AND t.amount != 0),0) aditional_amount, o.* FROM loanscapital o, customer c WHERE o.company_id = " . $this->session->userdata('company_id') . " AND o.company_id = c.company_id AND o.customer_id = c.customer_id AND o.loans_no = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT c.customer_first_name, c.customer_personalid, c.customer_address, c.customer_phone, IFNULL((SELECT SUM(t.amount) FROM loanscapital_transactions t WHERE t.loans_no=o.loans_no AND t.transactions_type='ADICIONAL' AND t.amount != 0),0) aditional_amount, o.* FROM loanscapital o, customer c WHERE o.company_id = " . $this->session->userdata('company_id') . " AND o.company_id = c.company_id AND o.customer_id = c.customer_id ORDER BY c.customer_first_name, o.entry_date DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getOrdersDueDate($id = null)
	{
		$sql = "SELECT due_date FROM loanscapital_accounting WHERE company_id = " . $this->session->userdata('company_id') . " AND loans_no=".$id." AND printed='No' ORDER BY due_date ASC";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	// get the transaction data
	public function getOrdersTransactionData($loans_no = null)
	{
		if(!$loans_no) {
			return false;
		}

		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no', $loans_no);
		return $this->db->get('loanscapital_transactions')->result_array();
	}

	// get the transaction data
	public function getTransactionByID($id = null)
	{
		if(!$id) {
			return false;
		}

		$sql = "SELECT * FROM loanscapital_transactions WHERE company_id = ".$this->session->userdata('company_id')." AND transactions_no = ? ";
		$query = $this->db->query($sql, array($id));

		return $query->row_array();
	}
	// get the additional data
	public function getAdditionalByID($id = null)
	{
		if(!$id) {
			return false;
		}

		$sql = "SELECT * FROM loanscapital_additional WHERE company_id = ".$this->session->userdata('company_id')." AND id = ? ";
		$query = $this->db->query($sql, array($id));

		return $query->row_array();
	}
	
	public function getLastOrderTransactionId()
	{
		$sql = "SELECT MAX(transactions_no) transactions_no FROM loanscapital_transactions WHERE company_id = " . $this->session->userdata('company_id') . "";
		$query = $this->db->query($sql, array(1));
		return $query->row_array();
	}

	public function pay($transaction_data, $accounting_data, $due_date, $id)
	{
		if ($transaction_data && $accounting_data && $id) 
		{
			$insert = $this->db->insert('loanscapital_transactions', $transaction_data);
			$duedate = $this->loanscapital_model->getOrdersDueDate($id);

			$arrayAccountingUpdate = array('loans_no' => $id, 'company_id' => $this->session->userdata('company_id'), 'due_date' => $duedate['due_date']);	
			$this->db->where($arrayAccountingUpdate);
			$update = $this->db->update('loanscapital_accounting', $accounting_data);
				
			return ($insert == true && $update == true) ? true : false;
		}
	}

	public function payCapital($transaction_data, $order_data, $id)
	{
		if ($transaction_data && $order_data && $id) 
		{
			$insert = $this->db->insert('loanscapital_transactions', $transaction_data);

			$arrayOrderUpdate = array('loans_no' => $id, 'company_id' => $this->session->userdata('company_id'));	
			$this->db->where($arrayOrderUpdate);
			$update = $this->db->update('loanscapital', $order_data);
				
			return ($insert == true && $update == true) ? true : false;
		}
	}

	public function additional($transaction_data, $order_data, $id)
	{
		if ($transaction_data && $order_data && $id) 
		{
			$insert = $this->db->insert('loanscapital_transactions', $transaction_data);
			
			$arrayOrderUpdate = array('loans_no' => $id, 'company_id' => $this->session->userdata('company_id'));	
			$this->db->where($arrayOrderUpdate);
			$update = $this->db->update('loanscapital', $order_data);
				
			return ($insert == true && $update == true) ? true : false;
		}
	}

	public function countTotalPaidTransaction($id, $transactions_type)
	{
		$sql = "SELECT SUM(amount) amount FROM loanscapital_transactions WHERE company_id = ".$this->session->userdata('company_id')." AND loans_no = ? AND transactions_type = '".$transactions_type."'";
		$query = $this->db->query($sql, $id);
			
		return $query->row_array();
	}

	public function countTotalPaidOrdersTransactionByDate($id)
	{
		$sql = "SELECT SUM(amount) amount FROM loanscapital_transactions WHERE company_id = ".$this->session->userdata('company_id')." AND loans_no = ? AND concept != 'Descuento'";
		$query = $this->db->query($sql, $id);
			
		return $query->row_array();
	}

	public function change_status($id,$mode)
	{
		$data=array('loans_is_active'=>$mode);
		$this->db->where('loans_no',$id);
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->update('loanscapital',$data);
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
		$entry_time = date('H:i',  strtotime($_POST['txt_entry_time']));
		$start_date = date('Y-m-d',  strtotime($_POST['txt_start_date']));

		$contract_number = $_POST['txt_contract_number'];
		$contract_folio1 = $_POST['txt_contract_folio1'];
		$contract_folio2 = $_POST['txt_contract_folio2'];
		
		$loans_amount = $_POST['txt_loans_amount'];
		$end_date = date('Y-m-d',  strtotime($_POST['txt_end_date']));
		$due_amount = $_POST['txt_loans_total'];
		$cuota = $_POST['txt_cuota_amount'];
		$capital = $_POST['txt_capital_amount'];
		$interes = $_POST['txt_interes_amount'];
		$interes_amount = $_POST['txt_loanstype_interes'];
		//$interes_nogain = $_POST['txt_interes_nogain'];
		//$interes_gain = $_POST['txt_interes_gain'];
		$customer_id = $_POST['txt_customer_id'];
		$routes_id = $_POST['txt_routes_id'];
		$collector_id = $_POST['txt_collector_id'];
		$guarantor1_id = $_POST['txt_guarantor_id1'];
		$guarantor2_id = $_POST['txt_guarantor_id2'];

		$search="SELECT (IFNULL(MAX(loans_no),0)+1) loans_no FROM loanscapital WHERE company_id=".$this->session->userdata('company_id');
		$row = $this->db->query($search)->row_array();
		if(is_array($row))
		{ $_order_no=$row['loans_no']; }
		else
		{ $_order_no=1;}
		//$_order_no = date('HisdmY');
	
		$data = array(

			'user_id' => $this->session->userdata('userid'),
			'company_id' => $this->session->userdata('company_id'),
			'loans_no' => $_order_no,

			'contract_number' => $contract_number,
			'contract_folio1' => $contract_folio1,
			'contract_folio2' => $contract_folio2,
			'entry_date' => $entry_date,
			'entry_time' => $entry_time,
			
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
			'current_balance' => $_POST['txt_loans_amount'],
			'customer_id' => $customer_id,
			'routes_id' => $routes_id,
			'collector_id' => $collector_id,
			'guarantor1_id' => $guarantor1_id,
			'guarantor2_id' => $guarantor2_id,
			'create_date' => date("Y-m-d"),
			'active' => 'yes',
		);

		$_frequency = "";
		switch($loanstype_id)
		{
			case "1" : $_frequency = floatval($loanstype_duration) == 1 ? "semana" : "semanas"; break;
			case "2" : $_frequency = floatval($loanstype_duration) == 1 ? "día" : "días"; break;
			case "3" : $_frequency = floatval($loanstype_duration) == 1 ? "mes" : "meses"; break;
			case "4" : $_frequency = floatval($loanstype_duration) == 1 ? "quincena" : "quincenas"; break;
			case "5" : $_frequency = floatval($loanstype_duration) == 1 ? "año" : "años"; break;
			default : $_frequency = floatval($loanstype_duration) == 1 ? "mes" : "meses"; break;
		}
		
		$this->logger->write( "Capital", "agregado", 'Nuevo préstamo cliente: ' . $this->input->post('txt_customer') . ' monto prestado $' . $loans_amount . ' duración: ' . $loanstype_duration . ' ' . $_frequency . ' interes: ' . $interes_amount );

		$this->db->insert('loanscapital', $data);

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

		$q = 'UPDATE loan_number SET loan_perant_id= loan_perant_id + 1 WHERE loans_no = '.$billid.'';
		$this->db->query($q);*/
		
		$this->db->where('loans_no',$_order_no);
		$this->db->delete('loanscapital_accounting');

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
				'updated_date' => $updated_date
			);
			
			if($loanstype_frequency == "Mensual"){
				date_add($end_date,date_interval_create_from_date_string("$days months"));
			} 
			else {
				date_add($end_date,date_interval_create_from_date_string("$days days"));
			}
			
			$grand_total -= $cuota;

			$this->db->insert('loanscapital_accounting', $data_g);
		}

		return $_order_no;
	}
		
	public function update($id)
	{
		$loanstype_id = $_POST['txt_loanstype_id'];
		$loanstype_duration = $_POST['txt_loanstype_duration'];
		$loanstype_frequency = $_POST['txt_loanstype_frequency'];
		$entry_date = date('Y-m-d',  strtotime($_POST['txt_entry_date']));
		$entry_time = date('H:i',  strtotime($_POST['txt_entry_time']));
		$start_date = date('Y-m-d',  strtotime($_POST['txt_start_date']));

		$contract_number = $_POST['txt_contract_number'];
		$contract_folio1 = $_POST['txt_contract_folio1'];
		$contract_folio2 = $_POST['txt_contract_folio2'];
		
		$loans_amount = $_POST['txt_loans_amount'];
		$end_date = date('Y-m-d',  strtotime($_POST['txt_end_date']));
		$due_amount = $_POST['txt_loans_total'];
		$cuota = $_POST['txt_cuota_amount'];
		$capital = $_POST['txt_capital_amount'];
		$interes = $_POST['txt_interes_amount'];
		$interes_amount = $_POST['txt_loanstype_interes'];
		//$interes_nogain = $_POST['txt_interes_nogain'];
		//$interes_gain = $_POST['txt_interes_gain'];
		$customer_id = $_POST['txt_customer_id'];
		$routes_id = $_POST['txt_routes_id'];
		$collector_id = $_POST['txt_collector_id'];
		$guarantor1_id = $_POST['txt_guarantor_id1'];
		$guarantor2_id = $_POST['txt_guarantor_id2'];

		$_order_no = date('HisdmY');
		
		$data = array(
			'user_id' => $this->session->userdata('userid'),
			'company_id' => $this->session->userdata('company_id'),
			'loans_no' => $id,

			'contract_number' => $contract_number,
			'contract_folio1' => $contract_folio1,
			'contract_folio2' => $contract_folio2,
			'entry_date' => $entry_date,
			'entry_time' => $entry_time,
			
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
			//'routes_id' => $routes_id,
			'collector_id' => $collector_id,
			'guarantor1_id' => $guarantor1_id,
			'guarantor2_id' => $guarantor2_id,
			'create_date' => $this->input->post('txt_create_date'),
			'active' => $this->input->post('txt_active'),
		);
		
		$this->db->where('loans_no',$id);
		$this->db->delete('loanscapital_accounting');

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
		$due_date=date_create($start_date);

		for ($i = 1; $i <= $loanstype_duration; $i++) {
		
			$data_g = array(
				'company_id' => $this->session->userdata('company_id'),
				'loans_no' => $id,
				'payment_no' => $i,
				'due_date' => date_format($due_date,"Y-m-d"),
				'due_amount' => $grand_total,
				'cuota' => $cuota,
				'capital' => $capital,
				'interes' => $interes_amount,
				//'fee_amount' => 0,
				//'advance_payment' => 0,
				'balance' => ($grand_total - $cuota),
				'printed' => 'No',
				'updated_date' => $updated_date
			);
			
			if($loanstype_frequency == "Mensual"){
				date_add($due_date,date_interval_create_from_date_string($days." months"));
			} 
			else {
				date_add($due_date,date_interval_create_from_date_string($days." days"));
			}

			$grand_total -= $cuota;

			$this->db->insert('loanscapital_accounting', $data_g);
		}

		$_frequency = "";
		switch($loanstype_id)
		{
			case "1" : $_frequency = floatval($loanstype_duration) == 1 ? "semana" : "semanas"; break;
			case "2" : $_frequency = floatval($loanstype_duration) == 1 ? "día" : "días"; break;
			case "3" : $_frequency = floatval($loanstype_duration) == 1 ? "mes" : "meses"; break;
			case "4" : $_frequency = floatval($loanstype_duration) == 1 ? "quincena" : "quincenas"; break;
			case "5" : $_frequency = floatval($loanstype_duration) == 1 ? "año" : "años"; break;
			default : $_frequency = floatval($loanstype_duration) == 1 ? "mes" : "meses"; break;
		}

		if ($id == 0) {
			$this->logger->write( "Capital", "agregado", 'Nuevo préstamo cliente: ' . $this->input->post('txt_customer') . ' monto prestado $' . $loans_amount . ' duración: ' . $loanstype_duration . ' ' . $_frequency . ' interes: ' . $interes_amount );

			return $this->db->insert('loanscapital', $data);
		} else {		
			$this->logger->write( "Capital", "actualizado", 'Préstamo cliente: ' . $this->input->post('txt_customer') . ' monto prestado $' . $loans_amount . ' duración: ' . $loanstype_duration . ' ' . $_frequency . ' interes: ' . $interes_amount );

			$this->db->where('loans_no', $id);
			return $this->db->update('loanscapital', $data);
		}
	}
	
	public function updateCurrentBalance($id)
	{
		$data = array(
			'current_balance' => 0
		);
		$this->db->where('loans_no', $id);
		return $this->db->update('loanscapital', $data);
	}
	
	public function remove($ids)
	{
		$this->logger->write( "Capital", "eliminado", 'Préstamo: ' . $ids . ' ' );

		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no',$ids);
		$this->db->delete('loanscapital');

		$this->logger->write( "Capital", "eliminado", 'transacciones del préstamo: ' . $ids . ' ' );

		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no',$ids);
		$this->db->delete('loanscapital_transactions');

		$this->logger->write( "Capital", "eliminado", 'amortización: ' . $ids . ' ' );

		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no',$ids);
		$this->db->delete('loanscapital_accounting');
	}
	
	public function removeTransaction($order_id, $id, $order_data)
	{
		$transaction = $this->loanscapital_model->getTransactionByID($id);
		$this->logger->write( "Capital", "eliminado", 'Transacción: ' . $id . ' ' );

		$arrayTransactionDelete = array('transactions_no' => $id, 'company_id' => $this->session->userdata('company_id'));
		$this->db->where($arrayTransactionDelete);
		$this->db->delete('loanscapital_transactions');
		//$this->db->update('loanscapital_transactions', array('isActive' => 'No'));

		if ($transaction['transactions_type'] == "CAPITAL") {
			$this->logger->write( "Capital", "actualizado", 'Préstamo: ' . $order_id . ' ' );
			
			$arrayOrderUpdate = array('loans_no' => $order_id, 'company_id' => $this->session->userdata('company_id'));
			$this->db->where($arrayOrderUpdate);
			$this->db->update('loanscapital', $order_data);
		}

		$this->logger->write( "Capital", "eliminado", 'amortización: ' . $order_id . ' ' );

		$arrayTransactionUpdate = array('loans_no' => $order_id, 'company_id' => $this->session->userdata('company_id'), 'due_date' => $transaction['accounting_due_date']);
		$this->db->where($arrayTransactionUpdate);
		$this->db->update('loanscapital_accounting', array('printed' => 'No'));

		/* $arrayOrderUpdate = array('loans_no' => $order_id, 'company_id' => $this->session->userdata('company_id'));
		$this->db->where($arrayOrderUpdate);
		$this->db->update('loanscapital', $order_data); */
	}		

	public function removeAdditional($order_id, $id, $order_data)
	{
		$this->logger->write( "Capital", "eliminado", 'adicional del présamo: ' . $order_id . ' ' );

		$arrayTransactionDelete = array('transactions_no' => $id, 'company_id' => $this->session->userdata('company_id'));
		$this->db->where($arrayTransactionDelete);
		$this->db->delete('loanscapital_transactions');

		$this->logger->write( "Capital", "actualizado", 'Préstamo: ' . $order_id . ' ' );

		$arrayOrderUpdate = array('loans_no' => $order_id, 'company_id' => $this->session->userdata('company_id'));
		$this->db->where($arrayOrderUpdate);
		$this->db->update('loanscapital', $order_data);
	}

	public function removeDiscountTransaction($order_id, $order_data)
	{
		if($order_id && $order_data) {
			$arrayDelete = array('loans_no' => $order_id, 'concept' => "Descuento", 'company_id' => $this->session->userdata('company_id'));

			$this->db->where($arrayDelete);
			$delete = $this->db->delete('loanscapital_transactions');

			$arrayUpdate = array('loans_no' => $order_id, 'company_id' => $this->session->userdata('company_id'));
			$this->db->where($arrayUpdate);
			$update_order = $this->db->update('loanscapital', $order_data);
				
			return ($delete == true && $update_order == true) ? true : false;
		}
	}
} 

?>