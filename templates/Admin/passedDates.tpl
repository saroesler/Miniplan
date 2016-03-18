{include file='Admin/Header.tpl' __title='Passed Dates' icon='config'}
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
						<th><a href="{modurl modname=Miniplan type=admin func=my_calendar id=$uid url='passed_Dates'}">{$mini->getNicname()}</a></th>
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
						{assign var="pid" value=$mini->getPid()}
						{assign var="partneruid" value=$uids.$pid}
						{if ($pid)}
							<td>{if ($mini.ppriority==0)}{gt text="like"}{else}{gt text="always"}{/if} {gt text="with"} {$partnername.$pid}</td>
						{else}
							<td></td>
						{/if}
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
								{assign var="text" __value="not devide"}
							{elseif $my_calendar[$wid] == 2}
								{assign var="color" value="#01A9DB"}
								{assign var="text" __value="like"}
							{else}
								{assign var="color" value="#0f0"}
								{assign var="text" __value="devide"}
							{/if}
						<td style="background-color:{$color}; border:1px #cfcfcf solid;">{*$text*}
							{if $my_calendar[$wid] == 1}
								{img src='redled.png' modname='core' class='non_shadow' set='icons/extrasmall'}
							{elseif $my_calendar[$wid] == 2}
								{img src='network.png' modname='core' class='non_shadow' set='icons/extrasmall'}
							{else}
								{img src='greenled.png' modname='core' class='non_shadow'  set='icons/extrasmall'}
							{/if}
						</td>
					{/foreach}
					</tr>
				{/foreach}
			</tbody>
		</table>
	<a href="{modurl modname=Miniplan type=admin func=quick_input}" class="z-button">{gt text="Quick Input"}</a>
	   <a href="{modurl modname=Miniplan type=admin func=printData}" class="z-button">{gt text="Print"}  {img src='printer.png' modname='core' set='icons/extrasmall'}</a>

{include file='Admin/Footer.tpl'}
