$(document).ready(function(){
    $('#ddl').click(function(e){ 
	e.stopPropagation();
	if ( $( "#ulsprints" ).is( ":hidden" ) ) {
	    $( "#ulsprints" ).show( "fast" );
	    $("#ulsprints").addClass("ex");
	} 
	else {
	    $( "#ulsprints" ).slideUp();
	}
    });

    $(window).on('click', function(e) {
	
	$( "#ulsprints" ).slideUp();
    });
});
