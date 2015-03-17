<?php
/**
 * Datasheete.
 *
 * @copyright Sascha Rösler (SR)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @package Miniplan
 * @author Sascha Rösler <i-loko@t-online.de>.
 * @link http://github.com/sarom5
 * @link http://zikula.org
 */

/**
 * Account api class.
 */
class Miniplan_Api_Account extends Zikula_AbstractApi
{
    /**
     * Return an array of items to show in the your account panel.
     *
     * @param array $args List of arguments.
     *
     * @return array List of collected account items
     */
    public function getall(array $args = array())
    {
        // collect items in an array
        $items = array();
        if(SecurityUtil::checkPermission($this->name . '::', '::', ACCESS_ADMIN))
        {
		    // Create an array of links to return
		        $items[] = array(
		            'url'   => ModUtil::url($this->name, 'admin', 'main'),
		            'title' => $this->__('Oberministrant'),
		            'icon'   => 'omi.gif',
		            'module' => 'Miniplan'
		        );
		}
    	
    	//generate array with userindormations
    	$uid = SessionUtil::getVar('uid');
    	$user = UserUtil::getPNUser($uid);
    	if((SecurityUtil::checkPermission('Miniplan' . '::', '::', ACCESS_ADMIN))||($user['__ATTRIBUTES__']['ministrant_state']=="1"))
        {
		    // Create an array of links to return
		        $items[] = array(
		            'url'   => ModUtil::url($this->name, 'admin', 'my_calendar'),
		            'title' => $this->__('Ministrant'),
		            'icon'   => 'minis.png',
		            'module' => 'Miniplan'
		        );
		}
        // return the items
        return $items;
    }
}
