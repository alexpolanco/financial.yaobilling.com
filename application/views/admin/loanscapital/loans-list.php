<?php
// Add FIle
// include common file
$this->load->view('admin/include/common.php'); 
// include header file
$this->load->view('admin/include/header.php'); 
// include sidebar file  
$this->load->view('admin/include/sidebar.php');

$loans_origen = $this->uri->segment(2);

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Préstamos interes y capital <?php echo empty($loansdue) ? 'activos' : $loansdue ; ?> (<?php echo count($recored); ?>)</h1>
      <div class="breadcrumb">
        <?php if($loans_origen == 'due') : ?>
        <a id="loans" href="<?php echo base_url().'loanscapital'; ?>" class="btn btn-lg btn-success">Préstamos activos</a>
        <?php else : ?>
        <a id="loans_due" href="<?php echo base_url().'loanscapital/due'; ?>" class="btn btn-lg btn-danger">Préstamos saldados</a>
				<?php endif; ?>
        <!-- <a id="receipts" href="<?php echo base_url().'loanscapital/receipt'; ?>" class="btn btn-lg btn-success">Recibos</a> -->
        <a id="new_loan" href="<?php echo base_url().'loanscapital/create'; ?>" class="btn btn-lg btn-primary">Nuevo Préstamo</a> 
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-body">
              <?php if($this->session->flashdata('msg') != false){ ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>  <i class="icon fa fa-check"></i> ¡Bien!</h4>
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
                <?php } ?>
              <?php 
                $attributes = array('id' => 'frm','name'=>'frm');
                echo form_open('loanscapital/delete',$attributes) ?>
                <table id="example" class="display table cell-border row-border hover" style="width:100%">
                  <thead>
                    <tr class="bg-blue">
                      <th>Cliente</th>
                      <th>Fecha </th>
                      <th>Préstamo</th>
                      <th>Adicional</th>
                      <th>Total prestado</th>
                      <th>Duración</th>
                      <th>Cuota</th>
                      <th>Interes</th>
                      <th>Capital</th>
                      <th>Pagado</th>                      
                      <th>Pago Interes</th>
                      <th>Pago Capital</th>
                      <th>Atraso</th>
                      <th>Balance</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $arids = array();
                    foreach ( $recored as $_recored ) {
                      $arids[] = $_recored->loans_id;
                      $loanstypeid = $_recored->loanstype_id;
                      
                      $_frequency = "";
                      if ($loanstypeid == "1") {
                        $_frequency = "semanas";
                      } else if ($loanstypeid == "2") {
                        $_frequency = "díos";
                      } else if ($loanstypeid == "3") {
                        $_frequency = "meses";
                      } else if ($loanstypeid == "4") {
                        $_frequency = "quincenas";
                      } else {
                        $_frequency = "años";
                      }
                      
                      $loanstotal = floatval($_recored->loans_amount) + floatval($_recored->aditional_amount);
                      $loanstotal_capital = floatval($loanstotal) - floatval($_recored->total_capital_paid);
                  ?>
                
                  <tr data-child-value="<?php echo $_recored->loans_no; ?>" data-child-name="<?php echo  $_recored->customer_first_name; ?>" data-child-loans_amount="<?php echo $_recored->loans_amount; ?>"  data-child-current_balance="<?php echo $loanstotal_capital; ?>" data-child-interes_amount="<?php echo $_recored->interes_amount; ?>" data-child-capital="<?php echo $_recored->capital; ?>" data-child-interes="<?php echo $_recored->interes; ?>" data-child-unpaid_payments="<?php echo $_recored->unpaid_payments; ?>" data-child-total_unpay="<?php echo $_recored->total_unpay; ?>" data-child-due_date="<?php echo date("d-m-Y", strtotime($_recored->due_date)); ?>" >
                      <td><?php echo $_recored->customer_first_name; ?><input type="hidden" name="due_date_<?php echo $_recored->loans_no; ?>" id="due_date_<?php echo $_recored->loans_no; ?>" value="<?php echo date("Y-m-d", strtotime($_recored->due_date)); ?>" /></td>
                      <td><?php echo date("d-m-Y", strtotime($_recored->entry_date)); ?></td>
                      <td><?php echo number_format((empty($loansdue) ? $_recored->loans_amount : $_recored->due_amount), 2); ?></td>
                      <td><?php echo number_format($_recored->additional_amount, 2); ?></td>
                      <td><?php echo number_format($loanstotal, 2); ?></td>
                      <td><?php echo $_recored->duration . ' ' .$_frequency; ?></td>
                      <td><?php echo number_format($_recored->interes_amount, 2); ?></td>
                      <td><?php echo number_format($_recored->interes, 2); ?></td>
                      <td><?php echo number_format($_recored->capital, 2); ?></td>
                      <td><?php echo number_format($_recored->amount_paid, 2); ?></td>
                      <td><?php echo number_format($_recored->interes_paid, 2); ?></td>
                      <td><?php echo number_format($_recored->total_capital_paid, 2); ?></td>
                      <td><?php echo number_format(floatval($_recored->unpaid_payments) + floatval($_recored->total_unpay), 2); ?></td>
                      <td><?php echo number_format(floatval($loanstotal) + floatval($_recored->unpaid_payments) + floatval($_recored->total_unpay) - floatval($_recored->total_capital_paid), 2); ?></td>
                      <td></td>
                    </tr>
                  <?php 
                    }
                  ?>
                    </tbody>
                </table>
                <input type="hidden" name="hdnmode" id="hdnmode" value="" />
                <input type="hidden" name="hdnids" id="hdnids" value="<?php echo implode(',',$arids); ?>" />
              <?php echo form_close() ?>
              </div>
            </div>
          </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    
    <!--  Model Start -->
            
    <div id="addcust" class="popupContainer" style="display:none;">
        <header class="popupHeader">
          <span class="header_title">Agregar Cliente</span>
          <span id="close" class="modal_close"><i class="fa fa-times"></i></span>
        </header>
        
        <section class="popupBody">
          <!-- Social Login -->
          <div class="social_login">
            <div class="">
                
                  Cliente :
                  <input type="text" name="txtfname" id="txtfname" class="form-control validate[required]" value=""  placeholder="Nombre del cliente..." required />
                  Correo electrónico :
                  <input type="email" name="txtemail" id="txtemail" class="form-control validate[required,custom[email]]" value=""  placeholder="Correo electrónico..." required />
                  Dirección :
                  <input type="text" name="txtadd" id="txtadd" class="form-control validate[required]" value=""  placeholder="Dirección..." required />
                  <br />
                  ¿Está Activo?
                  <input type="radio" class="radio-button" name="rdois_active" id="rdois_active" value="yes" />Si
                  <input type="radio" class="radio-button" name="rdois_active" id="rdois_active" value="no" />No
                  <input type="button" name="btnsubmit" onclick="addcust();"  style="float:right;" class="btn btn-primary" value="Guardar" />
                
            </div>
          </div>
        </section>
      </div>
      
      <div id="addbill" class="popupContainer" style="display:none;">
        <header class="popupHeader">
          <span class="header_title">Registrar un atraso</span>
          <span id="close" class="modal_close"><i class="fa fa-times"></i></span>
        </header>
        
        <section class="popupBody">
          <!-- Social Login -->
          <div class="social_login">
              <div class="btn-group">
                  <button type="button" id="payment_no" class="btn btn-default btn-flat">N.° Pago <?php echo empty($paymentno_field) ? "" : ": ".$paymentno_field; ?></button>
                  <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><input type="button" value="1" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(1)" /></li>
                    <li><input type="button" value="2" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(2)" /></li>
                    <li><input type="button" value="3" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(3)" /></li>
                    <li><input type="button" value="4" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(4)" /></li>
                    <li><input type="button" value="5" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(5)" /></li>
                    <li><input type="button" value="6" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(6)" /></li>
                    <li><input type="button" value="7" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(7)" /></li>
                    <li><input type="button" value="8" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(8)" /></li>
                    <li><input type="button" value="9" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(9)" /></li>
                    <li><input type="button" value="10" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(10)" /></li>
                    <li><input type="button" value="11" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(11)" /></li>
                    <li><input type="button" value="12" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(12)" /></li>
                    <li><input type="button" value="13" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(13)" /></li>
                    <li><input type="button" value="14" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(14)" /></li>
                    <li><input type="button" value="15" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(15)" /></li>
                    <li><input type="button" value="16" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(16)" /></li>
                    <li><input type="button" value="17" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(17)" /></li>
                    <li><input type="button" value="18" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(18)" /></li>
                    <li><input type="button" value="19" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(19)" /></li>
                    <li><input type="button" value="20" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(20)" /></li>
                    <li><input type="button" value="21" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(21)" /></li>
                    <li><input type="button" value="22" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(22)" /></li>
                    <li><input type="button" value="23" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(23)" /></li>
                    <li><input type="button" value="24" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(24)" /></li>
                    <li><input type="button" value="25" class="btn btn-block btn-lg btn-flat"  onclick="setpaymentno(25)" /></li>
                  </ul>
                  <input type="hidden" name="txt_paymentno" id="txt_paymentno" value="" />
                  <input type="button" name="btnpayments" id="btnpayments" onclick="getpayments();" style="margin-left:5px;" class="btn btn-info" value="Cargar pagos" />
                  <input type="button" name="btnsubmit" onclick="addbillnumber();" style="margin-left:5px;" class="btn btn-primary" value="Registrar" />
                </div>
                <div id="gridbox_amortization"></div>
        </div>
      </section>
    </div>
            
    <!--  Model End -->

  </div>
  <!-- /.content-wrapper -->
  
