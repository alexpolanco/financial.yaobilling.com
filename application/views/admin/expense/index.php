

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Gestionar
      <small>Gasto</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('') ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Gasto</li>
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

        <?php if(in_array('createExpense', $user_permission)): ?>
          <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Agregar Gasto</button>
          <br /> <br />
        <?php endif; ?>

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Gestionar Gastos</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Fecha</th>
                <th>Gasto</th>
                <th>Monto</th>
                <?php if(in_array('updateExpense', $user_permission) || in_array('deleteExpense', $user_permission)): ?>
                  <th>Acción</th>
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

<?php if(in_array('createExpense', $user_permission)): ?>
<!-- create brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-aqua-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
        <h4 class="modal-title">Agregar Gasto</h4>
      </div>

      <form role="form" action="<?php echo base_url('expense/create') ?>" method="post" id="createForm">

        <div class="modal-body">

          <div class="form-group">
            <label for="Description">Gasto</label>
            <input type="text" class="form-control" id="Description" name="Description" placeholder="Descripción del gasto" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="Amount">Monto</label>
            <input type="text" class="form-control" id="Amount" name="Amount" placeholder="Monto del gasto" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="PaidDate">Fecha de pago</label>
            <div class="input-group">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input type="text" name="PaidDate" id="PaidDate" class="form-control" value="<?php echo date('d-m-Y') ?>" autocomplete="off" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask="">
            </div>
            <!-- /.input group -->
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

<?php if(in_array('updateExpense', $user_permission)): ?>
<!-- edit brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-yellow-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
        <h4 class="modal-title">Editar Gasto</h4>
      </div>

      <form role="form" action="<?php echo base_url('expense/update') ?>" method="post" id="updateForm">
        <div class="modal-body">
          <div id="messages"></div>

          <div class="form-group">
            <label for="edit_Description">Gasto</label>
            <input type="text" class="form-control" id="edit_Description" name="edit_Description" placeholder="Descripción del gasto" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="edit_Amount">Monto</label>
            <input type="text" class="form-control" id="edit_Amount" name="edit_Amount" placeholder="Monto del gasto" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="edit_PaidDate">Fecha de pago</label>
            <div class="input-group">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input type="text" name="edit_PaidDate" id="edit_PaidDate" class="form-control" value="" autocomplete="off" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask="">
            </div>
            <!-- /.input group -->
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

<?php if(in_array('deleteExpense', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal modal-danger fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
        <h4 class="modal-title">Eliminar Gasto</h4>
      </div>

      <form role="form" action="<?php echo base_url('expense/remove') ?>" method="post" id="removeForm">
        <div class="modal-body">
          <p>¿Seguro que desea eliminar este gasto?</p>
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
var manageTable;

$(document).ready(function() {
  $("#expenseNav").addClass('active');

  $('#PaidDate').datepicker({'format': 'dd-mm-yyyy','autoclose': true});
  $('#edit_PaidDate').datepicker({'format': 'dd-mm-yyyy','autoclose': true});

  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    language: {
        url: '<?php echo base_url('assets/bower_components/datatables.net/Spanish.json') ?>'
    },      
    'ajax': 'fetchExpenseData',
    'order': []
  });

  // submit the create from 
  $("#createForm").unbind('submit').on('submit', function() {
    var form = $(this);

    // remove the text-danger
    $(".text-danger").remove();

    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(), // /converting the form data into array and sending it to server
      dataType: 'json',
      success:function(response) {

        manageTable.ajax.reload(null, false); 

        if(response.success === true) {
          $("#messages").html('<script>swal("¡Bien!", "'+response.messages+'", "success");<\/script>');

          // hide the modal
          $("#addModal").modal('hide');

          // reset the form
          $("#createForm")[0].reset();
          $("#createForm .form-group").removeClass('has-error').removeClass('has-success');

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
            $("#messages").html('<script>swal("¡Error!", "'+response.messages+'", "error");<\/script>');
          }
        }
      }
    }); 

    return false;
  });

});

// edit function
function editFunc(id)
{ 
  $.ajax({
    url: 'fetchExpenseDataById/'+id,
    type: 'post',
    dataType: 'json',
    success:function(response) {

      $("#edit_Description").val(response.Description);
      $("#edit_Amount").val(response.Amount);
      $("#edit_PaidDate").val(response.PaidDate);

      // submit the edit from 
      $("#updateForm").unbind('submit').bind('submit', function() {
        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action') + '/' + id,
          type: form.attr('method'),
          data: form.serialize(), // /converting the form data into array and sending it to server
          dataType: 'json',
          success:function(response) {

            manageTable.ajax.reload(null, false); 

            if(response.success === true) {
              $("#messages").html('<script>swal("¡Bien!", "'+response.messages+'", "success");<\/script>');

              // hide the modal
              $("#editModal").modal('hide');
              // reset the form 
              $("#updateForm .form-group").removeClass('has-error').removeClass('has-success');

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
                $("#messages").html('<script>swal("¡Error!", "'+response.messages+'", "error");<\/script>');
              }
            }
          }
        }); 

        return false;
      });

    }
  });
}

// remove functions 
function removeFunc(id)
{
  if(id) {
    $("#removeForm").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { id:id }, 
        dataType: 'json',
        success:function(response) {

          manageTable.ajax.reload(null, false); 

          if(response.success === true) {
            $("#messages").html('<script>swal("¡Bien!", "'+response.messages+'", "success");<\/script>');

            // hide the modal
            $("#removeModal").modal('hide');

          } else {
            $("#messages").html('<script>swal("¡Error!", "'+response.messages+'", "error");<\/script>'); 
          }
        }
      }); 

      return false;
    });
  }
}


</script>
