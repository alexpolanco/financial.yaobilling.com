<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getpayments extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
    }

	// Show view Page
	public function index(){

		$id = $this->input->get('id');

		$query = $this->db->query('select * from loans_accounting where loans_no='.$id);
		
		echo '<h3>Cuota: '.number_format($query->result()[0]->cuota, 2).'</h3>';
		echo '<table class="table table-striped"><tbody><tr><th style="width: 10px">#</th><th>Fecha</th><th>Pagado</th><th>Saldo</th></tr>';
		
		$i = 0;
		foreach ($query->result() as $row)
		{
		echo '<tr><td>'.($i+1).'</td><td>'.date("d-m-Y", strtotime($row->due_date)).'</td><td>'.number_format($row->payment, 2).'</td><td>'.number_format($row->due_amount, 2).'</td></tr>';
		
		$i++;
		}
		
		echo '</tbody></table>';
	}
}

?>