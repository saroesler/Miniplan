{include file='Admin/Header.tpl' __title='Group' icon='config'}

<table class="z-datatable">
	<thead>
		<tr>
			<th>{gt text='ID'}</th>
			<th>{gt text='Name'}</th>
			<th>{gt text='Nicname'}</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$ministrants item='ministrant'}
			<tr>
				<td>{$ministrant.user.uid}</td>
				<td>{$ministrant.user.uname}</td>
				<td>{$ministrant.db->getNicname()}</td>
				<td>
				<a href="{modurl modname=Miniplan type=admin func=my_calendar id=$ministrant.user.uid url='group'}" class="z-button">{img src='xedit.png' modname='core' set='icons/extrasmall'}</a>
				<a href="{modurl modname=Miniplan type=admin func=Delete_ministrant id=$ministrant.user.uid path='Group'}" class="z-button">{img src='14_layer_deletelayer.png' modname='core' set='icons/extrasmall'}</a>
				</td>
			</tr>
		{/foreach}
	</tbody>
</table>

{include file='Admin/Footer.tpl'}
