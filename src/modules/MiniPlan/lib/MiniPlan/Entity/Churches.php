<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Ministrants entity class.
 *
 * Annotations define the entity mappings to database.
 *
 * @ORM\Entity
 * @ORM\Table(name="MiniPlan_Ministrants")
 */
class MiniPlan_Entity_Churches extends Zikula_EntityAccess
{

    /**
     * The following are annotations which define the id field.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $cid;


    /**
     * The following are annotations which define the birthday field.
     *
     * @ORM\Column(type="string", length="255")
     */
    private $adress;


    public function getCid()
    {
        return $this->cid;
    }

    public function getAdress()
    {
        return $this->adress;
    }

    public function setAdress($adress)
    {
        $this->adress = $adress;
    }
}