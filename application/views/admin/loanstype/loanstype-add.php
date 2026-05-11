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
      echo form_open_multipart('loanstype/create',$attributes); ?>
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Nuevo tipo de préstamo
      </h1>
      <ol class="breadcrumb">
        <input type="submit" name="btnsubmit" class="btn btn-primary" value="Guardar" title="Guardar"/>
        <input type="button" value="Cancelar" class="btn btn-danger" onclick="javascript:window.location.href='<?php echo base_url().'loanstype' ?>'" title="Cancelar" />
      </ol>
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
                        <label>Tipo de préstamo :</label>
                        <input type="text" name="txt_loanstype_name" class="form-control " placeholder="Nombre del tipo de préstamo..." value="" />
                    </div>
                    <div class="form-group">
                        <label>Frecuencia :</label>
                        <select name="txt_loanstype_frequency" class="form-control ">
                            <option value="Diario">Diario</option>
                            <option value="Semanal" selected>Semanal</option>
                            <option value="Quincenal">Quincenal</option>
                            <option value="Mensual">Mensual</option>
                            <option value="Libre">Libre</option>
                        </select>
                    </div>
                    
		            <div class="form-group">
                        <label>Duración :</label>
                        <input type="number" name="txt_loanstype_duration" class="form-control " placeholder="Duración del préstamo..." value="10" min="1" />
                    </div>
                    
		            <div class="form-group">
                        <label>Interes :</label>
                        <input type="number" name="txt_loanstype_interes" class="form-control " placeholder="Tasa de interes del préstamo..." value="30" min="1" />
                    </div>
                    
		            <div class="form-group">
                        <label>Modelo :</label>
                        <select name="txt_loanstype_type" class="form-control ">
                            <option value="Americano">Americano</option>
                            <option value="Alemán">Alemán</option>
                            <option value="Frances">Frances</option>
                            <option value="Intéres fijo">Intéres fijo</option>
                            <option value="Intéres y capital">Intéres y capital</option>
                            <option value="Inversión">Inversión</option>
                            <option value="Regalía">Regalía</option>
                            <option value="Simple" selected>Simple</option>
                        </select>
                    </div>
                           
                    <div class="form-group">
                        <label>¿Está activa? :</label>
                        <input type="radio" name="txt_loanstype_is_active" checked value="yes" /> Si
                        <input type="radio" name="txt_loanstype_is_active" value="no" /> No
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

 <?php 
	// include footer file
 
 $this->load->view('admin/include/footer.php'); ?>