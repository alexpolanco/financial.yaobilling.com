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
      echo form_open('customer/create',$attributes); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Nuevo cliente</h1>
      <div class="breadcrumb">
        <input type="submit" name="btnsubmit" class="btn btn-lg btn-primary" value="Guardar" title="Guardar"/>
        <input type="button" value="Cancelar" class="btn btn-lg btn-danger" onclick="javascript:window.location.href='<?php echo base_url().'customer' ?>'" title="Cancelar" />
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

                <div class="row">
                  <div class="col-md-12">
		                <div class="form-group">
                      <div class="input-group input-group-lg">
                        <div class="input-group-btn">
                          <label for="txt_customer_first_name" class="control-label btn btn-default">Nombre :</label>
                        </div>
                        <input type="text" name="txt_customer_first_name" class="form-control " placeholder="Nombre..." value="" />
                      </div>
                    </div>
                  </div>
                </div>
                    
                <div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_customer_personal_id" class="control-label btn btn-default">Cédula :</label>	</div>
                        <input type="text" name="txt_customer_personal_id" class="form-control " placeholder="Cédula de identidad..." data-inputmask='"mask": "999-9999999-9"' data-mask="" value="" />
                    </div></div>

                    
            </div></div><div class="row">
                    <div class="col-md-12">
              <div class="form-group">
                  <div class="input-group">
                      <div class="input-group-btn">
                        <label for="txt_customer_gender" class="control-label btn">Sexo :</label></div>
                        <input type="radio" name="txt_customer_gender" placeholder="Sexo..." value="Masculino" checked /> Masculino
                        <input type="radio" name="txt_customer_gender" placeholder="Sexo..." value="Femenino" /> Femenino
                    </div></div>

                    
                    </div></div><div class="row">
                              <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                              <div class="input-group-btn">
                                <label for="txt_customer_nationality" class="control-label btn btn-default">Nacionalidad :</label></div>
                                <input type="text" name="txt_customer_nationality" class="form-control " placeholder="Nacionalidad..." value="" />
                            </div></div>
                    
                    </div></div><div class="row">
                                <div class="col-md-12">
                          <div class="form-group">
                              <div class="input-group input-group-lg">
                                <div class="input-group-btn">
                                  <label for="txt_customer_civilstatus" class="control-label btn btn-default">Estado civil :</label></div>
                                  <input type="text" name="txt_customer_civilstatus" class="form-control " placeholder="Estado civil..." value="" />
                              </div></div>

                    </div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_customer_nickname" class="control-label btn btn-default">Apodo :</label>	</div>
                        <input type="text" name="txt_customer_nickname" class="form-control " placeholder="Apodo del cliente..." value="" />
                    </div></div>
					          </div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_customer_address" class="control-label btn btn-default">Dirección :</label>	</div>
                        <input type="text" name="txt_customer_address" class="form-control " placeholder="Dirección..." value="" />
                    </div></div>
					          </div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_customer_city" class="control-label btn btn-default">Ciudad :</label>	</div>
                        <select name="txt_customer_city" class="form-control ">
                         <?php 
                            foreach ($cities as $value) {
                                ?>
                                <option value="<?php echo $value->cities_id; ?>" <?php if($recored['customer_city'] ==  $value->cities_id ) echo 'selected'; ?>><?php echo $value->cities_name; ?></option>
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
                        <label for="txt_customer_phone" class="control-label btn btn-default">Teléfono :</label>	</div>
                        <input type="text" name="txt_customer_phone" class="form-control " data-inputmask='"mask": "(999) 999-9999"' data-mask="" placeholder="Teléfono..." value="" />
                    </div></div>
					           </div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_customer_email" class="control-label btn btn-default">Email :</label>	</div>
                        <input type="text" name="txt_customer_email" class="form-control " placeholder="Email..." value="" />
                    </div></div>
                    
                     </div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_customer_occupation" class="control-label btn btn-default">Ocupación :</label>	</div>
                        <input type="text" name="txt_customer_occupation" class="form-control " data-mask="" placeholder="Ocupación..." value="" />
                    </div></div>
                     </div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_customer_workplace" class="control-label btn btn-default">Lugar de trabajo :</label>	</div>
                        <input type="text" name="txt_customer_workplace" class="form-control " data-mask="" placeholder="Lugar de trabajo..." value="" />
                    </div></div>
                     </div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_customer_workphone" class="control-label btn btn-default">Teléfono del trabajo :</label>	</div>
                        <input type="text" name="txt_customer_workphone" class="form-control " data-mask="" placeholder="Teléfono del trabajo..." value="" />
                    </div></div>
                     </div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_customer_workaddress" class="control-label btn btn-default">Dirección del trabajo :</label>	</div>
                        <input type="text" name="txt_customer_workaddress" class="form-control " data-mask="" placeholder="Dirección del trabajo..." value="" />
                    </div></div>
                    
					
		          </div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_contact_person" class="control-label btn btn-default">Persona de Contacto :</label>	</div>
                        <input type="text" name="txt_contact_person" class="form-control " placeholder="Persona de contacto..." value="" />
                    </div>
                    </div>
		          </div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_contact_person_phone" class="control-label btn btn-default">Teléfono de la Persona de Contacto :</label>	</div>
                        <input type="text" name="txt_contact_person_phone" class="form-control " data-inputmask='"mask": "(999) 999-9999"' data-mask="" placeholder="Teléfono de la persona de contacto..." value="" />
                    </div>
                    </div>

                    </div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_customer_pin" class="control-label btn btn-default">PIN o código:</label>	</div>
                        <input type="text" name="txt_customer_pin" class="form-control" placeholder="Cuatro digitos de la tarjeta..."  data-inputmask='"mask": "99-99"' data-mask="" value="" />
                    </div>
                    </div>

                    </div></div><div class="row">
                      <div class="col-md-12">
		            <div class="form-group">
                    <div class="input-group input-group-lg">
                      <div class="input-group-btn">
                        <label for="txt_customer_is_active" class="control-label btn btn-default">¿Está activo? :</label>	</div>
                        <input type="radio" name="txt_customer_is_active"  class="" placeholder="Está activo..." value="yes" checked /> Si
                        <input type="radio" name="txt_customer_is_active"  class="" placeholder="Está activo..." value="no" /> No
                      </div>
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
 </body>
</html>