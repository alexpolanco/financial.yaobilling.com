<?php
// Create Excel FIle				
	foreach($recored as $_recored)
	{
		
		$product_id = $_recored->product_id;
		$admin_id = $_recored->admin_id;
		$category_id = $_recored->category_id;
		$sub_category_id = $_recored->sub_category_id;
		$brand_id = $_recored->brand_id;
		$product_for = $_recored->product_for;
		$article_no = $_recored->article_no;
		$size_no = $_recored->size_no;
		$total_stock = $_recored->total_stock;
		$product_name = $_recored->product_name;
		$product_serial_no = $_recored->product_serial_no;
		$product_description = $_recored->product_description;
		$product_actual_price = $_recored->product_actual_price;
		$product_margin = $_recored->product_margin;
		$product_discount = $_recored->product_discount;
		$product_stock = $_recored->product_stock;
		$product_image_1 = $_recored->product_image_1;
		$product_image_2 = $_recored->product_image_2;
		$product_image_3 = $_recored->product_image_3;
		$product_image_4 = $_recored->product_image_4;
		$product_image_5 = $_recored->product_image_5;
		$product_time_visited = $_recored->product_time_visited;
		$product_meta_title = $_recored->product_meta_title;
		$product_meta_desc = $_recored->product_meta_desc;
		$product_meta_keywords = $_recored->product_meta_keywords;
		$product_display_order = $_recored->product_display_order;
		$product_is_new_arrival = $_recored->product_is_new_arrival;
		$product_is_active = $_recored->product_is_active;
		$entry_date = $_recored->entry_date;
		$create_date = $_recored->create_date;

		$data[][] = "$product_id,$admin_id,$category_id,$sub_category_id,$brand_id,$product_for,$article_no,$size_no,$total_stock,$product_name,$product_serial_no,$product_description,$product_actual_price,$product_margin,$product_discount,$product_stock,$product_image_1,$product_image_2,$product_image_3,$product_image_4,$product_image_5,$product_time_visited,$product_meta_title,$product_meta_desc,$product_meta_keywords,$product_display_order,$product_is_new_arrival,$product_is_active,$entry_date,$create_date,";
	}
				
			
				$filename = "Productos_YaoBilling";
				$excel = new PHPExcel();
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
				header('Cache-Control: max-age=0');
				
				$excel->setActiveSheetIndex(0);
				
				$rowCount = 1;
						
					$excel->getActiveSheet()->SetCellValue('A'.$rowCount, ' CÓDIGO DEL PRODUCTO ');
					$excel->getActiveSheet()->SetCellValue('B'.$rowCount, ' USUARIO ');
					$excel->getActiveSheet()->SetCellValue('C'.$rowCount, ' CATEGORÍA ');
					$excel->getActiveSheet()->SetCellValue('D'.$rowCount, ' SUBCATEGORÍA ');
					$excel->getActiveSheet()->SetCellValue('E'.$rowCount, ' MARCA ');
					$excel->getActiveSheet()->SetCellValue('F'.$rowCount, ' USO ');
					$excel->getActiveSheet()->SetCellValue('G'.$rowCount, ' ARTÍCULO ');
					$excel->getActiveSheet()->SetCellValue('H'.$rowCount, ' TAMAÑO ');
					$excel->getActiveSheet()->SetCellValue('I'.$rowCount, ' EN INVENTARIO ');
					$excel->getActiveSheet()->SetCellValue('J'.$rowCount, ' PRODUCTO ');
					$excel->getActiveSheet()->SetCellValue('K'.$rowCount, ' CÓDIGO ');
					$excel->getActiveSheet()->SetCellValue('L'.$rowCount, ' DESCRIPCIÓN ');
					$excel->getActiveSheet()->SetCellValue('M'.$rowCount, ' PRECIO ');
					$excel->getActiveSheet()->SetCellValue('N'.$rowCount, ' MARGEN ');
					$excel->getActiveSheet()->SetCellValue('O'.$rowCount, ' DESCUENTO ');
					$excel->getActiveSheet()->SetCellValue('P'.$rowCount, ' INVENTARIO ');
					$excel->getActiveSheet()->SetCellValue('Q'.$rowCount, ' IMAGEN_1 ');
					$excel->getActiveSheet()->SetCellValue('R'.$rowCount, ' IMAGEN_2 ');
					$excel->getActiveSheet()->SetCellValue('S'.$rowCount, ' IMAGEN_3 ');
					$excel->getActiveSheet()->SetCellValue('T'.$rowCount, ' IMAGEN_4 ');
					$excel->getActiveSheet()->SetCellValue('U'.$rowCount, ' IMAGEN_5 ');
					$excel->getActiveSheet()->SetCellValue('V'.$rowCount, ' VISTO ');
					$excel->getActiveSheet()->SetCellValue('W'.$rowCount, ' META TÍTULO ');
					$excel->getActiveSheet()->SetCellValue('X'.$rowCount, ' META DESCRIPCIÓN ');
					$excel->getActiveSheet()->SetCellValue('Y'.$rowCount, ' META PALABRAS CLAVES ');
					$excel->getActiveSheet()->SetCellValue('Z'.$rowCount, ' ORDEN DE VISUALIZACIÓN ');
					$excel->getActiveSheet()->SetCellValue(''.$rowCount, ' ES TENDENCIA ');
					$excel->getActiveSheet()->SetCellValue(''.$rowCount, ' ESTÁ ACTIVO ');
					$excel->getActiveSheet()->SetCellValue(''.$rowCount, ' FECHA DE REGISTRO ');
					$excel->getActiveSheet()->SetCellValue(''.$rowCount, ' FECHA DE CREADO ');

					
						$excel->getActiveSheet()
							->getStyle('A1:1')
							->applyFromArray(
								array(
									'fill' => array(
										'type' => PHPExcel_Style_Fill::FILL_SOLID,
										'color' => array('rgb' => '4682B4')
									)
								)
							);
						
						$excel->getActiveSheet()
							->getStyle('A1:1')
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
						foreach(range('A','') as $columnID)
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
					$excel->getActiveSheet()->SetCellValue('I'.$rowCount, $da[8]);
					$excel->getActiveSheet()->SetCellValue('J'.$rowCount, $da[9]);
					$excel->getActiveSheet()->SetCellValue('K'.$rowCount, $da[10]);
					$excel->getActiveSheet()->SetCellValue('L'.$rowCount, $da[11]);
					$excel->getActiveSheet()->SetCellValue('M'.$rowCount, $da[12]);
					$excel->getActiveSheet()->SetCellValue('N'.$rowCount, $da[13]);
					$excel->getActiveSheet()->SetCellValue('O'.$rowCount, $da[14]);
					$excel->getActiveSheet()->SetCellValue('P'.$rowCount, $da[15]);
					$excel->getActiveSheet()->SetCellValue('Q'.$rowCount, $da[16]);
					$excel->getActiveSheet()->SetCellValue('R'.$rowCount, $da[17]);
					$excel->getActiveSheet()->SetCellValue('S'.$rowCount, $da[18]);
					$excel->getActiveSheet()->SetCellValue('T'.$rowCount, $da[19]);
					$excel->getActiveSheet()->SetCellValue('U'.$rowCount, $da[20]);
					$excel->getActiveSheet()->SetCellValue('V'.$rowCount, $da[21]);
					$excel->getActiveSheet()->SetCellValue('W'.$rowCount, $da[22]);
					$excel->getActiveSheet()->SetCellValue('X'.$rowCount, $da[23]);
					$excel->getActiveSheet()->SetCellValue('Y'.$rowCount, $da[24]);
					$excel->getActiveSheet()->SetCellValue('Z'.$rowCount, $da[25]);
					$excel->getActiveSheet()->SetCellValue(''.$rowCount, $da[26]);
					$excel->getActiveSheet()->SetCellValue(''.$rowCount, $da[27]);
					$excel->getActiveSheet()->SetCellValue(''.$rowCount, $da[28]);
					$excel->getActiveSheet()->SetCellValue(''.$rowCount, $da[29]);

						
					}
					$rowCount++;
				}
				$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
				$writer->save('php://output');
				ob_flush();
		
?>