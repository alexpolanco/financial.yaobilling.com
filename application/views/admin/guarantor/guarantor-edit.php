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
      echo form_open('guarantor/edit/'.$this->uri->segment(3),$attributes); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Editar garante: <?php echo $recored['guarantor_first_name']; ?>
      </h1>
      <div class="breadcrumb">
        <input type="submit" name="btnsubmit" class="btn btn-lg btn-primary" value="Guardar" title="Guardar"/>
        <input type="button" value="Cancelar" class="btn btn-lg btn-danger" onclick="javascript:window.location.href='<?php echo base_url().'guarantor' ?>'" title="Cancelar" />
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

					<div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_guarantor_first_name" class="control-label btn btn-default">Nombre :</label></div>
                        <input type="text" name="txt_guarantor_first_name" class="form-control " placeholder="Nombre..." value="<?php echo $recored['guarantor_first_name']; ?>" />
                    </div></div>
					
					</div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_guarantor_nickname" class="control-label btn btn-default">Apodo del garante :</label></div>
                        <input type="text" name="txt_guarantor_nickname" class="form-control " placeholder="Apodo del garante..." value="<?php echo $recored['guarantor_nickname']; ?>" />
                    </div></div>
					
					</div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_guarantor_personal_id" class="control-label btn btn-default">Cédula :</label></div>
                        <input type="text" name="txt_guarantor_personal_id" class="form-control " placeholder="Documento de identidad..." data-inputmask='"mask": "999-9999999-9"' data-mask="" value="<?php echo $recored['guarantor_personalid']; ?>" />
                    </div></div>

        </div></div><div class="row">
                    <div class="col-md-12">
              <div class="form-group">
                  <div class="input-group">
                      <div class="input-group-btn">
                        <label for="txt_guarantor_gender" class="control-label btn">Sexo :</label></div>
                        <input type="radio" name="txt_guarantor_gender" <?php if($recored['guarantor_gender'] == 'Masculino') echo 'checked'; ?> placeholder="Sexo..." value="Masculino" /> Masculino
                        <input type="radio" name="txt_guarantor_gender" <?php if($recored['guarantor_gender'] == 'Femenino' || htmlspecialchars($recored['guarantor_gender']) == null) echo 'checked'; ?> placeholder="Sexo..." value="Femenino" /> Femenino
                    </div></div>
                                      
                  </div></div><div class="row">
                              <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                              <div class="input-group-btn">
                                <label for="txt_guarantor_nationality" class="control-label btn btn-default">Nacionalidad :</label></div>
                                <input type="text" name="txt_guarantor_nationality" class="form-control " placeholder="Nacionalidad..." value="<?php echo $recored['guarantor_nationality']; ?>" />
                            </div></div> 

                  </div></div><div class="row">
                              <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                              <div class="input-group-btn">
                                <label for="txt_guarantor_civilstatus" class="control-label btn btn-default">Estado civil :</label></div>
                                <input type="text" name="txt_guarantor_civilstatus" class="form-control " placeholder="Estado civil..." value="<?php echo $recored['guarantor_civilstatus']; ?>" />
                            </div></div>
                  
                  </div></div><div class="row">
                              <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                              <div class="input-group-btn">
                                <label for="txt_guarantor_address" class="control-label btn btn-default">Dirección :</label></div>
                                <input type="text" name="txt_guarantor_address" class="form-control " placeholder="Dirección..." value="<?php echo $recored['guarantor_address']; ?>" />
                            </div></div>
                            
					</div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_guarantor_city" class="control-label btn btn-default">Ciudad :</label></div>
                        <select name="txt_guarantor_city" class="form-control ">
                         <?php 
                            foreach ($cities as $value) {
                                ?>
                                <option value="<?php echo $value->cities_id; ?>" <?php if($recored['guarantor_city'] ==  $value->cities_id ) echo 'selected'; ?>><?php echo $value->cities_name; ?></option>
                                <?php
                            }
                          ?>
                        </select>
                    </div></div>
					</div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_guarantor_phone" class="control-label btn btn-default">Teléfono :</label></div>
                        <input type="text" name="txt_guarantor_phone" class="form-control " data-inputmask='"mask": "(999) 999-9999"' data-mask="" placeholder="Teléfono..." value="<?php echo $recored['guarantor_phone']; ?>" />
                    </div></div>
					
					</div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_guarantor_email" class="control-label btn btn-default">Correo electrónico :</label></div>
                        <input type="text" name="txt_guarantor_email" class="form-control " placeholder="Correo electrónico..." value="<?php echo $recored['guarantor_email']; ?>" />
                    </div></div>
					
					</div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_guarantor_occupation" class="control-label btn btn-default">Ocupación :</label></div>
                        <input type="text" name="txt_guarantor_occupation" class="form-control " placeholder="Ocupación..." value="<?php echo $recored['guarantor_occupation']; ?>" />
                    </div></div>
					
					</div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_guarantor_workplace" class="control-label btn btn-default">Lugar de trabajo :</label></div>
                        <input type="text" name="txt_guarantor_workplace" class="form-control " placeholder="Lugar de trabajo..." value="<?php echo $recored['guarantor_workplace']; ?>" />
                    </div></div>
					
					</div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_guarantor_workphone" class="control-label btn btn-default">Teléfono del trabajo :</label></div>
                        <input type="text" name="txt_guarantor_workphone" class="form-control " placeholder="Teléfono del trabajo..." value="<?php echo $recored['guarantor_workphone']; ?>" />
                    </div></div>
					
					</div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_guarantor_workaddress" class="control-label btn btn-default">Dirección del trabajo :</label></div>
                        <input type="text" name="txt_guarantor_workaddress" class="form-control " placeholder="Dirección del trabajo..." value="<?php echo $recored['guarantor_workaddress']; ?>" />
                    </div></div>
					
					</div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_contact_person" class="control-label btn btn-default">Persona de contacto :</label></div>
                        <input type="text" name="txt_contact_person" class="form-control " placeholder="Persona de contacto..." value="<?php echo $recored['contact_person']; ?>" />
                    </div></div>
					</div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_contact_person_phone" class="control-label btn btn-default">Teléfono de la persona de contacto :</label></div>
                        <input type="text" name="txt_contact_person_phone" class="form-control " data-inputmask='"mask": "(999) 999-9999"' data-mask="" placeholder="Teléfono de la persona de contacto..." value="<?php echo $recored['contact_person_phone']; ?>" />
                    </div></div>

                    </div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_guarantor_pin" class="control-label btn btn-default">PIN o código:</label>	</div>
                        <input type="text" name="txt_guarantor_pin" class="form-control" placeholder="Cuatro digitos de la tarjeta..." data-inputmask='"mask": "99-99"' data-mask="" value="<?php echo $recored['guarantor_pin']; ?>" />
                    </div>
                    </div>

                    </div></div><div class="row">
                      <div class="col-md-12">
		                  <div class="form-group">
                        <label for="txt_guarantor_is_active" class="control-label btn btn-default">¿Está Activo? :</label>
                        <input type="radio" name="txt_guarantor_is_active" <?php if($recored['guarantor_is_active'] == 'yes') echo 'checked'; ?> placeholder="Está activo..." value="yes" /> Si
                        <input type="radio" name="txt_guarantor_is_active" <?php if($recored['guarantor_is_active'] == 'no' || $recored['guarantor_is_active'] == null) echo 'checked'; ?> placeholder="Está activo..." value="no" /> No
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
</body>
</html>