<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getloansquickbusinessadditional extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}

	// Show view Page
	public function index(){

		$id = $this->input->get('id');

		$query = $this->db->query('SELECT * FROM loansquickbusiness_transactions WHERE company_id='.$this->session->userdata('company_id').' AND transactions_type="ADICIONAL" AND loans_no='.$id);
	
		setlocale(LC_MONETARY,"es_DO");

		echo '<table id="additionalTable" class="display table table-striped table-bordered" style="width:100%">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>FECHA</th>';
		echo '<th>MONTO</th>';
		echo '<th>ACCIÓN</th>';
		echo '</tr>';
		echo '</thead>';

		$total_amount = 0;

		foreach ($query->result() as $row)
		{
			$buttons = '';
			//$buttons .= '<a target="_blank" onclick="print_receipt('.intval($row->loans_no).','.intval($row->transactions_no).')" href="'.base_url().'loansquickbusiness/pdf/loan_receipt/'.intval($row->loans_no).'/'.intval($row->transactions_no).'" class="btn btn-warning btn-default" data-toggle="tooltip" data-placement="bottom" title="Imprimir recibo"><i class="fa fa-print"></i></a>';
			$buttons .= '<a target="_blank" onclick="print_receipt('.intval($row->loans_no).','.intval($row->transactions_no).')" class="btn btn-warning btn-default" data-toggle="tooltip" data-placement="bottom" title="Imprimir recibo"><i class="fa fa-print"></i></a>';
			$buttons .= '<button type="button" class="btn btn-danger btn-default" onclick="removeAdditionalFunc('.intval($row->loans_no).', '.$row->transactions_no.', '.$row->amount.')" data-toggle="modal" data-target="#removeAdditionalModal" data-toggle="tooltip" data-placement="bottom" title="Eliminar adicional"><i class="fa fa-trash"></i></button>';

			$total_amount += $row->amount;

			echo '<tr>
			<td>'.date("d-m-Y", strtotime($row->payment_date)).'</td>
			<td>'.number_format($row->amount, 2).'</td>
			<td>'.$buttons.'</td>
			</tr>';
		}	

		echo '<tfoot>
		<tr>
		<th>Total:</th>
		<td>'.number_format($total_amount, 2).'</td>
		<th></th>
		</tr>
		</tfoot>
		</table>';
	}
}

?>