<?php
// Create Excel FIle
	$CI =& get_instance();
	$total_ci =0;
	$total_re =0;
	$total_fi =0;
	$total_in =0;
	$total_ra =0;
	$total_to =0;
	
	foreach ($recored as $_date) {
		$total_ci += $_date->loanscapital_amount;
		$total_re += $_date->loanschristmas_amount;
		$total_fi += $_date->loansfixed_amount;
		$total_in += $_date->loansinversion_amount;
		$total_ra += $_date->loansquickbusiness_amount;
		$total_to = $total_ci + $total_re + $total_fi + $total_in + $total_ra;

		$_date_total = floatval($_date->loanscapital_amount) + floatval($_date->loanschristmas_amount) + floatval($_date->loansfixed_amount) + floatval($_date->loansinversion_amount) + floatval($_date->loansquickbusiness_amount);

		$data[][] = "$_date->customer_first_name,$_date->loanscapital_amount,$_date->loanschristmas_amount,$_date->loansfixed_amount,$_date->loansinversion_amount,$_date->loansquickbusiness_amount,$_date_total";
	}
	
	//$data[][] = " TOTAL,".number_format($total_ci,2).",".number_format($total_re,2).",".number_format($total_fi,2).",".number_format($total_in,2).",".number_format($total_ra,2).",".number_format($total_to,2);
			
	$filename = "Reporte_de_Prestamos";
	$excel = new PHPExcel();
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
	header('Cache-Control: max-age=0');
	
	$excel->setActiveSheetIndex(0);
	
	$rowCount = 1;

	$excel->getActiveSheet()->SetCellValue('A'.$rowCount, ' CLIENTES ');
	$excel->getActiveSheet()->SetCellValue('B'.$rowCount, ' CAPITAL E INTERES');
	$excel->getActiveSheet()->SetCellValue('C'.$rowCount, ' REGALIA ');
	$excel->getActiveSheet()->SetCellValue('D'.$rowCount, ' FIJOS ');
	$excel->getActiveSheet()->SetCellValue('E'.$rowCount, ' INVERSION ');
	$excel->getActiveSheet()->SetCellValue('F'.$rowCount, ' RAPIDOS ');
	$excel->getActiveSheet()->SetCellValue('G'.$rowCount, ' TOTAL ');
		
	$excel->getActiveSheet()
			->getStyle('A1:G1')
			->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => '4682B4')
					)
				)
			);
	
	$excel->getActiveSheet()
			->getStyle('A1:G1')
			->applyFromArray(
				array(
					'font'  => array(
						'bold'  => true,
						'color' => array('rgb' => 'FFFFFF'),
						'size'  => 10,
						'name'  => 'Times New Roman'
					)
				)
			);
			
	foreach(range('A','G') as $columnID)
	{
		$excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	}
	
	$rowCount++;
	foreach($data as $val){
		foreach($val as $d)
		{
			$da = explode(',',$d);
			
			$excel->getActiveSheet()->SetCellValue('A'.$rowCount, $da[0]);
			$excel->getActiveSheet()->SetCellValue('B'.$rowCount, $da[1]);
			$excel->getActiveSheet()->SetCellValue('C'.$rowCount, $da[2]);
			$excel->getActiveSheet()->SetCellValue('D'.$rowCount, $da[3]);
			$excel->getActiveSheet()->SetCellValue('E'.$rowCount, $da[4]);
			$excel->getActiveSheet()->SetCellValue('F'.$rowCount, $da[5]);
			$excel->getActiveSheet()->SetCellValue('G'.$rowCount, $da[6]);
		}
		$rowCount++;
	}
	$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
	$writer->save('php://output');
	ob_flush();
?>