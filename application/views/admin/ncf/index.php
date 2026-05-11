

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Números de Comprobantes Fiscales (NCF)</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('') ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">NCF</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

       <?php if ($this->session->flashdata("success")): ?>
			<script>
				swal("¡Bien!", "<?php echo $this->session->flashdata('success'); ?>", "success");
			</script>
		<?php endif ?>
		<?php if ($this->session->flashdata("error")): ?>
			<script>
				swal("¡Error!", "<?php echo $this->session->flashdata('error'); ?>", "error");
			</script>
		<?php endif ?>

        <?php if(in_array('createNCF', $user_permission)): ?>
          <button class="btn btn-primary btn-sm pull-left" data-toggle="modal" data-target="#addNCFModal">Agregar NCF</button>
          <br><br>
        <?php endif; ?>
        <div class="box">
          <div class="box-body">
            <table id="ncfTable" class="table table-striped table-bordered">
              <thead>
              <tr>
                <th>NCF</th>
                <th>Secuencial</th>
                <th>Último NCF Utilizado</th>
                <?php if(in_array('updateNCF', $user_permission) || in_array('deleteNCF', $user_permission)): ?>
                  <th>Acci&oacute;n</th>
                <?php endif; ?>
              </tr>
              </thead>

            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php if(in_array('createNCF', $user_permission)): ?>
<!-- create NCF modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addNCFModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Agregar NCF</h4>
      </div>

      <form role="form" action="<?php echo base_url('ncf/create') ?>" method="post" id="createNCFForm">

        <div class="modal-body">

          <div class="form-group">
            <label for="ncf_name">NCF</label>
            <input type="text" class="form-control" id="ncf_name" name="ncf_name" placeholder="Nombre del NCF" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="ncf_serie">Abreviatura</label>
            <input type="text" class="form-control" id="ncf_serie" name="ncf_serie" placeholder="Serie del NCF" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="ncf_sequence">Secuencia</label>
            <input type="text" class="form-control" id="ncf_sequence" name="ncf_sequence" placeholder="Número de secuencia del NCF" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="sequence_due_date">Vencimiento de la Secuencia</label>
            <input type='text' class="form-control" id="sequence_due_date" name="sequence_due_date" placeholder="Selecionar fecha" data-provide="datepicker" autocomplete="off" autofocus data-inputmask="'alias': 'dd-mm-yyyy'" data-mask="" aria-describedby="sequence_due_date-addon">
          </div>
          <div class="form-group">
            <label for="last_ncf">Último NCF</label>
            <input type="text" class="form-control" id="last_ncf" name="last_ncf" placeholder="Último NCF utilizado" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="active">Estado</label>
            <select class="form-control" id="active" name="active">
              <option value="1">Activo</option>
              <option value="2">Inactivo</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>

      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>

<?php if(in_array('updateNCF', $user_permission)): ?>
<!-- edit NCF modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editNCFModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Editar NCF</h4>
      </div>

      <form role="form" action="<?php echo base_url('ncf/update') ?>" method="post" id="updateNCFForm">

        <div class="modal-body">
          <div id="messages"></div>

          <div class="form-group">
            <label for="edit_ncf_name">NCF</label>
            <input type="text" class="form-control" id="edit_ncf_name" name="edit_ncf_name" placeholder="Nombre de la NCF" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="edit_ncf_serie">Abreviatura</label>
            <input type="text" class="form-control" id="edit_ncf_serie" name="edit_ncf_serie" placeholder="Abreviatura del NCF" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="edit_ncf_sequence">Secuencia</label>
            <input type="text" class="form-control" id="edit_ncf_sequence" name="edit_ncf_sequence" placeholder="Número de secuencia del NCF" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="edit_last_ncf">Último NCF</label>
            <input type="text" class="form-control" id="edit_last_ncf" name="edit_last_ncf" placeholder="Último NCF utilizado" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="edit_sequence_due_date">Vencimiento de la Secuencia</label>
            <input type='text' class="form-control" id="edit_sequence_due_date" name="edit_sequence_due_date" placeholder="Selecionar fecha" data-provide="datepicker" autocomplete="off" autofocus data-inputmask="'alias': 'dd-mm-yyyy'" data-mask="" aria-describedby="edit_sequence_due_date-addon">
          </div>
          <div class="form-group">
            <label for="edit_active">Estado</label>
            <select class="form-control" id="edit_active" name="edit_active">
              <option value="1">Activo</option>
              <option value="2">Inactivo</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>

      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>

