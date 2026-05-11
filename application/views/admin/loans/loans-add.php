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
  <?php echo form_open('loans/create', array('onsubmit' => 'return stopform();','id' => 'frm','name'=>'frm'));?>
    <section class="content-header">
      <h1>
        Agregar préstamo
      </h1>
      <div class="breadcrumb">
        <input type="submit" name="btnsubmit" id="fsubmit" class="btn btn-primary" value="Guardar" title="Guardar" />
      </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
         <?php if(validation_errors() != false){ ?>
          <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Error!</h4>
              <?php echo validation_errors(); ?>
          </div>
          <?php } ?>
        </div>
      </div>
      <!-- Small boxes (Stat box) -->
      <div class="row">
              <!-- Loans details -->
              <div class="col-md-6" style="padding-right:0px;" >
                  <div class='box box-primary'  >
                        <div class='box-body pad'>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="title-customer">
                                        <div class="input-group input-group-lg">    
                                            <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary" onclick="getcustomer()"><i class="fa fa-search own-de-i"></i> Cliente</button>
                                          </div>
                                          <input type="text" name="txt_customer" id="txt_customer" class="form-control " value="<?php echo $_customer[0]->customer_first_name; ?>" onkeypress="return tabE(this,event,'txt_loans_amount')" placeholder="Clientes..."  autocomplete="off" readonly />
                                          <span class="input-group-btn">
                                              <a id="modal_addcust" href="#addcust" rel="leanModal" class="btn btn-info btn-sm own-de"><i class="fa fa-user-plus own-de-i"></i></a>
                                          </span>                                          
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
                              <input type="number" name="txt_loans_amount" id="txt_loans_amount" class="form-control " value="" onKeyUp="loadAmortizationData()" onkeypress="return tabE(this,event,'btn_loanstype')" min="0" placeholder="Monto prestado..."  />
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="title-loanstype">
                                        <div class="input-group input-group-lg">    
                                            <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary" id="btn_loanstype" onclick="getloanstype()"><i class="fa fa-search own-de-i"></i> Tipo de préstamo</button>
                                          </div>
                                          <input type="text" name="txt_loanstype" id="txt_loanstype" class="form-control " value="<?php echo $_loanstype[0]->loanstype_name; ?>" onkeypress="return tabE(this,event,'btn_routes')" min="0" placeholder="Tipo de préstamo..."  readonly />
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
                                            <button type="button" class="btn btn-primary" id="btn_routes" onclick="getroutes()"><i class="fa fa-search own-de-i"></i> Ruta</button>
                                          </div>
                                          <input type="text" name="txt_routes" id="txt_routes" class="form-control " value="<?php echo $_routes[0]->routes_name . " - " . $_routes[0]->collector_first_name; ?>" onkeypress="return tabE(this,event,'txt_entry_date')" min="0" placeholder="Rutas..." readonly />
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
                              <input type="date" name="txt_entry_date" id="txt_entry_date" class="form-control " value="<?php echo date('Y-m-d') ?>" onkeypress="return tabE(this,event,'txt_start_date')" onChange="updateLoanDates()" min="0" placeholder="Fecha del contrato..."  />
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
                              <input type="date" name="txt_start_date" id="txt_start_date" class="form-control " value="" onkeypress="return tabE(this,event,'fsubmit')" min="0" placeholder="Fecha de inicio..."  />
                            </div>
                          </div>
                          </div></div>
                          <div class="row">
                                <div class="col-md-12">
                          <div class="form-group">
                            <div class="input-group input-group-lg">    
                                <div class="input-group-btn">
                                <label class="btn btn-default">Fecha de vencimiento</label>
                              </div>
                              <input type="date" name="txt_end_date" id="txt_end_date" class="form-control " value="" min="0" onkeypress="return tabE(this,event,'fsubmit')" placeholder="Fecha de vencimiento..." readonly  />
                            </div>
                          </div>
                          </div></div>
                        </div>
                      </div>
                </div>

                <div class="col-md-6 info-for-bill">
                  <div class='box box-primary' >
                      <input type="hidden" name="select_order_products" id="select_order_products" />
                      <input type="hidden" name="txt_collector_id" id="txt_collector_id" value="<?php echo $_routes[0]->collector_id; ?>" />
                      <input type="hidden" name="txt_customer_id" id="txt_customer_id" value="<?php echo $_customer[0]->customer_id; ?>" />
                      <input type="hidden" name="txt_cuota" id="txt_cuota" value="0" />
                      <input type="hidden" name="txt_capital" id="txt_capital" value="0" />
                      <input type="hidden" name="txt_interes_amount" id="txt_interes_amount" value="0" />
                      <input type="hidden" name="txt_loans_total" id="txt_loans_total" value="0" />
                      <input type="hidden" name="txt_loanstype_frequency" id="txt_loanstype_frequency" value="<?php echo $_loanstype[0]->loanstype_frequency; ?>" />
                      <input type="hidden" name="txt_loanstype_duration" id="txt_loanstype_duration" value="<?php echo $_loanstype[0]->loanstype_duration; ?>" />
                      <input type="hidden" name="txt_loanstype_interes" id="txt_loanstype_interes" value="<?php echo $_loanstype[0]->loanstype_interes; ?>" />
                      <input type="hidden" name="txt_loanstype_id" id="txt_loanstype_id" onChange="updateLoanDates()" value="<?php echo $_loanstype[0]->loanstype_id; ?>" />
                      <input type="hidden" name="txt_routes_id" id="txt_routes_id" value="<?php echo $_routes[0]->routes_id; ?>" />
                    <div class='box-body pad'>
                        <p class="lead">Amortización del préstamo</p>
                        <div id="gridbox_amortization"></div>
                    </div>
                  </div>
                </div>
          </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  <?php echo form_close(); ?>
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
                          Ciudad  :
                          <input type="text" name="txtcity" id="txtcity" class="form-control validate[required]" value=""  placeholder="Ciudad ..." required />
                          <br />
                          Teléfono :
                          <input type="text" name="txtphno" pattern="[0-9]{10}" id="txtphno" class="form-control validate[required]" value=""  placeholder="Teléfono..." required />
                          <br />
                          Persona de Contacto :
                          <input type="text" name="txtpname" id="txtpname" class="form-control validate[required]" value=""  placeholder="Persona de Contacto..." required />
                          <br />
                          Teléfono de la Persona de Contacto :
                          <input type="text" name="txtcphone" id="txtcphone" class="form-control validate[required]" value=""  placeholder="Teléfono de la Persona de Contacto..." required />
                          <br />
                          ¿Está Activo?
                          <input type="radio" class="radio-button" name="rdois_active" id="rdois_active" value="yes" />Si
                          <input type="radio" class="radio-button" name="rdois_active" id="rdois_active" value="no" />No
                          <input type="button" name="btnsubmit" onclick="addcust();"  style="float:right;" class="btn btn-primary" value="Guardar" />
                        
                    </div>
                 </div>
               </section>
             </div>
             
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
                          Cliente :
                          <input type="text" name="txtfname" id="etxtfname" class="form-control validate[required]" value=""  placeholder="Cliente..." required />
                           Correo electrónico :
                          <input type="email" name="txtemail" id="etxtemail" class="form-control validate[required,custom[email]]" value=""  placeholder="Correo electrónico..." required />
                          Dirección :
                          <input type="text" name="txtadd" id="etxtadd" class="form-control validate[required]" value=""  placeholder="Dirección..." required />
                          <br />
                          Ciudad :
                          <input type="text" name="txtcity" id="etxtcity" class="form-control validate[required]" value=""  placeholder="Ciudad ..." required />
                          <br />
                          Código postal :
                          <input type="text" name="txtzip" id="etxtzip" class="form-control validate[required]" value=""   placeholder="Código postal..." required />
                          <br />
                          Teléfono :
                          <input type="text" name="txtphno"  id="etxtphno" class="form-control validate[required]" value=""  placeholder="Teléfono..." required />
                          <br />
                          Persona de Contacto :
                          <input type="text" name="txtpname" id="etxtpname" class="form-control validate[required]" value=""  placeholder="Persona de Contacto..." required />
                          <br />
                          Teléfono de la Persona de Contacto :
                          <input type="text" name="txtcphone" id="etxtcphone" class="form-control validate[required]" value=""  placeholder="Teléfono de la Persona de Contacto..." required />
                          <br />
                         
                         <input type="button" name="btnsubmit" onclick="editcustsubmit();"  style="float:right;" class="btn btn-primary" value="Submit" />
                        
                    </div>
                 </div>
               </section>
             </div>
             
    <!--  Model End -->

  </div>
  <!-- /.content-wrapper -->

  <?php // include footer FIle

 $this->load->view('admin/include/footer.php'); ?>

  <!-- Hide Sidebar -->

