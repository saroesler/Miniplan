<?php
class Miniplan_Controller_Ajax extends Zikula_AbstractController
{
	/**
	 * @brief Set imaging status of one computer
	 * @param GET $cid The number of computer
	 * @param GET $imagingstatus status of imaging
	 *
	 * This function provides a simple soloutin to image much computers fast
	 *
	 * @author Sascha Rösler
	 * @version 1.0
	 */
	public function WorshipForm_load()
	{
		if (!SecurityUtil::checkPermission('Miniplan::', '::', ACCESS_ADD))
			return new Zikula_Response_Ajax(LogUtil::registerPermissionError());

		$wfid = FormUtil::getPassedValue('wfid', null, 'POST');
		if(!isset($wfid)) {
			return new Zikula_Response_Ajax_BadData($this->__('missing $wfid'));
		}
		$form = $this->entityManager->find('Miniplan_Entity_WorshipForm', $wfid);
		$result['cid'] = $form->getCid();
		$result['wfid'] = $form->getWfid();
		$result['time'] = $form->getTimeFormatted();
		$result['info'] = $form->getInfo();
		$result['minis'] = $form->getMinis_requested();
		return new Zikula_Response_Ajax($result);
		}
	
	
	/**
	 * @brief Get imaging status of much computers
	 * @param GET $cid The numbers of computer
	 * @return $imagingstatus status of imaging
	 *
	 * This function provides a simple soloution to get the imaging status of much computers
	 *
	 * @author Sascha Rösler
	 * @version 1.0
	 */
	public function WorshipForm_save()
	{
		if (!SecurityUtil::checkPermission('Miniplan::', '::', ACCESS_ADMIN))
			return new Zikula_Response_Ajax(LogUtil::registerPermissionError());

		$name = FormUtil::getPassedValue('name', null, 'POST');
		$cid = FormUtil::getPassedValue('cid', null, 'POST');
		$minis = FormUtil::getPassedValue('minis', null, 'POST');
		$time = FormUtil::getPassedValue('time', null, 'POST');
		$info = FormUtil::getPassedValue('info', "", 'POST');
		if(!$name)
			$text = ($this->__("There is no valid name!"));
		if(!$cid)
			$text =($this->__("There is no valid church!"));
		if(!$minis)
			$text = ($this->__("There is no valid number of ministrants!"));
		if(!$time)
			$text = ($this->__("There is no valid time!"));
		if($name&&$cid&&$minis&&$time)
		{
			$form = new Miniplan_Entity_WorshipForm();
			$form->setName($name);
			$form->setCid($cid);
			$form->setTime($time);
			$form->setMinis_requested($minis);
			$form->setInfo($info);
			$this->entityManager->persist($form);
			$this->entityManager->flush();
			$text = ($this->__("Saved")).": ".$name;
			$result['Wfid'] = $form->getWfid();
		}
		
		$result['text'] = $text;
		return new Zikula_Response_Ajax($result);
	}
	
	public function Partner_save()
	{
		if (!SecurityUtil::checkPermission('Miniplan::', '::', ACCESS_ADMIN))
			return new Zikula_Response_Ajax(LogUtil::registerPermissionError());

		$mid = FormUtil::getPassedValue('mid', null, 'POST');
		$pid = FormUtil::getPassedValue('pid', 0, 'POST');
		if(!$mid)
			$text = ($this->__("There is no valid mid!"));
		if($mid)
		{
			$minis = $this->entityManager->getRepository('Miniplan_Entity_User')->findBy(array('mid'=>$mid));
			$mini = $minis[0];
			$mini->setPid($pid);
			$this->entityManager->persist($mini);
			$this->entityManager->flush();
			$text = ($this->__("Saved")).": ".$mid;
			$result['pid'] = $mini->getPid();
		}
		
		$result['text'] = $text;
		return new Zikula_Response_Ajax($result);
	}
	
	public function Ppriority_save()
	{
		if (!SecurityUtil::checkPermission('Miniplan::', '::', ACCESS_ADMIN))
			return new Zikula_Response_Ajax(LogUtil::registerPermissionError());

		$mid = FormUtil::getPassedValue('mid', null, 'POST');
		$setting = FormUtil::getPassedValue('setting', null, 'POST');
		if(!$mid)
			$text = ($this->__("There is no valid mid!"));
		if($mid)
		{
			$minis = $this->entityManager->getRepository('Miniplan_Entity_User')->findBy(array('mid'=>$mid));
			$mini = $minis[0];
			$mini->setPpriority($setting);
			$this->entityManager->persist($mini);
			$this->entityManager->flush();
			$text = ($this->__("Saved")).": ".$mid;
			$result['ppriority'] = $mini->getPpriority();
		}
		
		$result['text'] = $text;
		return new Zikula_Response_Ajax($result);
	}
	
	public function editchange()
	{
		if (!SecurityUtil::checkPermission('Miniplan::', '::', ACCESS_ADMIN))
			return new Zikula_Response_Ajax(LogUtil::registerPermissionError());

		$mid = FormUtil::getPassedValue('mid', null, 'POST');
		$state = FormUtil::getPassedValue('state', null, 'POST');
		if(!$mid)
			$text = ($this->__("There is no valid mid!"));
		if($mid)
		{
			$minis = $this->entityManager->getRepository('Miniplan_Entity_User')->findBy(array('mid'=>$mid));
			$mini = $minis[0];
			if($state)
				$mini->setEdited(1);
			else
				$mini->setEdited(0);
			$this->entityManager->persist($mini);
			$this->entityManager->flush();
			$text = ($this->__("Saved")).": ".$mid;
			$result['ppriority'] = $mini->getPpriority();
		}
		
		$result['text'] = $text;
		return new Zikula_Response_Ajax($result);
	}
	
