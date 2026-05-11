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
        Cobradores
      </h1>
      <div class="breadcrumb">
        <a href="<?php echo base_url().'collector/create'; ?>" class="btn btn-primary pull-right" title="Nuevo cobrador">Nuevo Cobrador</a>
		<a target="_blank" href="<?php echo base_url().'collector/pdf'; ?>" class="btn btn-primary pull-right" style="margin-right: 5px;" title="Exportar a PDF">Exportar a PDF</a>
		<a target="_blank" href="<?php echo base_url().'collector/excel'; ?>" class="btn btn-primary pull-right" style="margin-right: 5px;" title="Exportar a Excel">Exportar a Excel</a>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
            <div class="box">
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
                echo form_open('collector/delete',$attributes) ?>
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th align="left" >Nombre</th>
                      <th align="left" >Teléfono</th>
                      <th>Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $arids = array();
                      foreach ( $recored as $_recored ) {
                  ?>
                            <tr>

                              <td><?php echo $_recored->collector_first_name; ?></td>
                              <td><?php echo $_recored->collector_phone; ?></td>
                              <td>
                                <label class="switch">
                                  <input type="checkbox" <?php $is_act = 'yes'; if($_recored->collector_is_active == 'yes') { echo 'checked'; $is_act = 'no'; }?> onchange="javascript:window.location.href='<?php echo base_url().'collector/change_action/'.$_recored->collector_id.'/'.$is_act; ?>'">
                                  <span class="slider round"></span>
                                </label>
                                <a class="action-edit btn btn-info btn-sm" href="<?php echo base_url().'collector/edit/'.$_recored->collector_id; ?>" class="action-edit" title="Editar"><i class="fa fa-edit"></i></a>
                              <a class="action-edit btn btn-danger btn-sm" href="<?php echo base_url().'collector/delete/'.$_recored->collector_id; ?>" class="action-edit" title="Eliminar"><i class="fa fa-close"></i></a>
                              </td>
                            </tr>
                  <?php 
                    }
                  ?>
                    </tbody>
                  <tfoot>
                  </tfoot>
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

