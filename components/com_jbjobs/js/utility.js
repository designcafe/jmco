var $j = jQuery.noConflict();
pic1 = new Image(16, 16); 
pic1.src = "loader.gif";

$j(document).ready(function(){

$j("#username").change(function() { 

var usr = $j("#username").val(); 

if(usr.length >= 3)
{
$j("#status").html('<img align="absmiddle" src="'+baseUrl+'components/com_jbjobs/images/loader.gif" /> Checking availability...');

$j.ajax({ 
type: "POST", 
url: "index.php?option=com_jbjobs&task=checkuser", 
data: "username="+ usr, 
success: function(msg){ 

$j("#status").ajaxComplete(function(event, request, settings){ 
if(msg == 'OK')
{ 
	$j("#username").removeClass('object_error'); // if necessary
	$j("#username").addClass("object_ok");
	$j(this).html(' <img align="absmiddle" src="'+baseUrl+'components/com_jbjobs/images/accepted.png" width="16"/> Username available ');
} 
else 
{ 
	$j("#username").removeClass('object_ok'); // if necessary
	$j("#username").addClass("object_error");
	$j(this).html(msg);
}});}});}
else
{
	$j("#status").html('The username should have at least 3 characters.');
	$j("#username").removeClass('object_ok'); // if necessary
	$j("#username").addClass("object_error");
}});

$j("#email").change(function() { 

var email = $j("#email").val(); 

$j("#statusemail").html('<img align="absmiddle" src="'+baseUrl+'components/com_jbjobs/images/loader.gif" /> Checking availability...');

$j.ajax({ 
type: "POST", 
url: "index.php?option=com_jbjobs&task=checkuser", 
data: "email="+ email, 
success: function(msg){ 

$j("#statusemail").ajaxComplete(function(event, request, settings){ 
if(msg == 'OK')
{ 
	$j("#email").removeClass('object_error'); // if necessary
	$j("#email").addClass("object_ok");
	$j(this).html(' <img align="absmiddle" src="'+baseUrl+'components/com_jbjobs/images/accepted.png" width="16"/>');
} 
else 
{ 
	$j("#email").removeClass('object_ok'); // if necessary
	$j("#email").addClass("object_error");
	$j(this).html(msg);
}});}});
});

});

function lookup(){
	var inputstr = $j("#ug_university").val(); 
	//alert(inputstr.length);
	
	if(inputstr.length == 0) { 
		// Hide the suggestion box.
		$j('#suggestions').hide();
	}else {
		$j.ajax({
		type: "POST",
		url: "index.php?option=com_jbjobs&task=searchsuggest", 
		data: "inputstr="+inputstr+"&type=ug",
		success: function(msg){ 
			if(msg.length >0) {
				$j('#suggestions').show();
				$j('#autoSuggestionsList').html(msg);
			}
		}});
	}
}

function lookuppg(){

	var inputstr = $j("#pg_university").val(); 
	if(inputstr.length == 0) { 
		// Hide the suggestion box.
		$j('#suggestionspg').hide();
	}else {
		$j.ajax({
		type: "POST",
		url: "index.php?option=com_jbjobs&task=searchsuggest", 
		data: "inputstr="+inputstr+"&type=pg", 
		success: function(msg){ 
			if(msg.length >0) {
				$j('#suggestionspg').show();
				$j('#autoSuggestionsListpg').html(msg);
			}
		}});
	}
}

function fill(thisValue) {
	$j('#ug_university').val(thisValue);
	setTimeout("$j('#suggestions').hide();", 200);
}

function fillpg(thisValue) {
	$j('#pg_university').val(thisValue);
	setTimeout("$j('#suggestionspg').hide();", 200);
}

/* Tips 2 */
window.addEvent('domready', function(){ 
var Tips2 = new Tips($$('.tooltip'), {
	className: 'tooltip',
	initialize:function(){
		this.fx = new Fx.Style(this.toolTip, 'opacity', {duration: 500, wait: false}).set(0);
	},
	onShow: function(toolTip) {
		this.fx.start(1);
	},
	onHide: function(toolTip) {
		this.fx.start(0);
	}
});
});