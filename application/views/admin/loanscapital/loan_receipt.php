<?php
ini_set('memory_limit', '1024M');

	//print_r($order);

$CI =& get_instance();
$company = $CI->get_company_data(); 

$company_terms = array();
$company_terms =explode(',',$company[0]->company_terms);
$loansdue = date("Y-m-d", strtotime($order[0]->end_date)) < date("Y-m-d") ? true : false;

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('. $company[0]->company_name.'.' powered by PBwDesign');
$pdf->SetTitle($order[0]->customer_first_name.' Préstamo No. '.$order[0]->loans_no.' Recibo de Pago '.($loansdue ? 'Fuera de Fecha (' : 'Activo (').date("d-m-Y").')');
$pdf->SetSubject('PDF');
$pdf->SetKeywords('TCPDF, PDF, Recibo de Pago, Recibo');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont("helvetica", "B",10);

// add a page
$pdf->AddPage();
$output = '';
// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content	
	$output .='
	<div id="div_wrapper" style="width:100%;height:250px;border: solid #000 .5px;">
	<table style="margin-top:0px;" width="100%" border="0">
	<tr>
		<td><span class="font10 bold">' . $company[0]->company_name . '</span></td>
		<td><span class="font10 bold">Pagare NO.: $week</span></td>
	</tr>
	<tr>
		<td><span class="font8">'.$company[0]->company_address.' '.$company[0]->company_city. '</span></td>
		<td>Fecha: '.date("d-m-Y").'</td>
	</tr>
	<tr>
		<td colspan="2">'.$company[0]->company_phone.'</td>
	</tr>
	</table>

	<div class="opacity" style="margin-bottom:3px;border-top-style:dotted;width="100%">
	</div>

	<div class="font10 bold" style="margin-bottom:5px;">
		$fullname
	</div>

	<table border="0" width="100%">
		<tr>
			<td><span class="">Entregado en... '.date("d-m-Y", strtotime($order[0]->start_date)).' y Termina en... '.date("d-m-Y", strtotime($order[0]->end_date)).'</span></td>
			<td align="right"><span style="margin-right:30px;">Monto Prestado: '.$order[0]->loans_amount.'</span></td>
		</tr>
		<tr>
			<td><span class="font10 bold">Valor RD: '.$order[0]->interes.'</span></td>
			<td><span class="font10 bold">Balance: $balance</span></td>
		</tr>
	</table>

	<div class="opacity" style="border-bottom-style:dotted;">
	</div>
		<table border="0" width="100%">
		 <tr>
			<td>Cobrador: $collector</td>
			<td>Zona: $zona</td>
		 </tr>
		</table>
	<div class="opacity" style="border-top-style:dotted;">
	</div>
	<table border="0" width="100%">
	<tr>
		<td><span>Direccón de Casa:</span></td>
		<td colspan="2">'.$order[0]->customer_address.'</td>
	</tr>
	<tr>
		<td>Teléfono:</td>
		<td>'.$order[0]->customer_phone.'</td>
		<td>Cliente #: '.$order[0]->customer_first_name.'</td>
	</tr>
	<tr>
		<td>Ocupacción de trabajo:</td>
		<td>$ocupation</td>
		<td>Prestamo #: '.$order[0]->loans_no.'</td>
	</tr>
	<tr>
		<td>Dirección de trabajo:</td>
		<td colspan="2">$debtor_work_address</td>
	</tr>
	<tr>
		<td>Al lado de:</td>
		<td>$next_to</td>
		<td>Cédula NO: '.$order[0]->customer_personalid.'</td>
	</tr>

	<tr>
		<td>Recomendado por:</td>
		<td colspan="2">$cosigner</td>
	</tr>
	</table>
	</div>
	<br/>';
		
	$loanstotal = floatval(number_format($_loans_total, 2, '.', ''));
	

// output the HTML content
$pdf->writeHTML($output, true, false, true, false, '');

//Close and output PDF document
$pdf->Output($order[0]->customer_first_name.' prestamo no '.$order[0]->loans_no.' '.($loansdue ? 'Fuera de fecha ' : 'Activo ').date("d-m-Y").'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>