{include file='Admin/Header.tpl' __title='Calendar' icon='config'}
<a href="{modurl modname=Miniplan type=admin func=Create_Worship}">{gt text="create new worship"}</a>
<br/><br/>

<form class="z-form" method="post" action="{modurl modname='Miniplan' type='admin' func='Requests'}">
		<table class="z-datatable">
			<thead>
				<tr>
					<th>{gt text='ID'}</th>
					<th>{gt text='Date'}</th>
					<th>{gt text='Time'}</th>
					<th>{gt text='Church'}</th>
					<th>{gt text='Ministrants'}</th>
					<th>{gt text='Info'}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$worships item='worship'}
					<tr>
						<td>{$worship->getWid()}</td>
						<td>{$worship->getDateFormattedout()}</td>
						<td>{$worship->getTimeFormatted()}</td>
						<td>{$worship->getCname()}</td>
						<td>{$worship->getMinis_requested()}</td>
						<td>{$worship->getInfo()}</td>
						<td>
						<a href="{modurl modname=Miniplan type=admin func=Edit_Worship id=$worship->getWid() }" class="z-button">{img src='xedit.png' modname='core' set='icons/extrasmall'}</a>
						<a href="{modurl modname=Miniplan type=admin func=Delete_Worship id=$worship->getWid()}" class="z-button">{img src='14_layer_deletelayer.png' modname='core' set='icons/extrasmall'}</a>
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
		<a href="{modurl modname=Miniplan type=admin func=Delete_All_Worship}" class="z-button">{img src='14_layer_deletelayer.png' modname='core' set='icons/extrasmall'} {gt text="Delete all worships"}</a>
	<input name="action" id="action" type="hidden" />
	<input name="id" id="id" type="hidden" />
</form>

{include file='Admin/Footer.tpl'}
