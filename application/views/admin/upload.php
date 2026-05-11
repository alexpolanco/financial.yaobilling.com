<!DOCTYPE html>

<html>

<head>

<title>Subir archivo</title>

</head>

<body>

<?php echo $error; ?>

<h3>Subir</h3>

<?php echo form_open_multipart('upload/upload_file'); ?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>

</body>

</html>
