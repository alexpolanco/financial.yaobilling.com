<?php
ini_set('memory_limit', '1024M');

$CI =& get_instance();
$company = $CI->get_company_data(); 

$company_terms = array();
$company_terms = explode(',',$company[0]->company_terms);
$loansdue = date("Y-m-d", strtotime($order[0]->end_date)) < date("Y-m-d") ? true : false;
$customer_first_name = rtrim($order[0]->customer_first_name);

$formatter = new NumeroALetras();

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor( $company[0]->company_name.' powered by PBwDesign');
$pdf->SetTitle('Carta de Saldo '.$customer_first_name.' Préstamo No. '.$order[0]->loans_no. ' '.date("d-m-Y"));
$pdf->SetSubject('PDF');
$pdf->SetKeywords('TCPDF, PDF, Carta de Saldo, Carta');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(30, 15, 30);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont("times", "", 12);

// add a page
$pdf->AddPage('P', 'LEGAL');
$output = '';
// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
if(date('H', strtotime($order[0]->entry_time)) < "12")
{ $timeOfTheDay = "mañana"; }
else
{ $timeOfTheDay = "tarde"; }

if($company[0]->LegalName_Sex == "Masculino")
{ $creditorSexHonor = "del señor"; $creditorSexType = "EL ACREEDOR"; }
else
{ $creditorSexHonor = "de la señora"; $creditorSexType = "LA ACREEDORA"; }

if($order[0]->customer_gender == "Masculino")
{ $debtorSexHonor = "el señor"; $debtorSexType = "EL DEUDOR"; }
else
{ $debtorSexHonor = "la señora"; $debtorSexType = "LA DEUDORA"; }

switch($order[0]->loanstype_frequency)
{
	case "Diario" : $_frequency = "día".($order[0]->duration > 1 ? "s" : ""); break;
	case "Semanal" : $_frequency = "semana".($order[0]->duration > 1 ? "s" : ""); break;
	case "Quincenal" : $_frequency = "quincena".($order[0]->duration > 1 ? "s" : ""); break;
	case "Mensual" : $_frequency = "mes".($order[0]->duration > 1 ? "es" : ""); break;
	case "Anual" : $_frequency = "año".($order[0]->duration > 1 ? "s" : ""); break;
	default : $_frequency = "mes".($order[0]->duration > 1 ? "es" : ""); break;
}

//$interes_amount = str_replace(',', '', $order[0]->loans_amount) * $order[0]->interes / 100;
$interes_amount = $order[0]->interes_amount;

setlocale(LC_ALL, 'es_ES');

$output .= '
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Carta de Saldo</title>
<style>#invoice{overflow:hidden;padding:10px 30px}.invoice{position:relative;background-color:#fff;min-height:380px;padding:1px}.invoice header{padding:0;margin-bottom:10px;border-bottom:1px solid #3989c6} .company-details{text-align:left}.company-details .name{margin-top:0;margin-bottom:0} .contacts{margin-bottom:10px}.invoice-to{text-align:left}.to{font-size: x-large;margin-top:0;margin-bottom:0;text-transform: uppercase;}.invoice-details{text-align:right} .invoice-id{font-size: xx-large;margin-top:0;color:#3989c6}main .thanks{margin-top:10px;}main .notices{padding-left:6px;border-left:6px solid #3989c6}main .notices .notice{font-size:1.2em}table{width:100%;border-collapse:collapse;border-spacing:0;margin-bottom:0}table td,table th{padding:3px;background:#eee;border-bottom:1px solid #fff}table th{white-space:nowrap;font-weight:400;font-size:16px}table td h3{margin:0;font-weight:400;color:#3989c6;font-size:1.2em}table .qty,table .total,table .unit{text-align:right;font-size:1.2em}table .no{color:#fff;font-size:1.6em;background:#3989c6}table .unit{background:#ddd}table .total{background:#3989c6;color:#fff}table tbody tr:last-child td{border:none}table tfoot td{background:0 0;border-bottom:none;white-space:nowrap;text-align:right;padding:0;border-top:1px solid #aaa}table tfoot tr:first-child td{border-top:none}table tfoot tr:last-child td{color:#3989c6;border-top:1px solid #3989c6}table tfoot tr td:first-child{border:none}footer{width:100%;text-align:center;color:#777;padding:0}</style>
</head>
<body>';

