{include file='Admin/Header.tpl' __title='Settings' icon='xedit'}
<script type="text/javascript">
	function changeNew(name)
	{
		if(document.getElementById(name).checked)
		{
			document.getElementById('New_'+name).checked=true;
			document.getElementById('Reset'+name).checked=false;
		}
	}
	
	function changeReset(name)
	{
		if(document.getElementById('Reset'+name).checked)
		{
			document.getElementById('New_'+name).checked=false;
			document.getElementById(name).checked=false;
		}
	}
</script>
<h2>{gt text="set start value for new ministrant"}</h2>
{form cssClass='z-form'}
<div>
	{formvalidationsummary}
    <fieldset>
        <legend>{gt text='Settings'}</legend>
		<div>
			{formcheckbox id='New_Inactive' checked=$settings.New_Inactive}
			{formlabel for='New_Inactive' __text='allowed to be an inactive ministrant'}
		</div>
        </br>
        
    </fieldset>
    <fieldset>
        <legend>{gt text='Weekday'}</legend>
        
        {formcheckbox id='New_Monday' checked=$settings.New_Monday}
		{formlabel for='New_Monday' __text='allowed to change Monday'}
		</br>
		
		{formcheckbox id='New_Tuesday' checked=$settings.New_Tuesday}
		{formlabel for='New_Tuesday' __text='allowed to change Tuesday'}
		</br>
		
		{formcheckbox id='New_Wednesday' checked=$settings.New_Wednesday}
		{formlabel for='New_Wednesday' __text='allowed to change Wednesday'}
		</br>
		
		{formcheckbox id='New_Thursday' checked=$settings.New_Thursday}
		{formlabel for='New_Thursday' __text='allowed to change Thursday'}
		</br>
		
		{formcheckbox id='New_Friday' checked=$settings.New_Friday}
		{formlabel for='New_Friday' __text='allowed to change Friday'}
		</br>
		
		{formcheckbox id='New_Saturday' checked=$settings.New_Saturday}
		{formlabel for='New_Saturday' __text='allowed to change Saturday'}
		</br>
		
		{formcheckbox id='New_Sunday' checked=$settings.New_Sunday}
		{formlabel for='New_Sunday' __text='allowed to change Sunday'}
        </br>
        
    </fieldset>
    
    <fieldset>
    	{assign var=churches_settings value=$settings.Churches}
        <legend>{gt text='Churches'}</legend>
        {formvalidationsummary}
        {foreach from=$churches item='church'}
			{assign var="cid" value=$church->getCid()}
			{assign var="New_churchstate" value=$New_churches_settings.$cid}
			
			{formcheckbox id="New_church_`$cid`" checked=$New_churchstate}
			{gt text="allowed to change %s" tag1=$church->getName() assign="church_label_text"}
			{formlabel for='Sunday' text=$church_label_text}
		    </br>
        {/foreach}
    </fieldset>
    
    <h2>{gt text="set start value for new church"}</h2>
    <fieldset>
    	{formcheckbox id="Default_Church" checked=$settings.Default_Church}
		{gt text="set new churches to allowed- state"}
	</fieldset>
	
    <h2>{gt text="set value for ministrants"}</h2>
    <div class="z-informationmsg"><p>{gt text="If you choose 'reset', all ministrans get the state not allowed for this category. Even if previously allowed and seted by the user!"}</p></div>
    <fieldset>
        <legend>{gt text='Settings'}</legend>
		<div>
			{formcheckbox id='Inactive' checked=$settings.Inactive onChange="changeNew('Inactive')"}
			{formlabel for='Inactive' __text='allowed to be an inactive ministrant'}
			{formcheckbox id='ResetInactive' checked=false onChange="changeReset('Inactive')"}
			{formlabel for='ResetInactive' __text='reset inactive state for every mini'}
			
		</div>
        </br>
        
    </fieldset>
    <fieldset>
        <legend>{gt text='Weekday'}</legend>
        
        {formcheckbox id='Monday' checked=$settings.Monday onChange="changeNew('Monday')"}
		{formlabel for='Monday' __text='allowed to change Monday'}
		{formcheckbox id='ResetMonday' checked=false onChange="changeReset('Monday')"}
		{formlabel for='ResetMonday' __text='reset Monday state for every mini'}
		</br>
		
		{formcheckbox id='Tuesday' checked=$settings.Tuesday onChange="changeNew('Tuesday')"}
		{formlabel for='Tuesday' __text='allowed to change Tuesday'}
		{formcheckbox id='ResetTuesday' checked=false onChange="changeReset('Tuesday')"}
		{formlabel for='ResetTuesday' __text='reset Tuesday state for every mini'}
		</br>
		
		{formcheckbox id='Wednesday' checked=$settings.Wednesday onChange="changeNew('Wednesday')"}
		{formlabel for='Wednesday' __text='allowed to change Wednesday'}
		{formcheckbox id='ResetWednesday' checked=false onChange="changeReset('Wednesday')"}
		{formlabel for='ResetWednesday' __text='reset Wednesday state for every mini'}
		</br>
		
		{formcheckbox id='Thursday' checked=$settings.Thursday onChange="changeNew('Thursday')"}
		{formlabel for='Thursday' __text='allowed to change Thursday'}
		{formcheckbox id='ResetThursday' checked=false onChange="changeReset('Thursday')"}
		{formlabel for='ResetThursday' __text='reset Thursday state for every mini'}
		</br>
		
		{formcheckbox id='Friday' checked=$settings.Friday onChange="changeNew('Friday')"}
		{formlabel for='Friday' __text='allowed to change Friday'}
		{formcheckbox id='ResetFriday' checked=false onChange="changeReset('Friday')"}
		{formlabel for='ResetFriday' __text='reset Friday state for every mini'}
		</br>
		
		{formcheckbox id='Saturday' checked=$settings.Saturday onChange="changeNew('Saturday')"}
		{formlabel for='Saturday' __text='allowed to change Saturday'}
		{formcheckbox id='ResetSaturday' checked=false onChange="changeReset('Saturday')"}
		{formlabel for='ResetSaturday' __text='reset Saturday state for every mini'}
		</br>
		
		{formcheckbox id='Sunday' checked=$settings.Sunday onChange="changeNew('Sunday')"}
		{formlabel for='Sunday' __text='allowed to change Sunday'}
		{formcheckbox id='ResetSunday' checked=false onChange="changeReset('Sunday')"}
		{formlabel for='ResetSunday' __text='reset Sunday state for every mini'}
        </br>
        
    </fieldset>
    
    <fieldset>
    	{assign var=churches_settings value=$settings.Churches}
        <legend>{gt text='Churches'}</legend>
        {formvalidationsummary}
        {foreach from=$churches item='church'}
			{assign var="cid" value=$church->getCid()}
			{assign var="churchstate" value=$churches_settings.$cid}
			
			{formcheckbox id="church_`$cid`" checked=$churchstate  onChange="changeNew('church_$cid')"}
			{gt text="allowed to change %s" tag1=$church->getName() assign="church_label_text"}
			{formlabel for='church_`$cid`' text=$church_label_text}

			<br/>
			
			{formcheckbox id="Resetchurch_`$cid`" checked=false  onChange="changeReset('church_$cid')"}
			{gt text="reset %s state for every mini" tag1=$church->getName() assign="church_label_text"}
			{formlabel for='Resetchurch_`$cid`' text=$church_label_text}
			
		    </br><br/>
        {/foreach}
    </fieldset>
	</div>

	<h2>{gt text="Creation Algorithm"}</h2>
    <fieldset>
		<legend>{gt text='Vuong-Algorithm'}</legend>
		<div class="z-formrow">
			{formlabel for='voungMaxLevel' __text='enter ministrant maximal'}
			{formtextinput id="voungMaxLevel" maxLength=3 size=3 mandatory=true text=$settings.voungMaxLevel}
		</div>
		
		<div class="z-formrow">
			{formlabel for='voungDistanceDays' __text='distance in days'}
			{formtextinput id="voungDistanceDays" maxLength=3 size=3 mandatory=true text=$settings.voungDistanceDays}
		</div>
		
		<div class="z-formrow">
			{formlabel for='voungDistanceWorships' __text='distance in worhsips'}
			{formtextinput id="voungDistanceWorships" maxLength=3 size=3 mandatory=true text=$settings.voungDistanceWorships}
		</div>
	</fieldset>

	<h2>{gt text="Profile Settings"}</h2>
	<fieldset>
		<legend>{gt text="Address fields"}</legend>
		<div class="z-informationmsg"><p>{gt text="Please insert in the following fields the name of the Profile- fields."}</p></div>
		<div class="z-formrow">
			{formlabel for='firstname' __text='First Name:'}
			{formtextinput id="firstname" maxLength=200 mandatory=true text=$settings.firstname}
		</div>
		<div class="z-formrow">
			{formlabel for='surname' __text='Surname:'}
			{formtextinput id="surname" maxLength=200 mandatory=true text=$settings.surname}
		</div>
		<div class="z-formrow">
			{formlabel for='address' __text='Address:'}
			{formtextinput id="address" maxLength=200 mandatory=true text=$settings.address}
		</div>
		<div class="z-formrow">
			{formlabel for='place' __text='Place:'}
			{formtextinput id="place" maxLength=200 mandatory=true text=$settings.place}
		</div>
		<div class="z-formrow">
			{formlabel for='plz' __text='Plz:'}
			{formtextinput id="plz" maxLength=200 mandatory=true text=$settings.plz}
		</div>
		<div class="z-formrow">
			{formlabel for='birthday' __text='Birthday:'}
			{formtextinput id="birthday" maxLength=200 mandatory=true text=$settings.birthday}
		</div>
		<div class="z-formrow">
			{formlabel for='phone' __text='Phone:'}
			{formtextinput id="phone" maxLength=200 mandatory=true text=$settings.phone}
		</div>
		<div class="z-formrow">
			{formlabel for='mobile' __text='Mobile:'}
			{formtextinput id="mobile" maxLength=200 mandatory=true text=$settings.mobile}
		</div>
		<div class="z-formrow">
			{formlabel for='parentmobile' __text='Parent Mobile:'}
			{formtextinput id="parentmobile" maxLength=200 mandatory=true text=$settings.parentmobile}
		</div>
   </fieldset>

	<div class="z-formbuttons z-buttons">
	   {formbutton class="z-bt-ok" commandName="save" __text="Save"}
	   {formbutton class="z-bt-cancel" commandName="cancel" __text="Cancel"}
   </div>
{/form}

{include file='Admin/Footer.tpl'}
