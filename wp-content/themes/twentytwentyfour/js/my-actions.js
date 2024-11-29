jQuery(function() {
	jQuery("#go-to-services").click(() => {
		jQuery('html, body').animate({
			scrollTop: jQuery('#services-container').offset().top - 50
		}, 900,'swing');
	}) 

	jQuery('[name="merchant-buy-now"], .single_add_to_cart_button').wrap('<div style="display: flex; justify-content: flex-end;"></div>');
	scrollToMainSection();

	console.log(document.location);
});

function scrollToMainSection() {
	let visited = window.localStorage.getItem("visited");
	if(visited) {
		console.log(jQuery('#services-container').offset())
		jQuery('html, body').animate({
			scrollTop: jQuery('#services-container').offset().top - 50
		}, 900,'swing');
		return false;
		
	} else {
		window.localStorage.setItem("visited", true);
	}
}