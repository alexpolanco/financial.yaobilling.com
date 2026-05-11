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
    <!-- Content Header (Page header) -->
  <?php echo form_open('loans/update/'.$this->uri->segment(3), array('onsubmit' => 'return stopform();','id' => 'frm','name'=>'frm'));?>
    <section class="content-header">
      <h1>
        Editar préstamo: <?php echo $recored[0]->customer_first_name . " de $" . number_format($recored[0]->loans_amount, 2); ?>
      </h1>
      <div class="breadcrumb">
        <input type="submit" name="btnsubmit" id="fsubmit" class="btn btn-primary" value="Guardar" title="Guardar" />
          <input type="submit" name="btnrenew" id="frenew" class="btn btn-success" value="Renovar" title="Renovar préstamo" />
          <span class="btn btn-success btn-flat " style="background-color: #dd4b39; border-color: #d73925;">

            <?php
                $checkreturn = $recored[0]->return_p;
                echo '<input type="hidden" name="product_serial_no[]" value="'.$recored[0]->loans_no.'" />';
            ?>

            <input type="checkbox" value="yes" name="return" <?php if($checkreturn == 'yes') echo 'checked'; ?> /> <span style="color:#FFF;" title="Cancelar préstamo" > Cancelar Préstamo</span>
            <input type="hidden" name="loan_number" value="" />
          </span>
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
                  <!-- category -->
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
                                <button type="button" class="btn btn-primary dropdown-toggle">Monto prestado</button>
                              </div>
                              <input type="number" name="txt_loans_amount" id="txt_loans_amount" class="form-control " value="<?php echo $recored[0]->loans_amount; ?>" onKeyUp="loadAmortizationData()" onkeypress="return tabE(this,event,'txt_loanstype')" min="0" placeholder="Monto prestado..."  />
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="title-loanstype">
                                        <div class="input-group input-group-lg">    
                                            <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary" onclick="getloanstype()"><i class="fa fa-search own-de-i"></i> Tipos de préstamos</button>
                                          </div>
                                          <input type="text" name="txt_loanstype" id="txt_loanstype" class="form-control " value="<?php echo $recored[0]->loanstype_name; ?>" onkeypress="return tabE(this,event,'txt_routes')" min="0" placeholder="Tipo de préstamo..." readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="row"  id="loanstype" style="display:none;">
                                <div class="col-md-12">
                                    <table id="gridbox_loanstype" class="display cell-border row-border hover" style="width:100%">
                                      <thead>
                                        <tr><th>Seleccionar tipo de préstamo</th></tr>
                                      </thead>
                                      <tbody>
                                      <?php foreach ( $_loanstype as $row ) : ?>
                                        <tr><td><?php echo '<h2 id="loanstype_'.$row->loanstype_id.'" class="lead" onclick="setloanstype('.$row->loanstype_id.',\''.$row->loanstype_name.'\','.$row->loanstype_duration.',\''.$row->loanstype_frequency.'\','.$row->loanstype_interes.')">'.$row->loanstype_name.'</h2>'; ?></td></tr>
                                      <?php endforeach; ?>
                                      </tbody>
                                      <tfoot></tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="title-routes">
                                        <div class="input-group input-group-lg">    
                                            <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary" onclick="getroutes()"><i class="fa fa-search own-de-i"></i> Rutas</button>
                                          </div>
                                          <input type="text" name="txt_routes" id="txt_routes" class="form-control " value="<?php echo $recored[0]->routes_name; ?>" onkeypress="return tabE(this,event,'txt_collector')" min="0" placeholder="Rutas..." readonly  />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="row" id="routes" style="display:none;">
                                <div class="col-md-12">
                                    <table id="gridbox_routes" class="display cell-border row-border hover" style="width:100%">
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
                            <div class="row">
                                <div class="col-md-12">
                          <div class="form-group">
                            <div class="input-group input-group-lg">    
                                <div class="input-group-btn">
                                <label class="btn btn-primary">Fecha del contrato</label>
                              </div>
                              <input type="date" name="txt_entry_date" id="txt_entry_date" class="form-control " value="<?php echo $recored[0]->entry_date; ?>" onkeypress="return tabE(this,event,'txt_entry_date')" onChange="updateLoanDates()" min="0" placeholder="Fecha del contrato..."  />
                            </div>
                          </div>
                          </div></div>
                          <div class="row">
                                <div class="col-md-12">
                          <div class="form-group">
                            <div class="input-group input-group-lg">    
                                <div class="input-group-btn">
                                <label class="btn btn-primary">Fecha de inicio</label>
                              </div>
                              <input type="date" name="txt_start_date" id="txt_start_date" class="form-control " value="<?php echo $recored[0]->start_date; ?>" onkeypress="return tabE(this,event,'fsubmit')" min="0" placeholder="Fecha de inicio..."  />
                            </div>
                          </div>
                          </div></div>
                          <div class="row">
                                <div class="col-md-12">
                          <div class="form-group">
                            <div class="input-group input-group-lg">    
                                <div class="input-group-btn">
                                <label class="btn btn-primary">Fecha de vencimiento</label>
                              </div>
                              <input type="date" name="txt_end_date" id="txt_end_date" class="form-control " value="<?php echo $recored[0]->end_date; ?>" min="0" onkeypress="return tabE(this,event,'fsubmit')" placeholder="Fecha de vencimiento..." readonly  />
                            </div>
                          </div>
                          </div></div>
                        </div>
                      </div>
                  </div>

                  <!-- Loans Table  -->
                  <div class='col-md-6 pad-0  info-for-bill' >
                    <div class='box box-primary' >
                      <input type="hidden" name="select_order_products" id="select_order_products" />
                      <input type="hidden" name="txt_collector_id" id="txt_collector_id" value="<?php echo $recored[0]->collector_id; ?>" />
                      <input type="hidden" name="txt_customer_id" id="txt_customer_id" value="<?php echo $recored[0]->customer_id; ?>" />
                      <input type="hidden" name="txt_cuota" id="txt_cuota" value="0" />
                      <input type="hidden" name="txt_capital" id="txt_capital" value="0" />
                      <input type="hidden" name="txt_interes_amount" id="txt_interes_amount" value="0" />
                      <input type="hidden" name="txt_loans_total" id="txt_loans_total" value="0" />
                      <input type="hidden" name="txt_loanstype_frequency" id="txt_loanstype_frequency" value="<?php echo $recored[0]->loanstype_frequency; ?>" />
                      <input type="hidden" name="txt_loanstype_duration" id="txt_loanstype_duration" value="<?php echo $recored[0]->loanstype_duration; ?>" />
                      <input type="hidden" name="txt_loanstype_interes" id="txt_loanstype_interes" value="<?php echo $recored[0]->loanstype_interes; ?>" />
                      <input type="hidden" name="txt_loanstype_id" id="txt_loanstype_id" onChange="updateLoanDates()" value="<?php echo $recored[0]->loanstype_id; ?>" />
                      <input type="hidden" name="txt_routes_id" id="txt_routes_id" value="<?php echo $recored[0]->routes_id; ?>" />
                      
                      <div class='box-body pad'>
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
                        <input type="number" name="txtqty" id="qtymodel" class="form-control " value="" min="1" max="10" onkeypress="return tabE(this,event)" placeholder="Cantidad del producto..." />
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

      loadAmortizationData();
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

