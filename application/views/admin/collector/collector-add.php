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
      echo form_open('collector/create',$attributes); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Nuevo cobrador
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
                  <h4><i class="icon fa fa-ban"></i> ¡Error!</h4>
                    <?php echo validation_errors(); ?>
                </div>
                <?php } ?>
		           <div class="form-group">
                        <label for="txt_collector_first_name" class="col-sm-5 control-label">Nombre :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_collector_first_name" class="form-control " placeholder="Nombre..." value="" />
                    </div></div>
                    <div class="form-group">
                        <label for="txt_collector_personal_id" class="col-sm-5 control-label">Cédula :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_collector_personal_id" class="form-control " placeholder="Cédula de identidad..." value="" />
                    </div></div>
                    <div class="form-group">
                        <label for="txt_collector_nickname" class="col-sm-5 control-label">Apodo :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_collector_nickname" class="form-control " placeholder="Apodo del cliente..." value="" />
                    </div></div>
					          <div class="form-group">
                        <label for="txt_collector_address" class="col-sm-5 control-label">Dirección :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_collector_address" class="form-control " placeholder="Dirección..." value="" />
                    </div></div>
					          <div class="form-group">
                        <label for="txt_collector_city" class="col-sm-5 control-label">Ciudad :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_collector_city" class="form-control " placeholder="Ciudad..." value="" />
                    </div></div>
					          <div class="form-group">
                        <label for="txt_collector_phone" class="col-sm-5 control-label">Teléfono :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_collector_phone" class="form-control " data-inputmask='"mask": "(999) 999-9999"' data-mask="" placeholder="Teléfono..." value="" />
                    </div></div>
					           <div class="form-group">
                        <label for="txt_collector_email" class="col-sm-5 control-label">Email :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_collector_email" class="form-control " placeholder="Email..." value="" />
                    </div></div>
                    
                     <div class="form-group">
                        <label for="txt_collector_occupation" class="col-sm-5 control-label">Ocupación :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_collector_occupation" class="form-control " data-mask="" placeholder="Ocupación..." value="" />
                    </div></div>
                     <div class="form-group">
                        <label for="txt_collector_workplace" class="col-sm-5 control-label">Lugar de trabajo :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_collector_workplace" class="form-control " data-mask="" placeholder="Lugar de trabajo..." value="" />
                    </div></div>
                     <div class="form-group">
                        <label for="txt_collector_workphone" class="col-sm-5 control-label">Teléfono del trabajo :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_collector_workphone" class="form-control " data-mask="" placeholder="Teléfono del trabajo..." value="" />
                    </div></div>
                     <div class="form-group">
                        <label for="txt_collector_workaddress" class="col-sm-5 control-label">Dirección del trabajo :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_collector_workaddress" class="form-control " data-mask="" placeholder="Dirección del trabajo..." value="" />
                    </div></div>
                    
					          <div class="form-group">
                        <label for="txt_contact_person" class="col-sm-5 control-label">Persona de Contacto :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_contact_person" class="form-control " placeholder="Persona de contacto..." value="" />
                    </div></div>
					          <div class="form-group">
                        <label for="txt_contact_person_phone" class="col-sm-5 control-label">Teléfono de la Persona de Contacto :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_contact_person_phone" class="form-control " data-inputmask='"mask": "(999) 999-9999"' data-mask="" placeholder="Teléfono de la persona de contacto..." value="" />
                    </div></div>
				            <div class="form-group">
                        <label for="txt_collector_is_active" class="col-sm-5 control-label">¿Está activo? :</label>	<div class="col-sm-7">
                        <input type="radio" name="txt_collector_is_active" checked placeholder="Está activo..." value="yes" /> Si
                        <input type="radio" name="txt_collector_is_active" placeholder="Está activo..." value="no" /> No
                    </div></div>
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