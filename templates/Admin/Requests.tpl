{include file='Admin/Header.tpl' __title='Requests' icon='config'}

<form class="z-form" method="post" action="{modurl modname='Miniplan' type='admin' func='Requests'}">
		<table class="z-datatable">
			<thead>
				<tr>
					<th>{gt text='ID'}</th>
					<th>{gt text='Name'}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$pendings item='pending'}
					<tr>
						<td>{$pending.uid}</td>
						<td>{$pending.uname}</td>
						<td>
						<a href="{modurl modname=Miniplan type=admin func=Add_ministrant id=$pending.uid }" class="z-button">{img src='button_ok.png' modname='core' set='icons/extrasmall'}</a>
						<a href="{modurl modname=Miniplan type=admin func=Delete_ministrant id=$pending.uid path='Requests'}" class="z-button">{img src='14_layer_deletelayer.png' modname='core' set='icons/extrasmall'}</a>
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	<input name="action" id="action" type="hidden" />
	<input name="id" id="id" type="hidden" />
</form>

{include file='Admin/Footer.tpl'}
