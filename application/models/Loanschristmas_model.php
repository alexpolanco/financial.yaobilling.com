<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loanschristmas_model extends CI_Model  { 
		
	public function __construct()
	{
		$this->load->database();
	}
	
	public function findAll()
	{
		$this->db->select('*, loanschristmas.interes, loanschristmas.capital, loanschristmas.due_amount, 
		IFNULL((SELECT SUM(loanschristmas_transactions.amount) FROM loanschristmas_transactions WHERE loanschristmas_transactions.loans_no=loanschristmas.loans_no AND (loanschristmas_transactions.transactions_type="CAPITAL" OR loanschristmas_transactions.transactions_type="INTERES" OR loanschristmas_transactions.transactions_type="CUOTA" OR loanschristmas_transactions.transactions_type="PAGO IRREGULAR")),0) AS amount_paid, 
		IFNULL((SELECT SUM(IF(t.concept="ABONO PAGO IRREGULAR", -t.amount, loanschristmas.interes_amount - t.amount)) FROM loanschristmas_transactions t WHERE t.loans_no=loanschristmas.loans_no AND t.transactions_type="PAGO IRREGULAR" AND t.amount != 0),0) unpaid_payments, 
		IFNULL((SELECT SUM(t.amount) FROM loanschristmas_transactions t WHERE t.loans_no=loanschristmas.loans_no AND t.transactions_type="ADICIONAL" AND t.amount != 0),0) aditional_amount, 
		IFNULL((SELECT SUM(t.interes_paid) FROM loanschristmas_transactions t WHERE t.loans_no=loanschristmas.loans_no AND t.amount != 0),0) interes_paid, 
		IFNULL((SELECT SUM(t.capital_paid) FROM loanschristmas_transactions t WHERE t.loans_no=loanschristmas.loans_no AND t.amount != 0),0) capital_paid', FALSE);

		$this->db->join('loanschristmas_accounting', 'loanschristmas_accounting.loans_no=loanschristmas.loans_no', 'left');
		$this->db->join('customer', 'loanschristmas.customer_id=customer.customer_id', 'left');
		$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->where('loanschristmas.company_id', $this->session->userdata('company_id'));
		$this->db->where('loanschristmas.current_balance >','0');

		$this->db->group_by("loanschristmas.loans_no");
		$this->db->order_by("loanschristmas.loans_no", "desc");
		return $this->db->get('loanschristmas')->result();
	}
	public function getLoansDetails($id, $customer_id)
	{
		$this->db->select(' loanschristmas.interes, loanschristmas.capital, loanschristmas.due_amount, IFNULL((SELECT SUM(loanschristmas_transactions.amount) FROM loanschristmas_transactions WHERE loanschristmas_transactions.loans_no=loanschristmas.loans_no AND (loanschristmas_transactions.transactions_type="CAPITAL" OR loanschristmas_transactions.transactions_type="INTERES" OR loanschristmas_transactions.transactions_type="CUOTA" OR loanschristmas_transactions.transactions_type="PAGO IRREGULAR")),0) AS amount_paid, 
		IFNULL((SELECT (TIMESTAMPDIFF(MONTH, t.payment_date, CURDATE()) * IF(loanschristmas.loanstype_id=4,2,1) * loanschristmas.interes) FROM loanschristmas_transactions t LEFT JOIN loanstype lt ON lt.loanstype_id=loanschristmas.loanstype_id WHERE t.loans_no=loanschristmas.loans_no ORDER BY t.payment_date DESC LIMIT 1), 0) unpaid_payments, 
		(SELECT SUM(t.amount) FROM loanschristmas_transactions t WHERE t.loans_no=loanschristmas.loans_no AND t.transactions_type="ADICIONAL" AND t.amount != 0) aditional_amount, (SELECT SUM(t.interes_paid) FROM loanschristmas_transactions t WHERE t.loans_no=loanschristmas.loans_no AND t.amount != 0) interes_paid, 
		(SELECT SUM(t.capital_paid) FROM loanschristmas_transactions t WHERE t.loans_no=loanschristmas.loans_no AND t.amount != 0) total_capital_paid', FALSE);

		$this->db->where('loanschristmas.company_id', $this->session->userdata('company_id'));
		//$this->db->where('loanschristmas.current_balance >','0');
		$this->db->where('loanschristmas.customer_id', $customer_id);
		$this->db->where('loanschristmas.loans_no', $id);
		
		return $this->db->get('loanschristmas')->result();
	}
	public function findAllDue()
	{
		$this->db->join('loanschristmas_accounting', 'loanschristmas_accounting.loans_no=loanschristmas.loans_no', 'left');
		$this->db->join('customer', 'loanschristmas.customer_id=customer.customer_id', 'left');
		$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->where('loanschristmas.company_id', $this->session->userdata('company_id'));
		$this->db->where('loanschristmas.current_balance <=','0');

		$this->db->group_by("loanschristmas.loans_no");
		$this->db->order_by("loanschristmas.loans_no", "desc");
		return $this->db->get('loanschristmas')->result();
	}
	
	public function findOne($id)
	{
		$this->db->select('*, guarantor1.guarantor_id guarantor1_id, guarantor1.guarantor_first_name guarantor1_first_name, guarantor2.guarantor_id guarantor2_id, guarantor2.guarantor_first_name guarantor2_first_name, (SELECT SUM(t.amount) FROM loanschristmas_transactions t WHERE t.loans_no=loanschristmas.loans_no AND t.transactions_type="ADICIONAL" AND t.amount != 0) additional_amount ', FALSE);

		$this->db->join('customer', 'loanschristmas.customer_id=customer.customer_id', 'left');
		$this->db->join('guarantor guarantor1', 'loanschristmas.guarantor1_id=guarantor1.guarantor_id', 'left');
		$this->db->join('guarantor guarantor2', 'loanschristmas.guarantor2_id=guarantor2.guarantor_id', 'left');
		//$this->db->join('routes', 'loanschristmas.routes_id=routes.routes_id', 'left');
		//$this->db->join('collector', 'routes.collector_id=collector.collector_id', 'left');
		$this->db->join('loanstype', 'loanschristmas.loanstype_id=loanstype.loanstype_id', 'left');
		
		$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->where('loanschristmas.company_id', $this->session->userdata('company_id'));
		$this->db->where('loanschristmas.loans_no',$id);
		$this->db->group_by("loanschristmas.loans_no");
		return $this->db->get('loanschristmas')->result();
	}

	public function CheckEndLoan($id)
	{
		$this->db->where('loanschristmas.company_id', $this->session->userdata('company_id'));
		$this->db->where('loanschristmas.loans_no',$id);
		$this->db->where('loanschristmas.current_balance <=','0');
		return $this->db->get('loanschristmas')->result();
	}
		
	/* get the orders data */
	public function getOrdersData($id = null)
	{
		if($id) {
			$sql = "SELECT c.customer_first_name, c.customer_personalid, c.customer_address, c.customer_phone, o.* FROM loanschristmas o, customer c WHERE o.company_id = " . $this->session->userdata('company_id') . " AND o.company_id = c.company_id AND o.customer_id = c.customer_id AND o.loans_no = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT c.customer_first_name, c.customer_personalid, c.customer_address, c.customer_phone, o.* FROM loanschristmas o, customer c WHERE o.company_id = " . $this->session->userdata('company_id') . " AND o.company_id = c.company_id AND o.customer_id = c.customer_id ORDER BY c.customer_first_name, o.entry_date DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getOrdersDueDate($id = null)
	{
		$sql = "SELECT due_date FROM loanschristmas_accounting WHERE company_id = " . $this->session->userdata('company_id') . " AND loans_no=".$id." AND printed='No' ORDER BY due_date ASC";
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
		return $this->db->get('loanschristmas_transactions')->result_array();
	}

	// get the transaction data
	public function getTransactionByID($id = null)
	{
		if(!$id) {
			return false;
		}

		$sql = "SELECT * FROM loanschristmas_transactions WHERE company_id = ".$this->session->userdata('company_id')." AND transactions_no = ? ";
		$query = $this->db->query($sql, array($id));

		return $query->row_array();
	}
	// get the additional data
	public function getAdditionalByID($id = null)
	{
		if(!$id) {
			return false;
		}

		$sql = "SELECT * FROM loanschristmas_additional WHERE company_id = ".$this->session->userdata('company_id')." AND id = ? ";
		$query = $this->db->query($sql, array($id));

		return $query->row_array();
	}
	
	public function getLastOrderTransactionId()
	{
		$sql = "SELECT MAX(transactions_no) transactions_no FROM loanschristmas_transactions WHERE company_id = " . $this->session->userdata('company_id') . "";
		$query = $this->db->query($sql, array(1));
		return $query->row_array();
	}
	
	public function pay($transaction_data, $accounting_data, $due_date, $id)
	{
		if ($transaction_data && $accounting_data && $id) 
		{
			$insert = $this->db->insert('loanschristmas_transactions', $transaction_data);
			$duedate = $this->loanschristmas_model->getOrdersDueDate($id);

			$arrayAccountingUpdate = array('loans_no' => $id, 'company_id' => $this->session->userdata('company_id'), 'due_date' => $duedate['due_date']);	
			$this->db->where($arrayAccountingUpdate);
			$update = $this->db->update('loanschristmas_accounting', $accounting_data);
				
			return ($insert == true && $update == true) ? true : false;
		}
	}
	
	public function payCapital($transaction_data, $order_data, $id)
	{
		if ($transaction_data && $order_data && $id) 
		{
			$insert = $this->db->insert('loanschristmas_transactions', $transaction_data);

			$arrayOrderUpdate = array('loans_no' => $id, 'company_id' => $this->session->userdata('company_id'));	
			$this->db->where($arrayOrderUpdate);
			$update = $this->db->update('loanschristmas', $order_data);
				
			return ($insert == true && $update == true) ? true : false;
		}
	}

	public function additional($transaction_data, $order_data, $id)
	{
		if ($transaction_data && $order_data && $id) 
		{
			$insert = $this->db->insert('loanschristmas_transactions', $transaction_data);
			
			$arrayOrderUpdate = array('loans_no' => $id, 'company_id' => $this->session->userdata('company_id'));	
			$this->db->where($arrayOrderUpdate);
			$update = $this->db->update('loanschristmas', $order_data);
				
			return ($insert == true && $update == true) ? true : false;
		}
	}

	public function countTotalPaidOrdersTransactionByDate($id)
	{
			$sql = "SELECT SUM(amount) amount FROM loanschristmas_transactions WHERE company_id = ".$this->session->userdata('company_id')." AND loans_no = ? AND concept != 'Descuento'";
		$query = $this->db->query($sql, $id);
			
		return $query->row_array();
	}
	
	public function change_status($id,$mode)
	{
		$data=array('loans_is_active'=>$mode);
		$this->db->where('loans_no',$id);
		$this->db->update('loanschristmas',$data);
	}
	public function delete_tmp_data($table_id)
	{
		$this->db->query("delete from loans_tmp WHERE table_id =". $table_id." AND admin_id =".$this->session->userdata('userid'));
	}
		
	public function insert($id = 0)
	{
		$loanstype_id = $_POST['txt_loanstype_id'];
		$loanstype_duration = $_POST['txt_loanstype_duration'];
		$loanstype_frequency = 'Mensual';
		$entry_date = date('Y-m-d',  strtotime($_POST['txt_entry_date']));
		$entry_time = date('H:i',  strtotime($_POST['txt_entry_time']));
		$start_date = date('Y-m-d',  strtotime($_POST['txt_start_date']));
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

		$search="SELECT (IFNULL(MAX(loans_no),0)+1) loans_no FROM loanschristmas WHERE company_id=".$this->session->userdata('company_id');
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
		
		$this->logger->write( "Regalia", "agregado", 'Nuevo préstamo cliente: ' . $this->input->post('txt_customer') . ' monto prestado $' . $loans_amount . ' duración: ' . $loanstype_duration . ' ' . $_frequency . ' interes: ' . $interes_amount );

		$this->db->insert('loanschristmas', $data);

		$this->db->where('loans_no',$_order_no);
		$this->db->delete('loanschristmas_accounting');

		//$_order_no;
		$grand_total = $due_amount;
		$updated_date = date("Y-m-d");
		
		$end_date = new DateTime();
		
		for ($i = 1; $i <= $loanstype_duration; $i++) {
			
			//date_add($end_date,date_interval_create_from_date_string("1 months"));

			$data_g = array(
				'company_id' => $this->session->userdata('company_id'),
				'loans_no' => $_order_no,
				'payment_no' => $i,
				'due_date' => date_format(date_add($end_date,date_interval_create_from_date_string("1 months")),"Y-m-d"),
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

			$this->db->insert('loanschristmas_accounting', $data_g);
		}

		return $_order_no;
	}
		
	public function update($id)
	{
		$loanstype_id = $_POST['txt_loanstype_id'];
		$loanstype_duration = $_POST['txt_loanstype_duration'];
		$entry_date = date('Y-m-d',  strtotime($_POST['txt_entry_date']));
		$entry_time = date('H:i',  strtotime($_POST['txt_entry_time']));
		$start_date = date('Y-m-d',  strtotime($_POST['txt_start_date']));
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
			$this->logger->write( "Regalia", "agregado", 'Nuevo préstamo cliente: ' . $this->input->post('txt_customer') . ' monto prestado $' . $loans_amount . ' duración: ' . $loanstype_duration . ' ' . $_frequency . ' interes: ' . $interes_amount );

			return $this->db->insert('loanschristmas', $data);
		} else {
			$this->logger->write( "Regalia", "actualizado", 'Préstamo cliente: ' . $this->input->post('txt_customer') . ' monto prestado $' . $loans_amount . ' duración: ' . $loanstype_duration . ' ' . $_frequency . ' interes: ' . $interes_amount );

			$this->db->where('loans_no', $id);
			return $this->db->update('loanschristmas', $data);
		}
	}
		
	public function updateCurrentBalance($id)
	{
		$data = array(
			'current_balance' => 0
		);
		$this->db->where('loans_no', $id);
		return $this->db->update('loanschristmas', $data);
	}

	public function remove($ids)
	{
		$this->logger->write( "Regalia", "eliminado", 'Préstamo: ' . $ids . ' ' );

		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no',$ids);
		$this->db->delete('loanschristmas');

		/*$this->logger->write( "Regalia", "eliminado", 'transacciones del préstamo: ' . $ids . ' ' );

		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no',$ids);
		$this->db->delete('loanschristmas_transactions');
		*/

		$this->logger->write( "Regalia", "eliminado", 'amortización: ' . $ids . ' ' );

		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no',$ids);
		$this->db->delete('loanschristmas_accounting');
	}

	public function removeTransaction($order_id, $id, $order_data)
	{
		$transaction = $this->loanschristmas_model->getTransactionByID($id);
		$this->logger->write( "Regalia", "eliminado", 'Transacción: ' . $id . ' ' );

		$arrayTransactionDelete = array('transactions_no' => $id, 'company_id' => $this->session->userdata('company_id'));
		$this->db->where($arrayTransactionDelete);
		$this->db->delete('loanschristmas_transactions');
		//$this->db->update('loanschristmas_transactions', array('isActive' => 'No'));

		if ($transaction['transactions_type'] == "CAPITAL") {
			$this->logger->write( "Regalia", "actualizado", 'Préstamo: ' . $order_id . ' ' );
			
			$arrayOrderUpdate = array('loans_no' => $order_id, 'company_id' => $this->session->userdata('company_id'));
			$this->db->where($arrayOrderUpdate);
			$this->db->update('loanschristmas', $order_data);
		}

		$this->logger->write( "Regalia", "eliminado", 'amortización: ' . $order_id . ' ' );

		$arrayTransactionUpdate = array('loans_no' => $order_id, 'company_id' => $this->session->userdata('company_id'), 'due_date' => $transaction['accounting_due_date']);
		$this->db->where($arrayTransactionUpdate);
		$this->db->update('loanschristmas_accounting', array('printed' => 'No'));

		/* $arrayOrderUpdate = array('loans_no' => $order_id, 'company_id' => $this->session->userdata('company_id'));
		$this->db->where($arrayOrderUpdate);
		$this->db->update('loanschristmas', $order_data); */
	}		

	public function removeAdditional($order_id, $id, $order_data)
	{
		$this->logger->write( "Regalia", "eliminado", 'adicional del présamo: ' . $order_id . ' ' );

		$arrayTransactionDelete = array('transactions_no' => $id, 'company_id' => $this->session->userdata('company_id'));
		$this->db->where($arrayTransactionDelete);
		$this->db->delete('loanschristmas_transactions');

		$this->logger->write( "Regalia", "actualizado", 'Préstamo: ' . $order_id . ' ' );

		$arrayOrderUpdate = array('loans_no' => $order_id, 'company_id' => $this->session->userdata('company_id'));
		$this->db->where($arrayOrderUpdate);
		$this->db->update('loanschristmas', $order_data);
	}
} 

?>