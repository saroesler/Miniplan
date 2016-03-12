{include file='Admin/Header.tpl' __title='Miniplan' icon='config'}
{pageaddvar name="javascript" value="modules/Miniplan/javascript/createManuely.js"}
{pageaddvar name="stylesheet" value="modules/Miniplan/style/manuelly.css"}
{pageaddvar name="javascript" value="jquery"}
<br />
<br />
<a id="Durchschnitt" style="display:none;">{$durchschnitt}</a>
<table id="MinisSelection">
	{foreach from=$data item="worship"}
		{assign var="wid" value=$worship.worship.wid}
		<tr>
			{assign var="counter" value=0}
			{foreach from=$worship.data item="item"}
				<td>{$item}</td>
				{assign var="counter" value=$counter+1 }
			{/foreach}
			
			<td id="cid_{$wid}" style="display:none">{$worship.worship.cid}</td>
			{assign var="counter" value=0}
			{foreach from=$worship.dividedMinis item="item"}
				<td>
					{if $item}
						<span id="DividedMini_{$wid}_{$counter}">{$item.nicname}</span>
						<a id="MinisDel_{$wid}_{$counter}" onclick="delMini({$wid}, {$counter})">{img src='edit_remove.png' modname='core' set='icons/extrasmall'}</a>
						
						<a id="MinisSelector_{$wid}_{$counter}" class="MinisSelector" onclick="getListForWsh({$wid}, {$counter}, this)">{img src='reload.png' modname='core' set='icons/extrasmall'}
						</a>
						<a id="DevisionId_{$wid}_{$counter}" style="display:none">{$item.id}</a>
						<a id="pid_{$wid}_{$counter}" style="display:none">{$item->getPid()}</a>
						<a id="mid_{$wid}_{$counter}" style="display:none">{$item.mid}</a>
						<a id="ppriority_{$wid}_{$counter}" style="display:none">{$item.ppriority}</a>
						{assign var="index" value=$item.mid}
						
						{if $partnerWarning.$wid.$index == 1}
							<a id="partnerError_{$wid}_{$counter}" class="PreInfo" onclick="removePartnerError({$wid}, {$counter})">{img src='bug.png' modname='core' set='icons/extrasmall'} <span id="partnerErrorInfo_{$wid}_{$counter}">{gt text="have to"} {$item.pnic}</span></a>
						{else}
							<a id="partnerError_{$wid}_{$counter}" style="display:none" class="PreInfo" onclick="removePartnerError({$wid}, {$counter})">{img src='bug.png' modname='core' set='icons/extrasmall'}<span id="partnerErrorInfo_{$wid}_{$counter}"></span></a>
						{/if}
						{if $partnerWarning.$wid.$index == 2}
							<a id="partnerWarning_{$wid}_{$counter}" class="PreInfo" onclick="removePartnerError({$wid}, {$counter})">{img src='error.png' modname='core' set='icons/extrasmall'}
							<span id="partnerWarningInfo_{$wid}_{$counter}">{gt text="happy with"} {$item->getPnic()}</span>
							</a>
						{else}
							<a id="partnerWarning_{$wid}_{$counter}" style="display:none" class="PreInfo" onclick="removePartnerError({$wid}, {$counter})">{img src='error.png' modname='core' set='icons/extrasmall'}<span id="partnerWarningInfo_{$wid}_{$counter}"></span></a>
						{/if}
						
					{else}
						<span id="DividedMini_{$wid}_{$counter}"></span>
						<a id="MinisDel_{$wid}_{$counter}" onclick="delMini({$wid}, {$counter})" style="display:none">{img src='edit_remove.png' modname='core' set='icons/extrasmall'}</a>
						
						<a id="MinisSelector_{$wid}_{$counter}" class="MinisSelector" onclick="getListForWsh({$wid}, {$counter}, this)" style="display:none">{img src='reload.png' modname='core' set='icons/extrasmall'}</a>
						<a id="partnerError_{$wid}_{$counter}" style="display:none" class="PreInfo" onclick="removePartnerError({$wid}, {$counter}, this)">{img src='bug.png' modname='core' set='icons/extrasmall'}
						<span id="partnerErrorInfo_{$wid}_{$counter}"></span>
						</a>
						<a id="partnerWarning_{$wid}_{$counter}" style="display:none" class="PreInfo" onclick="removePartnerError({$wid}, {$counter}, this)">{img src='error.png' modname='core' set='icons/extrasmall'}
						<span id="partnerWarningInfo_{$wid}_{$counter}"></span>
						</a>
						
						
						<a id="DevisionId_{$wid}_{$counter}" style="display:none">0</a>
						<a id="pid_{$wid}_{$counter}" style="display:none">0</a>
						<a id="mid_{$wid}_{$counter}" style="display:none">0</a>
						<a id="ppriority_{$wid}_{$counter}" style="display:none">0</a>
						{assign var="empty" value=1}
					{/if}
				</td>
			{assign var="counter" value=$counter+1}
			{/foreach}
			<td id="addMini{$wid}" style="display:{if $empty}block{else}none{/if}">
					<a class="MinisSelector" onclick="getListForWsh({$wid}, -1,this)">{img src='edit_add.png' modname='core' set='icons/extrasmall'}</a>
			</td>
			{assign var="empty" value=0}
			<td class="MiniSelectionListsContainer">
				<ul class="MiniSelectionLists" id="MiniSelectionList{$wid}">
					<li style="background-color:#eee"><a onclick="closeListForWsh(this)">{gt text = "Nobody"} </a>
					</li>
					{foreach from=$worship.voluntaryMinis item="listItem"}
						<li id="ListMini_{$wid}_{$minis.$listItem->getMid()}">
							<a id="ListMiniEntity_{$wid}_{$minis.$listItem->getMid()}" onclick="divideMini({$wid}, {$minis.$listItem->getMid()}, this)"style="background-color:#00f">
								{$minis.$listItem->getNicname()}
								<span id="ListMiniMidStatsitic_{$wid}_{$minis.$listItem->getMid()}"></span>
							</a>
							<a class="ListMiniMid" style="display:none">{$minis.$listItem->getMid()}</a>
							<a id="ListMiniPriority_{$wid}_{$minis.$listItem->getMid()}" style="display:none">voluntary</a>
						</li>
					{/foreach}
					{foreach from=$worship.allMinis item="listItem"}
						<li id="ListMini_{$wid}_{$minis.$listItem->getMid()}">
							<a id="ListMiniEntity_{$wid}_{$minis.$listItem->getMid()}" onclick="divideMini({$wid}, {$minis.$listItem->getMid()}, this)"style="background-color:#0f0">
								{$minis.$listItem->getNicname()}
								<span id="ListMiniMidStatsitic_{$wid}_{$minis.$listItem->getMid()}"></span>
							</a>
							<a class="ListMiniMid" style="display:none">{$minis.$listItem->getMid()}</a>
							<a id="ListMiniPriority_{$wid}_{$minis.$listItem->getMid()}" style="display:none">can</a>
						</li>
					{/foreach}
					<li id="Info{$wid}" style="display:none">
						<a id="divisionId{$wid}"></a>
						<a id="divisionCounter{$wid}"></a>
					</li>
				</ul>
			</td>
		</tr>
	{/foreach}
</table>

<table id="statistic" style="display:block">
	<tbody>
		<tr>
			<td ></td>
			<td >{gt text="All"}</td>
			{foreach from=$churches item="church"}
				<td >{$church->getShortName()}</td>
			{/foreach}
		</tr>
		{foreach from=$minis item="mini"}
			<tr>
			<td >{$mini->getNicname()}</td>
			{assign var="mid" value=$mini.mid}
			<td id="statistic_all_{$mini.mid}">{$statistic.$mid.all}</td>
			{foreach from=$churches item="church"}
				{assign var="cid" value=$church.cid}
				<td id="statistic_{$church.cid}_{$mini.mid}">{$statistic.$mid.$cid}</td>
			{/foreach}
			</tr>
		{/foreach}
	</tbody>
</table>

<a href="{modurl modname=Miniplan type=admin func=printOdt}" class="z-button">{gt text="Print"}  {img src='printer.png' modname='core' set='icons/extrasmall'}</a>
<a onclick="AllDivision_Del()" class="z-button">{gt text= "Delete all Devisions!"} {img src='14_layer_deletelayer.png' modname='core' set='icons/extrasmall'}</a>

{include file='Admin/Footer.tpl'}
