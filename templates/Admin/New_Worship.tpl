{pageaddvar name="javascript" value="jquery-ui"}
{pageaddvar name="stylesheet" value="javascript/jquery-ui/themes/base/jquery-ui.css"}
{pageaddvar name="javascript" value="modules/Miniplan/javascript/WorshipForm.js"}
<script language="javaScript">
function New_Date(f)
{  
	//read number
	var indate_num = parseInt(document.getElementById("indate_num").value);
	indate_num = indate_num+1;
	
	//create z-formrow
	var my_div = document.createElement('div');
	my_div.setAttribute("id", "datediv"+indate_num);
	my_div.setAttribute("class", "z-formrow");
	document.getElementById("felds").appendChild(my_div);
	
	//create label
	var label = document.createElement('label');
	label.setAttribute("for", "text");
	label.setAttribute("id", "label"+indate_num);
	document.getElementById("datediv"+indate_num).appendChild(label);
	document.getElementById("label"+indate_num).innerHTML = "Date "+(indate_num)+":";
	
	//create input
	var feld = document.createElement('input');
	feld.setAttribute("type", "text");
	feld.setAttribute("name", "indate"+indate_num);
	feld.setAttribute("id", "indate"+indate_num);
	feld.setAttribute("onChange", "New_Date(this.form)");
	document.getElementById("datediv"+indate_num).appendChild(feld);
	
	//set function to last input
	var last_id = indate_num-1;
	var last_input = document.getElementById("indate"+last_id);
	last_input.setAttribute("onChange", "");
	
	//initialize datepicker
	id_datepicker("indate"+indate_num);
	
	//save number
	document.getElementById("indate_num").value = indate_num;
}
function id_datepicker(id)
{
	jQuery( "#"+id ).datepicker();
	jQuery( "#"+id ).datepicker( "option", "dateFormat", "dd'. 'M'. 'yy" );
}
jQuery(function() {
	id_datepicker("indate0");
});
</script>

{include file='Admin/Header.tpl' __title='Calendar' icon='config'}
{form cssClass="z-form"}
	<fieldset>
	<div class="z-formrow">
        {formlabel for='wfid' __text='Form:'}
		{formdropdownlist id="wfid" size="1" mandatory=true items=$forms selectedValue=0 onchange="WorshipForm_load(document.getElementById('wfid').value)"}
	</div>
	<div class="z-formrow">
		{formlabel for='cid' __text='Church:'}
		{formdropdownlist id="cid" size="1" mandatory=true items=$cids selectedValue=0}
	</div>
	<div class="z-formrow">
		{formlabel for='time' __text='Time:'}
		{formtextinput id="time" maxLength=300 mandatory=true text=""}
	</div>
	<div class="z-formrow">
		{formlabel for='Minis_requested' __text='Who many ministrants are reqested?'}
		{formtextinput id="Minis_requested" maxLength=300 mandatory=true text=""}
		<div class="z-informationmsg"><p>{gt text="If you put in an 0, it is an voluntarily worship."}</p></div>
	</div>
	<div class="z-formrow">
		{formlabel for='info' __text='Infos:'}
		{formtextinput id="info" maxLength=300 mandatory=false text=""}
	</div>
	<a onclick="saveForm(prompt('{gt text='Name for this form'}','{gt text='New Form'}'))">{gt text="save form"}</a>
	</fieldset>
	
	<fieldset>
		<div id=felds>
			<div class="z-formrow">
		    	<label for="text">{gt text='Date'} 0:</label>
				<input type="text" name="indate0" id="indate0"  onChange="New_Date(this.form)"/>
			</div>
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
