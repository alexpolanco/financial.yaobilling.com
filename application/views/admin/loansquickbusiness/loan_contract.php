<?php
ini_set('memory_limit', '1024M');

$CI =& get_instance();
$company = $CI->get_company_data(); 

$company_terms = array();
$company_terms = explode(',',$company[0]->company_terms);
$loansdue = date("Y-m-d", strtotime($order[0]->end_date)) < date("Y-m-d") ? true : false;

$formatter = new NumeroALetras();

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor( $company[0]->company_name.' powered by PBwDesign');
$pdf->SetTitle('Pagaré Auténtico '.$customer_first_name.' Préstamo No. '.$order[0]->loans_no. ' '.date("d-m-Y"));
$pdf->SetSubject('PDF');
$pdf->SetKeywords('TCPDF, PDF, Pagaré Auténtico, Contrato');

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
{ $debtorSexHonor = "del señor"; $debtorSexType = "EL DEUDOR"; }
else
{ $debtorSexHonor = "de la señora"; $debtorSexType = "LA DEUDORA"; }

if($order[0]->guarantor1_gender == "Masculino")
{ $guarantor1SexHonor = "del señor"; $guarantor1SexType = "EL GARANTE"; }
else
{ $guarantor1SexHonor = "de la señora"; $guarantor1SexType = "LA GARANTE"; }

if($order[0]->guarantor2_gender == "Masculino")
{ $guarantor2SexHonor = "del señor"; $guarantor2SexType = "EL GARANTE"; }
else
{ $guarantor2SexHonor = "de la señora"; $guarantor2SexType = "LA GARANTE"; }

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
$customer_first_name = rtrim($order[0]->customer_first_name);

$guarantor1_first_name = rtrim($order[0]->guarantor1_first_name);
$guarantor2_first_name = rtrim($order[0]->guarantor2_first_name);

setlocale(LC_ALL, 'es_ES');