<!-- pay form modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="payModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="box-header with-border bg-aqua-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
          <h4 class="modal-title" id="order_info"></h4>
        <div id="payMessages"></div>
      </div>

      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
        <?php if($loans_origen != 'due') : ?>
          <li class="active"><a href="#tab_1-1" data-toggle="tab" aria-expanded="true"><i class="fa fa-dollar"></i> Realizar un abono</a></li>
        <?php endif; ?>
          <li class=""><a href="#tab_2-2" data-toggle="tab" aria-expanded="false"><i class="fa fa-clock-o"></i> Historial de pagos</a></li>
        </ul>
        <div class="tab-content">
        <?php if($loans_origen != 'due') : ?>
          <div class="tab-pane active" id="tab_1-1">
          <?php 
                $attributes = array('id' => 'payForm','name'=>'payForm','class'=>'form-horizontal');
                echo form_open('loanscapital/pay',$attributes) ?>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="payer_date" class="col-sm-3 control-label">FECHA DE PAGO</label>
                    <div class="col-sm-8">
                      <input type="date" class="form-control" id="payer_date" name="payer_date" onkeypress="return tabE(this,event,'payer_name')" value="<?php echo date('Y-m-d') ?>" placeholder="Selecionar fecha">
                    </div>
                    </div>
                  <div class="form-group">
                    <label for="payer_name" class="col-sm-3 control-label">PAGADO POR</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="payer_name" name="payer_name" onkeypress="return tabE(this,event,'capitalpaid_amount')" placeholder="Nombre de la persona que realiza el pago" autocomplete="off" aria-describedby="payer_name-addon">
                    </div>
                  </div>

                  <div class="form-group">
                  <label for="unpaid_amount" class="col-sm-3 control-label">CAPITAL ACTUAL</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="unpaid_amount" name="unpaid_amount" disabled>
                    </div>
                    <label for="capitalpaid_amount" class="col-sm-1 control-label">ABONO</label>
                    <div class="col-sm-3">
                      <input type="number" class="form-control" id="capitalpaid_amount" name="capitalpaid_amount" onkeypress="return tabE(this,event,'paid_amount')" value="0"  min="0" >
                    </div>
                    <div class="col-sm-1">
                      <button type="button" class="btn btn-sm btn-danger" id="capitalpaid_amount_reset" name="capitalpaid_amount_reset" onclick="return resetValue('capitalpaid_amount')"><i class="fa fa-trash"></i></button>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="unpaid_interes" class="col-sm-3 control-label">INTERES</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="unpaid_interes" name="unpaid_interes" disabled>
                    </div>
                    <label for="paid_amount" class="col-sm-1 control-label">ABONO</label>
                    <div class="col-sm-3">
                      <input type="number" class="form-control" id="paid_amount" name="paid_amount" onkeypress="return tabE(this,event,'psubmit')" value="0" min="0">
                    </div>
                    <div class="col-sm-1">
                      <button type="button" class="btn btn-sm btn-danger" id="paid_amount_reset" name="paid_amount_reset" onclick="return resetValue('paid_amount')"><i class="fa fa-trash"></i></button>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="unpaid_payments" class="col-sm-3 control-label">PAGOS IRREGULARES</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="unpaid_payments" name="unpaid_payments" disabled >
                    </div>
                    <label for="paid_payments_amount" class="col-sm-1 control-label">ABONO</label>
                    <div class="col-sm-3">
                      <input type="number" class="form-control" id="paid_payments_amount" name="paid_payments_amount" onkeypress="return tabE(this,event,'psubmit')" value="0" min="0">
                    </div>
                    <div class="col-sm-1">
                      <button type="button" class="btn btn-sm btn-danger" id="paid_payments_amount_reset" name="paid_payments_amount_reset" onclick="return resetValue('paid_payments_amount')"><i class="fa fa-trash"></i></button>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="hidden" name="txt_payloansno" id="txt_payloansno" value="" />
                  <input type="hidden" name="txt_due_date" id="txt_due_date" value="" />
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                  <button type="submit" name="psubmit" class="btn btn-primary">Guardar cambios</button>
                </div>
                <!-- /.box -->
            </form>
          </div>
          <!-- /.tab-pane -->
          <?php endif; ?>
          <div class="tab-pane" id="tab_2-2">
            <table id="orderTransactionsTable" class="display table table-striped table-bordered" style="width:100%">
              <thead>
              <tr>
                <th>FECHA</th>
                <th>MONTO</th>
                <th>INTERES</th>
                <th>CAPITAL</th>
                <th>CONCEPTO</th>
                <th>ACCIÓN</th>
              </tr>
              </thead>

              <tfoot>
                <tr>
                  <th>Total:</th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- additional form modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="additionalModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="box-header with-border bg-aqua-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
          <h4 class="modal-title" id="additional_info"></h4>
        <div id="additionalMessages">Registrar un adicional</div>
      </div>

      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#additional_tab_1-1" data-toggle="tab" aria-expanded="true"><i class="fa fa-dollar"></i> Realizar un adicional</a></li>
          <li class=""><a href="#additional_tab_2-2" data-toggle="tab" aria-expanded="false"><i class="fa fa-clock-o"></i> Historial de adicional</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="additional_tab_1-1">
          <?php 
                $attributes = array('id' => 'additionalForm','name'=>'additionalForm','class'=>'form-horizontal');
                echo form_open('loanscapital/additional',$attributes) ?>
                <div class="modal-body">
                  <h4 id="order_additional_title" class="modal-title"></h4>
                  <div class="form-group">
                    <label for="additional_date" class="col-sm-3 control-label">FECHA</label>
                    <div class="col-sm-8">
                      <input type="date" class="form-control" id="additional_date" name="additional_date" value="<?php echo date('Y-m-d') ?>" onkeypress="return tabE(this,event,'additional_amount')" placeholder="Selecionar fecha">
                    </div>
                  </div>
                  
                  <div class="form-group">
                  <label for="unpaid_capital" class="col-sm-3 control-label">CAPITAL ACTUAL</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="unpaid_capital" name="unpaid_capital" disabled>
                    </div>
                  </div>
                
                  <div class="form-group">
                    <label for="additional_amount" class="col-sm-3 control-label">MONTO ADICIONAL</label>
                    <div class="col-sm-8">
                      <input type="number" class="form-control" id="additional_amount" name="additional_amount" onkeypress="return tabE(this,event,'new_cuota_amount')" autocomplete="off" aria-describedby="additional_amount-addon">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="old_cuota_amount" class="col-sm-3 control-label">VALOR ACTUAL DE LA CUOTA</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="old_cuota_amount" name="old_cuota_amount" disabled>
                    </div>                      
                    <label for="new_cuota_amount" class="col-sm-3 control-label">NUEVO VALOR CUOTA</label>
                    <div class="col-sm-3">
                      <input type="number" class="form-control" id="new_cuota_amount" name="new_cuota_amount" onkeypress="return tabE(this,event,'new_interes_amount')" autocomplete="off" aria-describedby="new_cuota_amount-addon">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="old_interes_amount" class="col-sm-3 control-label">VALOR ACTUAL DEL INTERES</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="old_interes_amount" name="old_interes_amount" disabled>
                    </div>
                    <label for="new_interes_amount" class="col-sm-3 control-label">NUEVO VALOR DEL INTERES</label>
                    <div class="col-sm-3">
                      <input type="number" class="form-control" id="new_interes_amount" name="new_interes_amount" onkeypress="return tabE(this,event,'new_capital_amount')" autocomplete="off" aria-describedby="new_interes_amount-addon">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="old_capital_amount" class="col-sm-3 control-label">VALOR ACTUAL DEL CAPITAL</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="old_capital_amount" name="old_capital_amount" disabled>
                    </div>
                    <label for="new_capital_amount" class="col-sm-3 control-label">NUEVO VALOR DEL CAPITAL</label>
                    <div class="col-sm-3">
                      <input type="number" class="form-control" id="new_capital_amount" name="new_capital_amount" onkeypress="return tabE(this,event,'asubmit')" autocomplete="off" aria-describedby="new_capital_amount-addon">
                    </div>
                  </div>
                  
                </div>
                <div class="modal-footer">
                  <input type="hidden" name="txt_loansno" id="txt_loansno" value="" />
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                  <button type="submit" name="asubmit" class="btn btn-primary">Guardar cambios</button>
                </div>
                <!-- /.box -->
            </form>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="additional_tab_2-2">
            <table id="additionalTable" class="display table table-striped table-bordered" style="width:100%">
              <thead>
              <tr>
                <th>FECHA</th>
                <th>MONTO</th>
                <th>ACCIÓN</th>
              </tr>
              </thead>

              <tfoot>
                <tr>
                  <th colspan="2">Total:</th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- edit form modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="box-header with-border bg-blue-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
          <h4 class="modal-title" id="edit_info">Editar transacción</h4>
        <div id="editMessages"></div>
      </div>
      <?php 
          $attributes = array('id' => 'editForm','name'=>'editForm','class'=>'form-horizontal');
          echo form_open('loanscapital/update/',$attributes) ?>
          <div class="modal-body">
            <div class="form-group">
            <label for="edit_old_capital_amount" class="col-sm-3 control-label">CAPITAL</label>
              <div class="col-sm-3">
                <input type="text" class="form-control" id="edit_old_capital_amount" name="edit_old_capital_amount" disabled>
              </div>
              <label for="edit_new_capital_amount" class="col-sm-2 control-label">Nuevo valor</label>
              <div class="col-sm-3">
                <input type="number" class="form-control" id="edit_new_capital_amount" name="edit_new_capital_amount" onkeypress="return tabE(this,event,'edit_new_interes_amount')" value="0"  min="0" >
              </div>
            </div>
            <div class="form-group">
              <label for="edit_old_interes_amount" class="col-sm-3 control-label">INTERES</label>
              <div class="col-sm-3">
                <input type="text" class="form-control" id="edit_old_interes_amount" name="edit_old_interes_amount" disabled>
              </div>
              <label for="edit_new_interes_amount" class="col-sm-2 control-label">Nuevo valor</label>
              <div class="col-sm-3">
                <input type="number" class="form-control" id="edit_new_interes_amount" name="edit_new_interes_amount" onkeypress="return tabE(this,event,'edit_psubmit')" value="0" min="0">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="edit_transaction" id="edit_transaction" value="" />
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <button type="submit" name="edit_psubmit" class="btn btn-primary">Guardar cambios</button>
          </div>
          <!-- /.box -->
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- complete loan modal -->
<div class="modal modal-success fade in" tabindex="-1" role="dialog" id="completeLoanModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-teal-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
        <h4 class="modal-title">Saldar Préstamo</h4>
      </div>
      <?php 
      $attributes = array('id' => 'completeLoanForm','name'=>'completeLoanForm','class'=>'form-horizontal');
      echo form_open('loanscapital/edit/completeLoan',$attributes) ?>
        <div class="modal-body">
          <p>¿Seguro que quiere saldar este préstamo?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-outline">Saldar</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- remove transaction modal -->
