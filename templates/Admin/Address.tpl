{include file='Admin/Header.tpl' __title='Group' icon='config'}

<table class="z-datatable">
	<thead>
		<tr>
			<th>{gt text='Nr'}</th>
			<th>{gt text='Name'}</th>
			<th>{gt text='First Name'}</th>
			<th>{gt text='Address'}</th>
			<th>{gt text='Place'}</th>
			<th>{gt text='PLZ'}</th>
			<th>{gt text='Birthday'}</th>
			<th>{gt text='Telephone'}</th>
			<th>{gt text='Mobile'}</th>
			<th>{gt text='Parent Mobile'}</th>
			<th>{gt text='e-Mail'}</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$ministrants item='ministrant'}
			<tr>
				<td>{$ministrant.uid}</td>
				<td>{$ministrant.__ATTRIBUTES__.realname}</td>
				<td>{$ministrant.__ATTRIBUTES__.first_name}</td>
				<td>{$ministrant.__ATTRIBUTES__.street}</td>
				<td>{$ministrant.__ATTRIBUTES__.place}</td>
				<td>{$ministrant.__ATTRIBUTES__.plz}</td>
				<td>{$ministrant.__ATTRIBUTES__.birthday}</td>
				<td>{$ministrant.__ATTRIBUTES__.tel}</td>
				<td>{$ministrant.__ATTRIBUTES__.mobile}</td>
				<td>{$ministrant.__ATTRIBUTES__.parent_mobile}</td>
				<td><a href="mailto:{$ministrant.email}">{$ministrant.email}</a></td>
			</tr>
		{/foreach}
	</tbody>
</table>

<a href="{modurl modname=Miniplan type=admin func=printAddress}" class="z-button">{gt text="Print"}  {img src='printer.png' modname='core' set='icons/extrasmall'}</a>
{include file='Admin/Footer.tpl'}
