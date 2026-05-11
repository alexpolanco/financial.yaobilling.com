<?php
// Add FIle
// include common file
$this->load->view('admin/include/common.php'); 
// include header file
$this->load->view('admin/include/header.php'); 
// include sidebar file  
$this->load->view('admin/include/sidebar.php');

$dateform = empty($_POST['txtfrom_date']) ? date('Y-m-d') : $_POST['txtfrom_date'];
$dateto = empty($_POST['txtto_date']) ? date('Y-m-d') : $_POST['txtto_date'];
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Gastos</h1>
      <div class="breadcrumb">
      <button class="btn btn-lg btn-primary" data-toggle="modal" data-target="#addModal">Agregar Gasto</button>
      <!-- <a href="<?php echo base_url().'expense/create'; ?>" class="btn btn-lg btn-primary" title="Nuevo gasto">Nuevo Gasto</a> -->
      <!-- <a target="_blank" href="<?php echo base_url().'expense/pdf'.'/'.$dateform.'/'.$dateto; ?>" class="btn btn-lg btn-danger" title="Exportar a PDF">Exportar PDF</a>
      <a target="_blank" href="<?php echo base_url().'expense/excel'.'/'.$dateform.'/'.$dateto; ?>" class="btn btn-lg btn-success" title="Exportar a Excel">Exportar Excel</a> -->
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
            <div class="box">
              <div class="box-body">
              <?php if($this->session->flashdata('success') != false): ?>
                  <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>  <i class="icon fa fa-check"></i> ¡Bien!</h4>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php endif ?>
                <?php if ($this->session->flashdata("error")): ?>
                  <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>  <i class="icon fa fa-check"></i> Error!</h4>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php endif ?>

              <?php 
                $attributes = array('id' => 'frm','name'=>'frm');
                echo form_open('expense/delete',$attributes) ?>
                <table id="manageTable" class="display table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Fecha</th>
                      <th>Descripción del gasto</th>
                      <th>Monto</th>
                      <th>Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $arids = array();
                  foreach ( $recored as $_recored ) {
                  ?>
                    <tr>
                      <td><?php echo $_recored->PaidDate; ?></td>
                      <td><?php echo $_recored->Description; ?></td>
                      <td><?php echo $_recored->Amount; ?></td>
                      <td>
                        <button type="button" class="action-edit btn btn-info btn-sm" onclick="getExpense(<?php echo $_recored->Expense_ID; ?>)" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>
                        <button type="button" class="action-edit btn btn-danger btn-sm" onclick="removeFunc(<?php echo $_recored->Expense_ID; ?>)" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>
                      </td>
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

  <!-- create brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-aqua-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
        <h4 class="modal-title">Agregar Gasto</h4>
      </div>
      
      <?php 
      $attributes = array('id' => 'createForm','name'=>'createForm','class'=>'');
      echo form_open('expense/create',$attributes) ?>

      <div class="modal-body">
        <div id="messages"></div>

          <div class="form-group">
            <label for="Description">Gasto</label>
            <input type="text" class="form-control" id="Description" name="Description" onkeypress="return tabE(this,event,'Amount')" placeholder="Descripción del gasto" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="Amount">Monto</label>
            <input type="number" class="form-control" id="Amount" name="Amount" onkeypress="return tabE(this,event,'PaidDate')" placeholder="Monto del gasto" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="PaidDate">Fecha de pago</label>
            <div class="input-group">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input type="date" name="PaidDate" id="PaidDate" class="form-control" onkeypress="return tabE(this,event,'fsubmit')" value="<?php echo date('Y-m-d') ?>" autocomplete="off">
            </div>
            <!-- /.input group -->
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="fsubmit" class="btn btn-primary">Guardar cambios</button>
        </div>

      <?php echo form_close() ?>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- edit brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-yellow-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
        <h4 class="modal-title">Editar Gasto</h4>
      </div>

      <?php 
      $attributes = array('id' => 'updateForm','name'=>'updateForm','class'=>'');
      echo form_open('expense/update',$attributes) ?>

        <div class="modal-body">
          <div id="messages"></div>

          <div class="form-group">
            <label for="edit_Description">Gasto</label>
            <input type="text" class="form-control" id="edit_Description" name="edit_Description" onkeypress="return tabE(this,event,'edit_Amount')" placeholder="Descripción del gasto" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="edit_Amount">Monto</label>
            <input type="number" class="form-control" id="edit_Amount" name="edit_Amount" onkeypress="return tabE(this,event,'edit_PaidDate')" placeholder="Monto del gasto" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="edit_PaidDate">Fecha de pago</label>
            <div class="input-group">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input type="date" name="edit_PaidDate" id="edit_PaidDate" class="form-control" onkeypress="return tabE(this,event,'fesubmit')" value="" autocomplete="off">
            </div>
            <!-- /.input group -->
          </div>
        </div>

        <div class="modal-footer">
          <input type="hidden" name="expense_id" id="expense_id" value="" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="fesubmit" class="btn btn-primary">Guardar cambios</button>
        </div>

      <?php echo form_close() ?>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- remove brand modal -->
<div class="modal modal-danger fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
        <h4 class="modal-title">Eliminar Gasto</h4>
      </div>

      <?php 
      $attributes = array('id' => 'removeForm','name'=>'removeForm','class'=>'');
      echo form_open('expense/delete',$attributes) ?>
        <div class="modal-body">
          <p>¿Seguro que desea eliminar este gasto?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      <?php echo form_close() ?>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php // include footer FIle
$this->load->view('admin/include/footer.php'); ?>	

<script type="text/javascript">
//var manageTable = $('#manageTable').DataTable();

$(document).ready(function() {
  $("#expenseNav").addClass('active');
  
  $('#addModal').on('shown.bs.modal', function () {
    $('#Description').focus();
  });

  $('#editModal').on('shown.bs.modal', function () {
    $('#edit_Description').focus();
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

        console.log("s: " + response.success);
        console.log("m: " + response.messages);
        
        if(response.success === true) {
          $("#messages").html('¡Bien!<br>'+response.messages+'');

          // hide the modal
          $("#addModal").modal('hide');

          // reset the form
          $("#createForm")[0].reset();
          $("#createForm .form-group").removeClass('has-error').removeClass('has-success');

          window.location.reload();

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
            $("#messages").html('¡Error!<br>'+response.messages+'');
          }
        }
      }
    }); 

    return false;
  });

});

