<?php

/**
 * This is the admin controller class providing navigation and interaction functionality.
 */
class Miniplan_Creator_Gottesdienst //extends Zikula_AbstractController
{
	/**
	 * @brief Main function.
	 * @throws Different views according to the access
	 * @return template Admin/Main.tpl
	 * 
	 * @author Sascha Rösler
	 */
	 
	private $database;
	//Speicher für eingeteilte Ministranten:
	private $minis;
	// Minis, cant ministrate at this worship
	private $closed_minis;
	// Planspeicher für die Simulation (Partner prüfen)
	private $temp_plan;
	private $temp_plan_prio;
	private $log;

	public function __construct ($data, $log)
	{
		$this->setObj($data, $log);
	}

	public function setObj($data, $log)
	{
		$this->database = $data;
		$this->minis = array();
		$this->log = $log;
		$this->closed_minis = array();
		$this->temp_plan = array();
		$this->temp_plan_prio = array();
	}

	public function getId()
	{
		return $this->database->getWid();
	}
	
	public function getMinisRequested()
	{
		return $this->database->getMinis_requested();
	}
	
	public function getDate(){
		return $this->database->getDate()->format('U');
	}
	
	public function getDateUnformatted(){
		return $this->database->getDate();
	}
	
	public function getDateFormattedout(){
		return $this->database->getDateFormattedout();
	}
	
	public function getDay(){
		return $this->database->getDay();
	}
	
	public function getTime(){
		return $this->database->getTimeFormatted();
	}
	
	public function getCid(){
		return $this->database->getCid();
	}
	
	public function getChurchName(){
		
		return $this->database->getCnic();
		
	}
	
	//Ist Mini eingeteilt?
	public function hasMini($search){
		return in_array($search, $this->minis);
		//return $this->minis["mini".$i];
	}
	
	//Eingeteilt Minis zählen
	public function countMinis(){
		return count($this->minis);
	}
	
	//Eingeteilt Ministranten ausgeben
	public function getMinis(){
		return $this->minis;
	}
	
	public function writeMini($name, $data){
		$this->minis[$name] = $data;
	}
	
	public function getInfo(){
		return $this->database->getInfo();
	}
	
	//add mini to closed_minis
	//it exepts arrays, too
	public function addClosedMini($name){
		if(is_array($name) )
			$this->closed_minis = array_merge($this->closed_minis, $name);
		else
			$this->closed_minis[] = $name;
		$this->log->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT))," Blog: ".$name);
		$this->cleanTempPlanMini();
	}
	
	//set the howle temp to closed_minis
	public function addTempToClose(){
		$this->addClosedMini($this->temp_plan);
	}
	
	public function miniIsClosed($name){
		return in_array($name, $this->closed_minis);
	}
	
	public function addTempPlanMini($name, $prio){
		$this->temp_plan[] = $name;
		$this->temp_plan_prio[] = $prio;
	}
	
	//unset last element in temp, returns the value of the last element
	public function deleteLastTempMini(){
		$id = $this->countTempPlanMini()-1;
		$this->addClosedMini($this->temp_plan[$id]);
		unset($this->temp_plan[$id]);
	}
	
	public function countTempPlanMini(){
		return count($this->temp_plan);
	}
	
	public function miniIsInTemp($name){
		return in_array($name, $this->temp_plan);
	}
	
	public function cleanTempPlanMini(){
		$this->temp_plan = array();
		$this->temp_plan_prio = array();
	}
	
	//gibt Kettenlänge zurück
	public function countPrio(){
		$i = count($this->temp_plan_prio)-1;
		$counter = 0;
		while($this->temp_plan_prio[$i]==1)
		{
			$i --;
			$counter ++;
		}
		
		return $counter;
	}
	
	//schreibe temp in plan und leere temp anschließend
	public function addTempToPlan($logManager, $statistik){
		foreach($this->temp_plan as $miniId)
		{
			//write mini
			$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT))," Schreibe Ministrant in den Plan:"."mini".$this->countMinis()." Id = ".$miniId);
			$this->writeMini("mini".$this->countMinis(), $miniId);
			//count mini
			
			
			$statistik->AddWorshipToMini($miniId, $this->getId());
			
			/*$minis[$miniId]->eingeteiltindecrement();
			$minis[$miniId]->churchindecrement($this->getCid());

			switch($this->getDay())
			{
				case "Sunday":
					$minis[$miniId]->sundayindecrement();
					break;
				case "Saturday":
					$minis[$miniId]->saturdayindecrement();
					break;
				default:
					$minis[$miniId]->weekdayindecrement();
			}*/
		}
		
		$this->cleanTempPlanMini();
	}
	
	//prüfen, ob ein Ministrant benötigt wird
	public function needMini(){
		return $this->getMinisRequested() - $this->countMinis();
	}
	
	//prüfen, ob ein Ministrant benötigt wird, wenn der Templan hinzugefügt wird
	public function needMiniTemp(){
		return $this->getMinisRequested() - ($this->countMinis() + $this->countTempPlanMini());
	}
}
