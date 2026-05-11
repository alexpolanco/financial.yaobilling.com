<?php
  if(!isset($_SESSION['old_id']))
  {
    $_SESSION['old_id'] = 1;
  }

  $CI =& get_instance();
  $company = $CI->get_company_data(); 
  $tabids = $CI->get_tmp_loans();
  $_cat = $CI->get_all_cat();
  $_routes = $CI->get_all_routes();
  $_customer = $CI->get_all_customer();
  $_guarantor = $CI->get_all_guarantor();
  $_loanstype = $CI->get_all_loanstype();
?>

<?php
// Add FIle
// include common file
  $this->load->view('admin/include/common.php'); 
// include header file
  $this->load->view('admin/include/header.php'); 
// include sidebar file  
  $this->load->view('admin/include/sidebar.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <?php echo form_open('loansinversion/update/'.$this->uri->segment(3), array('onsubmit' => 'return stopform();','id' => 'frm','name'=>'frm'));?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Editar Préstamo de Inversión <b><?php echo $recored[0]->customer_first_name; ?></b></h1>
      <div class="breadcrumb">
        <input type="submit" name="btnsubmit" id="fsubmit" class="btn btn-lg btn-primary" value="Guardar" />
        <!-- <input type="submit" name="btnrenew" id="frenew" class="btn btn-lg btn-success" value="Renovar" />
        <span class="btn btn-lg btn-success btn-flat " style="background-color: #dd4b39; border-color: #d73925;">

          <?php
              $checkreturn = $recored[0]->return_p;
              echo '<input type="hidden" name="product_serial_no[]" value="'.$recored[0]->loans_no.'" />';
          ?>

          <input type="checkbox" value="yes" name="return" <?php if($checkreturn == 'yes') echo 'checked'; ?> /> <span style="color:#FFF;" > Cancelar Préstamo</span>
          <input type="hidden" name="loan_number" value="" />
        </span> -->
        
        <input type="button" title="Regresar" value="Regresar" class="btn btn-lg btn-warning" onclick="javascript:window.location.href='<?php echo base_url().'loansinversion' ?>'" />
      </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
        <?php if(validation_errors() != false){ ?>
          <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> ¡Error!</h4>
              <?php echo validation_errors(); ?>
          </div>
          <?php } ?>
        </div>
      </div>
      <!-- Small boxes (Stat box) -->
      <div class="row">

      <!-- loans details -->
      <div class="col-md-6" style="padding-right:0px;" >
          <div class='box box-primary'  >
            <div class='box-body pad'>
                <div class="row">
                    <div class="col-md-12">
                        <div id="title-customer">
                            <div class="input-group input-group-lg">    
                                <div class="input-group-btn">
                                <button type="button" class="btn btn-primary" onclick="getcustomer()"><i class="fa fa-search own-de-i"></i> Clientes</button>
                              </div>
                              <input type="text" name="txt_customer" id="txt_customer" class="form-control " value="<?php echo $recored[0]->customer_first_name; ?>" onkeypress="return tabE(this,event,'txt_loans_amount')" placeholder="Clientes..." autocomplete="off" readonly />
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row" id="customers" style="display:none;">
                  <div class="col-md-12">
                      <table id="gridbox_customers" class="display cell-border row-border hover" style="width:100%">
                        <thead>
                          <tr><th>Seleccionar cliente</th></tr>
                        </thead>
                        <tbody>
                        <?php foreach ( $_customer as $row ) : ?>
                          <tr><td><?php echo '<h2 id="customer_'.$row->customer_id.'" class="lead" onclick="setcustomer('.$row->customer_id.',\''.$row->customer_first_name.'\',\'txt_loans_amount\')">'.$row->customer_first_name.'</h2>' ?></td></tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot></tfoot>
                      </table>
                    </div>
                  </div>
                  <div class="input-group input-group-lg">    
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle">Monto prestado</button>
                    </div>
                    <input type="number" name="txt_loans_amount" id="txt_loans_amount" class="form-control " value="<?php echo $recored[0]->loans_amount; ?>" onChange="updateLoanDates()" onkeypress="return tabE(this,event,'txt_loanstype_interes')" min="0" placeholder="Monto prestado..."  />
                  </div>
                  <br />
                  <div class="input-group input-group-lg">    
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle">Adicionales</button>
                    </div>
                    <input type="number" name="txt_additionals_amount" id="txt_additionals_amount" class="form-control " value="<?php echo $recored[0]->additional_amount; ?>" min="0" placeholder="Adicionales prestado..." readonly  />
                  </div>
                  <br />
                  <div class="input-group input-group-lg">    
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle">Total prestado</button>
                    </div>
                    <input type="number" name="txt_total_amount" id="txt_total_amount" class="form-control " value="<?php echo floatval($recored[0]->loans_amount) + floatval($recored[0]->additional_amount); ?>" min="0" placeholder="Total prestado..." readonly  />
                  </div>
                  <br />
                  <div class="input-group input-group-lg">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle">Tasa de intéres</button>
                    </div>
                    <input type="number" name="txt_loanstype_interes" id="txt_loanstype_interes" class="form-control " data-inputmask='"mask": "99%"' data-mask="" step='0.01' value="<?php echo $recored[0]->interes; ?>" onChange="updateLoanDates()" onkeypress="return tabE(this,event,'txt_loanstype_frequency')" min="1" placeholder="Tasa de intéres..." />
                    <span class="input-group-btn">
                          <a class="btn btn-default btn-sm own-de"><i class="fa fa-percent" aria-hidden="true"></i>%</a>
                      </span> 
                  </div>
                  <br /> 
                  <div class="row">
                    <div class="col-md-12">
                      <div id="title-loanstype">
                          <div class="input-group input-group-lg">    
                            <div class="input-group-btn">
                            <button type="button" class="btn btn-primary" id="btn_loanstype" onclick="getloanstype()"><i class="fa fa-search own-de-i"></i> Frecuencia del préstamo</button>
                          </div>
                          <input type="text" name="txt_loanstype_frequency" id="txt_loanstype_frequency" class="form-control " value="<?php echo $recored[0]->loanstype_frequency; ?>" onkeypress="return tabE(this,event,'txt_loanstype_duration')" min="0" placeholder="Frecuencia del préstamo..."  readonly />
                          </div>
                        </div>
                      </div>
                    </div>
                    <br />
                    <div class="row"  id="loanstype" style="display:none;">
                      <div class="col-md-12">
                        <table id="gridbox_loanstype" class="display cell-border row-border hover" style="width:100%">
                          <thead>
                            <tr><th>Seleccionar frecuencia del préstamo</th></tr>
                          </thead>
                          <tbody>
                            <tr><td><h2 id="loanstype_5" class="lead" onclick="setloanstype(5, 'Anual')">Anual</h2></td></tr>
                            <tr><td><h2 id="loanstype_3" class="lead" onclick="setloanstype(3, 'Mensual')">Mensual</h2></td></tr>
                            <tr><td><h2 id="loanstype_4" class="lead" onclick="setloanstype(4, 'Quincenal')">Quincenal</h2></td></tr>
                            <tr><td><h2 id="loanstype_1" class="lead" onclick="setloanstype(1, 'Semanal')">Semanal</h2></td></tr>
                            <tr><td><h2 id="loanstype_2" class="lead" onclick="setloanstype(2, 'Diario')">Diario</h2></td></tr>
                          </tbody>
                          <tfoot></tfoot>
                        </table>
                      </div>
                    </div>    
                    
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-default dropdown-toggle">Cantidad de <span id="loantime">meses</span></button>
                      </div>
                      <input type="number" name="txt_loanstype_duration" id="txt_loanstype_duration" class="form-control " value="<?php echo $recored[0]->duration; ?>" onChange="updateLoanDates()" onkeypress="return tabE(this,event,'txt_contract_number')" min="1" placeholder="Cantidad de cuotas..."  />
                    </div>
                    <br />
                    
                    <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="input-group input-group-lg">    
                                  <div class="input-group-btn">
                                  <label class="btn btn-primary">Número del contrato</label>
                                </div>
                                <input type="text" name="txt_contract_number" id="txt_contract_number" class="form-control " value="<?php echo $recored[0]->contract_number; ?>" onkeypress="return tabE(this,event,'txt_contract_folio1')" min="0" placeholder="Número de acto autentico..."  />
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="input-group input-group-lg">    
                                  <div class="input-group-btn">
                                  <label class="btn btn-primary">Número del folio 1</label>
                                </div>
                                <input type="text" name="txt_contract_folio1" id="txt_contract_folio1" class="form-control " value="<?php echo $recored[0]->contract_folio1; ?>" onkeypress="return tabE(this,event,'txt_contract_folio2')" min="0" placeholder="Número de folio 1..."  />
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="input-group input-group-lg">    
                                  <div class="input-group-btn">
                                  <label class="btn btn-primary">Número del folio 2</label>
                                </div>
                                <input type="text" name="txt_contract_folio2" id="txt_contract_folio2" class="form-control " value="<?php echo $recored[0]->contract_folio2; ?>" onkeypress="return tabE(this,event,'txt_entry_date')" min="0" placeholder="Número de folio 2..."  />
                              </div>
                            </div>
                          </div>
                        </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="input-group input-group-lg">    
                            <div class="input-group-btn">
                              <label class="btn btn-primary">Fecha del contrato</label>
                                </div>
                                <input type="date" name="txt_entry_date" id="txt_entry_date" class="form-control " value="<?php echo $recored[0]->entry_date; ?>" onkeypress="return tabE(this,event,'txt_entry_time')" onChange="updateLoanDates()" min="0" placeholder="Fecha del contrato..."  />
                              </div>
                            </div>
                          </div>
                        </div>                        
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="input-group input-group-lg">    
                                  <div class="input-group-btn">
                                  <label class="btn btn-primary">Hora del contrato</label>
                                </div>
                                <input type="time" name="txt_entry_time" id="txt_entry_time" class="form-control " value="<?php echo $recored[0]->entry_time; ?>" onkeypress="return tabE(this,event,'txt_guarantor1')" min="0" placeholder="Hora del contrato..."  />
                              </div>
                            </div>
                          </div>
                        </div>
                          <div class="row">
                                <div class="col-md-12">
                          <div class="form-group">
                            <div class="input-group input-group-lg">    
                                <div class="input-group-btn">
                                <label class="btn btn-default">Fecha de vencimiento</label>
                              </div>
                              <input type="date" name="txt_end_date" id="txt_end_date" class="form-control " value="<?php echo $recored[0]->end_date; ?>" min="0" placeholder="Fecha de vencimiento..." readonly  />
                            </div>
                          </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                              <div id="title-guarantor1">
                                  <div class="input-group input-group-lg">    
                                    <div class="input-group-btn">
                                      <button type="button" class="btn btn-primary" onclick="getguarantor(1)"><i class="fa fa-search own-de-i"></i> Garante #1</button>
                                    </div>
                                    <input type="text" name="txt_guarantor1" id="txt_guarantor1" class="form-control " value="<?php echo $recored[0]->guarantor1_first_name; ?>" onkeypress="return tabE(this,event,'txt_guarantor2')" placeholder="Garante #1..."  autocomplete="off" readonly />
                                    <span class="input-group-btn">
                                      <a id="resetguarantor1" onclick="resetguarantor(1)" class="btn btn-danger btn-sm own-de"><i class="fa fa-trash own-de-i"></i></a>
                                  </span> 
                                  </div>
                              </div>
                          </div>
                      </div>
                      <br />
                      <div class="row" id="guarantors1" style="display:none;">
                        <div class="col-md-12">
                          <table id="gridbox_guarantors1" class="display cell-border row-border hover" style="width:100%">
                            <thead>
                              <tr><th>Seleccionar garante</th></tr>
                            </thead>
                            <tbody>
                            <?php foreach ( $_guarantor as $row ) : ?>
                              <tr><td><?php echo '<h2 id="guarantor1_'.$row->guarantor_id.'" class="lead" onclick="setguarantor(1,'.$row->guarantor_id.',\''.$row->guarantor_first_name.'\',\'txt_guarantor2\')">'.$row->guarantor_first_name.'</h2>' ?></td></tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot></tfoot>
                          </table>
                        </div>
                      </div>

                      <div class="row">
                          <div class="col-md-12">
                              <div id="title-guarantor2">
                                  <div class="input-group input-group-lg">    
                                    <div class="input-group-btn">
                                      <button type="button" class="btn btn-primary" onclick="getguarantor(2)"><i class="fa fa-search own-de-i"></i> Garante #2</button>
                                    </div>
                                    <input type="text" name="txt_guarantor2" id="txt_guarantor2" class="form-control " value="<?php echo $recored[0]->guarantor2_first_name; ?>" onkeypress="return tabE(this,event,'fsubmit')" placeholder="Garante #2..."  autocomplete="off" readonly />
                                    <span class="input-group-btn">
                                      <a id="resetguarantor2" onclick="resetguarantor(2)" class="btn btn-danger btn-sm own-de"><i class="fa fa-trash own-de-i"></i></a>
                                  </span>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <br />
                      <div class="row" id="guarantors2" style="display:none;">
                        <div class="col-md-12">
                          <table id="gridbox_guarantors2" class="display cell-border row-border hover" style="width:100%">
                            <thead>
                              <tr><th>Seleccionar garante</th></tr>
                            </thead>
                            <tbody>
                            <?php foreach ( $_guarantor as $row ) : ?>
                              <tr><td><?php echo '<h2 id="guarantor2_'.$row->guarantor_id.'" class="lead" onclick="setguarantor(2,'.$row->guarantor_id.',\''.$row->guarantor_first_name.'\',\'txt_loans_amount\')">'.$row->guarantor_first_name.'</h2>' ?></td></tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot></tfoot>
                          </table>
                        </div>
                      </div>
                      
                      </div>
                    </div>
                  </div>

                  <!-- Loans Table  -->
                  <div class='col-md-6 pad-0  info-for-bill' >
                    <div class='box box-primary' >
                      <div class='box-header'>
                      </div><!-- /.box-header -->
                      <div class='box-body pad'>
                      
                      <input type="hidden" name="select_order_products" id="select_order_products" />
                      <input type="hidden" name="txt_collector_id" id="txt_collector_id" value="<?php echo $recored[0]->collector_id; ?>" />
                      <input type="hidden" name="txt_customer_id" id="txt_customer_id" value="<?php echo $recored[0]->customer_id; ?>" />
                      <input type="hidden" name="txt_guarantor_id1" id="txt_guarantor_id1" value="<?php echo $recored[0]->guarantor1_id; ?>" />
                      <input type="hidden" name="txt_guarantor_id2" id="txt_guarantor_id2" value="<?php echo $recored[0]->guarantor2_id; ?>" />
                      <input type="hidden" name="txt_cuota" id="txt_cuota" value="0" />
                      <input type="hidden" name="txt_capital" id="txt_capital" value="0" />
                      <input type="hidden" name="txt_interes_amount" id="txt_interes_amount" value="0" />
                      <input type="hidden" name="txt_loans_total" id="txt_loans_total" value="0" />
                      <input type="hidden" name="txt_loanstype_id" id="txt_loanstype_id" onChange="updateLoanDates()" value="<?php echo $recored[0]->loanstype_id; ?>" />
                      <input type="hidden" name="txt_routes_id" id="txt_routes_id" value="<?php echo $recored[0]->routes_id; ?>" />
                      
                        <p class="lead">Amortización del préstamo</p>
                        <div id="gridbox_amortization"></div>
                    </div>
                </div>
          </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <?php echo form_close(); ?>

    <!--  Model Start -->
        
          <div id="addqty" class="popupContainer" style="display:none;">
                <header class="popupHeader">
                  <span class="header_title">Producto</span>
                  <span id="close" class="modal_close"><i class="fa fa-times"></i></span>
                </header>
                
                <section class="popupBody">
                  <!-- Social Login -->
                  <div class="social_login">
                    <div id="con">
                          Cantidad
                        <input type="number" name="txtqty" id="qtymodel" class="form-control " value="" min="1" max="5" onkeypress="return tabE(this,event)" placeholder="Cantidad del producto..." />
            <br />
            <div id="option_print">
            </div>
            <br />
                        <input type="button" id="modelqtyidenter" name="btnsubmit" onclick="addqty();" style="margin-left:50px;" class="btn btn-primary" value="Submit" />
                      
                    </div>
                 </div>
               </section>
             </div>
       <!-- Discount -->
       <div id="changediscount" class="popupContainer" style="display:none;">
                <header class="popupHeader">
                  <span class="header_title">Descuento</span>
                  <span id="close" class="modal_close"><i class="fa fa-times"></i></span>
                </header>
                
                <section class="popupBody">
                  <!-- Social Login -->
                  <div class="social_login">
                    <div class="">
                         En %
                          <input type="text" name="txtdisc" id="discmodel" class="form-control " value="" onkeyup="datachange(this.value)" placeholder="Descuento en porciento..." />
                          En Efectivo
                          <input type="text" class="form-control" name="txtdiscr" id="discrupee" value= "" onkeyup="datachangerupee(this.value)" placeholder="Descuento en efectivo..."/>
                          <br />
                          <input type="button" name="btnsubmit" onclick="editpurchasedisc();" style="margin-left:50px;" class="btn btn-primary" value="Submit" />
                      
                    </div>
                 </div>
               </section>
             </div>
             
             <div id="entire_disc" class="popupContainer" style="display:none;">
                <header class="popupHeader">
                  <span class="header_title">Total Descuento</span>
                  <span id="close" class="modal_close"><i class="fa fa-times"></i></span>
                </header>
                
                <section class="popupBody">
                  <!-- Social Login -->
                  <div class="social_login">
                    <div class="">
                        Descuento 
                          <input  type="text" class="form-control" name="txtentiredisc" id="txtentiredisc" value= "" onkeypress='return isNumberKey(event)' placeholder="Descuento en pesos..."/>
                          <br />
                          <input type="button" name="btnsubmit" id="btnentireloan" onclick="setentriedisc();" style="margin-left:50px;" class="btn btn-primary" value="Submit" />
                    </div>
                </div>
               </section>
             </div>
           <!-- Discount -->  
             <div id="changeqty" class="popupContainer" style="display:none;">
                <header class="popupHeader">
                  <span class="header_title">Cambiar Cantidad del Producto</span>
                  <span id="closepq" class="modal_close"><i class="fa fa-times"></i></span>
                </header>
                
                <section class="popupBody">
                  <!-- Social Login -->
                  <div class="social_login">
                    <div class="">
                          Cantidad
                        <input type="number" name="txtqty" id="qtymodelchange" class="form-control " onkeypress="return tabEa(this,event)" value="" min="1" max=""  onkeyup="this.value = minmax(this.value, 1)" placeholder="Cantidad del producto..." />
                        <input type="hidden" class="form-control" id="deleterowid" value= "" />
                        <br />
                        <input type="button" id="mmmmm" name="btnsubmit" onclick="changeqty();" style="margin-left:50px;" class="btn btn-primary" value="Submit" />
                      
                    </div>
                 </div>
               </section>
             </div>
             
             
             <div id="addbill" class="popupContainer" style="display:none;">
                <header class="popupHeader">
                  <span class="header_title">Agregar Número de Factura</span>
                  <span id="close" class="modal_close"><i class="fa fa-times"></i></span>
                </header>
                
                <section class="popupBody">
                  <!-- Social Login -->
                  <div class="social_login">
                    <div class="">
                          Agregar Número de Factura
                          <input type="text" name="txtbllnm" id="billaddmodel" class="form-control " value=""   placeholder="Número de factura..." />
                          <br />
                          <input type="button" name="btnsubmit" onclick="addbillnumber();" style="margin-left:25px;" class="btn btn-primary" value="Submit" />
                    </div>
                 </div>
               </section>
             </div>
             
             <div id="editbill" class="popupContainer" style="display:none;">
                <header class="popupHeader">
                  <span class="header_title">Editar Número de Factura</span>
                  <span id="close" class="modal_close"><i class="fa fa-times"></i></span>
                </header>
                
                <section class="popupBody">
                  <!-- Social Login -->
                  <div class="social_login">
                    <div class="">
                          Cambiar Número de Factura
                          <input type="text" name="txtbillnm" id="billeditmodel" class="form-control " value=""   placeholder="Número de factura..." />
                          <br />
                          <input type="button" name="btnsubmit" onclick="editbillnumber();" style="margin-left:25px;" class="btn btn-primary" value="Submit" />
                    </div>
                 </div>
               </section>
             </div>
             
             <!-- Party Add -->
             
             <div id="addcust" class="popupContainer" style="display:none;">
                <header class="popupHeader">
                  <span class="header_title">Agregar Cliente</span>
                  <span id="close" class="modal_close"><i class="fa fa-times"></i></span>
                </header>
                
                <section class="popupBody">
                  <!-- Social Login -->
                  <div class="social_login">
                    <div class="">
                        
                          Nombre :
                          <input type="text" name="txtfname" id="txtfname" class="form-control validate[required]" value=""  placeholder="Nombre..." required />
                          Cédula :
                          <input type="text" name="txtpersonalid" id="txtpersonalid" class="form-control validate[required]"  pattern="999-9999999-9" value=""  placeholder="Cédula del cliente..." required />
                          Correo electrónico :
                          <input type="email" name="txtemail" id="txtemail" class="form-control validate[required,custom[email]]" value=""  placeholder="Correo electrónico..." required />
                          Dirección :
                          <input type="text" name="txtadd" id="txtadd" class="form-control validate[required]" value=""  placeholder="Dirección..." required />
                          <br />
                          Ciudad :
                          <input type="text" name="txtcity" id="txtcity" class="form-control validate[required]" value=""  placeholder="Ciudad..." required />
                          <br />
                          Código postal :
                          <input type="number" name="txtzip" id="txtzip" class="form-control validate[required]" value=""   placeholder="Código postal..." required />
                          <br />
                          Teléfono :
                          <input type="text" name="txtphno" pattern="[0-9]{10}" id="txtphno" class="form-control validate[required]" value=""  placeholder="Teléfono..." required />
                          <br />
                          Persona de contacto
                          <input type="text" name="txtpname" id="txtpname" class="form-control validate[required]" value=""  placeholder="Persona de contacto..." required />
                          <br />
                          Teléfono de la persona de contacto :
                          <input type="text" name="txtcphone" id="txtcphone" class="form-control validate[required]" value=""  placeholder="Teléfono de la persona de contacto..." required />
                          <br />
                          ¿Está activo?
                          <input type="radio" class="radio-button" name="rdois_active" id="rdois_active" value="yes" />Si
                          <input type="radio" class="radio-button" name="rdois_active" id="rdois_active" value="no" />No
                          <input type="button" name="btnsubmit" onclick="addcust();"  style="float:right;" class="btn btn-primary" value="Submit" />
                        
                    </div>
                 </div>
               </section>
             </div>
             
             <!-- Customer ADD -->
             <!-- Customer Edit -->
             
              <div id="editcust" class="popupContainer" style="display:none;">
                <header class="popupHeader">
                  <span class="header_title" >Editar Cliente</span>
                  <span id="closeparty" class="modal_close" ><i class="fa fa-times"></i></span>
                </header>
                
                <section class="popupBody">
                  <!-- Social Login -->
                  <div class="social_login">
                    <div class="">
                          
                          <input type="hidden" name="custid" id="custid" value="" />
                          Nombre del cliente
                          <input type="text" name="txtfname" id="etxtfname" class="form-control validate[required]" value=""  placeholder="Nombre del cliente..." required />
                           Correo electrónico :
                          <input type="email" name="txtemail" id="etxtemail" class="form-control validate[required,custom[email]]" value=""  placeholder="Correo electrónico..." required />
                          Dirección :
                          <input type="text" name="txtadd" id="etxtadd" class="form-control validate[required]" value=""  placeholder="Dirección..." required />
                          <br />
                          Ciudad :
                          <input type="text" name="txtcity" id="etxtcity" class="form-control validate[required]" value=""  placeholder="Ciudad..." required />
                          <br />
                          Código postal :
                          <input type="text" name="txtzip" id="etxtzip" class="form-control validate[required]" value=""   placeholder="Código postal..." required />
                          <br />
                          Teléfono :
                          <input type="text" name="txtphno"  id="etxtphno" class="form-control validate[required]" value=""  placeholder="Teléfono..." required />
                          <br />
                          Persona de contacto
                          <input type="text" name="txtpname" id="etxtpname" class="form-control validate[required]" value=""  placeholder="Persona de contacto..." required />
                          <br />
                          Teléfono de la persona de contacto :
                          <input type="text" name="txtcphone" id="etxtcphone" class="form-control validate[required]" value=""  placeholder="Teléfono de la persona de contacto..." required />
                          <br />
                         
                         <input type="button" name="btnsubmit" onclick="editcustsubmit();"  style="float:right;" class="btn btn-primary" value="Submit" />
                        
                    </div>
                 </div>
               </section>
             </div>
             
             <!-- PCustomer Edit -->
        
        <!--  Model End -->
        
        

  </div>
  <!-- /.content-wrapper -->

  <?php // include footer FIle

$this->load->view('admin/include/footer.php'); ?>

  <script src="<?php echo base_url(); ?>_template/js/jquery.leanModal.min.js"></script>  
  <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>_template/css/style_model.css" />
  <script src="<?php echo base_url(); ?>_template/js/jquery.maskedinput.js"></script>  

  <link rel="stylesheet" href="<?php echo base_url(); ?>_template/css/jquery-ui.css">
  <script src="<?php echo base_url(); ?>_template/js/jquery-ui.js"></script>

  <!-- Hide Sidebar -->

<script type="text/javascript">
  $("#modal_addcust").leanModal({top : 0, overlay : 0.6, closeButton: ".modal_close" });
  $(document).ready(function(){
      $('#txt_customer').focus();
      $('#txt_loans_amount').inputmask('999,999,999.99', { numericInput: true });    //123456  =>  € ___.__1.234,56

      updateLoanDates();
  });

  $("#txt_customer").autocomplete({
      source: '<?php echo base_url() ?>ajax/search_customer/index',
      limit : 10
  });

  Date.prototype.toInputFormat = function() {
      var yyyy = this.getFullYear().toString();
      var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
      var dd  = this.getDate().toString();
      return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
  };
  
  function isNumberKey(evt)
  {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
    if(charCode == 13)
    $('#btnentireloan').click();
    
    return true;
  }
  
  function addcust()
  {
    var reg =  /\S+@\S+\.\S+/;
    
    var name = document.getElementById('txtfname').value;
    var email = document.getElementById('txtemail').value;
    var addr = document.getElementById('txtadd').value;
    var city = document.getElementById('txtcity').value;
    var zip = document.getElementById('txtzip').value;
    var phno = document.getElementById('txtphno').value;
    var conper = document.getElementById('txtpname').value;
    var cphno = document.getElementById('txtcphone').value;
    var acti = document.getElementById('rdois_active').value;
    
    if(!(String(name)==false)){
      if(reg.test(email)){
        if(!(String(addr)==false)){
          if(!(String(city)==false)){
            if(!(String(zip)==false) && /^\d{6}$/.test(zip)){
              if(!(String(phno)==false) && /^\d{10}$/.test(phno)){
                if(!(String(conper)==false)){
                  if(!(String(cphno)==false) &&  /^\d{10}$/.test(cphno)){
                    
                    
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() ?>ajax/add_customer/index",
                        data: { name:name, email:email,addr:addr,city:city,zip:zip,phno:phno,conper:conper,cphno:cphno }
                    }).done(function( msg ) {
                      alert(msg);
                      $("#close").click();
                      $("#skills").focus();
                      
                    })
                    
                  }
                  else{
                    alert('Validar Teléfono de la persona de contacto !!');
                  }
                }
                else{
                  alert('Persona de contacto!!');
                }
              }
              else{
                alert('Validar Teléfono !!');
              }
            }
            else{
              alert('Código postal, máximo de 6 dígitos !!');
            }
          }
          else {
            alert('Ciudad !!');
          }
        }
        else {
          alert('Dirección');
        }
      }
      else{
        alert('Validar Correo electrónico !!');
      }
    }
    else{
      alert('Nombre del cliente!!');
    }
    
  }

  function tabE(obj, e, ctrl) { 
        var e = (typeof event != 'undefined') ? window.event : e; // IE : Moz 
        
        if (e.keyCode == 13) {
            document.getElementById(ctrl).focus();
            return false;
        }
    }
    
  function tabEa(obj, e) { 
        var e = (typeof event != 'undefined') ? window.event : e; // IE : Moz 
        
        if (e.keyCode == 13) { 
            document.getElementById('mmmmm').focus();
            return false;
        }
    }

  function stopform(){
      // Retrieve the code
      var t = String(document.getElementById('txt_customer').value);  
      if(String(t) != '')
      {
        document.getElementById('loans_no').readOnly = true;
        return false;
      }
      else 
      {
        return true;
      }
}
  
