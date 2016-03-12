{include file='Admin/Header.tpl' __title='Forms' icon='config'}
<a href="{modurl modname=Miniplan type=admin func=Create_worship}">{gt text="create new form"}</a>
<br/><br/>

<form class="z-form" method="post" action="{modurl modname='Miniplan' type='admin' func=''}">
		<table class="z-datatable">
			<thead>
				<tr>
					<th>{gt text='ID'}</th>
					<th>{gt text='Name'}</th>
					<th>{gt text='Time'}</th>
					<th>{gt text='Church'}</th>
					<th>{gt text='Ministrants'}</th>
					<th>{gt text='Info'}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$forms item='form'}
					<tr>
						<td>{$form->getWfid()}</td>
						<td>{$form->getName()}</td>
						<td>{$form->getTimeFormatted()}</td>
						<td>{$form->getCname()}</td>
						<td>{$form->getMinis_requested()}</td>
						<td>{$form->getInfo()}</td>
						<td>
						<a href="{modurl modname=Miniplan type=admin func=Edit_Form id=$form->getWfid() }" class="z-button">{img src='xedit.png' modname='core' set='icons/extrasmall'}</a>
						<a href="{modurl modname=Miniplan type=admin func=Delete_Form id=$form->getWfid()}" class="z-button">{img src='14_layer_deletelayer.png' modname='core' set='icons/extrasmall'}</a>
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	<input name="action" id="action" type="hidden" />
	<input name="id" id="id" type="hidden" />
</form>

{include file='Admin/Footer.tpl'}
