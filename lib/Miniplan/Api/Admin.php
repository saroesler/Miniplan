<?php
/**
 * This is the User controller class providing navigation and interaction functionality.
 */
class Miniplan_Api_Admin extends Zikula_AbstractApi
{
	/**
	 * @brief Get available admin panel links
	 *
	 * @return array array of admin links
	 */
	public function getlinks()
	{
		$links = array();
		if (SecurityUtil::checkPermission('Miniplan::', '::', ACCESS_ADMIN)) 
		{
			$links[] = array(
				'url'=> ModUtil::url('Miniplan', 'admin', 'main'),
				'text'  => $this->__('Main'),
				'title' => $this->__('Main'),
				'class' => 'z-icon-es-config',
			);
		
			
			$links[] = array(
				'url'=> ModUtil::url('Miniplan', 'admin', 'group'),
				'text'  => $this->__('Group'),
				'title' => $this->__('Show the Acolytes group.'),
				'class' => 'z-icon-es-user',
			);
			
			 $pending = ModUtil::apiFunc($this->name, 'Admin', 'countPending');
            if ($pending) {
                $links[] = array(
                'url' => ModUtil::url($this->name, 'admin', 'Requests'), 
                'text' => $this->__('Requests') . ' ('.DataUtil::formatForDisplay($pending).')', 
                'title' => $this->__('Show requests for the Acolytes group.'),
				'class' => 'user-icon-adduser',
				);
            }
			
			$links[] = array(
				'url'=> ModUtil::url('Miniplan', 'admin', 'church'),
				'text'  => $this->__('Churches'),
				'title' => $this->__('Show the Churches.'),
				'class' => 'z-icon-es-display',
			);
			
			$links[] = array(
				'url'=> ModUtil::url('Miniplan', 'admin', 'form'),
				'text'  => $this->__('Forms'),
				'title' => $this->__('Show the Forms.'),
				'class' => 'z-icon-es-display',
			);
			
			$links[] = array(
				'url'=> ModUtil::url('Miniplan', 'admin', 'calendar'),
				'text'  => $this->__('Calendar'),
				'title' => $this->__('Show the Calendar.'),
				'class' => 'z-icon-es-display',
			);
			
			$links[] = array(
				'url'=> ModUtil::url('Miniplan', 'admin', 'passed_Dates'),
				'text'  => $this->__('Passed Date'),
				'title' => $this->__('See the Dates, the Ministrants pass.'),
				'class' => 'z-icon-es-display',
			);
			
			$links[] = array(
				'url'=> ModUtil::url('Miniplan', 'admin', 'createdPlan'),
				'text'  => $this->__('Created Plan'),
				'title' => $this->__('See the created Plan.'),
				'class' => 'z-icon-es-display',
			);
			
			$links[] = array(
				'url'=> ModUtil::url('Miniplan', 'admin', 'settings'),
				'text'  => $this->__('Settings'),
				'title' => $this->__('Configure the module.'),
				'class' => 'z-icon-es-config',
			);
		
		}
		
		if (SecurityUtil::checkPermission('Miniplan::', '::', ACCESS_MODERATE))
		$links[] = array(
				'url'=> ModUtil::url('Miniplan', 'admin', 'my_calendar'),
				'text'  => $this->__('My Data'),
				'title' => $this->__('sign in for worships'),
				'class' => 'z-icon-es-display',
			);
		if (SecurityUtil::checkPermission('Miniplan::', '::', ACCESS_MODERATE))
		$links[] = array(
				'url'=> ModUtil::url('Miniplan', 'admin', 'address'),
				'text'  => $this->__('Address'),
				'title' => $this->__('get the address list'),
				'class' => 'z-icon-es-display',
			);
		return $links;
	}
	
	public function countPending()
	{
		$users = UserUtil::getUsers();
		$counter = 0;
		foreach($users as $user)
		{
			if(isset ($user['__ATTRIBUTES__'][ministrant]))
				if($user['__ATTRIBUTES__'][ministrant]
					&& (
						$user['__ATTRIBUTES__'][ministrant_state] == "" 
						||$user['__ATTRIBUTES__'][ministrant_state] == "0"))
					$counter++;
		}
		return $counter;
	}
	
	public function getChurchSelectorForm($args)
	{
		$churches = $this->entityManager->getRepository('Miniplan_Entity_Church')->findBy(array());
		
		$list = array();
		foreach($churches as $church)
		{
			$list[] = array(
			'text' => $church->getName(),
			'value' => $church->getCid(),
			);
		}
		return $list;
	}
	