// load loans amortization
  function loadAmortizationData(){
    
    if (1==1){
        loadSimpleAmortizationData();
    }
    else
    {
       loadDirectAmortizationData(); 
    }
    
  }
  
// load loans amortization
  function loadSimpleAmortizationData(){
    var _table, _loopdates, 
        _loans_amount = $("#txt_loans_amount").val(), 
        _interes = $("#txt_loanstype_interes").val(),
        _duration = $("#txt_loanstype_duration").val(), 
        _interes_amount = (parseFloat(_loans_amount) * parseFloat(_interes) / 100) / parseFloat(_duration), 
        _loans_total = parseFloat(_loans_amount) + parseFloat(_interes_amount) * parseFloat(_duration), 
        _cuota = parseFloat(_loans_total) / parseFloat(_duration), 
        _capital = _cuota - _interes_amount,
        _entry_date = new Date($("#txt_entry_date").val());
        
    $("#txt_cuota").val(_cuota);
    $("#txt_capital").val(_capital);
    $("#txt_interes_amount").val(_interes_amount);
    $("#txt_loans_total").val(_loans_total);
        
    switch ($("#txt_loanstype_frequency").val()) {
      case "Diario":
        days = 1;
        break;
      case "Semanal":
        days = 7;
        break;
      case "Quincenal":
        days = 15;
        break;
      case "Mensual":
        days = 1;
        break;
      case "Anual":
        days = 365;
    }

    $("#gridbox_amortization").html('');

    var i, _table = '<table class="table table-striped  table-bordered table-hover"><tbody><tr><th style="width: 10px">#</th><th>Fecha</th><th>Saldo inicial</th><th>Cuota</th><th>Capital</th><th>Interes</th><th>Saldo final</th></tr>';
    
    for (i = 0; i <= _duration - 1; i++)
    {
        if($("#txt_loanstype_frequency").val() == "Mensual"){
            var currentMonth = _entry_date.getMonth();
            _entry_date.setMonth(currentMonth + 1);
            _entry_date.setMonth(currentMonth + _duration * days);
        } 
        else {
            _entry_date.setDate(_entry_date.getDate() + days + (i==0?1:0));
        }
        
        _loans_total -= _cuota

        _table += '<tr><td>'+(i+1)+'</td><td>'+_entry_date.toInputFormat()+'</td><td>'+addCommas(_loans_total+_cuota)+'</td><td>'+addCommas(_cuota)+'</td><td>'+addCommas(_capital)+'</td><td>'+addCommas(_interes_amount)+'</td><td>'+addCommas(_loans_total)+'</td></tr>';
    }
    _table += '</tbody></table>';
    $("#gridbox_amortization").html(_table);
  }  

