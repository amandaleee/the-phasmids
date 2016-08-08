/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens and enables tab
 * support for dropdown menus.
 */
jQuery(function( $ ){

	$("header .nav > ul").addClass("responsive-nav").before('<div class="icon-responsive-nav"></div>');

	$(".icon-responsive-nav").click(function(){
		$(this).next("header .nav > ul").slideToggle(150);
		$(this).toggleClass("open");
	});

	$(window).resize(function(){
		if(window.innerWidth > 767) {
			$("header .nav > ul, .sub-menu").removeAttr("style");
			$(".responsive-nav .menu-item").removeClass("menu-open");
		}
	});

	$(".responsive-nav .menu-item").click(function(event){
		if (event.target !== this)
		return;
		$(this).find(".sub-menu:first").slideToggle(150, function() {
			$(this).parent().toggleClass("menu-open");
		});
	});

});