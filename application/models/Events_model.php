<?php 

class Events_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();

		$this->user_id = $this->session->userdata('userid');
		$this->company_id = $this->session->userdata('company_id');
	}

	/* get all the events data by the given date */
	public function getLoansDataByDate($currentDate = null, $dateType = "month", $addOrSubFromDate = 0)
	{
		//if($currentDate && $dateType) {
			/* switch (isset($dateType)){
				case "día":{
					$sql = "SELECT 'Interes fijo' loans_type, o.loans_amount, o.current_balance, EXTRACT(YEAR FROM o.entry_date) orderYear, EXTRACT(MONTH FROM o.entry_date) orderMonth, EXTRACT(DAY FROM o.entry_date) orderDay, c.customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loansfixed o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND DATE_FORMAT(o.entry_date, '%Y-%m-%d') = DATE_ADD('".$currentDate."', INTERVAL ".$addOrSubFromDate." DAY) ORDER BY EXTRACT(DAY FROM o.entry_date), EXTRACT(MONTH FROM o.entry_date), c.customer_first_name";
					break;
						}
				case "semana":{
						$sql = "SELECT 'Interes fijo' loans_type, o.loans_amount, o.current_balance, EXTRACT(YEAR FROM o.entry_date) orderYear, EXTRACT(MONTH FROM o.entry_date) orderMonth, EXTRACT(DAY FROM o.entry_date) orderDay, c.customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loansfixed o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND EXTRACT(WEEK FROM o.entry_date) = WEEK(DATE_ADD('".$currentDate."', INTERVAL ".$addOrSubFromDate." WEEK)) ORDER BY EXTRACT(DAY FROM o.entry_date), EXTRACT(MONTH FROM o.entry_date), c.customer_first_name";
					break;
						}
				case "mes":{
						$sql = "SELECT 'Interes fijo' loans_type, o.loans_amount, o.current_balance, EXTRACT(YEAR FROM o.entry_date) orderYear, EXTRACT(MONTH FROM o.entry_date) orderMonth, EXTRACT(DAY FROM o.entry_date) orderDay, c.customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loansfixed o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND EXTRACT(MONTH FROM o.entry_date) = MONTH(DATE_ADD(".$currentDate.", INTERVAL ".$addOrSubFromDate." MONTH)) ORDER BY EXTRACT(DAY FROM o.entry_date), EXTRACT(MONTH FROM o.entry_date), c.customer_first_name";
					break;
						}
				case "today":{
						$sql = "SELECT 'Interes fijo' loans_type, o.loans_amount, o.current_balance, EXTRACT(YEAR FROM o.entry_date) orderYear, EXTRACT(MONTH FROM o.entry_date) orderMonth, EXTRACT(DAY FROM o.entry_date) orderDay, c.customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loansfixed o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND DATE_FORMAT(o.entry_date, '%Y-%m-%d') = '".$currentDate."' ORDER BY EXTRACT(DAY FROM o.entry_date), EXTRACT(MONTH FROM o.entry_date), c.customer_first_name";
					break;
						}
				case "week":{
						$sql = "SELECT 'Interes fijo' loans_type, o.loans_amount, o.current_balance, EXTRACT(YEAR FROM o.entry_date) orderYear, EXTRACT(MONTH FROM o.entry_date) orderMonth, EXTRACT(DAY FROM o.entry_date) orderDay, c.customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loansfixed o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND EXTRACT(WEEK FROM o.entry_date) = WEEK(DATE_ADD('".$currentDate."', INTERVAL ".$addOrSubFromDate." WEEK)) ORDER BY EXTRACT(DAY FROM o.entry_date), EXTRACT(MONTH FROM o.entry_date), c.customer_first_name";
					break;
						}
				case "month":{
						$sql = "SELECT 'Interes fijo' loans_type, o.loans_amount, o.current_balance, EXTRACT(YEAR FROM o.entry_date) orderYear, EXTRACT(MONTH FROM o.entry_date) orderMonth, EXTRACT(DAY FROM o.entry_date) orderDay, c.customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loansfixed o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND EXTRACT(MONTH FROM o.entry_date) = MONTH(DATE_ADD('".$currentDate."', INTERVAL ".$addOrSubFromDate." MONTH)) ORDER BY EXTRACT(DAY FROM o.entry_date), EXTRACT(MONTH FROM o.entry_date), c.customer_first_name";
					break;
						}
				default:{
					$sql = "SELECT 'Interes fijo' loans_type, o.loans_amount, o.current_balance, EXTRACT(YEAR FROM o.entry_date) orderYear, EXTRACT(MONTH FROM o.entry_date) orderMonth, EXTRACT(DAY FROM o.entry_date) orderDay, c.customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loansfixed o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND EXTRACT(MONTH FROM o.entry_date) = MONTH(CURDATE()) ORDER BY c.customer_first_name";
					break;
						}
						
           // }
            
			//$query = $this->db->query($sql);
			//return $query->result_array();
		} */

		$sql = "SELECT 'Interes fijo' loans_type, FORMAT(o.loans_amount,2) loans_amount, FORMAT(o.current_balance,2) current_balance, EXTRACT(YEAR FROM o.entry_date) orderYear, EXTRACT(MONTH FROM o.entry_date) orderMonth, EXTRACT(DAY FROM o.entry_date) orderDay, UPPER(c.customer_first_name) customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loansfixed o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loansfixed = $this->db->query($sql)->result_array();

		$sql = "SELECT 'Capital' loans_type, FORMAT(o.loans_amount,2) loans_amount, FORMAT(o.current_balance,2) current_balance, EXTRACT(YEAR FROM o.entry_date) orderYear, EXTRACT(MONTH FROM o.entry_date) orderMonth, EXTRACT(DAY FROM o.entry_date) orderDay, UPPER(c.customer_first_name) customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loanscapital o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loanscapital = $this->db->query($sql)->result_array();
		
		$sql = "SELECT 'Inversión' loans_type, FORMAT(o.loans_amount,2) loans_amount, FORMAT(o.current_balance,2) current_balance, EXTRACT(YEAR FROM o.entry_date) orderYear, EXTRACT(MONTH FROM o.entry_date) orderMonth, EXTRACT(DAY FROM o.entry_date) orderDay, UPPER(c.customer_first_name) customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loansinversion o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loansinversion = $this->db->query($sql)->result_array();

		$sql = "SELECT 'Regalía' loans_type, FORMAT(o.loans_amount,2) loans_amount, FORMAT(o.current_balance,2) current_balance, EXTRACT(YEAR FROM o.entry_date) orderYear, EXTRACT(MONTH FROM o.entry_date) orderMonth, EXTRACT(DAY FROM o.entry_date) orderDay, UPPER(c.customer_first_name) customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loanschristmas o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loanschristmas = $this->db->query($sql)->result_array();

		$sql = "SELECT 'Rápidos' loans_type, FORMAT(o.loans_amount,2) loans_amount, FORMAT(o.current_balance,2) current_balance, EXTRACT(YEAR FROM o.entry_date) orderYear, EXTRACT(MONTH FROM o.entry_date) orderMonth, EXTRACT(DAY FROM o.entry_date) orderDay, UPPER(c.customer_first_name) customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loansquickbusiness o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loansquickbusiness= $this->db->query($sql)->result_array();

		$query = array_merge($loansfixed, $loanscapital, $loansinversion, $loanschristmas, $loansquickbusiness);

		return $query;
	}

	public function getLoansPaymentsDataByDate($currentDate = null, $dateType = "month", $addOrSubFromDate = 0)
	{
		$sql = "SELECT 'Interes fijo' loans_type, FORMAT(ot.amount,2) loans_amount, FORMAT(o.current_balance,2) current_balance, EXTRACT(YEAR FROM ot.payment_date) orderYear, EXTRACT(MONTH FROM ot.payment_date) orderMonth, EXTRACT(DAY FROM ot.payment_date) orderDay, UPPER(c.customer_first_name) customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loansfixed o JOIN loansfixed_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND  (ot.transactions_type='INTERES' OR ot.transactions_type='PAGO IRREGULAR') AND ot.amount > 0 AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loansfixed = $this->db->query($sql)->result_array();

		$sql = "SELECT 'Capital' loans_type, FORMAT(ot.amount,2) loans_amount, FORMAT(o.current_balance,2) current_balance, EXTRACT(YEAR FROM ot.payment_date) orderYear, EXTRACT(MONTH FROM ot.payment_date) orderMonth, EXTRACT(DAY FROM ot.payment_date) orderDay, UPPER(c.customer_first_name) customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loanscapital o JOIN loanscapital_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND  (ot.transactions_type='INTERES' OR ot.transactions_type='PAGO IRREGULAR') AND ot.amount > 0 AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loanscapital = $this->db->query($sql)->result_array();
		
		$sql = "SELECT 'Inversión' loans_type, FORMAT(ot.amount,2) loans_amount, FORMAT(o.current_balance,2) current_balance, EXTRACT(YEAR FROM ot.payment_date) orderYear, EXTRACT(MONTH FROM ot.payment_date) orderMonth, EXTRACT(DAY FROM ot.payment_date) orderDay, UPPER(c.customer_first_name) customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loansinversion o JOIN loansinversion_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND  (ot.transactions_type='INTERES' OR ot.transactions_type='PAGO IRREGULAR') AND ot.amount > 0 AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loansinversion = $this->db->query($sql)->result_array();

		$sql = "SELECT 'Regalía' loans_type, FORMAT(ot.amount,2) loans_amount, FORMAT(o.current_balance,2) current_balance, EXTRACT(YEAR FROM ot.payment_date) orderYear, EXTRACT(MONTH FROM ot.payment_date) orderMonth, EXTRACT(DAY FROM ot.payment_date) orderDay, UPPER(c.customer_first_name) customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loanschristmas o JOIN loanschristmas_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND  (ot.transactions_type='INTERES' OR ot.transactions_type='PAGO IRREGULAR') AND ot.amount > 0 AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loanschristmas = $this->db->query($sql)->result_array();

		$sql = "SELECT 'Rápidos' loans_type, FORMAT(ot.amount,2) loans_amount, FORMAT(o.current_balance,2) current_balance, EXTRACT(YEAR FROM ot.payment_date) orderYear, EXTRACT(MONTH FROM ot.payment_date) orderMonth, EXTRACT(DAY FROM ot.payment_date) orderDay, UPPER(c.customer_first_name) customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loansquickbusiness o JOIN loansquickbusiness_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND  (ot.transactions_type='INTERES' OR ot.transactions_type='PAGO IRREGULAR') AND ot.amount > 0 AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loansquickbusiness= $this->db->query($sql)->result_array();

		$query = array_merge($loansfixed, $loanscapital, $loansinversion, $loanschristmas, $loansquickbusiness);

		return $query;
	}

	public function getLoansDueDataByDate($currentDate = null, $dateType = "month", $addOrSubFromDate = 0)
	{
		$sql = "SELECT 'Interes fijo' loans_type, FORMAT(o.interes_amount,2) loans_amount, FORMAT(o.current_balance,2) current_balance, EXTRACT(YEAR FROM NOW()) orderYear, EXTRACT(MONTH FROM NOW()) orderMonth, EXTRACT(DAY FROM o.start_date) orderDay, UPPER(c.customer_first_name) customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loansfixed o LEFT OUTER JOIN loansfixed_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND ISNULL(ot.amount) AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loansfixed = $this->db->query($sql)->result_array();

		$sql = "SELECT 'Capital' loans_type, FORMAT(o.interes_amount,2) loans_amount, FORMAT(o.current_balance,2) current_balance, EXTRACT(YEAR FROM NOW()) orderYear, EXTRACT(MONTH FROM NOW()) orderMonth, EXTRACT(DAY FROM o.start_date) orderDay, UPPER(c.customer_first_name) customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loanscapital o LEFT OUTER JOIN loanscapital_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND ISNULL(ot.amount) AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loanscapital = $this->db->query($sql)->result_array();
		
		$sql = "SELECT 'Inversión' loans_type, FORMAT(o.interes_amount,2) loans_amount, FORMAT(o.current_balance,2) current_balance, EXTRACT(YEAR FROM NOW()) orderYear, EXTRACT(MONTH FROM NOW()) orderMonth, EXTRACT(DAY FROM o.start_date) orderDay, UPPER(c.customer_first_name) customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loansinversion o LEFT OUTER JOIN loansinversion_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND ISNULL(ot.amount) AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loansinversion = $this->db->query($sql)->result_array();

		$sql = "SELECT 'Regalía' loans_type, FORMAT(o.interes_amount,2) loans_amount, FORMAT(o.current_balance,2) current_balance, EXTRACT(YEAR FROM NOW()) orderYear, EXTRACT(MONTH FROM NOW()) orderMonth, EXTRACT(DAY FROM o.start_date) orderDay, UPPER(c.customer_first_name) customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loanschristmas o LEFT OUTER JOIN loanschristmas_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND ISNULL(ot.amount) AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loanschristmas = $this->db->query($sql)->result_array();

		$sql = "SELECT 'Rápidos' loans_type, FORMAT(o.interes_amount,2) loans_amount, FORMAT(o.current_balance,2) current_balance, EXTRACT(YEAR FROM NOW()) orderYear, EXTRACT(MONTH FROM NOW()) orderMonth, EXTRACT(DAY FROM o.start_date) orderDay, UPPER(c.customer_first_name) customer_first_name, SUBSTRING(MD5(RAND()), 1, 6) color FROM loansquickbusiness o LEFT OUTER JOIN loansquickbusiness_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND ISNULL(ot.amount) AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loansquickbusiness= $this->db->query($sql)->result_array();

		$query = array_merge($loansfixed, $loanscapital, $loansinversion, $loanschristmas, $loansquickbusiness);

		return $query;
	}
	
	/* get all the events data by the given date */
	public function getTotalEventsLoans()
	{
		$sql = "SELECT COUNT(c.customer_first_name) FROM loansfixed o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loansfixed = $this->db->query($sql)->row_array();

		//var_dump($loansfixed);

		$sql = "SELECT COUNT(c.customer_first_name) FROM loanscapital o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loanscapital = $this->db->query($sql)->row_array();
		
		$sql = "SELECT COUNT(c.customer_first_name) FROM loansinversion o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loansinversion = $this->db->query($sql)->row_array();

		$sql = "SELECT COUNT(c.customer_first_name) FROM loanschristmas o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loanschristmas = $this->db->query($sql)->row_array();

		$sql = "SELECT COUNT(c.customer_first_name) FROM loansquickbusiness o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loansquickbusiness= $this->db->query($sql)->row_array();

		$query = ($loansfixed + $loanscapital + $loansinversion + $loanschristmas + $loansquickbusiness);

		return $query;
	}
	
	/* get all the events data by the given date */
	public function getTotalEventsLoansDue()
	{
		$sql = "SELECT COUNT(c.customer_first_name) FROM loansfixed o LEFT OUTER JOIN loansfixed_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND ISNULL(ot.amount) AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loansfixed = $this->db->query($sql)->row_array();

		$sql = "SELECT COUNT(c.customer_first_name) FROM loanscapital o LEFT OUTER JOIN loanscapital_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND ISNULL(ot.amount) AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loanscapital = $this->db->query($sql)->row_array();
		
		$sql = "SELECT COUNT(c.customer_first_name) FROM loansinversion o LEFT OUTER JOIN loansinversion_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND ISNULL(ot.amount) AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loansinversion = $this->db->query($sql)->row_array();

		$sql = "SELECT COUNT(c.customer_first_name) FROM loanschristmas o LEFT OUTER JOIN loanschristmas_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND ISNULL(ot.amount) AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loanschristmas = $this->db->query($sql)->row_array();

		$sql = "SELECT COUNT(c.customer_first_name) FROM loansquickbusiness o LEFT OUTER JOIN loansquickbusiness_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND ISNULL(ot.amount) AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loansquickbusiness= $this->db->query($sql)->row_array();
					
		$query = ($loansfixed + $loanscapital + $loansinversion + $loanschristmas + $loansquickbusiness);
		
		return $query;
	}
	
	/* get all the events data by the given date */
	public function getTotalEventsPayments()
	{
		$sql = "SELECT COUNT(c.customer_first_name) FROM loansfixed o JOIN loansfixed_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND  (ot.transactions_type='INTERES' OR ot.transactions_type='PAGO IRREGULAR') AND ot.amount > 0 AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loansfixed = $this->db->query($sql)->row_array();

		$sql = "SELECT COUNT(c.customer_first_name) FROM loanscapital o JOIN loanscapital_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND  (ot.transactions_type='INTERES' OR ot.transactions_type='PAGO IRREGULAR') AND ot.amount > 0 AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loanscapital = $this->db->query($sql)->row_array();
		
		$sql = "SELECT COUNT(c.customer_first_name) FROM loansinversion o JOIN loansinversion_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND  (ot.transactions_type='INTERES' OR ot.transactions_type='PAGO IRREGULAR') AND ot.amount > 0 AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loansinversion = $this->db->query($sql)->row_array();

		$sql = "SELECT COUNT(c.customer_first_name) FROM loanschristmas o JOIN loanschristmas_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND  (ot.transactions_type='INTERES' OR ot.transactions_type='PAGO IRREGULAR') AND ot.amount > 0 AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loanschristmas = $this->db->query($sql)->row_array();

		$sql = "SELECT COUNT(c.customer_first_name) FROM loansquickbusiness o JOIN loansquickbusiness_transactions ot ON o.loans_no=ot.loans_no JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND o.current_balance > 0 AND  (ot.transactions_type='INTERES' OR ot.transactions_type='PAGO IRREGULAR') AND ot.amount > 0 AND c.company_id = $this->company_id ORDER BY c.customer_first_name";
		$loansquickbusiness= $this->db->query($sql)->row_array();

		$query = ($loansfixed + $loanscapital + $loansinversion + $loanschristmas + $loansquickbusiness);

		return $query;
	}
	
	/* get all the events data by the given date */
	public function getTotalReservationsEventsThisDay()
	{
		$sql = "SELECT COUNT(o.loans_amount) eventsThisDay FROM loansfixed o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND DATE_FORMAT(o.entry_date, '%Y-%m-%d') = CURDATE() ORDER BY EXTRACT(DAY FROM o.entry_date), EXTRACT(MONTH FROM o.entry_date), c.customer_first_name";
			
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	/* get all the events data by the given date */
	public function getTotalReservationsEventsThisWeek()
	{
		$sql = "SELECT COUNT(o.loans_amount) eventsThisWeek FROM loansfixed o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND EXTRACT(WEEK FROM o.entry_date) = WEEK(CURDATE()) ORDER BY EXTRACT(DAY FROM o.entry_date), EXTRACT(MONTH FROM o.entry_date), c.customer_first_name";
					
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	/* get all the events data by the given date */
	public function getTotalReservationsEventsThisMonth()
	{
		$sql = "SELECT COUNT(o.loans_amount) eventsThisMonth FROM loansfixed o JOIN customer c ON o.customer_id = c.customer_id WHERE o.user_id = $this->user_id AND EXTRACT(MONTH FROM o.entry_date) = MONTH(CURDATE()) ORDER BY EXTRACT(DAY FROM o.entry_date), EXTRACT(MONTH FROM o.entry_date), c.customer_first_name";
			
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	/* get all the events data by the given date */
	public function getReservationsEventsDataByDate($dateType = null)
	{
		if($dateType) {
			$sql = "SELECT * FROM ncf WHERE user_id = $this->user_id AND id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
		
		$sql = "SELECT r.loans_amount, r.current_balance, r.entry_date, c.customer_first_name FROM reservations r JOIN customer c ON r.customer_id = c.customer_id WHERE r.user_id = $this->user_id AND EXTRACT(MONTH FROM r.entry_date) = MONTH(".$currentDate.") ORDER BY EXTRACT(DAY FROM r.entry_date), EXTRACT(MONTH FROM r.entry_date), c.customer_first_name";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}
}