<script language="javaScript">
	function changestate(state, wid)
	{
		var column = document.getElementById("Worship_column_"+wid);
		var color;
		switch (state)
		{
			case 1:
				color="#f00"
				break;
			case 0:
				color="#0f0"
				break;
			case 2:
				color="#01A9DB"
				break;
		}
		column.setAttribute("style", "background-color:"+color);
		document.getElementById("worship_state_"+wid).value=state;
	}
	
	//set column to state
	function changeonecolumn(state, id)
	{
		var column = document.getElementById(id);
		var color;
		switch (state)
		{
			case 1:
				color="#f00"
				break;
			case 0:
				color="#0f0"
				break;
			case 2:
				color="#01A9DB"
				break;
		}
		column.setAttribute("style", "background-color:"+color);
		var inputs = column.getElementsByTagName('input');
		inputs[0].value=state;
	}
	
	//manage day changes
	/**
	*mode= Modus
	*myid= id of the select
	*name= name of church or weekday
	*/
	function changeworships(mode,myid,name)
	{
		//get worships
		var worship_source=document.getElementById("worship_body");
		var worships=worship_source.getElementsByTagName('tr');
		
		//switch mode
		switch(mode)
		{
			case 'day':
				//get selection for this day
				var select=document.getElementById(myid);
				var state = select.options[select.selectedIndex].value-1;
				for(var i=1;i<worships.length;i++)
				{
					//pack worship
					var worship=worships[i];
					//get the weekday of the worship
					var inputs= worship.getElementsByTagName('input');
					var day=inputs[2].value;
					//look, if weekday is the same
					if(day==name)
						changeonecolumn(state, worship.id);
				}
			case 'church':
				//get selection for this church
				var select=document.getElementById(myid);
				var state = select.options[select.selectedIndex].value-1;
				for(var i=1;i<worships.length;i++)
				{
					//pack worship
					var worship=worships[i];
					//get the church of this worship
					var inputs= worship.getElementsByTagName('input');
					var cid=inputs[1].value;
					//look, if church is the worship church
					if(cid==name)
						changeonecolumn(state, worship.id);
				}
		}
	}
	
	//manage inactive changes
	function changeInactive()
	{
		var checkbox=document.getElementById("Inactive");
		if(checkbox.checked==true)
			state=1;
		else
			state=0;
		var worship_source=document.getElementById("worship_body");
		var worships=worship_source.getElementsByTagName('tr');
		for(var i=1;i<worships.length;i++)
		{
			var worship=worships[i];
			changeonecolumn(state, worship.id);
		}
	}
