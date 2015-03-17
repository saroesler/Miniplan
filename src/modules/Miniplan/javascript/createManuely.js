function getListForWsh(wid, counter,element ){
	if(document.getElementById("MiniSelectionList"+wid).style.display == "block")
		//document.getElementById("MiniSelectionList"+wid).style.display = "none";
		jQuery(element).parent().parent().find(".MiniSelectionLists").slideUp();
	else{
		//document.getElementById("MiniSelectionList"+wid).style.display = "block";
		
			var childelement = jQuery(element).parent().parent().find(".MiniSelectionLists");
			var parentelement = jQuery(element);
			var parentlist = parentelement.parent();
			var topelement = jQuery(element);
			var poffset = parentelement.offset();
			var toffset = topelement.offset();
			var topoffset = toffset.top - poffset.top + 36;
			var leftoffset = parentelement.width();
			
			childelement.css("top", 0 + "px");
			childelement.css("left", -36 + "px");
			
			jQuery(element).parent().parent().find(".MiniSelectionLists").slideDown();
			var midlist = jQuery(element).parent().parent().find(".MiniSelectionLists").children().find('.ListMiniMid');
			
			var durchschitt = parseFloat(document.getElementById("Durchschnitt").innerHTML);
			
			for(var i = 0; i < midlist.length; i ++){
				var mid = midlist[i].innerHTML;
				var cid = document.getElementById("cid_"+wid).innerHTML ;
				
				//setze Statistic
				var allStatistic = document.getElementById("statistic_all_"+mid).innerHTML;
				var churchStatistic = document.getElementById("statistic_"+cid+"_"+mid).innerHTML;
				document.getElementById("ListMiniMidStatsitic_"+wid+"_"+mid).innerHTML = allStatistic + " / " + churchStatistic;
				
				
				//change color, if too often
				var priority = document.getElementById("ListMiniPriority_"+wid+"_"+mid).innerHTML;
				
				if(durchschitt < parseFloat(allStatistic)){
					if(priority == "voluntary")
						document.getElementById("ListMiniEntity_"+wid+"_"+mid).style.background="#c09";
					else
						document.getElementById("ListMiniEntity_"+wid+"_"+mid).style.background="#f90";
				}
				else{
					if(priority == "voluntary")
						document.getElementById("ListMiniEntity_"+wid+"_"+mid).style.background="#00f";
					else
						document.getElementById("ListMiniEntity_"+wid+"_"+mid).style.background="#0f0";
				}
				
				
				//lösche schon eingeteilte 
				var j = 0;
				while(document.getElementById("mid_"+wid+"_"+j)){
					var test = document.getElementById("mid_"+wid+"_"+j).innerHTML;
					if(document.getElementById("mid_"+wid+"_"+j).innerHTML == mid){
						document.getElementById("ListMini_"+wid+"_"+mid).style.display="none";
						break;
					}
					else
						document.getElementById("ListMini_"+wid+"_"+mid).style.display="inline";
					j ++;
				}
			}
			if(counter > -1)
				document.getElementById("divisionId"+wid).innerHTML = document.getElementById("DevisionId_"+wid+"_"+counter).innerHTML;
			document.getElementById("divisionCounter"+wid).innerHTML = counter;
		}
}

function closeListForWsh(element){
		jQuery(element).parent().parent().slideUp();
}

