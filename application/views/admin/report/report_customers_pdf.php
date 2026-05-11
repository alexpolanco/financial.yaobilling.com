<?php
ini_set('memory_limit', '1024M');

$CI =& get_instance();
$company = $CI->get_company_data(); 

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(' powered by PBwDesign');
$pdf->SetTitle('Reporte de Clientes');
$pdf->SetSubject('PDF');
$pdf->SetKeywords('TCPDF, PDF, Reporte de Clientes, Clientes, Reporte');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set margins
$pdf->SetMargins(15, 15, 15);
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
$pdf->SetFont("times", "B",8);

// add a page
$pdf->AddPage();
$output = '';
// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$output .= '
	<table width="100%" class="display">
		<tr style="color:#000;font-weight:900;">
			<td width="20%" style=""><img src="'.base_url().'file/company/'.$company[0]->company_image.'" height="100" width="140" /></td>
			<td width="80%" style="" colspan="6">
				<h2 style="background-color:#fff;">'.$company[0]->company_name.'</h2>
				<p style="background-color:#dedede;">'.$company[0]->company_address.$company[0]->company_city.'<br />&nbsp;'.$company[0]->company_phone.'</p>
			</td>
		</tr>
		<tr><td colspan="7"><hr /><br /></td></tr>
		<tr><td colspan="7"><h2>Reporte de Clientes</h2></td></tr>
		<tr style="background-color:#dedede;color:#000;font-size:12px;font-weight:900;">
			<th width="30%" style="border:1px solid #000;">Clientes</th>
			<th width="10%" style="border:1px solid #000;">Cédula</th>
			<th width="10%" style="border:1px solid #000;">Teléfono</th>
			<th width="10%" style="border:1px solid #000;">Capital e interes</th>
			<th width="10%" style="border:1px solid #000;">Regalía</th>
			<th width="10%" style="border:1px solid #000;">Fijos</th>
			<th width="10%" style="border:1px solid #000;">Inversión</th>
			<th width="10%" style="border:1px solid #000;">Rápidos</th>
		</tr>';

		foreach ($recored as $_date) {
			$output .='<tr>
				<td style="border:1px solid #000;">'.$_date->customer_first_name.'</td>
				<td style="border:1px solid #000;">'.$_date->customer_personalid.'</td>
				<td style="border:1px solid #000;">'.$_date->customer_phone.'</td>
				<td style="border:1px solid #000;">'.$_date->loanscapital_active.'</td>
				<td style="border:1px solid #000;">'.$_date->loanschristmas_active.'</td>
				<td style="border:1px solid #000;">'.$_date->loansfixed_active.'</td>
				<td style="border:1px solid #000;">'.$_date->loansinversion_active.'</td>
				<td style="border:1px solid #000;">'.$_date->loansquickbusiness_active.'</td>
			</tr>';
		}

		$output .='
		<tr style="background-color:#dedede;color:#000;font-size:12px;font-weight:900;">
			<th width="30%" style="border:1px solid #000;">Clientes</th>
			<th width="10%" style="border:1px solid #000;">Cédula</th>
			<th width="10%" style="border:1px solid #000;">Teléfono</th>
			<th width="10%" style="border:1px solid #000;">Capital e interes</th>
			<th width="10%" style="border:1px solid #000;">Regalía</th>
			<th width="10%" style="border:1px solid #000;">Fijos</th>
			<th width="10%" style="border:1px solid #000;">Inversión</th>
			<th width="10%" style="border:1px solid #000;">Rápidos</th>
		</tr>
</table>';

//echo $output;
// output the HTML content
$pdf->writeHTML($output, true, false, true, false, '');

//Close and output PDF document
$pdf->Output('Reporte_de_Clientes.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>