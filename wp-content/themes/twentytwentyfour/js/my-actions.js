jQuery(function() {
	jQuery("#go-to-services").click(() => {
		jQuery('html, body').animate({
			scrollTop: jQuery('#services-container').offset().top - 50
		}, 900,'swing');
	}) 
	
	jQuery('.woocommerce div.product form.cart div.quantity, [name="is-descendent-of-single-product-block"], .single_add_to_cart_button')
		.wrapAll('<div class="quantity-cart-container" style="display: flex; justify-content: flex-end;"></div>');
	scrollToMainSection();

	let quantityContainer = jQuery(".woocommerce div.product form.cart div.quantity");

	if(/^\?product=(day-to-dusk|item-removal|virtual-staging)$/.test(window.document.location.search)) {
		quantityContainer.css("cssText", "");
	} else if(/^\?product=satellite-marketing-video$/.test(window.document.location.search)){
		quantityContainer.css("cssText", "display: none !important");
	}
});

function scrollToMainSection() {
	let visited = window.localStorage.getItem("visited");
	const serviceContainer = jQuery('#services-container')
	if(visited && !!serviceContainer.top) {
		jQuery('html, body').animate({
			scrollTop: jQuery('#services-container').offset().top - 50
		}, 900,'swing');
		return false;
		
	} else {
		window.localStorage.setItem("visited", true);
	}
}