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
      echo form_open('collector/update/'.$this->uri->segment(3),$attributes); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Editar cobrador: <?php echo $recored['collector_first_name']; ?>
      </h1>
      <div class="breadcrumb">
          <input type="submit" name="btnsubmit" class="btn btn-primary" value="Guardar" title="Guardar"/>
          <input type="button" value="Cancelar" class="btn btn-danger" onclick="javascript:window.location.href='<?php echo base_url().'collector' ?>'" title="Cancelar" />
      </div>
    </section>

     <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-body">
                <?php if(validation_errors() != false){ ?>
                  <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Error!</h4>
                      <?php echo validation_errors(); ?>
                  </div>
                <?php } ?>

					<div class="form-group">
                        <label for="txt_collector_first_name" class="col-sm-5 control-label">Nombre :</label><div class="col-sm-7">
                        <input type="text" name="txt_collector_first_name" class="form-control " placeholder="Nombre..." value="<?php echo $recored['collector_first_name']; ?>" />
                    </div></div>
					
					<div class="form-group">
                        <label for="txt_collector_nickname" class="col-sm-5 control-label">Apodo del cliente :</label><div class="col-sm-7">
                        <input type="text" name="txt_collector_nickname" class="form-control " placeholder="Apodo del cliente..." value="<?php echo $recored['collector_nickname']; ?>" />
                    </div></div>
					
					<div class="form-group">
                        <label for="txt_collector_personal_id" class="col-sm-5 control-label">Documento de identidad :</label><div class="col-sm-7">
                        <input type="text" name="txt_collector_personal_id" class="form-control " placeholder="Documento de identidad..." value="<?php echo $recored['collector_personalid']; ?>" />
                    </div></div>
				
					<div class="form-group">
                        <label for="txt_collector_address" class="col-sm-5 control-label">Dirección :</label><div class="col-sm-7">
                        <input type="text" name="txt_collector_address" class="form-control " placeholder="Dirección..." value="<?php echo $recored['collector_address']; ?>" />
                    </div></div>
					<div class="form-group">
                        <label for="txt_collector_city" class="col-sm-5 control-label">Ciudad :</label><div class="col-sm-7">
                        <input type="text" name="txt_collector_city" class="form-control " placeholder="Ciudad..." value="<?php echo $recored['collector_city']; ?>" />
                    </div></div>
					<div class="form-group">
                        <label for="txt_collector_phone" class="col-sm-5 control-label">Teléfono :</label><div class="col-sm-7">
                        <input type="text" name="txt_collector_phone" class="form-control " data-inputmask='"mask": "(999) 999-9999"' data-mask="" placeholder="Teléfono..." value="<?php echo $recored['collector_phone']; ?>" />
                    </div></div>
					
					<div class="form-group">
                        <label for="txt_collector_email" class="col-sm-5 control-label">Correo electrónico :</label><div class="col-sm-7">
                        <input type="text" name="txt_collector_email" class="form-control " placeholder="Correo electrónico..." value="<?php echo $recored['collector_email']; ?>" />
                    </div></div>
					
					<div class="form-group">
                        <label for="txt_collector_occupation" class="col-sm-5 control-label">Ocupación :</label><div class="col-sm-7">
                        <input type="text" name="txt_collector_occupation" class="form-control " placeholder="Ocupación..." value="<?php echo $recored['collector_occupation']; ?>" />
                    </div></div>
					
					<div class="form-group">
                        <label for="txt_collector_workplace" class="col-sm-5 control-label">Lugar de trabajo :</label><div class="col-sm-7">
                        <input type="text" name="txt_collector_workplace" class="form-control " placeholder="Lugar de trabajo..." value="<?php echo $recored['collector_workplace']; ?>" />
                    </div></div>
					
					<div class="form-group">
                        <label for="txt_collector_workphone" class="col-sm-5 control-label">Teléfono del trabajo :</label><div class="col-sm-7">
                        <input type="text" name="txt_collector_workphone" class="form-control " placeholder="Teléfono del trabajo..." value="<?php echo $recored['collector_workphone']; ?>" />
                    </div></div>
					
					<div class="form-group">
                        <label for="txt_collector_workaddress" class="col-sm-5 control-label">Dirección del trabajo :</label><div class="col-sm-7">
                        <input type="text" name="txt_collector_workaddress" class="form-control " placeholder="Dirección del trabajo..." value="<?php echo $recored['collector_workaddress']; ?>" />
                    </div></div>
					
					<div class="form-group">
                        <label for="txt_contact_person" class="col-sm-5 control-label">Persona de contacto :</label><div class="col-sm-7">
                        <input type="text" name="txt_contact_person" class="form-control " placeholder="Persona de contacto..." value="<?php echo $recored['contact_person']; ?>" />
                    </div></div>
					<div class="form-group">
                        <label for="txt_contact_person_phone" class="col-sm-5 control-label">Teléfono de la persona de contacto :</label><div class="col-sm-7">
                        <input type="text" name="txt_contact_person_phone" class="form-control " data-inputmask='"mask": "(999) 999-9999"' data-mask="" placeholder="Teléfono de la persona de contacto..." value="<?php echo $recored['contact_person_phone']; ?>" />
                    </div></div>

                    <div class="form-group">
                        <label for="txt_collector_is_active" class="col-sm-5 control-label">¿Está Activo? :</label><div class="col-sm-7">
                        <input type="radio" name="txt_collector_is_active" <?php if($recored['collector_is_active'] == 'yes') echo 'checked'; ?> placeholder="Está activo..." value="yes" /> Si
                        <input type="radio" name="txt_collector_is_active" <?php if($recored['collector_is_active'] == 'no') echo 'checked'; ?> placeholder="Está activo..." value="no" /> No
                    </div></div>
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

