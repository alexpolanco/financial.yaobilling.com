<?php
  $dateform = '';
  $dateto = '';

  if(isset($_POST['date']) && $_POST['date'] != '' )
  {
    if($_POST['date'] == 'search' )
    {
      $sendserver = $_POST['date'];
      $dateform = $_POST['txtfrom_date'];
      $dateto = $_POST['txtto_date'];
    }
    else
    {
      $sendserver = $_POST['date'];  
    }
  }
  else
  {
    $sendserver = $this->uri->segment(2);
  }

?>
<?php
// Add FIle
// include common file
 $this->load->view('admin/include/common.php'); 
// include header file
  $this->load->view('admin/include/header.php'); 
// include sidebar file  
   $this->load->view('admin/include/sidebar.php');
   
   	$loans_origen = $this->uri->segment(2);
   	
   $CI =& get_instance();

   $_routes = $CI->get_all_routes();
   $_customer = $CI->get_all_customer();
   //$_collector = $CI->get_all_collector();

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Recibos (<?php echo count($recored); ?>)
      </h1>
      <div class="breadcrumb">
         <a href="<?php echo base_url().'loans/loan_print'; ?>" class="btn btn-primary" title="Generar recibos e imprimir">Generar recibos e imprimir</a>
        <button type="button" onclick="print_list('payment_list')" class="btn btn-warning" title="Lista de cobro">Lista de cobro</button>
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
                echo form_open('loans/receipt',$attributes) ?>
                <div class="row">
                      <div class="col-xs-2">
                            <div class="input-group">
                                <span class="input-group-addon"><label>Desde:</label></span>
                                <input type="date" name="txtfrom_date" id="txtfrom_date" value="<?php echo (empty($this->uri->segment(3)) ? $date1 : $this->uri->segment(3)) ; ?>" class="form-control" />
                            </div>
                      </div>
                      <div class="col-xs-2">
                            <div class="input-group">
                                <span class="input-group-addon"><label>Hasta:</label></span>
                                <input type="date" name="txtto_date" id="txtto_date" value="<?php echo (empty($this->uri->segment(4)) ? $date2 : $this->uri->segment(4)); ?>" class="form-control" />
                            </div>
                      </div>
                      <div class="col-xs-8">
                            <div class="form-group">
                              <input id="search" type="submit" value="Buscar" title="Buscar" class="btn btn-primary" />
                              <?php /*<input type="button" value="Recibos de hoy" title="Recibos de hoy" class="btn btn-<?php if($sendserver == 'today') echo 'success'; else echo 'primary'; ?>" onclick="javascript:window.location.href='<?php echo base_url().'loans/today' ?>';" />
                              <input type="button" value="Esta semana" title="Esta semana" class="btn btn-<?php if($sendserver == 'weekly') echo 'success'; else echo 'primary'; ?>" onclick="javascript:window.location.href='<?php echo base_url().'loans/weekly' ?>';" />
                              <input type="button" value="Este mes" title="Este mes" class="btn btn-<?php if($sendserver == 'monthly') echo 'success'; else echo 'primary'; ?>" onclick="javascript:window.location.href='<?php echo base_url().'loans/monthly' ?>';" />
                              <input type="button" value="Este año" title="Este año" class="btn btn-<?php if($sendserver == 'yearly') echo 'success'; else echo 'primary'; ?>" onclick="javascript:window.location.href='<?php echo base_url().'loans/yearly' ?>';" />
                              */ ?>
                              <input type="button" value="Fuera de fecha" title="Fuera de fecha" class="btn btn-<?php if($sendserver_due == '1') echo 'success'; else echo 'primary'; ?>" onclick="getdue()" />
                              <input type="button" value="Pagados" title="Pagados" class="btn btn-<?php if($sendserver_pagados == '1') echo 'success'; else echo 'primary'; ?>"  onclick="getpaids()" />
                              <button type="button" class="btn btn-danger" onclick="javascript:window.location.href='<?php echo base_url() ?>loans/receipt'"><i class="fa fa-eraser own-de-i"></i></button>
                            </div>
                         </div>
                </div>
                
                <div class="row">
                    <div class="col-md-5">
                        <div id="title-customer">
                            <div class="input-group">    
                                <div class="input-group-btn">
                                <button type="button" class="btn btn-primary" onclick="getcustomer()"><i class="fa fa-search own-de-i"></i> Cliente</button>
                              </div>
                              <input type="text" name="txt_customer" id="txt_customer" class="form-control btn-lg" value="<?php echo $customer_name_field; ?>" onkeypress="return tabE(this,event,'txt_loans_amount')" placeholder="Clientes..."  autocomplete="off" readonly />
                                <span class="input-group-btn">
                                  <button type="button" class="btn btn-danger" onclick="remove_customer()"><i class="fa fa-eraser own-de-i"></i></button>
                              </span>
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
                    </div>
                 
                    <div class="col-md-5">
                        <div id="title-routes">
                            <div class="input-group">    
                                <div class="input-group-btn">
                                <button type="button" class="btn btn-primary" id="btn_routes" onclick="getroutes()"><i class="fa fa-search own-de-i"></i> Ruta</button>
                              </div>
                              <input type="text" name="txt_routes" id="txt_routes" class="form-control btn-lg" value="<?php echo $routes_name_field; ?>" onkeypress="return tabE(this,event,'txt_entry_date')" min="0" placeholder="Rutas..." readonly />
                              <span class="input-group-btn">
                                  <button type="button" class="btn btn-danger" onclick="remove_route()"><i class="fa fa-eraser own-de-i"></i></button>
                              </span>
                            </div>
                        </div>
                        <br />
                        <div class="row" id="routes" style="display:none;">
                            <div class="col-md-12">
                                <table id="gridbox_routes" class="display table cell-border row-border hover" style="width:100%">
                                  <thead>
                                    <tr><th>Seleccionar la ruta del préstamo</th></tr>
                                  </thead>
                                  <tbody>
                                  <?php foreach ( $_routes as $row ) : ?>
                                    <tr><td><?php echo '<h2 id="routes_'.$row->routes_id.'" class="lead" onclick="setroutes('.$row->routes_id.',\''.$row->routes_name.'\','.$row->collector_id.')">'.$row->routes_name.' - '.$row->collector_first_name.'</h2>' ?></td></tr>
                                  <?php endforeach; ?>
                                  </tbody>
                                  <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="btn-group">
                          <button type="button" id="payment_no" class="btn btn-default btn-flat">N.° Pago <?php echo empty($paymentno_field) ? "" : ": ".$paymentno_field; ?></button>
                          <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-danger" onclick="remove_paymentno()"><i class="fa fa-eraser own-de-i"></i></button>
                          </span>
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
                        </div>
                    </div>
                </div>
               
                <table id="example" class="display" style="width:100%">
                  <thead>
                    <tr class="bg-blue">
   						<th align="left" >Fecha de pago</th>
   						<th align="left" >N.° préstamo</th>
   						<th align="left" >N.° Pago</th>
   						<th align="left" >Cliente</th>
   						<th align="left" >Ruta</th>
   						<th align="left" >Cobrador</th>
   						<th align="left" >Cuota</th>
   						<th align="left" >Atraso</th>
   						<th align="left" ><?php echo empty($loansdue) ? "Adelanto" : "Mora"; ?></th>
   						<th align="left" ><?php echo empty($loansdue) ? "Pago" : "Debido"; ?></th>
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
   								<td><?php echo date("d-m-Y", strtotime($_recored->due_date)); ?></td>
   								<td><?php echo $_recored->loans_no; ?></td>
   								<td><?php echo $_recored->payment_no; ?></td>
   								<td><?php echo $_recored->customer_first_name; ?></td>
   								<td><?php echo $_recored->routes_name; ?></td>
   								<td><?php echo $_recored->collector_first_name; ?></td>
   								<td><?php echo $_recored->cuota; ?></td>
   								<td><?php echo $_recored->atraso; ?></td>
   								<td><?php echo empty($loansdue) ? $_recored->advance_amount : $_recored->fee_payment; ?></td>
   								<td><?php echo empty($loansdue) ? $_recored->payment : number_format(str_replace(",", "", $_recored->atraso) + 500,2); ?></td>
				                <td>
				                    <button type="button" onclick="javascript:print_loan('loan_1','<?php echo  $_recored->loans_no; ?>')" class="btn btn-sm btn-info">Ver</button>
                                    <a href="<?php echo base_url() ?>loans/loan_print/<?php echo $_recored->loans_no; ?>/<?php echo  $_recored->payment_no; ?>"><img src="<?php echo base_url() ?>_template/images/bprint.png" alt="print button" height="30" width="30" /></a>
                              </td>
                            </tr>
                  <?php 
                     }
                  ?>
                    </tbody>
                </table>
                
                <input type="hidden" name="txt_customer_id" id="txt_customer_id" value="<?php echo $customer_field; ?>" />
                <input type="hidden" name="txt_routes_id" id="txt_routes_id" value="<?php echo $routes_field; ?>" />
                <input type="hidden" name="txt_paymentno" id="txt_paymentno" value="<?php echo $paymentno_field; ?>" />
                <input type="hidden" name="receipt_due" id="receipt_due" value="<?php echo empty($sendserver_due) ? 0 : $sendserver_due; ?>" />
                <input type="hidden" name="receipt_paid" id="receipt_paid" value="<?php echo empty($sendserver_pagados) ? 0 : $sendserver_pagados; ?>" />
                <input type="hidden" name="hdnmode" id="hdnmode" value="" />
                <input type="hidden" name="hdnids" id="hdnids" value="<?php echo implode(',',$arids); ?>" />
              <?php echo form_close() ?>
              </div>
            </div>
          </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php // include footer FIle

 $this->load->view('admin/include/footer.php'); ?>			
