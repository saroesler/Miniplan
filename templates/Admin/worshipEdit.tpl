{pageaddvar name="javascript" value="jquery-ui"}
{pageaddvar name="stylesheet" value="javascript/jquery-ui/themes/base/jquery-ui.css"}
{pageaddvar name="javascript" value="modules/Miniplan/javascript/WorshipForm.js"}
<script language="javaScript">
function id_datepicker(id)
{
	jQuery( "#"+id ).datepicker();
	jQuery( "#"+id ).datepicker( "option", "dateFormat", "dd.mm.yy");
	var value= document.getElementById('indate_org').value;
	jQuery( "#"+id ).datepicker('setDate', value);
}
jQuery(function() {
	id_datepicker("date");
});
</script>

{include file='Admin/Header.tpl' __title='Calendar' icon='config'}
{form cssClass="z-form"}
	<fieldset>
	<div class="z-formrow">
        {formlabel for='wfid' __text='Form:'}
		{modapifunc modname='Miniplan' type='Admin' func='getFormSelector' name='wfid'}
	</div>
	<div class="z-formrow">
		{formlabel for='cid' __text='Church:'}
		{formdropdownlist id="cid" size="1" mandatory=true items=$cids selectedValue=$worship->getCid()}
	</div>
	<div class="z-formrow">
		{formlabel for='time' __text='Time:'}
		{formtextinput id="time" maxLength=300 mandatory=true text=$worship->getTimeFormatted()}
	</div>
	<div class="z-formrow">
		{formlabel for='Minis_requested' __text='Who many ministrants are reqested?'}
		{formtextinput id="Minis_requested" maxLength=300 mandatory=true text=$worship->getMinis_requested()}
		<div class="z-informationmsg"><p>{gt text="If you put in an 0, it is an voluntarily worship."}</p></div>
	</div>
	<div class="z-formrow">
		{formlabel for='info' __text='Infos:'}
		{formtextinput id="info" maxLength=300 mandatory=false text=$worship->getInfo()}
	</div>
	</fieldset>
	
	<fieldset>
		<div id=felds>
			<div class="z-formrow">
				{formlabel for='date' __text='Date:'}
				{formtextinput id="date" maxLength=300 mandatory=false text=$worship->getDateFormatted()}
				<input type="hidden" name="indate_org" id="indate_org" value="{$worship->getDateFormatted()}"/>
			</div>
	</div>
	</fieldset>
	<div class="z-formbuttons z-buttons">
		   {formbutton class="z-bt-ok" commandName="save" __text="Save"}
		   {formbutton class="z-bt-cancel" commandName="cancel" __text="Cancel"}
	   </div>
{/form}
{include file='Admin/Footer.tpl'}