$output .= '
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Pagaré Notarial</title>
<style></style>
</head>
<body>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b style="font-size:1.2em;text-align:center;text-decoration:underline;text-decoration-style:double;margin:0;padding:0">PAGARE NOTARIAL.-</b>
<p style="text-align:justify"><b style="text-decoration:underline;">ACTO AUTENTICO NÚMERO: '.$formatter->toMoney($order[0]->contract_number, 0, '', '').' ('.$order[0]->contract_number.') 
FOLIO'.($order[0]->contract_folio2=="" ? "" : "S").' NÚMERO'.($order[0]->contract_folio2=="" ? "" : "S").': '.$formatter->toMoney($order[0]->contract_folio1, 0, '', '').($order[0]->contract_folio2=="" ? "" : " Y ".$formatter->toMoney($order[0]->contract_folio2, 0, '', '')).' ('.$order[0]->contract_folio1.($order[0]->contract_folio2=="" ? "" : " y ".$order[0]->contract_folio2).')</b>. En la ciudad y municipio de Nagua, provincia María Trinidad
Sánchez, a los <span style="text-transform:lowercase">'.$formatter->toMoney(date('d', strtotime($order[0]->entry_date)), 0, '', '').'</span> ('.date('d', strtotime($order[0]->entry_date)).') días del mes de '.strftime('%B',strtotime($order[0]->entry_date)) .' del año dos mil <span style="text-transform:lowercase">'.$formatter->toMoney(date('y', strtotime($order[0]->entry_date))).'</span> ('.date('Y', strtotime($order[0]->entry_date)).'),
siendo las <span style="text-transform:lowercase">'.$formatter->toMoney(strftime('%I', strtotime($order[0]->entry_time)), 0, '', '').'</span>  y <span style="text-transform:lowercase">'.$formatter->toMoney(strftime('%M', strtotime($order[0]->entry_time)), 0, '', '').'</span> horas de la '.$timeOfTheDay.' ('.date('h:i A', strtotime($order[0]->entry_time)).'), <b>POR ANTE MI, <span style="text-transform:uppercase">'.$company[0]->Lawyer_Name.'</span></b>, '.$company[0]->Lawyer_Nationality.', mayor de edad, '.$company[0]->Lawyer_CivilStatus.', Abogado
de los Tribunales de la República Dominicana, titular de la cédula de identidad y electoral número '.$company[0]->Lawyer_PersonalId.', matriculado en el Colegio de
Notarios con el número '.$company[0]->Lawyer_NotaryNumber.', con estudio profesional abierto en '.$company[0]->Lawyer_Address.', y
en presencia de los testigos que serán nombrados al final de este acto,
<b>COMPARECE</b>: de una parte '.$debtorSexHonor.' <b><span style="text-transform:uppercase">'.$customer_first_name.'</span></b>, '.$order[0]->customer_nationality.', mayor de edad, '.$order[0]->customer_civilstatus.', '.$order[0]->customer_occupation.', titular de la cédula de identidad personal y electoral número
'.$order[0]->customer_personalid.', domiciliado y residente en '.$order[0]->customer_address.', en diligencias
propias de este acto y para lo que sigue se denominará, <b>'.$debtorSexType.'</b>, y de la
otra parte '.$creditorSexHonor.' <b><span style="text-transform:uppercase">'.$company[0]->LegalName.'</span></b>, '.$company[0]->LegalName_Nationality.', mayor de edad, '.$company[0]->LegalName_CivilStatus.', '.$company[0]->LegalName_Occupation.',
titular de la cedula de identidad personal y electoral número '.$company[0]->LegalName_PersonalId.',
domiciliada y residente en '.$company[0]->LegalName_Address.', quien en el presente contrato se
denominara <b>'.$creditorSexType.'</b>, me han declarado los comparecientes <b>BAJO LA FE
DEL JURAMENTO</b>, personas a quien doy fe conocer que el motivo de su
comparecencia por ante esta oficina es con la finalidad de hacer constar y
declarar mediante el presente <b>PAGARÉ AUTENTICO</b>, lo siguiente: <b><u>PRIMERO</u></b>: <b><span style="text-transform:uppercase">'.$customer_first_name.'</span></b> declara y confiesa que al suscribir el
presente <b>PAGARÉ NOTARIAL</b> es <b>'.$debtorSexType.'</b> '.$creditorSexHonor.' <b><span style="text-transform:uppercase">'.$company[0]->LegalName.'</span></b>, 
por la suma de <b>'.$formatter->toMoney(str_replace(',', '', $order[0]->loans_amount), 2, 'PESOS DOMINICANOS', 'CENTAVOS').' (RD$'.$order[0]->loans_amount.')</b>,
moneda de curso nacional, comprometiéndose <b>'.$debtorSexType.'</b> a
pagar la cantidad de <b>'.$formatter->toMoney($interes_amount, 2, 'PESOS DOMINICANOS', 'CENTAVOS').' (RD$'.number_format($interes_amount, 2).')</b>
de interés <span style="text-transform:lowercase">'.$order[0]->loanstype_frequency.'</span>, por un plazo de <span style="text-transform:lowercase">'.$formatter->toMoney($order[0]->duration, 2, '', '').'</span> ('.$order[0]->duration.') '.$_frequency.', a partir de la
fecha de hoy, la cual inicia el día <span style="text-transform:lowercase">'.$formatter->toMoney(date('d', strtotime($order[0]->start_date))).'</span> ('.date('d', strtotime($order[0]->start_date)).') del mes de '.strftime('%B',strtotime($order[0]->start_date)) .' del año dos mil <span style="text-transform:lowercase">'.$formatter->toMoney(date('y', strtotime($order[0]->start_date))).'</span> ('.date('Y', strtotime($order[0]->start_date)).') y finaliza el día <span style="text-transform:lowercase">'.$formatter->toMoney(date('d', strtotime($order[0]->end_date))).'</span> ('.date('d', strtotime($order[0]->end_date)).') del mes de '.strftime('%B',strtotime($order[0]->end_date)) .' del año dos mil <span style="text-transform:lowercase">'.$formatter->toMoney(date('y', strtotime($order[0]->end_date))).'</span> ('.date('Y', strtotime($order[0]->end_date)).'). <b><u>SEGUNDO</u></b>: Queda convenido por medio
de este mismo acto que <b>'.$debtorSexType.'</b> se compromete a cumplir con lo
establecido en el presente <b>PAGARÉ NOTARIAL</b>, y como tal es un título ejecutorio
suficiente por sí mismo, luego de registrado de conformidad con la ley, para
que <b>'.$creditorSexType.'</b> pueda realizar embargos y cuantas medidas considere
pertinentes, sin que sea necesaria la previa autorización de un juez competente,
además <b>'.$creditorSexType.'</b> podrá ejecutar sobre todos los bienes muebles e inmuebles,
presentes y futuros, habidos y por haber incluyendo el fuero de domicilio de
<b>'.$debtorSexType.'</b> no cumple con lo establecido; tal y como lo establece el art. 545
del Código de Procedimiento Civil Dominicano (mod. Por la Ley No.679 del 23 de
mayo de 1934). Tienen fuerza ejecutoria las primeras copias de las sentencias y
otras decisiones judiciales y las de los actos notariales que contengan obligación
de pagar cantidades de dinero, ya sea periódicamente o en época fija; así como
las segundas o ulteriores copias de las mismas sentencias y actos que fueren
expedidas en conformidad con la ley en sustitución de la primera. Además lo
establecido en el contenido del artículo 1134 del Código Civil Dominicano “Las
convenciones legalmente formadas tienen fuerza de ley para aquellos que la han
hecho”; <b><u>TERCERO</u></b>: ';

