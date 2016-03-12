<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Ministrants entity class.
 *
 * Annotations define the entity mappings to database.
 *
 * @ORM\Entity
 * @ORM\Table(name="Miniplan_Worship")
 */
class Miniplan_Entity_Worship extends Zikula_EntityAccess
{

    /**
     * The following are annotations which define the id field.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $wid;
	
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
    
    /**
     * The following are annotations which define the wdate field.
     *
     * @ORM\Column(type="date")
     */
    private $date;
    
    public function getWid()
    {
        return $this->wid;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getCid()
    {
        return $this->cid;
    }

    public function getCname()
    {
    	return ModUtil::apiFunc('Miniplan', 'Admin', 'getChurchNameById', array('id' => $this->cid));
    }
    
     public function getCnic()
    {
    	return ModUtil::apiFunc('Miniplan', 'Admin', 'getChurchNicById', array('id' => $this->cid));
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
    
    public function getDate()
    {
    	return $this->date;
    }
    
    public function getDay(){
		return $this->date->format('l');
	}
    
    public function getDateFormatted()
    {
        return $this->date->format('d.m.y');
    }
    
    public function getDateFormattedout()
    {
    	$trans = array(
			'Monday'    => 'Montag',
			'Tuesday'   => 'Dienstag',
			'Wednesday' => 'Mittwoch',
			'Thursday'  => 'Donnerstag',
			'Friday'    => 'Freitag',
			'Saturday'  => 'Samstag',
			'Sunday'    => 'Sonntag',
			'Mon'       => 'Mo',
			'Tue'       => 'Di',
			'Wed'       => 'Mi',
			'Thu'       => 'Do',
			'Fri'       => 'Fr',
			'Sat'       => 'Sa',
			'Sun'       => 'So',
			'January'   => 'Januar',
			'February'  => 'Februar',
			'March'     => 'März',
			'May'       => 'Mai',
			'June'      => 'Juni',
			'July'      => 'Juli',
			'October'   => 'Oktober',
			'December'  => 'Dezember',
		);
		$date = $this->date->format('D, d.m.y');
		$date = strtr($date, $trans);  
        return $date;
    }
    
    public function getDateClass()
    {
		$date = $this->date->format('l');
        return $date;
    }
    
    public function setDate($date)
    {
    	$this->date = new \Datetime($date);
    }
}
