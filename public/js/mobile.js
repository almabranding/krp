jQuery(document).ready(function($) {

	$(".menu_button").click(function(e) {
    
        e.preventDefault();
        $('.navMobile').slideToggle('slow');
    
    });
	
});
