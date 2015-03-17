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
class Miniplan_Handler_WorshipEdit extends Zikula_Form_AbstractHandler
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
        $actionid = FormUtil::getPassedValue('id',null,'GET');
        if ($actionid) {
            // load user with id
            $worship = $this->entityManager->find('Miniplan_Entity_Worship', $actionid);
			$cids = ModUtil::apiFunc('Miniplan', 'admin', 'getChurchSelectorForm');
            if (!$worship) 
            {
                return LogUtil::registerError($this->__f('Worship with id %s not found', $actionid));
            }
            $view->assign('worship',$worship);
             $view->assign('cids',$cids);
        } else {
            echo 'No ID';
        }
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
        
        $actionid = FormUtil::getPassedValue('id',null,'GET');
        // load form values
        $data = $view->getValues();
		print_r($data);
        // merge user and save everything
        $worship = $this->entityManager->find('Miniplan_Entity_Worship', $actionid);
        $worship->merge($data);
       // $this->page->setedit_comment($uid);
        $this->entityManager->persist($worship);
        $this->entityManager->flush();

        return $view->redirect($url);
    }
}
