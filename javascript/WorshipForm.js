function WorshipForm_load(wfid) {
	var params = new Object();
	params['wfid'] = wfid;
	new Zikula.Ajax.Request(
		"ajax.php?module=Miniplan&func=WorshipForm_load",
		{
			parameters: params,
			onComplete:	function (ajax) 
				{
					var returns = ajax.getData();
					document.getElementById('Minis_requested').value = returns['minis'];
					document.getElementById('info').value = returns['info'];
					document.getElementById('time').value = returns['time'];
					document.getElementById('cid').value = returns['cid'];
					}
		}
		
	);
}

function saveForm(name)
{
	if(name)
	{
		var params = new Object();
		params['name'] = name;
		params['cid'] = document.getElementById('cid').value;
		params['time'] = document.getElementById('time').value;
		params['minis'] = document.getElementById('Minis_requested').value;
		params['info'] = document.getElementById('info').value;
		new Zikula.Ajax.Request(
			"ajax.php?module=Miniplan&func=WorshipForm_save",
			{
				parameters: params,
				onComplete:	function (ajax) 
				{
					var returns = ajax.getData();
					document.getElementById('wfid').innerHTML = document.getElementById('wfid').innerHTML+'<option value="'+returns['Wfid']+'">'+name+'</option>'; 
					document.getElementById('wfid').value = returns['Wfid'];
					alert(returns['text']);
				}
			}
		);
	}
}

