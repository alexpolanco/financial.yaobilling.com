<?php
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
      <h1>Reporte de Clientes</h1>
      <div class="breadcrumb">
        <a target="_blank" href="<?php echo base_url().'report/pdf/c/'.$dateform.'/'.$dateto.'/customers'; ?>" class="btn btn-danger btn-lg" style="margin-right: 5px;">Exportar a PDF</a>
        <!-- <a target="_blank" href="<?php echo base_url().'report/excel/c/'.$dateform.'/'.$dateto.'/customers'; ?>" class="btn btn-success btn-lg" style="margin-right: 5px;">Exportar a Excel</a> -->
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
              echo form_open('report/customers',$attributes) ?>
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
                          <th width="30%">Clientes</th>
                          <th width="10%">Cédula</th>
                          <th width="10%">Teléfono</th>
                          <th width="10%">Capital e interes</th>
                          <th width="10%">Regalía</th>
                          <th width="10%">Fijos</th>
                          <th width="10%">Inversión</th>
                          <th width="10%">Rápidos</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $CI =& get_instance();
                          foreach ($order as $_date) {
                            ?>
                            <tr>
                              <td><?php echo $_date->customer_first_name; ?></td>
                              <td><?php echo $_date->customer_personalid; ?></td>
                              <td><?php echo $_date->customer_phone; ?></td>
                              <td><?php echo $_date->loanscapital_active; ?></td>
                              <td><?php echo $_date->loanschristmas_active; ?></td>
                              <td><?php echo $_date->loansfixed_active; ?></td>
                              <td><?php echo $_date->loansinversion_active; ?></td>
                              <td><?php echo $_date->loansquickbusiness_active; ?></td>
                            </tr>
                            <?php
                          }
                        ?>      
                      </tbody>
                      <tfoot>
                        <tr class="bg-blue">
                          <th width="30%">Clientes</th>
                          <th width="10%">Cédula</th>
                          <th width="10%">Teléfono</th>
                          <th width="10%">Capital e interes</th>
                          <th width="10%">Regalía</th>
                          <th width="10%">Fijos</th>
                          <th width="10%">Inversión</th>
                          <th width="10%">Rápidos</th>
                        </tr>
                        </tfoot>
                    </table>
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
        columns: [
            {
                data: 'name',
            },
            {
                data: 'personalid',
            },
            {
                data: 'phone',
            },
            {
                data: 'capital',
                render: function (data, type, row, meta) {
                    var colour = data == "No" ? 'red' : 'green';
                    return type === 'display' ? '<span style="color:' + colour + '">' + data + '</span>' : data;
                },
            },
            {
                data: 'christmas',
                render: function (data, type, row, meta) {
                    var colour = data == "No" ? 'red' : 'green';
                    return type === 'display' ? '<span style="color:' + colour + '">' + data + '</span>' : data;
                },
            },
            {
                data: 'fixed',
                render: function (data, type, row, meta) {
                    var colour = data == "No" ? 'red' : 'green';
                    return type === 'display' ? '<span style="color:' + colour + '">' + data + '</span>' : data;
                },
            },
            {
                data: 'inversion',
                render: function (data, type, row, meta) {
                    var colour = data == "No" ? 'red' : 'green';
                    return type === 'display' ? '<span style="color:' + colour + '">' + data + '</span>' : data;
                },
            },
            {
                data: 'quickbusiness',
                render: function (data, type, row, meta) {
                    var colour = data == "No" ? 'red' : 'green';
                    return type === 'display' ? '<span style="color:' + colour + '">' + data + '</span>' : data;
                },
            },
        ],
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