<?php

/**
 * This is the admin controller class providing navigation and interaction functionality.
 */
class MiniPlan_Controller_Admin extends Zikula_AbstractController
{
    /**
     * @brief Main function.
     * @throws Zikula_Forbidden If not ACCESS_ADMIN
     * @return template Admin/Main.tpl
     * 
     * @author Christian Flach
     */
    public function main()
    {
    	$this->throwForbiddenUnless(SecurityUtil::checkPermission('MiniPlan::', '::', ACCESS_ADMIN));
    	
        return $this->view->fetch('Admin/Main.tpl');
    }
    
    /**
     * @brief Churches view function.
     * @throws Zikula_Forbidden If not ACCESS_MODERATE
     * @return template Admin/ChurchesView.tpl
     *
     * @author Christian Flach
     */
    public function ChurchesView()
    {
    	$this->throwForbiddenUnless(SecurityUtil::checkPermission('MiniPlan::', '::', ACCESS_MODERATE));
    	
    	$churches = $this->entityManager->getRepository('MiniPlan_Entity_Churches')->findBy(array());
    	
    	return $this->view
    		->assign('churches', $churches)
    		->fetch('Admin/ChurchesView.tpl');
    }
}