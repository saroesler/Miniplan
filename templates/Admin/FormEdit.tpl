{include file='Admin/Header.tpl' __title='Form Edit' icon='config'}
{form cssClass="z-form"}
	<fieldset>
	<legend>{gt text="Edit form"}</legend>
	<div class="z-formrow">
		{formlabel for='name' __text='Formname:'}
		{formtextinput id="name" maxLength=300 mandatory=true text=$myform->getName()}
	</div>
	<div class="z-formrow">
		{formlabel for='cid' __text='Church:'}
		{formdropdownlist id="cid" size="1" mandatory=true items=$cids selectedValue=$myform->getCid()}
	</div>
	<div class="z-formrow">
		{formlabel for='time' __text='Time:'}
		{formtextinput id="time" maxLength=300 mandatory=true text=$myform->getTimeFormatted()}
	</div>
	<div class="z-formrow">
		{formlabel for='Minis_requested' __text='Who many ministrants are reqested?'}
		{formtextinput id="Minis_requested" maxLength=300 mandatory=true text=$myform->getMinis_requested()}
		<div class="z-informationmsg"><p>{gt text="If you put in an 0, it is an voluntarily worship."}</p></div>
	</div>
	<div class="z-formrow">
		{formlabel for='info' __text='Infos:'}
		{formtextinput id="info" maxLength=300 mandatory=false text=$myform->getInfo()}
	</div>
	</fieldset>
	<div class="z-formbuttons z-buttons">
		   {formbutton class="z-bt-ok" commandName="save" __text="Save"}
		   {formbutton class="z-bt-cancel" commandName="cancel" __text="Cancel"}
	   </div>
{/form}
{include file='Admin/Footer.tpl'}
