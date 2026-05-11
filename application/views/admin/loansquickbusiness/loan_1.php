<?php
$CI =& get_instance();
$company = $CI->get_company_data(); 

$company_terms = array();
$company_terms =explode(',',$company[0]->company_terms);
$loansdue = date("Y-m-d", strtotime($order[0]->end_date)) < date("Y-m-d") ? true : false;
$customer_first_name = rtrim($order[0]->customer_first_name);

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('. $company[0]->company_name.'.' powered by PBwDesign');
$pdf->SetTitle($customer_first_name.' Préstamo No. '.$order[0]->loans_no.' Reporte de Préstamo '.($loansdue ? 'Fuera de Fecha (' : 'Activo (').date("d-m-Y").')');
$pdf->SetSubject('PDF');
$pdf->SetKeywords('TCPDF, PDF, Reporte de Préstamos, Reporte');

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
						<td width="47.5%">Rápido</td>
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
						<td width="47.5%"> Ruta</td>
						<td width="5%">:</td>
						<td width="47.5%">'.$order[0]->routes_name.'</td>
					</tr>
					<tr>
						<td width="47.5%"> Cobrador</td>
						<td width="5%">:</td>
						<td width="47.5%">'.$order[0]->collector_first_name.'</td>
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
      	<td height="25"><br /><br /> CLIENTE: <h3>'.$customer_first_name.'</h3>&nbsp;'.$order[0]->customer_address.' '.$order[0]->customer_city. '<br />&nbsp;'.$order[0]->customer_phone.'</td>
      </tr>
	</table> 
	<table style="border:1px solid black;" width="100%">
		<tr>
			<td height="20" align="center"><h3>ESTADO DE CUENTA DEL PRÉSTAMO</h3> </td>
		</tr>	
	</table>
	
	<table style="border:1px solid black;" width="100%" >
		<tr>
    		<th style="width:8%;border:1px solid black;" align="right"></th>
    		<th style="width:12%;border:1px solid black;" align="left">Fecha</th>
    		<th style="width:10%;border:1px solid black;" align="left">Saldo inicial</th>
    		<th style="width:10%;border:1px solid black;" align="right">Cuota</th>
    		<th style="width:10%;border:1px solid black;" align="left">Interes</th>
    		<th style="width:10%;border:1px solid black;" align="right">Capital</th>
    		<th style="width:10%;border:1px solid black;" align="right">Atraso</th>
    		<th style="width:10%;border:1px solid black;" align="right">Adelanto</th>
    		<th style="width:10%;border:1px solid black;" align="right">Pago</th>
    		<th style="width:10%;border:1px solid black;" align="right">Saldo final</th>
    	</tr>
		';
		
		$c = 0;
		foreach( $order as $_order ) 
		{
			$c++;
			$output .= '<tr>
				<td style="border-right:1px solid black;" align="center">'.$c.'</td>
				<td style="border-right:1px solid black;">'.date("d-m-Y", strtotime($_order->due_date)).'</td>
				<td style="border-right:1px solid black;" align="right">'.$_order->due_amount.'</td>
				<td style="border-right:1px solid black;" align="right">'.$_order->cuota.'</td>
				<td style="border-right:1px solid black;" align="right">'.$_order->interes.'</td>
				<td style="border-right:1px solid black;" align="right">'.$_order->capital .'</td>
				<td style="border-right:1px solid black;" align="right">'.$_order->atraso .'</td>
				<td style="border-right:1px solid black;" align="right">'.$_order->advance_amount .'</td>
				<td style="border-right:1px solid black;" align="right">'.$_order->payment .'</td>
				<td style="border-right:1px solid black;" align="right">'.$_order->balance .'</td>
			</tr> ';
		}

		$mora = $loansdue ? '500.00' : '0.00';
		
		for($i = $c; $i <=12 ; $i++ ){
			
			$output .= '<tr>
			<td style="border-right:1px solid black;"></td>
    		<td style="border-right:1px solid black;"></td>
    		<td style="border-right:1px solid black;"></td>
    		<td style="border-right:1px solid black;"></td>
    		<td style="border-right:1px solid black;"></td>
    		<td style="border-right:1px solid black;"></td>
    		<td style="border-right:1px solid black;"></td>
    		<td style="border-right:1px solid black;"></td>
    		<td style="border-right:1px solid black;"></td>
		</tr> ';
		}
		$output .='
    </table>
    
    <table border="1" width="100%">
    	<tr>
          	<td colspan="2"></td>
            <td>
            	<table width="100%">
            	<tr>
                  	<td align="left" height="20" width="50%"><h2>MORA</h2></td>
        			<td style="width:5%;">:</td>
                    <td align="right" width="45%"><h3>'.$mora.' </h3></td>
                </tr>
                </table>
            </td>
        </tr>
    	<tr>
          	<td colspan="2">'.$CI->convertNumDecimal(floatval(str_replace(',', '', $order[9]->balance)+$mora)).'</td>
            <td>
            	<table width="100%">
            	<tr>
                  	<td align="left" height="20" width="50%"><h2>BALANCE</h2></td>
        			<td width="5%">:</td>
                    <td align="right" width="45%"><h2> '.(number_format(str_replace(',', '', $order[9]->balance) + $mora, 2)).' </h2></td>
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