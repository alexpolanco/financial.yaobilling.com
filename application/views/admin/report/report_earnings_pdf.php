<?php
ini_set('memory_limit', '1024M');

$CI =& get_instance();
$company = $CI->get_company_data(); 

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(' powered by PBwDesign');
$pdf->SetTitle('Reporte de Ingresos/Egresos');
$pdf->SetSubject('PDF');
$pdf->SetKeywords('TCPDF, PDF, Reporte de Ingresos/Egresos, Ingresos, Egresos, Reporte');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set margins
$pdf->SetMargins(25, 15, 25);
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
$total_g = ($payments[0]->loansfixed_amount + $payments[0]->loanscapital_amount + $payments[0]->loansinversion_amount + $payments[0]->loanschristmas_amount + $payments[0]->loansquickbusiness_amount) - ($expense[0]->total_amount + 
$loans[0]->loansfixed_total_amount + $additionals[0]->loansfixed_additional_amount +
$loans[0]->loanscapital_total_amount + $additionals[0]->loanscapital_additional_amount + 
$loans[0]->loansinversion_total_amount + $additionals[0]->loansinversion_additional_amount +
$loans[0]->loanschristmas_total_amount + $additionals[0]->loanschristmas_additional_amount + 
$loans[0]->loansquickbusiness_total_amount + $additionals[0]->loansquickbusiness_additional_amount);

