<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getloandata extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
		$this->load->model('opposition_model');
	}

	// Show view Page
	public function index(){

		$id = $this->input->get('id');
		$name = $this->input->get('name');
		$customer_id = $this->input->get('customer_id');
		
		$data_opposition = $this->opposition_model->findOppositionPlaceByLoan($id, $customer_id);
		$opposition_place = empty($data_opposition) ? "" : $data_opposition[0]->opposition_place;
		
		$loantype = "";
		$opposition = array();
		
		if($name == "loanscapital"){
			$loantype = "de interes capital";
			$this->load->model('loanscapital_model');
			$data['order'] = $this->loanscapital_model->findOne($id);
		}
		elseif($name == "loanschristmas"){
			$loantype = "de regalía";
			$this->load->model('loanschristmas_model');
			$data['order'] = $this->loanschristmas_model->findOne($id);
		}
		elseif($name == "loansfixed"){
			$loantype = "de interes fijo";
			$this->load->model('loansfixed_model');
			$data['order'] = $this->loansfixed_model->findOne($id);
		} 
		elseif($name == "loansinversion"){
			$loantype = "de inversión";
			$this->load->model('loansinversion_model');
			$data['order'] = $this->loansinversion_model->findOne($id);
		} 
		elseif($name == "loansquickbusiness"){
			$loantype = "rápido";
			$this->load->model('loansquickbusiness_model');
			$data['order'] = $this->loansquickbusiness_model->findOne($id);
		}

		if ($data['order'] == null) {
			?>
			<section class="content">
			<div class="error-page">
			<h2 class="headline text-red"> <i class="fa fa-warning text-red"></i> </h2>
			<div class="error-content">
			<h3>El cliente no tiene <b>préstamo <?php echo $loantype; ?></b> activo.</h3>
			<p>Si considera que esto es un error, favor contactar a soporte técnico.</p>
			</div></div></section>
			<?php
		} else {
			foreach ($data['order'] as $row)
			{
				?>
				
				<div class="col-md-6 info-for-bill">
					<div class='box' >
						<div class='box-body pad'>
							<div class="input-group input-group-lg">   
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-primary" id="btn_oppositionplace" onclick="getoppositionplace()"><i class="fa fa-search own-de-i"></i> Lugar de la oposición</button>
                              </div>
                                  <input type="text" name="txt_oppositionplace" id="txt_oppositionplace" class="form-control " value="<?php echo $opposition_place; ?>" onkeypress="return tabE(this,event,'txt_loans_amount')" placeholder="Lugar de la oposición..."  readonly />
                                </div>
                                <br />
                                <div class="row"  id="opposition_place" style="display:none;">
                                  <div class="col-md-12">
                                    <table id="gridbox_opposition_place" class="display cell-border row-border hover" style="width:100%">
                                      <thead>
                                        <tr><th>Seleccionar lugar de la oposición</th></tr>
                                      </thead>
                                      <tbody>
                                        <tr><td><h2 id="opposition_place_1" class="lead" onclick="setoppositionplace(1, 'Nagua')">Nagua</h2></td></tr>
                                        <tr><td><h2 id="opposition_place_2" class="lead" onclick="setoppositionplace(2, 'Coutí')">Cotuí</h2></td></tr>
                                        <tr><td><h2 id="opposition_place_3" class="lead" onclick="setoppositionplace(3, 'Luperón')">Luperón</h2></td></tr>
                                      </tbody>
                                      <tfoot></tfoot>
                                </table>
                              </div>
                          </div>
						    
							<div class="input-group input-group-lg">    
								<div class="input-group-btn">
									<button type="button" class="btn btn-default dropdown-toggle">Monto prestado</button>
								</div>
								<input type="number" name="txt_loans_amount" id="txt_loans_amount" class="form-control " value="<?php echo $row->loans_amount; ?>" min="0" placeholder="Monto prestado..." readonly />
								<input type="hidden" name="txt_cuota" id="txt_cuota" value="<?php echo $row->cuota; ?>" />
								<input type="hidden" name="txt_capital" id="txt_capital" value="<?php echo $row->capital; ?>" />
								<input type="hidden" name="txt_loans_total" id="txt_loans_total" value="<?php echo $row->due_amount; ?>" />
								<input type="hidden" name="txt_loanstype_interes" id="txt_loanstype_interes" value="<?php echo $row->interes; ?>" />
								<input type="hidden" name="txt_opposition_place" id="txt_opposition_place" value="<?php echo $opposition_place; ?>" />
								<input type="hidden" name="txt_interes_amount" id="txt_interes_amount" value="<?php echo $row->interes_amount; ?>" />
								<input type="hidden" name="txt_loanstype_id" id="txt_loanstype_id" value="<?php echo $row->loanstype_id; ?>" />
								<input type="hidden" name="txt_loansno" id="txt_loansno" value="<?php echo $row->loans_no; ?>" />

							</div>
							<br />
							<div class="input-group input-group-lg">    
								<div class="input-group-btn">
									<button type="button" class="btn btn-default dropdown-toggle">Adicionales</button>
								</div>
								<input type="number" name="txt_additionals_amount" id="txt_additionals_amount" class="form-control " value="<?php echo $row->additional_amount; ?>" min="0" placeholder="Adicionales prestado..." readonly  />
							</div>
							<br />
							<div class="input-group input-group-lg">    
								<div class="input-group-btn">
									<button type="button" class="btn btn-default dropdown-toggle">Total prestado</button>
								</div>
								<input type="number" name="txt_total_amount" id="txt_total_amount" class="form-control " value="<?php echo floatval($row->loans_amount) + floatval($row->additional_amount); ?>" min="0" placeholder="Total prestado..." readonly  />
							</div>
							<br />
							<div class="input-group input-group-lg">
								<div class="input-group-btn">
									<button type="button" class="btn btn-default dropdown-toggle">Tasa de intéres</button>
								</div>
								<input type="number" name="txt_loanstype_interes" id="txt_loanstype_interes" class="form-control " data-inputmask='"mask": "99%"' data-mask="" step='0.01' value="<?php echo $row->interes; ?>" min="1" placeholder="Tasa de intéres..." readonly />
								<span class="input-group-btn">
										<a class="btn btn-default btn-sm own-de"><i class="fa fa-percent" aria-hidden="true"></i>%</a>
									</span> 
							</div>
							<br /> 
							<div class="input-group input-group-lg">    
								<div class="input-group-btn">
								<button type="button" class="btn btn-default" id="btn_loanstype">Frecuencia del préstamo</button>
							</div>
							<input type="text" name="txt_loanstype_frequency" id="txt_loanstype_frequency" class="form-control " value="<?php echo $row->loanstype_frequency; ?>" min="0" placeholder="Frecuencia del préstamo..." readonly />
							</div>
							<br />   
								<?php
									$_frequency = "";
									if ($row->loanstype_frequency == "Semanal") {
										$_frequency = "semanas";
									} else if ($row->loanstype_frequency == "Diario") {
										$_frequency = "días";
									} else if ($row->loanstype_frequency == "Mensual") {
										$_frequency = "meses";
									} else if ($row->loanstype_frequency == "Quincenal") {
										$_frequency = "quincenas";
									} else {
										$_frequency = "años";
									}
								?>
								<div class="input-group input-group-lg">
									<div class="input-group-btn">
									<button type="button" class="btn btn-default dropdown-toggle">Cantidad de <span id="loantime"><?php echo $_frequency; ?></span></button>
									</div>
									<input type="number" name="txt_loanstype_duration" id="txt_loanstype_duration" class="form-control " value="<?php echo $row->duration; ?>" min="1" placeholder="Cantidad de cuotas..." readonly/>
								</div>
								<br />

								
								<div class="input-group input-group-lg">    
											<div class="input-group-btn">
												<button type="button" class="btn btn-default">Garante #1</button>
											</div>
											<input type="text" name="txt_guarantor1" id="txt_guarantor1" class="form-control " value="<?php echo $row->guarantor1_first_name; ?>" placeholder="Garante #1..."  autocomplete="off" readonly />
											</div>
								
								</div></div></div>
								<div class="col-md-6 info-for-bill">
									<div class='box' >
										<div class='box-body pad'>
											<div class="input-group input-group-lg">    
													<div class="input-group-btn">
													<label class="btn btn-default">Número del contrato</label>
												</div>
												<input type="number" name="txt_contract_number" id="txt_contract_number" class="form-control " value="<?php echo $row->contract_number; ?>" min="0" placeholder="Número de acto autentico..." readonly />
											</div>
											<br />
											<div class="input-group input-group-lg">    
													<div class="input-group-btn">
													<label class="btn btn-default">Número del folio 1</label>
												</div>
												<input type="number" name="txt_contract_folio1" id="txt_contract_folio1" class="form-control " value="<?php echo $row->contract_folio1; ?>" min="0" placeholder="Número de folio 1..." readonly />
											</div>
											<br />
											<div class="input-group input-group-lg">    
													<div class="input-group-btn">
													<label class="btn btn-default">Número del folio 2</label>
												</div>
												<input type="number" name="txt_contract_folio2" id="txt_contract_folio2" class="form-control " value="<?php echo $row->contract_folio2; ?>" min="0" placeholder="Número de folio 2..." readonly />
											</div>
											<br />
										<div class="input-group input-group-lg">    
											<div class="input-group-btn">
											<label class="btn btn-default">Fecha del contrato</label>
												</div>
												<input type="date" name="txt_entry_date" id="txt_entry_date" class="form-control " value="<?php echo $row->entry_date; ?>" min="0" placeholder="Fecha del contrato..." readonly />
											</div>
											<br />
											<div class="input-group input-group-lg">    
													<div class="input-group-btn">
													<label class="btn btn-default">Hora del contrato</label>
												</div>
												<input type="time" name="txt_entry_time" id="txt_entry_time" class="form-control " value="<?php echo $row->entry_time; ?>" min="0" placeholder="Hora del contrato..." readonly />
											</div>
											<br />
											<div class="input-group input-group-lg">    
												<div class="input-group-btn">
												<label class="btn btn-default">Fecha de inicio</label>
											</div>
											<input type="date" name="txt_start_date" id="txt_start_date" class="form-control " value="<?php echo $row->start_date; ?>" min="0" placeholder="Fecha de inicio..." readonly />
											</div>
											<br />
											<div class="input-group input-group-lg">    
												<div class="input-group-btn">
												<label class="btn btn-default">Fecha de vencimiento</label>
											</div>
											<input type="date" name="txt_end_date" id="txt_end_date" class="form-control " value="<?php echo $row->end_date; ?>" min="0" placeholder="Fecha de vencimiento..." readonly  />
											</div>
											<br />
														<div class="input-group input-group-lg">    
														<div class="input-group-btn">
															<button type="button" class="btn btn-default">Garante #2</button>
														</div>
														<input type="text" name="txt_guarantor2" id="txt_guarantor2" class="form-control " value="<?php echo $row->guarantor2_first_name; ?>" placeholder="Garante #2..."  autocomplete="off" readonly />
														</div>
												</div>
									</div></div></div>
				<?php
			}
		}
	}
}

?>