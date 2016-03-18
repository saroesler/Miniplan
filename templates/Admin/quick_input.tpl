{include file='Admin/Header.tpl' __title='Quick Input' icon='config'}
{pageaddvar name="javascript" value="modules/Miniplan/javascript/QuickInput.js"}

<a href="{modurl modname=Miniplan type=admin func=Create_Worship}">{gt text="create new worship"}</a>
<br/><br/>
<table>
	<tr>
		<td style="background-color:#f00;">{gt text="not devide"}</td>
		<td style="background-color:#0f0;"> {gt text="devide"}</td>
		<td style="background-color:#01A9DB;">{gt text="like"}</td>
	</tr>
</table>
<br/><br/>
		<table class="z-datatable">
			<thead>
				<tr>
					<th>{gt text='ID'}</th>
					<th>{gt text='Date'}</th>
					<th>{gt text='Time'}</th>
					<th>{gt text='Church'}</th>
					<th>{gt text='Ministrants'}</th>
					<th>{gt text='Info'}</th>
					{foreach from=$minis item='mini'}
						{assign var="uid" value=$mini->getUid()}
						<th><a href="{modurl modname=Miniplan type=admin func=my_calendar id=$uid url='quick_input'}">{$mini->getNicname()}</a></th>
					{/foreach}
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td><td></td><td></td><td></td><td></td><td></td>
					{foreach from=$minis item='mini'}
						<td>
							{assign var="edited" value=$mini->getEdited()}
							<input type="checkbox" id="edited_{$mini->getMid()}" name="edited_{$mini->getMid()}" value="{$mini->getMid()}" {if $edited <>0} checked="checked" {/if} onchange="editchange({$mini.mid})">
						</td>
					{/foreach}
				</tr>
				<tr>
					<td></td><td></td><td></td><td></td><td></td><td></td>
					{foreach from=$minis item='mini'}
					<td>
						<select name="ppriority{$mini.mid}" id="ppriority{$mini.mid}" onchange="prioritychange({$mini.mid})">
							<option value="0"{if ($mini.ppriority==0)}selected{/if}>{gt text="like"}</option>
							<option value="1"{if ($mini.ppriority==1)}selected=""{/if}>{gt text="always"}</option>
						</select>
						{assign var="mid" value=$mini.mid}
		    			{gt text="with"} {modapifunc modname='Miniplan' type='Admin' func='getPartnerSelector' name=pid$mid selected=$mini.pid myid=$mini.uid onchange=partnerchange($mid)} {gt text="divide"}
						{*assign var="pid" value=$mini->getPid()}
						{if ($pid)}
							
							{if ($mini.ppriority==0)}{gt text="like"}{else}{gt text="always"}{/if} {gt text="with"} {$users.$pid.uname}</td>
						{/if*}
					{/foreach}
				</tr>
				{foreach from=$worships item='worship'}
					{assign var="wid" value=$worship->getWid()}
					<tr>
						<td><a href="{modurl modname=Miniplan type=admin func=Edit_Worship id=$worship->getWid() }">{$worship->getWid()}</a></td>
						<td>{$worship->getDateFormattedout()}</td>
						<td>{$worship->getTimeFormatted()}</td>
						<td><a href="{modurl modname=Miniplan type=admin func=ChurchEdit id=$worship->getCid()}">{$worship->getCname()}</a></td>
						<td>{if $worship->getMinis_requested()!=0}
								{$worship->getMinis_requested()}
							{else}
								{gt text="voluntary"}
							{/if}
						</td>
						<td>{$worship->getInfo()}</td>
						{foreach from=$minis item='mini'}
								{assign var="my_calendar" value=$mini->getMy_calendar()}
								{if $my_calendar[$wid] == 1}
									{assign var="color" value="#f00"}
									{assign var="display1" value="block"}
									{assign var="display2" value="none"}
									{assign var="display3" value="none"}
								{elseif $my_calendar[$wid] == 2}
									{assign var="color" value="#01A9DB"}
									{assign var="display1" value="none"}
									{assign var="display2" value="none"}
									{assign var="display3" value="block"}
								{else}
									{assign var="color" value="#0f0"}
									{assign var="display1" value="none"}
									{assign var="display2" value="block"}
									{assign var="display3" value="none"}
								{/if}
								<td id="column_{$worship->getWid()}_{$mini->getMid()}" style="background-color:{$color}">
								<p><nobr>
									<a id="stateButton_0_{$worship->getWid()}_{$mini->getMid()}" style="display:{$display1}" ondblclick="changestate(0,{$worship->getWid()}, {$mini->getMid()})" class="z-button">{img src='redled.png' modname='core' set='icons/extrasmall'}</a>
									<a id="stateButton_1_{$worship->getWid()}_{$mini->getMid()}" style="display:{$display2}" ondblclick="changestate(2,{$worship->getWid()},{$mini->getMid()})" class="z-button">{img src='greenled.png' modname='core' set='icons/extrasmall'}</a>
									<a id="stateButton_2_{$worship->getWid()}_{$mini->getMid()}" style="display:{$display3}" ondblclick="changestate(1,{$worship->getWid()},{$mini->getMid()})" class="z-button">{img src='network.png' modname='core' set='icons/extrasmall'}</a></nobr>
								</p>
							</td>
					{/foreach}
					</tr>
				{/foreach}
			</tbody>
		</table>
{include file='Admin/Footer.tpl'}
