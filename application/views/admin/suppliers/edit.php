

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Editar Proveedor</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('') ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="<?php echo base_url('suppliers') ?>">Proveedores</a></li>
        <li class="active">Editar Proveedor</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <?php if ($this->session->flashdata("success")): ?>
            <script>
              swal("¡Bien!", "<?php echo $this->session->flashdata('success'); ?>", "success");
            </script>
          <?php endif ?>
          <?php if ($this->session->flashdata("error")): ?>
            <script>
              swal("¡Error!", "<?php echo $this->session->flashdata('error'); ?>", "error");
            </script>
          <?php endif ?>

          <form role="form" action="<?php base_url('suppliers/create') ?>" method="post" enctype="multipart/form-data">
            <div class="pull-left">
              <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Actualizar cambios</button>
            </div>
            <div class="pull-right">
              <a href="<?php echo base_url('suppliers') ?>" class="btn btn-warning btn-sm"><i class="fa fa-reply"></i> Regresar</a>
            </div><br><br>
            <div class="box">
              <div class="box-body">
                <?php if (validation_errors()): ?>
                  <script>
                    swal("¡Atención!", "<?php echo preg_replace( "/\r|\n/", "", validation_errors() ); ?>", "warning");
                  </script>
                <?php endif ?>
                <div class="row col-sm-12">
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab_1" data-toggle="tab">Información del proveedor</a></li>
                      <li><a href="#tab_2" data-toggle="tab">Catálogo de productos</a></li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane active" id="tab_1">
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="form-group">
                              <div class="alert alert-info alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  Favor de llenar todos los campos con *
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="suppliername" class="col-sm-4 control-label">Nombre*</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" id="suppliername" name="suppliername" placeholder="Nombre" value="<?php echo $supplier_data['suppliername'] ?>" autocomplete="off">
                              </div>
                            </div>
                              
                            <div class="form-group">
                              <label for="rnc" class="col-sm-4 control-label">RNC*</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" id="rnc" name="rnc" placeholder="RNC" value="<?php echo $supplier_data['rnc'] ?>" autocomplete="off">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="address" class="col-sm-4 control-label">Dirección</label>
                              <div class="col-sm-8">
                                <textarea type="text" class="form-control" id="address" name="address" placeholder="Dirección" autocomplete="off"><?php echo $supplier_data['address'] ?></textarea>
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="legalname" class="col-sm-4 control-label">Representante</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" id="legalname" name="legalname" placeholder="Representante" value="<?php echo $supplier_data['legalname'] ?>" autocomplete="off">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="phone" class="col-sm-4 control-label">Teféfono</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Teléfono" value="<?php echo $supplier_data['phone'] ?>" data-inputmask='"mask": "(999) 999-9999"' data-mask="" autocomplete="off">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="fax" class="col-sm-4 control-label">Fax</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" id="fax" name="fax" placeholder="Fax" value="<?php echo $supplier_data['fax'] ?>" data-inputmask='"mask": "(999) 999-9999"' data-mask="" autocomplete="off">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="email" class="col-sm-4 control-label">Email</label>
                              <div class="col-sm-8">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" value="<?php echo $supplier_data['email'] ?>">
                              </div>
                            </div>                

                            <div class="form-group">
                              <label for="website" class="col-sm-4 control-label">Website</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" id="website" name="website" placeholder="Página web" value="<?php echo $supplier_data['website'] ?>" autocomplete="off">
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="bank_account" class="col-sm-4 control-label">Cuenta bancaria</label>
                              <div class="col-sm-8">
                                <textarea class="form-control" id="bank_account" name="bank_account" placeholder="Cuenta bancaria" autocomplete="off"><?php echo $supplier_data['bank_account'] ?></textarea>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="notes" class="col-sm-4 control-label">Comentario</label>
                              <div class="col-sm-8">
                                <textarea class="form-control" id="notes" name="notes" placeholder="Comentario" autocomplete="off"><?php echo $supplier_data['notes'] ?></textarea>
                              </div>
                            </div>
                          </div>
                          <!-- /.col-lg-6 -->

                          <div class="col-lg-6">
                            <div class="form-group">
                              <label for="supplier_image" class="col-sm-4 control-label">Subir Foto</label>
                              <div class="kv-avatar col-sm-8">
                                <div class="file-loading">
                                  <input id="supplier_image" name="supplier_image" type="file">
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- /.col-lg-6 -->
                        </div>
                        <!-- /.row -->
                      </div>
                      <!-- /.tab-pane -->
                      <div class="tab-pane" id="tab_2">
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label for="supplier_catalog1" class="col-sm-4 control-label">Subir Cátalogo 1</label>
                              <div class="kv-avatar col-sm-8">
                                <div class="file-loading">
                                  <input id="supplier_catalog1" name="supplier_catalog1" type="file">
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- /.col-lg-6 -->
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label for="supplier_catalog2" class="col-sm-4 control-label">Subir Cátalogo 2</label>
                              <div class="kv-avatar col-sm-8">
                                <div class="file-loading">
                                  <input id="supplier_catalog2" name="supplier_catalog2" type="file">
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- /.col-lg-6 -->
                        </div>
                        <!-- /.row -->
                      </div>
                      <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <div class="pull-left">
              <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Actualizar cambios</button>
            </div>
            <div class="pull-right">
              <a href="<?php echo base_url('suppliers') ?>" class="btn btn-warning btn-sm"><i class="fa fa-reply"></i> Regresar</a>
            </div><br><br>
          </form>

        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script type="text/javascript">
