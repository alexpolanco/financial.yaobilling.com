<html>

<head>

<title>Subida de archivo exitosa</title>

</head>

<body>

<h3>Archivo subido exitosamente.</h3>

<ul>

<?php foreach ($upload_data as $item => $value): ?>

<li><?php echo $item;?>: <?php echo $value;?></li>

<?php endforeach; ?>

<li><?php echo "<h3>Archivo subido:</h3>"; ?></li>
<li>
  <img src="<?php echo base_url().'/uploads/'.$upload_data['file_name']; ?>" /></li>

</ul>

<p><?php echo anchor('upload', '¡Subir otro archivo!'); ?></p>

</body>

</html>