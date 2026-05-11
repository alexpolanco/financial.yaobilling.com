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
    echo form_open('report/logs',$attributes) ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Reporte de eventos</h1>
      <div class="breadcrumb">
        <a target="_blank" href="<?php echo base_url().'report/pdf'.'/'.$loanstype.'/'.$dateform.'/'.$dateto.'/logs'; ?>" class="btn btn-danger btn-lg btn-lg" style="margin-right: 5px;">Exportar a PDF</a>
        <!-- <a target="_blank" href="<?php echo base_url().'report/excel'.'/'.$loanstype.'/'.$dateform.'/'.$dateto.'/logs'; ?>" class="btn btn-success btn-lg btn-lg" style="margin-right: 5px;">Exportar a Excel</a> -->
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) --> 
      <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                  <div class="col-xs-12 col-md-12">
                    <div class='box-body pad'>
                      <div class="input-group input-group-lg">    
                        <div class="input-group-btn">
                          <button type="button" class="btn btn-primary" id="btn_from"><i class="fa fa-file"></i> Archivo</button>
                        </div>
                        <select name="archivos" id="events_files" class="form-control ">
                          <?php
                          $folder = "./application/logs/";
                          $files = scandir($folder);
                          foreach ($files as $file) {
                              $extension = pathinfo($file, PATHINFO_EXTENSION);
                              if ($extension === "log") {
                                $array = explode(".", $file);
                                echo "<option value='$file'>$array[0]</option>";
                              }
                          }
                          ?>
                          </select>
                      </div>
                    </div>
                  </div>
                  
                  <div class="col-xs-12 col-md-12">
                      <div class='box box-primary' >
                        <div class='box-body pad'>
                          
                        <div class="row">
                              <div class="col-md-12">
                                  <div id="title-event">
                                      <div class="input-group input-group-lg">    
                                          <div class="input-group-btn">
                                          <button type="button" class="btn btn-primary" onclick="getevent()"><i class="fa fa-search own-de-i"></i> Eventos</button>
                                        </div>
                                        <input type="text" name="txt_event" id="txt_event" class="form-control " value="<?php //echo $_loans[0]->loans_first_name; ?>" placeholder="Eventos..."  autocomplete="off" readonly />                                         
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <br />
                          <div class="row" id="events" style="display:none;">
                            <div class="col-md-12">
                              <table id="gridbox_events" class="display cell-border row-border hover" style="width:100%">
                                <thead>
                                  <tr><th>Seleccionar día</th></tr>
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

                <div class="box-body table-responsive">
                    <table id="example1" class="display" style="width:100%">
                      <thead>
                        <tr class="bg-blue">
                          <th width="15%">Fecha</th>
                          <th width="10%">Tipo de operación</th>
                          <th width="10%">Operación</th>
                          <th width="65%">Descripción</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $CI =& get_instance();
                          $folder = "./application/logs/";
                          $files = scandir($folder);
                          
                          foreach ($files as $file) {
                              $extension = pathinfo($file, PATHINFO_EXTENSION);
                              if ($extension === "log") {

                                $open_file = fopen($folder.$file, "r");
                                $lines = array();
      
                                while (!feof($open_file)) {
                                  $line = fgets($open_file);
                                  $lines[] = $line;
                                }
                                fclose($open_file);

                                $_file = explode("-", $file);

                                foreach ($lines as $order) {
                                  $_date = explode(";", $order);
                                  if (!empty($_date[0])) {
                                  ?>
                                  <tr>
                                    <td><?php echo date("d-m-Y h:i t", strtotime($_date[1])); ?></td>
                                    <td><?php echo ucfirst($_file[0]); ?></td>
                                    <td><?php echo $_date[0]; ?></td>
                                    <td><?php echo $_date[2]; ?></td>
                                  </tr>
                                  <?php
                                  }
                                }
                              }
                          }
                        ?>      
                      </tbody>
                      <tfoot>
                        <tr class="bg-blue">
                          <th width="15%">Fecha</th>
                          <th width="10%">Tipo de operación</th>
                          <th width="10%">Operación</th>
                          <th width="65%">Descripción</th>
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
        searching: true
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
  // get event
function getevent()
  {
    if ($('#events').css('display') == 'none')
    { $("#events").css('display', 'grid'); }
    else
    { $("#events").css('display', 'none'); }
  }
// set event
  function setevent(id,name)
  {
    $('#txt_event_id').val(id);
    $('#txt_event').val(name);
    $('#events').css('display', 'none');

    $.ajax({
        type: "GET",
        url: "<?php echo base_url() ?>ajax/getevent/index",
        data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'id':id}
    }).done(function( msg ) { 
        $('#gridbox_events').html(msg);
        $('#txt_event').val("");
        $('#events').css('display', 'none');

        $('#loandata').html('<section class="content"> <div class="error-page"> <h2 class="headline text-yellow"> <i class="fa fa-warning text-yellow"></i></h2><div class="error-content"><h3> Seleccione un tipo de préstamo para consultar y proceder a crear la oposición.</p> </div> </div> </section>');
    })

    document.getElementById('txt_loans').focus();
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