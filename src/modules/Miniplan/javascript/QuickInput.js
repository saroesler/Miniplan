function partnerchange(mid){
	var mySelect = document.getElementById("pid"+mid);
	var sid = mySelect.selectedIndex;
	var pid = mySelect.options[sid].value;
	if(mid)
	{
		var params = new Object();
		params['mid'] = mid;
		params['pid'] = pid;
		new Zikula.Ajax.Request(
			"ajax.php?module=Miniplan&func=Partner_save",
			{
				parameters: params,
				onComplete:	function (ajax) 
				{
					var returns = ajax.getData();
					document.getElementById('pid'+mid).value = returns['pid'];
				}
			}
		);
	}
}

function prioritychange(mid){
	var mySelect = document.getElementById("ppriority"+mid);
	var sid = mySelect.selectedIndex;
	var setting = mySelect.options[sid].value;
	if(mid)
	{
		var params = new Object();
		params['mid'] = mid;
		params['setting'] = setting;
		new Zikula.Ajax.Request(
			"ajax.php?module=Miniplan&func=Ppriority_save",
			{
				parameters: params,
				onComplete:	function (ajax) 
				{
					var returns = ajax.getData();
					document.getElementById('ppriority'+mid).value = returns['ppriority'];
				}
			}
		);
	}
}


function changestate(state ,wid, mid){
	if(mid)
	{
		var params = new Object();
		params['mid'] = mid;
		params['wid'] = wid;
		params['state'] = parseInt(state);
		new Zikula.Ajax.Request(
			"ajax.php?module=Miniplan&func=Calendar_save",
			{
				parameters: params,
				onComplete:	function (ajax) 
				{
					var returns = ajax.getData();
					var column = document.getElementById("column_"+wid+"_"+mid);
					var color;
					var calendar = returns['calendar'];
					var state = calendar[wid];
					var displayState0 = "none";
					var displayState1 = "none";
					var displayState2 = "none";
					switch (state)
					{
						case "1":
							color="#f00";
							displayState0 = "block";
							break;
						case "0":
							color="#0f0";
							displayState1 = "block";
							break;
						case "2":
							color="#01A9DB";
							displayState2 = "block";
							break;
					}
					column.setAttribute("style", "background-color:"+color);
					document.getElementById("stateButton_0_"+wid+"_"+mid).style.display = displayState0;
					document.getElementById("stateButton_1_"+wid+"_"+mid).style.display = displayState1;
					document.getElementById("stateButton_2_"+wid+"_"+mid).style.display = displayState2;
				}
			}
		);
	}
}

function editchange(mid){
	if(mid)
	{
		var params = new Object();
		params['mid'] = mid;
		var temp = document.getElementById("edited_"+mid);
		params['state'] =  temp.checked;
		new Zikula.Ajax.Request(
			"ajax.php?module=Miniplan&func=editchange",
			{
				parameters: params,
				onComplete:	function (ajax) 
				{
				}
			}
		);
	}
}
