<?php
/**
 * Copyright Zikula Foundation 2010 - Zikula Application Framework
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license MIT
 * @package ZikulaExamples_ExampleDoctrine
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

/**
 * Form handler for create and edit.
 */
class Miniplan_Handler_NewWorship extends Zikula_Form_AbstractHandler
{

    private $actionid;

    
    /**
     * Setup form.
     *
     * @param Zikula_Form_View $view Current Zikula_Form_View instance.
     
     *
     * @return boolean
     */
    public function initialize(Zikula_Form_View $view)
    {
			$cids = ModUtil::apiFunc('Miniplan', 'admin', 'getChurchSelectorForm');
			$forms = ModUtil::apiFunc('Miniplan', 'admin', 'getFormSelectorForm');
             $view->assign('cids',$cids);
             $view->assign('forms',$forms);
    }

    /**
     * Handle form submission.
     *
     * @param Zikula_Form_View $view  Current Zikula_Form_View instance.
     * @param array            &$args Args.
     *
     * @return boolean
     */
    public function handleCommand(Zikula_Form_View $view, &$args)
    {
        $url = ModUtil::url('Miniplan', 'admin', 'calendar' );
        if ($args['commandName'] == 'cancel') {
            return $view->redirect($url);
        }


        // check for valid form
        if (!$view->isValid()) {
            return false;
        }
        
        // load form values
        $data = $view->getValues();
		print_r($data);
		$date_num = FormUtil::getPassedValue('indate_num',null,'POST');
		for($i = 0;$i<=$date_num;$i++)
		{
			$date = FormUtil::getPassedValue('indate'.$i,null,'POST');
			if($date!="")
			{
				$worship = new Miniplan_Entity_Worship();
				$worship->setCid($data['cid']);
				$worship->setTime($data['time']);
				$worship->setMinis_requested($data['Minis_requested']);
				$worship->setInfo($data['info']);
				$worship->setDate($date);
				$this->entityManager->persist($worship);
				$this->entityManager->flush();
				$Wid = $worship->getWid();
				
				$users = $this->entityManager->getRepository('Miniplan_Entity_User')->findBy(array());
				$cid=$data['cid'];
				foreach($users as $user)
				{
					$userstate = 0;
					if($user->getInactive() == 2)
						$userstate = 1;
					
					$churches = $user->getChurches();
					if(($churches[$cid] == 2)||($churches[$cid] == 3))
						$userstate = $churches[$cid]-1;
					
					$userdate=$date;
					$userdate = date_format($date, 'l');
					$days = $user->getDays();
					if((($days[$userdate] == 2)||($days[$userdate] == 3))&&($churches[$cid] != 2))
						$userstate = $days[$userdate]-1;
					$my_calendar = $user->getMy_calendar();
					$my_calendar[$Wid] = $userstate;
					$user->setMy_calendar($my_calendar);
					//lösche Häkchen
					$user->setEdited(0);
					$this->entityManager->persist($user);
					$this->entityManager->flush();
				}
				LogUtil::RegisterStatus($this->__("Worship has been added successfully."));
			}
		}
        return $view->redirect($url);
    }
}
