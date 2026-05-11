

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
	  <?php if ($unpaid_invoice): ?>
      <div class="alert alert-warning alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  Estimado(a) cliente, la factura del mes se ha generado. <a class="btn btn-default btn-sm" href="<?php echo base_url('company/billing') ?>" style="margin-top: -5px; border: 0px; box-shadow: none; color: rgb(243, 156, 18); font-weight: 600; background: rgb(255, 255, 255);"> ¡Pagar factura! </a>
	  </div>
	  <?php endif ?>
	  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Empleados</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('') ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Empleados</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
        <div id="messages">
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
        </div>

          <?php if(in_array('createEmployee', $user_permission)): ?>
            <a href="<?php echo base_url('employee/create') ?>" class="btn btn-primary btn-sm pull-left">Agregar Empleado</a>
            <br><br>
          <?php endif; ?>
            
          <div class="box">
            <div class="box-body">
              <table id="employeeTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                  <th>Nombre</th>
                  <?php if(in_array('updateEmployee', $user_permission) || in_array('deleteEmployee', $user_permission)): ?>
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

<?php if(in_array('viewEmployee', $user_permission)): ?>
<!-- remove transaction modal -->
<div class="modal fade in" tabindex="-1" role="dialog" id="viewEmployeeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Perfil de Empleado</h4>
      </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>

<?php if(in_array('deleteEmployee', $user_permission)): ?>
<!-- remove transaction modal -->
<div class="modal modal-danger fade in" tabindex="-1" role="dialog" id="removeEmployeeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Eliminar Empleado</h4>
      </div>

      <form role="form" action="<?php echo base_url('employee/remove') ?>" method="post" id="removeEmployeeForm">
        <div class="modal-body">
          <p>¿Seguro que quiere eliminar este empleado?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Eliminar</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>

<script type="text/javascript">
var employeeTable;
var base_url = "<?php echo base_url(); ?>";
    
$(document).ready(function() {
    
  // initialize the datatable 
  employeeTable = $('#employeeTable').DataTable({
    'language': {
        'url': '<?php echo base_url('assets/bower_components/datatables.net/Spanish.json') ?>'
    },
    'ajax': base_url + 'employee/fetchEmployeeData',
    'responsive': 'true',
    'order': []
  });

  $("#mainEmployeeNav").addClass('active');
  $("#manageEmployeeNav").addClass('active');
});
    
// view employee functions 
function viewEmployeeFunc(id)
{
  if(id) {
      
      $.ajax({
        url: base_url + 'employee/fetchEmployeeDataByID/' + id,
        data: {emp_id:id }, // /converting the form data into array and sending it to server
        dataType: 'json',
        success:function(response) {
            
            $('.modal-body').html('<table class="table table-bordered table-condensed table-hovered">' +
                '<tr>'+
                  '<th>Nombre</th>'+
                  '<td>'+response.EmployeeName+'</td>'+
                '</tr>'+
                '<tr>'+
                  '<th>C&eacute;dula</th>'+
                  '<td>'+response.PersonalID+'</td>'+
                '</tr>'+
                '<tr>'+
                  '<th>Direcci&oacute;n</th>'+
                  '<td>'+response.Address+'</td>'+
                '</tr>'+
                '<tr>'+
                  '<th>Ocupaci&oacute;n</th>'+
                  '<td>'+response.Designation+'</td>'+
                '</tr>'+
                '<tr>'+
                  '<th>Tel&eacute;fono</th>'+
                  '<td>'+response.PhoneNo+', '+response.MobileNo+'</td>'+
                '</tr>'+
                '<tr>'+
                  '<th>Email</th>'+
                  '<td>'+response.Email+', '+response.Website+'</td>'+
                '</tr>'+
              '</table>');
        }
      });
  }
}
    
// remove functions 
function removeFunc(id)
{
  $('.modal-body').html('<p>¿Seguro que quiere eliminar este empleado?</p>');
  if(id) {
    $("#removeEmployeeForm").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();
      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { emp_id:id }, 
        dataType: 'json',
        success:function(response) {
            
          if(response.success === true) {
		    $("#messages").html('<script>swal("¡Bien!", "'+response.messages+'", "success");<\/script>');   
            // hide the modal
            $("#removeEmployeeModal").modal('hide');
          } else {
            $("#messages").html('<script>swal("¡Error!", "'+response.messages+'", "error");<\/script>');
          }
          employeeTable.ajax.reload();

        }
      }); 
      
      return false;
    });
  }
}
</script>
