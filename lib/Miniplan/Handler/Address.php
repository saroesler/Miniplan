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
class Miniplan_Handler_Address extends Zikula_Form_AbstractHandler
{

    private $uid;

    /**
     * Setup form.
     *
     * @param Zikula_Form_View $view Current Zikula_Form_View instance.
     *
     * @return boolean
     */
    public function initialize(Zikula_Form_View $view)
    {
        // Get the id.
        if(SecurityUtil::checkPermission('Miniplan::', '::', ACCESS_COMMENT))
		{
			$uid = FormUtil::getPassedValue('id',null,'GET');
			if(! $uid)
				$uid = SessionUtil::getVar('uid');
		}
		else
			$uid = SessionUtil::getVar('uid');
		$this->uid = $uid;
		$user = UserUtil::getPNUser($uid);
		print_r($user);
		$view->assign('user',$user);
		$view->assign('settings',$this->getVars());


        // assign current values to form fields
        return true;
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
        $url = ModUtil::url('Miniplan', 'admin', 'my_address', array("id"=>$this->uid) );
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
        
        UserUtil::setVar($this->getVar('firstname') ,$data["inFirstName"],$this->uid);
        UserUtil::setVar($this->getVar('surname') ,$data["inName"],$this->uid);
        UserUtil::setVar($this->getVar('address') ,$data["inStreet"],$this->uid);
        UserUtil::setVar($this->getVar('place') ,$data["inTown"],$this->uid);
        UserUtil::setVar($this->getVar('plz') ,$data["inPlz"],$this->uid);
        UserUtil::setVar($this->getVar('birthday') ,$data["inBirthday"],$this->uid);
        UserUtil::setVar($this->getVar('phone') ,$data["inTel"],$this->uid);
        UserUtil::setVar($this->getVar('mobile') ,$data["inHdy"],$this->uid);
        UserUtil::setVar($this->getVar('parentmobile') ,$data["inParentHdy"],$this->uid);
        
        return $view->redirect($url);
    }
}
