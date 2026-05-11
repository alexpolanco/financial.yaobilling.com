<?php
// Add FIle
// include common file
$this->load->view('admin/include/common.php'); 
// include header file
$this->load->view('admin/include/header.php'); 
// include sidebar file  
$this->load->view('admin/include/sidebar.php');

$CI =& get_instance();
$check_rights = $CI->check_rights();
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

  <?php 
    $attributes = array('id' => 'frm','name'=>'frm');
      echo form_open_multipart('company/update',$attributes); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Empresa: <?php echo htmlspecialchars($objcompany['company_name']); ?>
      </h1>
      <div class="breadcrumb">
        <input type="submit" name="btnsubmit" class="btn btn-lg btn-primary" value="Guardar" title="Guardar" />
        <button type="button" onclick="backupg();" id="babcd" class="btn btn-lg btn-danger" title="Realizar un backup a la base de datos">Backup</button>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
            
                <?php if($this->session->flashdata('msg') != false){ ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>  <i class="icon fa fa-check"></i> ¡Alerta!</h4>
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
              
                <div class="box box-primary">
                  <div class="col-md-6" style="background: #ffffff;">
                
                          <div class='box-body pad'>
                                <div class="form-group">
                                    <label>Nombre :</label>
                                    <input type="text" id="txtfirst_name" name="txtfirst_name" class="form-control " placeholder="Nombre de la empresa..." value="<?php echo htmlspecialchars($objcompany['company_name']); ?>" />
                                </div>
                                
                                <div class="form-group">
                                    <label>RNC :</label>
                                    <input type="text" name="txtRNC" class="form-control " placeholder="RNC..." value="<?php echo htmlspecialchars($objcompany['company_rnc']); ?>" />
                                </div>
                                
                                <div class="form-group">
                                    <label>Ciudad :</label>
                                    <input type="text" name="txtcity" class="form-control " placeholder="Ciudad..." value="<?php echo htmlspecialchars($objcompany['company_city']); ?>" />
                                </div>
                                
                                <div class="form-group">
                                  <label>Teléfono :</label><br />
                                  <input type="text" class="form-control" name="txt_company_phone" data-inputmask='"mask": "(999) 999-9999"' data-mask="" value="<?php echo htmlspecialchars($objcompany['company_phone']); ?>" placeholder="Teléfono..." />
                                </div>
                                                  
                                <div class="form-group">
                                  <label>Dirección :</label>
                                  <input type="text" class="form-control" name="txtaddress" value="<?php echo htmlspecialchars($objcompany['company_address']); ?>" />
                                </div>
                            </div>
                    </div>
                            
              <div class="col-md-6" style="background: #ffffff;">
                <div class='box-body pad'>
                                  
                  <div class="col-md-8">
                      <div class="form-group">
                          <label>Logo :</label><br />
                          <input type="file"  name="fl_clogo" />
                          <br />
                          <?php
                          $image = 'file/company/'.$objcompany['company_image'];
                          if (file_exists($image)) {
                                  echo '<input type="checkbox" name="chkdelete_logo" value="yes"  /> <label> Eliminar Logo</label><br />';
                                  ?>
                                  <input type="checkbox" <?php if($objcompany['recipe_print'] == 'yes') echo 'checked="checked"'; ?>   name="chkprint_logo" value="yes"  /> <label> Imprimir Logo en las facturas</label>
                                  <?php
                              }
                          ?>
                      </div>                
                      <div class="form-group">
                        <label>Email :</label>
                        <input type="text" class="form-control" name="txt_company_email" value="<?php echo htmlspecialchars($objcompany['company_email']); ?>" />
                      </div>
                                         
                      <div class="form-group">
                        <label>Página web :</label>
                        <input type="text" class="form-control" name="txt_company_url" value="<?php echo htmlspecialchars($objcompany['company_url']); ?>" />
                      </div>
                                        
                      <div class="form-group">
                        <label>Slogan :</label>
                        <input type="text" class="form-control" name="txt_company_slogan" value="<?php echo htmlspecialchars($objcompany['company_slogan']); ?>" />
                      </div>
                  </div>
                
                  <?php 
                        if ( file_exists($image) ) {
                            echo '<div class="col-md-4"><img src="'.base_url().$image.'" width="150" alt="Logo" /></div>';
                        }
                    ?>
                  </div>
              </div>
            </div><!-- /.box -->
        </div><!-- /.col-->
      </div>

      <br />
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="col-md-6" style="background: #ffffff;">
        
              <div class='box-body pad'>
              
                <div class="form-group">
                      <label>Representante :</label>
                      <input type="text" name="txtLegalName" class="form-control " placeholder="Representante de la empresa..." value="<?php echo htmlspecialchars($objcompany['LegalName']); ?>" />
                  </div>
                  
                  <div class="form-group">
                      <label>Cédula :</label>
                      <input type="text" name="txtLegalName_PersonalId" class="form-control " data-inputmask='"mask": "999-9999999-9"' data-mask="" placeholder="Cédula del representante..." value="<?php echo htmlspecialchars($objcompany['LegalName_PersonalId']); ?>" />
                  </div>
                  
                  <div class="form-group">
                      <label>Ocupación :</label>
                      <input type="text" name="txtLegalName_Occupation" class="form-control " placeholder="Ocupación..." value="<?php echo htmlspecialchars($objcompany['LegalName_Occupation']); ?>" />
                  </div>
                  
                  
                  <div class="form-group">
                    <label for="txtLegalName_Sex" class="">Sexo :</label>
                    <input type="radio" name="txtLegalName_Sex" <?php if($objcompany['LegalName_Sex'] == 'Masculino') echo 'checked'; ?> placeholder="Sexo..." value="Masculino" /> Masculino
                    <input type="radio" name="txtLegalName_Sex" <?php if($objcompany['LegalName_Sex'] == 'Femenino' || htmlspecialchars($objcompany['LegalName_Sex']) == null) echo 'checked'; ?> placeholder="Sexo..." value="Femenino" /> Femenino
                  </div>

                  <div class="form-group">
                      <label>Nacionalidad :</label>
                      <input type="text" name="txtLegalName_Nationality" class="form-control " placeholder="Nacionalidad..." value="<?php echo htmlspecialchars($objcompany['LegalName_Nationality']); ?>" />
                  </div>
                  
                  <div class="form-group">
                    <label>Estado civil :</label><br />
                    <input type="text" class="form-control" name="txtLegalName_CivilStatus" value="<?php echo htmlspecialchars($objcompany['LegalName_CivilStatus']); ?>" placeholder="Teléfono..." />
                  </div>
                                    
                  <div class="form-group">
                    <label>Dirección :</label>
                    <input type="text" class="form-control" name="txtLegalName_Address" value="<?php echo htmlspecialchars($objcompany['LegalName_Address']); ?>" />
                  </div>

                </div>
              </div>

              <div class="col-md-6" style="background: #ffffff;">
                <div class='box-body pad'>
                  
                <div class="form-group">
                      <label>Abogado notario :</label>
                      <input type="text" name="txtLawyer_Name" class="form-control " placeholder="Abogado notario de la empresa..." value="<?php echo htmlspecialchars($objcompany['Lawyer_Name']); ?>" />
                  </div>
                  
                  <div class="form-group">
                      <label>Cédula :</label>
                      <input type="text" name="txtLawyer_PersonalId" class="form-control " data-inputmask='"mask": "999-9999999-9"' data-mask="" placeholder="Cédula del representante..." value="<?php echo htmlspecialchars($objcompany['Lawyer_PersonalId']); ?>" />
                  </div>
                  
                  <div class="form-group">
                      <label>Nacionalidad :</label>
                      <input type="text" name="txtLawyer_Nationality" class="form-control " placeholder="Nacionalidad..." value="<?php echo htmlspecialchars($objcompany['Lawyer_Nationality']); ?>" />
                  </div>
                  
                  <div class="form-group">
                    <label>Estado civil :</label><br />
                    <input type="text" class="form-control" name="txtLawyer_CivilStatus" value="<?php echo htmlspecialchars($objcompany['Lawyer_CivilStatus']); ?>" placeholder="Teléfono..." />
                  </div>
                                    
                  <div class="form-group">
                    <label>Ciudad:</label>
                    <input type="text" class="form-control" name="txtLawyer_City" value="<?php echo htmlspecialchars($objcompany['Lawyer_City']); ?>" />
                  </div>
                  
                  <div class="form-group">
                    <label>Dirección profesional:</label>
                    <input type="text" class="form-control" name="txtLawyer_Address" value="<?php echo htmlspecialchars($objcompany['Lawyer_Address']); ?>" />
                  </div>
                  
                  <div class="form-group">
                    <label>Matricula :</label>
                    <input type="text" class="form-control" name="txtLawyer_Matricula" value="<?php echo htmlspecialchars($objcompany['Lawyer_Matricula']); ?>" />
                  </div>
                        
                  <div class="form-group">
                    <label>Código de notario :</label>
                    <input type="text" class="form-control" name="txtLawyer_NotaryNumber" value="<?php echo htmlspecialchars($objcompany['Lawyer_NotaryNumber']); ?>" />
                  </div>

                </div>
              </div>
            </div><!-- /.box -->
        </div><!-- /.col-->
      </div>

      <br />
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="col-md-6" style="background: #ffffff;">
        
              <div class='box-body pad'>
              
                <div class="form-group">
                      <label>Nombre del primer testigo :</label>
                      <input type="text" name="txtWitnessName1" class="form-control " placeholder="Nombre del primer testigo..." value="<?php echo htmlspecialchars($objcompany['WitnessName1']); ?>" />
                  </div>
                  
                  <div class="form-group">
                      <label>Cédula :</label>
                      <input type="text" name="txtWitness1_PersonalId" class="form-control " data-inputmask='"mask": "999-9999999-9"' data-mask="" placeholder="Cédula del primer testigo..." value="<?php echo htmlspecialchars($objcompany['Witness1_PersonalID']); ?>" />
                  </div>
                  
                  <div class="form-group">
                      <label>Ocupación :</label>
                      <input type="text" name="txtWitness1_Occupation" class="form-control " placeholder="Ocupación..." value="<?php echo htmlspecialchars($objcompany['Witness1_Occupation']); ?>" />
                  </div>
                  
                  <div class="form-group">
                    <label for="txtWitness1_Sex" class="">Sexo :</label>
                    <input type="radio" name="txtWitness1_Sex" <?php if($objcompany['Witness1_Sex'] == 'Masculino') echo 'checked'; ?> placeholder="Sexo..." value="Masculino" /> Masculino
                    <input type="radio" name="txtWitness1_Sex" <?php if($objcompany['Witness1_Sex'] == 'Femenino' || htmlspecialchars($objcompany['Witness1_Sex']) == null) echo 'checked'; ?> placeholder="Sexo..." value="Femenino" /> Femenino
                  </div>

                  <div class="form-group">
                      <label>Nacionalidad :</label>
                      <input type="text" name="txtWitness1_Nationality" class="form-control " placeholder="Nacionalidad..." value="<?php echo htmlspecialchars($objcompany['Witness1_Nationality']); ?>" />
                  </div>
                  
                  <div class="form-group">
                    <label>Estado civil :</label><br />
                    <input type="text" class="form-control" name="txtWitness1_CivilStatus" value="<?php echo htmlspecialchars($objcompany['Witness1_CivilStatus']); ?>" placeholder="Estado civil..." />
                  </div>
                                    
                  <div class="form-group">
                    <label>Dirección :</label>
                    <input type="text" class="form-control" name="txtWitness1_Address" value="<?php echo htmlspecialchars($objcompany['Witness1_Address']); ?>" />
                  </div>

                </div>
              </div>

              <div class="col-md-6" style="background: #ffffff;">
                <div class='box-body pad'>
                  
                <div class="form-group">
                      <label>Nombre del segundo testigo :</label>
                      <input type="text" name="txtWitnessName2" class="form-control " placeholder="Nombre del segundo testigo..." value="<?php echo htmlspecialchars($objcompany['WitnessName2']); ?>" />
                  </div>
                  
                  <div class="form-group">
                      <label>Cédula :</label>
                      <input type="text" name="txtWitness2_PersonalId" class="form-control " data-inputmask='"mask": "999-9999999-9"' data-mask="" placeholder="Cédula del segundo testigo..." value="<?php echo htmlspecialchars($objcompany['Witness2_PersonalID']); ?>" />
                  </div>
                  
                  <div class="form-group">
                      <label>Ocupación :</label>
                      <input type="text" name="txtWitness2_Occupation" class="form-control " placeholder="Ocupación..." value="<?php echo htmlspecialchars($objcompany['Witness2_Occupation']); ?>" />
                  </div>
                  
                  <div class="form-group">
                    <label for="txtWitness2_Sex" class="">Sexo :</label>
                    <input type="radio" name="txtWitness2_Sex" <?php if($objcompany['Witness2_Sex'] == 'Masculino') echo 'checked'; ?> placeholder="Sexo..." value="Masculino" /> Masculino
                    <input type="radio" name="txtWitness2_Sex" <?php if($objcompany['Witness2_Sex'] == 'Femenino' || htmlspecialchars($objcompany['Witness2_Sex']) == null) echo 'checked'; ?> placeholder="Sexo..." value="Femenino" /> Femenino
                  </div>

                  <div class="form-group">
                      <label>Nacionalidad :</label>
                      <input type="text" name="txtWitness2_Nationality" class="form-control " placeholder="Nacionalidad..." value="<?php echo htmlspecialchars($objcompany['Witness2_Nationality']); ?>" />
                  </div>
                  
                  <div class="form-group">
                    <label>Estado civil :</label><br />
                    <input type="text" class="form-control" name="txtWitness2_CivilStatus" value="<?php echo htmlspecialchars($objcompany['Witness2_CivilStatus']); ?>" placeholder="Estado civil..." />
                  </div>
                  
                  <div class="form-group">
                    <label>Dirección:</label>
                    <input type="text" class="form-control" name="txtWitness2_Address" value="<?php echo htmlspecialchars($objcompany['Witness2_Address']); ?>" />
                  </div>

                </div>
              </div>
            </div><!-- /.box -->
        </div><!-- /.col-->
      </div>

      <br />
      <div class="row">  
        <div class='col-md-12'>
                    <div class='box box-danger' >
                        <div class='box-header'>
                            <h3 class='box-title'><i class="fa fa-money" aria-hidden="true"></i>Impuestos</h3>
                        </div><!-- /.box-header -->
                        
                            <div class="col-md-6" style="background: #ffffff;">
                

                          <div class='box-body pad'>
                                  <div class="form-group">
                                        <label>Impuesto 1 :</label>
                                        <input type="text" name="txtgst_no" class="form-control " placeholder="Impuesto 1..." value="<?php echo htmlspecialchars($objcompany['company_gst_no']); ?>" />
                                    </div>


                                  <div class="form-group">
                                        <label>Impuesto 2 :</label>
                                        <input type="text" name="txtvat_no" class="form-control " placeholder="Impuesto 2..." value="<?php echo htmlspecialchars($objcompany['company_vat_no']); ?>" />
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Otro impuesto :</label>
                                        <input type="text" name="txtcst_no" class="form-control " placeholder="Impuesto 3..." value="<?php echo htmlspecialchars($objcompany['company_cst_no']); ?>" />
                                    </div>

                                </div>
                            </div>
                            
                            <div class="col-md-6" style="background: #ffffff;">
                <div class='box-body pad'>
                                    
                                    <div class="form-group">
                                        <label>Impuesto 1 (%):</label>
                                        <input type="text" name="txtsales_tax3" class="form-control " placeholder="Valor del impuesto..." value="<?php echo htmlspecialchars($objcompany['sales_tax3']); ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label>Impuesto 2 (%):</label>
                                        <input type="text" name="txtsales_tax1" class="form-control " placeholder="Valor del impuesto..." value="<?php echo htmlspecialchars($objcompany['sales_tax1']); ?>" />
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Otro impuesto (%):</label>
                                        <input type="text" name="txtsales_tax2" class="form-control " placeholder="Valor del impuesto..." value="<?php echo htmlspecialchars($objcompany['sales_tax2']); ?>" />
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                </div>
                            </div>
                    </div><!-- /.box -->
        </div><!-- /.col-->
      </div>  
      <br/> 
      
    <?php if (in_array('sales',$check_rights) || in_array('sales/create',$check_rights) || in_array('sales/order-view',$check_rights)) { ?>
      <div class="row">  
        <div class='col-md-12'>
          <div class='box box-success' >
                      <div class='box-header'>
                            <h3 class='box-title'>Total de mesas a mostrar</h3>
                        </div><!-- /.box-header -->
            <div class='box-body pad'>
              
                <div class="col-md-6">
                                  <div class="form-group">
                                      <label>Mesas</label>
                                        <input type="text" name="txttable" class="form-control " placeholder="Número de mesas..." value="<?php echo htmlspecialchars($objcompany['total_table']); ?>" />
                                    </div>
                </div>
                <div class="col-md-6">
                                  <div class="form-group">
                                      <label>Mesas VIP</label>
                                        <input type="text" name="txtparcel" class="form-control " placeholder="Número de mesas VIP..." value="<?php echo htmlspecialchars($objcompany['total_parcel']); ?>" />
                                    </div>
                </div>
                
            </div>
          </div>
        </div>
      </div>
    <?php } ?>

      <div class="row">
                <div class='col-md-12'>
          <div class='box box-warning' >
                      <div class='box-header'>
                            <h3 class='box-title'>Términos y políticas de la empresa</h3>
                        </div><!-- /.box-header -->
            <div class='box-body pad'>
              
                <div class="col-md-12">
                                  <div class="form-group">
                                      <label>Política</label>
                                        <input type="text" name="txtterms" class="form-control " placeholder="Introduzca las políticas de ventas..." value="<?php echo htmlspecialchars($objcompany['company_terms']); ?>" />
                                    </div>
                </div>
                
            </div>
          </div>
        </div>
      </div>
      
      <?php if($this->session->userdata('userid') == 1) { ?>
      <div class="row">
        <div class='col-md-12'>
          <div class='box box-warning' >
              <div class='box-header'>
                <h3 class='box-title'>SMS </h3>
              </div><!-- /.box-header -->
            <div class='box-body pad'>
                <div class="col-md-6">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label>Enviar mensaje</label>
                            <input type="checkbox" name="chksms"   value="yes"  <?php if($objcompany['sms'] == 'yes') echo 'checked="checkd"'; ?>/>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                  
                    <div class="col-md-12">
                      <div class="form-group">
                          <label>API de Mensajes</label>
                            <input type="text" name="txtsmsapi" class="form-control "  value="<?php echo htmlspecialchars($objcompany['sms_api']); ?>" />
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>

        <style>
 .loading-image {
  position: absolute;
  top: 50%;
  left: 50%;
  z-index: 10;
}
.loader
{
    display: none;
    width:200px;
    height: 200px;
    position: fixed;
    top: 40%;
    left: 50%;
    text-align:center;
    margin-left: -50px;
    margin-top: -100px;
    z-index:99999;
    overflow: auto;
  
}
 </style>
        <div class="loader">
           <center>
             <img class="loading-image" src="<?php echo base_url(); ?>_template/images/ajax-loader1.gif" alt="cargando..">
           </center>
        </div>
                   
      <!-- /.row -->
    </section>
    <!-- /.content -->
  <?php echo form_close(); ?>
  </div>
  <!-- /.content-wrapper -->

 <?php // include footer FIle 
 
 $this->load->view('admin/include/footer.php'); ?>			

<script type="text/javascript">
  document.getElementById('txtfirst_name').focus();
  
  function backupg()
  {
    jQuery.ajax({
      type: "GET",  
      url: "<?php echo base_url() ?>ajax/backup_db/index"
    }).done(function( msg ) {
    
      jQuery("#babcd").html(msg)
      
    })
  }
</script>

