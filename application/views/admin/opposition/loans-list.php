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
      <h1>Oposiciones <?php echo empty($loansdue) ? 'activas' : 'levantadas' ; ?> (<?php echo count($recored); ?>)</h1>
      <div class="breadcrumb">
        <?php if($loans_origen == 'due') : ?>
        <a id="loans" href="<?php echo base_url().'opposition'; ?>" class="btn btn-lg btn-success">Oposiciones activas</a>
        <?php else : ?>
        <a id="loans_due" href="<?php echo base_url().'opposition/due'; ?>" class="btn btn-lg btn-danger">Oposiciones levantadas</a>
				<?php endif; ?>
        <!-- <a id="receipts" href="<?php echo base_url().'opposition/receipt'; ?>" class="btn btn-lg btn-success">Recibos</a> -->
        <a id="new_loan" href="<?php echo base_url().'opposition/create'; ?>" class="btn btn-lg btn-primary">Nueva Oposición</a> 
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
                <div class="alert <?php echo $this->session->flashdata('msg') == "Datos actualizados exitosamente" ? "alert-success" : "alert-danger"; ?>  alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>  <i class="icon fa fa-check"></i> <?php echo $this->session->flashdata('msg') == "Datos actualizados exitosamente" ? "¡Bien!" : "¡Error!"; ?></h4>
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
                <?php } ?>
                <?php 
                $attributes = array('id' => 'frm','name'=>'frm');
                echo form_open('opposition/delete',$attributes) ?>
                <table id="example" class="display table cell-border row-border hover" style="width:100%">
                  <thead>
                    <tr class="bg-blue">
                      <th>Cliente</th>
                      <th>Fecha oposición</th>
                      <th>Lugar oposición</th>
                      <th>Tipo de préstamo</th>
                      <th>Total prestado</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $arids = array();
                    foreach ( $recored as $_recored ) {
                      $arids[] = $_recored->loans_no;
                      $loanstypeid = $_recored->loanstype_id;
                      
                      $_frequency = "";
                      if ($loanstypeid == "1") {
                        $_frequency = "semanas";
                      } else if ($loanstypeid == "2") {
                        $_frequency = "días";
                      } else if ($loanstypeid == "3") {
                        $_frequency = "meses";
                      } else if ($loanstypeid == "4") {
                        $_frequency = "quincenas";
                      } else {
                        $_frequency = "años";
                      }
                  ?>
                  
                  <tr data-child-value="<?php echo $_recored->loans_no; ?>" data-child-name="<?php echo  $_recored->customer_first_name; ?>" data-child-loans_amount="<?php echo $_recored->loans_amount; ?>"  data-child-current_balance="<?php echo $_recored->current_balance; ?>" data-child-interes_amount="<?php echo $_recored->interes_amount; ?>" data-child-old_opposition_no="<?php echo $_recored->opposition_no; ?>" data-child-old_opposition_route="<?php echo $_recored->routes_id; ?>" data-child-unpaid_payments="<?php echo $_recored->unpaid_payments; ?>" data-child-due_date="<?php echo date("d-m-Y", strtotime($_recored->due_date)); ?>" >
                      <td><?php echo $_recored->customer_first_name; ?><input type="hidden" name="due_date_<?php echo $_recored->loans_no; ?>" id="due_date_<?php echo $_recored->loans_no; ?>" value="<?php echo date("Y-m-d", strtotime($_recored->due_date)); ?>" /></td>
                      <td><?php echo date("d-m-Y", strtotime($_recored->create_date)); ?></td>
                      <td><?php echo $_recored->routes_id; ?></td>
                      <td><?php echo $_recored->loans_type; ?></td>
                      <td><?php echo number_format($_recored->due_amount, 2); ?></td>
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

  </div>
  <!-- /.content-wrapper -->

<!-- edit form modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="box-header with-border bg-aqua-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
          <h4 class="modal-title" id="edit_info"></h4>
        <div id="editMessages">Editar acto de oposición</div>
      </div>

      <div class="nav-tabs-custom">
      
        <?php 
              $attributes = array('id' => 'editForm','name'=>'editForm','class'=>'form-horizontal');
              echo form_open('opposition/edit',$attributes) ?>
              <div class="modal-body">
                <h4 id="order_edit_title" class="modal-title"></h4>
                <div class="form-group">
                  <label for="edit_date" class="col-sm-3 control-label">FECHA</label>
                  <div class="col-sm-8">
                    <input type="date" class="form-control" id="edit_date" name="edit_date" value="<?php echo date('Y-m-d') ?>" onkeypress="return tabE(this,event,'edit_opposition_no')" placeholder="Selecionar fecha">
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="old_opposition_no" class="col-sm-3 control-label">Acto No. anterior</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="old_opposition_no" name="old_opposition_no" disabled>
                    </div>
                    <label for="edit_opposition_no" class="col-sm-3 control-label">Acto No.</label>
                  <div class="col-sm-3">
                    <input type="number" class="form-control" id="edit_opposition_no" name="edit_opposition_no" onkeypress="return tabE(this,event,'edit_opposition_route')" autocomplete="off" aria-describedby="edit_opposition_no-addon">
                  </div>
                </div>
                
                <div class="form-group">
                    <label for="old_opposition_route" class="col-sm-3 control-label">Lugar de oposición anterior</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="old_opposition_route" name="old_opposition_route" disabled>
                    </div>                      
                    <label for="edit_opposition_route" class="col-sm-3 control-label">Lugar de la oposición</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="edit_opposition_route" name="edit_opposition_route" onkeypress="return tabE(this,event,'asubmit')" autocomplete="off" aria-describedby="edit_opposition_no-addon">
                    </div>
                </div>
                
              </div>
              <div class="modal-footer">
                <input type="hidden" name="txt_loansno" id="txt_loansno" value="" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" name="asubmit" class="btn btn-primary">Guardar cambios</button>
              </div>
              <!-- /.box -->
          </form>
          
        <!-- /.tab-content -->
      </div>
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
      echo form_open('opposition/delete/removeTransaction',$attributes) ?>
        <div class="modal-body">
          <p>¿Seguro que quiere eliminar este recibo?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Eliminar</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- remove edit modal -->
<div class="modal modal-danger fade in" tabindex="-1" role="dialog" id="removeeditModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-aqua-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
        <h4 class="modal-title">Eliminar Adicional</h4>
      </div>
      <?php 
      $attributes = array('id' => 'removeeditForm','name'=>'removeeditForm','class'=>'form-horizontal');
      echo form_open('opposition/delete/removeedit',$attributes) ?>
        <div class="modal-body">
          <p>¿Seguro que quiere eliminar este adicional?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
  var orderTransactionsTable, editTable, order_interes = 0, _abono_capital = "";

/* Formatting function for row details - modify as you need */
function format(value, name, loans_amount, current_balance, interes_amount, opposition_no, opposition_route, unpaid_payments, due_date) {
  base_url = '<?php echo base_url() ?>opposition/';

  return (
      '<table cellpadding="0" cellspacing="0" border="0" style="width:90%">' +
      '<tr>' +
      <?php if($loans_origen == 'due') : ?>
        '<td><button type="button" class="btn btn-sm btn-primary" onclick="print_letter(' + value + ')" ><i  class="fa fa-file" aria-hidden="true"></i> Acto de levantamiento de oposición</button></td>' +
        '<td><button type="button" class="btn btn-sm btn-info" onclick="print_contract(' + value + ')" ><i  class="fa fa-file" aria-hidden="true"></i> Contrato de oposición</button></td>' +
      <?php else : ?>
        '<td><button type="button" class="btn btn-sm btn-info" onclick="print_contract(' + value + ')" ><i  class="fa fa-file" aria-hidden="true"></i> Contrato de oposición</button></td>' +
        '<td><button type="button" class="btn btn-sm btn-warning" onclick="editFunc(' + value + ')" id="edit_order_' + value + '" data-id="' + value + '" data-order_edit_info_' + value + '="Cliente: <b>' + name + ' (' + addCommas(loans_amount) + ')</b>" data-order_date_' + value + '=""  data-order_edit_' + value + '="' + name + '" data-due_amount_' + value + '="' + current_balance + '" data-old_opposition_no_' + value + '="' + opposition_no + '" data-old_opposition_route_' + value + '="' + opposition_route + '" data-order_interes_' + value + '="' + interes_amount + '" data-order_unpaid_payments_' + value + '="' + unpaid_payments + '" data-toggle="modal" data-target="#editModal" data-toggle="tooltip" data-placement="bottom" title="Agregar un adicional al prestamo"><i class="fa fa-money"></i> Editar</button></td>' + 

        '<td><a class="action-edit btn btn-danger btn-sm" href="' + base_url + 'delete/' + value + '" title="Cancelar" rel="leanModal"><i class="fa fa-close"></i> Levantamiento de oposición</a></td>' +

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
            { data: 'routes_id' },
            { data: 'loans_type' },
            { data: 'current_loanamount', 'className': 'danger' },        
            {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: '',
            },
        ],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };

            // Total over all pages
            totals = api
            .column(2)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            // Update footer
            $(api.column(2).footer()).html(addCommas(totals));
        },
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
            row.child( format(tr.data('child-value'), tr.data('child-name'), tr.data('child-loans_amount'), tr.data('child-current_balance'), tr.data('child-interes_amount'), tr.data('child-old_opposition_no'), tr.data('child-old_opposition_route'), tr.data('child-unpaid_payments'), tr.data('child-due_date')) ).show();
            tr.addClass('shown');
        }        
        
        //var due = '<?php echo $loans_origen == 'due' ? ', "due"' : '' ?>';
        //if( typeof tr.data('child-value') !== "undefined")
        //{ document.querySelector('ul.nav.nav-tabs li a').setAttribute("onclick","updateOrderTransactionsTable("+tr.data('child-value'), due+")"); }

        //document.querySelector('ul.nav.nav-tabs li a').click();
    });
  
    $('#example thead th').addClass('text-black');

    $('#editModal').on('shown.bs.modal', function () {
      $('#edit_opposition_no').focus();
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
    url = '<?php echo base_url() ?>opposition/pdf/loan_letter/'+_loanno;
    
    var w = 900;
    var h = 600;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open(url,"_blank","resizable=yes,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,fullscreen=no,dependent=no,copyhistory=no,width="+w+",height="+h+",left="+left+",top="+top);
  }
  function print_loan(_loanno)
  {
    url = '<?php echo base_url() ?>opposition/pdf/loan_1/'+_loanno;
    
    var w = 900;
    var h = 600;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open(url,"_blank","resizable=yes,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,fullscreen=no,dependent=no,copyhistory=no,width="+w+",height="+h+",left="+left+",top="+top);
  }
  function print_contract(_loanno)
  {
    url = '<?php echo base_url() ?>opposition/pdf/loan_contract/'+_loanno;
    
    var w = 900;
    var h = 600;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open(url,"_blank","resizable=yes,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,fullscreen=no,dependent=no,copyhistory=no,width="+w+",height="+h+",left="+left+",top="+top);
  }
  function print_receipt(_loanno, _transno)
  {
    url = '<?php echo base_url() ?>opposition/pdf/loan_receipt/'+_loanno+'/'+_transno;
    
    var w = 900;
    var h = 600;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open(url,"_blank","resizable=yes,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,fullscreen=no,dependent=no,copyhistory=no,width="+w+",height="+h+",left="+left+",top="+top);
  }
  
  // pay functions 
  function editFunc(id)
  {
    if(id) {
      var a = $('#edit_order_'+id).attr("data-order_edit_info_"+id);
      var order_date = $('#edit_order_'+id).attr("data-order_date_"+id);
      var old_opposition_no = $('#edit_order_'+id).attr("data-old_opposition_no_"+id);
      var old_opposition_route = $('#edit_order_'+id).attr("data-old_opposition_route_"+id);
      
      $('#edit_info').html(a);
      $('#txt_loansno').val(id);

      $('#old_opposition_no').val(old_opposition_no);
      $('#old_opposition_route').val(old_opposition_route);
      //$('#edit_date').val(order_date);

      //updateEditTable(id);
      $("#edit_opposition_no").focus();
    }
  }

  // updateOrderTransactionsTable functions 
  function updateOrderTransactionsTable(id, due = "")
  {
    if(id) {
      $.ajax({
          type: "GET",
          url: "<?php echo base_url() ?>ajax/getoppositiontransactions/index",
          data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'id':id,'due':due}
      }).done(function( msg ) { 
          $('#orderTransactionsTable').html(msg);
      }); 
    };  
  }

  function updateEditTable(id)
  {
    if(id) {
      $.ajax({
          type: "GET",
          url: "<?php echo base_url() ?>ajax/getoppositionedit/index",
          data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'id':id}
      }).done(function( msg ) { 
          $('#editTable').html(msg);
      }); 
    };  
  }

  // remove transaction functions 
  function removeTransactionFunc(loan_no, transactions_no, paid_amount, due_date)
  {
      $("#removeTransactionForm").on('submit', function() {
        var form = $(this);
        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: { "<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>", loan_no: loan_no, transactions_no: transactions_no, amount: paid_amount, due_date: due_date }, 
        }).done(function( msg ) { 
        });
      });
  }
  // remove edit functions 
  function removeEditFunc(loan_no, transactions_no, edit_opposition_no)
  {
      $("#removeEditForm").on('submit', function() {
        var form = $(this);
        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: { "<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>", loan_no: loan_no, transactions_no: transactions_no, amount: edit_opposition_no }, 
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