</script>
{include file='Admin/myData/Header.tpl' __title='my Calendar' icon='config'}
<h2>{gt text="Welcome"} {$user.uname}</h2>
<form class="z-form" method="post" action="{modurl modname='Miniplan' type='admin' func='save_myCalendar'}">
	<input type="hidden" id="url" name="url" value={$url}>
	<input type="hidden" id="uid" name="uid" value={$user.uid}>
	{checkpermission component="Miniplan::" instance="::" level=ACCESS_EDIT assign=admin}
	{if $admin}
		<fieldset>
			<legend>{gt text='Admin Settings'}</legend>
			<div class="z-informationmsg"><p>{gt text="In this category you can allowed this ministrant to set global variables."}</p></div>
			<h3>{gt text="for all:"}</h3>
			{if $mini.inactive}
				<input type="checkbox" name="adminInactive" checked=""> {gt text="allowed to be an inactive ministrant"}
			{else}
				<input type="checkbox" name="adminInactive"> {gt text="allowed to be an inactive ministrant"}
			{/if}
			<br/>
			<br/>
			<h3>{gt text="for Weekdays:"}</h3>
			{if $mini.days.Mo}
				<input type="checkbox" name="adminMonday" checked=""> 
			{else}
				<input type="checkbox" name="adminMonday">
			{/if}
			{gt text="allowed to set globals for Monday"}
			<br/>
			{if $mini.days.Tue}
				<input type="checkbox" name="adminTuesday" checked="">
			{else}
				<input type="checkbox" name="adminTuesday">
			{/if}
			{gt text="allowed to set globals for Tuesday"}
			<br/>
			{if $mini.days.Wed}
				<input type="checkbox" name="adminWednesday" checked="">
			{else}
				<input type="checkbox" name="adminWednesday">
			{/if}
			{gt text="allowed to set globals for Wednesday"}
			<br/>
			{if $mini.days.Thur}
				<input type="checkbox" name="adminThursday" checked="">
			{else}
				<input type="checkbox" name="adminThursday">
			{/if}
			{gt text="allowed to set globals for Thursday"}
			<br/>
			{if $mini.days.Fri}
				<input type="checkbox" name="adminFriday" checked="">
			{else}
				<input type="checkbox" name="adminFriday">
			{/if}
			{gt text="allowed to set globals for Friday"}
			<br/>
			{if $mini.days.Sat}
				<input type="checkbox" name="adminSaturday" checked="">
			{else}
				<input type="checkbox" name="adminSaturday">
			{/if}
			{gt text="allowed to set globals for Saturday"}
			<br/>
			{if $mini.days.Sun}
				<input type="checkbox" name="adminSunday" checked="">
			{else}
				<input type="checkbox" name="adminSunday">
			{/if}
			{gt text="allowed to set globals for Sunday"}
			<br/>
			<br/><br/>
			<h3>{gt text="for Churches"}</h3>
			{assign var=churches_settings value=$mini.churches}
		    {foreach from=$churches item='church'}
				{assign var="cid" value=$church->getCid()}
				{assign var="churchstate" value=$churches_settings.$cid}
				
				{if $churchstate}
					<input type="checkbox" name="adminchurch_{$cid}" checked="">
				{else}
					<input type="checkbox" name="adminchurch_{$cid}" >
				{/if}
				{gt text="allowed to change %s" tag1=$church->getName() }
				</br>
		    {/foreach}
		</fieldset>
	{/if}
	</fieldset>
	<fieldset>
		<legend>{gt text='General Settings'}</legend>
		<div class="z-informationmsg"><p>{gt text="In this category you can set global settings."}</p></div>
			{if $mini.inactive || $admin}
				<h3>{gt text="for all:"}</h3>
				{if $mini.inactive == 2}
					<input type="checkbox" id="Inactive" name="Inactive" checked="" onChange="changeInactive()"> {gt text="be an inactive ministrant"}
				{else}
					<input type="checkbox" id="Inactive" name="Inactive" onChange="changeInactive()"> {gt text="be an inactive ministrant"}
				{/if}
				<br/>
				<br/>
			{/if}
			<h3>{gt text="for Weekdays:"}</h3>
			{if $mini.days.Mo || $admin}
				{modapifunc modname='Miniplan' type='Admin' func='getMinistateSelector' name='Mon_state' selected=$mini.days.Mo mytype="day" myname="Monday"}
				{gt text="on Monday"}
				<br/>
			{/if}
			{if $mini.days.Tue || $admin}
				{modapifunc modname='Miniplan' type='Admin' func='getMinistateSelector' name='Tue_state' selected=$mini.days.Tue mytype="day" myname="Tuesday"}
				{gt text="on Tuesday"}
				<br/>
			{/if}
			{if $mini.days.Wed || $admin}
				{modapifunc modname='Miniplan' type='Admin' func='getMinistateSelector' name='Wed_state' selected=$mini.days.Wed mytype="day" myname="Wednesday"}
				{gt text="on Wednesday"}
				<br/>
			{/if}
			{if $mini.days.Thur || $admin}
				{modapifunc modname='Miniplan' type='Admin' func='getMinistateSelector' name='Thur_state' selected=$mini.days.Thur mytype="day" myname="Thursday"}
				{gt text="on Thursday"}
				<br/>
			{/if}
			<br/>
			{if $mini.days.Fri || $admin}
				{modapifunc modname='Miniplan' type='Admin' func='getMinistateSelector' name='Fri_state' selected=$mini.days.Fri mytype="day" myname="Monday"}
				{gt text="on Friday"}
				<br/>
			{/if}
			{if $mini.days.Sat || $admin}
				{modapifunc modname='Miniplan' type='Admin' func='getMinistateSelector' name='Sat_state' selected=$mini.days.Sat mytype="day" myname="Saturday"}
				{gt text="on Saturday"}
				<br/>
			{/if}
			{if $mini.days.Sun || $admin}
				{modapifunc modname='Miniplan' type='Admin' func='getMinistateSelector' name='Sun_state' selected=$mini.days.Sun mytype="day" myname="Sunday"}
				{gt text="on Sunday"}
				<br/>
			{/if}
			<br/><br/>
			<h3>{gt text="for Churches"}</h3>
			{assign var=churches_settings value=$mini.churches}
		    {foreach from=$churches item='church'}
				{assign var="cid" value=$church->getCid()}
				{assign var="churchstate" value=$churches_settings.$cid}
				
				{if $churchstate  || $admin}
					{modapifunc modname='Miniplan' type='Admin' func='getMinistateSelector' name=church_state$cid selected=$churchstate  mytype='church' myname=$church->getCid()}
					{gt text="in %s" tag1=$church->getName()}
				{/if}
				</br>
		    {/foreach}
		    <br/><br/>
		    <h3>{gt text="Nicname"}</h3>
		    <input name="nicname" id="nicname" type="text" value="{$mini.nicname}"/>
		    <br/><br/>
			<h3>{gt text="choose a partner"}</h3>
		    <p>{gt text="please"} 
		    <select name="ppriority">
		    	<option value="0"{if ($mini.ppriority==0)}selected{/if}>{gt text="like"}</option>
		    	<option value="1"{if ($mini.ppriority==1)}selected=""{/if}>{gt text="always"}</option>
		    </select>
		    {gt text="with"} {modapifunc modname='Miniplan' type='Admin' func='getPartnerSelector' name=pid selected=$mini.pid myid=$mini.uid} {gt text="divide"}
	</fieldset>
	<fieldset>
		<legend>{gt text='Worships'}</legend>
		<table class="z-datatable" id="worship_body">
			<thead>
				<tr>
					<th>{gt text='Date'}</th>
					<th>{gt text='Time'}</th>
					<th>{gt text='Church'}</th>
					<th>{gt text='Info'}</th>
					<th></th>
				</tr>
			</thead>
			{assign var="my_calendar" value=$mini.my_calendar}
			<tbody>
				{foreach from=$worships item='worship'}
					{assign var="Wid" value=$worship->getWid()}
					{if $my_calendar[$Wid] == 1}
						{assign var="color" value="#f00"}
					{elseif $my_calendar[$Wid] == 2}
						{assign var="color" value="#01A9DB"}
					{else}
						{assign var="color" value="#0f0"}
					{/if}
					<tr id="Worship_column_{$worship->getWid()}" style="background-color:{$color}" class="{$worship->getDateClass()}">
						<td>{$worship->getDateFormattedout()}</td>
						<td>{$worship->getTimeFormatted()}</td>
						<td>{$worship->getCname()}</td>
						<td>{$worship->getInfo()}</td>
						<td>
							<a onclick="changestate(1,{$worship->getWid()})" class="z-button">{img src='redled.png' modname='core' set='icons/extrasmall'}</a>
							<a onclick="changestate(0,{$worship->getWid()})" class="z-button">{img src='greenled.png' modname='core' set='icons/extrasmall'}</a>
							<a onclick="changestate(2,{$worship->getWid()})" class="z-button">{img src='network.png' modname='core' set='icons/extrasmall'}</a>
							<input type="hidden" id="worship_state_{$worship->getWid()}" name="worship_state_{$worship->getWid()}" value={$my_calendar[$Wid]}>
							<input type="hidden" name="cid" value={$worship.cid}>
							<input type="hidden" name="weekday" value={$worship->getDateClass()}>
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	<button onclick="document.getElementById('action').value = 'add'" class="z-button">{img src='button_ok.png' modname='core' set='icons/extrasmall'} {gt text="save"}</button>
		<button onclick="document.getElementById('action').value = ''" class="z-button">{img src='button_cancel.png' modname='core' set='icons/extrasmall'} {gt text="aborte"}</button>
	<input name="action" id="action" type="hidden" />
	<input name="mid" id="mid" type="hidden" value="{$mini.mid}"/>
	</fieldset>
</form>

{include file='Admin/Footer.tpl'}
