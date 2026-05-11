<?php
	$order_no = $this->uri->segment(3);
	$CI =& get_instance();
	$company = $CI->get_company_data();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
	<meta name="robots" content="noindex"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<?php /*<link href="print3.css" rel="stylesheet" type="text/css"/>*/  ?>
	<link rel="shortcut icon" href="images/favicon.ico"/>
	<title><?php echo $company[0]->company_name; ?></title>

<!-- POS Bill Print -->
<?php /*<link rel="stylesheet" href="<?php echo base_url(); ?>_template/css/invoice-bill.css" /> */  ?>
<style>
html{ font-size: 12px; }.font8{ font-size:8px; }.font10{ font-size:10px; }.font12{ font-size:12px; }.font13{ font-size:13px; }.font14{ font-size:14px; }.font16{ font-size:16px; }.font18{ font-size:18px; }.font20{ font-size:20px; }.font22{ font-size:22px; }.font24{ font-size:24px; }.opacity{ opacity: 0.6; }.bold { font-weight: bold; }.italic{ font-style: italic; }
@media print
{
	#non-printable { display: none; }
	/*div.page-break { display: block; page-break-before: always; */
	
	.header, .hide { visibility: hidden }

	.page-break{
		page-break-after:always;
	}

	.print-button,#unicamente_alex{
		display:none;
	}
	@page {
	  size: auto;
	  margin: 0;
	}

	@page :first {
	  //used for the first page.;
	  //margin: 1cm 2cm;
	}

	body {
		font-family: "Times New Roman", Georgia, Serif;
		line-height: 1.0;
	}
}
</style>

</head>
<body>
<?php foreach($loans as $row) : ?>
<div id="div_wrapper" style="width:100%;height:250px;border: solid #000 .5px;">
	<table style="margin-top:0px;" width="100%" border="0">
	<?php
	if($company[0]->company_image != '' && $company[0]->recipe_print == 'yes') { 
		$logo = 'file/company/'.$company[0]->company_image;
		if (file_exists($logo) ) {
		?>
        <tr>
            <td rowspan="4"style="width:180px;"><img src="<?php echo base_url().$logo; ?>" style="border-width:0px;" /></td>
        </tr>
        <tr>
            <td align="right"><span class="font10 bold">Pagare NO.: <?php echo $row->payment_no; ?></span></td>
        </tr>
        <?php
		}
    }
	if($company[0]->recipe_print != 'yes'){ ?>
        <tr>
		    <td><span class="font10" bold><?php echo $company[0]->company_name; ?></span></td>
		    <td><span class="font10" bold>Pagare NO.: <?php echo $row->payment_no; ?></span></td>
    	</tr>
	<?php } ?>
    	<tr>
    		<td><span class="font8"><?php echo strip_tags($company[0]->company_address); ?>, <?php echo htmlspecialchars($company[0]->company_city); ?> </span></td>
    		<td>Fecha: <?php echo date("d-m-Y",strtotime($row->due_date));; ?></td>
    	</tr>
    	<tr>
    		<td colspan="2"><?php echo htmlspecialchars($company[0]->company_phone); ?></td>
    	</tr>
	</table>

	<div class=opacity style="margin-bottom:3px;border-top-style:dotted;width='100%'"></div>
	<div class="font10 bold" style="margin-bottom:5px;"><?php echo $row->customer_first_name; ?></div>

	<table border="0" width="100%">
		<tr>
			<td><span class="">Entregado en... <?php echo date("d-m-Y",strtotime($row->entry_date)); ?> y Termina en... <?php echo date("d-m-Y",strtotime($row->end_date)); ?> </span></td>
			<td align="right"><span style="margin-right:30px;">Monto Prestado: <?php echo $row->loans_amount; ?></span></td>
		</tr>
		<tr>
			<td><span class="font10 bold">Valor RD: <?php echo $row->cuota; ?></span></td>
			<td><span class="font10 bold">Balance: <?php echo $row->balance; ?></span></td>
		</tr>
	</table>

	<div class="opacity" style="border-bottom-style:dotted;"></div>
	<table border="0" width="100%">
	 <tr>
		<td>Cobrador: <?php echo $row->collector_first_name; ?></td>
		<td>Zona: <?php echo $row->routes_name; ?></td>
	 </tr>
	</table>
	<div class="opacity" style="border-top-style:dotted;"></div>
	<table border="0" width="100%">
	<tr>
		<td><span>Direccion de casa:</span></td>
		<td colspan="2"><?php echo $row->customer_address; ?></td>
	</tr>
	<tr>
		<td>Teléfono:</td>
		<td><?php echo $row->customer_phone; ?> / <?php echo $row->customer_mobile; ?></td>
		<td>Cliente #: <?php echo $row->customer_id; ?></td>
	</tr>
	<tr>
		<td>Ocupacción de trabajo:</td>
		<td><?php echo $row->customer_ocupation; ?></td>
		<td>Préstamo #: <?php echo $order_no; ?></td>
	</tr>
	<tr>
		<td>Dirección de trabajo:</td>
		<td colspan="2"><?php echo $row->customer_workaddress; ?></td>
	</tr>
	<tr>
		<td>Al lado de:</td>
		<td><?php echo $next_to; ?></td>
		<td>Cédula NO: <?php echo $row->customer_personalid; ?></td>
	</tr>
	<tr>
		<td>Recomendado por:</td>
		<td colspan="2"></td>
	</tr>
	</table>
</div>
<br/>

<?php endforeach; ?>


<div id="non-printable">
	<center>
  	<a href="" onclick="printDiv()">Imprimir</a>
    <a href="<?php echo base_url(); ?>loans" class="">Regresar</a>
  </center>
</div>
<script>
window.onload = printDiv();
function printDiv() {
	window.print();
}
</script>
</div>
</body>
</html>
