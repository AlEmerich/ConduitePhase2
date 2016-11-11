$(document).ready(function(){
    
    $("#buttonToToggleIn").click(function(){
	$("#toToggleIn").toggle("fast");
	$("#toggleiconin").toggleClass("fa-toggle-down");
	$("#toggleiconin").toggleClass("fa-toggle-up");
    });

    $("#buttonToToggleNotIn").click(function(){
	$("#toToggleNotIn").toggle("fast");
	$("#toggleiconnotin").toggleClass("fa-toggle-down");
	$("#toggleiconnotin").toggleClass("fa-toggle-up");
    });

    $("#buttonToToggleAll").click(function(){
	$("#toToggleAll").toggle("fast");
	$("#toggleiconall").toggleClass("fa-toggle-down");
	$("#toggleiconall").toggleClass("fa-toggle-up");
    });
});