// edit function
function getExpense(id)
{
  $('#expense_id').val(id);
  $.ajax({
      type: "GET",
      url: "<?php echo base_url() ?>ajax/getexpense/index",
      data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'id':id}
  }).done(function( response ) { 
      const obj = JSON.parse(response);
      $("#edit_Description").val(obj.Description);
			$("#edit_Amount").val(obj.Amount);
      $("#edit_PaidDate").val(obj.PaidDate);
  })
}
function editFunc(id)
{ 
  $.ajax({
    url: '<?php echo base_url() ?>expense/fetchExpenseDataById/'+id,
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

            if(response.success === true) {
              $("#messages").html('¡Bien!<br>'+response.messages+'');

              // hide the modal
              $("#editModal").modal('hide');
              // reset the form 
              $("#updateForm .form-group").removeClass('has-error').removeClass('has-success');

              $("table.display").DataTable().ajax.reload();

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
                $("#messages").html('¡Error!<br>'+response.messages+'');
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
    $("#removeForm").on('submit', function() {

      var form = $(this);

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { "<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>", id: id }, 
      }).done(function( response ) { 

      });
    });
}

function tabE(obj, e, ctrl) { 
    var e = (typeof event != 'undefined') ? window.event : e; // IE : Moz 
    
    if (e.keyCode == 13) {
        document.getElementById(ctrl).focus();
        return false;
    }
}
</script>
</body>
</html>