<?php if(in_array('deleteNCF', $user_permission)): ?>
<!-- remove NCF modal -->
<div class="modal modal-danger fade in" tabindex="-1" role="dialog" id="removeNCFModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Eliminar NCF</h4>
      </div>

      <form role="form" action="<?php echo base_url('ncf/remove') ?>" method="post" id="removeNCFForm">
        <div class="modal-body">
          <p>¿Seguro que desea eliminar este NCF?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>



<script type="text/javascript">
var ncfTable;

$(document).ready(function() {

  $("#ncfNav").addClass('active');
  $("#mainSettingNav").addClass('active');
  $('#sequence_due_date').datepicker({
      'format':     'dd-mm-yyyy',
      'autoclose':  'true'
  });
  $('#edit_sequence_due_date').datepicker({
      'format':     'dd-mm-yyyy',
      'autoclose':  'true'
  });
  $('#addNCFModal').on('shown.bs.modal', function () {
    $('#ncf_name').focus();
  });
  $('#editNCFModal').on('shown.bs.modal', function () {
    $('#edit_ncf_name').focus();
  });
    
  // initialize the datatable 
  ncfTable = $('#ncfTable').DataTable({
    language: {
        url: '<?php echo base_url('assets/bower_components/datatables.net/Spanish.json') ?>'
    },      
    'ajax': 'fetchNCFData',
    'responsive': 'true',
    'order': []
  });

  // submit the create from 
  $("#createNCFForm").unbind('submit').on('submit', function() {
    var form = $(this);

    // remove the text-danger
    $(".text-danger").remove();

    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(), // /converting the form data into array and sending it to server
      dataType: 'json',
      success:function(response) {

        ncfTable.ajax.reload(null, false); 

        if(response.success === true) {
          $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
          '</div>');


          // hide the modal
          $("#addNCFModal").modal('hide');

          // reset the form
          $("#createNCFForm")[0].reset();
          $("#createNCFForm .form-group").removeClass('has-error').removeClass('has-success');

        } else {

          if(response.messages instanceof Object) {
            $.each(response.messages, function(index, value) {
              var id = $("#"+index);

              id.closest('.form-group')
              .removeClass('has-error')
              .removeClass('has-success')
              .addClass(value.length > 0 ? 'has-error' : 'has-success');
              
              id.after(value);

            });
          } else {
            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>');
          }
        }
      }
    }); 

    return false;
  });


});

function editNCF(id)
{ 
  $.ajax({
    url: 'fetchNCFDataById/'+id,
    type: 'post',
    dataType: 'json',
    success:function(response) {

      $("#edit_ncf_name").val(response.name);
      $("#edit_ncf_serie").val(response.serie);
      $("#edit_ncf_sequence").val(response.sequence);
      $("#edit_sequence_due_date").val(response.sequence_due_date);
      $("#edit_last_ncf").val(response.last_ncf);
      $("#edit_active").val(response.active);

      // submit the edit from 
      $("#updateNCFForm").unbind('submit').bind('submit', function() {
        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action') + '/' + id,
          type: form.attr('method'),
          data: form.serialize(), // /converting the form data into array and sending it to server
          dataType: 'json',
          success:function(response) {

            ncfTable.ajax.reload(null, false); 

            if(response.success === true) {
              $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
              '</div>');


              // hide the modal
              $("#editNCFModal").modal('hide');
              // reset the form 
              $("#updateNCFForm .form-group").removeClass('has-error').removeClass('has-success');

            } else {

              if(response.messages instanceof Object) {
                $.each(response.messages, function(index, value) {
                  var id = $("#"+index);

                  id.closest('.form-group')
                  .removeClass('has-error')
                  .removeClass('has-success')
                  .addClass(value.length > 0 ? 'has-error' : 'has-success');
                  
                  id.after(value);

                });
              } else {
                $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                '</div>');
              }
            }
          }
        }); 

        return false;
      });

    }
  });
}

function removeNCF(id)
{
  if(id) {
    $("#removeNCFForm").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { ncf_id:id }, 
        dataType: 'json',
        success:function(response) {

          ncfTable.ajax.reload(null, false); 

          if(response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');

            // hide the modal
            $("#removeNCFModal").modal('hide');

          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
          }
        }
      }); 

      return false;
    });
  }
}


</script>
