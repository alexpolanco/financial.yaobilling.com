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
$pdf->SetTitle('Levantamiento de oposición '.$customer_first_name.' Préstamo No. '.$order[0]->loans_no. ' '.date("d-m-Y"));
$pdf->SetSubject('PDF');
$pdf->SetKeywords('TCPDF, PDF, Levantamiento de oposición, Carta');

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
$pdf->AddPage('P', 'LETTER');
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
<title>ACTO DE LEVANTAMIENTO DE OPOSICION A DESEMBOLSO DE DINERO, DEPÓSITO, EN AHORROS Y EMBARGO RETENTIVO</title>
<style></style>
</head>
<body>
<b style="font-size:1.2em;text-align:center;text-decoration:underline;text-decoration-style:double;margin:0;padding:0">ACTO DE LEVANTAMIENTO DE OPOSICION A DESEMBOLSO DE DINERO, DEPÓSITO, EN AHORROS Y EMBARGO RETENTIVO</b>
<p style="text-align:justify"><b>Acto No._________/ '.date('Y').'</b><br><br>

En el municipio de Nagua, provincia María Trinidad Sánchez, a los __________________ (___) días del mes de ________________ del año dos mil <span style="text-transform:lowercase">'.$formatter->toMoney(date('y')).'</span> ('.date('Y').'),
hora: ____________. 

Actuando a requerimiento '.$creditorSexHonor.' <b><span style="text-transform:uppercase">'.$company[0]->LegalName.'</span></b>, '.$company[0]->LegalName_Nationality.', mayor de edad, '.$company[0]->LegalName_CivilStatus.', '.$company[0]->LegalName_Occupation.',
titular de la cedula de identidad personal y electoral número '.$company[0]->LegalName_PersonalId.',
domiciliada y residente en '.$company[0]->LegalName_Address.', quien tiene como abogada constituida y apoderada a la <b>LICDA. ANDREINA GERMÁN MARTÍNEZ</b> dominicana, mayor de edad, soltera, Abogada de los Tribunales de la República Dominicana, portadora de la cédula de identidad y electoral No.060-0024084-3, con su estudio profesional abierto en la avenida María Trinidad Sánchez número 51, de esta ciudad de Nagua, provincia María Trinidad Sánchez, República Dominicana, miembro activo del Colegio de Abogados de la República Dominicana, que es donde mi requerida hace formal elección de domicilio para todos los fines y consecuencias legales del presente acto:<br><br>
Yo;<br> ____________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________
<br><br>
Expresamente y en virtud del anterior requerimiento y siempre actuando dentro de mi jurisdicción: <b>PRIMERO:</b> Me he trasladado a la calle María Trinidad Sánchez, primer nivel, edifico Plaza Ventura, que es donde  me consta que tiene su asiento comercial la sucursal de la <b>COOPERATIVA NACIONAL DE SERVICIOS MULTIPLES DE LOS MAESTROS, INC.</b> y una vez allí, hablando personalmente con ______________________________________________ quien me dijo ser __________________________ de mi requerida, la intermediación financiera <b>COOPERATIVA NACIONAL DE SERVICIOS MULTIPLES DE LOS MAESTROS, INC.</b> según me lo ha declarado persona con calidad y capacidad para recibir actos de esta naturaleza, lo cual es de mi conocimiento; le he notificado, dejado y leído en calidad ya expresada lo siguiente: que mi requiriente la señora <b><span style="text-transform:uppercase">'.$company[0]->LegalName.'</span></b>, por medio del presente acto le manifiesta que autoriza el levantamiento de la oposición  practicada mediante el acto No.'.$order[0]->opposition_no.'/2023, de fecha <span style="text-transform:lowercase">'.$formatter->toMoney(date('d', strtotime($order[0]->opposition_date)), 0, '', '').'</span> ('.date('d', strtotime($order[0]->opposition_date)).') días del mes de '.strftime('%B',strtotime($order[0]->opposition_date)) .' del año dos mil <span style="text-transform:lowercase">'.$formatter->toMoney(date('y', strtotime($order[0]->opposition_date))).'</span> ('.date('Y', strtotime($order[0]->opposition_date)).'), instrumentado por el ministerial <b>ANGEL LOPEZ GELABERT</b> Alguacil Ordinario del Tribunal de Tierras de Jurisdicción Original de María Trinidad Sánchez, por lo que mi requirente <b>AUTORIZA</b> a que dicha institución page, entregue, desembolse o de cualquier forma que fuere se desapodere de cualquier suma de dinero o de valores, que tenga depositado, ahorrado, o acumulado en aportaciones, o ahorro retirable, a cualquier título que fuere, o mancomunado con cualquier persona física o moral, en capital e intereses a nombre o propiedad '.$debtorSexHonor.' <b><span style="text-transform:uppercase">'.$customer_first_name.'</span></b>, '.$order[0]->customer_nationality.', mayor de edad, '.$order[0]->customer_civilstatus.', '.$order[0]->customer_occupation.', titular de la cédula de identidad personal y electoral número '.$order[0]->customer_personalid.', domiciliado y residente en '.$order[0]->customer_address.', y de tránsito en este municipio de Nagua, provincia María Trinidad Sánchez, advirtiéndole a dicha institución <b>COOPERATIVA NACIONAL DE SERVICIOS MULTIPLES DE LOS MAESTROS, INC.</b> que mi requiriente le libera de cualquier tipo de responsabilidad, con la ejecución del levantamiento de la oposición de referencia la cual se practicó sustentada en el pagare notarial número: <b style="text-decoration:underline;">'.$formatter->toMoney($order[0]->contract_number, 0, '', '').' ('.$order[0]->contract_number.') 
FOLIO'.($order[0]->contract_folio2=="" ? "" : "S").' NÚMERO'.($order[0]->contract_folio2=="" ? "" : "S").': '.$formatter->toMoney($order[0]->contract_folio1, 0, '', '').($order[0]->contract_folio2=="" ? "" : " Y ".$formatter->toMoney($order[0]->contract_folio2, 0, '', '')).' ('.$order[0]->contract_folio1.($order[0]->contract_folio2=="" ? "" : " y ".$order[0]->contract_folio2).')</b>, de fecha <span style="text-transform:lowercase">'.$formatter->toMoney(date('d', strtotime($order[0]->entry_date)), 0, '', '').'</span> ('.date('d', strtotime($order[0]->entry_date)).') días del mes de '.strftime('%B',strtotime($order[0]->entry_date)) .' del año dos mil <span style="text-transform:lowercase">'.$formatter->toMoney(date('y', strtotime($order[0]->entry_date))).'</span> ('.date('Y', strtotime($order[0]->entry_date)).'), debidamente instrumentado y legalizado por la <b><span style="text-transform:uppercase">'.$company[0]->Lawyer_Name.'</span></b>, Notario Público de los del número y para el municipio de Nagua, anexa este acto por la cantidad de <b>'.$formatter->toMoney(str_replace(',', '', $order[0]->loans_amount), 2, 'PESOS DOMINICANOS', 'CENTAVOS').' (RD$'.$order[0]->loans_amount.')</b>, donde se establece que '.$debtorShortSexHonor.' <b><span style="text-transform:uppercase">'.$customer_first_name.'</span></b> es deudor de la cantidad de <b>'.$formatter->toMoney(str_replace(',', '', $order[0]->loans_amount), 2, 'PESOS DOMINICANOS', 'CENTAVOS').' (RD$'.$order[0]->loans_amount.')</b>, de la señora <b><span style="text-transform:uppercase">'.$company[0]->LegalName.'</span></b> por conceptos del capital y los intereses vencidos. En tal virtud mi requiriente AUTORIZA EL LEVANTAMIENTO DE LA REFERIDA OPISICION POR HABER DESAPARECIDO LAS CAUSAS QUE LA GENERARON.

