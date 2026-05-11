<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Sales extends MY_Controller  { 
 
	
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
        $this->load->model('sales_model');

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
	
	
 
	
 		public function convertNum($number) {
			
			   $no = (int)$number;
			   $point = round($number - $no, 2) * 100;
			   $hundred = null;
			   $digits_1 = strlen($no);
			   $i = 0;
			   $str = array();
			   $words = array('0' => '', '1' => 'uno', '2' => 'dos',
			    '3' => 'tres', '4' => 'cuatro', '5' => 'cinco', '6' => 'seis',
			    '7' => 'siete', '8' => 'ocho', '9' => 'nueve',
			    '10' => 'diez', '11' => 'once', '12' => 'doce',
			    '13' => 'trece', '14' => 'catorce',
			    '15' => 'quince', '16' => 'dieciseis', '17' => 'diecisiete',
			    '18' => 'dieciocho', '19' =>'diecinueve', '20' => 'veinte',
			    '30' => 'treinta', '40' => 'cuarenta', '50' => 'cincuenta',
			    '60' => 'sesenta', '70' => 'setenta',
			    '80' => 'ochenta', '90' => 'noventa');
			   $digits = array('', 'cien', 'mil', 'millón', 'billón');
			   while ($i < $digits_1) {
			     $divider = ($i == 2) ? 10 : 100;
			     $number = floor($no % $divider);
			     $no = floor($no / $divider);
			     $i += ($divider == 10) ? 1 : 2;
			     if ($number) {
			        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
			        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
			        $str [] = ($number < 21) ? $words[$number] .
			            " " . $digits[$counter] . $plural . " " . $hundred
			            :
			            $words[floor($number / 10) * 10]
			            . " " . $words[$number % 10] . " "
			            . $digits[$counter] . $plural . " " . $hundred;
			     } else $str[] = null;
			  }
			  $str = array_reverse($str);
			  $result = implode('', $str);
			  $points = ($point) ?
			    "Points " . $words[$point / 10] . " " . 
			          $words[$point = $point % 10] : '';
			  return $result . " " . $points . " ";
		}
	// index method
	public function index()
	{
		$data['recored'] = $this->sales_model->findAll();
		$this->load->view('admin/sales/sales-list',$data);
	}
 	
	public function return_sales()
	{
		$this->db->where('return_p','yes');
		$this->db->group_by('purchase_no');
		$this->db->join('sales_grandtotal', 'sales_grandtotal.grand_order_no = sales.purchase_no');
		$data['recored'] = $this->db->get('sales')->result();
		$this->load->view('admin/sales/sales-return-list',$data);
	}

	// order view

	public function order_view()
	{
		$this->load->view('admin/sales/order-view');
	}

	// pdf method
	public function pdf($page,$order_no)
	{
		$this->db->where('purchase_no',$order_no);
		$data['order'] = $this->db->get('sales')->result();
		$this->load->view('admin/sales/'.$page,$data);
	}
 		
	// excel method
	public function excel()
	{
		$data['recored'] = $this->sales_model->findAll();
		$this->load->view('admin/sales/sales-excel',$data);
	}
	
	public function get_grand_value($order_no)
	{
		$res = $this->db->query("select * from sales_grandtotal where grand_order_no='".$order_no."'");
		return $totrel = $res->row_array();
	}

	public function get_tmp_sales()
	{
		$query = $this->db->query('select DISTINCT(table_id) from sales_tmp where admin_id ='.$this->session->userdata('userid'));
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

	public function get_company_data()
	{
		return $this->db->get('company')->result();
	}

	public function get_bill_number($no)
	{
		$this->db->where('purchase_no',$no);
		$data = $this->db->get('sales')->row_array();
		return  $data['purchase_billno'];
	}

	public function get_bill_date($no)
	{
		$this->db->where('purchase_no',$no);
		$data = $this->db->get('sales')->row_array();
		return  $data['purchase_dt'];
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


		$this->form_validation->set_rules('typeahead', 'Nombre del cliente', 'required');
		$this->form_validation->set_rules('selcd_for', 'Forma de pago', 'required');
		$this->form_validation->set_rules('txtbillno', 'Factura No.', 'required');
		$this->form_validation->set_rules('select_order_products','Productos','required');
		
        if ($this->form_validation->run() === FALSE)
        {
			$this->load->view('admin/sales/sales-add');
		}
		else
		{
			$this->sales_model->insert();
			
			$this->session->set_flashdata('msg','Datos insertados exitosamente');
			return redirect('sales');
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
	public function bill_print($no)
	{
		$this->db->where('purchase_no',$no);
		$data['order'] = $this->db->get('sales')->result();
		$this->load->view('admin/sales/bill-print-confrim',$data);
	}

	// update method
	public function update($id)
	{
			$product_re = array();
			$product_re = $_POST['product_serial_no'];
			$priduct_re_qty = $_POST['product_qty'];
			$re_c = 0;
			if(isset($_POST['return']))
			{
				if($_POST['return'] == 'yes')
				{
					$data=array('return_p'=>'yes');
					$this->db->where('purchase_no',$id);
					$this->db->update('sales',$data);
					
					return redirect('sales');
				}
			}
			else
			{
				$this->db->where('purchase_no',$id);
				$this->db->delete('sales');

				$this->db->where('grand_order_no',$id);
				$this->db->delete('sales_grandtotal');

				$data_ar = $this->sales_model->insert();
				//echo $data_ar;	
				return redirect('sales/bill_print/'.$data_ar);
			}

		
	}
		
	// edit method
	public function edit($id)
	{
		$data['recored'] = $this->sales_model->findOne($id);
		$this->load->view('admin/sales/sales-edit',$data);
	}
		
	// delete method
	public function delete($id)
	{

		if($this->session->userdata('userid') != 1)
	    {

			$rights = $this->check_rights();
			if(!in_array('sales/delete', $rights))
	    	{
	    		return redirect('access');
	    	}
	    	else
	    	{
	    		$this->sales_model->remove($id);
				$this->session->set_flashdata('msg','Datos eliminados exitosamente');
				
				return redirect('sales');
			}
		}
		else
		{
				$this->sales_model->remove($id);
				$this->session->set_flashdata('msg','Datos eliminados exitosamente');
				
				return redirect('sales');
		}
	}
		
	public function active_inactive($id,$mode)
	{
		$this->sales_model->change_status($id,$mode);
		return redirect('sales');
	}
 } 
 

?>