if ($order[0]->guarantor1_id != null && $order[0]->guarantor2_id != null) {
	$output .= 'se hace constar que al suscribir este pagaré notarial los señores <b><span style="text-transform:uppercase">'.$order[0]->guarantor1_first_name.'</span></b> y <b><span style="text-transform:uppercase">'.$order[0]->guarantor2_first_name.'</span></b>, dominicanos, mayores de edad, <span style="text-transform:lowercase">'.$order[0]->guarantor1_civilstatus.' y '.$order[0]->guarantor2_civilstatus.', '.$order[0]->guarantor1_occupation.' y '.$order[0]->guarantor2_occupation.'</span>, titulares de las cédulas de identidad personal y electoral números '.$order[0]->guarantor1_personalid.' y '.$order[0]->guarantor2_personalid.', domiciliados y residentes en '.$order[0]->guarantor1_address.' y '.$order[0]->guarantor2_address.' respectivamente, se hacen <b>GARANTES</b> o <b>FIADORES</b> de dicha cuenta y en caso de atraso en el pago de cuotas de interés, o del capital y el total de los intereses acumulados por <b>'.$debtorSexType.'</b>, estos se hacen responsable de saldar dicha cuenta, en favor y provecho de <b>'.$creditorSexType.'</b> y firman este acto en señal de aprobación y aceptación del compromiso;';
}
else if ($order[0]->guarantor1_id != null) {
	$output .= 'se hace constar que al suscribir este pagaré notarial '.($guarantor1SexHonor == "del señor" ? "el señor" : "la señora").' <b><span style="text-transform:uppercase">'.$order[0]->guarantor1_first_name.'</span></b>, <span style="text-transform:lowercase">'.$order[0]->guarantor1_nationality.', mayor de edad, '.$order[0]->guarantor1_civilstatus.', '.$order[0]->guarantor1_occupation.'</span>, titular de la cédula de identidad personal y electoral número '.$order[0]->guarantor1_personalid.', domiciliado y residente en '.$order[0]->guarantor1_address.', se hace <b>GARANTE</b> o <b>FIADOR</b> de dicha cuenta y en caso de atraso en el pago de cuotas de interés, o del capital y el total de los intereses acumulados por <b>'.$debtorSexType.'</b>, se hace responsable de saldar dicha cuenta, en favor y provecho de <b>'.$creditorSexType.'</b> y firma este acto en señal de aprobación y aceptación del compromiso;';
}
else if ($order[0]->guarantor2_id != null)
{
	$output .= 'se hace constar que al suscribir este pagaré notarial '.($guarantor2SexHonor == "del señor" ? "el señor" : "la señora").' <b><span style="text-transform:uppercase">'.$order[0]->guarantor2_first_name.'</span></b>, <span style="text-transform:lowercase">'.$order[0]->guarantor2_nationality.', mayor de edad, '.$order[0]->guarantor2_civilstatus.', '.$order[0]->guarantor2_occupation.'</span>, titular de la cédula de identidad personal y electoral número '.$order[0]->guarantor2_personalid.', domiciliado y residente en '.$order[0]->guarantor2_address.', se hace <b>GARANTE</b> o <b>FIADOR</b> de dicha cuenta y en caso de atraso en el pago de cuotas de interés, o del capital y el total de los intereses acumulados por <b>'.$debtorSexType.'</b>, se hace responsable de saldar dicha cuenta, en favor y provecho de <b>'.$creditorSexType.'</b> y firma este acto en señal de aprobación y aceptación del compromiso;';
}

