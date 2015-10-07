/* 
 * Toggles side mobile menu on or off
 */
jQuery(document).ready(function($){
	$(".mobile-menu").click(function(){
    // Calling a function in case you want to expand upon this.
    toggleNav();
  });

	function toggleNav() {
	if ($('.site-wrapper').hasClass('show-nav')) {
		// Do things on Nav Close
		$('.site-wrapper').removeClass('show-nav');
	} else {
		// Do things on Nav Open
		$('.site-wrapper').addClass('show-nav');
	}

	//$('#site-wrapper').toggleClass('show-nav');
	}
	
});

/* 
 * Toggles search on and off
 */
jQuery(document).ready(function($){
	$(".search-mobile").click(function(){
		$("#search-container").slideToggle('slow', function(){
			$('.search-mobile').toggleClass('active');
		});
		// Optional return false to avoid the page "jumping" when clicked
		return false;
	});

	$(".search-not-mobile").click(function(){
		$("#search-container").slideToggle('slow', function(){
			$('.search-not-mobile').toggleClass('active');
		});
		// Optional return false to avoid the page "jumping" when clicked
		return false;
	});	
		
});