<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Loansquickbusiness_model extends CI_Model  { 
		
	public function __construct()
	{
		$this->load->database();
	}
	
	public function findAll()
	{
		$this->db->select('*, loansquickbusiness.interes, loansquickbusiness.capital, 
		IFNULL((SELECT SUM(loansquickbusiness_transactions.amount) FROM loansquickbusiness_transactions WHERE loansquickbusiness_transactions.loans_no=loansquickbusiness.loans_no AND (loansquickbusiness_transactions.transactions_type="CAPITAL" OR loansquickbusiness_transactions.transactions_type="INTERES" OR loansquickbusiness_transactions.transactions_type="CUOTA" OR loansquickbusiness_transactions.transactions_type="PAGO IRREGULAR")),0) AS amount_paid, 
		IFNULL((SELECT SUM(IF(t.concept="ABONO PAGO IRREGULAR", -t.amount, loansquickbusiness.interes_amount - t.amount)) FROM loansquickbusiness_transactions t WHERE t.loans_no=loansquickbusiness.loans_no AND t.transactions_type="PAGO IRREGULAR" AND t.amount != 0),0) unpaid_payments, 
		IFNULL((SELECT SUM(t.amount) FROM loansquickbusiness_transactions t WHERE t.loans_no=loansquickbusiness.loans_no AND t.transactions_type="ADICIONAL" AND t.amount != 0),0) aditional_amount, 
		IFNULL((SELECT SUM(t.interes_paid) FROM loansquickbusiness_transactions t WHERE t.loans_no=loansquickbusiness.loans_no AND t.amount != 0),0) interes_paid, 
		IFNULL((SELECT SUM(t.capital_paid) FROM loansquickbusiness_transactions t WHERE t.loans_no=loansquickbusiness.loans_no AND t.amount != 0),0) capital_paid', FALSE);

		$this->db->join('loansquickbusiness_accounting', 'loansquickbusiness_accounting.loans_no=loansquickbusiness.loans_no', 'left');
		$this->db->join('customer', 'loansquickbusiness.customer_id=customer.customer_id', 'left');
		$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->where('loansquickbusiness.company_id', $this->session->userdata('company_id'));
		$this->db->where('loansquickbusiness.current_balance >','0');

		$this->db->group_by("loansquickbusiness.loans_no");
		$this->db->order_by("loansquickbusiness.loans_no", "desc");
		return $this->db->get('loansquickbusiness')->result();
	}
	public function getLoansDetails($id, $customer_id)
	{
		$this->db->select(' loansquickbusiness.interes, loansquickbusiness.capital, loansquickbusiness.due_amount, IFNULL((SELECT SUM(loansquickbusiness_transactions.amount) FROM loansquickbusiness_transactions WHERE loansquickbusiness_transactions.loans_no=loansquickbusiness.loans_no AND (loansquickbusiness_transactions.transactions_type="CAPITAL" OR loansquickbusiness_transactions.transactions_type="INTERES" OR loansquickbusiness_transactions.transactions_type="CUOTA" OR loansquickbusiness_transactions.transactions_type="PAGO IRREGULAR")),0) AS amount_paid, 
		IFNULL((SELECT (TIMESTAMPDIFF(MONTH, t.payment_date, CURDATE()) * IF(loansquickbusiness.loanstype_id=4,2,1) * loansquickbusiness.interes) FROM loansquickbusiness_transactions t LEFT JOIN loanstype lt ON lt.loanstype_id=loansquickbusiness.loanstype_id WHERE t.loans_no=loansquickbusiness.loans_no ORDER BY t.payment_date DESC LIMIT 1), 0) unpaid_payments, 
		(SELECT SUM(t.amount) FROM loansquickbusiness_transactions t WHERE t.loans_no=loansquickbusiness.loans_no AND t.transactions_type="ADICIONAL" AND t.amount != 0) aditional_amount, (SELECT SUM(t.interes_paid) FROM loansquickbusiness_transactions t WHERE t.loans_no=loansquickbusiness.loans_no AND t.amount != 0) interes_paid, 
		(SELECT SUM(t.capital_paid) FROM loansquickbusiness_transactions t WHERE t.loans_no=loansquickbusiness.loans_no AND t.amount != 0) total_capital_paid', FALSE);

		$this->db->where('loansquickbusiness.company_id', $this->session->userdata('company_id'));
		//$this->db->where('loansquickbusiness.current_balance >','0');
		$this->db->where('loansquickbusiness.customer_id', $customer_id);
		$this->db->where('loansquickbusiness.loans_no', $id);
		
		return $this->db->get('loansquickbusiness')->result();
	}
	public function findAllDue()
	{
		$this->db->select('*, loansquickbusiness.interes, IFNULL((SELECT SUM(loansquickbusiness_transactions.amount) FROM loansquickbusiness_transactions WHERE loansquickbusiness_transactions.loans_no=loansquickbusiness.loans_no AND (loansquickbusiness_transactions.transactions_type="CAPITAL" OR loansquickbusiness_transactions.transactions_type="INTERES" OR loansquickbusiness_transactions.transactions_type="CUOTA" OR loansquickbusiness_transactions.transactions_type="PAGO IRREGULAR")),0) AS amount_paid, (SELECT SUM(loansquickbusiness.interes_amount - t.amount) FROM loansquickbusiness_transactions t WHERE t.loans_no=loansquickbusiness.loans_no AND t.transactions_type="PAGO IRREGULAR" AND t.amount != 0) unpaid_payments, (SELECT SUM(t.amount) FROM loansquickbusiness_transactions t WHERE t.loans_no=loansquickbusiness.loans_no AND t.transactions_type="ADICIONAL" AND t.amount != 0) aditional_amount, (SELECT SUM(t.interes_paid) FROM loansquickbusiness_transactions t WHERE t.loans_no=loansquickbusiness.loans_no AND t.amount != 0) interes_paid, (SELECT SUM(t.capital_paid) FROM loansquickbusiness_transactions t WHERE t.loans_no=loansquickbusiness.loans_no AND t.amount != 0) capital_paid', FALSE);

		$this->db->join('loansquickbusiness_accounting', 'loansquickbusiness_accounting.loans_no=loansquickbusiness.loans_no', 'left');
		$this->db->join('customer', 'loansquickbusiness.customer_id=customer.customer_id', 'left');
		$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->where('loansquickbusiness.company_id', $this->session->userdata('company_id'));
		$this->db->where('loansquickbusiness.current_balance <=','0');

		$this->db->group_by("loansquickbusiness.loans_no");
		$this->db->order_by("loansquickbusiness.loans_no", "desc");
		return $this->db->get('loansquickbusiness')->result();
	}
	
	public function findOne($id)
	{
		$this->db->select('*, guarantor1.guarantor_id guarantor1_id, guarantor1.guarantor_first_name guarantor1_first_name, guarantor2.guarantor_id guarantor2_id, guarantor2.guarantor_first_name guarantor2_first_name, (SELECT SUM(t.amount) FROM loansquickbusiness_transactions t WHERE t.loans_no=loansquickbusiness.loans_no AND t.transactions_type="ADICIONAL" AND t.amount != 0) additional_amount ', FALSE);

		$this->db->join('customer', 'loansquickbusiness.customer_id=customer.customer_id', 'left');
		$this->db->join('guarantor guarantor1', 'loansquickbusiness.guarantor1_id=guarantor1.guarantor_id', 'left');
		$this->db->join('guarantor guarantor2', 'loansquickbusiness.guarantor2_id=guarantor2.guarantor_id', 'left');
		
		$this->db->join('loanstype', 'loansquickbusiness.loanstype_id=loanstype.loanstype_id', 'left');
		
		$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->where('loansquickbusiness.company_id', $this->session->userdata('company_id'));
		$this->db->where('loansquickbusiness.loans_no',$id);
		$this->db->group_by("loansquickbusiness.loans_no");
		return $this->db->get('loansquickbusiness')->result();
	}

	public function getLoanCustomer($id)
	{
		$this->db->select(" loansquickbusiness.loans_no, loansquickbusiness.current_balance, cli.customer_gender, cli.customer_nationality, cli.customer_civilstatus, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, 
		g1.guarantor_gender guarantor1_gender, g1.guarantor_nationality guarantor1_nationality, g1.guarantor_civilstatus guarantor1_civilstatus, If(g1.guarantor_nickname ='', g1.guarantor_first_name, CONCAT_WS(' ', g1.guarantor_first_name, '(', g1.guarantor_nickname, ')')) AS guarantor1_first_name,  g1.guarantor_id guarantor1_id, g1.guarantor_personalid guarantor1_personalid, g1.guarantor_address guarantor1_address, g1.guarantor_phone guarantor1_phone, g1.guarantor_workplace guarantor1_workplace, g1.guarantor_occupation guarantor1_occupation, 
		g2.guarantor_gender guarantor2_gender, g2.guarantor_nationality guarantor2_nationality, g2.guarantor_civilstatus guarantor2_civilstatus, If(g2.guarantor_nickname ='', g2.guarantor_first_name, CONCAT_WS(' ', g2.guarantor_first_name, '(', g2.guarantor_nickname, ')')) AS guarantor2_first_name,  g2.guarantor_id guarantor2_id, g2.guarantor_personalid guarantor2_personalid, g2.guarantor_address guarantor2_address, g2.guarantor_phone guarantor2_phone, g2.guarantor_workplace guarantor2_workplace, g2.guarantor_occupation guarantor2_occupation,
		loansquickbusiness.duration, loansquickbusiness.interes_amount, FORMAT(loansquickbusiness.loans_amount,2) loans_amount, FORMAT(loansquickbusiness.cuota,2) cuota, 
		loansquickbusiness.contract_number, loansquickbusiness.contract_folio1, loansquickbusiness.contract_folio2, loansquickbusiness.entry_date, loansquickbusiness.entry_time, loansquickbusiness.start_date, loansquickbusiness.end_date, FORMAT(loansquickbusiness.due_amount,2) due_amount, loansquickbusiness.interes interes, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, (SELECT FORMAT(IFNULL(SUM(ct.cuota - ct.advance_amount), 0),2) FROM loansquickbusiness_accounting ct WHERE ct.due_date < CURDATE() AND ct.printed='NO' AND loans_no=loansquickbusiness.loans_no) atraso, cli2.customer_address garante_address, cli2.customer_phone garante_phone ");
	
		$this->db->join('customer cli', 'loansquickbusiness.customer_id=cli.customer_id', 'left');
		$this->db->join('customer cli2', 'loansquickbusiness.customer_id=cli2.customer_id', 'left');
		$this->db->join('guarantor g1', 'loansquickbusiness.guarantor1_id=g1.guarantor_id', 'left');
		$this->db->join('guarantor g2', 'loansquickbusiness.guarantor2_id=g2.guarantor_id', 'left');
		
		$this->db->where('cli.company_id', $this->session->userdata('company_id'));
		$this->db->where('cli2.company_id', $this->session->userdata('company_id'));
		$this->db->where('loansquickbusiness.company_id', $this->session->userdata('company_id'));			
		$this->db->where('loansquickbusiness.loans_no', $id);

		return $this->db->get('loansquickbusiness')->row_array();
	}
 
	public function CheckEndLoan($id)
	{
		$this->db->where('loansquickbusiness.company_id', $this->session->userdata('company_id'));
		$this->db->where('loansquickbusiness.loans_no',$id);
		$this->db->where('loansquickbusiness.current_balance <=','0');
		return $this->db->get('loansquickbusiness')->result();
	}
	/* get the orders data */
	public function getOrdersData($id = null)
	{
		if($id) {
			$sql = "SELECT c.customer_first_name, c.customer_personalid, c.customer_address, c.customer_phone, IFNULL((SELECT SUM(t.amount) FROM loansquickbusiness_transactions t WHERE t.loans_no=o.loans_no AND t.transactions_type='ADICIONAL' AND t.amount != 0),0) aditional_amount, o.* FROM loansquickbusiness o, customer c WHERE o.company_id = " . $this->session->userdata('company_id') . " AND o.company_id = c.company_id AND o.customer_id = c.customer_id AND o.loans_no = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT c.customer_first_name, c.customer_personalid, c.customer_address, c.customer_phone, IFNULL((SELECT SUM(t.amount) FROM loansquickbusiness_transactions t WHERE t.loans_no=o.loans_no AND t.transactions_type='ADICIONAL' AND t.amount != 0),0) aditional_amount, o.* FROM loansquickbusiness o, customer c WHERE o.company_id = " . $this->session->userdata('company_id') . " AND o.company_id = c.company_id AND o.customer_id = c.customer_id ORDER BY c.customer_first_name, o.entry_date DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// get the transaction data
	public function getOrdersTransactionData($loans_no = null)
	{
		if(!$loans_no) {
			return false;
		}

		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no', $loans_no);
		return $this->db->get('loansquickbusiness_transactions')->result_array();
	}


	public function getOrdersDueDate($id = null)
	{
		$sql = "SELECT due_date FROM loansquickbusiness_accounting WHERE company_id = " . $this->session->userdata('company_id') . " AND loans_no=".$id." AND printed='No' ORDER BY due_date ASC";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	// get the transaction data
	public function getTransactionByID($id = null)
	{
		if(!$id) {
			return false;
		}

		$sql = "SELECT * FROM loansquickbusiness_transactions WHERE company_id = ".$this->session->userdata('company_id')." AND transactions_no = ? ";
		$query = $this->db->query($sql, array($id));

		return $query->row_array();
	}
	public function getLastTransactionByLoan($id = null)
	{
		if(!$id) {
			return false;
		}

		$sql = "SELECT * FROM loansquickbusiness_transactions WHERE company_id = ".$this->session->userdata('company_id')." AND loans_no = ? ORDER BY payment_date ASC LIMIT 1";
		$query = $this->db->query($sql, array($id));

		return $query->row_array();
	}

	// get the additional data
	public function getAdditionalByID($id = null)
	{
		if(!$id) {
			return false;
		}

		$sql = "SELECT * FROM loansquickbusiness_additional WHERE company_id = ".$this->session->userdata('company_id')." AND id = ? ";
		$query = $this->db->query($sql, array($id));

		return $query->row_array();
	}
	
	public function getLastOrderTransactionId()
	{
		$sql = "SELECT MAX(transactions_no) transactions_no FROM loansquickbusiness_transactions WHERE company_id = " . $this->session->userdata('company_id') . "";
		$query = $this->db->query($sql, array(1));
		return $query->row_array();
	}
	
	public function pay($transaction_data, $accounting_data, $due_date, $id)
	{
		if ($transaction_data && $accounting_data && $id) 
		{
			$insert = $this->db->insert('loansquickbusiness_transactions', $transaction_data);
			$duedate = $this->loansquickbusiness_model->getOrdersDueDate($id);

			$arrayAccountingUpdate = array('loans_no' => $id, 'company_id' => $this->session->userdata('company_id'), 'due_date' => $duedate['due_date']);	
			$this->db->where($arrayAccountingUpdate);
			$update = $this->db->update('loansquickbusiness_accounting', $accounting_data);
				
			return ($insert == true && $update == true) ? true : false;
		}
	}
	
	public function payCapital($transaction_data, $order_data, $id)
	{
		if ($transaction_data && $order_data && $id) 
		{
			$insert = $this->db->insert('loansquickbusiness_transactions', $transaction_data);

			$arrayOrderUpdate = array('loans_no' => $id, 'company_id' => $this->session->userdata('company_id'));	
			$this->db->where($arrayOrderUpdate);
			$update = $this->db->update('loansquickbusiness', $order_data);
				
			return ($insert == true && $update == true) ? true : false;
		}
	}

	public function additional($transaction_data, $order_data, $id)
	{
		if ($transaction_data && $order_data && $id) 
		{
			$insert = $this->db->insert('loansquickbusiness_transactions', $transaction_data);
			
			$arrayOrderUpdate = array('loans_no' => $id, 'company_id' => $this->session->userdata('company_id'));	
			$this->db->where($arrayOrderUpdate);
			$update = $this->db->update('loansquickbusiness', $order_data);
				
			return ($insert == true && $update == true) ? true : false;
		}
	}

	public function countTotalPaidOrdersTransactionByDate($id)
	{
			$sql = "SELECT SUM(amount) amount FROM loansquickbusiness_transactions WHERE company_id = ".$this->session->userdata('company_id')." AND loans_no = ? AND concept != 'Descuento'";
		$query = $this->db->query($sql, $id);
			
		return $query->row_array();
	}
	
	public function change_status($id,$mode)
	{
		$data=array('loans_is_active'=>$mode);
		$this->db->where('loans_no',$id);
		$this->db->update('loansquickbusiness',$data);
	}
	public function delete_tmp_data($table_id)
	{
		$this->db->query("DELETE from loans_tmp WHERE table_id =". $table_id." AND admin_id =".$this->session->userdata('userid'));
	}
		
	public function insert($id = 0)
	{
		$loanstype_id = $_POST['txt_loanstype_id'];
		$loanstype_duration = $_POST['txt_loanstype_duration'];
		$loanstype_frequency = $_POST['txt_loanstype_frequency'];
		$entry_date = date('Y-m-d',  strtotime($_POST['txt_entry_date']));
		$entry_time = date('H:i',  strtotime($_POST['txt_entry_time']));
		$start_date = $entry_date;

		$contract_number = $_POST['txt_contract_number'];
		$contract_folio1 = $_POST['txt_contract_folio1'];
		$contract_folio2 = $_POST['txt_contract_folio2'];

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
		$guarantor1_id = $_POST['txt_guarantor_id1'];
		$guarantor2_id = $_POST['txt_guarantor_id2'];

		$search="SELECT (IFNULL(MAX(loans_no),0)+1) loans_no FROM loansquickbusiness WHERE company_id=".$this->session->userdata('company_id');
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
			'current_balance' => $loans_amount,
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
		
		$this->logger->write( "Rapido", "agregado", 'Nuevo préstamo cliente: ' . $this->input->post('txt_customer') . ' monto prestado $' . $loans_amount . ' duración: ' . $loanstype_duration . ' ' . $_frequency . ' interes: ' . $interes_amount );

		$this->db->insert('loansquickbusiness', $data);

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
		$this->db->delete('loansquickbusiness_accounting');

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

			$this->db->insert('loansquickbusiness_accounting', $data_g);
		}

		return $_order_no;
	}
		
	public function update($id)
	{
		$loanstype_id = $_POST['txt_loanstype_id'];
		$loanstype_duration = $_POST['txt_loanstype_duration'];
		$entry_date = date('Y-m-d',  strtotime($_POST['txt_entry_date']));
		$entry_time = date('H:i',  strtotime($_POST['txt_entry_time']));
		$start_date = $entry_date;
		$contract_number = $_POST['txt_contract_number'];
		$contract_folio1 = $_POST['txt_contract_folio1'];
		$contract_folio2 = $_POST['txt_contract_folio2'];
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
		$guarantor1_id = $_POST['txt_guarantor_id1'];
		$guarantor2_id = $_POST['txt_guarantor_id2'];

		$_order_no = date('HisdmY');
		
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
			//'interes_gain' => $interes_gain,
			'customer_id' => $customer_id,
			'routes_id' => $routes_id,
			'collector_id' => $collector_id,
			'guarantor1_id' => $guarantor1_id,
			'guarantor2_id' => $guarantor2_id,
			'create_date' => $this->input->post('txt_create_date'),
			'active' => $this->input->post('txt_active'),

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

		if ($id == 0) {
			$this->logger->write( "Rapido", "agregado", 'Nuevo préstamo cliente: ' . $this->input->post('txt_customer') . ' monto prestado $' . $loans_amount . ' duración: ' . $loanstype_duration . ' ' . $_frequency . ' interes: ' . $interes_amount );

			return $this->db->insert('loansquickbusiness', $data);
		} else {
			$this->logger->write( "Rapido", "actualizado", 'Préstamo cliente: ' . $this->input->post('txt_customer') . ' monto prestado $' . $loans_amount . ' duración: ' . $loanstype_duration . ' ' . $_frequency . ' interes: ' . $interes_amount );

			$this->db->where('loans_no', $id);
			return $this->db->update('loansquickbusiness', $data);
		}
	}
		
	public function remove($ids)
	{
		$this->db->where('loans_no',$ids);
		$this->db->delete('loansquickbusiness');


		$this->db->where('loans_no',$ids);
		$this->db->delete('loansquickbusiness_accounting');
	}

	public function removeAdditional($order_id, $id, $order_data)
	{
		$arrayTransactionDelete = array('transactions_no' => $id, 'company_id' => $this->session->userdata('company_id'));
		$this->db->where($arrayTransactionDelete);
		$this->db->delete('loansquickbusiness_transactions');

		$arrayOrderUpdate = array('loans_no' => $order_id, 'company_id' => $this->session->userdata('company_id'));
		$this->db->where($arrayOrderUpdate);
		$this->db->update('loansquickbusiness', $order_data);
	}

	public function removeTransaction($order_id, $id, $order_data)
	{
		$transaction = $this->loansquickbusiness_model->getTransactionByID($id);
		
		$arrayTransactionDelete = array('transactions_no' => $id, 'company_id' => $this->session->userdata('company_id'));
		$this->db->where($arrayTransactionDelete);
		$this->db->delete('loansquickbusiness_transactions');

		$arrayTransactionUpdate = array('loans_no' => $order_id, 'company_id' => $this->session->userdata('company_id'), 'due_date' => $transaction['accounting_due_date']);
		$this->db->where($arrayTransactionUpdate);
		$this->db->update('loansquickbusiness_accounting', array('printed' => 'No'));

		/* $arrayOrderUpdate = array('loans_no' => $order_id, 'company_id' => $this->session->userdata('company_id'));
		$this->db->where($arrayOrderUpdate);
		$this->db->update('loansquickbusiness', $order_data); */
	}
} 

?>