// update loan dates
  function updateLoanDates() {
    var days = 0, _table, _loopdates, 
        _loans_amount = $("#txt_total_amount").val(), 
        _interes = $("#txt_loanstype_interes").val(),
        _duration = $("#txt_loanstype_duration").val(), 
        _interes_amount = (parseFloat(_loans_amount) * parseFloat(_interes) / 100), 
        _loans_total = parseFloat(_loans_amount), 
        _cuota = parseFloat(_loans_total) / parseFloat(_duration), 
        _capital = 0,
        _start_date = new Date($("#txt_entry_date").val()),
        i, _table = '<table class="table table-striped table-bordered table-hover"><tbody><tr><th style="width: 10px">#</th><th>Fecha</th><th>Saldo inicial</th><th>Cuota fija</th><th>Saldo final</th></tr>';

    $("#txt_cuota").val(_cuota);
    $("#txt_capital").val(_capital);
    $("#txt_interes_amount").val(_interes_amount);
    $("#txt_loans_total").val(_loans_total);

    $("#gridbox_amortization").html('');
    
    _table += '<tr><td>Inicio</td><td>'+$("#txt_entry_date").val()+'</td><td>'+addCommas(_loans_amount)+'</td><td></td></tr>';

    for (i = 0; i < _duration; i++)
    {
      //if(!isNaN(_start_date.getTime())) {
        if (i == 0)
        {
          var dt = new Date(_start_date);
          dt.setDate(dt.getDate() + 1);          
          _start_date = dt.toInputFormat();          
        }
        else
        {
          switch ($("#txt_loanstype_frequency").val()) {
            case "Diario":
              _start_date = addDays(_start_date).toInputFormat();
              break;
            case "Semanal":
              _start_date = addWeeks(_start_date).toInputFormat();
              break;
            case "Quincenal":
              _start_date = addBiWeeks(_start_date).toInputFormat();
              break;
            case "Mensual":
              _start_date = addMonths(_start_date).toInputFormat();
              break;
            case "Anual":
              _start_date = addYears(_start_date).toInputFormat();
              break;
          }
        }

      //} else { alert("Fecha inválida"); }
        
        _table += '<tr>';
        _table += '<td>Cuota '+(i + 1)+'</td>';
        _table += '<td>'+_start_date+'</td>';
        _table += '<td></td>';
        _table += '<td>'+addCommas(_interes_amount)+'</td>';
        _table += '</tr>';

        _capital += _interes_amount;
        _loans_total += _interes_amount;
              
    }

    _table += '<tr>';
    _table += '<td>Totales:  </td>';
    _table += '<td></td>';
    _table += '<td>'+addCommas(_loans_amount)+'</td>';
    _table += '<td>'+addCommas(_capital)+'</td>';
    _table += '<td>'+addCommas(_loans_total)+'</td>';
    _table += '</tr>';

    _table += '</tbody></table>';

    $("#txt_end_date").val(_start_date);
    $("#gridbox_amortization").html(_table);

  }

