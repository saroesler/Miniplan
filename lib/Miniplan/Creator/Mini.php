<?php

/**
 * This is the admin controller class providing navigation and interaction functionality.
 */
class Miniplan_Creator_Mini //extends Zikula_AbstractController
{
	/**
	 * @brief Main function.
	 * @throws Different views according to the access
	 * @return template Admin/Main.tpl
	 * 
	 * @author Sascha Rösler
	 */
	 
	private $database;
	private $randid;
	private $eingeteilt;
	private $eingeteilt_saturday;
	private $eingeteilt_sunday;
	private $eingeteilt_week;
	private $eingeteilt_kirchen;

	public function __construct ($data, $randid, $churches)
	{
		$this->setObj($data);
		$this->setRandId($randid);
		$this->eingeteilt_saturday = 0;
		$this->eingeteilt_sunday = 0;
		$this->eingeteilt_weekday = 0;
		$this->eingeteilt = 0;

		$this->initialize_churches($churches);
	}

	public function setObj($data)
	{
		$this->database = $data;
	}

	public function setRandId($randid)
	{
		$this->randid = $randid;
	}

	public function saturdayindecrement()
	{
		$this->eingeteilt_saturday++;
	}

	public function eingeteiltindecrement()
	{
		$this->eingeteilt++;
	}

	public function sundayindecrement()
	{
		$this->eingeteilt_sunday++;
	}

	public function weekdayindecrement()
	{
		$this->eingeteilt_week++;
	}

	public function churchindecrement($cid)
	{
		$this->eingeteilt_kirchen[$cid]++;
	}
	
	public function initialize_churches($churches)
	{
		$this->eingeteilt_kirchen = array();
		foreach($churches as $church)
		{
			$this->eingeteilt_kirchen[$church->getCid()] = 0;
		}
	}

	public function eingeteilt()
	{
		return $this->eingeteilt;
	}

	public function eingeteilt_week()
	{
		return $this->eingeteilt_week;
	}

	public function eingeteilt_sun()
	{
		return $this->eingeteilt_sunday;
	}

	public function eingeteilt_sat()
	{
		return $this->eingeteilt_saturday;
	}

	public function eingeteiltChurch($cid)
	{
		return $this->eingeteilt_kirchen[$cid];
	}
	
	public function calendar($wid)
	{
		$temp = $this->database->getMy_calendar();
		return $temp[$wid];
	}

	public function getRand()
	{
		return $this->randid;
	}

	public function getPid()
	{
		return $this->database->getPid();
	}
	
	public function getMid()
	{
		return $this->database->getMid();
	}
	
	public function getEinteilungsIndex()
	{
		return $this->database->getEinteilungsIndex();
	}

	public function getPartnername()
	{
		return UserUtil::getPNUser($this->database->getPid() );
	}

	public function getPpriority()
	{
		return $this->database->getPpriority();
	}
	
	public function getUid()
	{
		return $this->database->getUid();
	}

	public function getUsername()
	{
		return $this->database->getNicname();
	}
	
	public function abstand($plan, $wid, $logManager){
		$my_worship_index = $wid;
		$worship = $plan[$my_worship_index];
		$worship_index = $wid;
		
		//integer in seconds
		//look, if not divided at the last 4 days (345600 sec) or 4 worships
		while((($worship->getDate()-345600)<= $plan[$my_worship_index]->getDate() )||(($worship_index-$my_worship_index)<4))
		{
			$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),"  Prüfe auf alten Gottesdienst ".$plan[$my_worship_index]->getId());
			/*for($i=0; $i<worship->getMinisRequested();$i++)
			{
				if($worship->getMini($i) == $this->database->getMid())
				{
					$mini_ok = 0;
					$logManager.= "  ".$this->database->getMid()."in".$my_worship_index."eingeteilt   \n";
					$logManager.= "zu nahe eingeteilt\n";
				}
			}
			*/
			if(($plan[$my_worship_index]->hasMini($this->database->getMid())))
			{
				$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),"zu nahe eingeteilt!");
				return 0;
			}
			else if($my_worship_index > 0)
				$my_worship_index--;
			else
				break;
		}
		
		return 1;
	
	}

	/**
	* look, if mini can here
	* args:
	* mid: id of mini
	* windex: worship index
	* plan = ausgabearray
	*
	* Rückgabewerte:
	* 	0: Mini kann nicht
	*	1: Mini kann
	* 	2: Mini kann nicht
	**/
	public function test_mini($args)
	{
		//look, if mini have time
		$mini_ok = 1;
		$my_worship_index = $args["windex"];
		$logManager = $args["log"];
		$plan = $args["plan"];
		$worship = $plan[$my_worship_index];

		$my_calendar = $this->database->getMy_calendar();
		if($my_calendar[$worship->getId()] == 1 && $my_calendar[$worship->getId()] != "")
		{
			$mini_ok = 0;
			$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),"kann nicht!".$my_calendar[$worship->getId()]);
			return $mini_ok;
		}
		
		if(!$this->abstand($plan, $my_worship_index, $logManager))
			return 0;
		
		//if devided into the temp array
		if( $worship->miniIsInTemp($this->database->getMid()) )
		{
			$mini_ok = 2;
			$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),"schon im Temp!");
			return $mini_ok;
		}
		
		
		//if closed for this worship
		if( $worship->miniIsClosed($this->database->getMid()) )
		{
			$mini_ok = 0;
			$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),"schon für diesen Gottesdienst gesperrt");
		}
		else
			$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),$this->database->getMid()." Nicht Gesperrt");
		return $mini_ok;
	}
}
