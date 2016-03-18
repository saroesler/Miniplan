{include file='Admin/Header.tpl' __title='Churches' icon='display'}

<form class="z-form" method="post" action="{modurl modname='Miniplan' type='admin' func='ChurchAdd'}">
		<table class="z-datatable">
			<thead>
				<tr>
					<th>{gt text='ID'}</th>
					<th>{gt text='Name'}</th>
					<th>{gt text='ShortName'}</th>
					<th>{gt text='Adress'}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$churches item='church'}
					<tr>
						<td>{$church->getCid()}</td>
						<td>{$church->getName()}</td>
						<td>{$church->getShortName()}</td>
						<td>{$church->getAdress()}</td>
						<td>
						<a href="{modurl modname=Miniplan type=admin func=ChurchEdit id=$church->getCid()}" class="z-button">{img src='xedit.png' modname='core' set='icons/extrasmall'}</a>
						<a href="{modurl modname=Miniplan type=admin func=ChurchDel id=$church->getCid()}" class="z-button">{img src='14_layer_deletelayer.png' modname='core' set='icons/extrasmall'}</a>
						</td>
					</tr>
				{/foreach}
				<tr> 
					<td></td>
					<td><input type="text" name="inname" /></td>
					<td><input type="text" name="inshortname" /></td>
					<td><input type="text" name="inadress" /></td>
					<td>
						<button onclick="document.getElementById('action').value = 'add'" class="z-button">{img src='button_ok.png' modname='core' set='icons/extrasmall'}</button>
						<button onclick="document.getElementById('action').value = ''" class="z-button">{img src='button_cancel.png' modname='core' set='icons/extrasmall'}</button>
					</td>
				</tr>
			</tbody>
		</table>
	<input name="action" id="action" type="hidden" />
	<input name="id" id="id" type="hidden" />
</form>

{include file='Admin/Footer.tpl'}
