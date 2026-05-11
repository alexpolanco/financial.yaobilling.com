<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Loans extends MY_Controller  { 


public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Pdf_Library');
		$this->load->library('Excel_Library');
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
		$this->load->model('routes_model');
		$this->load->model('collector_model');
		$this->load->model('loanstype_model');
		$this->load->model('loans_model');

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
		else if ($value < 100) $num2Text = $ci->convertNum($value / 10 * 10) . " Y " . $ci->convertNum($value % 10);
		else if ($value == 100) $num2Text = "CIEN";
		else if ($value < 200) $num2Text = "CIENTO " . $ci->convertNum($value - 100);
		else if (($value == 200) || ($value == 300) || ($value == 400) || ($value == 600) || ($value == 800)) $num2Text = $ci->convertNum($value / 100) . "CIENTOS";
		else if ($value == 500) $num2Text = "QUINIENTOS";
		else if ($value == 700) $num2Text = "SETECIENTOS";
		else if ($value == 900) $num2Text = "NOVECIENTOS";
		else if ($value < 1000) $num2Text = $ci->convertNum($value / 100 * 100) . " " . $ci->convertNum($value % 100);
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
		$data['recored'] = $this->loans_model->findAll();
		$this->load->view('admin/loans/loans-list',$data);
	}
	
	public function due()
	{
		$data['loansdue'] = 'fuera de fecha';
		$data['recored'] = $this->loans_model->findAllDue();
		$this->load->view('admin/loans/loans-list',$data);
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

		$this->db->select("printed, con.due_date, loans.loans_no, con.payment_no, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, FORMAT(loans.loans_amount,2) loans_amount, FORMAT(loans.cuota,2) cuota, lt.loanstype_name, loans.entry_date, loans.start_date, loans.end_date, FORMAT(loans.due_amount,2) due_amount, FORMAT(con.interes,2) interes, FORMAT(con.capital,2) capital, FORMAT(con.payment,2) payment, a.routes_name,a.collector_id, IF(cob.collector_nickname='', cob.collector_first_name, CONCAT_WS(' ', cob.collector_first_name, '(', cob.collector_nickname, ')')) collector_first_name, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, (SELECT FORMAT(IFNULL(SUM(ct.cuota - ct.advance_amount), 0),2) FROM loans_accounting ct WHERE ct.due_date < CURDATE() AND ct.printed='NO' AND loans_no=loans.loans_no) atraso, FORMAT(con.balance,2) balance, cli2.customer_address garante_address, cli2.customer_phone garante_phone, FORMAT(con.advance_amount,2) advance_amount");
		
		$this->db->join('customer cli', 'loans.customer_id=cli.customer_id', 'left');
		$this->db->join('customer cli2', 'loans.customer_id=cli2.customer_id', 'left');
		$this->db->join('routes a', 'loans.routes_id=a.routes_id', 'left');
		$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
		$this->db->join('loanstype lt', 'loans.loanstype_id=lt.loanstype_id', 'left');
		$this->db->join('loans_accounting con', 'con.loans_no = loans.loans_no');

		$this->db->where('loans.company_id', $this->session->userdata('company_id'));

		if(isset($receipt_due) && $receipt_due != "0"){
			$this->db->where('due_date <', date('Y-m-d'));
			$this->db->group_by('loans_no');
		}
		else {
			$this->db->where('con.due_date >=', $date1);
			$this->db->where('con.due_date <=', $date2);
		}
		
		if(isset($customer_field) && $customer_field != ""){
			$this->db->where('loans.customer_id', $customer_field);
		}
		if(isset($routes_field) && $routes_field != ""){
			$this->db->where('loans.routes_id', $routes_field);
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
		
		$data['recored'] = $this->db->get('loans')->result();
		$this->load->view('admin/loans/loans-receipt',$data);
	}
	
	public function receipt_due()
	{
		$data['loansdue'] = 'fuera de fecha';
		
		$this->db->select("printed, con.due_date, loans.loans_no, (lt.loanstype_duration + 1) payment_no, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, FORMAT(loans.loans_amount,2) loans_amount, FORMAT(loans.cuota,2) cuota, lt.loanstype_name, loans.entry_date, loans.start_date, loans.end_date, FORMAT(loans.due_amount,2) due_amount, FORMAT(con.interes,2) interes, FORMAT(con.capital,2) capital, FORMAT(con.payment,2) payment, a.routes_name,a.collector_id, IF(cob.collector_nickname='', cob.collector_first_name, CONCAT_WS(' ', cob.collector_first_name, '(', cob.collector_nickname, ')')) collector_first_name, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, (SELECT FORMAT(IFNULL(SUM(ct.cuota - ct.advance_amount), 0),2) FROM loans_accounting ct WHERE ct.due_date < CURDATE() AND ct.printed='NO' AND loans_no=loans.loans_no) atraso, FORMAT(con.balance,2) balance, cli2.customer_address garante_address, cli2.customer_phone garante_phone, FORMAT(con.advance_amount,2) advance_amount, '500.00' fee_payment");  
		
		$this->db->join('customer cli', 'loans.customer_id=cli.customer_id', 'left');
		$this->db->join('customer cli2', 'loans.customer_id=cli2.customer_id', 'left');
		$this->db->join('routes a', 'loans.routes_id=a.routes_id', 'left');
		$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
		$this->db->join('loanstype lt', 'loans.loanstype_id=lt.loanstype_id', 'left');
		$this->db->join('loans_accounting con', 'con.loans_no = loans.loans_no');
		
		$this->db->where('loans.company_id', $this->session->userdata('company_id'));

		$this->db->where('return_p', 'no');
		$this->db->where('due_date <', date('Y-m-d'));
		$this->db->where('due_date <', date('Y-m-d'));
		$this->db->where('printed', 'no');

		$this->db->group_by('loans_no');
		
		$data['recored'] = $this->db->get('loans')->result();
		$this->load->view('admin/loans/loans-receipt',$data);
	}

	public function return_loans()
	{
		$this->db->where('return_p','yes');
		$data['recored'] = $this->db->get('loans')->result();
		$this->load->view('admin/loans/loans-return-list',$data);
	}

	// order view
	public function loan_view()
	{
		$this->load->view('admin/loans/loan-view');
	}

	// pdf method
	public function pdf($segment_1,$segment_2,$segment_3="",$segment_4="")
	{
		if($segment_1 == "loan_1")
		{
			$this->db->select("printed, con.due_date, loans.loans_no, con.payment_no, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, FORMAT(loans.loans_amount,2) loans_amount, FORMAT(loans.cuota,2) cuota, lt.loanstype_name, loans.entry_date, loans.start_date, loans.end_date, FORMAT(loans.due_amount,2) due_amount, FORMAT(con.interes,2) interes, FORMAT(con.capital,2) capital, FORMAT(con.payment,2) payment, a.routes_name,a.collector_id, IF(cob.collector_nickname='', cob.collector_first_name, CONCAT_WS(' ', cob.collector_first_name, '(', cob.collector_nickname, ')')) collector_first_name, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, (SELECT FORMAT(IFNULL(SUM(ct.cuota - ct.advance_amount), 0),2) FROM loans_accounting ct WHERE ct.due_date < CURDATE() AND ct.printed='NO' AND loans_no=loans.loans_no) atraso, FORMAT(con.balance,2) balance, cli2.customer_address garante_address, cli2.customer_phone garante_phone, FORMAT(con.advance_amount,2) advance_amount");
			
			$this->db->join('customer cli', 'loans.customer_id=cli.customer_id', 'left');
			$this->db->join('customer cli2', 'loans.customer_id=cli2.customer_id', 'left');
			$this->db->join('routes a', 'loans.routes_id=a.routes_id', 'left');
			$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
			$this->db->join('loanstype lt', 'loans.loanstype_id=lt.loanstype_id', 'left');
			$this->db->join('loans_accounting con', 'con.loans_no = loans.loans_no');
			
			$this->db->where('loans.company_id', $this->session->userdata('company_id'));
			$this->db->where('loans.loans_no =', $segment_2);
		}
		else
		{
			$receipt_due = $_POST['receipt_due'];

			$this->db->select("printed, con.due_date, loans.loans_no, con.payment_no, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, FORMAT(loans.loans_amount,2) loans_amount, FORMAT(loans.cuota,2) cuota, lt.loanstype_name, loans.entry_date, loans.start_date, loans.end_date, FORMAT(loans.due_amount,2) due_amount, FORMAT(con.interes,2) interes, FORMAT(con.capital,2) capital, FORMAT(con.payment,2) payment, a.routes_name,a.collector_id, IF(cob.collector_nickname='', cob.collector_first_name, CONCAT_WS(' ', cob.collector_first_name, '(', cob.collector_nickname, ')')) collector_first_name, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, (SELECT IFNULL(SUM(ct.cuota - ct.advance_amount), 0) FROM loans_accounting ct WHERE ct.due_date < CURDATE() AND ct.printed='NO' AND loans_no=loans.loans_no) atraso, FORMAT(con.balance,2) balance, cli2.customer_address garante_address, cli2.customer_phone garante_phone, FORMAT(con.advance_amount,2) advance_amount");
			
			$this->db->join('customer cli', 'loans.customer_id=cli.customer_id', 'left');
			$this->db->join('customer cli2', 'loans.customer_id=cli2.customer_id', 'left');
			$this->db->join('routes a', 'loans.routes_id=a.routes_id', 'left');
			$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
			$this->db->join('loanstype lt', 'loans.loanstype_id=lt.loanstype_id', 'left');
			$this->db->join('loans_accounting con', 'con.loans_no = loans.loans_no');
			
			$this->db->where('loans.company_id', $this->session->userdata('company_id'));

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

		}
		
		$this->db->order_by('collector_first_name', 'ASC');
		$this->db->order_by('customer_first_name', 'ASC');
		
		$data['order'] = $this->db->get('loans')->result();
		$data['date1'] = $segment_2;
		$data['date2'] = $segment_3;
		$this->load->view('admin/loans/'.$segment_1,$data);
	}

	// excel method
	public function excel()
	{
		$data['recored'] = $this->loans_model->findAll();
		$this->load->view('admin/loans/loans-excel',$data);
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
		return $this->db->get('collector')->result();
	}

	public function get_company_data()
	{
		return $this->db->get('company')->result();
	}

	public function get_loan_number($no)
	{
		$this->db->where('loans.company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no',$no);
		$data = $this->db->get('loans')->row_array();
		return  $data['loans_no'];
	}

	public function get_loan_date($no)
	{
		$this->db->where('loans.company_id', $this->session->userdata('company_id'));
		$this->db->where('loans_no',$no);
		$data = $this->db->get('loans')->row_array();
		return  $data['create_date'];
	}
	//Get All customer 
	public function get_all_customer()
	{
		$this->db->order_by('customer_first_name', 'ASC');
		return $data['_customer'] = $this->db->get('customer')->result();
	}
	//Get All collector 
	public function get_all_collector()
	{
		$this->db->order_by('collector_first_name', 'ASC');
		return $data['_collector'] = $this->db->get('collector')->result();
	}
	//Get All routes 
	public function get_all_routes()
	{
		$this->db->join('collector', 'collector.collector_id = routes.collector_id', 'left');
		$this->db->order_by('routes_name', 'DESC');
		return $data['_routes'] = $this->db->get('routes')->result();
	}
	//Get All loanstype 
	public function get_all_loanstype()
	{
		return $data['_loanstype'] = $this->db->get('loanstype')->result();
	}
	//Get All category 
	public function get_all_cat()
	{
		$this->db->where('parent_id !=','0');
		return $data['_cate'] = $this->db->get('category')->result();
	}


	// Create method
	public function create()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('txt_loans_amount', 'Monto prestado', 'required');
		$this->form_validation->set_rules('txt_routes_id', 'Ruta', 'required');
		$this->form_validation->set_rules('txt_loanstype_id', 'Tipo de préstamo', 'required');
		$this->form_validation->set_rules('txt_customer_id', 'Nombre del cliente', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('admin/loans/loans-add');
		}
		else
		{
			$this->loans_model->insert();
			
			$this->session->set_flashdata('msg','Datos insertados exitosamente');
			return redirect('loans');
		}
	}
	
	public function get_product_option_bill($id)
	{
		$query = $this->db->query("SELECT po.product_option_stock,po.option_parent_id,po.option_id,o.option_name,po.product_option_id FROM product_option po 
								INNER JOIN options o ON po.option_id=o.option_id
								WHERE product_option_id =".$id);
		return $query->row_array();
	}

	//public pos function
	public function loan_print($no = null)
	{
		$this->db->join('customer', 'loans.customer_id=customer.customer_id', 'left');
		$this->db->join('routes', 'loans.routes_id=routes.routes_id', 'left');
		$this->db->join('collector', 'routes.collector_id=collector.collector_id', 'left');
		$this->db->join('loanstype', 'loans.loanstype_id=loanstype.loanstype_id', 'left');
		$this->db->join('loans_accounting la', 'loans.loans_no=la.loans_no', 'left');

		$this->db->where('loans.company_id', $this->session->userdata('company_id'));
		//$this->db->where('loans.loans_no',$no);

		$data['loans'] = $this->db->get('loans')->result();
		
		//$this->load->view('admin/loans/loan-pos-confirm',$data);
		//$this->load->view('admin/loans/loan-print-confirm',$data);
		$this->load->view('admin/loans/loan-report-confirm',$data);
	}

	// update method
	public function update($id)
	{
		if(isset($_POST['return']))
		{
			if($_POST['return'] == 'yes')
			{
				$data=array('return_p'=>'yes');
				$this->db->where('company_id', $this->session->userdata('company_id'));
				$this->db->where('loans_no',$id);
				$this->db->update('loans',$data);
				
				return redirect('loans');
			}
		}
		else
		{
			$this->db->where('company_id', $this->session->userdata('company_id'));
			$this->db->where('loans_no',$id);
			$this->db->delete('loans');

			//$this->db->where('grand_order_no',$id);
			//$this->db->delete('loans_grandtotal');

			$data_ar = $this->loans_model->insert();
			//echo $data_ar;	
			return redirect('loans/loan_print/'.$data_ar);
		}
	}
		
	// edit method
	public function edit($id)
	{		
		$data['recored'] = $this->loans_model->findOne($id);
		$this->load->view('admin/loans/loans-edit',$data);
	}
		
	// delete method
	public function delete($id)
	{

		if($this->session->userdata('userid') != 1)
		{

			$rights = $this->check_rights();
			if(!in_array('loans/delete', $rights))
			{
				return redirect('access');
			}
			else
			{
				$this->loans_model->remove($id);
				$this->session->set_flashdata('msg','Datos eliminados exitosamente');
				
				return redirect('loans');
			}
		}
		else
		{
			$this->loans_model->remove($id);
			$this->session->set_flashdata('msg','Datos eliminados exitosamente');
			
			return redirect('loans');
		}
	}

	public function today()
	{
		$data['date1'] = date('Y-m-d');
		$data['date2'] = date('Y-m-d');
		
		$customer_field = $_POST['txt_customer_id'];
		$routes_field = $_POST['txt_routes_id'];
		$paymentno_field = $_POST['txt_paymentno'];
		$receipt_paid = $_POST['receipt_paid'];
		
		$this->db->select("printed, con.due_date, loans.loans_no, con.payment_no, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, FORMAT(loans.loans_amount,2) loans_amount, FORMAT(loans.cuota,2) cuota, lt.loanstype_name, loans.entry_date, loans.start_date, loans.end_date, FORMAT(loans.due_amount,2) due_amount, FORMAT(con.interes,2) interes, FORMAT(con.capital,2) capital, FORMAT(con.payment,2) payment, a.routes_name,a.collector_id, IF(cob.collector_nickname='', cob.collector_first_name, CONCAT_WS(' ', cob.collector_first_name, '(', cob.collector_nickname, ')')) collector_first_name, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, (SELECT FORMAT(IFNULL(SUM(ct.cuota - ct.advance_amount), 0),2) FROM loans_accounting ct WHERE ct.due_date < CURDATE() AND ct.printed='NO' AND loans_no=loans.loans_no) atraso, FORMAT(con.balance,2) balance, cli2.customer_address garante_address, cli2.customer_phone garante_phone, FORMAT(con.advance_amount,2) advance_amount"); 
		$this->db->join('customer cli', 'loans.customer_id=cli.customer_id', 'left');
		$this->db->join('customer cli2', 'loans.customer_id=cli2.customer_id', 'left');
		$this->db->join('routes a', 'loans.routes_id=a.routes_id', 'left');
		$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
		$this->db->join('loanstype lt', 'loans.loanstype_id=lt.loanstype_id', 'left');
		$this->db->join('loans_accounting con', 'con.loans_no = loans.loans_no');
		
		$this->db->where('loans.company_id', $this->session->userdata('company_id'));
		$this->db->where('due_date',date('Y-m-d'));

		if($customer_field != ""){
			$this->db->where('loans.customer_id', $customer_field);
		}
		if(isset($routes_field) && $routes_field != ""){
			$this->db->where('loans.routes_id', $routes_field);
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
		
		$data['recored'] = $this->db->get('loans')->result();
		$this->load->view('admin/loans/loans-receipt',$data);	
	}

	public function weekly()
	{
		//$date1=date('Y-m-d',strtotime(date("Y-m-d")."-6 day"));
		//$date2=date('Y-m-d');
		$date2=date('Y-m-d',strtotime(date("Y-m-d")." last monday"));
		$date1=date('Y-m-d',strtotime(date($date2)." -6 day"));

		$data['date1'] = $date1;
		$data['date2'] = $date2;

		$this->db->select("printed, con.due_date, loans.loans_no, con.payment_no, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, FORMAT(loans.loans_amount,2) loans_amount, FORMAT(loans.cuota,2) cuota, lt.loanstype_name, loans.entry_date, loans.start_date, loans.end_date, FORMAT(loans.due_amount,2) due_amount, FORMAT(con.interes,2) interes, FORMAT(con.capital,2) capital, FORMAT(con.payment,2) payment, a.routes_name,a.collector_id, IF(cob.collector_nickname='', cob.collector_first_name, CONCAT_WS(' ', cob.collector_first_name, '(', cob.collector_nickname, ')')) collector_first_name, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, (SELECT FORMAT(IFNULL(SUM(ct.cuota - ct.advance_amount), 0),2) FROM loans_accounting ct WHERE ct.due_date < CURDATE() AND ct.printed='NO' AND loans_no=loans.loans_no) atraso, FORMAT(con.balance,2) balance, cli2.customer_address garante_address, cli2.customer_phone garante_phone, FORMAT(con.advance_amount,2) advance_amount"); 
		$this->db->where('due_date >=', $date1);
		$this->db->where('due_date <=', $date2);
		$this->db->join('customer cli', 'loans.customer_id=cli.customer_id', 'left');
		$this->db->join('customer cli2', 'loans.customer_id=cli2.customer_id', 'left');
		$this->db->join('routes a', 'loans.routes_id=a.routes_id', 'left');
		$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
		$this->db->join('loanstype lt', 'loans.loanstype_id=lt.loanstype_id', 'left');
		$this->db->join('loans_accounting con', 'con.loans_no = loans.loans_no');
		
		$this->db->where('loans.company_id', $this->session->userdata('company_id'));

		$data['recored'] = $this->db->get('loans')->result();
		$this->load->view('admin/loans/loans-receipt',$data);	
	}

	public function monthly()
	{
		$start_date=date('Y-m-01'); // Month Starting Date
		$end_date=date('Y-m-t');  // Month Ending Date
		
		$data['date1'] = $start_date;
		$data['date2'] = $end_date;

		$this->db->select("printed, con.due_date, loans.loans_no, con.payment_no, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, FORMAT(loans.loans_amount,2) loans_amount, FORMAT(loans.cuota,2) cuota, lt.loanstype_name, loans.entry_date, loans.start_date, loans.end_date, FORMAT(loans.due_amount,2) due_amount, FORMAT(con.interes,2) interes, FORMAT(con.capital,2) capital, FORMAT(con.payment,2) payment, a.routes_name,a.collector_id, IF(cob.collector_nickname='', cob.collector_first_name, CONCAT_WS(' ', cob.collector_first_name, '(', cob.collector_nickname, ')')) collector_first_name, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, (SELECT FORMAT(IFNULL(SUM(ct.cuota - ct.advance_amount), 0),2) FROM loans_accounting ct WHERE ct.due_date < CURDATE() AND ct.printed='NO' AND loans_no=loans.loans_no) atraso, FORMAT(con.balance,2) balance, cli2.customer_address garante_address, cli2.customer_phone garante_phone, FORMAT(con.advance_amount,2) advance_amount");  
		$this->db->where('due_date >=', $start_date);
		$this->db->where('due_date <=', $end_date);
		$this->db->join('customer cli', 'loans.customer_id=cli.customer_id', 'left');
		$this->db->join('customer cli2', 'loans.customer_id=cli2.customer_id', 'left');
		$this->db->join('routes a', 'loans.routes_id=a.routes_id', 'left');
		$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
		$this->db->join('loanstype lt', 'loans.loanstype_id=lt.loanstype_id', 'left');
		$this->db->join('loans_accounting con', 'con.loans_no = loans.loans_no');

		$this->db->where('loans.company_id', $this->session->userdata('company_id'));

		$data['recored'] = $this->db->get('loans')->result();
		$this->load->view('admin/loans/loans-receipt',$data);	
	}

	public function yearly()
	{
		$start_date=date('Y-01-d'); // year Starting Date
		$end_date=date('Y-12-d');  // year Ending Date
		
		$data['date1'] = $start_date;
		$data['date2'] = $end_date;

		$this->db->select("printed, con.due_date, loans.loans_no, con.payment_no, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, FORMAT(loans.loans_amount,2) loans_amount, FORMAT(loans.cuota,2) cuota, lt.loanstype_name, loans.entry_date, loans.start_date, loans.end_date, FORMAT(loans.due_amount,2) due_amount, FORMAT(con.interes,2) interes, FORMAT(con.capital,2) capital, FORMAT(con.payment,2) payment, a.routes_name,a.collector_id, IF(cob.collector_nickname='', cob.collector_first_name, CONCAT_WS(' ', cob.collector_first_name, '(', cob.collector_nickname, ')')) collector_first_name, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, (SELECT FORMAT(IFNULL(SUM(ct.cuota - ct.advance_amount), 0),2) FROM loans_accounting ct WHERE ct.due_date < CURDATE() AND ct.printed='NO' AND loans_no=loans.loans_no) atraso, FORMAT(con.balance,2) balance, cli2.customer_address garante_address, cli2.customer_phone garante_phone, FORMAT(con.advance_amount,2) advance_amount");  
		$this->db->where('due_date >=', $start_date);
		$this->db->where('due_date <=', $end_date);
		$this->db->join('customer cli', 'loans.customer_id=cli.customer_id', 'left');
		$this->db->join('customer cli2', 'loans.customer_id=cli2.customer_id', 'left');
		$this->db->join('routes a', 'loans.routes_id=a.routes_id', 'left');
		$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
		$this->db->join('loanstype lt', 'loans.loanstype_id=lt.loanstype_id', 'left');
		$this->db->join('loans_accounting con', 'con.loans_no = loans.loans_no');

		$this->db->where('loans.company_id', $this->session->userdata('company_id'));

		$data['recored'] = $this->db->get('loans')->result();
		$this->load->view('admin/loans/loans-receipt',$data);	
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

		$this->db->select("printed, con.due_date, loans.loans_no, con.payment_no, If(cli.customer_nickname ='', cli.customer_first_name, CONCAT_WS(' ', cli.customer_first_name, '(', cli.customer_nickname, ')')) AS customer_first_name,  cli.customer_id, cli.customer_personalid, cli.customer_address, cli.customer_phone, cli.customer_workplace, cli.customer_occupation, FORMAT(loans.loans_amount,2) loans_amount, FORMAT(loans.cuota,2) cuota, lt.loanstype_name, loans.entry_date, loans.start_date, loans.end_date, FORMAT(loans.due_amount,2) due_amount, FORMAT(con.interes,2) interes, FORMAT(con.capital,2) capital, FORMAT(con.payment,2) payment, a.routes_name,a.collector_id, IF(cob.collector_nickname='', cob.collector_first_name, CONCAT_WS(' ', cob.collector_first_name, '(', cob.collector_nickname, ')')) collector_first_name, IF(cli2.customer_nickname='', cli2.customer_first_name, CONCAT_WS(' ', cli2.customer_first_name, '(', cli2.customer_nickname, ')')) AS garante, (SELECT FORMAT(IFNULL(SUM(ct.cuota - ct.advance_amount), 0),2) FROM loans_accounting ct WHERE ct.due_date < CURDATE() AND ct.printed='NO' AND loans_no=loans.loans_no) atraso, FORMAT(con.balance,2) balance, cli2.customer_address garante_address, cli2.customer_phone garante_phone, FORMAT(con.advance_amount,2) advance_amount");
		
		$this->db->join('customer cli', 'loans.customer_id=cli.customer_id', 'left');
		$this->db->join('customer cli2', 'loans.customer_id=cli2.customer_id', 'left');
		$this->db->join('routes a', 'loans.routes_id=a.routes_id', 'left');
		$this->db->join('collector cob', 'a.collector_id=cob.collector_id', 'left');
		$this->db->join('loanstype lt', 'loans.loanstype_id=lt.loanstype_id', 'left');
		$this->db->join('loans_accounting con', 'con.loans_no = loans.loans_no');

		$this->db->where('loans.company_id', $this->session->userdata('company_id'));
		$this->db->where('con.due_date >=', $date1);
		$this->db->where('con.due_date <=', $date2);
		
		if(isset($customer_field) && $customer_field != ""){
			$this->db->where('loans.customer_id', $customer_field);
		}
		if(isset($routes_field) && $routes_field != ""){
			$this->db->where('loans.routes_id', $routes_field);
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
		
		$data['recored'] = $this->db->get('loans')->result();
		$this->load->view('admin/loans/loans-receipt',$data);
	}
		
	public function active_inactive($id,$mode)
	{
		$this->loans_model->change_status($id,$mode);
		return redirect('loans');
	}
} 

?>