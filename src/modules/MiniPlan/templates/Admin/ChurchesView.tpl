{include file='Admin/Header.tpl' __title='Churches view' icon='display'}

{if !empty($churches)}
	<table class="z-datatable">
		<thead>
			<tr>
				<th>{gt text='ID'}</th>
				<th>{gt text='Name'}</th>
				<th>{gt text='Adress'}</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$churches item='church'}
				<tr class=""> {*TODO z-odd / z-even*}
					<td>{$church->getCid()}</td>
					<td>{$church->getName()}</td>
					<td>{$church->getAdress()}</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
{/if}

{include file='Admin/Footer.tpl'}