<div class="modal modal-danger fade in" tabindex="-1" role="dialog" id="removeTransactionModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-aqua-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
        <h4 class="modal-title">Eliminar Recibo</h4>
      </div>

      <?php 
      $attributes = array('id' => 'removeTransactionForm','name'=>'removeTransactionForm','class'=>'form-horizontal');
      echo form_open('loanscapital/delete/removeTransaction',$attributes) ?>
        <div class="modal-body">
          <p>¿Seguro que quiere eliminar este recibo?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Eliminar</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- remove additional modal -->
<div class="modal modal-danger fade in" tabindex="-1" role="dialog" id="removeAdditionalModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-aqua-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
        <h4 class="modal-title">Eliminar Adicional</h4>
      </div>
      <?php 
      $attributes = array('id' => 'removeAdditionalForm','name'=>'removeAdditionalForm','class'=>'form-horizontal');
      echo form_open('loanscapital/delete/removeAdditional',$attributes) ?>
        <div class="modal-body">
          <p>¿Seguro que quiere eliminar este adicional?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Eliminar</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

 <?php // include footer FIle

$this->load->view('admin/include/footer.php'); ?>
  
<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";
  var orderTransactionsTable, additionalTable, order_interes = 0, _abono_capital = "";

/* Formatting function for row details - modify as you need */
function format(value, name, loans_amount, current_balance, interes_amount, capital, interes, unpaid_payments, total_unpay, due_date) {
  base_url = '<?php echo base_url() ?>loanscapital/';

  return (
      '<table cellpadding="0" cellspacing="0" border="0" style="width:90%">' +
      '<tr><td colspan=6>Cliente: <b>' + name + '</b></td></tr>' +
      '<tr><td colspan=6>Pagos irregulares: <b>' + addCommas(unpaid_payments) + '</b> :: Intereses no pagados: <b>' + addCommas(total_unpay) + '</b> :: Total atraso: <b>' + addCommas(parseFloat(unpaid_payments) + parseFloat(total_unpay)) + '</b></td></tr>' +
      '<tr>' +
      <?php if($loans_origen == 'due') : ?>
        '<td><button type="button" class="btn btn-sm btn-primary" onclick="print_letter(' + value + ')" ><i  class="fa fa-file" aria-hidden="true"></i> Carta</button></td>' +
        //'<td><button type="button" class="btn btn-sm btn-primary" onclick="print_loan(' + value + ')" ><i  class="fa fa-download" aria-hidden="true"></i> Estado</button></td>' +
        '<td><button type="button" class="btn btn-sm btn-info" onclick="print_contract(' + value + ')" ><i  class="fa fa-file" aria-hidden="true"></i> Contrato</button></td>' +
        '<td><button type="button" class="btn btn-sm btn-success" onclick="payFunc(' + value + ')" id="pay_order_' + value + '" data-id="' + value + '" data-order_pay_title_' + value + '="Pago pendiente de <b>' + interes_amount + '</b> de fecha <b>' + due_date + '</b>" data-order_due_date_' + value + '=' + due_date + '" data-order_payer_info_' + value + '="Cliente: <b>' + name + ' (' + addCommas(loans_amount) + ')</b>" data-order_date_' + value + '=""  data-order_payer_' + value + '="' + name + '" data-due_amount_' + value + '="' + current_balance + '" data-order_net_amount_' + value + '="' + current_balance + '" data-order_interes_' + value + '="' + interes_amount + '" data-toggle="modal" data-target="#payModal" data-toggle="tooltip" data-placement="bottom" title="Abonar al préstamo"><i class="fa fa-money"></i> Abono</button></td>' + 
        '<td><a class="action-edit btn btn-warning btn-sm" href="' + base_url + 'renew/' + value + '" title="Renovar" rel="leanModal"><i class="fa fa-edit"></i> Renovar</a></td>' +
        '<td><a class="action-edit btn btn-danger btn-sm" href="' + base_url + 'delete/' + value + '" title="Eliminar" rel="leanModal"><i class="fa fa-close"></i> Eliminar</a></td>' +
      <?php else : ?>
        //'<td><button type="button" class="btn btn-sm btn-primary" onclick="print_loan(' + value + ')" ><i  class="fa fa-download" aria-hidden="true"></i> Estado</button></td>' +
        '<td><button type="button" class="btn btn-sm btn-info" onclick="print_contract(' + value + ')" ><i  class="fa fa-file" aria-hidden="true"></i> Contrato</button></td>' +
        '<td><button type="button" class="btn btn-sm btn-success" onclick="additionalFunc(' + value + ')" id="additional_order_' + value + '" data-id="' + value + '" data-order_additional_info_' + value + '="Cliente: <b>' + name + ' (' + addCommas(loans_amount) + ')</b>" data-order_date_' + value + '=""  data-order_additional_' + value + '="' + name + '" data-due_amount_' + value + '="' + current_balance + '" data-order_interes_' + value + '="' + interes_amount + '" data-interes_' + value + '="' + interes + '" data-capital_' + value + '="' + capital + '" data-order_unpaid_payments_' + value + '="' + unpaid_payments + '" data-toggle="modal" data-target="#additionalModal" data-toggle="tooltip" data-placement="bottom" title="Agregar un adicional al prestamo"><i class="fa fa-money"></i> Adicional</button></td>' + 
        '<td><button type="button" class="btn btn-sm btn-success" onclick="payFunc(' + value + ')" id="pay_order_' + value + '" data-id="' + value + '" data-order_pay_title_' + value + '="Pago pendiente de <b>' + interes_amount + '</b> de fecha <b>' + due_date + '</b>" data-order_due_date_' + value + '=' + due_date + '" data-order_payer_info_' + value + '="Cliente: <b>' + name + ' (' + addCommas(loans_amount) + ')</b>" data-order_date_' + value + '=""  data-order_payer_' + value + '="' + name + '" data-due_amount_' + value + '="' + current_balance + '" data-order_net_amount_' + value + '="' + current_balance + '" data-order_interes_' + value + '="' + interes_amount + '" data-interes_' + value + '="' + interes + '" data-capital_' + value + '="' + capital + '" data-order_unpaid_payments_' + value + '="' + unpaid_payments + '" data-toggle="modal" data-target="#payModal" data-toggle="tooltip" data-placement="bottom" title="Abonar al préstamo"><i class="fa fa-money"></i> Abono</button></td>' + 
        '<td><button type="button" class="btn btn-sm btn-success" onclick="completeLoanFunc(' + value + ')" id="complete_loan_' + value + '" data-id="' + value + '" data-toggle="modal" data-target="#completeLoanModal" data-toggle="tooltip" data-placement="bottom" title="Saldar préstamo"><i class="fa fa-check" aria-hidden="true"></i> Saldar</button></td>' +
        '<td><a class="action-edit btn btn-warning btn-sm" href="' + base_url + 'edit/' + value + '" title="Editar" rel="leanModal"><i class="fa fa-edit"></i> Editar</a></td>' +
        '<td><a class="action-edit btn btn-danger btn-sm" href="' + base_url + 'delete/' + value + '" title="Eliminar" rel="leanModal"><i class="fa fa-close"></i> Eliminar</a></td>' +
      <?php endif; ?>
      '</tr>' +
      '</table>'
  );
}

