{include file='Header.tpl'}
{adminheader}

<div class="z-menu">
    <span class = "z-menuitem-title">
    	 [ 
    	<a href="{modurl modname=Miniplan type=admin func=my_calendar id=$user.uid}">{gt text="My Calendar"}</a>
    	 | 
    	<a href="{modurl modname=Miniplan type=admin func=my_address id=$user.uid}">{gt text="My Address"}</a>
    	 ] 
    </span>
</div>

<div class="z-admin-content-pagetitle">
	{if $icon != ""}
   		{icon type=$icon size="small"}
   	{/if}
    <h3>{$title}</h3>
</div>
