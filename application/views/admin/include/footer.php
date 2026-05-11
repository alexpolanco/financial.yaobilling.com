  <footer class="main-footer" style="display: none;">
    <div class="pull-right hidden-xs">
    <span><b>YaoLending</b> v1.0.0</span>  
    <a target="__blank" href="tel:829-421-3797"  class=" mx-2" data-toggle="tooltip" data-placement="top" title="Llamar al soporte técnico"><i class="fa fa-phone" aria-hidden="true"></i></a>  <a target="__blank" href="mailto:pbwdesign@hotmail.com" class="mx-2" data-toggle="tooltip" data-placement="top" title="Enviar correo electrónico al soporte técnico"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>  <a target="__blank" href="https://wa.me/8294213797" class="mx-2" data-toggle="tooltip" data-placement="top" title="Contactar por WhatsApp al soporte técnico"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
    </div>
    <strong>&copy; <?php echo date('Y'); ?>, hecho con <i class="fa fa-heart own-de-i text-red"></i> por Alex <span class="hidden-xs">Rafael</span> Polanco <span class="hidden-xs">Bobadilla</span> <a href="//pbwdesign.com" target="_blank" rel="noreferrer">(PBwDesign)</a>.</strong> Todos los derechos reservados.
<?php
$myfile = fopen("company.txt", "w") or die("Unable to open file!");
$txt = $this->session->userdata('storename');
fwrite($myfile, $txt);
fclose($myfile);
?>
    </footer>

  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- pay form modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="externalModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="box-header with-border bg-aqua-active">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
          <h4 class="modal-title" id="external_info">Página externa</h4>
      </div>
      <div class="modal-body" id="externalContent"></div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- jQuery 3.5.1 -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url('_template/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('_template/plugins/select2/select2.full.min.js'); ?>"></script>
    <!-- InputMask -->
    <script src="<?php echo base_url('_template/plugins/inputmask/inputmask.js') ?>"></script>
    <script src="<?php echo base_url('_template/plugins/inputmask/jquery.inputmask.js') ?>"></script>
    <script src="<?php echo base_url('_template/plugins/inputmask/inputmask.numeric.extensions.js') ?>"></script>
    <script src="<?php echo base_url('_template/plugins/inputmask/inputmask.date.extensions.js') ?>"></script>
    <script src="<?php echo base_url('_template/plugins/inputmask/inputmask.extensions.js') ?>"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url('_template/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('_template/plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url('_template/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
    <script src="<?php echo base_url('_template/plugins/iCheck/icheck.min.js'); ?>"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url('_template/plugins/fastclick/fastclick.min.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url('_template/dist/js/app.min.js'); ?>"></script>
  
    <script src="<?php echo base_url('_template/js/bootstrap-datepicker.js'); ?>"></script>
    
    <script src="<?php echo base_url('_template/js/tinymce/tinymce.min.js'); ?>"></script>
    
    <script src="<?php echo base_url('_template/js/jquery.leanModal.min.js'); ?>"></script>  
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('_template/css/style_model.css'); ?>" />
    <script src="<?php echo base_url('_template/js/jquery.maskedinput.js'); ?>"></script>  
    
    <link rel="stylesheet" href="<?php echo base_url('_template/css/jquery-ui.css'); ?>">
    <script src="<?php echo base_url('_template/js/jquery-ui.js'); ?>"></script>
    
    <script src="https://adminlte.io/themes/v3/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
        $("a[rel*=leanModal]").leanModal({top : 50, overlay : 0.6, closeButton: ".modal_close" });
        $("[data-mask]").inputmask();
    });

    tinymce.init({
        selector: "textarea",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    });
    
      $(function () {
        $("table.display").DataTable({
            "language": {
                "lengthMenu": "_MENU_ resultados por página",
                "zeroRecords": "Lo sentimos, no se encontró información que coincida con sus terminos de búsqueda",
                "info": "Página _PAGE_ de _PAGES_",
                "search": "Buscador ",
            	"oPaginate"		:	{
            		'sFirst'			:	'Primero',
            		'sLast'				:	'Último',
            		'sNext'				:	'Siguiente',
            		'sPrevious'			:	'Anterior'
            	},
                "infoEmpty": "",
                "infoFiltered": "(_MAX_ resultados encontrados)"
            }
        });
      });
      
    function openExternalURL(url)
    {
      if(url) {
        //$('#externalContent').load(url);
        $("#externalContent").html('<object data="'+url+'">');
      };  
    }
    </script>

