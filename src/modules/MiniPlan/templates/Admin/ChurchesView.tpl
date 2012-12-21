{include file='Admin/Header.tpl' __title='Churches' icon='display'}

<form class="z-form" method="post" action="{modurl modname='MiniPlan' type='Admin' func='ChurchAdd'}">
		<table class="z-datatable">
			<thead>
				<tr>
					<th>{gt text='ID'}</th>
					<th>{gt text='Name'}</th>
					<th>{gt text='Adress'}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$churches item='church'}
					<tr>
						<td>{$church->getCid()}</td>
						<td>{$church->getName()}</td>
						<td>{$church->getAdress()}</td>
						<td><button onclick="document.getElementById('action').value = 'del'; document.getElementById('id').value = {$church->getCid()};">{img src='14_layer_deletelayer.png' modname='core' set='icons/extrasmall'}</button></td>
					</tr>
				{/foreach}
				<tr> 
					<td></td>
					<td><input type="text" name="inname" /></td>
					<td><input type="text" name="inadress" /></td>
					<td>
						<button onclick="document.getElementById('action').value = 'add'">{img src='button_ok.png' modname='core' set='icons/extrasmall'}</button>
						<button onclick="document.getElementById('action').value = ''">{img src='button_cancel.png' modname='core' set='icons/extrasmall'}</button>
					</td>
				</tr>
			</tbody>
		</table>
	<input name="action" id="action" type="hidden" />
	<input name="id" id="id" type="hidden" />
</form>

{include file='Admin/Footer.tpl'}
