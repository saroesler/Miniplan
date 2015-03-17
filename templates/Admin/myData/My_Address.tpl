{pageaddvar name="javascript" value="jquery-ui"}
{pageaddvar name="stylesheet" value="javascript/jquery-ui/themes/base/jquery-ui.css"}

<script language="javaScript">
function id_datepicker(id)
{
	jQuery( "#"+id ).datepicker();
	jQuery( "#"+id ).datepicker( "option", "dateFormat", "dd.mm.yy");
	var value= document.getElementById('inBirthday_org').value;
	jQuery( "#"+id ).datepicker('setDate', value);
}
jQuery(function() {
	id_datepicker("inBirthday");
});
</script>

{include file='Admin/myData/Header.tpl' __title='my Address' icon='config'}
<h2>{gt text="Welcome"} {$user.uname}</h2>
<br />
<div class="z-informationmsg"><p>{gt text="On this page you can input your Address."}</p></div>

{form cssClass="z-form"}
	<fieldset>
		<div class="z-formrow">
			{formlabel for='inFirstName' __text='First Name:'}
			{formtextinput id="inFirstName" maxLength=300 mandatory=true text=$user.__ATTRIBUTES__.first_name}
		</div>
		<div class="z-formrow">
			{formlabel for='inName' __text='Name:'}
			{formtextinput id="inName" maxLength=300 mandatory=true text=$user.__ATTRIBUTES__.realname}
		</div>
		<div class="z-formrow">
			{formlabel for='inStreet' __text='Street:'}
			{formtextinput id="inStreet" maxLength=300 mandatory=true text=$user.__ATTRIBUTES__.street}
		</div>
		<div class="z-formrow">
			{formlabel for='inTown' __text='Town:'}
			{formtextinput id="inTown" maxLength=300 mandatory=true text=$user.__ATTRIBUTES__.place}
		</div>
		<div class="z-formrow">
			{formlabel for='inPlz' __text='PLZ:'}
			{formtextinput id="inPlz" maxLength=300 mandatory=true text=$user.__ATTRIBUTES__.plz}
		</div>
		<div class="z-formrow">
			{formlabel for='inBirthday' __text='Birthday:'}
			{formtextinput id="inBirthday" maxLength=300 mandatory=true text=$user.__ATTRIBUTES__.birthday}
			<input type="hidden" name="inBirthday_org" id="inBirthday_org" value="{$user.__ATTRIBUTES__.birthday}"/>
		</div>
		<div class="z-formrow">
			{formlabel for='inTel' __text='Telephone:'}
			{formtextinput id="inTel" maxLength=300 mandatory=false text=$user.__ATTRIBUTES__.tel}
		</div>
		<div class="z-formrow">
			{formlabel for='inHdy' __text='Mobile:'}
			{formtextinput id="inHdy" maxLength=300 mandatory=false text=$user.__ATTRIBUTES__.mobile}
		</div>
		<div class="z-formrow">
			{formlabel for='inParentHdy' __text='Parent Mobile:'}
			{formtextinput id="inParentHdy" maxLength=300 mandatory=false text=$user.__ATTRIBUTES__.parent_mobile}
		</div>
		<div class="z-formrow">
			{formlabel for='inEmail' __text='e-Mail:'}
			<input id="inEmail" name="inEmail" maxLength=300 value={$user.email} readonly="readonly">
		</div>
		<div class="z-formrow">
			{formlabel for='inEmail' __text='e-Mail:'}
			<a href="{modurl modname=users type=user func=changeEmail}" class="z-button">{gt text = "Emailadresse ändern"}{img src='xedit.png' modname='core' set='icons/extrasmall'}</a>
		</div>
	</fieldset>
	<div class="z-formbuttons z-buttons">
		   {formbutton class="z-bt-ok" commandName="save" __text="Save"}
		   {formbutton class="z-bt-cancel" commandName="cancel" __text="Cancel"}
	   </div>
	<input name="action" id="action" type="hidden" />
	<input type="hidden" id="indate_num" name="indate_num" value=0>
{/form}
{include file='Admin/Footer.tpl'}
