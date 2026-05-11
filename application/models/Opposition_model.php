<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Opposition_model extends CI_Model 
{ 
	
	public function __construct()
	{
		$this->load->database();
	}
	
	public function findAll()
	{
		$this->db->select('*, opposition.due_amount, opposition.interes, "0" AS amount_paid, "0" unpaid_payments, "0" aditional_amount, "0" interes_paid, "0" capital_paid', FALSE);

		$this->db->join('customer', 'opposition.customer_id=customer.customer_id', 'left');
		$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->where('opposition.company_id', $this->session->userdata('company_id'));
		$this->db->where('opposition.active','yes');

		$this->db->group_by("opposition.loans_no");
		$this->db->order_by("opposition.loans_no", "desc");
		return $this->db->get('opposition')->result();
	}
	
	public function findAllDue()
	{
		$this->db->join('customer', 'opposition.customer_id=customer.customer_id', 'left');
		$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->where('opposition.company_id', $this->session->userdata('company_id'));
		$this->db->where('opposition.active','no');

		$this->db->group_by("opposition.loans_no");
		$this->db->order_by("opposition.loans_no", "desc");
		return $this->db->get('opposition')->result();
	}
	
	public function findOne($id)
	{
		$this->db->select('*, guarantor1.guarantor_id guarantor1_id, guarantor1.guarantor_first_name guarantor1_first_name, guarantor2.guarantor_id guarantor2_id, guarantor2.guarantor_first_name guarantor2_first_name, (1 = 1) additional_amount ', FALSE);

		$this->db->join('customer', 'opposition.customer_id=customer.customer_id', 'left');
		$this->db->join('guarantor guarantor1', 'opposition.guarantor1_id=guarantor1.guarantor_id', 'left');
		$this->db->join('guarantor guarantor2', 'opposition.guarantor2_id=guarantor2.guarantor_id', 'left');
		//$this->db->join('routes', 'opposition.routes_id=routes.routes_id', 'left');
		//$this->db->join('collector', 'routes.collector_id=collector.collector_id', 'left');
		$this->db->join('loanstype', 'opposition.loanstype_id=loanstype.loanstype_id', 'left');
		
		$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->where('opposition.company_id', $this->session->userdata('company_id'));
		$this->db->where('opposition.loans_no',$id);
		$this->db->group_by("opposition.loans_no");
		return $this->db->get('opposition')->result();
	}
	
	public function findOppositionPlaceByLoan($loans_no, $customer_id)
	{
		$this->db->select('opposition.routes_id opposition_place');
		$this->db->where('opposition.company_id', $this->session->userdata('company_id'));
		$this->db->where('opposition.loans_no',$loans_no);
		$this->db->where('opposition.customer_id',$customer_id);
		$this->db->group_by("opposition.loans_no");
		return $this->db->get('opposition')->result();
	}
	
	public function CheckOppositionExist($id, $type)
	{
		$this->db->select('loans_no, loans_type');
		$this->db->where('opposition.company_id', $this->session->userdata('company_id'));
		$this->db->where('opposition.loans_type',$type);
		$this->db->where('opposition.loans_no',$id);
		return $this->db->get('opposition')->result();
	}

	public function CheckEndLoan($id)
	{
		$this->db->where('opposition.company_id', $this->session->userdata('company_id'));
		$this->db->where('opposition.loans_no',$id);
		$this->db->where('opposition.active','no');
		return $this->db->get('opposition')->result();
	}
	
	/* get the orders data */
	public function getOrdersData($id = null)
	{
		if($id) {
			$sql = "SELECT c.customer_first_name, c.customer_personalid, c.customer_address, c.customer_phone, o.* FROM opposition o, customer c WHERE o.company_id = " . $this->session->userdata('company_id') . " AND o.company_id = c.company_id AND o.customer_id = c.customer_id AND o.loans_no = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT c.customer_first_name, c.customer_personalid, c.customer_address, c.customer_phone, o.* FROM opposition o, customer c WHERE o.company_id = " . $this->session->userdata('company_id') . " AND o.company_id = c.company_id AND o.customer_id = c.customer_id ORDER BY c.customer_first_name, o.entry_date DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getOrdersDueDate($id = null)
	{
		$sql = "SELECT due_date FROM opposition_accounting WHERE company_id = " . $this->session->userdata('company_id') . " AND loans_no=".$id." AND printed='No' ORDER BY due_date ASC";
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
		return $this->db->get('opposition_transactions')->result_array();
	}

	// get the transaction data
	public function getTransactionByID($id = null)
	{
		if(!$id) {
			return false;
		}

		$sql = "SELECT * FROM opposition_transactions WHERE company_id = ".$this->session->userdata('company_id')." AND transactions_no = ? ";
		$query = $this->db->query($sql, array($id));

		return $query->row_array();
	}
	// get the additional data
	public function getAdditionalByID($id = null)
	{
		if(!$id) {
			return false;
		}

		$sql = "SELECT * FROM opposition_additional WHERE company_id = ".$this->session->userdata('company_id')." AND id = ? ";
		$query = $this->db->query($sql, array($id));

		return $query->row_array();
	}
	
	public function getLastOrderTransactionId()
	{
		$sql = "SELECT MAX(transactions_no) transactions_no FROM opposition_transactions WHERE company_id = " . $this->session->userdata('company_id') . "";
		$query = $this->db->query($sql, array(1));
		return $query->row_array();
	}

	public function pay($transaction_data, $accounting_data, $due_date, $id)
	{
		if ($transaction_data && $accounting_data && $id) 
		{
			$insert = $this->db->insert('opposition_transactions', $transaction_data);
			$duedate = $this->opposition_model->getOrdersDueDate($id);

			$arrayAccountingUpdate = array('loans_no' => $id, 'company_id' => $this->session->userdata('company_id'), 'due_date' => $duedate['due_date']);	
			$this->db->where($arrayAccountingUpdate);
			$update = $this->db->update('opposition_accounting', $accounting_data);
				
			return ($insert == true && $update == true) ? true : false;
		}
	}
	
	public function payCapital($transaction_data, $order_data, $id)
	{
		if ($transaction_data && $order_data && $id) 
		{
			$insert = $this->db->insert('opposition_transactions', $transaction_data);

			$arrayOrderUpdate = array('loans_no' => $id, 'company_id' => $this->session->userdata('company_id'));	
			$this->db->where($arrayOrderUpdate);
			$update = $this->db->update('opposition', $order_data);
				
			return ($insert == true && $update == true) ? true : false;
		}
	}

	public function additional($transaction_data, $order_data, $id)
	{
		if ($transaction_data && $order_data && $id) 
		{
			$insert = $this->db->insert('opposition_transactions', $transaction_data);
			
			$arrayOrderUpdate = array('loans_no' => $id, 'company_id' => $this->session->userdata('company_id'));	
			$this->db->where($arrayOrderUpdate);
			$update = $this->db->update('opposition', $order_data);
				
			return ($insert == true && $update == true) ? true : false;
		}
	}

	public function edit($order_data, $id)
	{
		if ($order_data && $id) 
		{			
			$arrayOrderUpdate = array('loans_no' => $id, 'company_id' => $this->session->userdata('company_id'));	
			$this->db->where($arrayOrderUpdate);
			$update = $this->db->update('opposition', $order_data);
				
			return ($update == true) ? true : false;
		}
	}

	public function countTotalPaidTransaction($id, $transactions_type)
	{
		$sql = "SELECT SUM(amount) amount FROM opposition_transactions WHERE company_id = ".$this->session->userdata('company_id')." AND loans_no = ? AND transactions_type = '".$transactions_type."'";
		$query = $this->db->query($sql, $id);
			
		return $query->row_array();
	}

	public function countTotalPaidOrdersTransactionByDate($id)
	{
		$sql = "SELECT SUM(interes) interes FROM opposition_transactions WHERE company_id = ".$this->session->userdata('company_id')." AND loans_no = ? AND concept != 'Descuento'";
		$query = $this->db->query($sql, $id);
			
		return $query->row_array();
	}
	
	public function change_status($id,$mode)
	{
		$data=array('loans_is_active'=>$mode);
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no',$id);
		$this->db->update('opposition',$data);
	}
	public function delete_tmp_data($table_id)
	{
		$this->db->query("delete from loans_tmp WHERE table_id =". $table_id." AND admin_id =".$this->session->userdata('userid'));
	}
		
	public function insert($id = 0)
	{
		$loans = $_POST['txt_loans'];
		$_order_no = $_POST['txt_loansno'];
				
		$_exist = $this->CheckOppositionExist($_order_no, $loans);
		
		if($_exist[0]->loans_no == $_order_no && $_exist[0]->loans_type == $loans) 
		{ return false; }
		else
		{
    		$loanstype_id = $_POST['txt_loanstype_id'];
    		$loanstype_duration = $_POST['txt_loanstype_duration'];
    		$loanstype_frequency = $_POST['txt_loanstype_frequency'];
    		$opposition_place = $_POST['txt_opposition_place'];
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
    
    		
    		$data = array(
    
    			'user_id' => $this->session->userdata('userid'),
    			'company_id' => $this->session->userdata('company_id'),
    			'loans_type' => $loans,
    			'loans_no' => $_order_no,
    
    			'contract_number' => $contract_number,
    			'contract_folio1' => $contract_folio1,
    			'contract_folio2' => $contract_folio2,
    			'entry_date' => $entry_date,
    			'entry_time' => $entry_time,
    
    			'routes_id' => $opposition_place,
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
    			//'routes_id' => $routes_id,
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
    		
    		$this->logger->write( "Oposición", "agregada", 'Nueva oposición cliente: ' . $this->input->post('txt_customer') . ' monto prestada $' . $loans_amount . ' duración: ' . $loanstype_duration . ' ' . $_frequency . ' interes: ' . $interes_amount );
    
    		$this->db->insert('opposition', $data);
    		
    		return true;
		    
		}
		//return $_order_no;
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

		$_order_no = $_POST['txt_loansno'];
		
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

		$grand_total = $due_amount;
		$updated_date = date("Y-m-d");
		
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
			$this->logger->write( "Oposición", "agregada", 'Nueva oposición cliente: ' . $this->input->post('txt_customer') . ' monto prestado $' . $loans_amount . ' duración: ' . $loanstype_duration . ' ' . $_frequency . ' interes: ' . $interes_amount );

			return $this->db->insert('opposition', $data);
		} else {
			$this->logger->write( "Oposición", "actualizada", 'Oposición cliente: ' . $this->input->post('txt_customer') . ' monto prestado $' . $loans_amount . ' duración: ' . $loanstype_duration . ' ' . $_frequency . ' interes: ' . $interes_amount );

			$this->db->where('loans_no', $id);
			return $this->db->update('opposition', $data);
		}
	}
		
	public function updateCurrentBalance($id)
	{
		$data = array(
			'current_balance' => 0
		);
		$this->db->where('loans_no', $id);
		return $this->db->update('opposition', $data);
	}

	public function remove($ids)
	{
		$this->logger->write( "Oposición", "levantada", 'Oposición: ' . $ids . ' ' );

		$data = array(
			'FechaFinalizado' => date('Y-m-d'),
			'active' => 'no'
		);
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no',$ids);
		$this->db->update('opposition', $data);
	}

	public function removeTransaction($order_id, $id, $order_data)
	{
		$transaction = $this->opposition_model->getTransactionByID($id);
		$this->logger->write( "Oposición", "eliminada", 'Transacción: ' . $id . ' ' );

		$arrayTransactionDelete = array('transactions_no' => $id, 'company_id' => $this->session->userdata('company_id'));
		$this->db->where($arrayTransactionDelete);
		$this->db->delete('opposition_transactions');

		if ($transaction['transactions_type'] == "CAPITAL") {
			$this->logger->write( "Oposición", "actualizada", 'Oposición: ' . $order_id . ' ' );
			
			$arrayOrderUpdate = array('loans_no' => $order_id, 'company_id' => $this->session->userdata('company_id'));
			$this->db->where($arrayOrderUpdate);
			$this->db->update('opposition', $order_data);
		}
	}

	public function removeAdditional($order_id, $id, $order_data)
	{
		$this->logger->write( "Oposición", "eliminada", 'adicional del présamo: ' . $order_id . ' ' );
		
		$arrayTransactionDelete = array('transactions_no' => $id, 'company_id' => $this->session->userdata('company_id'));
		$this->db->where($arrayTransactionDelete);
		$this->db->delete('opposition_transactions');

		$this->logger->write( "Oposición", "actualizada", 'Oposición: ' . $order_id . ' ' );

		$arrayOrderUpdate = array('loans_no' => $order_id, 'company_id' => $this->session->userdata('company_id'));
		$this->db->where($arrayOrderUpdate);
		$this->db->update('opposition', $order_data);
	}

	public function removeDiscountTransaction($order_id, $order_data)
	{
		if($order_id && $order_data) {
			$arrayDelete = array('loans_no' => $order_id, 'concept' => "Descuento", 'company_id' => $this->session->userdata('company_id'));

			$this->db->where($arrayDelete);
			$delete = $this->db->delete('opposition_transactions');

			$arrayUpdate = array('loans_no' => $order_id, 'company_id' => $this->session->userdata('company_id'));
			$this->db->where($arrayUpdate);
			$update_order = $this->db->update('opposition', $order_data);
				
			return ($delete == true && $update_order == true) ? true : false;
		}
	}
} 

?>