<script type="text/javascript">
  function print_loan(url, _loanno)
  {
    url = '<?php echo base_url() ?>loans/pdf/'+url+'/'+_loanno;
    
    var w = 900;
    var h = 600;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open(url,"_blank","resizable=yes,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,fullscreen=no,dependent=no,copyhistory=no,width="+w+",height="+h+",left="+left+",top="+top);
  }
  
  function print_list(url)
  {
    var dateform = document.getElementById('txtfrom_date').value;
    var dateto = document.getElementById('txtto_date').value;
    var loansdue = document.getElementById('receipt_due').value == 0 ? "" : "/due";
    
    if(dateto==''){ dateto=dateform; }
    
    url = '<?php echo base_url() ?>loans/pdf/'+url+'/'+dateform+'/'+dateto+loansdue<?php echo empty($loansdue) || empty($sendserver_due) ? '' : "+'/due'" ?>;
    
    var w = 900;
    var h = 600;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open(url,"_blank","resizable=yes,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,fullscreen=no,dependent=no,copyhistory=no,width="+w+",height="+h+",left="+left+",top="+top);
  }
  function search_record()
  {
    document.getElementById('search').click();
  }
  function getpaids(){
      if($('#receipt_paid').val()==1)
      { $('#receipt_paid').val(0) }
      else
      { $('#receipt_paid').val(1); }
      
      if($('#receipt_due').val()==1)
      { $('#receipt_due').val(0) }
      search_record();
  }
  function getdue(){
      if($('#receipt_due').val()==1)
      { $('#receipt_due').val(0) }
      else
      { $('#receipt_due').val(1); }
      
      if($('#receipt_paid').val()==1)
      { $('#receipt_paid').val(0) }
      search_record();
  }
  
  function tabE(obj, e, ctrl) { 
        var e = (typeof event != 'undefined') ? window.event : e; // IE : Moz 
        
        if (e.keyCode == 13) { 
            document.getElementById(ctrl).focus();
            return false;
        }
  }
  function remove_route(){
      $('#txt_routes_id').val('');
      $('#txt_routes').val('');
      $('#txt_collector_id').val('');
      search_record();
  }
  function remove_customer(){
      $('#txt_customer_id').val('');
      $('#txt_customer').val('');
      search_record();
  }
  function remove_paymentno(){
      $('#payment_no').html('N.° Pago');
      $('#txt_paymentno').val('');
      search_record();
  }
  
  function setpaymentno(id){
      $('#payment_no').html("N.° Pago : "+id);
      $('#txt_paymentno').val(id);
      search_record();
  }
  
  // get routes
  function getroutes(id)
  {
     if ($('#routes').css('display') == 'none')
     { $("#routes").css('display', 'grid'); }
      else
     { $("#routes").css('display', 'none'); }
  }
// set routes
  function setroutes(id,name,collector_id)
  {
        $('#txt_routes_id').val(id);
        $('#txt_routes').val($('#routes_'+id).html());
        $('#txt_collector_id').val(collector_id);
        $('#routes').css('display', 'none');
        search_record();
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
  function setcustomer(id,name)
  {
        $('#txt_customer_id').val(id);
        $('#txt_customer').val(name);
        $('#customers').css('display', 'none');
        search_record();
  }
</script>
