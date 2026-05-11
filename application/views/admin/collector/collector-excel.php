<?php
// Create Excel FIle				
	foreach($recored as $_recored)
	{
		
		$collector_first_name = $_recored->collector_first_name;
		$collector_email = $_recored->collector_email;
		$collector_address = str_replace($_recored->collector_address, ',', '');
		$collector_city = $_recored->collector_city;
		$collector_zipcode = $_recored->collector_zipcode;
		$collector_phone = $_recored->collector_phone;
		$collector_balance = $_recored->collector_balance;
		$create_date = $_recored->create_date;
		
		$data[][] = "$collector_first_name,$collector_email,$collector_address,$collector_city,$collector_zipcode,$collector_phone,$collector_balance,$create_date";
	}
				
			
				$filename = "Reporte_de_Cobradores";
				$excel = new PHPExcel();
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
				header('Cache-Control: max-age=0');
				
				$excel->setActiveSheetIndex(0);
				
				$rowCount = 1;
						
					$excel->getActiveSheet()->SetCellValue('A'.$rowCount, ' CLIENTE ');
					$excel->getActiveSheet()->SetCellValue('B'.$rowCount, ' CORREO ELECTRÓNICO ');
					$excel->getActiveSheet()->SetCellValue('C'.$rowCount, ' DIRECCIÓN ');
					$excel->getActiveSheet()->SetCellValue('D'.$rowCount, ' CIUDAD ');
					$excel->getActiveSheet()->SetCellValue('E'.$rowCount, ' CÓDIGO POSTAL ');
					$excel->getActiveSheet()->SetCellValue('F'.$rowCount, ' TELÉFONO ');
					$excel->getActiveSheet()->SetCellValue('G'.$rowCount, ' BALANCE ');
					$excel->getActiveSheet()->SetCellValue('H'.$rowCount, ' FECHA DE REGISTRO ');
					
						$excel->getActiveSheet()
							->getStyle('A1:H1')
							->applyFromArray(
								array(
									'fill' => array(
										'type' => PHPExcel_Style_Fill::FILL_SOLID,
										'color' => array('rgb' => '4682B4')
									)
								)
							);
						
						$excel->getActiveSheet()
							->getStyle('A1:H1')
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
						foreach(range('A','H') as $columnID)
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
						$excel->getActiveSheet()->SetCellValue('H'.$rowCount, $da[7]);
							
					}
					$rowCount++;
				}
				$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
				$writer->save('php://output');
				ob_flush();
		
?>