<script type="text/javascript">


  $(document).ready(function(){
      $('#txt_customer').focus();
        
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
    var phno = document.getElementById('txtphno').value;
    var conper = document.getElementById('txtpname').value;
    var cphno = document.getElementById('txtcphone').value;
    var acti = document.getElementById('rdois_active').value;
    
    if(!(String(name)==false)){
      if(reg.test(email)){
        if(!(String(addr)==false)){
          if(!(String(city)==false)){
              if(!(String(phno)==false) && /^\d{10}$/.test(phno)){
                if(!(String(conper)==false)){
                  if(!(String(cphno)==false) &&  /^\d{10}$/.test(cphno)){
                    
                    
                    $.ajax({
                        type: "GET",
                        url: "<?php echo base_url() ?>ajax/add_customer/index",
                        data: { name:name, email:email,addr:addr,city:city,phno:phno,conper:conper,cphno:cphno,"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>" }
                    }).done(function( msg ) {
                      alert(msg);
                      $("#close").click();
                      $("#skills").focus();
                      
                    })
                    
                  }
                  else{
                    alert('Validar Teléfono de la Persona de Contacto !!');
                  }
                }
                else{
                  alert('Persona de Contacto !!');
                }
              }
              else{
                alert('Validar Teléfono !!');
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
      alert('Cliente !!');
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
