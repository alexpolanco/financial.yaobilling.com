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
      echo form_open_multipart('loanstype/update/'.$this->uri->segment(3),$attributes); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Editar tipo de préstamo: <?php echo $recored['loanstype_name']; ?>
      </h1>
      <div class="breadcrumb">
        <input type="submit" name="btnsubmit" class="btn btn-primary" value="Guardar" title="Guardar"/>
        <input type="button" value="Cancelar" class="btn btn-danger" onclick="javascript:window.location.href='<?php echo base_url().'loanstype' ?>'" title="Cancelar" />
      </div>
    </section>

     <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-body">

                <?php 
                  if (isset($error)) {
                    ?>
                    <div class="alert alert-danger alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h4>  <i class="icon fa fa-ban"></i> ¡Error!</h4>
                      <?php echo $error; ?>
                    </div>
                    <?php
                  }
                ?>

                <?php if(validation_errors() != false){ ?>
                  <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> ¡Error!</h4>
                      <?php echo validation_errors(); ?>
                  </div>
                <?php } ?>

			         <div class="form-group">
                        <label>Nombre :</label>
                        <input type="text" name="txt_loanstype_name" class="form-control " placeholder="Nombre del tipo de préstamo..." value="<?php echo $recored['loanstype_name']; ?>" />
                    </div>
                    <div class="form-group">
                        <label>Frecuencia :</label>
                        <select name="txt_loanstype_frequency" class="form-control ">
                            <option value="Diario" <?php if($recored['loanstype_frequency'] ==  'Diario' ) echo 'selected'; ?>>Diario</option>
                            <option value="Semanal" <?php if($recored['loanstype_frequency'] ==  'Semanal' ) echo 'selected'; ?>>Semanal</option>
                            <option value="Quincenal" <?php if($recored['loanstype_frequency'] ==  'Quincenal' ) echo 'selected'; ?>>Quincenal</option>
                            <option value="Mensual" <?php if($recored['loanstype_frequency'] ==  'Mensual' ) echo 'selected'; ?>>Mensual</option>
                            <option value="Libre" <?php if($recored['loanstype_frequency'] ==  'Libre' ) echo 'selected'; ?>>Libre</option>
                        </select>
                    </div>
                    
		            <div class="form-group">
                        <label>Duración :</label>
                        <input type="number" name="txt_loanstype_duration" class="form-control " placeholder="Duración del préstamo..." value="<?php echo $recored['loanstype_duration']; ?>" min="1" />
                    </div>
                    
		            <div class="form-group">
                        <label>Interes :</label>
                        <input type="number" name="txt_loanstype_interes" class="form-control " placeholder="Tasa de interes del préstamo..." value="<?php echo $recored['loanstype_interes']; ?>" min="1" />
                    </div>
                    
		            <div class="form-group">
                        <label>Modelo :</label>
                        <select name="txt_loanstype_type" class="form-control ">
                            <option value="Americano" <?php if($recored['loanstype_type'] ==  'Americano' ) echo 'selected'; ?>>Americano</option>
                            <option value="Alemán" <?php if($recored['loanstype_type'] ==  'Alemán' ) echo 'selected'; ?>>Alemán</option>
                            <option value="Frances" <?php if($recored['loanstype_type'] ==  'Frances' ) echo 'selected'; ?>>Frances</option>
                            <option value="Intéres fijo" <?php if($recored['loanstype_type'] ==  'Intéres fijo' ) echo 'selected'; ?>>Intéres fijo</option>
                            <option value="Intéres y capital" <?php if($recored['loanstype_type'] ==  'Intéres y capital' ) echo 'selected'; ?>>Intéres y capital</option>
                            <option value="Inversión" <?php if($recored['loanstype_type'] ==  'Inversión' ) echo 'selected'; ?>>Inversión</option>
                            <option value="Regalía" <?php if($recored['loanstype_type'] ==  'Regalía' ) echo 'selected'; ?>>Regalía</option>
                            <option value="Simple" <?php if($recored['loanstype_type'] ==  'Simple' ) echo 'selected'; ?>>Simple</option>
                        </select>
                    </div>     
                     <div class="form-group">
                        <label>¿Está activa? :</label>
                        <input type="radio" name="txt_loanstype_is_active" <?php if($recored['loanstype_is_active'] == 'yes') echo 'checked'; ?> placeholder="Está activa..." value="yes" /> Si
                        <input type="radio" name="txt_loanstype_is_active" <?php if($recored['loanstype_is_active'] == 'no') echo 'checked'; ?> placeholder="Está activa..." value="no" /> No
                    </div>
              </div>
            </div>
          </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  <?php echo form_close(); ?>

  </div>
  <!-- /.content-wrapper -->

 <?php // include footer FIle 
 
 $this->load->view('admin/include/footer.php'); ?>			

