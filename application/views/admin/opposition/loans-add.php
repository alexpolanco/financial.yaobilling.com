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
   $_loans = $CI->get_all_loans();
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
  <?php echo form_open('opposition/create', array('onsubmit' => 'return stopform();','id' => 'frm','name'=>'frm'));?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Agregar Oposición</h1>
      <div class="breadcrumb">
        <input type="submit" name="btnsubmit" id="fsubmit" class="btn btn-lg btn-primary" value="Guardar" />
        <input type="button" title="Regresar" value="Regresar" class="btn btn-lg btn-warning" onclick="javascript:window.location.href='<?php echo base_url().'opposition' ?>'" />
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
                      <input type="text" name="txt_customer" id="txt_customer" class="form-control " value="<?php echo $_customer[0]->customer_first_name; ?>" onkeypress="return tabE(this,event,'txt_loans')" placeholder="Clientes..."  autocomplete="off" readonly />                                          
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
                              <tr><td><?php echo '<h2 id="customer_'.$row->customer_id.'" class="lead" onclick="setcustomer('.$row->customer_id.',\''.$row->customer_first_name.'\',\'txt_loans\')">'.$row->customer_first_name.'</h2>' ?></td></tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot></tfoot>
                          </table>
                          <input type="hidden" name="txt_customer_id" id="txt_customer_id" value="<?php echo $_customer[0]->customer_id; ?>" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 info-for-bill">
                  <div class='box box-primary' >
                    <div class='box-body pad'>
                      
                    <div class="row">
                          <div class="col-md-12">
                              <div id="title-loans">
                                  <div class="input-group input-group-lg">    
                                      <div class="input-group-btn">
                                      <button type="button" class="btn btn-primary" onclick="getloans()"><i class="fa fa-search own-de-i"></i> Prestamos</button>
                                    </div>
                                    <input type="text" name="txt_loans" id="txt_loans" class="form-control " value="<?php echo $_loans[0]->loans_first_name; ?>" placeholder="Prestamos..."  autocomplete="off" readonly />                                         
                                  </div>
                              </div>
                          </div>
                      </div>
                      <br />
                      <div class="row" id="loanss" style="display:none;">
                        <div class="col-md-12">
                          <table id="gridbox_loanss" class="display cell-border row-border hover" style="width:100%">
                            <thead>
                              <tr><th>Seleccionar préstamo</th></tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot></tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
          </div>
        </div>              
      </div>
      <!-- /.row -->

      <div class="row" id="loandata">
      <section class="content"> <div class="error-page"> <h2 class="headline text-yellow"> <i class="fa fa-warning text-yellow"></i></h2><div class="error-content"><h3> Seleccione un tipo de préstamo para consultar y proceder a crear la oposición.</p> </div> </div> </section>
      </div>
      
    </section>
    <!-- /.content -->
    <?php echo form_close(); ?>

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
  $(document).ready(function(){
    console.log($('#txt_customer_id').val() + " " + $('#txt_customer').val());
    setcustomer($('#txt_customer_id').val(), $('#txt_customer').val());
      $('#txt_customer').focus();
      $('#txt_loans_amount').inputmask('999,999,999.99', { numericInput: true });    //123456  =>  € ___.__1.234,56
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
  function updateLoanDates()
  {
    var days = 0, _table, _loopdates, 
        _loans_amount = $("#txt_loans_amount").val(), 
        _interes = $("#txt_loanstype_interes").val(),
        _duration = $("#txt_loanstype_duration").val(), 
        _interes_amount = (parseFloat(_loans_amount) * parseFloat(_interes) / 100), 
        _loans_total = parseFloat(_loans_amount), 
        _cuota = parseFloat(_loans_total) / parseFloat(_duration), 
        _capital = 0,
        _start_date = new Date($("#txt_start_date").val()),
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
  function setcustomer(id,name)
  {
    $('#txt_customer_id').val(id);
    $('#txt_customer').val(name);
    $('#customers').css('display', 'none');

    $.ajax({
        type: "GET",
        url: "<?php echo base_url() ?>ajax/getcustomerloans/index",
        data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'id':id}
    }).done(function( msg ) { 
        $('#gridbox_loanss').html(msg);
        $('#txt_loans').val("");
        $('#loanss').css('display', 'none');

        $('#loandata').html('<section class="content"> <div class="error-page"> <h2 class="headline text-yellow"> <i class="fa fa-warning text-yellow"></i></h2><div class="error-content"><h3> Seleccione un tipo de préstamo para consultar y proceder a crear la oposición.</p> </div> </div> </section>');
    })

    document.getElementById('txt_loans').focus();
  }
  
// get loans
function getloans()
  {
    if ($('#loanss').css('display') == 'none')
    { $("#loanss").css('display', 'grid'); }
    else
    { $("#loanss").css('display', 'none'); }
  }
// set loans
  function setloans(id,name)
  {
    $('#txt_loans_id').val(id);
    var customer_id = $('#txt_customer_id').val();

    if(name == "loanscapital"){
      $('#txt_loans').val("Interes capital");
		}
		else if(name == "loanschristmas"){
      $('#txt_loans').val("Regalía");
		}
		else if(name == "loansfixed"){ 
      $('#txt_loans').val("Interes fijo");
		} 
		else if(name == "loansinversion"){
      $('#txt_loans').val("Inversión");
		} 
		else if(name == "loansquickbusiness"){
      $('#txt_loans').val("Rápidos");
		}

    $('#loanss').css('display', 'none');

    $.ajax({
        type: "GET",
        url: "<?php echo base_url() ?>ajax/getloandata/index",
        data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'id':id, 'name':name, 'customer_id':customer_id}
    }).done(function( msg ) { 
        $('#loandata').html(msg);
    })
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
// get opposition_place
  function getoppositionplace(id)
  {
    if ($('#opposition_place').css('display') == 'none')
    { $("#opposition_place").css('display', 'grid'); }
    else
    { $("#opposition_place").css('display', 'none'); }
  }
// set opposition_place
  function setoppositionplace(id, place)
  {
    $('#txt_opposition_place').val(place);
    $('#opposition_place').css('display', 'none');
    
    updateLoanDates();
    document.getElementById('txt_loans_amount').focus();
  }
  
  function addCommas(x) {
    return Number.parseFloat(x).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",").toLocaleString("es");
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