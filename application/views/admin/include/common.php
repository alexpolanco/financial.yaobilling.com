<?php error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE); ?>
<!DOCTYPE html>
<html lang="es-ES">
<head><meta charset="utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>YaoLending System | <?php echo ucfirst($this->uri->segment(1));  ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="description" content="Tu software de préstamos, contabilidad y facturación en la nube. " />	
  <meta name="author" content="Alex Rafael Polanco Bobadilla, tel: 829-421-3797, email: info@pbwdesign.com" />
<!-- Bootstrap 3.3.5 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/bootstrap/css/bootstrap.min.css">
<!-- font Awesome -->
<link href="<?php echo base_url(); ?>_template/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Ionicons -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/bootstrap/css/ionicons.min.css">
<!-- Button css  -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/css/button_switch.css">
<!-- jvectormap -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/dist/css/skins/_all-skins.min.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>_template/bootstrap/css/developer.css">
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/plugins/select2/select2.min.css">
<!-- Date Picker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/css/datepicker.css" type="text/css" />
<!-- daterange picker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/plugins/daterangepicker/daterangepicker-bs3.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/plugins/iCheck/all.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/plugins/colorpicker/bootstrap-colorpicker.min.css">
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/plugins/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/css/datepicker.css" type="text/css" />
<!-- fullCalendar -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/plugins/fullcalendar/dist/fullcalendar.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/plugins/fullcalendar/dist/fullcalendar.print.min.css" media="print">

<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>_template/css/editor.dataTables.min.css">
<script type="text/javascript" src="<?php echo base_url(); ?>_template/js/dataTables.editor.min.js" language="javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>_template/js/common.js" language="javascript"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="_template/https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="_template/https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>table.dataTable td {font-size: 1em;}table.dataTable tr.dtrg-level-0 td {font-size: 1.1em;}.content-header>.breadcrumb{top:2px;} .content-header>h1 {font-size:28px; !important;} .products-list .product-info{margin-left:0}</style>
</head>
<body class="hold-transition sidebar-collapse sidebar-mini skin-blue">
<!-- Messenger Plugin de chat Code -->    <div id='fb-root'></div>    <!-- Your Plugin de chat code -->    <div id='fb-customer-chat' class='fb-customerchat'>    </div>    <script>     var chatbox = document.getElementById('fb-customer-chat');      chatbox.setAttribute('page_id', '157569461531675');      chatbox.setAttribute('attribution', 'biz_inbox');    </script>    <!-- Your SDK code -->    <script>      window.fbAsyncInit = function() {        FB.init({          xfbml            : true,          version          : 'v16.0'       });      };      (function(d, s, id) {        var js, fjs = d.getElementsByTagName(s)[0];        if (d.getElementById(id)) return;        js = d.createElement(s); js.id = id;        js.src = 'https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js';        fjs.parentNode.insertBefore(js, fjs);      }(document, 'script', 'facebook-jssdk'));    </script>
<div class="wrapper">
