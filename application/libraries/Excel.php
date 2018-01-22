<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Excel {
	 //flag is true means header data field same 
    function export($data, $header, $filename, $flag = false,$filters = null,$data_datas = null)
    	{
				 require_once APPPATH . 'third_party/PHPExcel.php';
				 
				
				  $objPHPExcel = new PHPExcel();
				// Set the active Excel worksheet to sheet 0 
				$objPHPExcel->setActiveSheetIndex(0);  
				// Initialise the Excel row number 
				$rowCount = 1;  

				//start of printing column names as names of MySQL fields  
				$column = 'A';
				for ($i = 0; $i < count($header) ; $i++)  
				{
						$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $header[$i]);
						$objPHPExcel->getActiveSheet()->getStyle($column.$rowCount)->getFont()->setBold(true);
						$objPHPExcel->getDefaultStyle()->getAlignment($column.$rowCount)->setWrapText(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setWidth(20);
						$column++;
				}
	
				//end of adding column names  
				//start while loop to get data  
				$rowCount = 2;  
				if($flag){
				$count=count($data)+2;
				$count1=count($data)+3;
				$alt_count=0;
			    foreach($data as $key=>$res)
				{
				$alt_count=$alt_count+1;
				$column = 'A';
				for ($i = 0; $i < count($header) ; $i++) 
				{
				if(!isset($res[$header[$i]]))
				$value = NULL;  
				elseif ($res[$header[$i]] != "")  
				$value = $res[$header[$i]];  
				else  
				$value = "";  
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $value);
				if($alt_count%2==0)
				{
				$objPHPExcel->getActiveSheet()->getStyle($column.$rowCount)->getFill()->applyFromArray(
	            array(
		        'type'       => PHPExcel_Style_Fill::FILL_SOLID,
		         'startcolor' => array('rgb' => 'E9E9E9'),
		         'endcolor'   => array('rgb' => 'E9E9E9')
	            )
                 );
				 }
			    $column++;
			    }	
			
				$rowCount++;					 
			}	
					   if(!empty($filters) && !empty($data_datas))
					   {
					   $filter_Count=$rowCount+2;
					   $filter_Count1=$rowCount+2;
	                  $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$filter_Count,'Search By Datas');
					   $objPHPExcel->getActiveSheet()->getStyle('A'.$filter_Count)->getFont()->setBold(true);
					   $filter_Count=$filter_Count+1;
					   $filter_Count1=$filter_Count1+1;
					   foreach($filters as $f)
					   {
					     $filter_Count=$filter_Count+1;
					     $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$filter_Count,$f);
						 $objPHPExcel->getActiveSheet()->getStyle('A'.$filter_Count)->getFont()->setBold(true);
					   }
					   foreach($data_datas as $f)
					   {
					     $filter_Count1=$filter_Count1+1;
					     $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$filter_Count1,$f);
					   }
					   
					   }
				}else
				{
						foreach($data as $key=>$res)
						{
								$column = 'A';
								foreach ($res as $cell)
								{
										if(!isset($cell))
													$value = NULL;  
										else
													$value = strip_tags($cell); 
										$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $value);
										$column++;
								}
								$rowCount++;				
						}
				}
			
				// Redirect output to a client’s web browser (Excel5) 
				header('Content-Type: application/vnd.ms-excel'); 
				header('Content-Disposition: attachment;filename="'.$filename.'"'); 
				header('Cache-Control: max-age=0'); 
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
				$objWriter->save('php://output');
		}

}
