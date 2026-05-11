

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Configuraci&oacute;n
        <small>Cliente</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Configuraci&oacute;n</li>
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

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Actualizar Informaci&oacute;n</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php base_url('customers/setting') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="name">Nombre</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" value="<?php echo $customer_data['name'] ?>" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="personal_id">C&eacute;dula</label>
                  <input type="text" class="form-control" id="personal_id" name="personal_id" placeholder="Cédula" value="<?php echo $customer_data['personal_id'] ?>" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="address">Direcci&oacute;n</label>
                  <input type="text" class="form-control" id="address" name="address" placeholder="Dirección" value="<?php echo $customer_data[password_needs_rehash()] ?>" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="profession">Ocupaci&oacute;n</label>
                  <input type="text" class="form-control" id="profession" name="profession" placeholder="Ocupación" value="<?php echo $customer_data['profession'] ?>" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="phone">Teléfono</label>
                  <input type="text" class="form-control" id="phone" name="phone" placeholder="Teléfono" value="<?php echo $customer_data['phone'] ?>" autocomplete="off">
                </div>
              
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $customer_data['email'] ?>" autocomplete="off">
                </div>
              
                <div class="form-group">
                  <label for="notes">Comentarios</label>
                  <input type="text" class="form-control" id="notes" name="notes" placeholder="Comentarios" value="<?php echo $customer_data['notes'] ?>" autocomplete="off">
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="<?php echo base_url('customers/') ?>" class="btn btn-warning">Regresar</a>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
       
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 
