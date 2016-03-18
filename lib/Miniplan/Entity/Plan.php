<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Ministrants entity class.
 *
 * Annotations define the entity mappings to database.
 *
 * @ORM\Entity
 * @ORM\Table(name="Miniplan_Plan")
 */
class Miniplan_Entity_Plan extends Zikula_EntityAccess
{

    /**
     * The following are annotations which define the id field.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The following are annotations which define the user id field.
     *
     * @ORM\Column(type="integer")
     */
    private $wid;
    
    /**
     * The following are annotations which define the inactive field.
     *
     * @ORM\Column(type="integer")
     */
    private $mid;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getWid()
    {
        return $this->wid;
    }
    
    public function setWid($wid)
    {
        $this->wid = $wid;
    }
    
    public function getMid()
    {
        return $this->mid;
    }
    
    public function getNicname()
    {
        return ModUtil::apiFunc('Miniplan', 'Admin', 'getNicById', array('id' => $this->mid));
    }
    
    public function getPid()
    {
        return ModUtil::apiFunc('Miniplan', 'Admin', 'getPidById', array('id' => $this->mid));
    }
    
    public function getPpriority()
    {
        return ModUtil::apiFunc('Miniplan', 'Admin', 'getPpriorityById', array('id' => $this->mid));
    }
    
    public function getPnic()
    {
    	return ModUtil::apiFunc('Miniplan', 'Admin', 'getNicById', array('id' => $this->getPid()));
    }
    
    public function getCid()
    {
        return ModUtil::apiFunc('Miniplan', 'Admin', 'getCidByWid', array('id' => $this->wid));
    }
    
    public function setMid($mid)
    {
        $this->mid = $mid;
    }
}
