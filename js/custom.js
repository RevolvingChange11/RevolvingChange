(function($) {
	
	"use strict";

	$(document).ready(function(){
		
	});
	
	$(window).scroll(function(){
	
	});
	
	/* ## Window Load - Handler for .load() called */
	$(window).on("load",function() {
		$("#siteloader").delay(1000).fadeOut("slow");
	});
	
})(jQuery);



 // Header Profile Dropdown
 $(".profile-dropdown").hide();
$(".profile-menu a").click(function(){
  $(".profile-dropdown").slideToggle();
});