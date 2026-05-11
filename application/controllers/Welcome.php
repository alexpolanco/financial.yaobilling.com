<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->database(); 

		if (!$this->session->userdata('logged_in'))
		{ 
			redirect('login');
		}

		$this->user_id = $this->session->userdata('userid');
		$this->company_id = $this->session->userdata('company_id');

		$this->load->helper('form');
		$this->load->model('login_model');
	}

	public function index()
	{
		$this->load->view('admin/index');
	}

	public function total_user()
	{
		$query = $this->db->query("SELECT count(*) as total FROM users WHERE company_id = '". $this->session->userdata('company_id')."'");
		$data = $query->row_array();

		return isset($data['total']) ? 0 : $data['total'];
	}

	public function total_customer()
	{
		$query = $this->db->query("SELECT count(*) as total FROM customer WHERE company_id = '". $this->session->userdata('company_id')."'");
		$data = $query->row_array();

		return $data['total'];	
	}
	
	public function total_collector()
	{
		$query = $this->db->query("SELECT count(*) as total FROM collector WHERE company_id = '". $this->session->userdata('company_id')."'");
		$data = $query->row_array();

		return $data['total'];	
	}

	public function total_loans()
	{
		$query = $this->db->query("SELECT count(*) as total FROM loans WHERE company_id = '". $this->session->userdata('company_id')."'");
		$data = $query->row_array();

		return $data['total'];	
	}

	public function total_loansfixed()
	{
		$query = $this->db->query("SELECT count(*) as total FROM loansfixed WHERE company_id = '". $this->session->userdata('company_id')."'");
		$data = $query->row_array();

		return $data['total'];	
	}

	public function total_loanscapital()
	{
		$query = $this->db->query("SELECT count(*) as total FROM loanscapital WHERE company_id = '". $this->session->userdata('company_id')."'");
		$data = $query->row_array();

		return $data['total'];	
	}

	public function total_loansinversion()
	{
		$query = $this->db->query("SELECT count(*) as total FROM loansinversion WHERE company_id = '". $this->session->userdata('company_id')."'");
		$data = $query->row_array();

		return $data['total'];	
	}

	public function total_loanschristmas()
	{
		$query = $this->db->query("SELECT count(*) as total FROM loanschristmas WHERE company_id = '". $this->session->userdata('company_id')."'");
		$data = $query->row_array();

		return $data['total'];	
	}

	public function total_loansquickbusiness()
	{
		$query = $this->db->query("SELECT count(*) as total FROM loansquickbusiness WHERE company_id = '". $this->session->userdata('company_id')."'");
		$data = $query->row_array();

		return $data['total'];	
	}

	public function total_loansdue()
	{
		$query = $this->db->query("SELECT count(*) as total FROM loans WHERE company_id = '". $this->session->userdata('company_id')."' AND end_date < CURDATE() and return_p='no'");
		$data = $query->row_array();

		return $data['total'];	
	}

	public function total_party()
	{
			
	}

	public function total_product()
	{
		$query = $this->db->query("SELECT count(*) as total FROM product WHERE company_id = '". $this->session->userdata('company_id')."'");
		$data = $query->row_array();

		return $data['total'];	
	}	

	public function sales()
	{
		$year = date('Y');
		$query = $this->db->query("SELECT entry_date, purchase_item_qty, purchase_serial_no, purchase_item_name  FROM sales WHERE company_id = '". $this->session->userdata('company_id')."' AND return_p !='yes' AND entry_date LIKE '".$year."%' ");
		return $query->row_array(); 
	}

	public function order() 
	{
		$query = $this->db->query("SELECT  s.purchase_no ,s.purchase_item_name,s.purchase_billno,sg.grand_total FROM sales s INNER JOIN sales_grandtotal sg ON s.purchase_no=sg.grand_order_no WHERE s.company_id = '". $this->session->userdata('company_id')."' GROUP BY s.purchase_no ORDER BY  s.purchase_id DESC LIMIT 5 ");
		$data = $query->result();

		return $data;	
	}
	
	public function loans() 
	{
		$query = $this->db->query("SELECT  s.loans_no ,sg.customer_first_name,s.loans_amount FROM loans s INNER JOIN customer sg ON s.customer_id=sg.customer_id WHERE s.company_id = '". $this->session->userdata('company_id')."' AND sg.company_id = '". $this->session->userdata('company_id')."' GROUP BY s.loans_no ORDER BY  s.loans_no DESC LIMIT 5 ");
		$data = $query->result();

		return $data;	
	}
	
	public function loansfixed() 
	{
		$query = $this->db->query("SELECT  s.loans_no ,sg.customer_first_name,s.loans_amount, s.current_balance FROM loansfixed s INNER JOIN customer sg ON s.customer_id=sg.customer_id WHERE s.company_id = '". $this->session->userdata('company_id')."' AND sg.company_id = '". $this->session->userdata('company_id')."' GROUP BY s.loans_no ORDER BY  s.loans_no DESC LIMIT 5 ");
		$data = $query->result();

		return $data;	
	}
	
	public function loanscapital() 
	{
		$query = $this->db->query("SELECT  s.loans_no ,sg.customer_first_name,s.loans_amount, s.current_balance FROM loanscapital s INNER JOIN customer sg ON s.customer_id=sg.customer_id WHERE s.company_id = '". $this->session->userdata('company_id')."' AND sg.company_id = '". $this->session->userdata('company_id')."' GROUP BY s.loans_no ORDER BY  s.loans_no DESC LIMIT 5 ");
		$data = $query->result();

		return $data;	
	}
	
	public function loansinversion() 
	{
		$query = $this->db->query("SELECT  s.loans_no ,sg.customer_first_name,s.loans_amount, s.current_balance FROM loansinversion s INNER JOIN customer sg ON s.customer_id=sg.customer_id WHERE s.company_id = '". $this->session->userdata('company_id')."' AND sg.company_id = '". $this->session->userdata('company_id')."' GROUP BY s.loans_no ORDER BY  s.loans_no DESC LIMIT 5 ");
		$data = $query->result();

		return $data;	
	}
	
	public function loanschristmas() 
	{
		$query = $this->db->query("SELECT  s.loans_no ,sg.customer_first_name,s.loans_amount, s.current_balance FROM loanschristmas s INNER JOIN customer sg ON s.customer_id=sg.customer_id WHERE s.company_id = '". $this->session->userdata('company_id')."' AND sg.company_id = '". $this->session->userdata('company_id')."' GROUP BY s.loans_no ORDER BY  s.loans_no DESC LIMIT 5 ");
		$data = $query->result();

		return $data;	
	}
	
	public function loansquickbusiness() 
	{
		$query = $this->db->query("SELECT  s.loans_no ,sg.customer_first_name,s.loans_amount, s.current_balance FROM loansquickbusiness s INNER JOIN customer sg ON s.customer_id=sg.customer_id WHERE s.company_id = '". $this->session->userdata('company_id')."' AND sg.company_id = '". $this->session->userdata('company_id')."' GROUP BY s.loans_no ORDER BY  s.loans_no DESC LIMIT 5 ");
		$data = $query->result();

		return $data;	
	}

	public function get_product()
	{
		$query = $this->db->query("SELECT product_name,product_image_1,product_actual_price,product_serial_no,product_discount FROM product WHERE company_id = '". $this->session->userdata('company_id')."'  ORDER BY product_id DESC LIMIT 4");
		$data = $query->result();

		return $data;	
	}

	public function get_customer()
	{
		$query = $this->db->query("SELECT customer_first_name,customer_phone,customer_personalid,customer_image_1,customer_id FROM customer WHERE company_id = '". $this->session->userdata('company_id')."' ORDER BY customer_id DESC LIMIT 5");
		$data = $query->result();

		return $data;	
	}

	public function get_sales_chart()
	{
		$query = $this->db->query("SELECT DISTINCT (purchase_item_name)  FROM sales WHERE company_id = '". $this->session->userdata('company_id')."' AND return_p != 'yes' AND active='yes'");
		$data = $query->result();

		return $data;
	}

	public function get_loans_chart()
	{
		$query = $this->db->query("SELECT loans.customer_id, customer_first_name, loans_amount  FROM loans left join customer on loans.customer_id=customer.customer_id WHERE loans.company_id = '". $this->session->userdata('company_id')."' AND customer.company_id = '". $this->session->userdata('company_id')."' LIMIT 10");
		$data = $query->result();

		return $data;
	}

	public function get_sales_qty($p)
	{
		$query = $this->db->query("SELECT sum(purchase_item_qty) as total FROM sales WHERE company_id = '". $this->session->userdata('company_id')."' AND return_p != 'yes' AND purchase_item_name = ''.$p.'' AND active='yes' ");
		$data = $query->row_array();

		return $data;
	}

	public function sale_month_r($v)
	{
		$query = $this->db->query("SELECT count(*) as total FROM sales WHERE company_id = '". $this->session->userdata('company_id')."' AND return_p != 'yes' AND MONTH(entry_date) =".$v);
		$data = $query->row_array();

		return $data['total'] == '' ? 0 : $data['total'];
	}

	public function loans_month_r($v)
	{
		$query = $this->db->query("SELECT count(*) as total FROM loans WHERE company_id = '". $this->session->userdata('company_id')."' AND return_p != 'yes' AND MONTH(entry_date) =".$v);
		$data = $query->row_array();

		return $data['total'] == '' ? 0 : $data['total'];
	}

	public function total_bill()
	{
			$query = $this->db->query("SELECT count(distinct purchase_no) as total FROM sales WHERE company_id = '". $this->session->userdata('company_id')."'");
			$data = $query->row_array();
			return $data['total'];	
	}

	public function total_loans_no()
	{
			$query = $this->db->query("SELECT count(distinct loans_no) as total FROM loans WHERE company_id = '". $this->session->userdata('company_id')."'");
			$data = $query->row_array();
			return $data['total'];	
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
}