$output .='
	<table width="100%" class="display">
		<tr style="color:#000;font-weight:900;">
			<td width="20%" style=""><img src="'.base_url().'file/company/'.$company[0]->company_image.'" height="100" width="140" /></td>
			<td width="80%" style="" colspan="6">
				<h3 style="background-color:#fff;">'.$company[0]->company_name.'</h3>
				<p style="background-color:#dedede;">'.$company[0]->company_address.$company[0]->company_city.'<br />&nbsp;'.$company[0]->company_phone.'</p>
			</td>
		</tr>
		<tr><td colspan="7"><hr /></td></tr>
		<tr><td colspan="7"><h3>Reporte de Ingresos/Egresos '.(!empty($loans[0]->datefrom) ? ' desde ' . date('d/m/Y', strtotime($loans[0]->datefrom)) . ' hasta ' . date('d/m/Y', strtotime($loans[0]->dateto)) : '').'</h3><br></td></tr>

		<tr>
			<td colspan="6"><h3 class="card-title">Gastos</h3></td>
			<td style="text-align:right"><em>($' . number_format($expense[0]->total_amount,2). ')</em></td>
		</tr>

		<tr><td colspan="7"></td></tr>
		<tr><td colspan="7"><h3 class="card-title">Préstamos Fijos</h3></td></tr>
		<tr>
			<td></td>
			<td><span class="description-text">Entregados</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right"><em>($' . number_format($loans[0]->loansfixed_total_amount,2). ')</em></td>
			<td></td>
		</tr>
		
		<tr>
			<td></td>
			<td><span class="description-text">Adicionales</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right;border-bottom:1px solid #000"><em>($' . number_format($additionals[0]->loansfixed_additional_amount,2). ')</em></td>
			<td></td>
		</tr>
		
		<tr>
			<td></td>
			<td colspan="2"><span class="description-text">Total entregados + adicionales</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right"><em>($' . number_format($loans[0]->loansfixed_total_amount+$additionals[0]->loansfixed_additional_amount,2). ')</em></td>
		</tr>
		
		<tr>
			<td></td>
			<td><span class="description-text">Total cobrado</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right"><em>$' . number_format($payments[0]->loansfixed_amount,2). '</em></td>
		</tr>

		<tr><td colspan="7"></td></tr>
		<tr><td colspan="7"><h3 class="card-title">Préstamos Capital</h3></td></tr>
		<tr>
			<td></td>
			<td><span class="description-text">Entregados</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right"><em>($' . number_format($loans[0]->loanscapital_total_amount,2). ')</em></td>
			<td></td>
		</tr>
		
		<tr>
			<td></td>
			<td><span class="description-text">Adicionales</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right;border-bottom:1px solid #000"><em>($' . number_format($additionals[0]->loanscapital_additional_amount,2). ')</em></td>
			<td></td>
		</tr>
		
		<tr>
			<td></td>
			<td colspan="2"><span class="description-text">Total entregados + adicionales</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right"><em>($' . number_format($loans[0]->loanscapital_total_amount+$additionals[0]->loanscapital_additional_amount,2). ')</em></td>
		</tr>
		
		<tr>
			<td></td>
			<td><span class="description-text">Total cobrado</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right"><em>$' . number_format($payments[0]->loanscapital_amount,2). '</em></td>
		</tr>

		<tr><td colspan="7"></td></tr>
		<tr><td colspan="7"><h3 class="card-title">Préstamos Inversión</h3></td></tr>
		<tr>
			<td></td>
			<td><span class="description-text">Entregados</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right"><em>($' . number_format($loans[0]->loansinversion_total_amount,2). ')</em></td>
			<td></td>
		</tr>
		
		<tr>
			<td></td>
			<td><span class="description-text">Adicionales</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right;border-bottom:1px solid #000"><em>($' . number_format($additionals[0]->loansinversion_additional_amount,2). ')</em></td>
			<td></td>
		</tr>
		
		<tr>
			<td></td>
			<td colspan="2"><span class="description-text">Total entregados + adicionales</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right"><em>($' . number_format($loans[0]->loansinversion_total_amount+$additionals[0]->loansinversion_additional_amount,2). ')</em></td>
		</tr>
		
		<tr>
			<td></td>
			<td><span class="description-text">Total cobrado</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right"><em>$' . number_format($payments[0]->loansinversion_amount,2). '</em></td>
		</tr>

		<tr><td colspan="7"></td></tr>
		<tr><td colspan="7"><h3 class="card-title">Préstamos Regalía</h3></td></tr>
		<tr>
			<td></td>
			<td><span class="description-text">Entregados</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right"><em>($' . number_format($loans[0]->loanschristmas_total_amount,2). ')</em></td>
			<td></td>
		</tr>
		
		<tr>
			<td></td>
			<td><span class="description-text">Adicionales</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right;border-bottom:1px solid #000"><em>($' . number_format($additionals[0]->loanschristmas_additional_amount,2). ')</em></td>
			<td></td>
		</tr>
		
		<tr>
			<td></td>
			<td colspan="2"><span class="description-text">Total entregados + adicionales</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right"><em>($' . number_format($loans[0]->loanschristmas_total_amount+$additionals[0]->loanschristmas_additional_amount,2). ')</em></td>
		</tr>
		
		<tr>
			<td></td>
			<td><span class="description-text">Total cobrado</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right"><em>$' . number_format($payments[0]->loanschristmas_amount,2). '</em></td>
		</tr>

		<tr><td colspan="7"></td></tr>
		<tr><td colspan="7"><h3 class="card-title">Préstamos Rapidos</h3></td></tr>
		<tr>
			<td></td>
			<td><span class="description-text">Entregados</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right"><em>($' . number_format($loans[0]->loansquickbusiness_total_amount,2). ')</em></td>
			<td></td>
		</tr>
		
		<tr>
			<td></td>
			<td><span class="description-text">Adicionales</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right;border-bottom:1px solid #000"><em>($' . number_format($additionals[0]->loansquickbusiness_additional_amount,2). ')</em></td>
			<td></td>
		</tr>
		
		<tr>
			<td></td>
			<td colspan="2"><span class="description-text">Total entregados + adicionales</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right"><em>($' . number_format($loans[0]->loansquickbusiness_total_amount+$additionals[0]->loansquickbusiness_additional_amount,2). ')</em></td>
		</tr>
		
		<tr>
			<td></td>
			<td><span class="description-text">Total cobrado</span></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right;border-bottom:1px solid #000"><em>$' . number_format($payments[0]->loansquickbusiness_amount,2). '</em></td>
		</tr>

		<tr><td colspan="7"></td></tr>
		<tr>
			<td colspan="6"><h3>TOTAL GENERAL</h3></td>
			<td style="text-align:right;text-decoration:doble;border-bottom: 1px solid #000"><h3>$' . number_format($total_g,2). '</h3></td>
		</tr>
		</table>';

		//echo $output;
// output the HTML content
$pdf->writeHTML($output, true, false, true, false, '');

//Close and output PDF document
$pdf->Output('Reporte_de_Ingresos_Egresos.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>