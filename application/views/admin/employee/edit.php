

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Editar Empleado</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="<?php echo base_url('employee') ?>">Empleados</a></li>
        <li class="active">Editar Empleado</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
          
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
      <form role="form" action="<?php echo base_url('employee/edit') ?>" method="post" class="form">			
		<?php //echo form_open_multipart('employee/edit') ?>
              <div class="pull-left">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Actualizar cambios</button>
              </div>
              <div class="pull-right">
                <a href="<?php echo base_url('employee') ?>" class="btn btn-warning btn-sm"><i class="fa fa-reply"></i> Regresar</a>
              </div><br><br>
          <div class="box">
              <div class="box-body">
			    <?php if (validation_errors()): ?>
					<script>
						swal("¡Atención!", "<?php echo preg_replace( "/\r|\n/", "", validation_errors() ); ?>", "warning");
					</script>
				<?php endif ?>
                <div class="form-group">
                  <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      Favor de llenar todos los campos con *
                  </div>
                </div>
				  
				<div class="row col-sm-12">
				  <div class="col-lg-6">
					<div class="form-group">
					  <label for="name" class="col-sm-4 control-label">Nombre*</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" id="name" name="name" placeholder="Nombre" value="<?php echo $employee_data['EmployeeName'] ?>" autocomplete="off">
					  </div>                
					</div>

					<div class="form-group">
					  <label for="personal_id" class="col-sm-4 control-label">C&eacute;dula*</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" id="personal_id" name="personal_id" placeholder="Cédula" value="<?php echo $employee_data['PersonalID'] ?>" data-inputmask='"mask": "999-9999999-9"' data-mask="" autocomplete="off">
					  </div>                
					</div>

					<div class="form-group">
					  <label for="address" class="col-sm-4 control-label">Direcci&oacute;n</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" id="address" name="address" placeholder="Dirección" value="<?php echo $employee_data['Address'] ?>"  autocomplete="off">
					  </div>                
					</div>

					<div class="form-group">
					  <label for="designation" class="col-sm-4 control-label">Cargo</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" id="designation" name="designation" placeholder="Cargo" value="<?php echo $employee_data['Designation'] ?>" autocomplete="off">
					  </div>                
					</div>

					<div class="form-group">
					  <label for="phone" class="col-sm-4 control-label">Tef&eacute;fono</label>
					  <div class="col-sm-8">
						<input type="tel" class="form-control" id="phone" name="phone" placeholder="Teléfono" value="<?php echo $employee_data['PhoneNo'] ?>" data-inputmask='"mask": "(999) 999-9999"' data-mask="" autocomplete="off">
					  </div>                
					</div>
					<div class="form-group">
					  <label for="mobile" class="col-sm-4 control-label">Célular</label>
					  <div class="col-sm-8">
					  <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Célular" value="<?php echo $employee_data['MobileNo'] ?>" data-inputmask='"mask": "(999) 999-9999"' data-mask="" autocomplete="off">
					  </div>                
					</div>

					<div class="form-group">
					  <label for="email" class="col-sm-4 control-label">Email</label>
					  <div class="col-sm-8">
						<input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" value="<?php echo $employee_data['Email'] ?>">
					  </div>                
					</div>                
					<div class="form-group">
					  <label for="website" class="col-sm-4 control-label">Website</label>
					  <div class="col-sm-8">
						<input type="url" class="form-control" id="website" name="website" placeholder="Website" autocomplete="off" value="<?php echo $employee_data['Website'] ?>">
					  </div>                
					</div>
              	</div>
				<div class="col-lg-6">
					<?php /*?><div class="form-group">
                      <label class="col-sm-4 control-label"></label>
					  <div class="col-sm-8">
						  <img src="<?php echo !empty($employee_data['image']) ? $employee_data['image'] : base_url("/assets/images/No-image-found.jpg"); ?>" width="100" height="100" class="img-circle">
					  </div>
					</div><?php */?>
                    <div class="form-group">
                      <label for="employee_image" class="col-sm-4 control-label">Subir Foto</label>
                      <div class="kv-avatar col-sm-8">
                        <div class="file-loading">
                           <input id="employee_image" name="employee_image" type="file">
                        </div>
                      </div>
                    </div>
				  </div>
	              <!-- /.col-lg-6 -->
			    </div>
			    <!-- /.row -->
              </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
              <div class="pull-left">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Actualizar cambios</button>
				<input type="hidden" id="emp_id" value="<?php echo $employee_data['EMP_ID'] ?>">
			  </div>
              <div class="pull-right">
                <a href="<?php echo base_url('employee') ?>" class="btn btn-warning btn-sm"><i class="fa fa-reply"></i> Regresar</a>
              </div><br><br>
            </form>

        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script type="text/javascript">
$(document).ready(function() {
    $("#groups").select2();

    $("#mainEmployeeNav").addClass('active');
    $("#manageEmployeeNav").addClass('active');
      
    $("[data-mask]").inputmask();
	$("#employee_image").fileinput({
        overwriteInitial: true,
        maxFileSize: 1500,
        showClose: false,
        showCaption: false,
        browseLabel: '&nbsp;Buscar foto',
        removeLabel: '',
        browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeTitle: 'Quitar imagen',
        elErrorContainer: '#kv-avatar-errors-1',
        msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img src="<?php echo !empty($employee_data['image']) ? base_url($employee_data['image']) : base_url("/assets/images/No-image-found.jpg"); ?>" width="100" alt="Empleado">',
        layoutTemplates: {main2: '{preview} ' +  /*btnCust +*/ ' {remove} {browse}'},
        allowedFileExtensions: ["jpg", "png", "gif"]
    });
});
    
function tabindexFix() {
    $("input[tabindex], textarea[tabindex]").each(function () {
        $(this).on("keypress", function (e) {
            if (e.keyCode === 13)
            {
                var nextElement = $('[tabindex="' + (this.tabIndex + 1) + '"]');
                if (nextElement.length) {
                    $('[tabindex="' + (this.tabIndex + 1) + '"]').focus();
                    e.preventDefault();
                } else
                    $('[tabindex="1"]').focus();
            }
        });
    });
}
</script>
