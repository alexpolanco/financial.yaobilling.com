

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Perfil
        <small>Proveedor</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Perfil</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Proveedor <?php echo $supplier_data['suppliername']; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-condensed table-hovered">
                <tr>
                  <th>RNC</th>
                  <td><?php echo $supplier_data['rnc']; ?></td>
                </tr>
                <tr>
                  <th>Direcci&oacute;n</th>
                  <td><?php echo $supplier_data['address']; ?></td>
                </tr>
                <tr>
                  <th>Representante</th>
                  <td><?php echo $supplier_data['legalname']; ?></td>
                </tr>
                <tr>
                  <th>Tel&eacute;fono</th>
                  <td><?php echo $supplier_data['phone']; ?></td>
                </tr>
                <tr>
                  <th>Fax</th>
                  <td><?php echo $supplier_data['fax']; ?></td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td><?php echo $supplier_data['email']; ?></td>
                </tr>
                <tr>
                  <th>Website</th>
                  <td><?php echo $supplier_data['website']; ?></td>
                </tr>
                <tr>
                  <th>Comentario</th>
                  <td><?php echo $supplier_data['notes']; ?></td>
                </tr>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo base_url('suppliers/') ?>" class="btn btn-warning">Regresar</a>
            </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 
