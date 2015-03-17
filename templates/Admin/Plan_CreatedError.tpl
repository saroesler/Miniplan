<style>
.nomargin p{
	margin:0px;
}

.bigimage img{
	height:40px;
	width:38px;
}
</style>

{include file='Admin/Header.tpl' __title='Miniplan' icon='config'}
<div class="alert alert-danger">
	<p><b>{gt text="Miniplan creation failes"}</b></p>
</div>
<fieldset style="margin-left: 10px; margin-top:15px; padding:5px">
	<legend>{gt text="Error and Warnings"}</legend>
		<p>{$message}</p>
</fieldset>
<div style="margin-left: 0px; margin-top:15px;" class="nomargin">
	<a class="z-button bigimage" href="{modurl modname=Miniplan type=admin func=printOdt}" style="width:29%; display:none;" title="" target="_blank">
		<div style="float:left;">{img src="openoffice.png"}</div>
		<p>{gt text="Get it as an LibreOffice/ OpenOffice- Document (.odt)"}</p>
	</a>
	
	<a class="z-button" href="modules/Miniplan/lib/Miniplan/log.log" style="width:98%" title="" target="_blank">
		<p>{gt text="Get the Log- file"}<br/>&nbsp</p>
	</a>
	
</div>

{include file='Admin/Footer.tpl'}
