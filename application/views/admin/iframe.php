<?php 
include('include/common.php'); 
include('include/header.php'); 
include('include/sidebar.php');

$destiny = $this->uri->segment(2);
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750" style="height: 401px;">
    <!-- Content Header (Page header) -->
    <div class="nav navbar navbar-expand navbar-white navbar-light border-bottom p-0">
      <div class="nav-item dropdown">
        <a class="nav-link bg-danger dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Cerrar <?php echo $destiny; ?></a>
        <div class="dropdown-menu mt-0" style="left: 0px; right: inherit;">
          <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all">Cerrar todas</a>
          <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all-other">Cerrar todas excepto esta</a>
        </div>
      </div>
      <a class="nav-link bg-light" href="#" data-widget="iframe-scrollleft"><i class="fas fa-angle-double-left"></i></a>
      <ul class="navbar-nav overflow-hidden" role="tablist"></ul>
      <a class="nav-link bg-light" href="#" data-widget="iframe-scrollright"><i class="fas fa-angle-double-right"></i></a>
      <a class="nav-link bg-light" href="#" data-widget="iframe-fullscreen"><i class="fas fa-expand"></i></a>
    </div>
    <div class="tab-content">
      <div class="tab-empty" style="height: 634px;">
        <h2 class="display-4">No ha seleccionado ninguna página para mostrar!</h2>
      </div>
      <div class="tab-loading" style="height: 634px; display: none;">
        <div>
          <h2 class="display-4">Cargando <i class="fa fa-sync fa-spin"></i></h2>
        </div>
      </div>
    </div>

    <section class="content-header">
      <h1>Página web<small>externa</small></h1>
      <div class="breadcrumb">
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Permission (box) -->
      <div class="row">
        <div class="col-md-12">
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include('include/footer.php'); ?>
