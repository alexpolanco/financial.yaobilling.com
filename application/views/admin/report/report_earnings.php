<?php
  $loanstype = empty($_POST['txt_loanstype']) ? "Fijos" : $_POST['txt_loanstype'];
  $dateform = empty($_POST['txtfrom_date']) ? date('Y-m-d') : $_POST['txtfrom_date'];
  $dateto = empty($_POST['txtto_date']) ? date('Y-m-d') : $_POST['txtto_date'];
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
    <section class="content-header">
      <h1>Reporte de Egresos/Ingresos</h1>
      <div class="breadcrumb">
        <a target="_blank" href="<?php echo base_url().'report/pdf'.'/'.$loanstype.'/'.$dateform.'/'.$dateto.'/earnings'; ?>" class="btn btn-danger btn-lg" style="margin-right: 5px;">Exportar a PDF</a>
        <!-- <a target="_blank" href="<?php echo base_url().'report/excel'.'/'.$loanstype.'/'.$dateform.'/'.$dateto.'/earnings'; ?>" class="btn btn-success btn-lg" style="margin-right: 5px;">Exportar a Excel</a> -->
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) --> 
      <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
              <?php 
              $attributes = array('id' => 'frm','name'=>'frm');
              echo form_open('report/report_earnings',$attributes) ?>
              <div class="box-body">
                  <div class="col-xs-12 col-md-4">
                    <div class='box-body pad'>
                      <div class="row">
                        <div class="col-md-12">
                          <div id="title-loanstype">
                            <div class="input-group input-group-lg">    
                              <div class="input-group-btn">
                                <button type="button" class="btn btn-primary" id="btn_loanstype" onclick="getloanstype()"><i class="fa fa-search own-de-i"></i>Tipo de préstamo</button></div>
                              <input type="text" name="txt_loanstype" id="txt_loanstype" class="form-control " value="<?php echo $loanstype; ?>" onkeypress="return tabE(this,event,'txt_loanstype_duration')" placeholder="Tipo de préstamo..."  readonly />
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
                              <tr><td><h2 id="loanstype_1" class="lead" onclick="setloanstype(1, 'Fijos')">Interes Fijo</h2></td></tr>
                              <tr><td><h2 id="loanstype_2" class="lead" onclick="setloanstype(2, 'Capital')">Interes y Capital</h2></td></tr>
                              <tr><td><h2 id="loanstype_3" class="lead" onclick="setloanstype(3, 'Inversion')">Inversión</h2></td></tr>
                              <tr><td><h2 id="loanstype_4" class="lead" onclick="setloanstype(4, 'Regalia')">Regalía</h2></td></tr>
                              <tr><td><h2 id="loanstype_5" class="lead" onclick="setloanstype(5, 'Rapidos')">Rápidos</h2></td></tr>
                            </tbody>
                            <tfoot></tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-xs-12 col-md-4">
                    <div class='box-body pad'>
                      <div class="input-group input-group-lg">    
                        <div class="input-group-btn">
                          <button type="button" class="btn btn-primary" id="btn_from"><i class="fa fa-calendar"></i>Desde</button>
                        </div>
                        <input type="date" name="txtfrom_date" id="txtfrom_date" onchange="submitForm()" value="<?php echo $dateform; ?>" class="form-control" />
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-4">
                    <div class='box-body pad'>
                      <div class="input-group input-group-lg">    
                        <div class="input-group-btn">
                          <button type="button" class="btn btn-primary" id="btn_to"><i class="fa fa-calendar"></i>Hasta</button>
                        </div>
                        <input type="date" name="txtto_date" id="txtto_date" onchange="submitForm()" value="<?php echo $dateto; ?>" class="form-control" />
                      </div>
                    </div>
                  </div>
                </div>
              
                <div class="box-body table-responsive">
                  <h2 class="card-title">Gastos</h2>
                  <div class="row">
                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($expense[0]->total_amount,2); ?></h5>
                        <span class="description-text">TOTAL DE GASTOS</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="box-body table-responsive bg-gray">
                  <h2 class="card-title">Préstamos Fijos</h2>
                  <div class="row">
                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($loans[0]->loansfixed_total_amount,2); ?></h5>
                        <span class="description-text">PRESTAMOS ENTREGADOS</span>
                      </div>
                    </div>
                    
                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($additionals[0]->loansfixed_additional_amount,2); ?></h5>
                        <span class="description-text">ADICIONALES</span>
                      </div>
                    </div>
                    
                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($loans[0]->loansfixed_total_amount+$additionals[0]->loansfixed_additional_amount,2); ?></h5>
                        <span class="description-text">TOTAL ENTREGADO</span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($payments[0]->loansfixed_amount,2); ?></h5>
                        <span class="description-text">TOTAL COBRADO</span>
                      </div>
                    </div>

                  </div>
                </div>

                <div class="box-body table-responsive">
                  <h2 class="card-title">Préstamos Capital</h2>
                  <div class="row">
                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($loans[0]->loanscapital_total_amount,2); ?></h5>
                        <span class="description-text">PRESTAMOS ENTREGADOS</span>
                      </div>
                    </div>
                    
                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($additionals[0]->loanscapital_additional_amount,2); ?></h5>
                        <span class="description-text">ADICIONALES</span>
                      </div>
                    </div>
                    
                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($loans[0]->loanscapital_total_amount+$additionals[0]->loanscapital_additional_amount,2); ?></h5>
                        <span class="description-text">TOTAL ENTREGADO</span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($payments[0]->loanscapital_amount,2); ?></h5>
                        <span class="description-text">TOTAL COBRADO</span>
                      </div>
                    </div>

                  </div>
                </div>

                <div class="box-body table-responsive bg-gray">
                  <h2 class="card-title">Préstamos Inversión</h2>
                  <div class="row">
                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($loans[0]->loansinversion_total_amount,2); ?></h5>
                        <span class="description-text">PRESTAMOS ENTREGADOS</span>
                      </div>
                    </div>
                    
                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($additionals[0]->loansinversion_additional_amount,2); ?></h5>
                        <span class="description-text">ADICIONALES</span>
                      </div>
                    </div>
                    
                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($loans[0]->loansinversion_total_amount+$additionals[0]->loansinversion_additional_amount,2); ?></h5>
                        <span class="description-text">TOTAL ENTREGADO</span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($payments[0]->loansinversion_amount,2); ?></h5>
                        <span class="description-text">TOTAL COBRADO</span>
                      </div>
                    </div>

                  </div>
                </div>

                <div class="box-body table-responsive">
                  <h2 class="card-title">Préstamos Regalía</h2>
                  <div class="row">
                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($loans[0]->loanschristmas_total_amount,2); ?></h5>
                        <span class="description-text">PRESTAMOS ENTREGADOS</span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($additionals[0]->loanschristmas_additional_amount,2); ?></h5>
                        <span class="description-text">ADICIONALES</span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($loans[0]->loanschristmas_total_amount+$additionals[0]->loanschristmas_additional_amount,2); ?></h5>
                        <span class="description-text">TOTAL ENTREGADO</span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($payments[0]->loanschristmas_amount,2); ?></h5>
                        <span class="description-text">TOTAL COBRADO</span>
                      </div>
                    </div>

                  </div>
                </div>

                <div class="box-body table-responsive bg-gray">
                  <h2 class="card-title">Préstamos Rapidos</h2>
                  <div class="row">
                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($loans[0]->loansquickbusiness_total_amount,2); ?></h5>
                        <span class="description-text">PRESTAMOS ENTREGADOS</span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($additionals[0]->loansquickbusiness_additional_amount,2); ?></h5>
                        <span class="description-text">ADICIONALES</span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($loans[0]->loansquickbusiness_total_amount+$loans[0]->loansquickbusiness_additional_amount,2); ?></h5>
                        <span class="description-text">TOTAL ENTREGADO</span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($payments[0]->loansquickbusiness_amount,2); ?></h5>
                        <span class="description-text">TOTAL COBRADO</span>
                      </div>
                    </div>

                  </div>
                </div>

              <?php echo form_close() ?>
            </div>
        </div>
      </div>
    </section>
  </div>


  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
  <?php // include footer FIle

