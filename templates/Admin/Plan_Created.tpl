<style>
.nomargin p{
	margin:0px;
}

.bigimage img{
	height:40px;
	width:38px;
}
</style>

<script language="javaScript">
	function changestate()
	{
		
		var logfile = document.getElementById("logfile");
		var ausbild = document.getElementById("ausbild");
		var anbild = document.getElementById("anbild");
		if(logfile.style.display == "none")
		{
			var ende = false;
			while(ende == false)
			{
				var params = new Object();
				new Zikula.Ajax.Request(
				"ajax.php?module=Miniplan&func=PrintLog",
				{
					parameters: params,
					onComplete:	function (ajax) 
					{
						var returns = ajax.getData();
						logfile.innerHTML += returns['log'];
						ende = returns['ende'];
					}
				}
				);
			}
			
			logfile.style.display = "block";
			ausbild.style.display = "none";
			anbild.style.display = "block";
		}
		else
		{
			logfile.style.display = "none";
			ausbild.style.display = "block";
			anbild.style.display = "none";
		}
	}
</script>
{include file='Admin/Header.tpl' __title='Miniplan' icon='config'}

{if $MiniplanData.error_warnings}
	<div class="alert alert-warning">
		<p><b>{gt text="Miniplan created successfully. There is a Warning!"}</b></p>
	</div>
{else}
	<div class="alert alert-success">
		<p><b>{gt text="Miniplan created successfully"}</b></p>
	</div>
{/if}

<fieldset style="margin-left: 10px; margin-top:15px; padding:5px">
	<legend>{gt text="Error and Warnings"}</legend>
	{if ($MiniplanData.error_warnings == "")}
		<p>{gt text="There are no Error or Warnings!"}</p>
	{else}
		<p>{$MiniplanData.error_warnings}</p>
	{/if}
</fieldset>

<div style="margin-left: 10px; margin-top:15px;" class="nomargin">
	<a class="z-button bigimage" href="{modurl modname=Miniplan type=admin func=printOdt}" style="width:29%; display:none;" title="" target="_blank">
		<div style="float:left;">{img src="openoffice.png"}</div>
		<p>{gt text="Get it as an LibreOffice/ OpenOffice- Document (.odt)"}</p>
	</a>
	
	<a class="z-button bigimage" href="{modurl modname=Miniplan type=admin func=printOdt}" style="width:29%" title="" target="_blank">
		<div style="float:left;">{img src="openoffice.png"}</div>
		<p>{gt text="Get it as an LibreOffice/ OpenOffice- Document (.odt)"}</p>
	</a>
	
	<a class="z-button bigimage" href="https://de.libreoffice.org/download/" style="width:29%" title="" target="_blank">
		<div style="float:left;">{img src="openoffice.png"}</div>
		<p>{gt text="Get LibreOffice to read the plan!"}</p>
	</a>
	<a class="z-button" href="modules/Miniplan/lib/Miniplan/log.log" style="width:29%" title="" target="_blank">
		<p>{gt text="Get the Log- file"}<br/>&nbsp</p>
	</a>
	
</div>
<br/>
<br/>
<h2>{gt text="Allocation"}</h2>
<div style="margin-left: 10px; margin-top:15px; width:850px; overflow:auto;" class="nomargin" >
{assign var="firstline" value=$statistik->getAusgabe()}
<table border="1">
{foreach from=$firstline item="item"}
	<tr>
	{foreach from=$item item="item2"}
		<td>{$item2}</td>
	{/foreach}
	</tr>
{/foreach}</tr>
</table>
</div>

<br/>
<br/>
<h2>{gt text="standard deviation"}: {$statistik->varianz()}</h2>
<br/>
<br/>
<fieldset style="margin-left: 10px; margin-top:15px; padding:5px">
	<legend>{gt text="Log File"}</legend>
	{assign var="log" value=$MiniplanData.log}
	<a onclick="changestate()">
		<span id="ausbild">{img src='1rightarrow.png' modname='core' set='icons/extrasmall'}</span>
		<span id="anbild" style="display:none">{img src='1downarrow.png' modname='core' set='icons/extrasmall'}</span>
	</a>
	<div id="logfile" style="display:none">
		{*assign var="meldung" value=$log->getData()}
		{while $meldung<>NULL}
		{*foreach from= item="meldung"*}
			<p>{$meldung}</p>
			{*assign var="meldung" value=$log->getData()}
		{*/foreach*}
		{*/while*}
	</div>
</fieldset>
{include file='Admin/Footer.tpl'}