$(document).ready(function(){
      $('#new_loan').focus();      
 
      var table = $('#example').DataTable({
      language: {
            "lengthMenu": "_MENU_ resultados por página",
            "zeroRecords": "Lo sentimos, no se encontró información que coincida con sus terminos de búsqueda",
            "info": "Página _PAGE_ de _PAGES_",
            "search": "Buscador ",
            "oPaginate"		:	{
              'sFirst'			:	'Primero',
              'sLast'				:	'Último',
              'sNext'				:	'Siguiente',
              'sPrevious'			:	'Anterior'
            },
            "infoEmpty": "",
            "infoFiltered": "(_MAX_ resultados encontrados)"
        },
        destroy: true,
        searching: true,
        columns: [
            { data: 'name' },
            { data: 'date' },
            { data: 'current_balance', 'className': 'danger' },
            { data: 'additional_amount', 'className': 'danger' },
            { data: 'current_loanamount', 'className': 'danger' },
            { data: 'duration' },
            { data: 'interes_amount', 'className': 'info' },
            { data: 'interes' },
            { data: 'capital' },
            { data: 'amount_paid', 'className': 'success' },
            { data: 'interes_paid' },
            { data: 'capital_paid', 'className': 'success' },
            { data: 'unpaid_payments', 'className': 'danger' },
            { data: 'total', 'className': 'warning' },
            {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: '',
            },
        ],
        //order: [[1, 'asc']],
    });

    // Add event listener for opening and closing details
    $('#example tbody').on('click', 'td', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child( format(tr.data('child-value'), tr.data('child-name'), tr.data('child-loans_amount'), tr.data('child-current_balance'), tr.data('child-interes_amount'), tr.data('child-capital'), tr.data('child-interes'), tr.data('child-unpaid_payments'), tr.data('child-total_unpay'), tr.data('child-due_date')) ).show();
            tr.addClass('shown');
        }
        
        var due = '<?php echo $loans_origen == 'due' ? ', "due"' : '' ?>';
        if( typeof tr.data('child-value') !== "undefined")
        { document.querySelector('ul.nav.nav-tabs li a').setAttribute("onclick","updateOrderTransactionsTable("+tr.data('child-value')+","+ due+")"); }

        document.querySelector('ul.nav.nav-tabs li a').click();
    });

    $('#example thead th').addClass('text-black');

    $('#additionalModal').on('shown.bs.modal', function () {
      $('#additional_amount').focus();
    });
      
    $('#payModal').on('shown.bs.modal', function () {
      $('#paid_amount').focus();
    });

    order_interes = $('input:text[name=unpaid_interes]').val();
  });

  function setpaymentno(id){
      $('#payment_no').html("N.° Pago : "+id);
      $('#txt_paymentno').val(id);
  }
  function print_letter(_loanno)
  {
    url = '<?php echo base_url() ?>loanscapital/pdf/loan_letter/'+_loanno;
    
    var w = 900;
    var h = 600;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open(url,"_blank","resizable=yes,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,fullscreen=no,dependent=no,copyhistory=no,width="+w+",height="+h+",left="+left+",top="+top);
  }
  function print_loan(_loanno)
  {
    url = '<?php echo base_url() ?>loanscapital/pdf/loan_1/'+_loanno;
    
    var w = 900;
    var h = 600;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open(url,"_blank","resizable=yes,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,fullscreen=no,dependent=no,copyhistory=no,width="+w+",height="+h+",left="+left+",top="+top);
  }
  function print_contract(_loanno)
  {
    url = '<?php echo base_url() ?>loanscapital/pdf/loan_contract/'+_loanno;
    
    var w = 900;
    var h = 600;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open(url,"_blank","resizable=yes,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,fullscreen=no,dependent=no,copyhistory=no,width="+w+",height="+h+",left="+left+",top="+top);
  }
  function print_receipt(_loanno, _transno, _transdate)
  {
    url = '<?php echo base_url() ?>loanscapital/pdf/loan_receipt/'+_loanno+'/'+_transno+'/'+_transdate;
    
    var w = 900;
    var h = 600;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open(url,"_blank","resizable=yes,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,fullscreen=no,dependent=no,copyhistory=no,width="+w+",height="+h+",left="+left+",top="+top);
  }
  function addcust(){
      
  }
  
  // pay functions 
  function payFunc(id)
  {
    if(id) {
      var a = $('#pay_order_'+id).attr("data-order_payer_info_"+id);
      var order_payer = $('#pay_order_'+id).attr("data-order_payer_"+id);
      var order_date = $('#pay_order_'+id).attr("data-order_date_"+id);
      var order_net_amount = $('#pay_order_'+id).attr("data-order_net_amount_"+id);
      
      var current_balance = $('#pay_order_'+id).attr("data-due_amount_"+id);
      var due_info = $('#pay_order_'+id).attr("data-order_pay_title_"+id);
      var due_date = $('#due_date_'+id).val();
      var order_unpaid_payments = $('#pay_order_'+id).attr("data-order_unpaid_payments_"+id);

      order_interes = $('#pay_order_'+id).attr("data-order_interes_"+id);

      $('#order_info').html(a);
      $('#txt_payloansno').val(id);
      $('#txt_due_date').val(due_date);
      $('#payer_name').val(order_payer);
      $('#unpaid_amount').val(current_balance);
      $('#unpaid_interes').val(order_interes);
      $('#unpaid_payments').val(order_unpaid_payments);
      $('#paid_amount').val(order_interes);

      unpaid_amount = order_net_amount;

      var due = '<?php echo $loans_origen == 'due' ? ', "due"' : '' ?>';
      updateOrderTransactionsTable(id, due);
      $("#payer_name").focus();
    }
  }// edit functions 
  function editFunc(id)
  {
    if(id) {
      $('#editForm').attr('action', '<?php echo base_url() ?>loanscapital/update/'+id);
      $('#edit_transaction').val(id);
      $('#edit_old_interes_amount').val($('#edit_order_'+id).attr("data-interes_topaid_"+id));
      $('#edit_old_capital_amount').val($('#edit_order_'+id).attr("data-capital_topaid_"+id));
      
      $("#edit_new_capital_amount").focus();
    }
  }
  // pay functions 
  function additionalFunc(id)
  {
    if(id) {
      var a = $('#pay_order_'+id).attr("data-order_additional_info_"+id);
      var order_date = $('#pay_order_'+id).attr("data-order_date_"+id);
      var current_balance = $('#pay_order_'+id).attr("data-due_amount_"+id);
      
      var old_cuota_amount = $('#pay_order_'+id).attr("data-order_interes_"+id);
      var old_interes_amount = $('#pay_order_'+id).attr("data-interes_"+id);
      var old_capital_amount = $('#pay_order_'+id).attr("data-capital_"+id);
      
      $('#additional_info').html(a);
      $('#txt_loansno').val(id);
      $('#additional_amount').val(0);
      $('#unpaid_capital').val(current_balance);

      $('#old_cuota_amount').val(old_cuota_amount);
      $('#old_interes_amount').val(old_interes_amount);
      $('#old_capital_amount').val(old_capital_amount);
      
      $('#new_cuota_amount').val(old_cuota_amount);
      $('#new_interes_amount').val(old_interes_amount);
      $('#new_capital_amount').val(old_capital_amount);
      
      //$('#additional_date').val(order_date);
      unpaid_amount = current_balance;

      updateAdditionalTable(id);
      $("#capitalpaid_amount").focus();
    }
  }

    // complete loan function 
    function completeLoanFunc(id)
  {
    if(id) {
      $("#completeLoanForm").on('submit', function() {
        var form = $(this);
        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'id':id}
        }).done(function( msg ) { 
        });
      });
    }
  }
  // updateOrderTransactionsTable functions 
  function updateOrderTransactionsTable(id, due = "")
  {
    if(id) {
      $.ajax({
          type: "GET",
          url: "<?php echo base_url() ?>ajax/getloanscapitaltransactions/index",
          data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'id':id,'due':due}
      }).done(function( msg ) { 
          $('#orderTransactionsTable').html(msg);
          $('#capitalpaid_amount').val(0);
          $('#paid_payments_amount').val(0);
      }); 
    };  
  }