// load loans amortization
  function loadDirectAmortizationData(){
    var _table, _loopdates, 
        _loans_amount = $("#txt_loans_amount").val(), 
        _interes = $("#txt_loanstype_interes").val(),
        _duration = $("#txt_loanstype_duration").val(), 
        _interes_amount = parseFloat(_loans_amount) * parseFloat(_interes) / 100, 
        _loans_total = parseFloat(_loans_amount) + parseFloat(_interes_amount), 
        _cuota = parseFloat(_loans_total) / parseFloat(_duration), 
        _capital = 0,
        _entry_date = new Date($("#txt_entry_date").val());
        
    switch ($("#txt_loanstype_frequency").val()) {
      case "Diario":
        days = 1;
        break;
      case "Semanal":
        days = 7;
        break;
      case "Quincenal":
        days = 15;
        break;
      case "Mensual":
        days = 1;
        break;
      case "Anual":
        days = 365;
    }

    $("#gridbox_amortization").html('');

    var i, _table = '<table class="table table-striped"><tbody><tr><th style="width: 10px">#</th><th>Fecha</th><th>Saldo inicial</th><th>Cuota</th><th>Capital</th><th>Interes</th><th>Saldo final</th></tr>';
    
    for (i = 0; i <= _duration - 1; i++)
    {
        if($("#txt_loanstype_frequency").val() == "Mensual"){
            var currentMonth = _entry_date.getMonth();
            _entry_date.setMonth(currentMonth + days);
        } 
        else {
            _entry_date.setDate(_entry_date.getDate() + days + (i==0?1:0));
        }
        
        _interes_amount = _loans_total * _interes / 100
        _capital = _cuota - _interes_amount
        
        _table += '<tr><td>'+(i+1)+'</td><td>'+_entry_date.toInputFormat()+'</td><td>'+addCommas(_loans_total+_cuota)+'</td><td>'+addCommas(_cuota)+'</td><td>'+addCommas(_capital)+'</td><td>'+addCommas(_interes_amount)+'</td><td>'+addCommas(_loans_total)+'</td></tr>';
        
        _loans_total -= _capital

    }
    _table += '</tbody></table>';
    $("#gridbox_amortization").html(_table);
  }
  
// update loan dates
  function updateLoanDates(){
      var _entry_date = new Date($("#txt_entry_date").val()), _duration = $("#txt_loanstype_duration").val(), days = 0;

      switch ($("#txt_loanstype_frequency").val()) {
          case "Diario":
            days = 1;
            break;
          case "Semanal":
            days = 7;
            break;
          case "Quincenal":
            days = 15;
            break;
          case "Mensual":
            days = 1;
            break;
          case "Anual":
            days = 365;
        }
        
        if(!isNaN(_entry_date.getTime())){
            if($("#txt_loanstype_frequency").val() == "Mensual"){
                var currentMonth = _entry_date.getMonth();
                
                _entry_date.setMonth(currentMonth + 1);
                $("#txt_start_date").val(_entry_date.toInputFormat());
                _entry_date.setMonth(currentMonth + _duration * days);
                $("#txt_end_date").val(_entry_date.toInputFormat());
            } 
            else {
                _entry_date.setDate(_entry_date.getDate() + days + 1);
                $("#txt_start_date").val(_entry_date.toInputFormat());
                _entry_date.setDate(_entry_date.getDate() + _duration * days - days);
                $("#txt_end_date").val(_entry_date.toInputFormat());
            }
            
        } else {
            alert("Fecha inválida");
        }
        
        loadAmortizationData();
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
        document.getElementById('txt_entry_date').focus();
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
        document.getElementById('txt_loans_amount').focus();
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
  function setloanstype(id,name,duration,frequency)
  {
        $('#txt_loanstype_id').val(id);
        $('#txt_loanstype_duration').val(duration);
        $('#txt_loanstype_frequency').val(frequency);
        $('#txt_loanstype').val(name);
        $('#loanstype').css('display', 'none');
        
        updateLoanDates();
        document.getElementById('btn_routes').focus();
  }
  
  function addCommas(x) {
    return Number.parseFloat(x).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",").toLocaleString("es");
  }
</script>
