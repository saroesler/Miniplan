<?php

/**
 * This is the admin controller class providing navigation and interaction functionality.
 */
class Miniplan_Controller_Print extends Zikula_AbstractController
{
	/**
	 * @brief Main function.
	 * @throws Different views according to the access
	 * @return template Admin/Main.tpl
	 * 
	 * @author Sascha Rösler
	 */
	 
	 /*
	 *Security: access ADmin: add and remove sites
	 *			access Moderate: confirm pages
	 *			access Edit: edit pages
	 */
	 
	 /*
	 * args:
	 * $data = array('worships' => $worships, 
				'churches'=> $churches,
				'minis' => $minis,
				'uids' => $uids,
				'users' => $users
				);
	*/
	
	public function printDataXLS($args)
	{
		/** Error reporting */
		error_reporting(E_ALL);

		/** Include path **/
		ini_set('include_path', ini_get('include_path').';../Classes/');

		/** PHPExcel */
		include 'PHPExcel.php';

		/** PHPExcel_Writer_Excel2007 */
		include 'PHPExcel/Writer/Excel2007.php';

		$styleArrayKann = array(
			'font' => array(
				'bold' => false,
				'color'     => array(
					'rgb' => '008800'
				)
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
			/*'borders' => array(
				'top' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),*/
		);
		
		$styleArrayNicht = array(
			'font' => array(
				'bold' => true,
				'color'     => array(
					'rgb' => 'ff0000'
				)
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
			/*'borders' => array(
				'top' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),*/
		);
		
		$styleArrayFreiwillig = array(
			'font' => array(
				'bold' => false,
				'color'     => array(
					'rgb' => '0000ff'
				)
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
		);
		
		$styleArrayHeading = array(
			'font' => array(
				'bold' => true,
				'size' => 14,
				'color'     => array(
					'rgb' => '0000ff'
				)
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
		);
		
		// Create new PHPExcel object
		//echo date('H:i:s') . " Create new PHPExcel object\n";
		$objPHPExcel = new PHPExcel();
		
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(10); 

		// Set properties
		//echo date('H:i:s') . " Set properties\n";
		$objPHPExcel->getProperties()->setCreator("Miniplan st-marien-spandau.de");
		$objPHPExcel->getProperties()->setLastModifiedBy("Miniplan st-marien-spandau.de");
		$objPHPExcel->getProperties()->setTitle("Miniplan Daten vom ".date('d.m.y'));
		$objPHPExcel->getProperties()->setSubject("Miniplan Daten vom ".date('d.m.y'));
		$objPHPExcel->getProperties()->setDescription("Daten, wann die Minis, wie eingeteilt werden können.");


		// Add some data
		//echo date('H:i:s') . " Add some data\n";
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Miniplan Daten vom '.date('d.m.y'));
		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArrayHeading);
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
		
		$column = 'D';
		
		foreach($args['worships'] as $worship)
		{
			$objPHPExcel->getActiveSheet()->SetCellValue($column.'3', $worship->getDateFormattedout());
			$objPHPExcel->getActiveSheet()->SetCellValue($column.'4', $worship->getTimeFormatted());
			$objPHPExcel->getActiveSheet()->SetCellValue($column.'5', $worship->getCnic());
			$objPHPExcel->getActiveSheet()->SetCellValue($column.'6', $worship->getMinis_requested()." Minis");
			
			$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setWidth(11);
			
			$column++;
		}
		
		$objPHPExcel->getActiveSheet()->getStyle('A6:'.$column.'6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
		
		$row = 7;
		

		foreach($args['minis'] as $mini){
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$row, $mini->getNicname());
			if($mini->getPid())							//hat Partner
			{
				if($mini->getPpriority())
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$row, "immer");
				else
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$row, "gerne");
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$row, $mini->getPnic());
			}
			
			$column = 'D';
			foreach($args['worships'] as $worship)
			{
				$data = $mini->getMy_calendar();
				if($data[$worship->getWid()] == 1){
					$objPHPExcel->getActiveSheet()->getStyle($column.$row)->applyFromArray($styleArrayNicht);
					$objPHPExcel->getActiveSheet()->SetCellValue($column.$row, "nicht");
				}
				elseif($data[$worship->getWid()] == 2){
					$objPHPExcel->getActiveSheet()->getStyle($column.$row)->applyFromArray($styleArrayFreiwillig);
					$objPHPExcel->getActiveSheet()->SetCellValue($column.$row, "freiwillig");
				}
				else{
					$objPHPExcel->getActiveSheet()->getStyle($column.$row)->applyFromArray($styleArrayKann);
					$objPHPExcel->getActiveSheet()->SetCellValue($column.$row, "kann");
				}
				$column ++;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue($column.$row, $mini->getEinteilungsIndex());
			$row ++;
		}
		$objPHPExcel->getActiveSheet()->getStyle('C3:C'.$row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
		
		// Rename sheet
		//echo date('H:i:s') . " Rename sheet\n";
		$objPHPExcel->getActiveSheet()->setTitle('Miniplan');
		
		ob_end_clean();
		if($args['type'] == 'xls'){
			// Redirect output to a client’s web browser (Excel5)
			header('Content-type: application/vnd.ms-excel');
			$filetype = '.xls';
		}
		else{
			// Redirect output to a client’s web browser (OpenDocument)
			header('Content-type: application/vnd.oasis.opendocument.spreadsheet');
			$filetype = '.ods';
		}
		
		header('Content-Disposition: attachment;filename="Miniplandaten'.date('y_d_m').$filetype);
		
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		if($args['type'] == 'xls')
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		else
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'OpenDocument');
		$objWriter->save('php://output');
		system::shutdown();

		// Echo done
		echo date('H:i:s') . " Done writing file.\r\n";
		system::shutdown();
	}
	
	
	/*
	 * args:
	 * $data = array('worships' => $worships, 
				'churches'=> $churches,
				'minis' => $minis,
				'uids' => $uids,
				'users' => $users
				);
	*/
	
	public function printAddressXLS($ministrants)
	{
		/** Error reporting */
		error_reporting(E_ALL);

		/** Include path **/
		ini_set('include_path', ini_get('include_path').';../Classes/');

		/** PHPExcel */
		include 'PHPExcel.php';

		/** PHPExcel_Writer_Excel2007 */
		include 'PHPExcel/Writer/Excel2007.php';

		$styleArrayKann = array(
			'font' => array(
				'bold' => false,
				'color'     => array(
					'rgb' => '008800'
				)
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
			/*'borders' => array(
				'top' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),*/
		);
		
		$styleArrayNicht = array(
			'font' => array(
				'bold' => true,
				'color'     => array(
					'rgb' => 'ff0000'
				)
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
			/*'borders' => array(
				'top' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),*/
		);
		
		$styleArrayFreiwillig = array(
			'font' => array(
				'bold' => false,
				'color'     => array(
					'rgb' => '0000ff'
				)
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
		);
		
		$styleArrayHeading = array(
			'font' => array(
				'bold' => true,
				'size' => 14,
				'color'     => array(
					'rgb' => '0000ff'
				)
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
		);
		
		// Create new PHPExcel object
		//echo date('H:i:s') . " Create new PHPExcel object\n";
		$objPHPExcel = new PHPExcel();
		
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(10); 

		// Set properties
		//echo date('H:i:s') . " Set properties\n";
		$objPHPExcel->getProperties()->setCreator("Homepage st-marien-spandau.de");
		$objPHPExcel->getProperties()->setLastModifiedBy("Homepage st-marien-spandau.de");
		$objPHPExcel->getProperties()->setTitle("Adressliste vom ".date('d.m.y'));
		$objPHPExcel->getProperties()->setSubject("Adressliste vom ".date('d.m.y'));
		$objPHPExcel->getProperties()->setDescription("Adressliste der Ministranten");


		// Add some data
		//echo date('H:i:s') . " Add some data\n";
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Adressliste Daten vom '.date('d.m.y'));
		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArrayHeading);
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
		/*
		<td>{$ministrant.__ATTRIBUTES__.realname}</td>
		<td>{$ministrant.__ATTRIBUTES__.first_name}</td>
		<td>{$ministrant.__ATTRIBUTES__.street}</td>
		<td>{$ministrant.__ATTRIBUTES__.place}</td>
		<td>{$ministrant.__ATTRIBUTES__.plz}</td>
		<td>{$ministrant.__ATTRIBUTES__.birthday}</td>
		<td>{$ministrant.__ATTRIBUTES__.tel}</td>
		<td>{$ministrant.__ATTRIBUTES__.mobile}</td>
		<td>{$ministrant..__ATTRIBUTES__parent_mobile}</td>
		<td><a href="mailto:{$ministrant.email}">{$ministrant.email}</a></td>
		*/
		$objPHPExcel->getActiveSheet()->SetCellValue('B3', "Name");
		$objPHPExcel->getActiveSheet()->SetCellValue('C3', "Vorname");
		$objPHPExcel->getActiveSheet()->SetCellValue('D3', "Adresse");
		$objPHPExcel->getActiveSheet()->SetCellValue('E3', "Plz");
		$objPHPExcel->getActiveSheet()->SetCellValue('F3', "Ort");
		$objPHPExcel->getActiveSheet()->SetCellValue('G3', "Geburtstag");
		$objPHPExcel->getActiveSheet()->SetCellValue('H3', "Telefon");
		$objPHPExcel->getActiveSheet()->SetCellValue('I3', "Mobil");
		$objPHPExcel->getActiveSheet()->SetCellValue('J3', "Eltern Mobil");
		$objPHPExcel->getActiveSheet()->SetCellValue('K3', "E-Mail");
		
		$row = 5;
		
		$erster = true;
		
		foreach($ministrants as $ministrant)
		{
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$row, "=A".($row-1)."+1");
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$row, $ministrant[__ATTRIBUTES__][realname]);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$row, $ministrant[__ATTRIBUTES__][first_name]);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$row, $ministrant[__ATTRIBUTES__][street]);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$row, $ministrant[__ATTRIBUTES__][place]);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$row, $ministrant[__ATTRIBUTES__][plz]);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$row, $ministrant[__ATTRIBUTES__][birthday]);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$row, $ministrant[__ATTRIBUTES__][tel]);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$row, $ministrant[__ATTRIBUTES__][mobil]);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$row, $ministrant[__ATTRIBUTES__][parent_mobile]);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$row, $ministrant[email]);
			
			$row++;
		}
		$objPHPExcel->getActiveSheet()->SetCellValue('A5', "1");
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getStyle('A5:'.'K'.$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
		$objPHPExcel->getActiveSheet()->setTitle('Adressliste');
		
		ob_end_clean();
		if($args['type'] == 'xls'){
			// Redirect output to a client’s web browser (Excel5)
			header('Content-type: application/vnd.ms-excel');
			$filetype = '.xls';
		}
		else{
			// Redirect output to a client’s web browser (OpenDocument)
			header('Content-type: application/vnd.oasis.opendocument.spreadsheet');
			$filetype = '.ods';
		}
		
		header('Content-Disposition: attachment;filename="Miniplandaten'.date('y_d_m').$filetype);
		
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		if($args['type'] == 'xls')
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		else
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'OpenDocument');
		$objWriter->save('php://output');
		system::shutdown();

		// Echo done
		echo date('H:i:s') . " Done writing file.\r\n";
		system::shutdown();
	}
}
