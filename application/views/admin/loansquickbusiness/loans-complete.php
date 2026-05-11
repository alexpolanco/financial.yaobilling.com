<?php
ini_set('memory_limit', '1024M');

$order_date = date("d-m-Y", strtotime($transaction_pay['creation_date']) );
$transaction_date = date("d-m-Y", strtotime($transaction_pay['payment_date']) );
$paid_status = ($order_data['current_balance'] > 0) ? "A CRÉDITO" : "SALDADA";
      
$CI =& get_instance();
$company = $CI->get_company_data(); 
$company_terms = explode(',',$company[0]->company_terms);
$loansdue = date("Y-m-d", strtotime($order_data['end_date'])) < date("Y-m-d") ? true : false;
$customer_first_name = rtrim($order_data['customer_first_name']);

$formatter = new NumeroALetras();

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF('L', 'mm', array(215.9, 93.21), true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(' powered by PBwDesign');
$pdf->SetTitle('Reporte de Préstamos');
$pdf->SetSubject('PDF');
$pdf->SetKeywords('TCPDF, PDF, Reporte de Préstamos, Préstamos, Pagos, Reporte');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$this->pageWidth=421;                     
$this->pageHeight=595;

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set margins
$pdf->SetMargins(10, 4, 10, 0);
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
      
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
  require_once(dirname(__FILE__).'/lang/eng.php');
  $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont("helvetica", "",11);

// add a page
$pdf->AddPage();
$pdf->setPage(1, true);

setlocale(LC_MONETARY,"es_DO");
$base_url = base_url();
$user_data = $this->users_model->findOne($this->session->userdata('userid'));
$id_pad = str_pad($transaction_pay['transactions_no'], 8, "0", STR_PAD_LEFT);
$transaction_amount = $transaction_pay['amount'];
$transaction_capital_amount = $transaction_capital['amount'];

$customer_first_name = rtrim($order_data['customer_first_name'], ' ');

$original_loan_amount = '<tr>
  <td class="text-left" colspan="2" border="1">CAPITAL PRESTADO</td>
  <td class="text-right" border="1">'.number_format($order_data['loans_amount'], 2).'</td>
</tr>';
$transaction_pay_detail = '<tr>
  <td class="text-left" colspan="2" border="1"> ABONO</td>
  <td class="text-right" border="1">'.number_format($order_data['current_balance'], 2).'</td>
</tr>';
$current_loan_amount = '<tr>
  <td class="text-left" colspan="2" border="1">BALANCE</td>
  <td class="text-right" border="1">0.00</td>
</tr>';

$transaction_type = "PAGO";

$bootstrap_css = '<style>'.file_get_contents('https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css').'</style>';

$output = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
{$bootstrap_css}
<style>
#invoice{overflow: hidden;padding:10px 30px}.invoice{position:relative;background-color:#fff;min-height:380px;padding:1px}.invoice header{padding:0;margin-bottom:10px;border-bottom:1px solid #3989c6} .company-details{text-align:left}.company-details .name{margin-top:0;margin-bottom:0} .contacts{margin-bottom:10px}.invoice-to{text-align:left}.to{font-size: x-large;margin-top:0;margin-bottom:0;text-transform: uppercase;}.invoice-details{text-align:right} .invoice-id{font-size: xx-large;margin-top:0;color:#3989c6}main .thanks{margin-top:10px;}main .notices{padding-left:6px;border-left:6px solid #3989c6}main .notices .notice{font-size:1.2em}table{width:100%;border-collapse:collapse;border-spacing:0;margin-bottom:0}table td,table th{padding:3px;background:#eee;border-bottom:1px solid #fff}table th{white-space:nowrap;font-weight:400;font-size:16px}table td h3{margin:0;font-weight:400;color:#3989c6;font-size:1.2em}table .qty,table .total,table .unit{text-align:right;font-size:1.2em}table .no{color:#fff;font-size:1.6em;background:#3989c6}table .unit{background:#ddd}table .total{background:#3989c6;color:#fff}table tbody tr:last-child td{border:none}table tfoot td{background:0 0;border-bottom:none;white-space:nowrap;text-align:right;padding:0;border-top:1px solid #aaa}table tfoot tr:first-child td{border-top:none}table tfoot tr:last-child td{color:#3989c6;border-top:1px solid #3989c6}table tfoot tr td:first-child{border:none}footer{width:100%;text-align:center;color:#777;padding:0}
</style>
<table width="100%" class="display" style="font-size:10px">
  <tr style="">
    <td width="90%">
      <div><span style="font-size:18px;font-weight:900;">{$company[0]->company_name}</span><br>
      {$company[0]->company_address}{$company[0]->company_city}<br>&nbsp;{$company[0]->company_phone} • {$company[0]->company_email}<br>Fecha: {$order_date}</div>
    </td>
    <td width="10%" style="text-align:center"><img src="{$base_url}file/company/{$company[0]->company_id}.svg" width="120" /></td>
  </tr>
  <tr><td colspan="2"><hr></td></tr>
</table>
<table width="100%" class="display" style="font-size:10px">
  <tr>
    <td width="68%">
      <div><span class="text-gray-light">CLIENTE:</span><br>
      <span class="to">{$customer_first_name}</span><br>
      {$order_data['customer_address']}<br>{$order_data['customer_phone']}</div>
    </td>
    <td>
      <div><span class="to">RECIBO DE PAGO Y SALDO</span>
      <br>Recibo No.: {$id_pad}<br>Fecha de pago: {$transaction_date}<br>Atendido por: {$user_data['user_fullname']}</div>
    </td>
  </tr>
  </table>
  <br>
  <table width="100%" class="" style="border:1px solid #000;font-size:10px" border="1" cellspacing="1" cellpadding="1">
  <thead>
  <tr>
    <th class="text-left" colspan="2" border="1"><b>CONCEPTO</b></th>
    <th class="text-right" border="1"><b>VALOR</b></th>
  </tr>
  </thead>
  <tbody>
  {$original_loan_amount}
  {$transaction_pay_detail}
  {$current_loan_amount}
  </tbody>
</table>
<span class="thanks" style="font-size:10px;text-align:center">{$company_info['company_slogan']}</span>
EOF;			

//echo $output;
// output the HTML content
$pdf->writeHTML($output, true, false, true, false, '');

// add a page
$pdf->AddPage('P', 'A4');
$pdf->setPage(2, true);

// set margins
$pdf->SetMargins(30, 15, 30);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


// ---------------------------------------------------------

// set font
$pdf->SetFont("times", "", 12);


$output = '';
// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
//var_dump($order['entry_time']);
// create some HTML content
if(date('H', strtotime($order['entry_time'])) < "12")
{ $timeOfTheDay = "mañana"; }
else
{ $timeOfTheDay = "tarde"; }

if($company[0]->LegalName_Sex == "Masculino")
{ $creditorSexHonor = "del señor"; $creditorSexType = "EL ACREEDOR"; }
else
{ $creditorSexHonor = "de la señora"; $creditorSexType = "LA ACREEDORA"; }

if($order['customer_gender'] == "Masculino")
{ $debtorSexHonor = "el señor"; $debtorSexType = "EL DEUDOR"; }
else
{ $debtorSexHonor = "la señora"; $debtorSexType = "LA DEUDORA"; }

switch($order['loanstype_frequency'])
{
	case "Diario" : $_frequency = "día".($order_data['duration'] > 1 ? "s" : ""); break;
	case "Semanal" : $_frequency = "semana".($order_data['duration'] > 1 ? "s" : ""); break;
	case "Quincenal" : $_frequency = "quincena".($order_data['duration'] > 1 ? "s" : ""); break;
	case "Mensual" : $_frequency = "mes".($order_data['duration'] > 1 ? "es" : ""); break;
	case "Anual" : $_frequency = "año".($order_data['duration'] > 1 ? "s" : ""); break;
	default : $_frequency = "mes".($order_data['duration'] > 1 ? "es" : ""); break;
}

//$interes_amount = str_replace(',', '', $order_data['loans_amount']) * $order_data['interes'] / 100;
$interes_amount = $order_data['interes_amount'];

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

$pdf->ImageSVG($file=''.base_url().'file/company/'.$company[0]->company_id.'.svg', $x=86, $y=10, $w='', $h=40, $link='', $align='', $palign='', $border=0, $fitonpage=false);

$output .= '
<p></p>

<table style="text-align:center">
<tr>
	<td style="text-align:center"><img src="'.base_url().'file/company/'.$company[0]->company_id.'.jpg" width="1" height="1" /></td>
</tr>
<tr>
	<td style="text-align:center;font-size:9px">'.$company[0]->company_address.$company[0]->company_city.'<br>&nbsp;'.$company[0]->company_phone.'<br><br><br></td>
</tr>
<tr>
	<td style="text-align:center"><h3>CARTA DE SALDO</h3></td>
</tr>
</table>

<p></p>
<p>A quien pueda interesar:</p>
<p></p>

<p>Por medio de la presente, le informamos que '.$debtorSexHonor.' <b><span style="text-transform:uppercase">'.$customer_first_name.'</span></b>, '.$order['customer_nationality'].', mayor de edad, '.$order['customer_civilstatus'].', '.$order['customer_occupation'].', titular de la cédula de identidad personal y electoral número
'.$order_data['customer_personalid'].', domiciliado y residente en '.$order_data['customer_address'].', ha saldado en su totalidad la deuda de <b>'.$formatter->toMoney(str_replace(',', '', $order_data['loans_amount']), 2, 'PESOS DOMINICANOS', 'CENTAVOS').' (RD$'.number_format($order_data['loans_amount'], 2).')</b>,
moneda de curso nacional, contraída mediante el Pagare Notarial No.'.$order_data['contract_number'].', Folios '.$order_data['contract_folio1'].' y '.$order_data['contract_folio2'].', de fecha <span style="text-transform:lowercase">'.$formatter->toMoney(date('d', strtotime($order_data['entry_date'])), 0, '', '').'</span>('.date('d', strtotime($order_data['entry_date'])).') días del mes de '.strftime('%B',strtotime($order_data['entry_date'])) .' del año dos mil <span style="text-transform:lowercase">'.$formatter->toMoney(date('y', strtotime($order_data['entry_date']))).'</span>('.date('Y', strtotime($order_data['entry_date'])).'), los cuales fueron recibidos en efectivo, lo que le sirve de descargo y finiquito ante la compañía de préstamos <b>"AGENCIA INMOBILIARIA E INVERSIONES GONZALEZ SANTOS, S.R.L."</b>, y por lo que queda levantada cualquier oposición que pudiere tener sin ninguna objeción.</p>

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

$pdf->lastPage();

//var_dump($order);
//var_dump($order_data);

//Close and output PDF document
//$pdf->Output('Recibo_de_Pago.pdf', 'I');
$pdf->Output('[carta de saldo] '.$customer_first_name.' prestamo no '.$order_data['loans_no'].' '.date("d-m-Y").'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>