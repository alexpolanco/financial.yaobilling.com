<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getloanscapitaltransactions extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}

	// Show view Page
	public function index(){

		$id = $this->input->get('id');
		$due = $this->input->get('due');

		$query = $this->db->query('SELECT * FROM loanscapital_transactions WHERE company_id='.$this->session->userdata('company_id').' AND amount != 0 AND (transactions_type="CAPITAL" OR transactions_type="CUOTA" OR transactions_type="PAGO IRREGULAR") AND loans_no='.$id.' ORDER BY payment_date ASC');
		
		setlocale(LC_MONETARY,"es_DO");

		echo '<table id="orderTransactionsTable" class="display table table-striped table-bordered" style="width:100%">
		<thead>
		<tr>
		<th>FECHA</th>
		<th>MONTO</th>
		<th>INTERES</th>
		<th>CAPITAL</th>
		<th>CONCEPTO</th>
		<th>ACCIÓN</th>
		</tr> 
		</thead>';
		
		$total_amount = 0;
		$total_interes_paid = 0;
		$total_capital_paid = 0;

		foreach ($query->result() as $row)
		{
			$buttons = '';
			$buttons .= 
			//'<a target="__blank" onclick="print_receipt('.intval($row->loans_no).','.intval($row->transactions_no).')" class="btn btn-info btn-sm btn-default" data-toggle="tooltip" data-placement="bottom" title="Editar recibo"><i class="fa fa-edit"></i></a>'+
			'<button type="button" class="btn btn-sm btn-info" onclick="editFunc('.intval($row->transactions_no).')" id="edit_order_'.intval($row->transactions_no).'" data-capital_topaid_'.intval($row->transactions_no).'="'.intval($row->capital_paid).'" data-interes_topaid_'.intval($row->transactions_no).'="'.intval($row->interes_paid).'"  data-toggle="modal" data-target="#editModal" data-toggle="tooltip" data-placement="bottom" title="Editar recibo"><i class="fa fa-edit"></i></button>';

			$buttons .= '<a target="__blank" onclick="print_receipt('.intval($row->loans_no).','.intval($row->transactions_no).','.date("Y-m-d", strtotime($row->payment_date)).')" class="btn btn-warning btn-sm btn-default" data-toggle="tooltip" data-placement="bottom" title="Imprimir recibo"><i class="fa fa-print"></i></a>';
			//$buttons .= '<a target="__blank" onclick="print_receipt('.intval($row->loans_no).','.intval($row->transactions_no).')" href="'.base_url().'loanscapital/pdf/loan_receipt/'.intval($row->loans_no).'/'.intval($row->transactions_no).'" class="btn btn-warning btn-default" data-toggle="tooltip" data-placement="bottom" title="Imprimir recibo"><i class="fa fa-print"></i></a>';

			$buttons .= $due == "" ? '<button type="button" class="btn btn-sm btn-danger btn-default" onclick="removeTransactionFunc('.intval($row->loans_no).', '.$row->transactions_no.', '.$row->amount.', '.$row->accounting_due_date.')" data-toggle="modal" data-target="#removeTransactionModal" data-toggle="tooltip" data-placement="bottom" title="Eliminar recibo"><i class="fa fa-trash"></i></button>' : '';

			$total_amount += $row->amount;
			$total_interes_paid += $row->interes_paid;
			$total_capital_paid += $row->capital_paid;

			echo '<tr>
			<td>'.date("d-m-Y", strtotime($row->payment_date)).'</td>
			<td>'.number_format($row->amount, 2).'</td>
			<td>'.number_format($row->interes_paid, 2).'</td>
			<td>'.number_format($row->capital_paid, 2).'</td>
			<td>'.($row->concept!="Descuento" ? $row->concept.". <small>Pagado por ".$row->payer_name."</small>" : $row->concept).'</td>
			<td>'.$buttons.'</td>
			</tr>';
		}		

		echo '<tfoot>
		<tr>
		<th>Total:</th>
		<td>'.number_format($total_amount, 2).'</td>
		<td>'.number_format($total_interes_paid, 2).'</td>
		<td>'.number_format($total_capital_paid, 2).'</td>
		<th colspan="2"></th>
		</tr>
		</tfoot>
		</table>';
	}
}
?>