function divideMini(wid, mid, element){
	if(wid && mid)
	{
		var params = new Object();
		params['id'] = document.getElementById("divisionId"+wid).innerHTML;
		params['mid'] = mid;
		params['wid'] = wid;
		new Zikula.Ajax.Request(
			"ajax.php?module=Miniplan&func=miniDivision",
			{
				parameters: params,
				onComplete:	function (ajax) 
				{
					var returns = ajax.getData();
					var counter = document.getElementById("divisionCounter"+wid).innerHTML;
					if(returns['error'])
						return;
					
					if(!returns['error']&&(counter < 0 )){
						//serch free cell
						var i = 0;
						while(document.getElementById("DividedMini_"+wid+"_"+i)){
						//empty cell
							var test = document.getElementById("DividedMini_"+wid+"_"+i).innerHTML;
							if(document.getElementById("DividedMini_"+wid+"_"+i).innerHTML == ""){
								break;
							}
							i ++;
						}
						//fill cell
						document.getElementById("DividedMini_"+wid+"_"+i).innerHTML = returns['name'];
						document.getElementById("DevisionId_"+wid+"_"+i).innerHTML = returns['id'];
						document.getElementById("mid_"+wid+"_"+i).innerHTML = returns['mid'];
						document.getElementById("pid_"+wid+"_"+i).innerHTML = returns['pid'];
						document.getElementById("ppriority_"+wid+"_"+i).innerHTML = returns['ppriority'];
						
						//show add button, if there are free cells
						if(document.getElementById("DividedMini_"+wid+"_"+(i+1)))
							document.getElementById("addMini"+wid).style.display = "block";
						else
							document.getElementById("addMini"+wid).style.display = "none";
						
						document.getElementById("MinisSelector_"+wid+"_"+i).style.display = "inline";
						document.getElementById("MinisDel_"+wid+"_"+i).style.display = "inline";
						
						closeListForWsh(element);
						
						
					}else if(!returns['error']&&(counter > -1)){
						//change
						var mid = document.getElementById("mid_"+wid+"_"+counter).innerHTML;
						var ppriority = document.getElementById("ppriority_"+wid+"_"+counter).innerHTML;
						var name = document.getElementById("DividedMini_"+wid+"_"+counter).innerHTML;
						
						
						document.getElementById("DividedMini_"+wid+"_"+counter).innerHTML = returns['name'];
						document.getElementById("mid_"+wid+"_"+counter).innerHTML = returns['mid'];
						document.getElementById("pid_"+wid+"_"+counter).innerHTML = returns['pid'];
						document.getElementById("ppriority_"+wid+"_"+counter).innerHTML = returns['ppriority'];
						
						loosePartner(mid, ppriority, name, wid);
						
						closeListForWsh(element);
					}
					
					//change the statistic for this mini
					var allStatistic = document.getElementById("statistic_all_"+returns['mid']).innerHTML;
					var churchStatistic = document.getElementById("statistic_"+returns['cid']+"_"+returns['mid']).innerHTML;
					document.getElementById("statistic_all_"+returns['mid']).innerHTML = parseInt(allStatistic)+1;
					document.getElementById("statistic_"+returns['cid']+"_"+returns['mid']).innerHTML = parseInt(churchStatistic)+1;
					
					//serach mini, how was this mini as partner
					var j = 0;
					while(document.getElementById("mid_"+wid+"_"+j)){
						var test = document.getElementById("mid_"+wid+"_"+j).innerHTML;
						if(document.getElementById("mid_"+wid+"_"+j).innerHTML == ""+returns['pid'] + ""){
							
							document.getElementById("partnerError_"+wid+"_"+j).style.display = "none";
							document.getElementById("partnerWarning_"+wid+"_"+j).style.display = "none";
						}
						j ++;
					}
					
					if(returns['pid']){
						//serach partner for this mini
						var partner = 0;
						j = 0;
						while(document.getElementById("pid_"+wid+"_"+j)){
							var test = document.getElementById("pid_"+wid+"_"+j).innerHTML;
							if(document.getElementById("pid_"+wid+"_"+j).innerHTML == returns["mid"]){
								partner ++;
							}
							j ++;
						}
						
						//>2, because one time, its himself
						if(partner < 1 && returns['ppriority']){
							document.getElementById("partnerError_"+wid+"_"+i).style.display = "inline";
							document.getElementById("partnerErrorInfo_"+wid+"_"+i).innerHTML = "muss mit "+returns['pnic'];
						}
						else
							document.getElementById("partnerError_"+wid+"_"+i).style.display = "none";
							
						if((partner < 1) && !returns['ppriority']){
							document.getElementById("partnerWarning_"+wid+"_"+i).style.display = "inline";
							document.getElementById("partnerWarningInfo_"+wid+"_"+i).innerHTML = "gerne mit "+returns['pnic'];
						}
						else
							document.getElementById("partnerWarning_"+wid+"_"+i).style.display = "none";
					}
				},
				onError: function (ajax){
					alert("test");
				}
			}
		);
	}
}


