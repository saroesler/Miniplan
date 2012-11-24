<?php
/**
 * This is the User controller class providing navigation and interaction functionality.
 */
class MiniPlan_Api_Admin extends Zikula_AbstractApi
{
	/**
	 * @brief Get available admin panel links
	 *
	 * @return array array of admin links
	 */
	public function getlinks()
	{
		$links = array();
		if (SecurityUtil::checkPermission('MiniPlan::', '::', ACCESS_ADMIN)) {
			$links[] = array(
				'url'=> ModUtil::url('MiniPlan', 'admin', 'main'),
				'text'  => $this->__('Main'),
				'title' => $this->__('Main'),
				'class' => 'z-icon-es-config',
			);
		}
		
		if (SecurityUtil::checkPermission('MiniPlan::', '::', ACCESS_MODERATE)) {
			$links[] = array(
				'url'=> ModUtil::url('MiniPlan', 'admin', 'ChurchesView'),
				'text'  => $this->__('Churches'),
				'title' => $this->__('Churches'),
				'class' => 'z-icon-es-display',
			);
		}
		return $links;
	}
}