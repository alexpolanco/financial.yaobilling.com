<?php
$CI =& get_instance();
$collector = $CI->get_collector_data(); 
$company = $CI->get_company_data(); 

$company_terms = array();
$company_terms =explode(',',$company[0]->company_terms);

$loansdue = $this->uri->segment(6);

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('. $company[0]->company_name.'.' powered by PBwDesign');
$pdf->SetTitle('Lista de Cobro de Préstamos '.($loansdue ? 'Fuera de Fecha (' : 'Activos (').date("d-m-Y").')');
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
	<table width="100%" border="0"> 
		<tr align="left">
      	    <td width="65%"><h1> '.$company[0]->company_name.'</h1>&nbsp;'.$company[0]->company_address.' '.$company[0]->company_city. '<br />&nbsp;'.$company[0]->company_phone.'</td>
			<td rowspan="2" width="35%">
				<table width="100%">
					<tr bgcolor="#CCC" align="center">
        	            <td colspan="3"><h3>LISTA DE COBRO</h3></td>
                    </tr>
					<tr align="center"><td colspan="3">Préstamos '.($loansdue ? 'Fuera de Fecha' : 'Activos').'</td></tr>
					<tr>
						<td width="47.5%"></td>
						<td width="5%"></td>
						<td width="47.5%"></td>
					</tr>
					<tr>
						<td colspan="3">Impreso el '.date("d-m-Y").' a las '.date("h:i A").'</td>
					</tr>
					<tr>
						<td width="47.5%"></td>
						<td width="5%"></td>
						<td width="47.5%"></td>
					</tr>
					<tr><td colspan="3"></td></tr>
				</table>
			</td>
      </tr>
      <tr align="left">
      	<td height="25"><br /><br /> FECHA: '.date("d-m-Y", strtotime($date1)).' al '.date("d-m-Y", strtotime($date2)).' </td>
      </tr>
	</table><br><br>';
	
	$c = 0; $atrasos = 0; $mora = 0; $total = 0; $collector_first_name='';
	foreach( $order as $_order ) 	{
	    
	    $_mora = empty($loansdue) ? 0.00 : 500.00; 
	    
	    if($collector_first_name != $_order->collector_first_name) {
	        
	        if($c != 0){
	            $output .='
    </table>
    
    <table border="0" width="100%">
    	<tr>
            <td align="left" height="20" width="50%"><h3># RECIBOS: '.(number_format($c, 0)).' </h3></td>
            <td align="right" width="50$this->uri->segment(4)%"><h3>BALANCE: '.(number_format($total, 2)).' </h3></td>
          </tr>
    </table><br><br>';
    		    $c = 0; $atrasos = 0; $mora = 0; $total = 0; 
	        }
	        
		    $output .= '
	
	<table style="border:1px solid black;" width="100%">
		<tr>
			<td height="20" align="left"><h3>'.$_order->collector_first_name.' </h3></td>
		</tr>	
	</table>
	<table style="border:1px solid black;" width="100%" >
		<tr>
    		<th style="width:8%;border:1px solid black;" align="right"></th>
    		<th style="width:32%;border:1px solid black;" align="left">Cliente</th>
    		<th style="width:10%;border:1px solid black;" align="left">N.° préstamo</th>
    		<th style="width:10%;border:1px solid black;" align="right">N.° pago</th>
    		<th style="width:10%;border:1px solid black;" align="left">Cuota</th>
    		<th style="width:10%;border:1px solid black;" align="right">Mora</th>
    		<th style="width:10%;border:1px solid black;" align="right">Atraso</th>
    		<th style="width:10%;border:1px solid black;" align="right">Total</th>
    	</tr>';
	    }
	    
	    $collector_first_name=$_order->collector_first_name;
		$c++;
		$mora += $_mora;
		$atrasos += floatval($_order->atraso);
		$total = $atrasos + $mora;

		$output .= '<tr>
			<td style="border-right:1px solid black;" align="center">'.$c.'</td>
			<td style="border-right:1px solid black;">'.$_order->customer_first_name.'</td>
			<td style="border-right:1px solid black;" align="right">'.$_order->loans_no.'</td>
			<td style="border-right:1px solid black;" align="right">'.$_order->payment_no.'</td>
			<td style="border-right:1px solid black;" align="right">'.$_order->cuota.'</td>
			<td style="border-right:1px solid black;" align="right">'.number_format($_mora,2).'</td>
			<td style="border-right:1px solid black;" align="right">'.number_format($_order->atraso,2).'</td>
			<td style="border-right:1px solid black;" align="right">'.number_format(($_order->atraso + $_mora),2).'</td>
		</tr> ';
		
	}
	$output .='
    </table>
    
    <table border="0" width="100%">
    	<tr>
            <td align="left" height="20" width="50%"><h3># RECIBOS: '.(number_format($c, 0)).' </h3></td>
            <td align="right" width="50%"><h3>BALANCE: '.(number_format($total, 2)).' </h3></td>
          </tr>
    </table>';

// output the HTML content
$pdf->writeHTML($output, true, false, true, false, '');

//Close and output PDF document
$pdf->Output('Lista de cobro de prestamos '.($loansdue ? 'fuera de fecha ' : 'activos ').date("d-m-Y").'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>