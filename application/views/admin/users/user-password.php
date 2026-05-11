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
      echo form_open('users/c_password',$attributes); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Cambiar contraseña</h1>
      <div class="breadcrumb">
        <input type="submit" name="btnsubmit" class="btn btn-primary btn-lg" value="Guardar" title="Guardar" />
      </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-body">
                <?php if($this->session->flashdata('msg') != false){ 
                    $len = strlen($this->session->flashdata('msg'));
                  ?>
                 <div class="alert alert-<?php if($len >= 30) echo "danger"; else "success"; ?> alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>  <i class="icon fa fa-<?php if($len >= 30) echo "ban"; else "check"; ?>"></i> ¡Bien!</h4>
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
                <?php } ?>
                <?php if(validation_errors() != false){ ?>
                <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h4><i class="icon fa fa-ban"></i> ¡Error!</h4>
                    <?php echo validation_errors(); ?>
                </div>
                <?php } ?>

		          <div class="form-group">
                        <label>Contraseña anterior :</label>
                        <input type="password" name="old_password" class="form-control " placeholder="Contraseña anterior..." value="" />
                    </div>
					
					          <div class="form-group">
                        <label>Nueva contraseña :</label>
                        <input type="password" name="txt_password" class="form-control " placeholder="Nueva contraseña..." value="" />
                    </div>

                    <div class="form-group">
                        <label>Confirmar nueva contraseña :</label>
                        <input type="password" name="confirm_password" class="form-control " placeholder="Confirmar nueva contraseña..." value="" />
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