	public function getChurchSelector($args)
	{
		$churches = $this->entityManager->getRepository('Miniplan_Entity_Church')->findBy(array());
		
		$list = "<select name=\"{$args['name']}\">";
		
		foreach($churches as $church)
		{
			if($args['selected']==$church->getCid())
				$list .="<option selected value=\"{$church->getCid()}\"> {$church->getName()} </option>";
			else
				$list .="<option value=\"{$church->getCid()}\"> {$church->getName()} </option>";
		}
		$list .="</select>";
		return $list;
	}
	
	public function getPartnerSelector($args)
	{
		$minis = $this->entityManager->getRepository('Miniplan_Entity_User')->findBy(array());
		
		$list = "<select name=\"{$args['name']}\" id=\"{$args['name']}\"";
		if($args['onchange'])
			$list .= "onchange=\"" . $args['onchange'] . "\" >";
		else
			$list .= ">";
		$list .="<option selected value=\"0\"> keiner </option>";
		foreach($minis as $mini)
		{
			//cant be a partner with himself
			if($args['myid']!=$mini->getUid())
			{
				$user = UserUtil::getPNUser($mini->getUid());
				if($args['selected']==$mini->getMid())
					$list .="<option selected value=\"{$mini->getMid()}\">".$mini->getNicname()."</option>";
				else
					$list .="<option value=\"{$mini->getMid()}\">".$mini->getNicname()."</option>";
			}
		}
		$list .="</select>";
		return $list;
	}
	
	public function getChurchNameById($args)
	{
		$church = $this->entityManager->find('Miniplan_Entity_Church', $args['id']);
		return $church->getName();
	}
	
	public function getChurchNicById($args)
	{
		$church = $this->entityManager->find('Miniplan_Entity_Church', $args['id']);
		return $church->getShortName();
	}
	
	public function getNicById($args)
	{
		if($args['id'])
		{
			$mini = $this->entityManager->find('Miniplan_Entity_User', $args['id']);
			return $mini->getNicname();
		}
		else
			return "";
	}
	
	public function getPidById($args)
	{
		if($args['id'])
		{
			$mini = $this->entityManager->find('Miniplan_Entity_User', $args['id']);
			return $mini->getPid();
		}
		else
			return "";
	}
	
	public function getPpriorityById($args)
	{
		if($args['id'])
		{
			$mini = $this->entityManager->find('Miniplan_Entity_User', $args['id']);
			return $mini->getPpriority();
		}
		else
			return "";
	}
	
	public function getCidByWid($args)
	{
		if($args['id'])
		{
			$worship = $this->entityManager->find('Miniplan_Entity_Worship', $args['id']);
			return $worship->getCid();
		}
		else
			return "";
	}
	
	public function getMinistateSelector($args)
	{
		$list = "<select id=\"{$args['name']}\" name=\"{$args['name']}\" onChange=\"changeworships('{$args['mytype']}','{$args['name']}','{$args['myname']}')\">";
		
			if($args['selected']==1)
				$list .="<option selected value=\"1\">einteilen</option>";
			else
				$list .="<option value=\"1\">einteilen</option>";
			
			if($args['selected']==2)
				$list .="<option selected value=\"2\">nicht einteilen</option>";
			else
				$list .="<option value=\"2\">nicht einteilen</option>";
			
			if($args['selected']==3)
				$list .="<option selected value=\"3\">gerne einteilen</option>";
			else
				$list .="<option value=\"3\">gerne einteilen</option>";
		$list .="</select>";
		return $list;
	}
	
	public function getFormSelectorForm($args)
	{
		$forms = $this->entityManager->getRepository('Miniplan_Entity_WorshipForm')->findBy(array());
		
		$list = array();
		$list[] = array(
			'text' => ($this->__("No form selected")),
			'value' => 0,
			);
			
		foreach($forms as $form)
		{
			$list[] = array(
			'text' => $form->getName(),
			'value' => $form->getWfid(),
			);
		}
		return $list;
	}
	
	public function getFormSelector($args)
	{
		$forms = $this->entityManager->getRepository('Miniplan_Entity_WorshipForm')->findBy(array());
		
		$list = "<select name=\"{$args['name']}\" id=\"{$args['name']}\" onchange=\"WorshipForm_load(document.getElementById('{$args['name']}').value)\">";
		$list .="<option value=\"0\">".($this->__("No form selected"))."</option>";
		
		foreach($forms as $form)
		{
			$list .="<option value=\"{$form->getWFid()}\"> {$form->getName()} </option>";
		}
		$list .="</select>";
		return $list;
	}
	
	public function getFormNameById($args)
	{
		$form = $this->entityManager->find('Miniplan_Entity_WorshipForm', $args['id']);
		return $form->getName();
	}
}
