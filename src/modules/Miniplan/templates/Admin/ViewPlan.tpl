{include file='Admin/Header.tpl' __title='Miniplan' icon='config'}

<table>
	{foreach from=$data item="worship"}
		<tr>
			{assign var="counter" value=0}
			{foreach from=$worship item="item"}
				<td>{$item}</td>
				{assign var="counter" value=$counter+1 }
			{/foreach}
		</tr>
	{/foreach}
</table>

<a href="{modurl modname=Miniplan type=admin func=createManuell}" class="z-button">{gt text="Create the Plan manuelly"}</a>
<a href="{modurl modname=Miniplan type=admin func=printOdt}" class="z-button">{gt text="Print"}  {img src='printer.png' modname='core' set='icons/extrasmall'}</a>

{include file='Admin/Footer.tpl'}
