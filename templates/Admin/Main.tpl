{include file='Admin/Header.tpl' __title='Main' icon='config'}
<style>
.Description_save{
	display:none;
}
</style>
<script>
function Description()
{
	var id = document.getElementById('Routineselector').selectedIndex;
	document.getElementById('Description_output').innerHTML = document.getElementById('Description_'+id).innerHTML;
	document.getElementById('Description_sub').innerHTML = document.getElementById('Description_subtitle_'+id).innerHTML;
	document.getElementById('Description_output_sub').innerHTML = document.getElementById('Description_subtext_'+id).innerHTML;
}
</script>
{foreach from=$descriptions item = "description"}
	<p id="Description_{$description.id}" class="Description_save">{$description.text}</p>
	<p id="Description_subtitle_{$description.id}" class="Description_save">{$description.subtitle}</p>
	<p id="Description_subtext_{$description.id}" class="Description_save">{$description.subtext}</p>
{/foreach}
{if $thereiswhattdo <> 0}
	<div class="alert alert-warning">
		{gt text="There are minis, their passed dates are not controlled."}
	</div>
{/if}
<h2>{gt text="Create a Miniplan"}</h2>
<form class="z-form" method="post" action="{modurl modname='Miniplan' type='admin' func='createmanager'}">
	<fieldset style="margin_10px">
		<lable>{gt text="choose a routine:"}</lable>
			{modapifunc modname='Miniplan' type='Create' func='getRoutineselector' name='inday'}
			<br/> <br/>
			<fieldset style="margin_10px">
				<legend>{gt text='Description'}</legend>
				<p id="Description_output"></p>
				<fieldset style="margin_10px">
				<legend id="Description_sub"></legend>
					<p id="Description_output_sub"></p>
				</fieldset>
			</fieldset>
			<br/><br/>
		<button class="z-button">{img src='button_ok.png' modname='core' set='icons/extrasmall'}{gt text="create plan now!"}</button>
	</fieldset>
</form>
<script>
	Description();
</script>
{include file='Admin/Footer.tpl'}
