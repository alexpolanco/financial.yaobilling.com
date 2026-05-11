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
      echo form_open('users/update/'.$this->uri->segment(3),$attributes); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Editar usuario: <?php echo $recored['user_fullname']; ?></h1>
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
                    <div class="form-group">
                        <label for="txt_user_group_id" class="col-sm-5 control-label">Rol :</label><div class="col-sm-7">
                        <select name="txt_user_group_id" class="form-control ">
                        <?php 
                            $CI =& get_instance();
                            $group = $CI->get_All_group();
                            foreach ($group as $value) {
                                ?>
                                <option value="<?php echo $value->user_group_id; ?>" <?php if($recored['user_group_id'] == $value->user_group_id) echo "selected"; ?>><?php echo $value->user_group_name; ?></option>
                                <?php
                            }
                          ?>
                        </select>
                    </div></div>
                        
			          <div class="form-group">
                        <label for="txt_user_name" class="col-sm-5 control-label">Usuario :</label><div class="col-sm-7">
                        <input type="text" name="txt_user_name" class="form-control " placeholder="Nombre del usuario..." value="<?php echo $recored['user_name']; ?>" />
                    </div></div>

                    <div class="form-group">
                        <label for="txt_user_active" class="col-sm-5 control-label">¿Está activo? :</label><div class="col-sm-7">
                        <div><input type="radio" name="txt_user_active" <?php if($recored['user_active'] == 'yes') echo 'checked'; ?>  value="yes" /> Si</div>
                        <div><input type="radio" name="txt_user_active" <?php if($recored['user_active'] == 'no') echo 'checked'; ?> value="no" /> No</div>
                    </div></div>
					   
					   <div class="form-group">
                        <label for="txt_user_fullname" class="col-sm-5 control-label">Nombre :</label><div class="col-sm-7">
                        <input type="text" name="txt_user_fullname" class="form-control " placeholder="Nombre completo..." value="<?php echo $recored['user_fullname']; ?>" />
                    </div></div>
					
					<div class="form-group">
                        <label for="txt_user_nickname" class="col-sm-5 control-label">Apodo :</label><div class="col-sm-7">
                        <input type="text" name="txt_user_nickname" class="form-control " placeholder="Apodo del usuario..." value="<?php echo $recored['user_nickname']; ?>" />
                    </div></div>
					
					<div class="form-group">
                        <label for="txt_user_personal_id" class="col-sm-5 control-label">Documento de identidad :</label><div class="col-sm-7">
                        <input type="text" name="txt_user_personal_id" class="form-control " placeholder="Documento de identidad..." value="<?php echo $recored['user_personalid']; ?>" />
                    </div></div>
				
					<div class="form-group">
                        <label for="txt_user_address" class="col-sm-5 control-label">Dirección :</label><div class="col-sm-7">
                        <input type="text" name="txt_user_address" class="form-control " placeholder="Dirección..." value="<?php echo $recored['user_address']; ?>" />
                    </div></div>
					<div class="form-group">
                        <label for="txt_user_city" class="col-sm-5 control-label">Ciudad :</label><div class="col-sm-7">
                        <select name="txt_user_city" class="form-control ">
                         <?php 
                            foreach ($cities as $value) {
                                ?>
                                <option value="<?php echo $value->cities_id; ?>" <?php if($recored['user_city'] ==  $value->cities_id ) echo 'selected'; ?>><?php echo $value->cities_name; ?></option>
                                <?php
                            }
                          ?>
                        </select>
                    </div></div>
					<div class="form-group">
                        <label for="txt_user_phone" class="col-sm-5 control-label">Teléfono :</label><div class="col-sm-7">
                        <input type="text" name="txt_user_phone" class="form-control " data-inputmask='"mask": "(999) 999-9999"' data-mask="" placeholder="Teléfono..." value="<?php echo $recored['user_phone']; ?>" />
                    </div></div>
					
					<div class="form-group">
                        <label for="txt_user_email" class="col-sm-5 control-label">Correo electrónico :</label><div class="col-sm-7">
                        <input type="text" name="txt_user_email" class="form-control " placeholder="Correo electrónico..." value="<?php echo $recored['user_email']; ?>" />
                    </div></div>
					
					<div class="form-group">
                        <label for="txt_user_occupation" class="col-sm-5 control-label">Ocupación :</label><div class="col-sm-7">
                        <input type="text" name="txt_user_occupation" class="form-control " placeholder="Ocupación..." value="<?php echo $recored['user_occupation']; ?>" />
                    </div></div>
					
					<div class="form-group">
                        <label for="txt_user_workplace" class="col-sm-5 control-label">Lugar de trabajo :</label><div class="col-sm-7">
                        <input type="text" name="txt_user_workplace" class="form-control " placeholder="Lugar de trabajo..." value="<?php echo $recored['user_workplace']; ?>" />
                    </div></div>
					
					<div class="form-group">
                        <label for="txt_user_workphone" class="col-sm-5 control-label">Teléfono del trabajo :</label><div class="col-sm-7">
                        <input type="text" name="txt_user_workphone" class="form-control " placeholder="Teléfono del trabajo..." value="<?php echo $recored['user_workphone']; ?>" />
                    </div></div>
					
					<div class="form-group">
                        <label for="txt_user_workaddress" class="col-sm-5 control-label">Dirección del trabajo :</label><div class="col-sm-7">
                        <input type="text" name="txt_user_workaddress" class="form-control " placeholder="Dirección del trabajo..." value="<?php echo $recored['user_workaddress']; ?>" />
                    </div></div>
					
					<div class="form-group">
                        <label for="txt_contact_person" class="col-sm-5 control-label">Persona de contacto :</label><div class="col-sm-7">
                        <input type="text" name="txt_contact_person" class="form-control " placeholder="Persona de contacto..." value="<?php echo $recored['contact_person']; ?>" />
                    </div></div>
					<div class="form-group">
                        <label for="txt_contact_person_phone" class="col-sm-5 control-label">Teléfono de la persona de contacto :</label><div class="col-sm-7">
                        <input type="text" name="txt_contact_person_phone" class="form-control " data-inputmask='"mask": "(999) 999-9999"' data-mask="" placeholder="Teléfono de la persona de contacto..." value="<?php echo $recored['contact_person_phone']; ?>" />
                    </div></div>
					   
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
                              <td width="15%"><strong>Retornar</strong></td>
                            </tr>
                            <?php 
                              $CI =& get_instance();
                              $component = $CI->get_component();
                              $i = 0;
                              $each_right = $CI->get_rights($recored['user_id']);
                              foreach ($component as  $_c) {
                                $i++;
                                ?>
                                <tr <?php if($_c->component_name == 'setup' || $_c->component_name == 'report' || $_c->component_name == 'loans') echo 'class="bg-blue"';  ?>>
                                  <td>
                                  <?php if($_c->component_name == 'order-view') echo 'order-view'; else echo $_c->component_name; ?>
                                  </td>

                                  <?php
                                    if($_c->component_name == 'report')
                                    {
                                    ?>
                                    <td colspan="5">
                                      <table class="table" style="background-color:transparent !important">
                                        <tr>
                                          <td>  
                                            <input type="checkbox" name="chk1_<?php echo $i; ?>" id="chk1_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/" <?php if(in_array($_c->component_name.'/', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td>
                                            Logs<br><input type="checkbox" name="chk2_<?php echo $i; ?>" id="chk2_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/logs" <?php if(in_array($_c->component_name.'/logs', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td>
                                            Cashflow<br><input type="checkbox" name="chk3_<?php echo $i; ?>" id="chk3_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/report_cashflow" <?php if(in_array($_c->component_name.'/report_cashflow', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td>
                                            Info<br><input type="checkbox" name="chk4_<?php echo $i; ?>" id="chk4_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/report_info" <?php if(in_array($_c->component_name.'/report_info', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td>
                                            Clientes<br><input type="checkbox" name="chk5_<?php echo $i; ?>" id="chk5_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/customers" <?php if(in_array($_c->component_name.'/customers', $each_right)) echo "checked"; ?> />
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>
                                            Gastos<br><input type="checkbox" name="chk6_<?php echo $i; ?>" id="chk6_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/expense" <?php if(in_array($_c->component_name.'/expense', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td>
                                            Pagos<br><input type="checkbox" name="chk7_<?php echo $i; ?>" id="chk7_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/report_payments" <?php if(in_array($_c->component_name.'/report_payments', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td>
                                            Ingresos/Egresos<br><input type="checkbox" name="chk8_<?php echo $i; ?>" id="chk8_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/report_earnings" <?php if(in_array($_c->component_name.'/report_earnings', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td>
                                            Préstamos<br><input type="checkbox" name="chk9_<?php echo $i; ?>" id="chk9_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/report_loans" <?php if(in_array($_c->component_name.'/report_loans', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td>
                                            PDF<br><input type="checkbox" name="chk10_<?php echo $i; ?>" id="chk10_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/pdf" <?php if(in_array($_c->component_name.'/pdf', $each_right)) echo "checked"; ?> />
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>
                                            Abonos al capital<br><input type="checkbox" name="chk11_<?php echo $i; ?>" id="chk11_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/#" <?php if(in_array($_c->component_name.'/expense', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td>
                                            Adicional al capital<br><input type="checkbox" name="chk12_<?php echo $i; ?>" id="chk12_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/#" <?php if(in_array($_c->component_name.'/report_payments', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td>
                                            Pagos irregulares<br><input type="checkbox" name="chk13_<?php echo $i; ?>" id="chk13_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/#" <?php if(in_array($_c->component_name.'/report_earnings', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td>
                                            Pagos completos<br><input type="checkbox" name="chk14_<?php echo $i; ?>" id="chk14_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/#" <?php if(in_array($_c->component_name.'/report_loans', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td>
                                            Pagos por mes<br><input type="checkbox" name="chk15_<?php echo $i; ?>" id="chk15_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/pdf" <?php if(in_array($_c->component_name.'/#', $each_right)) echo "checked"; ?> />
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                    <?php
                                    }
                                    else if($_c->component_name == 'events')
                                    {
                                        ?>
                                          <td> 
                                            Calendario<br>
                                            <input type="checkbox" name="chk1_<?php echo $i; ?>" id="chk1_<?php echo $i; ?>" value="events/" <?php if(in_array('events/', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td>
                                            Pagos<br><input type="checkbox" name="chk2_<?php echo $i; ?>" id="chk2_<?php echo $i; ?>" value="events/payments" <?php if(in_array('events/payments', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td>
                                            Vencidos<br><input type="checkbox" name="chk3_<?php echo $i; ?>" id="chk3_<?php echo $i; ?>" value="events/due" <?php if(in_array('events/due', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td></td>
                                          <td></td>
                                        <?php
                                    }
                                    else if($_c->component_name == 'iframe')
                                    {
                                        ?>
                                          <td> 
                                            GMail<br>
                                            <input type="checkbox" name="chk1_<?php echo $i; ?>" id="chk1_<?php echo $i; ?>" value="iframe/gmail" <?php if(in_array('iframe/gmail', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td>
                                            Outlook<br><input type="checkbox" name="chk2_<?php echo $i; ?>" id="chk2_<?php echo $i; ?>" value="iframe/outlook" <?php if(in_array('iframe/outlook', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td>
                                            Datacrédito<br><input type="checkbox" name="chk3_<?php echo $i; ?>" id="chk3_<?php echo $i; ?>" value="iframe/datacredito" <?php if(in_array('iframe/datacredito', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td>
                                            TransUnión<br><input type="checkbox" name="chk4_<?php echo $i; ?>" id="chk4_<?php echo $i; ?>" value="iframe/transunion" <?php if(in_array('iframe/transunion', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td></td>
                                        <?php
                                    }
                                    else if($_c->component_name == 'setup')
                                    {
                                        ?>
                                          <td> 
                                            La Empresa
                                          </td>
                                          <td>
                                            <input type="checkbox" name="chk1_<?php echo $i; ?>" id="chk1_<?php echo $i; ?>" value="company/edit" <?php if(in_array('company/edit', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                        <?php
                                    }
                                    else if($_c->component_name == 'order-view')
                                    {
                                        ?>
                                          <td>
                                            <input type="checkbox" name="chk1_<?php echo $i; ?>" id="chk1_<?php echo $i; ?>" value="sales/order_view" <?php if(in_array('sales/order-view', $each_right)) echo "checked"; ?> />
                                          </td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                        <?php
                                    }
                                    else if($_c->component_name == 'opposition')
                                    {
                                      ?>
                                      <td colspan="5">
                                        <table class="table" style="background-color:transparent !important">
                                          <tr>
                                            <td width="20%">
                                              <input type="checkbox" name="chk1_<?php echo $i; ?>" id="chk1_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/" <?php if(in_array($_c->component_name.'/', $each_right)) echo "checked"; ?> />
                                            </td>
                                            <td width="20%">
                                              <input type="checkbox" name="chk2_<?php echo $i; ?>" id="chk2_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/create" <?php if(in_array($_c->component_name.'/create', $each_right)) echo "checked"; ?> />
                                            </td>
                                            <td width="20%">
                                              <input type="checkbox" name="chk3_<?php echo $i; ?>" id="chk3_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/edit" <?php if(in_array($_c->component_name.'/edit', $each_right)) echo "checked"; ?> />
                                            </td>
                                            <td width="20%">
                                              <input type="checkbox" name="chk4_<?php echo $i; ?>" id="chk4_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/delete" <?php if(in_array($_c->component_name.'/delete', $each_right)) echo "checked"; ?> />
                                            </td>
                                            <td width="20%">
                                              <input type="checkbox" name="chk5_<?php echo $i; ?>" id="chk5_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/pdf" <?php if(in_array($_c->component_name.'/pdf', $each_right)) echo "checked"; ?> />
                                            </td>
                                          </tr>
                                          <tr><td>
                                              Levantadas<br><input type="checkbox" name="chk6_<?php echo $i; ?>" id="chk6_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/due" <?php if(in_array($_c->component_name.'/due', $each_right)) echo "checked"; ?> />
                                            </td>
                                            <td>
                                              Abonos<br><input type="checkbox" name="chk7_<?php echo $i; ?>" id="chk7_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/pay" <?php if(in_array($_c->component_name.'/pay', $each_right)) echo "checked"; ?> />
                                            </td>
                                            <td>
                                              Imprimir<br><input type="checkbox" name="chk8_<?php echo $i; ?>" id="chk8_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/print" <?php if(in_array($_c->component_name.'/print', $each_right)) echo "checked"; ?> />
                                            </td>
                                            <td>
                                              Contratos<br><input type="checkbox" name="chk9_<?php echo $i; ?>" id="chk9_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/letter" <?php if(in_array($_c->component_name.'/letter', $each_right)) echo "checked"; ?> />
                                            </td>
                                            <td>
                                              Renovar<br><input type="checkbox" name="chk10_<?php echo $i; ?>" id="chk10_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/renew" <?php if(in_array($_c->component_name.'/renew', $each_right)) echo "checked"; ?> />
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
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
                                      <td colspan="5">
                                        <table class="table" style="background-color:transparent !important">
                                          <tr>
                                            <td width="20%">
                                              <input type="checkbox" name="chk1_<?php echo $i; ?>" id="chk1_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/" <?php if(in_array($_c->component_name.'/', $each_right)) echo "checked"; ?> />
                                            </td>
                                            <td width="20%">
                                              <input type="checkbox" name="chk2_<?php echo $i; ?>" id="chk2_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/create" <?php if(in_array($_c->component_name.'/create', $each_right)) echo "checked"; ?> />
                                            </td>
                                            <td width="20%">
                                              <input type="checkbox" name="chk3_<?php echo $i; ?>" id="chk3_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/edit" <?php if(in_array($_c->component_name.'/edit', $each_right)) echo "checked"; ?> />
                                            </td>
                                            <td width="20%">
                                              <input type="checkbox" name="chk4_<?php echo $i; ?>" id="chk4_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/delete" <?php if(in_array($_c->component_name.'/delete', $each_right)) echo "checked"; ?> />
                                            </td>
                                            <td width="20%">
                                              <input type="checkbox" name="chk5_<?php echo $i; ?>" id="chk5_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/pdf" <?php if(in_array($_c->component_name.'/pdf', $each_right)) echo "checked"; ?> />
                                            </td>
                                          </tr>
                                          <tr><td>
                                              Vencidos<br><input type="checkbox" name="chk6_<?php echo $i; ?>" id="chk6_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/due" <?php if(in_array($_c->component_name.'/due', $each_right)) echo "checked"; ?> />
                                            </td>
                                            <td>
                                              Abonos<br><input type="checkbox" name="chk7_<?php echo $i; ?>" id="chk7_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/pay" <?php if(in_array($_c->component_name.'/pay', $each_right)) echo "checked"; ?> />
                                            </td>
                                            <td>
                                              Imprimir<br><input type="checkbox" name="chk8_<?php echo $i; ?>" id="chk8_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/loan_print" <?php if(in_array($_c->component_name.'/loan_print', $each_right)) echo "checked"; ?> />
                                            </td>
                                            <td>
                                              Contratos<br><input type="checkbox" name="chk9_<?php echo $i; ?>" id="chk9_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/loan_letter" <?php if(in_array($_c->component_name.'/loan_letter', $each_right)) echo "checked"; ?> />
                                            </td>
                                            <td>
                                              Renovar<br><input type="checkbox" name="chk10_<?php echo $i; ?>" id="chk10_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/renew" <?php if(in_array($_c->component_name.'/renew', $each_right)) echo "checked"; ?> />
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                      <?php
                                    }
                                    else
                                    {
                                      ?>
                                        <td>
                                          <input type="checkbox" name="chk1_<?php echo $i; ?>" id="chk1_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/" <?php if(in_array($_c->component_name.'/', $each_right)) echo "checked"; ?> />
                                        </td>
                                        <td>
                                          <input type="checkbox" name="chk2_<?php echo $i; ?>" id="chk2_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/create" <?php if(in_array($_c->component_name.'/create', $each_right)) echo "checked"; ?> />
                                        </td>
                                        <td>
                                          <input type="checkbox" name="chk3_<?php echo $i; ?>" id="chk3_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/edit" <?php if(in_array($_c->component_name.'/edit', $each_right)) echo "checked"; ?> />
                                        </td>
                                        <td>
                                          <input type="checkbox" name="chk4_<?php echo $i; ?>" id="chk4_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/delete" <?php if(in_array($_c->component_name.'/delete', $each_right)) echo "checked"; ?> />
                                        </td>
                                        <?php 
                                            if($_c->component_name == 'sales')
                                            {
                                              ?>
                                              <td>
                                                <input type="checkbox" name="chk5_<?php echo $i; ?>" id="chk5_<?php echo $i; ?>" value="<?php echo $_c->component_name; ?>/return_sales" <?php if(in_array($_c->component_name.'/return_sales', $each_right)) echo "checked"; ?> />
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

 <?php // include footer FIle 
 
 $this->load->view('admin/include/footer.php'); ?>			

