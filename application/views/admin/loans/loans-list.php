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
      <h1>
        Préstamos <?php echo empty($loansdue) ? 'activos' : $loansdue ; ?> (<?php echo count($recored); ?>)
      </h1>
      <div class="breadcrumb">
    <?php if($loans_origen == 'due') : ?>
        <a id="loans" href="<?php echo base_url().'loans'; ?>" class="btn btn-primary">Préstamos activos</a>
    <?php else : ?>
        <a id="loans_due" href="<?php echo base_url().'loans/due'; ?>" class="btn btn-danger">Préstamos fuera de fecha</a>
	<?php endif; ?>
        <a id="receipts" href="<?php echo base_url().'loans/receipt'; ?>" class="btn btn-success">Recibos</a>
        <a id="new_loan" href="<?php echo base_url().'loans/create'; ?>" class="btn btn-primary">Nuevo Préstamo</a>
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
                echo form_open('loans/delete',$attributes) ?>
                <table id="example" class="display table cell-border row-border hover" style="width:100%">
                  <thead>
                    <tr class="bg-blue">
   						<th align="left" >Cliente</th>
   						<th align="left" >Fecha </th>
   						<th align="left" >Monto prestado</th>
   						<th>Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
					  $arids = array();
                      foreach ( $recored as $_recored ) {
                        $arids[] = $_recored->loans_id;
                  ?>
                            <tr>
   								<td><?php echo $_recored->customer_first_name; ?></td>
   								<td><?php echo date("d-m-Y", strtotime($_recored->entry_date)); ?></td>
   								<td><?php echo number_format($_recored->loans_amount, 2); ?></td>
				                <td>
				                    <button type="button" onclick="print_loan('loan_1','<?php echo  $_recored->loans_no; ?>')" class="btn btn-sm btn-info" title="Estado del préstamo">Ver</button>
				                    <a id="modal_addbill" href="#addbill"  class="btn btn-info btn-sm own-de" rel="leanModal" onclick="getpayments(<?php echo  $_recored->loans_no; ?>)" title="Registrar un atraso"><i  class="fa fa-download" aria-hidden="true"></i></a>
				                    <a class="action-edit btn btn-success btn-sm own-de" href="#addcust" id="modal_addcust" rel="leanModal" onclick="getpayments(<?php echo  $_recored->loans_no; ?>)" title="Registrar un abono"><i class="fa fa-money"></i></a>
                                    <a class="action-edit btn btn-warning btn-sm" href="<?php echo base_url().'loans/edit/'.$_recored->loans_no; ?>" title="Editar préstamo" rel="leanModal"><i class="fa fa-edit"></i></a>
                                    <a class="action-edit btn btn-danger btn-sm" href="<?php echo base_url().'loans/delete/'.$_recored->loans_no; ?>" title="Eliminar préstamo" rel="leanModal"><i class="fa fa-close"></i></a>
                              </td>
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
  
 <?php // include footer FIle
 $this->load->view('admin/include/footer-loans-list.php'); ?>
