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
                <a href="<?php echo base_url().'options/create'; ?>" class="btn btn-primary btn-sm pull-right">Nuevo atributo</a>
				
              </div>
              <!-- /.box-header -->
              <div class="box-body">
              <?php if($this->session->flashdata('msg') != false){ ?>
                 <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>  <i class="icon fa fa-check"></i> ¡Bien!</h4>
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
                <?php } ?>
              <?php 
                $attributes = array('id' => 'frm','name'=>'frm');
                echo form_open('options/delete',$attributes) ?>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th align="left" >Nombre</th>
                      <th align="left" >Atributo padre</th>
   										<th>Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
					  //$arids = array();
            $c= 0;
                      foreach ( $recored as $_recored ) {
                        
                  ?>
                            <tr>
                              <td><?php echo $_recored->option_name; ?></td>
                              <td>
                                  <?php 
                                    $CI =& get_instance();
                                    echo $CI->get_onpation_name($_recored->parent_id);
                                  ?>
                              </td>
       												<td>
                                <label class="switch">
                                  <input type="checkbox" <?php $is_act = 'yes'; if($_recored->option_is_active == 'yes') { echo 'checked'; $is_act = 'no'; }?> onchange="javascript:window.location.href='<?php echo base_url().'options/change_action/'.$_recored->option_id.'/'.$is_act; ?>'">
                                  <span class="slider round"></span>
                                </label>
                              <a class="action-edit btn btn-info btn-sm" href="<?php echo base_url().'options/edit/'.$_recored->option_id; ?>" class="action-edit" title="Editar"><i class="fa fa-edit"></i></a>
                              <a class="action-edit btn btn-danger btn-sm" href="<?php echo base_url().'options/delete/'.$_recored->option_id; ?>" class="action-edit" title="Eliminar"><i class="fa fa-close"></i></a>
                              </td>
							 
                            </tr>
                  <?php
                      $c++; 
                     }
                  ?>
                    </tbody>
                 
                </table>
               
              <?php echo form_close() ?>
              </div>
            </div>
          </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php // include footer FIle

 $this->load->view('admin/include/footer.php'); ?>			

