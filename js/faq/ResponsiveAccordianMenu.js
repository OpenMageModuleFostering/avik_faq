var jQuery = jQuery.noConflict();
jQuery(window).load(function() {
	
	var divs = jQuery('.expandContent'),
	content = divs.children('div');
	
	// hide all divs initially
	content.hide();
	
	// drop down menu - on change show the selected div
	jQuery('#SelectMenu').on('change', function() {
	  content.hide();
	  showDiv(this.value);
	});

	// function that shows the selected div
	function showDiv(divID) {
		jQuery(".styled option").removeClass("selected");
		jQuery(".styled option").removeAttr("style");
		var thisContent = jQuery('#'+divID).find('.expandedContent')
		if (jQuery(thisContent).is(':visible')) {
			thisContent.slideUp("slow");
			jQuery('#'+divID).find('.header .expand img').attr('src', 'plus.png');
			jQuery('#'+divID+' .icon').removeClass('minus');
			jQuery('#'+divID+' .icon').addClass('plus');
		}
		else {
			content.not(thisContent).slideUp("slow", function() {
				jQuery('#'+divID).parent().find('.header .expand img').attr('src', 'plus.png');
				jQuery('.icon').removeClass('minus');
				jQuery('.icon').addClass('plus');
			});
			thisContent.slideDown("slow", function() {
				// scroll to selected div
				jQuery('html, body').animate({
					scrollTop: jQuery("#"+divID).offset().top
				}, 500);
				
				// change drop down menu's selected option  
				jQuery('#SelectMenu').val(divID);
				jQuery('#SelectMenu option[value="'+divID+'"]').addClass("selected");
				
				//change + icon to -
				jQuery('#'+divID).find('.header .expand img').attr('src', 'minus.png');
				
				jQuery('#'+divID+' .icon').removeClass('plus');
				jQuery('#'+divID+' .icon').addClass('minus');
			});
		}
	}	
	
	// on click show the selected div
	divs.click(function() {
		showDiv(jQuery(this).attr('id'));
	});	
});
