<?php
/**
 * Version.
 */
class MiniPlan_Version extends Zikula_AbstractVersion
{
    /**
     * Module meta data.
     *
     * @return array Module metadata.
     */
    public function getMetaData()
    {
        $meta = array();
        $meta['displayname']    = $this->__('MiniPlan');
        $meta['description']    = $this->__("MiniPlan"); ///@todo description
        $meta['url']            = $this->__('miniplan');
        $meta['version']        = '0.0.1';
        $meta['official']       = 0;
        $meta['author']         = 'Christian Flach';
        $meta['contact']        = 'cmfcmf.flach@gmail.com';
        $meta['admin']          = 1;
        $meta['user']           = 1;
        $meta['securityschema'] = array(); ///@todo Security schema
        $meta['core_min'] = '1.3.0';
        $meta['core_max'] = '1.3.99';
        
        return $meta;
    }
}