	public function Calendar_save()
	{
		if (!SecurityUtil::checkPermission('Miniplan::', '::', ACCESS_ADMIN))
			return new Zikula_Response_Ajax(LogUtil::registerPermissionError());

		$mid = FormUtil::getPassedValue('mid', null, 'POST');
		$wid = FormUtil::getPassedValue('wid', null, 'POST');
		$state = FormUtil::getPassedValue('state', 0, 'POST');
		if(!$mid)
			$text = ($this->__("There is no valid mid!"));
		if(!$wid)
			$text = ($this->__("There is no valid worship!"));
		if($mid&&$wid)
		{
			$minis = $this->entityManager->getRepository('Miniplan_Entity_User')->findBy(array('mid'=>$mid));
			$mini = $minis[0];
			$calendar = $mini->getMy_calendar();
			$calendar[$wid] = $state;
			$result['state'] = $state;
			$mini->setMy_calendar($calendar);
			$this->entityManager->persist($mini);
			$this->entityManager->flush();
			$text = ($this->__("Saved")).": ".$mid;
			$result['calendar'] = $mini->getMy_calendar();
		}
		
		$result['text'] = $text;
		return new Zikula_Response_Ajax($result);
	}
	
	public function PrintLog(){
		static $firstTime = true;
		static $log;
		
		if($firstTime)
		{
			$log = new Miniplan_Creator_Log('r', "");
			$firstTime = false;
		}
		
		$meldung = "";
		$counter = 0;
		$ende = true;
		/*while(($temp = $log->getData()) != NULL && ($counter < 10) )
		{
			$meldung .= $temp."<br />";
			$counter ++;
			if($temp == NULL)
			{
				$ende = true;
				break;
			}
		}*/
		while($temp = $log->getData())
		{
			$meldung .= $temp."<br />";
			//$counter ++;
			
			if($counter > 100)
			{
				$ende = false;
				break;
			}
		}
		
		$result['log'] = $meldung;
		$result['ende'] = $ende;
		return new Zikula_Response_Ajax($result);
	}
	
	public function delDivision(){
		if (!SecurityUtil::checkPermission('Miniplan::', '::', ACCESS_ADD))
			return new Zikula_Response_Ajax(LogUtil::registerPermissionError());
		$id = FormUtil::getPassedValue('id', null, 'POST');
		if(!$id)
			$text = ($this->__("There is no valid id!"));
		if($id){
			$devision = $this->entityManager->find('Miniplan_Entity_Plan', $id);
			$this->entityManager->remove($devision);
			$this->entityManager->flush();
			return 0;
		}
		return 1;
	}
	
	public function miniDivision(){
		if (!SecurityUtil::checkPermission('Miniplan::', '::', ACCESS_ADD))
			return new Zikula_Response_Ajax(LogUtil::registerPermissionError());
		$id = FormUtil::getPassedValue('id', null, 'POST');
		$mid = FormUtil::getPassedValue('mid', null, 'POST');
		$wid = FormUtil::getPassedValue('wid', null, 'POST');
		
		if(!$mid)
			$text = ($this->__("There is no valid mid!"));
		if(!$wid)
			$text = ($this->__("There is no valid wid!"));
		
		if($mid&&$wid){
			$mymini = $this->entityManager->find('Miniplan_Entity_User', $mid);
			$myCalendar = $mymini->getMy_calendar();
			//mini kann nicht
			if($myCalendar[$wid] == 1)
				return new Zikula_Response_Ajax(array('name' => $devision->getNicname(), "id" => $devision->getId(), "error" => 1));
			$devision;
			if($id){
				$devision = $this->entityManager->find('Miniplan_Entity_Plan', $id);
			}
			else{
				$devision = new Miniplan_Entity_Plan();
			}
			$devision->setMid($mid);
			$devision->setWid($wid);
			$this->entityManager->persist($devision);
			$this->entityManager->flush();
			return new Zikula_Response_Ajax(array('name' => $devision->getNicname(), "id" => $devision->getId(), "error" => 0, "pid" => $devision->getPid(), "mid" => $devision->getMid(), "ppriority" => $devision->getPpriority(), "pnic"=>$devision->getPnic(), "cid"=>$devision->getCid()));
		}
		return new Zikula_Response_Ajax(array('name' => $devision->getNicname(), "id" => $devision->getId(), "error" => 1));
	}
	
	public function AllDivision_Del(){
		if (!SecurityUtil::checkPermission('Miniplan::', '::', ACCESS_ADD))
			return new Zikula_Response_Ajax(LogUtil::registerPermissionError());
		$minis = $this->entityManager->getRepository('Miniplan_Entity_Plan')->findBy(array());
		
		$result = array();
		
		foreach($minis as $item){
			$tmp = array();
			$id = $item->getId();
			$devision = $this->entityManager->find('Miniplan_Entity_Plan', $id);
			$tmp['wid'] = $devision->getWid();
			$tmp['cid'] = $devision->getCid();
			$this->entityManager->remove($devision);
			$this->entityManager->flush();
			
			$newWid = true;
			foreach($result as $mytmp){
				if($mytmp['wid'] == $tmp['wid']){
					$newWid = false;
					break;
				}
			}
			
			if($newWid){
				$result[] = $tmp;
			}
		}
		return new Zikula_Response_Ajax($result);
	}
}
