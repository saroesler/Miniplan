<?php
/**
 * This is the User controller class providing navigation and interaction functionality.
 */
class Miniplan_Api_Create extends Zikula_AbstractApi
{
	/**
	 * @brief Get available admin panel links
	 *
	 * @return array array of admin links
	 */
	
	public function getRoutineselector($args)
	{
		$list = "<select name=\"Routineselector\" id=\"Routineselector\" onChange=\"Description()\">";
		$list .="<option value=\"0\">".($this->__("No routine selected"))."</option>";
		
		$list .="<option value=\"1\">".($this->__("The Vuong'sche Routine"))."</option>";
		$list .="<option value=\"2\">".($this->__("manually"))."</option>";
		$list .="<option value=\"3\">".($this->__("get odt"))."</option>";
		$list .="<option value=\"4\">".($this->__("get Data"))."</option>";
		$list .= "</select>";
		
		return $list;
	}
	
	public function getRoutinedescription($args)
	{
		$description = array();
		$description[0] = array ( "id" => 0, "text" => $this->__("No routine selected"));
		$description[1] = array ( "id" => 1, "text" =>$this->__("The Vuong- Routine chooses a voluntary acolyte for every worship at first. If there isn't any voluntary acolyte it chooses an other acolyte by a random routine. After chosing an acolyte it tests, if the acolyte is not devided in the last 4 days or the last 4 worships. The random routine selects the acolyte having the lowest unber of devidings. <br/>After that it looks, if there is a prtner. If the partner can't ministrate at this worship, both (partner and acolyte) are removed. If the partner is too for this worship and partner order is longer than two, the partner will be not devided (This works, if the partner state is 'have to', too). otherwise they both won't be devided, too. If there isn't anything of this, the partner will devided. <br/> The routine don't deals with devidings to churches or dates."),
		"subtitle" => $this->__("Please notice"),
		"subtext" => $this->__("Partners who have always ministrate together, both must specify each other. Otherwise it may happen that those one who has stated that he has to ministrate with his partner, is not divided.")."<br />".
		$this->__("Ministrants only having time at the first worships, should be marked as \"voluntary\", otherwise it my happen that he isn't devided.")
		."<img src=\"modules/Miniplan/images/Vuong.svg\" />"
		);
		$description[2] = array ( "id" => 2, "text" => $this->__("Get the page to create the plan by yourself"));
		$description[3] = array ( "id" => 3, "text" => $this->__("Get the created plan as odt- file."));
		$description[3] = array ( "id" => 4, "text" => $this->__("Get the data as a Exel- output to create a plan manuelly."));
		return $description;
	}
	
	/**
	* Vuong routine
	**/
	
	
	public function Vuong()
	{
		$logManager = new Miniplan_Creator_Log('w', str_pad(__LINE__, 3, 0, STR_PAD_LEFT));
		SessionUtil::delVar("Generated_Miniplan");
		
		$error_warnings = "";
		
		/*******************
		* Hole Daten aus Datenbank und validiere diese
		********************/
		
		$worships = $this->entityManager->getRepository('Miniplan_Entity_Worship')->findBy(array(),array('date'=>'ASC','time'=>'ASC'));
		$churches = $this->entityManager->getRepository('Miniplan_Entity_Church')->findBy(array(),array('cid'=>'ASC'));
		$minis = $this->entityManager->getRepository('Miniplan_Entity_User')->findBy(array(),array('mid'=>'ASC'));
		
		
		if(!count($minis))
		{
			$logManager->add( ( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),  "Keine Ministranten!!!");
			$logManager->close( ( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)));
			$error_warnings .= "Keine Ministranten eingetragen!\n";
		}
		
