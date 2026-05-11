<?php
// Create Excel FIle				
	foreach($recored as $_recored)
	{
		
		$guarantor_first_name = $_recored->guarantor_first_name;
		$guarantor_email = $_recored->guarantor_email;
		$guarantor_address = str_replace($_recored->guarantor_address, ',', '');
		$guarantor_city = $_recored->guarantor_city;
		$guarantor_zipcode = $_recored->guarantor_zipcode;
		$guarantor_phone = $_recored->guarantor_phone;
		$guarantor_balance = $_recored->guarantor_balance;
		$create_date = $_recored->create_date;
		
		$data[][] = "$guarantor_first_name,$guarantor_email,$guarantor_address,$guarantor_city,$guarantor_zipcode,$guarantor_phone,$guarantor_balance,$create_date";
	}
				
			
				$filename = "Reporte_de_Garantes";
				$excel = new PHPExcel();
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
				header('Cache-Control: max-age=0');
				
				$excel->setActiveSheetIndex(0);
				
				$rowCount = 1;
						
					$excel->getActiveSheet()->SetCellValue('A'.$rowCount, ' GARANTE ');
					$excel->getActiveSheet()->SetCellValue('B'.$rowCount, ' CORREO ELECTRÓNICO ');
					$excel->getActiveSheet()->SetCellValue('C'.$rowCount, ' DIRECCIÓN ');
					$excel->getActiveSheet()->SetCellValue('D'.$rowCount, ' CIUDAD ');
					//$excel->getActiveSheet()->SetCellValue('E'.$rowCount, ' CÓDIGO POSTAL ');
					$excel->getActiveSheet()->SetCellValue('E'.$rowCount, ' TELÉFONO ');
					$excel->getActiveSheet()->SetCellValue('F'.$rowCount, ' BALANCE ');
					$excel->getActiveSheet()->SetCellValue('G'.$rowCount, ' FECHA DE REGISTRO ');
					
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
						//$excel->getActiveSheet()->SetCellValue('E'.$rowCount, $da[4]);
						$excel->getActiveSheet()->SetCellValue('E'.$rowCount, $da[5]);
						$excel->getActiveSheet()->SetCellValue('F'.$rowCount, $da[6]);
						$excel->getActiveSheet()->SetCellValue('G'.$rowCount, $da[7]);
							
					}
					$rowCount++;
				}
				$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
				$writer->save('php://output');
				ob_flush();
		
?>