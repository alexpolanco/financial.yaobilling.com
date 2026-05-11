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
      <h1>Clientes</h1>
      <div class="breadcrumb">
        <a href="<?php echo base_url().'customer/create'; ?>" class="btn btn-lg btn-primary" title="Nuevo cliente">Nuevo Cliente</a>
        <a target="_blank" href="<?php echo base_url().'customer/pdf'; ?>" class="btn btn-lg btn-danger" title="Exportar a PDF">PDF</a>
        <!-- <a target="_blank" href="<?php echo base_url().'customer/excel'; ?>" class="btn btn-lg btn-primary" title="Exportar a Excel">Excel</a> -->
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
            <div class="box">
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
                echo form_open('customer/delete',$attributes) ?>
                <table id="example" class="display table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th align="left" >Nombre</th>
                      <th align="left" >Teléfono</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $arids = array();
                      foreach ( $recored as $_recored ) {
                  ?>
                      <tr data-child-value="<?php echo  $_recored->customer_id; ?>" data-child-is_active="<?php echo  $_recored->customer_is_active; ?>">
                        <td><?php echo $_recored->customer_first_name; ?></td>
                        <td><?php echo $_recored->customer_phone; ?></td>
                        <td></td>
                      </tr>
                  <?php 
                    }
                  ?>
                    </tbody>
                  <tfoot>
                  </tfoot>
                </table>
                
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
/* Formatting function for row details - modify as you need */
function format(value, is_active) {
  base_url = '<?php echo base_url() ?>customer/';
  is_act = 'yes';

  if(is_active == 'yes')
  { checked = 'checked'; is_act = 'no'; }
  else
  { checked = ''; is_act = 'yes'; }

  return (
      '<table cellpadding="4" cellspacing="0" border="0" style="padding-left:50px;width:100%">' +
      '<tr>' + 
      '<td><label class="switch">' +
        '<input type="checkbox"' + checked + ' onchange="javascript:window.location.href=\'' + base_url + 'change_action/' + value + '/' + is_act + '\'">' +
        '<span class="slider round"></span>' +
      '</label></td>' +
      '<td><a class="action-edit btn btn-info btn-sm" href="' + base_url + 'edit/' + value + '" class="action-edit" title="Editar"><i class="fa fa-edit"></i> Editar</a></td>' +
      '<td><a class="action-edit btn btn-danger btn-sm" href="' + base_url + 'delete/' + value + '" class="action-edit" title="Eliminar"><i class="fa fa-close"></i> Eliminar</a></td>' +
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
            { data: 'phone' },            
            {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: '',
            },
        ],
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
            row.child(format(tr.data('child-value'), tr.data('child-is_active'))).show();
            tr.addClass('shown');
        }
    });

  });
</script>
</body>
</html>