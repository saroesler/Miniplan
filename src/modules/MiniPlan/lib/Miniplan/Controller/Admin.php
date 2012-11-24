<?php

/**
 * This is the admin controller class providing navigation and interaction functionality.
 */
class MiniPlan_Controller_Admin extends Zikula_AbstractController
{
    /**
     * @brief Main function.
     * @throws Zikula_Forbidden If not ACCESS_ADMIN
     * @return string
     * 
     * @author Christian Flach
     */
    public function main()
    {
    	$this->throwForbiddenUnless(SecurityUtil::checkPermission('MiniPlan::', '::', ACCESS_ADMIN));
    	
        return $this->view->fetch('Admin/Main.tpl');
    }
}