// get customer
  function getcustomer()
  {
    if ($('#customers').css('display') == 'none')
    { $("#customers").css('display', 'grid'); }
    else
    { $("#customers").css('display', 'none'); }
  }
// set customer
  function setcustomer(id, name)
  {
    $('#txt_customer_id').val(id);
    $('#txt_customer').val(name);
    $('#customers').css('display', 'none');
    document.getElementById('txt_loans_amount').focus();
  }
// get guarantor
function getguarantor(no)
  {
    if ($('#guarantors'+no).css('display') == 'none')
    { $("#guarantors"+no).css('display', 'grid'); }
    else
    { $("#guarantors"+no).css('display', 'none'); }
  }
// set guarantor
function setguarantor(no,id,name)
  {
    $('#txt_guarantor_id'+no).val(id);
    $('#txt_guarantor'+no).val(name);
    $('#guarantors'+no).css('display', 'none');
  }
// reset guarantor
  function resetguarantor(no)
  {
    $('#txt_guarantor_id'+no).val("");
    $('#txt_guarantor'+no).val("");
    $('#guarantors'+no).css('display', 'none');
  }
// get loanstype
  function getloanstype(id)
  {
    if ($('#loanstype').css('display') == 'none')
    { $("#loanstype").css('display', 'grid'); }
    else
    { $("#loanstype").css('display', 'none'); }
  }