$(document).ready(function() {
  $("#groups").select2();

  $("#mainSupplierNav").addClass('active');
  $("#manageSuppliersNav").addClass('active');

  $("[data-mask]").inputmask();
  $("#supplier_image").fileinput({
    initialPreview: ["<?php echo !empty($supplier_data['photofilename']) ? base_url($supplier_data['photofilename']) : base_url("/assets/images/No-image-found.jpg"); ?>"],
    initialPreviewAsData: true,
    initialPreviewConfig: [
        {caption: "Proveedor <?php echo $supplier_data['suppliername'] ?>", downloadUrl: "<?php echo !empty($supplier_data['photofilename']) ? base_url($supplier_data['photofilename']) : base_url("/assets/images/No-image-found.jpg"); ?>", size: 930321, width: "120px", key: 1}
    ],
    overwriteInitial: false,
    maxFileSize: 1500,
    showClose: false,
    showRemove:false,
    showCaption: false,
    browseLabel: ' Examinar en el equipo',
    removeLabel: '',
    theme: "gly",
    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
    removeTitle: 'Quitar imagen',
    elErrorContainer: '#kv-avatar-errors-1',
    msgErrorClass: 'alert alert-block alert-danger',
    defaultPreviewContent: '<img src="<?php echo !empty($supplier_data['photofilename']) ? base_url($supplier_data['photofilename']) : base_url("/assets/images/No-image-found.jpg"); ?>" width="100" alt="Proveedor <?php echo $supplier_data['suppliername'] ?>">',
    layoutTemplates: {main: '{preview} ' +  /*btnCust +*/ ' {remove} {browse}'},
    allowedFileExtensions: ["jpg", "png", "gif"]
  });

  $("#supplier_catalog1").fileinput({
    initialPreview: ["<?php echo !empty($supplier_data['catalogfile1']) ? base_url($supplier_data['catalogfile1']) : base_url("/assets/images/No-image-found.jpg"); ?>"],
    initialPreviewAsData: true,
    initialPreviewConfig: [
        {caption: "Catálogo 1 <?php echo $supplier_data['suppliername'] ?>", downloadUrl: "<?php echo !empty($supplier_data['catalogfile1']) ? base_url($supplier_data['catalogfile1']) : base_url("/assets/images/No-image-found.jpg"); ?>", size: 930321, width: "120px", key: 2}
    ],
    overwriteInitial: false,
    maxFileSize: 3072,
    showClose: false,
    showRemove:false,
    showCaption: false,
    browseLabel: ' Examinar en el equipo',
    removeLabel: '',
    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i> ',
    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
    removeTitle: 'Quitar imagen',
    elErrorContainer: '#kv-avatar-errors-1',
    msgErrorClass: 'alert alert-block alert-danger',
    defaultPreviewContent: '<img src="<?php echo !empty($supplier_data['catalogfile1']) ? base_url($supplier_data['catalogfile1']) : base_url("/assets/images/No-image-found.jpg"); ?>" width="100" alt="Cátalogo 1 de productos de <?php echo $supplier_data['suppliername'] ?>">',
    layoutTemplates: {main: '{preview} ' +  /*btnCust +*/' {remove} {browse}'},
    allowedFileExtensions: ["pdf", "txt", "jpg", "png", "gif"]
  });

  $("#supplier_catalog2").fileinput({
    initialPreview: ["<?php echo !empty($supplier_data['catalogfile2']) ? base_url($supplier_data['catalogfile2']) : base_url("/assets/images/No-image-found.jpg"); ?>"],
    initialPreviewAsData: true,
    initialPreviewConfig: [
        {caption: "Catálogo 2 <?php echo $supplier_data['suppliername'] ?>", downloadUrl: "<?php echo !empty($supplier_data['catalogfile2']) ? base_url($supplier_data['catalogfile2']) : base_url("/assets/images/No-image-found.jpg"); ?>", size: 930321, width: "120px", key: 3}
    ],
    overwriteInitial: false,
    maxFileSize: 3072,
    showClose: false,
    showRemove:false,
    showCaption: false,
    browseLabel: ' Examinar en el equipo',
    removeLabel: '',
    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i> ',
    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
    removeTitle: 'Quitar imagen',
    elErrorContainer: '#kv-avatar-errors-1',
    msgErrorClass: 'alert alert-block alert-danger',
    defaultPreviewContent: '<img src="<?php echo !empty($supplier_data['catalogfile2']) ? base_url($supplier_data['catalogfile2']) : base_url("/assets/images/No-image-found.jpg"); ?>" width="100" alt="Cátalogo 2 de productos de <?php echo $supplier_data['suppliername'] ?>">',
    layoutTemplates: {main: '{preview} ' +  /*btnCust +*/ ' {remove} {browse}'},
    allowedFileExtensions: ["pdf", "txt", "jpg", "png", "gif"]
  });
});

function tabindexFix() {
  $("input[tabindex], textarea[tabindex]").each(function () {
    $(this).on("keypress", function (e) {
      if (e.keyCode === 13)
      {
        var nextElement = $('[tabindex="' + (this.tabIndex + 1) + '"]');
        if (nextElement.length) {
          $('[tabindex="' + (this.tabIndex + 1) + '"]').focus();
          e.preventDefault();
        } else
          $('[tabindex="1"]').focus();
      }
    });
  });
}
</script>