function delMini(wid, counter){
	var id = document.getElementById("DevisionId_"+wid+"_"+counter).innerHTML;
	if(id)
	{
		var params = new Object();
		params['id'] = document.getElementById("DevisionId_"+wid+"_"+counter).innerHTML;;
		new Zikula.Ajax.Request(
			"ajax.php?module=Miniplan&func=delDivision",
			{
				parameters: params,
				onComplete:	function (ajax) 
				{
					var returns = ajax.getData();
					if(!returns){
						//delete cell
						var mid = document.getElementById("mid_"+wid+"_"+counter).innerHTML;
						var cid = document.getElementById("cid_"+wid).innerHTML;
						var name = document.getElementById("DividedMini_"+wid+"_"+counter).innerHTML;
						
						document.getElementById("DividedMini_"+wid+"_"+counter).innerHTML = "";
						document.getElementById("DevisionId_"+wid+"_"+counter).innerHTML = "0";
						document.getElementById("pid_"+wid+"_"+counter).innerHTML = "0";
						document.getElementById("mid_"+wid+"_"+counter).innerHTML = "0";
						document.getElementById("partnerErrorInfo_"+wid+"_"+counter).innerHTML = "";
						document.getElementById("partnerWarningInfo_"+wid+"_"+counter).innerHTML = "";
						document.getElementById("ppriority_"+wid+"_"+counter).innerHTML = "0";
						document.getElementById("MinisSelector_"+wid+"_"+counter).style.display = "none";
						document.getElementById("MinisDel_"+wid+"_"+counter).style.display = "none";
						document.getElementById("partnerError_"+wid+"_"+counter).style.display = "none";
						document.getElementById("partnerWarning_"+wid+"_"+counter).style.display = "none";
						//verschiebe Zellen
						slip(wid);
						document.getElementById("addMini"+wid).style.display = "block";
						loosePartner(mid, name, wid);
						
						//change the statistic for this mini
						var allStatistic = document.getElementById("statistic_all_"+mid).innerHTML;
						var churchStatistic = document.getElementById("statistic_"+cid+"_"+mid).innerHTML;
						document.getElementById("statistic_all_"+mid).innerHTML = parseInt(allStatistic)-1;
						document.getElementById("statistic_"+cid+"_"+mid).innerHTML = parseInt(churchStatistic)-1;
					}
				}
			}
		);
	}
}

function slip(wid){
	var i = 0;
	var empty = new Array();
	while(document.getElementById("DividedMini_"+wid+"_"+i)){
		//empty cell
		if(document.getElementById("DividedMini_"+wid+"_"+i).innerHTML == ""){
			empty.push(i);
			i ++;
			continue;
		}
		
		//copy value to empty cell
		if(empty.length){
			var newI = empty.shift();
			changePosition(wid, i, newI);
			empty.push(i);
		}
		
		i ++;
	}
}

function changePosition(wid, counter1, counter2){
	//copy Name
	document.getElementById("DividedMini_"+wid+"_"+counter2).innerHTML = document.getElementById("DividedMini_"+wid+"_"+counter1).innerHTML;
	//copy Ids
	document.getElementById("DevisionId_"+wid+"_"+counter2).innerHTML = document.getElementById("DevisionId_"+wid+"_"+counter1).innerHTML;
	document.getElementById("pid_"+wid+"_"+counter2).innerHTML = document.getElementById("pid_"+wid+"_"+counter1).innerHTML;
	document.getElementById("mid_"+wid+"_"+counter2).innerHTML = document.getElementById("mid_"+wid+"_"+counter1).innerHTML;
	document.getElementById("ppriority_"+wid+"_"+counter2).innerHTML = document.getElementById("ppriority_"+wid+"_"+counter1).innerHTML;
	//copy image states
	document.getElementById("partnerWarning_"+wid+"_"+counter2).style.display = document.getElementById("partnerWarning_"+wid+"_"+counter1).style.display;
	document.getElementById("partnerError_"+wid+"_"+counter2).style.display = document.getElementById("partnerError_"+wid+"_"+counter1).style.display;
	document.getElementById("partnerErrorInfo_"+wid+"_"+counter2).innerHTML = document.getElementById("partnerErrorInfo_"+wid+"_"+counter1).innerHTML;
	document.getElementById("partnerWarningInfo_"+wid+"_"+counter2).innerHTML = document.getElementById("partnerWarningInfo_"+wid+"_"+counter1).innerHTML;
	//set buttons
	document.getElementById("MinisSelector_"+wid+"_"+counter2).style.display = "inline";
	document.getElementById("MinisDel_"+wid+"_"+counter2).style.display = "inline";
	
	
	//del id
	document.getElementById("DevisionId_"+wid+"_"+counter1).innerHTML = "0";
	document.getElementById("pid_"+wid+"_"+counter1).innerHTML = "0";
	document.getElementById("mid_"+wid+"_"+counter1).innerHTML = "0";
	document.getElementById("ppriority_"+wid+"_"+counter1).innerHTML = "0";
	//del name
	document.getElementById("DividedMini_"+wid+"_"+counter1).innerHTML = "";
	document.getElementById("partnerErrorInfo_"+wid+"_"+counter1).innerHTML = "";
	document.getElementById("partnerWarningInfo_"+wid+"_"+counter1).innerHTML = "";
	//unset buttons
	document.getElementById("MinisSelector_"+wid+"_"+counter1).style.display = "none";
	document.getElementById("MinisDel_"+wid+"_"+counter1).style.display = "none";
	document.getElementById("partnerWarning_"+wid+"_"+counter1).style.display = "none";
	document.getElementById("partnerError_"+wid+"_"+counter1).style.display = "none";
}

