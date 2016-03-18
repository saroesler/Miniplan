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
			{assign var="firstnameType" value=$settings.firstname }
			{formtextinput id="inFirstName" maxLength=300 mandatory=true text=$user.__ATTRIBUTES__.$firstnameType}
		</div>
		<div class="z-formrow">
			{formlabel for='inName' __text='Name:'}
			{assign var="surnameType" value=$settings.surname }
			{formtextinput id="inName" maxLength=300 mandatory=true text=$user.__ATTRIBUTES__.$surnameType}
		</div>
		<div class="z-formrow">
			{formlabel for='inStreet' __text='Address:'}
			{assign var="addressType" value=$settings.address }
			{formtextinput id="inStreet" maxLength=300 mandatory=true text=$user.__ATTRIBUTES__.$addressType}
		</div>
		<div class="z-formrow">
			{formlabel for='inTown' __text='Town:'}
			{assign var="placeType" value=$settings.place }
			{formtextinput id="inTown" maxLength=300 mandatory=true text=$user.__ATTRIBUTES__.$placeType}
		</div>
		<div class="z-formrow">
			{formlabel for='inPlz' __text='PLZ:'}
			{assign var="plzType" value=$settings.plz}
			{formtextinput id="inPlz" maxLength=300 mandatory=true text=$user.__ATTRIBUTES__.$plzType}
		</div>
		<div class="z-formrow">
			{formlabel for='inBirthday' __text='Birthday:'}
			{assign var="birthdayType" value=$settings.birthday}
			{formtextinput id="inBirthday" maxLength=300 mandatory=true text=$user.__ATTRIBUTES__.$birthdayType}
			<input type="hidden" name="inBirthday_org" id="inBirthday_org" value="{$user.__ATTRIBUTES__.$birthdayType}"/>
		</div>
		<div class="z-formrow">
			{formlabel for='inTel' __text='Phone:'}
			{assign var="phoneType" value=$settings.phone}
			{formtextinput id="inTel" maxLength=300 mandatory=false text=$user.__ATTRIBUTES__.$phoneType}
		</div>
		<div class="z-formrow">
			{formlabel for='inHdy' __text='Mobile:'}
			{assign var="mobileType" value=$settings.mobile}
			{formtextinput id="inHdy" maxLength=300 mandatory=false text=$user.__ATTRIBUTES__.$mobileType}
		</div>
		<div class="z-formrow">
			{formlabel for='inParentHdy' __text='Parent Mobile:'}
			{assign var="parentmobileType" value=$settings.parentmobile}
			{formtextinput id="inParentHdy" maxLength=300 mandatory=false text=$user.__ATTRIBUTES__.$parentmobileType}
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