// set loanstype
  function setloanstype(id, frequency)
  {
    $('#txt_loanstype_id').val(id);
    $('#txt_loanstype_frequency').val(frequency);
    $('#loanstype').css('display', 'none');

    switch ($("#txt_loanstype_frequency").val()) {
        case "Diario":
            $('#loantime').html("días");
          break;
        case "Semanal":
            $('#loantime').html("semanas");
          break;
        case "Quincenal":
            $('#loantime').html("quincenas");
          break;
        case "Mensual":
            $('#loantime').html("meses");
          break;
        case "Anual":
            $('#loantime').html("años");
          break;
      }

      updateLoanDates();
    document.getElementById('txt_loanstype_duration').focus();
  }
  
  function addCommas(x) {
    return Number.parseFloat(x).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",").toLocaleString("es");
  }
  function monthDiff(date) {
    var dt = new Date(), months;
    months = (dt.getFullYear() - date.getFullYear()) * 12;
    months -= date.getMonth();
    months += dt.getMonth();
    return months <= 0 ? 0 : months;
  }
  function addYears(date) {
    var dt = new Date(date);
    dt.setFullYear(dt.getFullYear() + 1);
    dt.setDate(dt.getDate() + 1);
    return dt;
  }
  function addMonths(date) {
    var dt = new Date(date);
    dt.setMonth(dt.getMonth() + 1);
    dt.setDate(dt.getDate() + 1);
    return dt;
  }
  function addWeeks(date) {
    var dt = new Date(date);
    dt.setDate(dt.getDate() + 8);
    return dt;
  }
  function addBiWeeks(date) {
    var dt = new Date(date);
    dt.setDate(dt.getDate() + 15);
    return dt;
  }
  function addDays(date) {
    var dt = new Date(date);
    dt.setDate(dt.getDate() + 2);
    return dt;
  }
</script>
</body>
</html>