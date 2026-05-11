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
      echo form_open('users/create',$attributes); ?>
      <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Nuevo usuario</h1>
      <div class="breadcrumb">
        <input type="submit" name="btnsubmit" class="btn btn-primary btn-lg" value="Guardar" title="Guardar"/>
        <input type="button" value="Cancelar" class="btn btn-danger btn-lg" onclick="javascript:window.location.href='<?php echo base_url().'users' ?>'" title="Cancelar" />
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

                  <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash'];?>" />
		           <div class="form-group"> 
                        <label for="txt_user_group_id" class="col-sm-5 control-label">Rol :</label><div class="col-sm-7">
                        <select name="txt_user_group_id" class="form-control ">
                         <?php 
                            $CI =& get_instance();
                            $group = $CI->get_All_group();
                            foreach ($group as $value) {
                                ?>
                                <option value="<?php echo $value->user_group_id; ?>"><?php echo $value->user_group_name; ?></option>
                                <?php
                            }
                          ?>
                        </select>
                    </div></div>

		          <div class="form-group">
                        <label for="txt_user_name" class="col-sm-5 control-label">Nombre del usuario :</label><div class="col-sm-7">
                        <input type="text" name="txt_user_name" class="form-control " placeholder="Nombre de usuario..." value="" />
                    </div></div>
					
		          <div class="form-group">
                        <label for="txt_password" class="col-sm-5 control-label">Contraseña :</label><div class="col-sm-7">
                        <input type="password" name="txt_password" class="form-control " placeholder="Contraseña..." value="" />
                    </div></div>

                    <div class="form-group">
                        <label for="confirm_password" class="col-sm-5 control-label">Confirmar contraseña :</label><div class="col-sm-7">
                        <input type="password" name="confirm_password" class="form-control " placeholder="Confirmar contraseña..." value="" />
                    </div></div>
                    
                   <div class="form-group">
                        <label for="txt_user_active" class="col-sm-5 control-label">¿Está activo? :</label><div class="col-sm-7">
                        <div style=""><input type="radio" name="txt_user_active" checked value="yes" title="Si" /> Si</div>
                        <div style=""><input type="radio" name="txt_user_active" value="no" title="No" /> No</div>
                    </div></div>
                    
                    <br><br>
                    <div class="form-group">
                        <label for="txt_user_fullname" class="col-sm-5 control-label">Nombre :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_user_fullname" class="form-control " placeholder="Nombre completo..." value="" />
                    </div></div>
                    <div class="form-group">
                        <label for="txt_user_personal_id" class="col-sm-5 control-label">Cédula :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_user_personal_id" class="form-control " placeholder="Cédula de identidad..." value="" />
                    </div></div>
                    <div class="form-group">
                        <label for="txt_user_nickname" class="col-sm-5 control-label">Apodo :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_user_nickname" class="form-control " placeholder="Apodo del cliente..." value="" />
                    </div></div>
					          <div class="form-group">
                        <label for="txt_user_address" class="col-sm-5 control-label">Dirección :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_user_address" class="form-control " placeholder="Dirección..." value="" />
                    </div></div>
					          <div class="form-group">
                        <label for="txt_user_city" class="col-sm-5 control-label">Ciudad :</label>	<div class="col-sm-7">
                        <select name="txt_user_city" class="form-control ">
                         <?php 
                            foreach ($cities as $value) {
                                ?>
                                <option value="<?php echo $value->cities_id; ?>" <?php if($recored['customer_city'] ==  $value->cities_id ) echo 'selected'; ?>><?php echo $value->cities_name; ?></option>
                                <?php
                            }
                          ?>
                        </select>
                    </div></div>
					          <div class="form-group">
                        <label for="txt_user_phone" class="col-sm-5 control-label">Teléfono :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_user_phone" class="form-control " data-inputmask='"mask": "(999) 999-9999"' data-mask="" placeholder="Teléfono..." value="" />
                    </div></div>
					           <div class="form-group">
                        <label for="txt_user_email" class="col-sm-5 control-label">Email :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_user_email" class="form-control " placeholder="Email..." value="" />
                    </div></div>
                    
                     <div class="form-group">
                        <label for="txt_user_occupation" class="col-sm-5 control-label">Ocupación :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_user_occupation" class="form-control " data-mask="" placeholder="Ocupación..." value="" />
                    </div></div>
                     <div class="form-group">
                        <label for="txt_user_workplace" class="col-sm-5 control-label">Lugar de trabajo :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_user_workplace" class="form-control " data-mask="" placeholder="Lugar de trabajo..." value="" />
                    </div></div>
                     <div class="form-group">
                        <label for="txt_user_workphone" class="col-sm-5 control-label">Teléfono del trabajo :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_user_workphone" class="form-control " data-mask="" placeholder="Teléfono del trabajo..." value="" />
                    </div></div>
                     <div class="form-group">
                        <label for="txt_user_workaddress" class="col-sm-5 control-label">Dirección del trabajo :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_user_workaddress" class="form-control " data-mask="" placeholder="Dirección del trabajo..." value="" />
                    </div></div>
                    
					
		          <div class="form-group">
                        <label for="txt_contact_person" class="col-sm-5 control-label">Persona de Contacto :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_contact_person" class="form-control " placeholder="Persona de contacto..." value="" />
                    </div>
                    </div>
		          <div class="form-group">
                        <label for="txt_contact_person_phone" class="col-sm-5 control-label">Teléfono de la Persona de Contacto :</label>	<div class="col-sm-7">
                        <input type="text" name="txt_contact_person_phone" class="form-control " data-inputmask='"mask": "(999) 999-9999"' data-mask="" placeholder="Teléfono de la persona de contacto..." value="" />
                    </div>
                    </div>
                    
                    <table class="table">
                      <tr>
                        <th><h3>Privilegios...</h3></th> 
                      </tr>
                      <tr>
                        <td>
                          <table class="table">
                            <tr>
                              <td width="40%"><strong>Privilegio</strong></td>
                              <td width="10%"><strong>Ver</strong></td>
                              <td width="10%"><strong>Agregar</strong></td>
                              <td width="10%"><strong>Editar</strong></td>
                              <td width="15%"><strong>Eliminar</strong></td>
                              <td width="15%"><strong>Devolver</strong></td>
                            </tr>
                            <?php 
                              $CI =& get_instance();
                              $component = $CI->get_component();
                              $i = 0;
                              foreach ($component as  $_c) {
                                $i++;
                                ?>
                                <tr <?php if($_c->component_name == 'setup' || $_c->component_name == 'report') echo 'class="bg-blue"';  ?>>
                                  <td>
                                    <?php if($_c->component_name == 'order-view') echo 'order-view'; else echo $_c->component_name; ?>
                                  </td>
                                  <?php
                                    if($_c->component_name == 'report')
                                    {
                                        ?>
                                          <td>  
                                            <input type="checkbox" name="chk1_<?php echo $i; ?>" id="chk1_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/" />
                                          </td>
                                          <td>
                                            <label class="pull-right">Logs </label>
                                          </td>
                                          <td>
                                            <input type="checkbox" name="chk2_<?php echo $i; ?>" id="chk2_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/logs" />
                                          </td>
                                          <td>
                                            <label class="pull-right">Cashflow </label>
                                          </td>
                                          <td>
                                            <input type="checkbox" name="chk3_<?php echo $i; ?>" id="chk3_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/report_cashflow" />
                                          </td>
                                          <td>
                                            <input type="checkbox" name="chk4_<?php echo $i; ?>" id="chk4_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/report_info" />
                                          </td>
                                          <td>
                                            <input type="checkbox" name="chk5_<?php echo $i; ?>" id="chk5_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/customers" />
                                          </td>
                                        <?php
                                    }
                                    else if($_c->component_name == 'setup')
                                    {
                                        ?>
                                          <td> 
                                            <label class="pull-right">La Empresa</label>
                                          </td>
                                          <td>
                                            <input type="checkbox" name="chk1_<?php echo $i; ?>" id="chk1_<?php echo $i; ?>" value="company/edit" />
                                          </td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                        <?php
                                    }
                                    else if($_c->component_name == 'order-view')
                                    {
                                        ?>
                                          <td>
                                            <input type="checkbox" name="chk1_<?php echo $i; ?>" id="chk1_<?php echo $i; ?>" value="sales/order_view" />
                                          </td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                        <?php
                                    }
                                    else if($_c->component_name == 'loans' || 
                                    $_c->component_name == 'loansfixed' || 
                                    $_c->component_name == 'loanscapital' || 
                                    $_c->component_name == 'loansinversion' || 
                                    $_c->component_name == 'loanschristmas' || 
                                    $_c->component_name == 'loansquickbusiness')
                                    {
                                        ?>
                                          <td>
                                            <label class="pull-right">Vencidos</label><input type="checkbox" name="chk1_<?php echo $i; ?>" id="chk1_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/" />
                                          </td>
                                          <td>
                                            <label class="pull-right">Recibos</label><input type="checkbox" name="chk2_<?php echo $i; ?>" id="chk2_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/due" />
                                          </td>
                                          <td>
                                            <label class="pull-right">Imprimir</label><input type="checkbox" name="chk3_<?php echo $i; ?>" id="chk3_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/receipt" />
                                          </td>
                                          <td>
                                            <label class="pull-right"></label><input type="checkbox" name="chk4_<?php echo $i; ?>" id="chk4_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/loan_print" <?php if(in_array($_c->component_name.'/loan_print', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td>
                                            <label class="pull-right">PDF</label><input type="checkbox" name="chk5_<?php echo $i; ?>" id="chk5_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/pdf" <?php if(in_array($_c->component_name.'/pdf', $each_right)) echo "checked"; ?> />
                                          </td>
                                        <?php
                                    }
                                    else
                                    {
                                  ?>
                                          <td>
                                            <input type="checkbox" name="chk1_<?php echo $i; ?>" id="chk4_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/" />
                                          </td>
                                          <td>
                                            <input type="checkbox" name="chk2_<?php echo $i; ?>" id="chk4_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/create" />
                                          </td>
                                          <td>
                                            <input type="checkbox" name="chk3_<?php echo $i; ?>" id="chk4_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/edit" />
                                          </td>
                                          <td>
                                            <input type="checkbox" name="chk4_<?php echo $i; ?>" id="chk4_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/delete" />
                                          </td>
                                          <?php 
                                            if($_c->component_name == 'sales')
                                            {
                                              ?>
                                              <td>
                                                <input type="checkbox" name="chk5_<?php echo $i; ?>" id="chk4_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/return_sales" />
                                              </td>
                                              <?php
                                            }
                                  }
                                  ?>
                                </tr>
                                <?php
                              }

                            ?>
                          </table>
                        </td>
                      </tr>
                    </table>
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