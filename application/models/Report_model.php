<?php
defined('BASEPATH') OR exit('No direct script access allowed');
		
class Report_model extends CI_Model  { 

	public function __construct()
	{
		$this->load->database();
	}

	public function findAll($dateform = null, $dateto = null)
	{
		$this->db->select('customer.customer_id, UPPER(customer.customer_first_name) customer_first_name, customer.customer_personalid, 

		COALESCE(loanscapital_amount, 0) loanscapital_amount, loanscapital_unpay_qty,

		COALESCE(loanschristmas_amount, 0) loanschristmas_amount, 

		COALESCE(loansfixed_amount, 0) loansfixed_amount, 

		COALESCE(loansinversion_amount, 0) loansinversion_amount, 

		COALESCE(loansquickbusiness_amount, 0) loansquickbusiness_amount, 

		"'.$dateform.'" as datefrom, "'.$dateto.'" as dateto');

		$this->db->join('(
				SELECT
					`customer_id`,
					SUM(current_balance) AS loansfixed_amount
				FROM
					`loansfixed`
				WHERE
					`current_balance` > 0
				GROUP BY
					`customer_id`
		) AS lf ', 'customer.customer_id = lf.customer_id', 'LEFT OUTER');
		$this->db->or_where('loansfixed.company_id', $this->session->userdata('company_id'));

		$this->db->join('(
				SELECT
					`customer_id`,
					IFNULL((SELECT TIMESTAMPDIFF(MONTH, t.payment_date, CURDATE()) FROM loanscapital_transactions t WHERE loanscapital.loans_no=t.loans_no AND (t.transactions_type="CUOTA" OR t.transactions_type="INTERES") ORDER BY t.payment_date DESC LIMIT 1), 0) AS loanscapital_unpay_qty,
					(SUM(current_balance) + IFNULL((SELECT (TIMESTAMPDIFF(MONTH, t.payment_date, CURDATE()) * loanscapital.interes) FROM loanscapital_transactions t WHERE loanscapital.loans_no=t.loans_no AND (t.transactions_type="CUOTA" OR t.transactions_type="INTERES") ORDER BY t.payment_date DESC LIMIT 1), 0) - IFNULL((SELECT SUM(t.capital_paid) FROM loanscapital_transactions t WHERE t.loans_no=loanscapital.loans_no AND t.amount != 0),0)) AS loanscapital_amount
				FROM
					`loanscapital`
				WHERE
					`current_balance` > 0
				GROUP BY
					`customer_id`
		) AS lc', 'customer.customer_id = lc.customer_id ', 'LEFT OUTER');
		$this->db->or_where('loanscapital.company_id', $this->session->userdata('company_id'));

		$this->db->join('(
				SELECT
					`customer_id`,
					SUM(current_balance) AS loansinversion_amount
				FROM
					`loansinversion`
				WHERE
					`current_balance` > 0
				GROUP BY
					`customer_id`
		) AS li', 'customer.customer_id = li.customer_id ', 'LEFT OUTER');
		$this->db->or_where('loansinversion.company_id', $this->session->userdata('company_id'));

		$this->db->join('(
				SELECT
					`customer_id`,
					SUM(current_balance) AS loansquickbusiness_amount
				FROM
					`loansquickbusiness`
				WHERE
					`current_balance` > 0
				GROUP BY
					`customer_id`
		) AS lqb', 'customer.customer_id = lqb.customer_id ', 'LEFT OUTER');
		$this->db->or_where('loansquickbusiness.company_id', $this->session->userdata('company_id'));

		$this->db->join('(
				SELECT
					`customer_id`,
					SUM(current_balance) AS loanschristmas_amount
				FROM
					`loanschristmas`
				WHERE
					`current_balance` > 0
				GROUP BY
					`customer_id`
		) AS lch', 'customer.customer_id = lch.customer_id', 'LEFT OUTER');
		$this->db->or_where('loanschristmas.company_id', $this->session->userdata('company_id'));

		/*$this->db->where('loansfixed.entry_date >=', $dateform);
		$this->db->where('loansfixed.entry_date <=', $dateto);

		$this->db->where('loanscapital.entry_date >=', $dateform);
		$this->db->where('loanscapital.entry_date <=', $dateto);

		$this->db->where('loansinversion.entry_date >=', $dateform);
		$this->db->where('loansinversion.entry_date <=', $dateto);

		$this->db->where('loansquickbusiness.entry_date >=', $dateform);
		$this->db->where('loansquickbusiness.entry_date <=', $dateto);

		$this->db->where('loanschristmas.entry_date >=', $dateform);
		$this->db->where('loanschristmas.entry_date <=', $dateto);*/

		$this->db->where('customer.company_id', $this->session->userdata('company_id'));

		$this->db->group_by('customer.customer_id');
		$this->db->order_by('customer.customer_first_name', 'ASC');

		return $this->db->get('customer')->result();
	}
	
	public function findAllFixed($dateform = null, $dateto = null)
	{
		$this->db->select('customer.customer_id, UPPER(customer.customer_first_name) customer_first_name, customer.customer_personalid, 
		IFNULL(loansfixed.due_amount, 0) loansfixed_amount, "'.$dateform.'" as datefrom, "'.$dateto.'" as dateto');

		$this->db->join('loansfixed', 'customer.customer_id = loansfixed.customer_id', 'LEFT');
		$this->db->or_where('loansfixed.company_id', $this->session->userdata('company_id'));
		
		$this->db->where('loansfixed.entry_date >=', $dateform);
		$this->db->where('loansfixed.entry_date <=', $dateto);
		
		$this->db->where('customer.company_id', $this->session->userdata('company_id'));

		$this->db->group_by('customer.customer_id');
		$this->db->order_by('customer.customer_first_name', 'ASC');

		return $this->db->get('customer')->result();
	}
	
	public function findAllCapital($dateform = null, $dateto = null)
	{
		$this->db->select('customer.customer_id, UPPER(customer.customer_first_name) customer_first_name, customer.customer_personalid, 
		IFNULL(loanscapital.due_amount, 0) loanscapital_amount, "'.$dateform.'" as datefrom, "'.$dateto.'" as dateto');

		$this->db->join('loanscapital', 'customer.customer_id = loanscapital.customer_id', 'LEFT');
		$this->db->or_where('loanscapital.company_id', $this->session->userdata('company_id'));
		
		$this->db->where('loanscapital.entry_date >=', $dateform);
		$this->db->where('loanscapital.entry_date <=', $dateto);
		
		$this->db->where('customer.company_id', $this->session->userdata('company_id'));

		$this->db->group_by('customer.customer_id');
		$this->db->order_by('customer.customer_first_name', 'ASC');

		return $this->db->get('customer')->result();
	}
	
	public function findAllInversion($dateform = null, $dateto = null)
	{
		$this->db->select('customer.customer_id, UPPER(customer.customer_first_name) customer_first_name, customer.customer_personalid, 
		IFNULL(loansinversion.due_amount, 0) loansinversion_amount, "'.$dateform.'" as datefrom, "'.$dateto.'" as dateto');

		$this->db->join('loansinversion', 'customer.customer_id = loansinversion.customer_id', 'LEFT');
		$this->db->or_where('loansinversion.company_id', $this->session->userdata('company_id'));

		$this->db->where('loansinversion.entry_date >=', $dateform);
		$this->db->where('loansinversion.entry_date <=', $dateto);
		
		$this->db->where('customer.company_id', $this->session->userdata('company_id'));

		$this->db->group_by('customer.customer_id');
		$this->db->order_by('customer.customer_first_name', 'ASC');

		return $this->db->get('customer')->result();
	}
	
	public function findAllQuickbusiness($dateform = null, $dateto = null)
	{
		$this->db->select('customer.customer_id, UPPER(customer.customer_first_name) customer_first_name, customer.customer_personalid, 
		IFNULL(loansquickbusiness.due_amount, 0) loansquickbusiness_amount, "'.$dateform.'" as datefrom, "'.$dateto.'" as dateto');

		$this->db->join('loansquickbusiness', 'customer.customer_id = loansquickbusiness.customer_id', 'LEFT');
		$this->db->or_where('loansquickbusiness.company_id', $this->session->userdata('company_id'));
		
		$this->db->where('loansquickbusiness.entry_date >=', $dateform);
		$this->db->where('loansquickbusiness.entry_date <=', $dateto);
		
		$this->db->where('customer.company_id', $this->session->userdata('company_id'));

		$this->db->group_by('customer.customer_id');
		$this->db->order_by('customer.customer_first_name', 'ASC');

		return $this->db->get('customer')->result();
	}
	
	public function findAllChristmas($dateform = null, $dateto = null)
	{
		$this->db->select('customer.customer_id, UPPER(customer.customer_first_name) customer_first_name, customer.customer_personalid, 
		IFNULL(loanschristmas.due_amount, 0) loanschristmas_amount, "'.$dateform.'" as datefrom, "'.$dateto.'" as dateto');

		$this->db->join('loanschristmas', 'customer.customer_id = loanschristmas.customer_id', 'LEFT');
		$this->db->or_where('loanschristmas.company_id', $this->session->userdata('company_id'));

		$this->db->where('loanschristmas.entry_date >=', $dateform);
		$this->db->where('loanschristmas.entry_date <=', $dateto);
		
		$this->db->where('customer.company_id', $this->session->userdata('company_id'));

		$this->db->group_by('customer.customer_id');
		$this->db->order_by('customer.customer_first_name', 'ASC');

		return $this->db->get('customer')->result();
	}

	public function findAllCustomers($dateform = null, $dateto = null)
	{
		$this->db->select('customer.customer_id, UPPER(customer.customer_first_name) customer_first_name, customer.customer_personalid, customer.customer_phone, "'.$dateform.'" as datefrom, "'.$dateto.'" as dateto,

		IF(ISNULL((SELECT loansfixed.loans_amount FROM loansfixed WHERE loansfixed.current_balance > 0 AND loansfixed.company_id="'.$this->session->userdata('company_id').'" AND loansfixed.customer_id=customer.customer_id GROUP BY loansfixed.customer_id)), "No", "Si") loansfixed_active, 
		
		IF(ISNULL((SELECT loanscapital.loans_amount FROM loanscapital WHERE loanscapital.current_balance > 0 AND loanscapital.company_id="'.$this->session->userdata('company_id').'" AND loanscapital.customer_id=customer.customer_id GROUP BY loanscapital.customer_id)), "No", "Si") loanscapital_active, 
		
		IF(ISNULL((SELECT loanschristmas.loans_amount FROM loanschristmas WHERE loanschristmas.current_balance > 0 AND loanschristmas.company_id="'.$this->session->userdata('company_id').'" AND loanschristmas.customer_id=customer.customer_id GROUP BY loanschristmas.customer_id)), "No", "Si") loanschristmas_active, 
		
		IF(ISNULL((SELECT loansquickbusiness.loans_amount FROM loansquickbusiness WHERE loansquickbusiness.current_balance > 0 AND loansquickbusiness.company_id="'.$this->session->userdata('company_id').'" AND loansquickbusiness.customer_id=customer.customer_id GROUP BY loansquickbusiness.customer_id)), "No", "Si") loansquickbusiness_active, 
		
		IF(ISNULL((SELECT loansinversion.loans_amount FROM loansinversion WHERE loansinversion.current_balance > 0 AND loansinversion.company_id="'.$this->session->userdata('company_id').'" AND loansinversion.customer_id=customer.customer_id GROUP BY loansinversion.customer_id)), "No", "Si") loansinversion_active
		');

		$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->order_by('customer.customer_first_name', 'ASC');

		return $this->db->get('customer')->result();
	}

	public function findAllPayments($report_type, $dateform, $dateto)
	{
		$this->db->select('customer.customer_id, UPPER(customer.customer_first_name) customer_first_name, customer.customer_personalid, "'.$dateform.'" as datefrom, "'.$dateto.'" as dateto,
		(SELECT IF(ISNULL(loansfixed_transactions.amount), 0, SUM(loansfixed_transactions.amount)) FROM loansfixed LEFT JOIN loansfixed_transactions ON loansfixed.loans_no = loansfixed_transactions.loans_no WHERE customer.customer_id = loansfixed.customer_id AND loansfixed_transactions.payment_date BETWEEN "'.$dateform.'" AND "'.$dateto.'" AND (loansfixed_transactions.transactions_type="CAPITAL" OR loansfixed_transactions.transactions_type="INTERES" OR loansfixed_transactions.transactions_type="PAGO IRREGULAR")) loansfixed_amount, 
		
		(SELECT IF(ISNULL(loanscapital_transactions.amount), 0, SUM(loanscapital_transactions.amount)) FROM loanscapital LEFT JOIN loanscapital_transactions ON loanscapital.loans_no = loanscapital_transactions.loans_no WHERE customer.customer_id = loanscapital.customer_id AND loanscapital_transactions.payment_date BETWEEN "'.$dateform.'" AND "'.$dateto.'" AND (loanscapital_transactions.transactions_type="CAPITAL" OR loanscapital_transactions.transactions_type="INTERES" OR loanscapital_transactions.transactions_type="CUOTA" OR loanscapital_transactions.transactions_type="PAGO IRREGULAR")) loanscapital_amount, 
		
		(SELECT IF(ISNULL(loanschristmas_transactions.amount), 0, SUM(loanschristmas_transactions.amount)) FROM loanschristmas LEFT JOIN loanschristmas_transactions ON loanschristmas.loans_no = loanschristmas_transactions.loans_no WHERE customer.customer_id = loanschristmas.customer_id AND loanschristmas_transactions.payment_date BETWEEN "'.$dateform.'" AND "'.$dateto.'" AND (loanschristmas_transactions.transactions_type="CAPITAL" OR loanschristmas_transactions.transactions_type="INTERES" OR loanschristmas_transactions.transactions_type="PAGO IRREGULAR")) loanschristmas_amount, 
		
		(SELECT IF(ISNULL(loansquickbusiness_transactions.amount), 0, SUM(loansquickbusiness_transactions.amount)) FROM loansquickbusiness LEFT JOIN loansquickbusiness_transactions ON loansquickbusiness.loans_no = loansquickbusiness_transactions.loans_no WHERE customer.customer_id = loansquickbusiness.customer_id AND loansquickbusiness_transactions.payment_date BETWEEN "'.$dateform.'" AND "'.$dateto.'" AND (loansquickbusiness_transactions.transactions_type="CAPITAL" OR loansquickbusiness_transactions.transactions_type="INTERES" OR loansquickbusiness_transactions.transactions_type="PAGO IRREGULAR")) loansquickbusiness_amount, 
		
		(SELECT IF(ISNULL(loansinversion_transactions.amount), 0, SUM(loansinversion_transactions.amount)) FROM loansinversion LEFT JOIN loansinversion_transactions ON loansinversion.loans_no = loansinversion_transactions.loans_no WHERE customer.customer_id = loansinversion.customer_id AND loansinversion_transactions.payment_date BETWEEN "'.$dateform.'" AND "'.$dateto.'" AND (loansinversion_transactions.transactions_type="CAPITAL" OR loansinversion_transactions.transactions_type="INTERES" OR loansinversion_transactions.transactions_type="PAGO IRREGULAR")) loansinversion_amount 
		'); 

		$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->group_by('customer.customer_id');
		$this->db->order_by('customer.customer_first_name', 'ASC');

		return $this->db->get('customer')->result();
	}

	public function findLoans($report_type, $dateform, $dateto)
	{
		$this->db->select('entry_date, UPPER(customer_first_name) customer_first_name, customer.customer_personalid, due_amount, current_balance, loans_amount, interes_amount, "'.$dateform.'" as datefrom, "'.$dateto.'" as dateto 
		'); 

		switch ($report_type) {
			case 'Fijos':
				$this->db->join('loansfixed', 'customer.customer_id = loansfixed.customer_id', 'LEFT');
				$this->db->where('loansfixed.company_id', $this->session->userdata('company_id'));
				$this->db->where('loansfixed.current_balance >','0');
				break;
			case 'Capital':
				$this->db->join('loanscapital', 'customer.customer_id = loanscapital.customer_id', 'LEFT');
				$this->db->where('loanscapital.company_id', $this->session->userdata('company_id'));
				$this->db->where('loanscapital.current_balance >','0');

				break;
			case 'Inversion':
				$this->db->join('loansinversion', 'customer.customer_id = loansinversion.customer_id', 'LEFT');
				$this->db->where('loansinversion.company_id', $this->session->userdata('company_id'));
				$this->db->where('loansinversion.current_balance >','0');

				break;
			case 'Rapidos':
				$this->db->join('loansquickbusiness', 'customer.customer_id = loansquickbusiness.customer_id', 'LEFT');
				$this->db->where('loansquickbusiness.company_id', $this->session->userdata('company_id'));
				$this->db->where('loansquickbusiness.current_balance >','0');

				break;
			case 'Regalia':
				//$this->db->select('entry_date, UPPER(customer_first_name) customer_first_name, customer.customer_personalid, due_amount, current_balance, loans_amount, interes_amount, "'.$dateform.'" as datefrom, "'.$dateto.'" as dateto'); 
				$this->db->join('loanschristmas', 'customer.customer_id = loanschristmas.customer_id', 'LEFT');
				$this->db->where('loanschristmas.company_id', $this->session->userdata('company_id'));
				$this->db->where('loanschristmas.current_balance >','0');

				break;
			default:
				$this->db->join('loansfixed', 'customer.customer_id = loansfixed.customer_id', 'LEFT');
				$this->db->where('loansfixed.company_id', $this->session->userdata('company_id'));
				$this->db->where('loansfixed.current_balance >','0');
				break;
		}

		$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->where('entry_date >=', $dateform);
		$this->db->where('entry_date <=', $dateto);
		$this->db->order_by('customer_first_name', 'ASC');

		return $this->db->get('customer')->result();
	}

	public function findPayments($report_type, $dateform, $dateto)
	{
		//$this->db->select('payment_date, UPPER(customer_first_name) customer_first_name, customer.customer_personalid, interes_amount, amount, concept, IFNULL(payer_name, customer_first_name) payer_name, "'.$dateform.'" as datefrom, "'.$dateto.'" as dateto '); 
		$this->db->select('UPPER(customer_first_name) customer_first_name, customer.customer_personalid, IFNULL(current_balance, 0) current_balance, IFNULL(interes_amount, 0) interes_amount, IFNULL(amount, 0) amount, IFNULL(payer_name, customer_first_name) payer_name, "'.$dateform.'" as datefrom, "'.$dateto.'" as dateto');

		switch ($report_type) {
			case 'Fijos':
				$this->db->join('loansfixed', 'customer.customer_id = loansfixed.customer_id', 'LEFT');
				$this->db->join('loansfixed_transactions', 'loansfixed.loans_no = loansfixed_transactions.loans_no AND payment_date >= "'. $dateform .'" AND payment_date <= "'. $dateto .'" AND transactions_type IN ("CAPITAL", "CUOTA", "INTERES", "PAGO IRREGULAR")', 'LEFT');
				//$this->db->where('loansfixed.company_id', $this->session->userdata('company_id'));
				//$this->db->where('loansfixed_transactions.company_id', $this->session->userdata('company_id'));
				$this->db->where('loansfixed.current_balance >','0');

				break;
			case 'Capital':
				$this->db->join('loanscapital', 'customer.customer_id = loanscapital.customer_id', 'LEFT');
				$this->db->join('loanscapital_transactions', 'loanscapital.loans_no = loanscapital_transactions.loans_no AND payment_date >= "'. $dateform .'" AND payment_date <= "'. $dateto .'" AND transactions_type IN ("CAPITAL", "CUOTA", "INTERES", "PAGO IRREGULAR")', 'LEFT');
				//$this->db->where('loanscapital.company_id', $this->session->userdata('company_id'));
				//$this->db->where('loanscapital_transactions.company_id', $this->session->userdata('company_id'));
				$this->db->where('loanscapital.current_balance >','0');

				break;
			case 'Inversion':
				$this->db->join('loansinversion', 'customer.customer_id = loansinversion.customer_id', 'LEFT');
				$this->db->join('loansinversion_transactions', 'loansinversion.loans_no = loansinversion_transactions.loans_no AND payment_date >= "'. $dateform .'" AND payment_date <= "'. $dateto .'" AND transactions_type IN ("CAPITAL", "CUOTA", "INTERES", "PAGO IRREGULAR")', 'LEFT');
				//$this->db->where('loansinversion.company_id', $this->session->userdata('company_id'));
				//$this->db->where('loansinversion_transactions.company_id', $this->session->userdata('company_id'));
				$this->db->where('loansinversion.current_balance >','0');

				break;
			case 'Rapidos':
				$this->db->join('loansquickbusiness', 'customer.customer_id = loansquickbusiness.customer_id', 'LEFT');
				$this->db->join('loansquickbusiness_transactions', 'loansquickbusiness.loans_no = loansquickbusiness_transactions.loans_no AND payment_date >= "'. $dateform .'" AND payment_date <= "'. $dateto .'" AND transactions_type IN ("CAPITAL", "CUOTA", "INTERES", "PAGO IRREGULAR")', 'LEFT');
				//$this->db->where('loansquickbusiness.company_id', $this->session->userdata('company_id'));
				//$this->db->where('loansquickbusiness_transactions.company_id', $this->session->userdata('company_id'));
				$this->db->where('loansquickbusiness.current_balance >','0');

				break;
			case 'Regalia':
				$this->db->join('loanschristmas', 'customer.customer_id = loanschristmas.customer_id', 'LEFT');
				$this->db->join('loanschristmas_transactions', 'loanschristmas.loans_no = loanschristmas_transactions.loans_no AND payment_date >= "'. $dateform .'" AND payment_date <= "'. $dateto .'" AND transactions_type IN ("CAPITAL", "CUOTA", "INTERES", "PAGO IRREGULAR")', 'LEFT');
				//$this->db->where('loanschristmas.company_id', $this->session->userdata('company_id'));
				//$this->db->where('loanschristmas_transactions.company_id', $this->session->userdata('company_id'));
				$this->db->where('loanschristmas.current_balance >','0');

				break;
			default:
				$this->db->join('loansfixed', 'customer.customer_id = loansfixed.customer_id', 'LEFT');
				$this->db->join('loansfixed_transactions', 'loansfixed.loans_no = loansfixed_transactions.loans_no AND payment_date >= "'. $dateform .'" AND payment_date <= "'. $dateto .'" AND transactions_type NOT IN ("ADICIONAL AL CAPITAL	", "ADICIONAL AL CAPITAL")', 'LEFT');
				//$this->db->where('loansfixed.company_id', $this->session->userdata('company_id'));
				//$this->db->where('loansfixed_transactions.company_id', $this->session->userdata('company_id'));
				$this->db->where('loansfixed.current_balance >','0');
				break;
		}

		//$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		//$this->db->where('payment_date >=', $dateform);
		//$this->db->where('payment_date <=', $dateto);
		//$this->db->where_in('transactions_type', array('CAPITAL', 'CUOTA', 'INTERES', 'PAGO IRREGULAR'));
		$this->db->order_by('customer_first_name', 'ASC');

		return $this->db->get('customer')->result();
	}

	public function findCashFlow($report_type, $dateform, $dateto)
	{
		$this->db->select(' payment_date, UPPER(customer_first_name) customer_first_name, customer.customer_personalid, IFNULL(current_balance, 0) current_balance, concept, IFNULL(interes_amount, 0) interes_amount, IFNULL(amount, 0) amount, IFNULL(payer_name, customer_first_name) payer_name, "'.$dateform.'" as datefrom, "'.$dateto.'" as dateto'); 

		switch ($report_type) {
			case 'Fijos':
				$this->db->join('loansfixed', 'customer.customer_id = loansfixed.customer_id', 'LEFT');
				$this->db->join('loansfixed_transactions', 'loansfixed.loans_no = loansfixed_transactions.loans_no AND loansfixed_transactions.payment_date >= "'. $dateform .'" AND loansfixed_transactions.payment_date <= "'. $dateto .'"', 'LEFT');
				//$this->db->where('loansfixed.company_id', $this->session->userdata('company_id'));
				//$this->db->where('loansfixed_transactions.company_id', $this->session->userdata('company_id'));
				$this->db->where('loansfixed.current_balance >','0');

				break;
			case 'Capital':
				$this->db->join('loanscapital', 'customer.customer_id = loanscapital.customer_id', 'LEFT');
				$this->db->join('loanscapital_transactions', 'loanscapital.loans_no = loanscapital_transactions.loans_no AND loanscapital_transactions.payment_date >= "'. $dateform .'" AND loanscapital_transactions.payment_date <= "'. $dateto .'"', 'LEFT');
				//$this->db->where('loanscapital.company_id', $this->session->userdata('company_id'));
				//$this->db->where('loanscapital_transactions.company_id', $this->session->userdata('company_id'));
				$this->db->where('loanscapital.current_balance >','0');

				break;
			case 'Inversion':
				$this->db->join('loansinversion', 'customer.customer_id = loansinversion.customer_id', 'LEFT');
				$this->db->join('loansinversion_transactions', 'loansinversion.loans_no = loansinversion_transactions.loans_no AND loansinversion_transactions.payment_date >= "'. $dateform .'" AND loansinversion_transactions.payment_date <= "'. $dateto .'"', 'LEFT');
				//$this->db->where('loansinversion.company_id', $this->session->userdata('company_id'));
				//$this->db->where('loansinversion_transactions.company_id', $this->session->userdata('company_id'));
				$this->db->where('loansinversion.current_balance >','0');

				break;
			case 'Rapidos':
				$this->db->join('loansquickbusiness', 'customer.customer_id = loansquickbusiness.customer_id', 'LEFT');
				$this->db->join('loansquickbusiness_transactions', 'loansquickbusiness.loans_no = loansquickbusiness_transactions.loans_no AND loansquickbusiness_transactions.payment_date >= "'. $dateform .'" AND loansquickbusiness_transactions.payment_date <= "'. $dateto .'"', 'LEFT');
				//$this->db->where('loansquickbusiness.company_id', $this->session->userdata('company_id'));
				//$this->db->where('loansquickbusiness_transactions.company_id', $this->session->userdata('company_id'));
				$this->db->where('loansquickbusiness.current_balance >','0');

				break;
			case 'Regalia':
				$this->db->join('loanschristmas', 'customer.customer_id = loanschristmas.customer_id', 'LEFT');
				$this->db->join('loanschristmas_transactions', 'loanschristmas.loans_no = loanschristmas_transactions.loans_no AND loanschristmas_transactions.payment_date >= "'. $dateform .'" AND loanschristmas_transactions.payment_date <= "'. $dateto .'"', 'LEFT');
				//$this->db->where('loanschristmas.company_id', $this->session->userdata('company_id'));
				//$this->db->where('loanschristmas_transactions.company_id', $this->session->userdata('company_id'));
				$this->db->where('loanschristmas.current_balance >','0');

				break;
			default:
				//$this->db->select(' payment_date, UPPER(customer_first_name) customer_first_name, customer.customer_personalid, IFNULL(current_balance, 0) current_balance, concept, IFNULL(interes_amount, 0) interes_amount, IFNULL(amount, 0) amount, , IFNULL(payer_name, customer_first_name) payer_name, "'.$dateform.'" as datefrom, "'.$dateto.'" as dateto FROM customer LEFT JOIN loansfixed ON customer.customer_id=loansfixed.customer_id LEFT JOIN loansfixed_transactions ON loansfixed.loans_no = loansfixed_transactions.loans_no AND loansfixed_transactions.payment_date >= "'. $dateform .'" AND loansfixed_transactions.payment_date <= "'. $dateto .'" ORDER BY customer_first_name '); 

				$this->db->join('loansfixed', 'customer.customer_id = loansfixed.customer_id', 'LEFT');
				$this->db->join('loansfixed_transactions', 'loansfixed.loans_no = loansfixed_transactions.loans_no AND loansfixed_transactions.payment_date >= "'. $dateform .'" AND loansfixed_transactions.payment_date <= "'. $dateto .'"', 'LEFT');
				//$this->db->where('loansfixed.company_id', $this->session->userdata('company_id'));
				//$this->db->where('loansfixed_transactions.company_id', $this->session->userdata('company_id'));
				$this->db->where('loansfixed.current_balance >','0');

				break;
		}

		//$this->db->where('customer.company_id', $this->session->userdata('company_id'));
		$this->db->order_by('customer_first_name', 'ASC');

		return $this->db->get('customer')->result();
	}
		
	public function findOne($id)
	{
		$this->db->where('purchase_no',$id);
		return $this->db->get('sales')->result();
	}

	public function findEvents($dateform, $dateto)
	{
		$this->db->select('"'.$dateform.'" as datefrom, "'.$dateto.'" as dateto,
		expense.* FROM expense WHERE company_id="'.$this->session->userdata('company_id').'" AND PaidDate BETWEEN "'.$dateform.'" AND "'.$dateto.'" '); 

		return $this->db->get()->result();
	}

	public function findExpense($dateform, $dateto)
	{
		$this->db->select('"'.$dateform.'" as datefrom, "'.$dateto.'" as dateto,
		expense.* FROM expense WHERE company_id="'.$this->session->userdata('company_id').'" AND PaidDate BETWEEN "'.$dateform.'" AND "'.$dateto.'" '); 

		return $this->db->get()->result();
	}

	public function totalExpenses($dateform, $dateto)
	{
		$this->db->select('"'.$dateform.'" as datefrom, "'.$dateto.'" as dateto,
		(SELECT IF(ISNULL(Amount), 0, SUM(Amount)) FROM expense WHERE company_id="'.$this->session->userdata('company_id').'" AND PaidDate BETWEEN "'.$dateform.'" AND "'.$dateto.'") total_amount
		'); 

		return $this->db->get()->result();
	}

	public function totalLoans($report_type, $dateform, $dateto)
	{
		$this->db->select('"'.$dateform.'" as datefrom, "'.$dateto.'" as dateto,
		(SELECT IF(ISNULL(loansfixed.loans_amount), 0, SUM(loansfixed.loans_amount)) FROM loansfixed WHERE loansfixed.current_balance > 0 AND loansfixed.company_id="'.$this->session->userdata('company_id').'" AND loansfixed.entry_date BETWEEN "'.$dateform.'" AND "'.$dateto.'") loansfixed_total_amount, 
		
		(SELECT IF(ISNULL(loanscapital.loans_amount), 0, SUM(loanscapital.loans_amount)) FROM loanscapital WHERE loanscapital.current_balance > 0 AND loanscapital.company_id="'.$this->session->userdata('company_id').'" AND loanscapital.entry_date BETWEEN "'.$dateform.'" AND "'.$dateto.'") loanscapital_total_amount, 
		
		(SELECT IF(ISNULL(loanschristmas.loans_amount), 0, SUM(loanschristmas.loans_amount)) FROM loanschristmas WHERE loanschristmas.current_balance > 0 AND loanschristmas.company_id="'.$this->session->userdata('company_id').'" AND loanschristmas.entry_date BETWEEN "'.$dateform.'" AND "'.$dateto.'") loanschristmas_total_amount, 
		
		(SELECT IF(ISNULL(loansquickbusiness.loans_amount), 0, SUM(loansquickbusiness.loans_amount)) FROM loansquickbusiness WHERE loansquickbusiness.current_balance > 0 AND loansquickbusiness.company_id="'.$this->session->userdata('company_id').'" AND loansquickbusiness.entry_date BETWEEN "'.$dateform.'" AND "'.$dateto.'") loansquickbusiness_total_amount, 
		
		(SELECT IF(ISNULL(loansinversion.loans_amount), 0, SUM(loansinversion.loans_amount)) FROM loansinversion WHERE loansinversion.current_balance > 0 AND loansinversion.company_id="'.$this->session->userdata('company_id').'" AND loansinversion.entry_date BETWEEN "'.$dateform.'" AND "'.$dateto.'") loansinversion_total_amount 
		'); 

		return $this->db->get()->result();
	}

	public function totalPayments($report_type, $dateform, $dateto)
	{
		$this->db->select('"'.$dateform.'" as datefrom, "'.$dateto.'" as dateto,
		(SELECT IF(ISNULL(loansfixed_transactions.amount), 0, SUM(loansfixed_transactions.amount)) FROM loansfixed LEFT JOIN loansfixed_transactions ON loansfixed.loans_no = loansfixed_transactions.loans_no WHERE loansfixed.company_id="'.$this->session->userdata('company_id').'" AND loansfixed_transactions.payment_date BETWEEN "'.$dateform.'" AND "'.$dateto.'" AND (loansfixed_transactions.transactions_type="CAPITAL" OR loansfixed_transactions.transactions_type="INTERES" OR loansfixed_transactions.transactions_type="PAGO IRREGULAR")) loansfixed_amount, 
		
		(SELECT IF(ISNULL(loanscapital_transactions.amount), 0, SUM(loanscapital_transactions.amount)) FROM loanscapital LEFT JOIN loanscapital_transactions ON loanscapital.loans_no = loanscapital_transactions.loans_no WHERE loanscapital.company_id="'.$this->session->userdata('company_id').'" AND loanscapital_transactions.payment_date BETWEEN "'.$dateform.'" AND "'.$dateto.'" AND (loanscapital_transactions.transactions_type="CAPITAL" OR loanscapital_transactions.transactions_type="INTERES" OR loanscapital_transactions.transactions_type="CUOTA" OR loanscapital_transactions.transactions_type="PAGO IRREGULAR")) loanscapital_amount, 
		
		(SELECT IF(ISNULL(loanschristmas_transactions.amount), 0, SUM(loanschristmas_transactions.amount)) FROM loanschristmas LEFT JOIN loanschristmas_transactions ON loanschristmas.loans_no = loanschristmas_transactions.loans_no WHERE loanschristmas.company_id="'.$this->session->userdata('company_id').'" AND loanschristmas_transactions.payment_date BETWEEN "'.$dateform.'" AND "'.$dateto.'" AND (loanschristmas_transactions.transactions_type="CAPITAL" OR loanschristmas_transactions.transactions_type="INTERES" OR loanschristmas_transactions.transactions_type="CUOTA" OR loanschristmas_transactions.transactions_type="PAGO IRREGULAR")) loanschristmas_amount, 
		
		(SELECT IF(ISNULL(loansquickbusiness_transactions.amount), 0, SUM(loansquickbusiness_transactions.amount)) FROM loansquickbusiness LEFT JOIN loansquickbusiness_transactions ON loansquickbusiness.loans_no = loansquickbusiness_transactions.loans_no WHERE loansquickbusiness.company_id="'.$this->session->userdata('company_id').'" AND loansquickbusiness_transactions.payment_date BETWEEN "'.$dateform.'" AND "'.$dateto.'" AND (loansquickbusiness_transactions.transactions_type="CAPITAL" OR loansquickbusiness_transactions.transactions_type="INTERES" OR loansquickbusiness_transactions.transactions_type="PAGO IRREGULAR")) loansquickbusiness_amount, 
		
		(SELECT IF(ISNULL(loansinversion_transactions.amount), 0, SUM(loansinversion_transactions.amount)) FROM loansinversion LEFT JOIN loansinversion_transactions ON loansinversion.loans_no = loansinversion_transactions.loans_no WHERE loansinversion.company_id="'.$this->session->userdata('company_id').'" AND loansinversion_transactions.payment_date BETWEEN "'.$dateform.'" AND "'.$dateto.'" AND (loansinversion_transactions.transactions_type="CAPITAL" OR loansinversion_transactions.transactions_type="INTERES" OR loansinversion_transactions.transactions_type="PAGO IRREGULAR")) loansinversion_amount 
		'); 

		return $this->db->get()->result();
	}

	public function totalAdditionals($report_type, $dateform, $dateto)
	{
		$this->db->select('"'.$dateform.'" as datefrom, "'.$dateto.'" as dateto,
		(SELECT IF(ISNULL(loansfixed_transactions.amount), 0, SUM(loansfixed_transactions.amount)) FROM loansfixed LEFT JOIN loansfixed_transactions ON loansfixed.loans_no = loansfixed_transactions.loans_no WHERE loansfixed.current_balance > 0 AND loansfixed.company_id="'.$this->session->userdata('company_id').'" AND loansfixed_transactions.payment_date BETWEEN "'.$dateform.'" AND "'.$dateto.'" AND loansfixed_transactions.transactions_type="ADICIONAL") loansfixed_additional_amount, 
		
		(SELECT IF(ISNULL(loanscapital_transactions.amount), 0, SUM(loanscapital_transactions.amount)) FROM loanscapital LEFT JOIN loanscapital_transactions ON loanscapital.loans_no = loanscapital_transactions.loans_no WHERE loanscapital.current_balance > 0 AND loanscapital.company_id="'.$this->session->userdata('company_id').'" AND loanscapital_transactions.payment_date BETWEEN "'.$dateform.'" AND "'.$dateto.'" AND loanscapital_transactions.transactions_type="ADICIONAL") loanscapital_additional_amount, 
		
		(SELECT IF(ISNULL(loanschristmas_transactions.amount), 0, SUM(loanschristmas_transactions.amount)) FROM loanschristmas LEFT JOIN loanschristmas_transactions ON loanschristmas.loans_no = loanschristmas_transactions.loans_no WHERE loanschristmas.current_balance > 0 AND loanschristmas.company_id="'.$this->session->userdata('company_id').'" AND loanschristmas_transactions.payment_date BETWEEN "'.$dateform.'" AND "'.$dateto.'" AND loanschristmas_transactions.transactions_type="ADICIONAL") loanschristmas_additional_amount, 
		
		(SELECT IF(ISNULL(loansquickbusiness_transactions.amount), 0, SUM(loansquickbusiness_transactions.amount)) FROM loansquickbusiness LEFT JOIN loansquickbusiness_transactions ON loansquickbusiness.loans_no = loansquickbusiness_transactions.loans_no WHERE loansquickbusiness.current_balance > 0 AND loansquickbusiness.company_id="'.$this->session->userdata('company_id').'" AND loansquickbusiness_transactions.payment_date BETWEEN "'.$dateform.'" AND "'.$dateto.'" AND loansquickbusiness_transactions.transactions_type="ADICIONAL") loansquickbusiness_additional_amount, 
		
		(SELECT IF(ISNULL(loansinversion_transactions.amount), 0, SUM(loansinversion_transactions.amount)) FROM loansinversion LEFT JOIN loansinversion_transactions ON loansinversion.loans_no = loansinversion_transactions.loans_no WHERE loansinversion.current_balance > 0 AND loansinversion.company_id="'.$this->session->userdata('company_id').'" AND loansinversion_transactions.payment_date BETWEEN "'.$dateform.'" AND "'.$dateto.'" AND loansinversion_transactions.transactions_type="ADICIONAL") loansinversion_amount 
		'); 

		return $this->db->get()->result();
	}
}


?>