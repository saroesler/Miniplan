{pageaddvar name='javascript' value='jquery-ui'}
{pageaddvar name='stylesheet' value='javascript/jquery-ui/themes/base/jquery-ui.css'}
{pageaddvar name='javascript' value='javascript/jquery-plugins/jQuery-Timepicker-Addon/jquery-ui-timepicker-addon.js'}
{pageaddvar name='stylesheet' value='javascript/jquery-plugins/jQuery-Timepicker-Addon/jquery-ui-timepicker-addon.css'}

{include file='Admin/Header.tpl' __title='Worships' icon='display'}

<form class="z-form" method="post" action="{modurl modname='MiniPlan' type='Admin' func='worshipManage'}">
		<table class="z-datatable">
			<thead>
				<tr>
					<th>{gt text='ID'}</th>
					<th>{gt text='Church'}</th>
					<th>{gt text='Date'}</th>
					<th>{gt text='Ministrants'}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$worships item='worship'}
					<tr>
						<td>{$worship->getWid()}</td>
						<td>{$worship->getCname()}</td>
						<td>{$worship->getDateFormatted()}</td>
						<td>{$worship->getMinistrantsRequired()}</td>
						<td><button onclick="document.getElementById('action').value = 'del'; document.getElementById('id').value = {$worship->getWid()};">{img src='14_layer_deletelayer.png' modname='core' set='icons/extrasmall'}</button></td>
					</tr>
				{/foreach}
				<tr> 
					<td></td>
					<td>{modapifunc modname='MiniPlan' type='Admin' func='getChurchSelector' name='inchurch'}{*<input type="text" name="inchurch" />*}</td>
					<td><input type="text" name="indate" id="indate"/></td>
					<script>
						jQuery(function() {
							/*
							jQuery( "#indate" ).datepicker();
							jQuery( "#indate" ).datepicker( "option", "dateFormat", "d'.'m'.'yy" );
							*/
							jQuery('#indate').datetimepicker({
							  dateFormat: 'dd.mm.yy',
							  separator: ' ',
							  minDate: new Date()
							});
						});
					</script>
					<td><input type="text" name="inministrantsrequired" /></td>
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
