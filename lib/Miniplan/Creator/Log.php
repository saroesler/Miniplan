<?php

/**
 * This is the admin controller class providing navigation and interaction functionality.
 */
class Miniplan_Creator_Log //extends Zikula_AbstractController
{
	/**
	 * @brief Main function.
	 * @throws Different views according to the access
	 * @return template Admin/Main.tpl
	 * 
	 * @author Sascha Rösler
	 */
	 
	 //private $log;
	 private $open;
	 private $ausgabedatei;

	 public function __construct ($modus, $zeile)
	{
		if($modus == 'w'){
			//$log = array();
			$open = false;
			$this->printLogHeader();
			file_put_contents("modules/Miniplan/lib/Miniplan/short.log", "");
			$this->add($zeile, "Start am ".date('D, d M Y H:i:s'));
			// leere file
		}
	}

	public function add($zeile, $text)
	{
		
		//$this->log[] = "[Zeile ".$zeile."]: ".$text;
		//DEBUG::echo "[Zeile ".$zeile."]: ".$text."<br />";
		// Schreibt den Inhalt in die Datei
		// unter Verwendung des Flags FILE_APPEND, um den Inhalt an das Ende der Datei anzufügen
		// und das Flag LOCK_EX, um ein Schreiben in die selbe Datei zur gleichen Zeit zu verhindern
		file_put_contents("modules/Miniplan/lib/Miniplan/short.log", "[Zeile ".$zeile."]: ".$text."\n", FILE_APPEND | LOCK_EX);
	}

	public function close($zeile)
	{
		$this->add($zeile, " Ende am ".date('D, d M Y H:i:s'));
	}

	public function getData()
	{
		static $open = false;
		static $ausgabedatei = "";
		if(!$open){
			$ausgabedatei = fopen("modules/Miniplan/lib/Miniplan/short.log","r");
			$open = true;
		}
		if(!feof($ausgabedatei))
		{
		   $zeile = fgets($ausgabedatei);
		}
		else{
			$zeile = NULL;
			fclose($ausgabedatei);
			$open = false;
		}
		return $zeile;
	}
	
	public function printLogHeader()
	{
		/*
			"curches" => $churches,				//list of churches
			"worships" => $worships,			//list of worships
			"minis_array" => $minis,			//list of minis
			"mixed_minis" => $minis_rand_array,	//list of mixed minis with data of Amount of divisions
			"plan" => $plan,					//the created plan
			"error_warnings" => $error_warnings,//all error and warnings
			"allocation" => $allocation,		//Häufigkeit der Einteilung
			"varianz" => $varianz,
			"log" => $log						//logfile
		*/
		file_put_contents("modules/Miniplan/lib/Miniplan/log.log", "");
		
		file_put_contents("modules/Miniplan/lib/Miniplan/log.log", "Logdatei für den Miniplan am ".date("Ymd_Hi")."\n\n
#Inhaltsverzeichnis\n
Bitte navigieren Sie durch diese Logdatei mit Hilfe von Hashtags.\nHierzu öffnen Sie mit \"Strg+F\" die Suche und gaben dort das gesuchte Kapitel mit einem \"#\"davor ein.\n\n
#Fehler und Warnungen
#Prozess Log
#Kirchen
#Gottesdienste
#Ministranten
#Gemischte Ministranten", 
		FILE_APPEND | LOCK_EX);
		
	}
	
	public function printLogError($error_warnings)
	{
		
		
		file_put_contents("modules/Miniplan/lib/Miniplan/log.log", "\n\n#Fehler und Warnungen:\n"
			.$error_warnings
			."\n\n", 
		FILE_APPEND | LOCK_EX);
	}
	
	public function printLogProzess()
	{
		file_put_contents("modules/Miniplan/lib/Miniplan/log.log", "#Prozess Log:\n", FILE_APPEND | LOCK_EX);
		
		/*$ausgabedatei = fopen("modules/Miniplan/lib/Miniplan/short.log","r");
		
		while(!feof($ausgabedatei))
		{
			file_put_contents("modules/Miniplan/lib/Miniplan/log.log", fgets($ausgabedatei)/*$this->getData()*//*, FILE_APPEND | LOCK_EX);
		}
		
		fclose($ausgabedatei);*/
		
		while($temp = $this->getData())
		{
			file_put_contents("modules/Miniplan/lib/Miniplan/log.log",$temp, FILE_APPEND | LOCK_EX);
		}
		
		file_put_contents("modules/Miniplan/lib/Miniplan/log.log", "\n\n\n\nAnhang\n", FILE_APPEND | LOCK_EX);
	}
	
	public function printChurches($churches)
	{
		file_put_contents("modules/Miniplan/lib/Miniplan/log.log", "#Kirchen:\n", FILE_APPEND | LOCK_EX);
		
		$temp = print_r($churches, true);
		file_put_contents("modules/Miniplan/lib/Miniplan/log.log", $temp, FILE_APPEND | LOCK_EX);
		
		file_put_contents("modules/Miniplan/lib/Miniplan/log.log", "\n\n", FILE_APPEND | LOCK_EX);
	}
	
	public function printWorships($worships)
	{
		file_put_contents("modules/Miniplan/lib/Miniplan/log.log", "#Gottesdienste:\n", FILE_APPEND | LOCK_EX);
		
		$temp = print_r($worships, true);
		file_put_contents("modules/Miniplan/lib/Miniplan/log.log", $temp, FILE_APPEND | LOCK_EX);
		
		file_put_contents("modules/Miniplan/lib/Miniplan/log.log", "\n\n", FILE_APPEND | LOCK_EX);
	}
	
	public function printMinisArray($minis_array)
	{
		file_put_contents("modules/Miniplan/lib/Miniplan/log.log", "#Ministranten:\n", FILE_APPEND | LOCK_EX);
		
		$temp = print_r($minis_array, true);
		file_put_contents("modules/Miniplan/lib/Miniplan/log.log", $temp, FILE_APPEND | LOCK_EX);
		
		file_put_contents("modules/Miniplan/lib/Miniplan/log.log", "\n\n", FILE_APPEND | LOCK_EX);
		
	}
	
	public function printMixedMinis($mixed_minis)
	{
		file_put_contents("modules/Miniplan/lib/Miniplan/log.log", "#gemischte Ministranten:\n", FILE_APPEND | LOCK_EX);
		
		$temp = print_r($mixed_minis, true);
		file_put_contents("modules/Miniplan/lib/Miniplan/log.log", $temp, FILE_APPEND | LOCK_EX);
		
		file_put_contents("modules/Miniplan/lib/Miniplan/log.log", "\n\n", FILE_APPEND | LOCK_EX);
	}
}
