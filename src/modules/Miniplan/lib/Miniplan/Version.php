<?php
/**
 * Version.
 */
class Miniplan_Version extends Zikula_AbstractVersion
{
    /**
     * Module meta data.
     *
     * @return array Module metadata.
     */
    public function getMetaData()
    {
        $meta = array();
        $meta['displayname']    = $this->__('Miniplan');
        $meta['description']    = $this->__("Zikula Module creating Ministrantenplans"); ///@todo description
        $meta['url']            = $this->__('Miniplan');
        $meta['version']        = '1.0.0';
        $meta['official']       = 0;
        $meta['author']         = 'Sascha Rösler';
        $meta['contact']        = 'sa-roesler@t-online.de';
        $meta['admin']          = 1;
        $meta['user']           = 1;
        $meta['securityschema'] = array(); ///@todo Security schema
        $meta['core_min'] = '1.3.0';
        $meta['core_max'] = '1.3.99';
        $meta['capabilities'] = array();
        $meta['capabilities'][HookUtil::SUBSCRIBER_CAPABLE] = array('enabled' => true);
        
        return $meta;
    }

 	/**
     * Set up hook subscriber and provider bundles 
     */
}
