<!DOCTYPE html>
<html lang='es'>
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0, shrink-to-fit=no'>
<meta http-equiv='X-UA-Compatible' content='ie=edge'>
<link rel='icon' type='image/png' href='<?php echo base_url() ?>favicon.ico'>
<link rel="icon" type="image/ico" href="<?php echo base_url().'YaoBilling.ico' ?>" sizes="128x128" />
<link rel="apple-touch-icon" href="<?php echo base_url() ?>'favicon.png'" sizes="192x192">    
<link rel='apple-touch-icon' href='<?php echo base_url() ?>favicon.ico' sizes='76x76'>
<title>Facture Cloud Loans - Login</title>
<meta name='description' content='Tu software para préstamos y facturación en la nube. ' />	
<meta name='author' content='Alex Rafael Polanco Bobadilla, tel: 829-421-3797, email: info@pbwdesign.com' />
<link href='https://fonts.googleapis.com/css?family=Karla:400,700&display=swap' rel='stylesheet'>
<link rel='stylesheet' href='https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css'>
<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css'>
<link rel='stylesheet' href='<?php echo base_url() ?>_template/css/login.css'>
<link rel='stylesheet' href='<?php echo base_url() ?>_template/bootstrap/css/font-awesome.min.css'>
<style type='text/css'>
#featured { width: auto; height: 660px; background: #009cff url('<?php echo base_url() ?>_template/images/loading.gif') no-repeat center center; overflow: hidden; }
@media (max-width: 422px){ .login-card .card-body { height: 600px !important; } }
</style>
<!--[if IE]>
<style type='text/css'>
.timer { display: none !important; } div.caption { background:transparent; filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000,endColorstr=#99000000);zoom: 1; }
</style>
<![endif]-->
<script type='text/javascript' src='<?php echo base_url() ?>_template/js/jquery-1.4.1.min.js'></script>
<script type='text/javascript' src='<?php echo base_url() ?>_template/js/jquery.orbit.min.js'></script>
<script type='text/javascript'>
$(window).load(function() {
    $('#featured').orbit({
        'bullets': true,
        'timer' : true,
        'animation' : 'fade'
    });
});
</script>
</head>
<body style='overflow: hidden;'>
<main class='d-flex align-items-center min-vh-100 py-3 py-md-0'>
<div class='container'>
<div class='card login-card'>
<div class='row no-gutters'>
<div class='col-md-6 d-none d-md-block'>
<div id='featured'>
<img src='<?php echo base_url() ?>_template/images/slide_0.jpg' alt='Link' rel='slide_0'  class='login-card-img' />
<img src='<?php echo base_url() ?>_template/images/slide_1.jpg' alt='Link' rel='slide_1'  class='login-card-img' />
<img src='<?php echo base_url() ?>_template/images/slide_2.jpg' alt='Link' rel='slide_2'  class='login-card-img' />
<img src='<?php echo base_url() ?>_template/images/slide_3.jpg' alt='Link' rel='slide_3'  class='login-card-img' />
<img src='<?php echo base_url() ?>_template/images/slide_4.jpg' alt='Link' rel='slide_4'  class='login-card-img' />
<img src='<?php echo base_url() ?>_template/images/slide_5.jpg' alt='Link' rel='slide_5'  class='login-card-img' />
<img src='<?php echo base_url() ?>_template/images/slide_6.jpg' alt='Link' rel='slide_6'  class='login-card-img' />
<img src='<?php echo base_url() ?>_template/images/slide_7.jpg' alt='Link' rel='slide_7'  class='login-card-img' />
<img src='<?php echo base_url() ?>_template/images/slide_8.jpg' alt='Link' rel='slide_8'  class='login-card-img' />
<img src='<?php echo base_url() ?>_template/images/slide_9.jpg' alt='Link' rel='slide_9'  class='login-card-img' />
</div>
<span class='orbit-caption' id='slide_0'>Sistema integral de préstamos, contabilidad y facturación para PyMES.<br><br></span>
<span class='orbit-caption' id='slide_1'>La opción más avanzada para gestionar tu empresa.<br><br></span>
<span class='orbit-caption' id='slide_2'>Calcula préstamos con diferente modalidad de pago (Diario, Semanal, Quincenal, Mensual).<br><br></span>
<span class='orbit-caption' id='slide_3'>Reporte detallado de los ingresos de cada préstamo (Capital abonado, interés y Mora).<br><br></span>
<span class='orbit-caption' id='slide_4'>Genera e imprime el recibo de cada pago realizado.<br><br></span>
<span class='orbit-caption' id='slide_5'>Genera e imprime el pagare notarial de cada préstamo.<br><br></span>
<span class='orbit-caption' id='slide_6'>Listado de todos los préstamos que están pendiente de pago.<br><br></span>
<span class='orbit-caption' id='slide_7'>Sistema diseñado para pantallas táctiles, práctico y fácil de utilizar.<br><br></span>
<span class='orbit-caption' id='slide_8'>Muestra notificaciones de clientes pendiente de pago, préstamos con atrazo, etc...<br><br></span>
<span class='orbit-caption' id='slide_9'>Para que te sientas más seguro, podrás descargar copia de todos tus datos en el sistema.<br><br></span>
</div>
<div class='col-md-6'>
<div class='card-body'>
<div class='brand-wrapper'>
<img src='<?php echo base_url() ?>logo.png' alt='logo' class='logo'> <span style='font-size: x-large; font-weight: 600; vertical-align: middle;'>Facture para prestamistas</span>
</div>
<p class='login-card-description' style='font-size: 16px !important;'>Sistema integral de préstamos para Inversiones González</p>
<p class='login-card-description'>Inicia sesión <?php echo $this->session->userdata('user'); ?></p>
<?php if($this->session->flashdata('logout_msg') != false){ ?>
  <div class="alert alert-success alert-dismissable">
    <h4>  <i class="icon fa fa-check"></i> ¡Bien!</h4>
    <?php echo $this->session->flashdata('logout_msg'); ?>
  </div>
<?php } ?>

<?php if($this->session->flashdata('msg') != false){ ?>
  <div class="alert alert-danger alert-dismissable">
    <h4>  <i class="icon fa fa-ban"></i> ¡Error!</h4>
    <?php echo $this->session->flashdata('msg'); ?>
  </div>
<?php } ?>

<?php if(validation_errors() != false){ ?>
<div class="alert alert-danger alert-dismissable">
  <h4><i class="icon fa fa-ban"></i> ¡Error!</h4>
  <?php echo validation_errors(); ?>
</div>
<?php } ?>
<?php 
  $attributes = array('id' => 'frm','name'=>'frm',"class"=>"form-4");
  echo form_open('login/check',$attributes) ?>
<?php  //$hidden = array($this->security->get_csrf_token_name() => $this->security->get_csrf_hash()); echo form_open('login/check', '', $hidden); ?>
<div class='form-group'>
<label for='user_name' class='sr-only'>Email</label>
<input type='text' name='user_name' id='user_name' class='form-control' placeholder='Introduzca su nombre de usuario'>
</div>
<div class='form-group mb-4'>
<label for='password' class='sr-only'>Contraseña</label>
<input type='password' name='password' id='password' class='form-control' placeholder='***********'>
</div>
<input name='login' id='login' class='btn btn-block login-btn mb-4' type='submit' value='Acceder'>
</form>
<span class='forgot-password-link'>¿Olvidó su nombre de usuario o contraseña? <br>Contácte a soporte técnico: <a target="_blank" href="tel:829-421-3797" class="forgot-password-link mx-1" data-toggle="tooltip" data-placement="top" title="Llamar al soporte técnico"><i class="fa fa-phone" aria-hidden="true"></i></a>
<a target="_blank" href="mailto:pbwdesign@hotmail.com" class="forgot-password-link mx-1" data-toggle="tooltip" data-placement="top" title="Enviar correo electrónico al soporte técnico"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
<a target="_blank" href="https://wa.me/8294213797" class="forgot-password-link mx-1" data-toggle="tooltip" data-placement="top" title="Contactar por WhatsApp al soporte técnico"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></span>
            
<nav class='login-card-footer-nav'>
<small class='login-wrapper-footer-text' style='bottom: 14px;position: absolute;'>&copy; PBwDesign (Alex Rafael Polanco Bobadilla) <?php echo date('Y'); ?>, todos los derechos reservados.
 C/ Narciso Minaya, 60, Nagua, MTS 33000, República Dominicana. Teléfono: <a target="_blank" href="tel:829-421-3797" class="forgot-password-link mx-1" data-toggle="tooltip" data-placement="top" title="Llamar al soporte técnico">829-421-3797</a>, Email: <a target="_blank" href="mailto:pbwdesign@hotmail.com" class="forgot-password-link mx-1" data-toggle="tooltip" data-placement="top" title="Enviar correo electrónico al soporte técnico">polancobobadilla@gmail.com</a></small>
</nav>
</div>
</div>
</div>
</div>
</div>
</main>
<script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js'></script>
</body>
</html>
