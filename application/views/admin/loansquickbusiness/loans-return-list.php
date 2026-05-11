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
        Devolución de préstamo
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Devolución de préstamo</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header">
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
                echo form_open('loans/delete',$attributes) ?>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
   										<th align="left" >Cliente</th>
   										<th align="left" >Fecha </th>
   										<th align="left" >Total</th>
   										<th>Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
					  $arids = array();
                      foreach ( $recored as $_recored ) {
                        $arids[] = $_recored->purchase_id;
                  ?>
                            <tr>
       												<td><?php echo $_recored->purchase_party_name; ?></td>
       												<td><?php echo $_recored->purchase_dt; ?></td>
       												<td><?php echo $_recored->grand_total; ?></td>
       												<td>
                                  <button type="button" onclick="javascript:print_invoice('bill_1','<?php echo  $_recored->purchase_no; ?>')" class="btn btn-sm btn-info">Ver</button>
                              
                                <a href="<?php echo base_url() ?>loans/bill_print/<?php echo $_recored->purchase_no; ?>"><img src="<?php echo base_url() ?>_template/images/bprint.png" height="30" width="30" /></a>

                                <a class="action-edit btn btn-info btn-sm" href="<?php echo base_url().'loans/edit/'.$_recored->purchase_no; ?>" class="action-edit" title="Editar"><i class="fa fa-edit"></i></a>
                                <a class="action-edit btn btn-danger btn-sm" href="<?php echo base_url().'loans/delete/'.$_recored->purchase_no; ?>" class="action-edit" title="Eliminar"><i class="fa fa-close"></i></a>
                              </td>
							 
                            </tr>
                  <?php 
                     }
                  ?>
                    </tbody>
                 
                </table>
                <input type="hidden" name="hdnmode" id="hdnmode" value="" />
                <input type="hidden" name="hdnids" id="hdnids" value="<?php echo implode(',',$arids); ?>" />
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
<script type="text/javascript">
  
  function print_invoice(url , _orderno)
  {
    url = '<?php echo base_url() ?>loans/pdf/'+url+'/'+_orderno;
    
    var w = 900;
    var h = 600;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open(url,"_blank","resizable=yes,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,fullscreen=no,dependent=no,copyhistory=no,width="+w+",height="+h+",left="+left+",top="+top);
  }

  

</script>