function updateAdditionalTable(id)
  {
    if(id) {
      $.ajax({
          type: "GET",
          url: "<?php echo base_url() ?>ajax/getloanscapitaladditional/index",
          data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'id':id}
      }).done(function( msg ) { 
          $('#additionalTable').html(msg);
          $('#capitalpaid_amount').val(0);
          $('#paid_payments_amount').val(0);
      }); 
    };  
  }

// remove transaction functions 
function removeTransactionFunc(loan_no, transactions_no, paid_amount)
{
    $("#removeTransactionForm").on('submit', function() {

      var form = $(this);
      console.log(loan_no, " ", transactions_no, " ", paid_amount);

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { "<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>", loan_no: loan_no, transactions_no: transactions_no, amount: paid_amount }, 
      }).done(function( msg ) { 
        alert(msg);
        console.log(msg);
      });
    });
}
  // remove additional functions 
  function removeAdditionalFunc(loan_no, transactions_no, additional_amount)
  {
      $("#removeAdditionalForm").on('submit', function() {
        var form = $(this);
        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: { "<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>", loan_no: loan_no, transactions_no: transactions_no, amount: additional_amount }, 
        }).done(function( msg ) { 
        });
      });
  }

  function getpayments(id)
  {
    $.ajax({
        type: "GET",
        url: "<?php echo base_url() ?>ajax/getpayments/index",
        data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'id':id}
    }).done(function( msg ) { 
        $('#gridbox_amortization').html(msg);
    })
  }
  function resetValue(ctrl) { 
    $('#'+ctrl).val("0");
  }
  function tabE(obj, e, ctrl) { 
    var e = (typeof event != 'undefined') ? window.event : e; // IE : Moz 
    if (e.keyCode == 13) { 
      document.getElementById(ctrl).focus();
      return false;
    }
  }
  function addCommas(x) { const formatterDolar = new Intl.NumberFormat('en-EN', { style: 'currency', currency: 'USD' });
    return formatterDolar.format(x);
  }
</script>

</body>
</html>