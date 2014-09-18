$(document).ready(function() {
	
	$('.popup-box').live('click', function(e) {
		/* Stop the link working normally on click if it's linked to a popup */
		e.stopPropagation();
	});

	$('.close').live('click', function() {
		var scrollPos = $(window).scrollTop();
		/* Hide the popup and blackout when clicking outside the popup */
		$('.popup-box').hide();
		$('#blackout').hide();
		$("html,body").css("overflow","auto");
		$('html').scrollTop(scrollPos);
		$('.popup-box').remove();

	});
});

function centerBox(width) {
	/* Preliminary information */
	var winWidth	= $(window).width() + 20;
	var winHeight	= $(document).height();
	var scrollPos	= $(window).scrollTop();
	var boxWidth	= width;
	/* auto scroll bug */
	/* Calculate positions */
	var disWidth	= (winWidth - boxWidth) / 2;
	var disHeight	= scrollPos + 20;
	/* Move stuff about */
    $('#blackout').css({'width' : winWidth+'px', 'height' : winHeight+'px', 'overflow' : 'auto'});
    $('.popup-box').css({'width' : boxWidth+'px', 'left' : disWidth+'px', 'top' : disHeight+'px'});
	return false;
}

function showPopup(popupId) {
	$('body').append('<div id="blackout"></div>');

	$(window).resize(centerBox);
	$(window).scroll(centerBox);

//	centerBox($(popupId).find('form').width());
    centerBox($(popupId).width());
	var scrollPos = $(window).scrollTop();
	/* Show the correct popup box, show the blackout and disable scrolling */
    $('#blackout').show();
    $(popupId).show();
	$('html,body').css('overflow', 'hidden');
	/* Fixes a bug in Firefox */
	$('html').scrollTop(scrollPos);
};


