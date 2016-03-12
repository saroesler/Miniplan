<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Ministrants entity class.
 *
 * Annotations define the entity mappings to database.
 *
 * @ORM\Entity
 * @ORM\Table(name="Miniplan_WorshipForm")
 */
class Miniplan_Entity_WorshipForm extends Zikula_EntityAccess
{

    /**
     * The following are annotations which define the id field.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $wfid;

    /**
     * The following are annotations which define the WorshipForm id field.
     *
     * @ORM\Column(type="string",  length="100")
     */
    private $name;
    
     /**
     * The following are annotations which define the my_calendar field.
     *
     * @ORM\Column(type="integer")
     */
    private $cid;
    
    /**
     * The following are annotations which define the churches field.
     *
     * @ORM\Column(type="integer")
     */
    private $minis_requested;
    
     /**
     * The following are annotations which define the days field.
     *
     * @ORM\Column(type="time")
     */
    private $time;
    
     /**
     * The following are annotations which define the field for additional informations.
     *
     * @ORM\Column(type="string",  length="100")
     */
    private $info;
    
    public function getWfid()
    {
        return $this->wfid;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getCname()
    {
    	return ModUtil::apiFunc('Miniplan', 'Admin', 'getChurchNameById', array('id' => $this->cid));
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getCid()
    {
        return $this->cid;
    }

    public function setCid($cid)
    {
        $this->cid = $cid;
    }
        
    public function getTime()
    {
    	return $this->time;
    }
    
    public function setTime($time)
    {
    	$this->time = new \DateTime($time);
    }
    
    public function getTimeFormatted()
    {
        return $this->time->format('G:i');
    }
    
    public function getMinis_requested()
    {
    	return $this->minis_requested;
    }
    
    public function setMinis_requested($minis_requested)
    {
    	$this->minis_requested = $minis_requested;
    }
        
    public function getInfo()
    {
    	return $this->info;
    }
    
    public function setInfo($info)
    {
    	$this->info = $info;
    }
}