<br><br>
<table style="text-align:center">
<tr>
<td><b>BAJO TODA CLASE DE RESERVA</b></td>
</tr>
</table>
<br><br>

Y para que mi requerida entidad de intermediación <b>COOPERATIVA NACIONAL DE SERVICIOS MULTIPLES DE LOS MAESTROS, INC.</b> no alegue ignorancia y desconocimiento del presente acto, así se lo he notificado y advertido, conjuntamente dejándole en mano de la persona con quien dije haber hablado antes en el lugar de mi traslado copia fiel y conforme a lo original del acto No.'.$order[0]->opposition_no.'/2023, de fecha <span style="text-transform:lowercase">'.$formatter->toMoney(date('d', strtotime($order[0]->opposition_date)), 0, '', '').'</span> ('.date('d', strtotime($order[0]->opposition_date)).') días del mes de '.strftime('%B',strtotime($order[0]->opposition_date)) .' del año dos mil <span style="text-transform:lowercase">'.$formatter->toMoney(date('y', strtotime($order[0]->opposition_date))).'</span> ('.date('Y', strtotime($order[0]->opposition_date)).'), instrumentado por el ministerial <b>ANGEL LOPEZ GELABERT</b> Alguacil Ordinario del Tribunal de Tierras Jurisdicción Original de María Trinidad Sánchez, copia fiel de la cedula de la señora <b><span style="text-transform:uppercase">'.$company[0]->LegalName.'</span></b> y el original de presente acto de notificación, debidamente firmado, sellado y rubricado por mí, Alguacil actuante de todo lo cual <b>CERTIFICO Y DOY FE</b>. Este acto consta de dos (2) fojas y un costo de RD$____________.

<br><br>

<table style="text-align:center">
<tr>
<td><b><span style="text-decoration:underline;text-transform:uppercase">'.$company[0]->LegalName.'</span></b><br>Acreedor y autoriza el levantamiento</td>
</tr>
</table>

<br><br>
<br>

<table style="text-align:center">
<tr>
<td><b>DOY FE</b></td>
</tr><tr>
<td></td>
</tr>
<tr>
<td>__________________________________<br><b><span style="text-transform:uppercase">EL ALGUACIL.-</span></b></td>
</tr>
</table>

<br><br>
<br>

<table style="text-align:center">
<tr>
<td><b><span style="text-decoration:underline">Licda. Dulcyna María Fermín Guzmán</span></b><br>Abogada apoderada</td>
</tr>
</table>

</body>
</html>';

//echo $output;
// output the HTML content
$pdf->writeHTML($output, true, false, true, false, '');

//Close and output PDF document
$pdf->Output('[levantamiento de oposicion] '.$customer_first_name.' prestamo no '.$order[0]->loans_no.' '.date("d-m-Y").'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>