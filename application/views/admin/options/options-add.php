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
        Atributos
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Atributos</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Agregar</h3>
                <a href="<?php echo base_url().'options'; ?>" class="btn btn-primary btn-small pull-right">Regresar</a>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <?php if(validation_errors() != false){ ?>
                <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h4><i class="icon fa fa-ban"></i> ¡Error!</h4>
                    <?php echo validation_errors(); ?>
                </div>
                <?php } ?>
              <?php 
                $attributes = array('id' => 'frm','name'=>'frm');
                  echo form_open('options/create',$attributes); ?>

                    <div class="form-group">
                        <label>Categoría :</label>
                        <select name="txt_parent_id" class="form-control">
                          <option value="0">Seleccionar categoría</option>
                           <?php 
                              $CI =& get_instance();
                              $parent_op = $CI->get_all_parent();
                              foreach ($parent_op as $value) {
                                ?>
                                <option value="<?php echo $value->option_id; ?>"><?php echo $value->option_name; ?></option>
                                <?php
                              }
                            ?>
                        </select>
                         
                    </div>
					          <div class="form-group">
                        <label>Atributo :</label>
                        <input type="text" name="txt_option_name" class="form-control " placeholder="Nombre del atributo..." value="" />
                    </div>
					         
					          <div class="form-group">
                        <label>¿Está activa? :</label>
                        <input type="radio" name="txt_option_is_active" checked value="yes" /> Si
                        <input type="radio" name="txt_option_is_active"  value="no" /> No
                    </div>
					            
                    <div class="form-group">
                      <input type="submit" name="btnsubmit" class="btn btn-primary" value="Guardar"/>
                      <input type="button" title="Cancelar" value="Cancelar" class="btn btn-danger" onclick="javascript:window.location.href='<?php echo base_url().'options' ?>'" />
                    </div>
              <?php echo form_close(); ?>
              </div>
            </div>
          </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php 
	// include footer file
 
 $this->load->view('admin/include/footer.php'); ?>