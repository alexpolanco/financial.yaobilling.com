<?php
ini_set('memory_limit', '1024M');

$CI =& get_instance();
$company = $CI->get_company_data(); 
$transactions = $CI->get_transactions_data($order[0]->loans_no); 
$customer_first_name = rtrim($order[0]->customer_first_name);

//var_dump($transactions);

$company_terms =  array();
$company_terms = explode(',',$company[0]->company_terms);
$loansdue = date("Y-m-d", strtotime($order[0]->end_date)) < date("Y-m-d") ? true : false;

$formatter = new NumeroALetras();

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(' powered by PBwDesign');
$pdf->SetTitle($customer_first_name.' Préstamo No. '.$order[0]->loans_no.' Reporte de Préstamo '.($loansdue ? 'Fuera de Fecha (' : 'Activo (').date("d-m-Y").')');
$pdf->SetSubject('PDF');
$pdf->SetKeywords('TCPDF, PDF, Reporte de Préstamos, Reporte');


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
$pdf->SetFont("helvetica", "B",10);

// add a page
$pdf->AddPage();
$output = '';
//writeHTML($output, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
//writeHTMLCell($w, $h, $x, $y, $output='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
	$output .= '
	<table width="100%">
		<tr align="right">
			<td height="20">[ ] Original / [ ] Duplicado</td>
		</tr>
	</table>
   
	<table width="100%" border="1"> 
		<tr align="left">
			<td width="65%"><h1> '. $company[0]->company_name.'</h1>&nbsp;'.$company[0]->company_address.' '.$company[0]->company_city. '<br />&nbsp;'.$company[0]->company_phone.'</td>
			<td rowspan="2" width="35%">
				<table width="100%">
					<tr bgcolor="#CCC" align="center">
						<td colspan="3"><h3>INFORMACIÓN</h3></td>
					</tr>
					<tr><td colspan="3"></td></tr>
					<tr>
						<td width="47.5%"> Préstamo No.</td>
						<td width="5%">:</td>
						<td width="47.5%">'.$order[0]->loans_no.'</td>
					</tr>
					<tr>
						<td width="47.5%"> Tipo préstamo</td>
						<td width="5%">:</td>
						<td width="47.5%">Inversión</td>
					</tr>
					<tr>
						<td width="47.5%"> Monto prestado</td>
						<td width="5%">:</td>
						<td width="47.5%">'.$order[0]->loans_amount.'</td>
					</tr>
					<tr>
						<td width="47.5%"> Fecha entrega</td>
						<td width="5%">:</td>
						<td width="47.5%">'.date("d-m-Y", strtotime($order[0]->start_date)).'</td>
					</tr>
					<tr>
						<td width="47.5%"> Fecha finaliza</td>
						<td width="5%">:</td>
						<td width="47.5%">'.date("d-m-Y", strtotime($order[0]->end_date)).'</td>
					</tr>
					<tr>
						<td width="47.5%"> Estado</td>
						<td width="5%">:</td>
						<td width="47.5%">'.($loansdue ? 'Fuera de fecha' : 'Activo').'</td>
					</tr>
					<tr><td colspan="3"></td></tr>
				</table>
			</td>
      </tr>
      <tr align="left">
			<td height="25"><br /><br /> CLIENTE: <h3 style="text-transform:uppercase">'.$customer_first_name.'</h3>&nbsp;'.$order[0]->customer_address.' '.$order[0]->customer_city. '<br />&nbsp;'.$order[0]->customer_phone.'</td>
      </tr>
	</table> 
	<table style="border:1px solid black;" width="100%">
		<tr>
			<td height="20" align="center"><h3>ESTADO DE CUENTA DEL PRÉSTAMO</h3> </td>
		</tr>	
	</table>';
	
	$output .='
	<table style="border:1px solid black;margin:20px auto; text-align:center" align="center" width="100%" >
		<tr>
			<th style="width:10%;border:1px solid black;" align="right"></th>
			<th style="width:15%;border:1px solid black;" align="left">Fecha</th>
			<th style="width:15%;border:1px solid black;" align="left">Transacción</th>
			<th style="width:15%;border:1px solid black;" align="right">Monto</th>
		</tr>
		';
		
		$c = 0;
		$_capital = 0;
		$_loans_total = floatval(str_replace(',', '', $order[0]->current_balance));

		foreach( $transactions as $_transactions ) 
		{
			$c++;
			$_capital += floatval(str_replace(',', '', $_transactions->interes));
			
			if ($_transactions->amount > 0) {
				$output .= '<tr>
					<td style="border-right:1px solid black;" align="center">'.$c.'</td>
					<td style="border-right:1px solid black;">'.date("d-m-Y", strtotime($_transactions->payment_date)).'</td>
					<td style="border-right:1px solid black;" align="right">'.$_transactions->transactions_type.'</td>
					<td style="border-right:1px solid black;" align="right">'.number_format($_transactions->amount, 2).'</td>
				</tr> ';
			} else {
				$output .= '<tr>
					<td style="border-right:1px solid black;" align="center">'.$c.'</td>
					<td style="border-right:1px solid black;">'.date("d-m-Y", strtotime($_transactions->due_date)).'</td>
					<td style="border-right:1px solid black;" align="right">CUOTA</td>
					<td style="border-right:1px solid black;" align="right">'.number_format($_transactions->interes, 2).'</td>
				</tr> ';
			}
			
		}

		$mora = $loansdue ? 500.00 : 0.00;
		
		for($i = $c; $i <=12 ; $i++ ){
			$output .= '<tr>
			<td style="border-right:1px solid black;"></td>
			<td style="border-right:1px solid black;"></td>
			<td style="border-right:1px solid black;"></td>
			<td style="border-right:1px solid black;"></td>
		</tr> ';
		}
		$output .='
	</table>';

	$loanstotal = floatval(number_format($_loans_total, 2, '.', ''));
	$output .='
	<table border="1" width="100%">
		<tr>
				<td colspan="2">'.$formatter->toMoney($_loans_total, 2, 'PESOS DOMINICANOS', 'CENTAVOS') . '</td>
				<td>
					<table width="100%">
					<tr>
							<td align="left" height="20" width="50%"><h2>BALANCE</h2></td>
					<td width="5%">:</td>
						<td align="right" width="45%"><h2> '.(number_format(str_replace(',', '', $_loans_total) + $mora, 2)).' </h2></td>
					</tr>
					</table>
				</td>
			</tr>
			
			<tr>
				<td colspan="4"  height="20"></td>
			</tr>
			<tr>
				<td colspan="2" align="left">
					<span style="font-size:15px; font-wight:bold; " >Términos & condiciones :</span>
					<ul>';
					foreach($company_terms as $_terms){
						$output .= '<li>'.$_terms.'</li>';
					}
					
					$output .='</ul>
				</td>
				<td colspan="2">
					<span style="font-size:10px; font-wight:bold;">
							'.$company[0]->company_name.'
						</span>
						<br /><br />
						<div  style="text-align:right; width:100%;" >	
					Firma.
						</div>
				</td>
			</tr>
	</table>';

// output the HTML content
$pdf->writeHTML($output, true, false, true, false, '');

//Close and output PDF document
$pdf->Output($customer_first_name.' prestamo no '.$order[0]->loans_no.' '.($loansdue ? 'Fuera de fecha ' : 'Activo ').date("d-m-Y").'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>