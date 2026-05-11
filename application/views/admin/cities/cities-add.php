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
      <h1>
        Nueva ciudad
      </h1>
      <ol class="breadcrumb">
        <input type="submit" name="btnsubmit" class="btn btn-primary" value="Guardar" title="Guardar"/>
        <input type="button" value="Cancelar" class="btn btn-danger" onclick="javascript:window.location.href='<?php echo base_url().'cities' ?>'" title="Cancelar" />
      </ol>
    </section>

  <?php 
    $attributes = array('id' => 'frm','name'=>'frm');
      echo form_open_multipart('cities/create',$attributes); ?>
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
                        <label>Ciudad :</label>
                        <input type="text" name="txt_cities_name" class="form-control " placeholder="Nombre de la ciudad..." value="" />
                    </div>
                    <div class="form-group">
                        <label>Provincia :</label>
                        <select name="txt_district_id" class="form-control ">
                            
                         <?php 
                            foreach ($district as $value) {
                                ?>
                                <option value="<?php echo $value->district_id; ?>"><?php echo $value->district_name; ?></option>
                                <?php
                            }
                          ?>
                        </select>
                    </div>
                    
					          <div class="form-group">
                        <label>Descripción :</label>
                        <textarea name="txt_cities_description"  ></textarea>
                    </div>
                           
                    <div class="form-group">
                        <label>¿Está activa? :</label>
                        <input type="radio" name="txt_cities_is_active" checked value="yes" /> Si
                        <input type="radio" name="txt_cities_is_active" value="no" /> No
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