$this->load->view('admin/include/footer.php'); ?>   

<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

<script type="text/javascript">
  var totals = 0;

  $(document).ready(function () {
    $('#example1').DataTable({
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
        columnDefs: [
            {
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                render: function (data, type, row) {
                  totals += removeCommas(row[1]) + removeCommas(row[2]) + removeCommas(row[3]) + removeCommas(row[4]) + removeCommas(row[5]);
                  return data + addCommas(removeCommas(row[1]) + removeCommas(row[2]) + removeCommas(row[3]) + removeCommas(row[4]) + removeCommas(row[5]));
                },
                targets: 6,
            },
        ],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };

            // Total over all pages
            total_capital = api
            .column(1)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            total_christmas = api
            .column(2)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            total_fixed = api
            .column(3)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            total_inversion = api
            .column(4)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            total_quickbusiness = api
            .column(5)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            // Update footer
            $(api.column(1).footer()).html(addCommas(total_capital));
            $(api.column(2).footer()).html(addCommas(total_christmas));
            $(api.column(3).footer()).html(addCommas(total_fixed));
            $(api.column(4).footer()).html(addCommas(total_inversion));
            $(api.column(5).footer()).html(addCommas(total_quickbusiness));
            $(api.column(6).footer()).html(addCommas(totals/3));
        },
    });
  });
  
  // get loanstype
  function getloanstype()
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
    $('#txt_loanstype').val(frequency);
    $('#loanstype').css('display', 'none');
      
    submitForm();
  }
  function submitForm() {
    $("#frm").submit();
  }
  function addCommas(x) { const formatterDolar = new Intl.NumberFormat('en-EN', { style: 'decimal', minimumFractionDigits: 2, });
    return formatterDolar.format(x);
  }
  function removeCommas(x) {
    return parseFloat(x.replaceAll(/[\$,]/g, '').replaceAll('$', ''));
  }
</script>