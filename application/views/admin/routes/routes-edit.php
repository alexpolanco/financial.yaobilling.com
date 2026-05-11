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
      echo form_open_multipart('routes/update/'.$this->uri->segment(3),$attributes); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Editar ruta: <?php echo $recored['routes_name']; ?>
      </h1>
      <ol class="breadcrumb">
        <input type="submit" name="btnsubmit" class="btn btn-primary" value="Guardar" title="Guardar"/>
        <input type="button" value="Cancelar" class="btn btn-danger" onclick="javascript:window.location.href='<?php echo base_url().'routes' ?>'" title="Cancelar" />
      </ol>
    </section>

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
                        <label>Ruta :</label>
                        <input type="text" name="txt_routes_name" class="form-control " placeholder="Nombre de la ruta..." value="<?php echo $recored['routes_name']; ?>"  onFocus="getcities()" />
                    </div>
                    <div class="form-group">
                        <label>Tipo de préstamo :</label>
                        <select name="txt_district_id" class="form-control ">
                            
                         <?php 
                            foreach ($loanstype as $value) {
                                ?>
                                <option value="<?php echo $value->loanstype_id; ?>" <?php if($recored['loanstype_id'] ==  $value->loanstype_id ) echo 'selected'; ?>><?php echo $value->loanstype_name; ?></option>
                                <?php
                            }
                          ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cobrador principal :</label>
                        <select name="txt_collector_id" class="form-control ">
                            
                         <?php 
                            foreach ($collector as $value) {
                                ?>
                                <option value="<?php echo $value->collector_id; ?>" <?php if($recored['collector_id'] ==  $value->collector_id ) echo 'selected'; ?>><?php echo $value->collector_first_name; ?></option>
                                <?php
                            }
                          ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cobrador secundario :</label>
                        <select name="txt_collector_aux_id" class="form-control ">
                            <option value="0"></option>                            
                         <?php 
                            foreach ($collector as $value) {
                                ?>
                                <option value="<?php echo $value->collector_id; ?>" <?php if($recored['collector_aux_id'] ==  $value->collector_id ) echo 'selected'; ?>><?php echo $value->collector_first_name; ?></option>
                                <?php
                            }
                          ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Provincia :</label>
                        <select id="txt_district_id" name="txt_district_id" class="form-control" onChange="getcities()">
                            
                         <?php 
                            foreach ($district as $value) {
                                ?>
                                <option value="<?php echo $value->district_id; ?>" <?php if($recored['parent_id'] ==  $value->district_id ) echo 'selected'; ?>><?php echo $value->district_name; ?></option>
                                <?php
                            }
                          ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ciudad :</label>
                        <select id="txt_cities_id" name="txt_cities_id" class="form-control ">
                            
                         <?php 
                            foreach ($cities as $value) {
                                ?>
                                <option value="<?php echo $value->cities_id; ?>" <?php if($recored['cities_id'] ==  $value->cities_id ) echo 'selected'; ?>><?php echo $value->cities_name; ?></option>
                                <?php
                            }
                          ?>
                        </select>
                    </div>
					         <div class="form-group">
                        <label>Descripción :</label>
                        <textarea name="txt_routes_description"  ><?php echo $recored['routes_description']; ?></textarea>
                    </div>      
                     <div class="form-group">
                        <label>¿Está activa? :</label>
                        <input type="radio" name="txt_routes_is_active" <?php if($recored['routes_is_active'] == 'yes') echo 'checked'; ?> placeholder="Está activa..." value="yes" /> Si
                        <input type="radio" name="txt_routes_is_active" <?php if($recored['routes_is_active'] == 'no') echo 'checked'; ?> placeholder="Está activa..." value="no" /> No
                    </div>
                     
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
              </div>
            </div>
          </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  <?php echo form_close(); ?>
  </div>
  <!-- /.content-wrapper -->
<script type="text/javascript">
// get the cities information from the server
function getcities()
{
    var parent_id = $("#txt_district_id").val();
    $.ajax({
        url: "<?php echo base_url() ?>ajax/getcities/index",
        type: 'GET',
        data: { "<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",parent_id : parent_id }
        }).done(function( data ) {
            $('#txt_cities_id').html(data);
    }); // /ajax function to fetch the cities data 
}
</script>
 <?php // include footer FIle 
 
 $this->load->view('admin/include/footer.php'); ?>			