$output .=' '.($order[0]->guarantor1_id != null || $order[0]->guarantor2_id != null ? '<b><u>CUARTO</u></b>: ' : '').'
<b>'.$debtorSexType.'</b> conviene y acepta que de no realizar el pago de
<span style="text-transform:lowercase">'.$formatter->toMoney($order[0]->duration, 0, '', '').'</span> ('.$order[0]->duration.') cuotas consecutivas, tendrá que realizar el pago total del capital y
los intereses, <b>'.$creditorSexType.'</b> '.$creditorSexHonor.' <b><span style="text-transform:uppercase">'.$company[0]->LegalName.'</span></b> le hará exigible en su totalidad y gastos procedimentales; 
<b><u>'.($order[0]->guarantor1_id != null || $order[0]->guarantor2_id != null ? 'QUINTO' : 'CUARTO').'</u></b>: <b>'.$debtorSexType.'</b> conviene y acepta que de no realizar el pago total del capital,
<b>'.$creditorSexType.'</b> '.$creditorSexHonor.' <b><span style="text-transform:uppercase">'.$company[0]->LegalName.'</span></b> por medio de
este pagaré será ejecutorio y la deuda será exigible en su totalidad y gastos
procedimentales. En fe de todo lo cual se levanta el presente acto que he leído
a los comparecientes en presencia de los testigos instrumentales requeridos al
efecto, personas libres de tachas e impedimentos legales, establecidos por la
ley para tales fines; los testigos señores <b>'.$company[0]->WitnessName1.'</b> y <b>'.$company[0]->WitnessName2.'</b>, dominicanos, mayores de edad, solteros, '.$company[0]->Witness1_Occupation.' y '.$company[0]->Witness2_Occupation.', titulares
de las cédulas de identidad personal y electoral números '.$company[0]->Witness1_PersonalID.' y
'.$company[0]->Witness2_PersonalID.', domiciliados y residentes en esta ciudad de Nagua, provincia
María Trinidad Sánchez, después de haberlo visto, oído, leído y aceptado el
contenido de este acto en su totalidad, lo hallaron conforme, lo firmaron tanto
<b>'.$debtorSexType.'</b>, como <b>'.$creditorSexType.'</b> y los testigos, junto conmigo, notario
actuante <b><span style="text-transform:uppercase">'.$company[0]->Lawyer_Name.'</span></b>. <b>CERTIFICO Y DOY FE</b> en señal de
aprobación y conformidad.</p>

<p></p>
<p></p>

<table style="text-align:center">
 <tr>
  <td>__________________________________<br><b><span style="text-transform:uppercase">'.$company[0]->LegalName.'</span></b><br><span style="text-transform: capitalize;">'.substr($creditorSexType, 3).'.-</span></td>
 </tr>
</table>

<br>
<br>
<br>

<table style="text-align:center">
 <tr>
  <td>__________________________________<br><b><span style="text-transform:uppercase">'.$customer_first_name.'</span></b><br><span style="text-transform: capitalize;">'.substr($debtorSexType, 3).'.-</span></td>
 </tr>
 </table>';

 if ($order[0]->guarantor1_id != null && $order[0]->guarantor2_id != null) {
	 $output .= '
	 <br>
	 <br>
	 <br>
	 
	 <table style="text-align:center">
	  <tr>
		<td>__________________________________<br><b><span style="text-transform:uppercase">'.$guarantor1_first_name.'</span></b><br><span style="text-transform: capitalize;">Garante.-</span></td>
		<td>__________________________________<br><b><span style="text-transform:uppercase">'.$guarantor2_first_name.'</span></b><br><span style="text-transform: capitalize;">Garante.-</span></td>
	  </tr>
	 </table>';
 }
 else if ($order[0]->guarantor1_id != null) {
	 $output .= '
	 <br>
	 <br>
	 <br>
	 
	 <table style="text-align:center">
	  <tr>
	  <td>__________________________________<br><b><span style="text-transform:uppercase">'.$guarantor1_first_name.'</span></b><br><span style="text-transform: capitalize;">Garante.-</span></td>
	  </tr>
	 </table>';
 }
 else if ($order[0]->guarantor2_id != null)
 {
	 $output .= '
	 <br>
	 <br>
	 <br>
	 
	 <table style="text-align:center">
	  <tr>
	  <td>__________________________________<br><b><span style="text-transform:uppercase">'.$guarantor2_first_name.'</span></b><br><span style="text-transform: capitalize;">Garante.-</span></td>
	  </tr>
	 </table>';
 }
 
 $output .= '
<br>
<br>
<br>

<table style="text-align:center">
 <tr>
  <td>__________________________________<br><b>'.$company[0]->WitnessName1.'</b><br>Testigo.-</td>
  <td>__________________________________<br><b>'.$company[0]->WitnessName2.'</b><br>Testigo.-</td>
 </tr>
</table>

<br>
<br>
<br>

<table style="text-align:center">
 <tr>
  <td>__________________________________<br><b><span style="text-transform:uppercase">'.$company[0]->Lawyer_Name.'</span></b><br>Notario Público.-</td>
 </tr> 
</table>

</body>
</html>';

//echo $output;
// output the HTML content
$pdf->writeHTML($output, true, false, true, false, '');

//Close and output PDF document
$pdf->Output('[contrato] pagare autentico '.$customer_first_name.' prestamo no '.$order[0]->loans_no.' '.date("d-m-Y").'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>