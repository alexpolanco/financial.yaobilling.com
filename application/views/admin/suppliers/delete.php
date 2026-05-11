

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Gestionar
        <small>Proveedor</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="<?php echo base_url('suppliers/') ?>">Proveedores</a></li>
        <li class="active">Eliminar</li>
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

          <h1>¿Seguro que quiere eliminar este proveedor?</h1>

          <form action="<?php echo base_url('suppliers/delete/'.$id) ?>" method="post">
            <input type="submit" class="btn btn-primary" name="confirm" value="Confirmar">
            <a href="<?php echo base_url('suppliers') ?>" class="btn btn-warning">Cancelar</a>
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
    $("#mainSupplierNav").addClass('active');
    $("#manageSuppliersNav").addClass('active');
  });
</script>