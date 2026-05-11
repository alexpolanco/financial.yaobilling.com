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
      <h1>Usuarios</h1>
      <div class="breadcrumb">
        <a href="<?php echo base_url().'users/create'; ?>" class="btn btn-primary btn-lg" title="Nuevo usuario">Nuevo Usuario</a>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
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
                echo form_open('users/delete',$attributes) ?>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th align="left" >Rol</th>
   										<th align="left" >Nombre completo</th>
   										<th align="left" >Usuario</th>
   										<th align="left" >Balance</th>
   										<th>Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
					  $arids = array();
                      foreach ( $recored as $_recored ) {
                        $arids[] = $_recored->user_id;
                  ?>
                            <tr>
                              <td><?php $CI =& get_instance();  echo $CI->get_group_name($_recored->user_group_id); ?></td>
       												<td><?php echo $_recored->user_fullname; ?></td>
       												<td><?php echo $_recored->user_name; ?></td>
       												<td><?php echo $_recored->balance; ?></td>
       												<td>
                                <label class="switch">
                                  <input type="checkbox" <?php $is_act = 'yes'; if($_recored->user_active == 'yes') { echo 'checked'; $is_act = 'no'; }?> onchange="javascript:window.location.href='<?php echo base_url().'users/active_inactive/'.$_recored->user_id.'/'.$is_act; ?>'">
                                  <span class="slider round"></span>
                                </label>
                                <a class="action-edit btn btn-info btn-sm" href="<?php echo base_url().'users/edit/'.$_recored->user_id; ?>" class="action-edit" title="Editar"><i class="fa fa-edit"></i></a>
                                <a class="action-edit btn btn-danger btn-sm" href="<?php echo base_url().'users/delete/'.$_recored->user_id; ?>" class="action-edit" title="Eliminar"><i class="fa fa-close"></i></a>
                              </td>
							 
                            </tr>
                  <?php 
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

