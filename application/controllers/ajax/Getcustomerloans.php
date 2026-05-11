<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getcustomerloans extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	$this->load->database();
	}

	// Show view Page
	public function index(){

		$id = $this->input->get('id');
		
		$query = $this->db->query('SELECT 
		IFNULL((SELECT GROUP_CONCAT(IF(loanscapital.current_balance > 0, loanscapital.loans_no, 0)) FROM loanscapital WHERE loanscapital.customer_id = '.$id.' AND loanscapital.current_balance > 0), 0) loanscapital_no, 

		IFNULL((SELECT GROUP_CONCAT(IF(loanschristmas.current_balance > 0, loanschristmas.loans_no, 0)) FROM loanschristmas WHERE loanschristmas.customer_id = '.$id.' AND loanschristmas.current_balance > 0), 0) loanschristmas_no, 

		IFNULL((SELECT GROUP_CONCAT(IF(loansfixed.current_balance > 0, loansfixed.loans_no, 0)) FROM loansfixed WHERE loansfixed.customer_id = '.$id.' AND loansfixed.current_balance > 0), 0) loansfixed_no, 

		IFNULL((SELECT GROUP_CONCAT(IF(loansinversion.current_balance > 0, loansinversion.loans_no, 0)) FROM loansinversion WHERE loansinversion.customer_id = '.$id.' AND loansinversion.current_balance > 0), 0) loansinversion_no, 

		IFNULL((SELECT GROUP_CONCAT(IF(loansquickbusiness.current_balance > 0, loansquickbusiness.loans_no, 0)) FROM loansquickbusiness WHERE loansquickbusiness.customer_id = '.$id.' AND loansquickbusiness.current_balance > 0), 0) loansquickbusiness_no 
		');

		foreach ($query->result() as $row)
		{
			?>
			<table id="gridbox_loanss" class="display cell-border row-border hover" style="width:100%">
				<thead>
				<tr><th>Seleccionar préstamo</th></tr>
				</thead>
				<tbody>
				<?php 
				$loansfixed_no = explode(",", $row->loansfixed_no); 
				foreach ($loansfixed_no as $value) {
					?>
					<tr><td><?php echo '<h2 id="loansfixed_'.$value.'" class="lead" onclick="setloans('.$value.', \'loansfixed\')">Interes fijo '.$value.'</h2>' ?></td></tr>
					<?php
				}
				?>	

				<?php 
				$loanscapital_no = explode(",", $row->loanscapital_no); 
				foreach ($loanscapital_no as $value) {
					?>
					<tr><td><?php echo '<h2 id="loanscapital_'.$value.'" class="lead" onclick="setloans('.$value.', \'loanscapital\')">Interes capital '.$value.'</h2>' ?></td></tr>
					<?php
				}
				?>	

				<?php 
				$loansinversion_no = explode(",", $row->loansinversion_no); 
				foreach ($loansinversion_no as $value) {
					?>
					<tr><td><?php echo '<h2 id="loansinversion_'.$value.'" class="lead" onclick="setloans('.$value.', \'loansinversion\')">Inversión '.$value.'</h2>' ?></td></tr>
					<?php
				}
				?>	

				<?php 
				$loansquickbusiness_no = explode(",", $row->loansquickbusiness_no); 
				foreach ($loansquickbusiness_no as $value) {
					?>
					<tr><td><?php echo '<h2 id="loansquickbusiness_'.$value.'" class="lead" onclick="setloans('.$value.', \'loansquickbusiness\')">Negocio rápido '.$value.'</h2>' ?></td></tr>
					<?php
				}
				?>				

				<?php 
				$loanschristmas_no = explode(",", $row->loanschristmas_no); 
				foreach ($loanschristmas_no as $value) {
					?>
					<tr><td><?php echo '<h2 id="loanschristmas_'.$value.'" class="lead" onclick="setloans('.$value.', \'loanschristmas\')">Regalía '.$value.'</h2>' ?></td></tr>
					<?php
				}
				?>	

				</tbody>
				<tfoot></tfoot>
			</table>
			<?php
		}
	}
}

?>