function loosePartner(pid, nicname, wid){
	var j = 0;
	while(document.getElementById("pid_"+wid+"_"+j)){
		var test = document.getElementById("pid_"+wid+"_"+j).innerHTML;
		if(document.getElementById("pid_"+wid+"_"+j).innerHTML == ""+pid+""){
			var ppriority = document.getElementById("ppriority_"+wid+"_"+j).innerHTML
			if(ppriority=="1"){
				document.getElementById("partnerError_"+wid+"_"+j).style.display = "inline";
				document.getElementById("partnerErrorInfo_"+wid+"_"+j).innerHTML = "muss mit "+nicname;
			}
			else{
				document.getElementById("partnerWarning_"+wid+"_"+j).style.display = "inline";
				document.getElementById("partnerWarningInfo_"+wid+"_"+j).innerHTML = "gerne mit "+nicname;
			}
		}
		j ++;
	}
}

function removePartnerError(wid, counter){
	var i = 0;
	var empty = 0;
	while(document.getElementById("DividedMini_"+wid+"_"+i)){
	//empty cell
		var test = document.getElementById("DividedMini_"+wid+"_"+i).innerHTML;
		if(document.getElementById("DividedMini_"+wid+"_"+i).innerHTML == ""){
			empty = 1;
			break;
		}
		i ++;
	}
	
	//noch Platz
	if(empty){
		document.getElementById("divisionId"+wid).innerHTML = "";
		var strpid = document.getElementById("pid_"+wid+"_"+counter).innerHTML;
		var pid = parseInt(strpid);
		document.getElementById("divisionCounter"+wid).innerHTML = "-1";
		var element = document.getElementById("Info"+wid)
		divideMini(wid, pid, element);
	}
}

function AllDivision_Del()
{
	var params = new Object();
	if(confirm("Sollen alle Einteilungen gelöscht werden?"))
	{
		new Zikula.Ajax.Request(
			"ajax.php?module=Miniplan&func=AllDivision_Del",
			{
				parameters: params,
				onComplete:	function (ajax) 
				{
					var returns = ajax.getData();
					
					for(var i = 0; i < returns.length; i ++){
						var wid = returns[i]['wid'];
						var counter = 0;
						while(document.getElementById("mid_"+wid+"_"+counter)){
							
							var mid = document.getElementById("mid_"+wid+"_"+counter).innerHTML;
							var cid = document.getElementById("cid_"+wid).innerHTML;
							var name = document.getElementById("DividedMini_"+wid+"_"+counter).innerHTML;
					
							document.getElementById("DividedMini_"+wid+"_"+counter).innerHTML = "";
							document.getElementById("DevisionId_"+wid+"_"+counter).innerHTML = "0";
							document.getElementById("pid_"+wid+"_"+counter).innerHTML = "0";
							document.getElementById("mid_"+wid+"_"+counter).innerHTML = "0";
							document.getElementById("partnerErrorInfo_"+wid+"_"+counter).innerHTML = "";
							document.getElementById("partnerWarningInfo_"+wid+"_"+counter).innerHTML = "";
							document.getElementById("ppriority_"+wid+"_"+counter).innerHTML = "0";
							document.getElementById("MinisSelector_"+wid+"_"+counter).style.display = "none";
							document.getElementById("MinisDel_"+wid+"_"+counter).style.display = "none";
							document.getElementById("partnerError_"+wid+"_"+counter).style.display = "none";
							document.getElementById("partnerWarning_"+wid+"_"+counter).style.display = "none";
							//verschiebe Zellen
							document.getElementById("addMini"+wid).style.display = "block";
					
							//change the statistic for this mini
							document.getElementById("statistic_all_"+mid).innerHTML = 0;
							document.getElementById("statistic_"+cid+"_"+mid).innerHTML = 0;
						
							counter ++;
						}
					}
				}
			}
		);
	}
}

function getStatistics(){
	document.getElementById("statistic").style.display = 'block';
	document.getElementById("showStatistic").style.display = 'none';
	document.getElementById("hideStatistic").style.display = '';
}

function hideStatistics(){
	document.getElementById("statistic").style.display = 'none';
	document.getElementById("showStatistic").style.display = '';
	document.getElementById("hideStatistic").style.display = 'none';
}
