<?php

/**
 * This is the admin controller class providing navigation and interaction functionality.
 */
class Miniplan_Creator_Statistik extends Zikula_AbstractController
{
	/**
	 * @brief Main function.
	 * @throws Different views according to the access
	 * @return template Admin/Main.tpl
	 * 
	 * @author Sascha Rösler
	 */
	private $minis;
	private $all_requested_minis;
	private $max_requested_minis;
	private $worships;
	private $churches;
	private $miniObj;
	
	public function __construct ($myworships, $myminis = array(), $churches)
	{
		$this-> worships = $myworships;
		$this->minis = $myminis;
		$this->churches = $churches;
		$this->calculate_start();
	}
	
	private function calculate_start(){
		foreach ($this->worships as $worship)
		{
			//read requested minis for each worship
			$temp = $worship->getMinis_requested();
			//add this worship to sum
			$this->all_requested_minis += $temp;
			//look, if it has more requested minis than other worships
			if($temp > $this->max_requested_minis)
				$this->max_requested_minis = $temp;
			//count worship
		}
	}
	
	public function getNumberMinis(){
		return count($this->minis)!=0 ? count($this->minis) :  count($this->miniObj);
	}
	
	public function getDurchschnitt(){
		//calculate average times every ministrant has to work
		return $this->all_requested_minis/$this->getNumberMinis();
	}
	
	public function setMinisObj($obj){
		//calculate average times every ministrant has to work
		$this->miniObj = $obj;
	}
	
	public function getMaxRequestedMinis(){
		//calculate average times every ministrant has to work
		return $this->max_requested_minis;
	}
	
	public function getAllRequestedMinis(){
		//calculate average times every ministrant has to work
		return $this->all_requested_minis;
	}
	
	public function varianz(){
		$varianz=0;
		foreach($this->miniObj as $item)
		{
			$varianz+=($item->eingeteilt_week()-$d_weekday) *($item->eingeteilt_week()-$d_weekday);
			$varianz+=($item->eingeteilt_sat() -$d_saturday)*($item->eingeteilt_sat() -$d_saturday);
			$varianz+=($item->eingeteilt_sun() -$d_sunday)  *($item->eingeteilt_sun() -$d_sunday);
			foreach($this->churches as $church)
			{
				$varianz+=($item->eingeteiltChurch($church->getCid())-$d_church[$church->getCid()])*($item->eingeteiltChurch($church->getCid())-$d_church[$church->getCid()]);
			}
		}
		return $varianz;
	}
	
	public function abweichung(){
		return sqrt($varianz);
	}
	
	public function getAllWeekday(){
		$temp = 0;
		foreach($this->miniObj as $item)
			$temp += $item->eingeteilt_week();
		return $temp;
	}
	
	public function getAllSunday(){
		$temp = 0;
		foreach($this->miniObj as $item)
			$temp += $item->eingeteilt_sun();
		return $temp;
	}
	
	public function getAllSatday(){
		$temp = 0;
		foreach($this->miniObj as $item)
			$temp += $item->eingeteilt_sat();
		return $temp;
	}
	
	public function getAllChurches($cid){
		$temp = 0;
		foreach($this->miniObj as $item)
			$temp += $item->eingeteiltChurch($cid);
		return $temp;
	}
	
	public function getAusgabe(){
	
		$table = array();
		
		//prepare Array
		$allocation[0] = array(
			"mini" => "Mini",
			"midname" => "Id",
			"gesamt" => "Gesamt",
			"week" => "Wochentage",
			"saturday" => "Samstag",
			"sunday" => "Sonntag"
		);
		
		//create entries for the churches
		foreach($this->churches as $church)
		{
			$allocation[0][]= $church->getName();
		}
		
		$allocounter = 1;
		//create statistic of mini
		foreach($this->miniObj as $item)
		{
			$allocation[$allocounter] = array(
				"mini" => $item->getUsername(),
				"mid" => $item->getMid(),
				"gesamt" => $item->eingeteilt(),
				"week" => $item->eingeteilt_week(),
				"saturday" => $item->eingeteilt_sat(),
				"sunday" => $item->eingeteilt_sun()
			);
			foreach($this->churches as $church)
			{
				$allocation[$allocounter][$church->getCid()] = $item->eingeteiltChurch($church->getCid()); 
			}
			$allocounter++;
		}
		//$output.="<tr><td></td>";
		$allocation["all"] = array(
				"name" => "alle Minis",
				"gesamt" => $this->all_requested_minis,
				"week" => $this->getAllWeekday(),
				"saturday" =>$this->getAllSatday(),
				"sunday" =>$this->getAllSunday()
			);
		/*$output.= "<td>".$this->getAllWeekday()."</td>";
		$output.= "<td>".$all_saturdays."</td>";
		$output.= "<td>".$all_sundays."</td>";*/
		foreach($this->churches as $church)
		{
			//$output.= "<td>".$all_churches[$church->getCid()]."</td>";
			$allocation["all"][] = $this->getAllChurches($church->getCid());
		}
		//$output.="</tr><tr><td></td>";
		$d_weekday = $this->getAllWeekday()/$this->getNumberMinis();
		//$output.= "<td>".$d_weekday."</td>";
		$d_saturday =$this->getAllSatday()/$this->getNumberMinis();
		//$output.= "<td>".$d_saturday."</td>";
		$d_sunday =$this->getAllSunday()/$this->getNumberMinis();
		//$output.= "<td>".$d_sunday."</td>";
		
		$allocation["durchschnitt"] = array(
				"name" => " Durchschnitt aller Minis",
				"gesamt" => $this->getDurchschnitt(),
				"week" => $d_weekday,
				"saturday" => $d_saturday,
				"sunday" => $d_sunday
			);
		
		foreach($this->churches as $church)
		{
			$allocation["durchschnitt"][] = $d_church[$church->getCid()] += $this->getAllChurches($church->getCid())/$this->getNumberMinis();
		}
		
		return $allocation;
	}
	
	//berechne, wie oft jeder Ministrant wo eingeteilt wurde
	public function calculateStatistik(){
		foreach($this->miniObj as $item)
		{
			$em = ServiceUtil::getService('doctrine.entitymanager');
			$myplan = $em->getRepository('Miniplan_Entity_Plan')->findBy(array("mid"=>$item->getMid()));
			
			foreach($myplan as $mytermin){
				$this->AddWorshipToMini($item->getMid(), $mytermin->getWid());
			}
		}
	}
	
	//füge bei 
	public function AddWorshipToMini($mid, $wid){
		$em = ServiceUtil::getService('doctrine.entitymanager');
		$worship = $em->find('Miniplan_Entity_Worship', $wid);
		if(is_array($worship)){
		
		    $this->miniObj[$mid]->eingeteiltindecrement();
		    $this->miniObj[$mid]->churchindecrement($worship->getCid());
		

		    switch($worship->getDay())
		    {
			    case "Sunday":
				    $this->miniObj[$mid]->sundayindecrement();
				    break;
			    case "Saturday":
				    $this->miniObj[$mid]->saturdayindecrement();
				    break;
			    default:
				    $this->miniObj[$mid]->weekdayindecrement();
		    }
	    }
	}
}
