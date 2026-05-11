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
<title>Facture - Soporte al cliente</title>
<meta name='description' content='Tu software para préstamos y facturación en la nube. ' />	
<meta name='author' content='Alex Rafael Polanco Bobadilla, tel: 829-421-3797, email: info@pbwdesign.com' />
</head>
<body style='overflow: hidden;'>
<!-- Messenger Plugin de chat Code -->    <div id='fb-root'></div>    <!-- Your Plugin de chat code -->    <div id='fb-customer-chat' class='fb-customerchat'>    </div>    <script>     var chatbox = document.getElementById('fb-customer-chat');      chatbox.setAttribute('page_id', '157569461531675');      chatbox.setAttribute('attribution', 'biz_inbox');    </script>    <!-- Your SDK code -->    <script>      window.fbAsyncInit = function() {        FB.init({          xfbml            : true,          version          : 'v16.0'       });      };      (function(d, s, id) {        var js, fjs = d.getElementsByTagName(s)[0];        if (d.getElementById(id)) return;        js = d.createElement(s); js.id = id;        js.src = 'https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js';        fjs.parentNode.insertBefore(js, fjs);      }(document, 'script', 'facebook-jssdk'));    </script>
</body>
</html>
