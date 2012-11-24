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
class MiniPlan_Entity_Ministrants extends Zikula_EntityAccess
{

    /**
     * The following are annotations which define the id field.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $uid;


    /**
     * The following are annotations which define the birthday field.
     *
     * @ORM\Column(type="datetime")
     */
    private $birthday;


    public function getUid()
    {
        return $this->uid;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setBirthday($birthday)
    {
        $this->birthday = new DateTime($birthday);
    }
}