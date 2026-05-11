

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Perfil
        <small>Empleado</small>
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
              <h3 class="box-title">Empleado <?php echo $employee_data['name']; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-condensed table-hovered">
                <tr>
                  <th>C&eacute;dula</th>
                  <td><?php echo $employee_data['personal_id']; ?></td>
                </tr>
                <tr>
                  <th>Direcci&oacute;n</th>
                  <td><?php echo $employee_data['address']; ?></td>
                </tr>
                <tr>
                  <th>Ocupaci&oacute;n</th>
                  <td><?php echo $employee_data['profession']; ?></td>
                </tr>
                <tr>
                  <th>Tel&eacute;fono</th>
                  <td><?php echo $employee_data['phone'] . " " . $employee_data['phone2'];?></td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td><?php echo $employee_data['email'] . " " .$employee_data['email2']; ?></td>
                </tr>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo base_url('employee/') ?>" class="btn btn-warning">Regresar</a>
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

 
