<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Ministrants entity class.
 *
 * Annotations define the entity mappings to database.
 *
 * @ORM\Entity
 * @ORM\Table(name="MiniPlan_Messes")
 */
class MiniPlan_Entity_Messes extends Zikula_EntityAccess
{

    /**
     * The following are annotations which define the id field.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $mid;

    /**
     * The following are annotations which define the cid field.
     *
     * @ORM\Column(type="integer")
     */
    private $cid;
    
    /**
     * The following are annotations which define the ministrantsRequired field.
     *
     * @ORM\Column(type="integer")
     */
    private $ministrantsRequired;


    public function getMid()
    {
        return $this->mid;
    }
    
    public function getCid()
    {
    	return $this->cid;
    }

    public function getMinistrantsRequired()
    {
        return $this->ministrantsRequired;
    }

    public function setCid($cid)
    {
        $this->cid = $cid;
    }
    
    public function setMinistrantsRequired($ministrantsRequired)
    {
    	$this->ministrantsRequired = $ministrantsRequired;
    }
}