$pdf->ImageSVG($file=''.base_url().'file/company/'.$company[0]->company_id.'.svg', $x=88, $y=10, $w='', $h=40, $link='', $align='', $palign='', $border=0, $fitonpage=false);

$output .= '
<table width="100%" class="display">
<tr>
	<td style="text-align:center;"><img src="'.base_url().'file/company/'.$company[0]->company_id.'.jpg" width="1" height="1" /></td>
</tr>
<tr>
	<td style="text-align:center;font-size:9px">'.$company[0]->company_address.$company[0]->company_city.'<br>&nbsp;'.$company[0]->company_phone.' • '.$company[0]->company_email.'<br>
	</td>
</tr>
</table>

<p><b style="font-size:1.2em;text-align:center;margin:0;padding:0">CARTA DE SALDO</b></p>
<p></p>
<p>A quien pueda interesar:</p>
<p></p

<p>Por medio de la presente, le informamos que '.$debtorSexHonor.' <b><span style="text-transform:uppercase">'.$customer_first_name.'</span></b>, '.$order[0]->customer_nationality.', mayor de edad, '.$order[0]->customer_civilstatus.', '.$order[0]->customer_occupation.', titular de la cédula de identidad personal y electoral número
'.$order[0]->customer_personalid.', domiciliado y residente en '.$order[0]->customer_address.', ha saldado en su totalidad la deuda de <b>'.$formatter->toMoney(str_replace(',', '', $order[0]->loans_amount), 2, 'PESOS DOMINICANOS', 'CENTAVOS').' (RD$'.$order[0]->loans_amount.')</b>,
moneda de curso nacional, contraída mediante el pagare notarial de fecha <span style="text-transform:lowercase">'.$formatter->toMoney(date('d', strtotime($order[0]->entry_date)), 0, '', '').'</span>('.date('d', strtotime($order[0]->entry_date)).') días del mes de '.strftime('%B',strtotime($order[0]->entry_date)) .' del año dos mil <span style="text-transform:lowercase">'.$formatter->toMoney(date('y', strtotime($order[0]->entry_date))).'</span>('.date('Y', strtotime($order[0]->entry_date)).'), los cuales fueron recibidos en efectivo, lo que le sirve de descargo y finiquito ante la compañía de préstamos <b>"INVERSIONES GONZALEZ"</b>, y por lo que queda levantada cualquier oposición que pudiere tener sin ninguna objeción.</p>

<p>Dada en la ciudad y municipio de Nagua, provincia María Trinidad Sánchez, República Dominicana, a los <span style="text-transform:lowercase">'.$formatter->toMoney(date('d'), 0, '', '').'</span>('.date('d').') días del mes de '.strftime('%B',strtotime(date('Y-m-d'))) .' del año dos mil <span style="text-transform:lowercase">'.$formatter->toMoney(date('y')).'</span>('.date('Y').').</p>

<p></p>
<p></p>
<p></p>

<table style="text-align:center">
<tr>
	<td>__________________________________<br><b><span style="text-transform:uppercase">'.$company[0]->company_name.'</span></b><br><span style="text-transform: capitalize;">Representante.-</span></td>
</tr>
</table>

</body>
</html>';

//echo $output;
// output the HTML content
$pdf->writeHTML($output, true, false, true, false, '');

//Close and output PDF document
$pdf->Output('[carta de saldo] '.$customer_first_name.' prestamo no '.$order[0]->loans_no.' '.date("d-m-Y").'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>