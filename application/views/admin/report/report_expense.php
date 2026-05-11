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
  <?php 
    $attributes = array('id' => 'frm','name'=>'frm');
    echo form_open('report/expense',$attributes) ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Reporte de gastos</h1>
      <div class="breadcrumb">
        <a target="_blank" href="<?php echo base_url().'report/pdf'.'/'.$loanstype.'/'.$dateform.'/'.$dateto.'/expense'; ?>" class="btn btn-danger btn-lg btn-lg" style="margin-right: 5px;">Exportar a PDF</a>
        <!-- <a target="_blank" href="<?php echo base_url().'report/excel'.'/'.$loanstype.'/'.$dateform.'/'.$dateto.'/expense'; ?>" class="btn btn-success btn-lg btn-lg" style="margin-right: 5px;">Exportar a Excel</a> -->
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) --> 
      <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">

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
                    <table id="example1" class="display" style="width:100%">
                      <thead>
                        <tr class="bg-blue">
                          <th width="15%">Fecha</th>
                          <th width="35%">Descripción</th>
                          <th width="15%">Monto</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $CI =& get_instance();
                          foreach ($order as $_date) {
                            ?>
                            <tr>
                              <td><?php echo date("d-m-Y", strtotime($_date->PaidDate)); ?></td>
                              <td><?php echo $_date->Description; ?></td>
                              <td><?php echo number_format($_date->Amount,2); ?></td>
                            </tr>
                            <?php
                          }
                        ?>      
                      </tbody>
                      <tfoot>
                        <tr class="bg-blue">
                          <th width="15%">Fecha</th>
                          <th width="35%">Descripción</th>
                          <th width="15%">Monto</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
      </div>
    </section>
    <?php echo form_close() ?>

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
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };

            // Total over all pages
            total_fixed = api
            .column(2)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            // Update footer
            $(api.column(2).footer()).html(addCommas(total_fixed));
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
  function search_record()
  {
    var dateform = document.getElementById('txtfrom_date').value;
    var dateto = document.getElementById('txtto_date').value;
    var loanstype = document.getElementById('txt_loanstype').value;

    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { "<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>", loanstype: loanstype, dateform: dateform, dateto: dateto }, 
      }).done(function( msg ) { 
    }); 
  }
  function addCommas(x) { const formatterDolar = new Intl.NumberFormat('en-EN', { style: 'decimal', minimumFractionDigits: 2, });
    return formatterDolar.format(x);
  }
  function removeCommas(x) {
    return parseFloat(x.replaceAll(/[\$,]/g, '').replaceAll('$', ''));
  }
</script>