		if(!count($churches))
		{
			$logManager->add( ( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),  "Keine Kirchen eingetragen!!!");
			$logManager->close( ( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)));
			$error_warnings .= "Keine Kirchen eingetragen!\n";
		}
		
		if(!count($worships))
		{
			$logManager->add( ( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),  "Keine Gottesdienste eingetragen!!!");
			$logManager->close( ( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)));
			$error_warnings .= "Keine Gottesdienste eingetragen!!!\n";
		}
		
		//Wenn ein Fehler bisher vorlag
		if($error_warnings != "")
		{
			$MiniplanData = array(
				"success" => false,
				"error_warnings" => $error_warnings//all error and warnings
			);

			$logManager->printLogHeader();
			$logManager->printLogError($error_warnings);
			$logManager->printLogProzess();
			$logManager->printChurches($churches);
			$logManager->printWorships($worships);
			$logManager->printMinisArray($minis_array);
			$logManager->printMixedMinis($minis_rand_array);

			return $MiniplanData;
		}
		
		/**
		* General calculating:
		*	all requested
		*	max requested minis
		*	number of worships
		**/

		$statistik = new Miniplan_Creator_Statistik($worships, $minis, $churches);
		$logManager->add( ( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),  "Ministrantenanzahl: ".$statistik->getNumberMinis());
		/**
		* Create Planarray
		**/
		$plan = array();
		foreach ($worships as $worship)
		{
			$plan[] = new Miniplan_Creator_Gottesdienst($worship, $logManager);
		} 

		$logManager->add(( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),  "Initialisieren beendet");
		
		/*Mix Minis*/
		//mixed- array with counter for days and churches
		$minis_array = array();
		//array with mixed minis
		$minis_rand_array = array();
		$mini_counter = 0;
		foreach ($minis as $mini)
		{
			/*get rand for mini*/
			$myrand = rand(0, ($statistik->getNumberMinis()-1));
			/*if posotion is also given, search next free field*/
			while(array_key_exists($myrand, $minis_rand_array))
				{
					/*reset for overflow*/
					$myrand--;
					if($myrand<0)
						$myrand = $statistik->getNumberMinis()-1;
				}
			$minis_rand_array[$myrand] = $mini->getMid();
			$minis_array[$mini->getMid()] = new Miniplan_Creator_Mini($mini, $myrand, $churches);
		}
		
		$statistik->setMinisObj($minis_array);
		$logManager->add(( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),  "Mixen beendet");
		
		/**
		* End of general calculation
		***/
		$logManager->add(( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),  "Vorbereitung abgeschlossen");		
		/***
		* Begin of deviding into worships
		**/
		
		//index for chosing routine
		$mini_index = 0;
		//do for every worship
		$test=0;
		foreach($plan as $worship_index => $worship)
		{
			$wid = $worship->getId();
			$logManager->add(( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),  "Neuer Gottesdienst wird eingeteilt: Gottesdienst".$wid);		
			//for every ministrant requested
			$logManager->add(( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),  "Suche Ministranten für Gottesdienst".$wid);
			
			$first_item = -1;
			//work while there are not enought minis
			while($worship->needMini() )
			{
				//state for voluntary find
				$voluntary_state = 0;
				//look for minis want voluntary ministrate 
				$my_mini_index = $mini_index;
				$logManager->add(( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),  "Suche ersten Ministranten");
				$logManager->add(( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),  "Startministrant".$mini_index);
				
				$start_mini_index = $mini_index;
				
				//durchsuche alle Minis, und schaue, ob ein Freiwilliger dabei ist
				$logManager->add(( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),  "Suche freiwilligen Mini!");
				$logManager->add(( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),  "Index: Start = ".$my_mini_index." Stop = ".$mini_index);
				while($first_item !=1)
				{
					//look for overflow
					if($my_mini_index == $statistik->getNumberMinis())
						$my_mini_index = 0;
					
					if($my_mini_index==($mini_index))
					{
						$first_item++;
					}
					//look, if mini likes to ministrate at this worship and not to often devided
					$my_mid = $minis_rand_array[$my_mini_index];
					$logManager->add(( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),  " Prüfe neuen Ministranten ".$my_mid." alias ".$my_mini_index."; Index = ".$my_mini_index);
					//if all ok
					//		freiwillig					nicht zu oft eingeteilt
					if(($minis_array[$my_mid]->calendar($wid) == 2)&&($minis_array[$my_mid]->eingeteilt() <= ($statistik->getDurchschnitt()+2))&&$minis_array[$my_mid]-> abstand($plan, $worship_index, $logManager))
					{
						$logManager->add(( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)), "  freiwillig! -> wähle".$my_mid);
						$mini_index = $my_mini_index;
						$voluntary_state = 1;
						break;
					}
					else
						$logManager->add(( str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),"  nicht freieiwillig, oder zu oft eingeteilt");						
					
					$my_mini_index++;
				}
				
				//if no voluntary found, look for next mini
				if(!$voluntary_state)
				{
					$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),"kein Freiwilliger gefunden: ziehen");
					//reset $mini_index to the start value
					$mini_index = $start_mini_index;
					
					/***********************************
					* Ministranten ziehen. $my_reverence als Referenzwert. Die Routine sucht
					* nach Ministranten, die noch nicht so oft eingeteilt wurden.
					***********************************/
					$my_reverence = 0;
					
					while($my_reverence < 1000)
					{
						$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)), "Suche Mini, der noch nicht ".$my_reverence." mal eingeteilt wurde.");
						$my_mini_index = $mini_index+1;
						if($my_mini_index >= ($statistik->getNumberMinis()-1))
								$my_mini_index = 0;
						$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)), "Startindex = ".$my_mini_index);
						//look for minis with the lowest number of dividings
						$first_item = -1;
						//cancel, if no mini found or all minis compare with reference
						while($first_item <=0)
						{
							//Bei Überlauf den lokalen Index zurücksetzen.
							if($my_mini_index >= ($statistik->getNumberMinis()))
								$my_mini_index = 0;
							$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT))," Prüfe Mini ".$minis_array[$minis_rand_array[$my_mini_index]]->getUsername()."; Index = ".$my_mini_index);
							//prüfe, ob eine runde rum
							if($my_mini_index==$mini_index)
							{
								$first_item++;
							}
							
							//prüfe, ob mini so oft eingeteilt wurde, wie die Referenz ist…
							if($minis_array[$minis_rand_array[$my_mini_index]]->eingeteilt() == $my_reverence)
							{
								$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),"  mini".$minis_rand_array[$my_mini_index]." noch nicht so oft eingetielt");
								if($minis_array[$minis_rand_array[$my_mini_index]]->test_mini(array(
									'windex' =>$worship_index,
									'plan'=>$plan,
									'log'=>$logManager
									)))
								//mini kann
								{
									$mini_index = $my_mini_index;
									$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT))," mini ".$minis_rand_array[$my_mini_index]."kann--- Nicname:".$minis_array[$minis_rand_array[$my_mini_index]]->getUsername());
									$my_reverence = 1000;
									//setze first_item auf ok.
									$first_item=-1;
									break;
								}
							}
							$my_mini_index++;
						}//end Mini loop
						$my_reverence++;
					}//end reverence loop
					
					//abbruch, wenn kein Ministrant gefunden werden konnte
					if($first_item == 1)
					{
						$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT))," Es kann kein Ministrant eingeteilt werden!!!\n Break");
						$error_warnings.= "Es kann kein Ministrant eingeteilt werden!!!\n Break\n";
						$logManager->close((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)));
						
						$MiniplanData = array(
							"success" => false,
							"error_warnings" => $error_warnings//all error and warnings
						);
		
						$logManager->printLogHeader();
						$logManager->printLogError($error_warnings);
						$logManager->printLogProzess();
						$logManager->printChurches($churches);
						$logManager->printWorships($worships);
						$logManager->printMinisArray($minis_array);
						$logManager->printMixedMinis($minis_rand_array);
		
						return $MiniplanData;
					}
				}//end if no voluntary mini 
				$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),"mini".$minis_rand_array[$mini_index]." gewählt");
				
				//mini is choosen
				
				/*******************
				* Partner area
				*******************/
				//initialisierung. Sorgt beim erstdurchlauf, ohne das der Mini kann dazu, dass am Ende eine Ordentliche Auswertung stattfindet
				$mypid = 0;
				
				$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),"Suche Partner");
				//while have partner
				do{
					$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT))," prüfe mini".$minis_rand_array[$my_mini_index]);
					$mini_ok = $minis_array[$minis_rand_array[$my_mini_index]]->test_mini(array(
									'windex' =>$worship_index,
									'plan'=>$plan,
									'log'=>$logManager
									));
					
					//exit partnermode if there is a partner to use, the mode is activeted again.
					$partner_active = 0;
					
					
					
					//mini kann eingeteilt werden
					if($mini_ok)
					{
						$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT))," mini ".$minis_rand_array[$my_mini_index]."kann--- Nicname:".$minis_array[$minis_rand_array[$my_mini_index]]->getUsername());
						if($mini_ok==1)
							//mini kann -> vormerken
							$worship->addTempPlanMini( $minis_rand_array[$mini_index], $minis_array[$minis_rand_array[$mini_index]]->getPpriority() );
							$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),"Vormerken von Mini ".$minis_rand_array[$mini_index]);
						
						//look for partner
						$mypid = $minis_array[$minis_rand_array[$mini_index]] -> getPid();
						//mini schon mal einteilt
						if($mini_ok==2 || $worship->miniIsInTemp($mypid))
						{
							//schalte partner aus, dies verhindert eine endlosschleife
							$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT))," Partner Schleife gefunden!");
							$mypid =0;
							$mypprio =0;
						}
						else
						
						
						//hole priorität, wenn es einen partner gibt
						if($mypid)
							$mypprio = $minis_array[$minis_rand_array[$mini_index]]->getPpriority();
						else
							$mypprio = 0;
						
						//need a new mini, if there the temp is added and have partner
						if(($worship->needMiniTemp())&&$mypid)
						{
							//if partner
							//look for mini index for partner
							$mini_index = $minis_array[$mypid]->getRand();
							$my_mini_index = $minis_array[$mypid]->getRand();
							$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT))," Partner kann und hat selber Parnter ".$mypid);
							$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT))," arbeite weiter mit Ministrant".$my_mini_index);
							$partner_active = 1;
						}
						else if($mypid)
							$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),"Kein Platz für einen vorhandenen Partner.");
						else
							$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),"Der Ministrant ".$my_mini_index."hat keinen Partner");
					}//end mini kann
				}while($partner_active);
				//end partnermode
						
				/*******************
				* Nachbearbeitung: Kein Partner vorhanden,
				* oder es gibt kein Platz mehr
				********************/
				
				/********************
				* Falls es einen Partner gibt, so ist interessant,
				* wie er mit dem vorherigen Mini verknüpft ist. 
				* Gibt es keinen partner, so kann direkt eingeteilt
				* werden. Dies erledigt das Ende der Routine. Voher
				* müssen folgende Fälle beachtet werden:
				* - Der Partner kann nicht
				* - Es gibt keinen freien Platz mehr
				* - Es gibt keinen Partner
				* Dies erledigt die Routine in der while- Schleife
				* hierrüber. 
				* Zu beachten sind:
				* - Zwei Ministranten müssen zusammen eingeilt werden
				*		=> Herausnehmen des 1., nicht aufnehmen des 2.
				* - mehr als zwei Minis müssen zusammen eingeteilt werden
				*		=> Einteilen und Ausgabe einer Warnung
				* - kein wichtiger Partner
				* 		=> Einteilen
				*****************************/
				
				if($mypid)		//hat Parnter, muss beachtet werden
				{
					if(!$mini_ok)
						$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),"Der Partner kann nicht!");
				
					/***************************
					* Die wichtig- Partnerlänge ist länger als 1, daher mehrere Ministanten haben
					* sich gegenseitig als wichtiger Partner gewählt. Hierbei wird keine Rücksicht genommen
					***************************/
					if($worship->countPrio() > 1)
					{
						//warnen, dass eingeteilt wurde, obwohl ein wichtiger Partner vorlag
						$error_warnings.="<br/>Warnung: Der Partner ".$minis_array[$mypid]->getUsername().'('.$mypid.')'
						." konnte nicht im Gottesdienst ".$wid.", mit "
						.$minis_array[$minis_rand_array[$mini_index]]->getUsername().'('.$minis_rand_array[$mini_index].') eingeteilt werden';
					
						$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),
							" Warnung: Der Partner ".$minis_array[$mypid]->getUsername().'('.$mypid.')'." konnte nicht im Gottesdienst ".$wid.", mit ".$minis_array[$mypid]->getUsername().'('.$minis_rand_array[$mini_index].') eingeteilt werden'
							);
					}
					
					
					/************************
					* Nur zwei Ministranten haben sich als wichtige Partner. Hierbei wird der Vorgänger
					* von dem Partner herausgenommen und der Partner, der nicht kann wird garnicht erst
					* eingeteilt. Alle übrigen werden dann eingeteilt. Wenn nur ein Ministrant bisher im
					* Temp stand, wird dieser dann heraus genommen und ein leeres Array wird eingeteilt.
					***********************/
					else{
						$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT))," Der Partner ".$minis_array[$mypid]->getUsername().'('.$mypid.')'." konnte nicht im Gottesdienst ".$wid.", mit ".$minis_array[$mypid]->getUsername().'('.$minis_rand_array[$mini_index].') eingeteilt werden. Beide werden wieder herausgenommen.');
						$worship->deleteLastTempMini();
					}
				}//end: Hat Partner
				
				//write minis in plan
				$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),"Minis werden eingetragen");
				$worship->addTempToPlan($logManager, $statistik);
				
				$mini_index++;
				if($mini_index == $statistik->getNumberMinis())
						$mini_index = 0;
				
			}//end: while need ministrants for this worship
			//Einteilung für diesen Gottesdienst abgeschlossen
			$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),"Gottesdienst fertig eingeteilt");
			if($test < 30)
				$test ++;
			else
				die;
			
		}//end: for worship
		
		$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),"Überprüfe alle Minis…");
		foreach($minis_array as $mini){
			if($mini->getEinteilungsIndex() != 0 && $mini->eingeteilt() == 0)
			{
				$error_warnings.="<br/>Warnung: Der Ministrant ".$mini->getUsername().'wurde nicht eingeteilt! Bitte überprüfen Sie ob es genügend Messen gibt, oder ob der Partner an allen Terminen nicht kann!';
			
				$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),
					" Warnung: Der Ministrant ".$mini->getUsername().'wurde nicht eingeteilt! Bitte überprüfen Sie ob es genügend Messen gibt, oder ob der Partner an allen Terminen nicht kann!'
					);
			}
		}
		$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT)),"Einteilung Abgeschlossen!");
		
		//temp output:
		/*
		print_r($worships);
		echo "<br/><br/>";
		
		print_r($churches);
		echo "<br/><br/>";
		
		print_r($minis);
		echo "<br/><br/>------------------------------Minis gemischt----------------------------------------------------------------</br>";
		
		print_r($minis_array);
		echo "<br/><br/>-------------------------------------------------------------------------------------------------------</br>";
		
		echo "Durchschnitt".$statistik->getAllRequestedMinis()."/".$statistik->getNumberMinis().": ".$statistik->getDurchschnitt()."<br/>";
		echo "Maximale Länge: ".$statistik->getMaxRequestedMinis()."<br/>";
		
		echo "<br/><br/>--------------------------------------------Hauptarray-----------------------------------------------------------</br>";
		$output = "<table>";
		foreach($plan as $item)
		{
			$output.="<tr>";
			$output.="<td>".$item["id"]."</td>";
			$output.="<td>".$item["cid"]."</td>";
			$output.="<td>".$item["cname"]."</td>";
			$output.="<td>".$item["date"]."</td>";
			$output.="<td>".$item["time"]."</td>";
			$output.="<td>".$item["info"]."</td>";
			//print_r($item);
			foreach($item["minis"] as $mini)
				{
				//echo $mini;
				$output.="<td>".$mini."</td>";
				}
			for($i=0;$i<($statistik->getMaxRequestedMinis() -$item["minis_requested"]);$i++)
				$output.="<td>"."</td>";
			$output.="<td>".$item["minis_requested"]."</td>";
			$output.="</tr>";
		}
		$output .= "</table>";
		echo $output;
		
		echo "<br/><br/>--------------------------------------------Plan-----------------------------------------------------------</br>";
		$output = "<table>";
		$counter = 0;
		foreach($plan as $item)
		{
			$output.="<tr>";
			if($counter && ($plan[$counter-1]["date"]==$item["date"]))
				$output.="<td></td>";
			else
				$output.="<td>".$item["date"]."</td>";
			$output.="<td>".$item["time"]."</td>";
			$output.="<td>".$item["cname"]."</td>";
			$output.="<td>".$item["info"]."</td>";
			//print_r($item);
			foreach($item["minis"] as $mini)
				{
					//echo $mini;
					$thismini = UserUtil::getPNUser($minis_array[$mini]["uid"]);
					$output.="<td>".$thismini["uname"]."</td>";
				}
			for($i=0;$i<($statistik->getMaxRequestedMinis() -$item["minis_requested"]);$i++)
				$output.="<td>"."</td>";
			$output.="<td>".$item["minis_requested"]."</td>";
			$output.="</tr>";
			$counter++;
		}
		$output .= "</table>";
		echo $output;
		echo "<br/><br/>--------------------------------------------Error and Warnings-----------------------------------------------------------</br>";
		echo $error_warnings;
		
		echo "<br/><br/>--------------------------------------------allocation-----------------------------------------------------------</br>";
		*/
		$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT))," Errechnen der Statistik");
		
		$logManager->add((str_pad(__LINE__, 3, 0, STR_PAD_LEFT))," Plan speichern!");
		
		$old_plan = $this->entityManager->getRepository('Miniplan_Entity_Plan')->findBy(array());
		
		foreach($old_plan as $old_einteilung)
		{
			$oldtemp = $this->entityManager->find('Miniplan_Entity_Plan', $old_einteilung->getId());
			$this->entityManager->remove($oldtemp);
			$this->entityManager->flush();
		}
		
		foreach($plan as $gottesdienst)
		{
			foreach($gottesdienst->getMinis() as $mini)
			{
				$dbplan = new Miniplan_Entity_Plan();
				$dbplan->setWid($gottesdienst->getId());
				$dbplan->setMid($mini);
				$this->entityManager->persist($dbplan);
				$this->entityManager->flush();
			}
		}
		
		
		$logManager->close(str_pad(__LINE__, 3, 0, STR_PAD_LEFT));
		
		$MiniplanData = array(
			"success" => true,
			"error_warnings" => $error_warnings//all error and warnings
		);
		
		$logManager->printLogHeader();
		$logManager->printLogError($error_warnings);
		$logManager->printLogProzess();
		$logManager->printChurches($churches);
		$logManager->printWorships($worships);
		$logManager->printMinisArray($minis_array);
		$logManager->printMixedMinis($minis_rand_array);
		
		return $MiniplanData;
	}
}

