jQuery(function() {
	jQuery("#go-to-services").click(() => {
		jQuery('html, body').animate({
			scrollTop: jQuery('#services-container').offset().top - 50
		}, 900,'swing');
	}) 

	jQuery('[name="merchant-buy-now"], .single_add_to_cart_button').wrap('<div style="display: flex; justify-content: flex-end;"></div>');
	scrollToMainSection();

	//let quantityContainer = jQuery(".woocommerce div.product .wc-block-add-to-cart-form form.cart .quantity");

	//if(/^\?product=(day-to-dusk|item-removal|virtual-staging)$/.test(window.document.location.search)) {
	//	quantityContainer.detach().appendTo(".number-of-files-to-deliver");
	//} else if(/^\?product=satellite-marketing-video$/.test(window.document.location.search)){
	//	quantityContainer.hide();
	//}
});

function scrollToMainSection() {
	let visited = window.localStorage.getItem("visited");
	if(visited && !!jQuery('#services-container')) {
		jQuery('html, body').animate({
			scrollTop: jQuery('#services-container').offset().top - 50
		}, 900,'swing');
		return false;
		
	} else {
		window.localStorage.setItem("visited", true);
	}
}