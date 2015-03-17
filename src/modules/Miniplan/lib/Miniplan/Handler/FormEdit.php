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
 * form handler for create and edit.
 */
class Miniplan_Handler_FormEdit extends Zikula_Form_AbstractHandler
{

    private $actionid;

    
    /**
     * Setup form.
     *
     * @param Zikula_form_View $view Current Zikula_form_View instance.
     
     *
     * @return boolean
     */
    public function initialize(Zikula_form_View $view)
    {
        $actionid = formUtil::getPassedValue('id',null,'GET');
        if ($actionid) {
            // load user with id
            $form = $this->entityManager->find('Miniplan_Entity_WorshipForm', $actionid);
			$cids = ModUtil::apiFunc('Miniplan', 'admin', 'getChurchSelectorForm');
            if (!$form) 
            {
                return LogUtil::registerError($this->__f('form with id %s not found', $actionid));
            }
            $view->assign('myform',$form);
            $view->assign('cids',$cids);
        } else {
            echo 'No ID';
        }
    }

    /**
     * Handle form submission.
     *
     * @param Zikula_form_View $view  Current Zikula_form_View instance.
     * @param array            &$args Args.
     *
     * @return boolean
     */
    public function handleCommand(Zikula_form_View $view, &$args)
    {
          $url = ModUtil::url('Miniplan', 'admin', 'form' );
        if ($args['commandName'] == 'cancel') {
            return $view->redirect($url);
        }
		$actionid = FormUtil::getPassedValue('id',null,'GET');

        // check for valid form
        if (!$view->isValid()) {
            return false;
        }
        // load form values
        $data = $view->getValues();
        // merge user and save everything
        $form = $this->entityManager->find('Miniplan_Entity_WorshipForm', $actionid);
        $form->merge($data);
       // $this->page->setedit_comment($uid);
        $this->entityManager->persist($form);
        $this->entityManager->flush();

        return $view->redirect($url);
    }
}
