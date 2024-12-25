
jQuery( document ).on(
	'click',
	'li.wc_payment_method',
	function(){
		jQuery( document.body ).trigger( "update_checkout" );
	}
);

var af_ig_front_nonce=af_ig_php_vars.nonce;
var getshippingData = '';
var getpaymentData = '';
let debounceTimeout;

jQuery(document).ready(function($) {


jQuery( document ).on(
	'click',
	'.wc-block-checkout__use-address-for-billing',
	function(){
        setTimeout(() => {
        wp.apiFetch({ path: '/wc/store/cart' }).then(posts => {
            getshippingData = wooSelectedShipping();
            getpaymentData = wooSelectedPaymentMethod();
            debouncedAfCspBlockGetCheckoutDetails(posts.shipping_address, posts.billing_address, getshippingData, getpaymentData,posts.payment_methods);

        });
    }, 1000);
	}
);
    setTimeout(() => {

        wp.apiFetch({ path: '/wc/store/cart' }).then(posts => {
            getshippingData = wooSelectedShipping();
            getpaymentData = wooSelectedPaymentMethod();
            debouncedAfCspBlockGetCheckoutDetails(posts.shipping_address, posts.billing_address, getshippingData, getpaymentData,posts.payment_methods);

        });

    
        wp.hooks.addAction('experimental__woocommerce_blocks-checkout-set-shipping-address', 'a-cm-cart-block', handleHook);
        wp.hooks.addAction('experimental__woocommerce_blocks-checkout-set-billing-address', 'a-cm-cart-block', handleHook);
        wp.hooks.addAction('experimental__woocommerce_blocks-checkout-set-email-address', 'a-cm-cart-block', handleHook);
        wp.hooks.addAction('experimental__woocommerce_blocks-checkout-set-selected-shipping-rate', 'a-cm-cart-block', handleHook);
        wp.hooks.addAction('experimental__woocommerce_blocks-checkout-set-active-payment-method', 'a-cm-cart-block', handleHook);
		

    }, 1000);

});

function handleHook(checkout_form) {
			
    getshippingData = wooSelectedShipping();
    getpaymentData = wooSelectedPaymentMethod();
    debouncedAfCspBlockGetCheckoutDetails(
        checkout_form.storeCart.shippingAddress,
        checkout_form.storeCart.billingAddress,
        getshippingData,
        getpaymentData,
        checkout_form.storeCart.paymentMethods
    );
}


function wooSelectedShipping() {
    const selectedOption = jQuery('#shipping-option input[type="radio"]:checked');
    if (selectedOption.length) {
        return selectedOption.closest('label').find('.wc-block-components-radio-control__label').text();
    } else {
        return 'no_shipping_selected';
    }
}

function wooSelectedPaymentMethod() {
    const selectedPaymentOption = jQuery('#payment-method .wc-block-components-radio-control__input[type="radio"]:checked');
    if (selectedPaymentOption.length) {
        const paymentId = selectedPaymentOption.attr('id');
        return paymentId.split('-').pop();
    } else {
        return 'no_payment_selected';
    }
}

let lastAjaxRequest;

function sendCheckoutDetails(checkoutDetails,paymentMethods) {
	jQuery('#radio-control-wc-payment-method-options-invoice').closest('.wc-block-components-radio-control-accordion-option').show();
				jQuery('.af_ig_block_error').hide();
    // Abort the previous AJAX request if it's still pending
    if (lastAjaxRequest && lastAjaxRequest.readyState !== 4) {
        lastAjaxRequest.abort();
    }

    // Make the new AJAX request and store it in the variable
    lastAjaxRequest = jQuery.ajax({
        url: af_ig_php_vars.admin_url,
        type: 'POST',
        data: {
            action: 'af_ig_block_process_checkout_details',
            checkoutDetails: checkoutDetails,
            nonce:af_ig_front_nonce

        },
        success: function(response) {

            if (response.data.invoicecheck == 'hideinvoice') {
                jQuery('#radio-control-wc-payment-method-options-invoice').closest('.wc-block-components-radio-control-accordion-option').hide();
            
				if (checkPaymentMethods(paymentMethods)) {
					

					
					// Check if the error notice already exists
					if (jQuery('.af_ig_block_error').length === 0) {

						const svgIcon = `
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false">
							<path d="M12 3.2c-4.8 0-8.8 3.9-8.8 8.8 0 4.8 3.9 8.8 8.8 8.8 4.8 0 8.8-3.9 8.8-8.8 0-4.8-4-8.8-8.8-8.8zm0 16c-4 0-7.2-3.3-7.2-7.2C4.8 8 8 4.8 12 4.8s7.2 3.3 7.2 7.2c0 4-3.2 7.2-7.2 7.2zM11 17h2v-6h-2v6zm0-8h2V7h-2v2z"></path>
						</svg>`;
						
						// Create the HTML with the SVG icon and error message
						const noticeHTML = `<div class="af_ig_block_error wc-block-components-notice-banner is-error">${svgIcon} ${response.data.invoiceerror}</div>`;


						// Insert the notice HTML if it doesn't already exist
						jQuery('.wc-block-checkout__payment-method .wc-block-components-notices').html(noticeHTML);
					}

					jQuery('.af_ig_block_error').show();

				}

			} 
			
        },
        error: function(xhr, status, error) {
            if (status !== 'abort') { // Ignore errors from aborted requests
             
            }
        }
    });
}


function afcspblockgetcheckoutdetails(Shipping_details, Billing_details, ShippingMethod, getpaymentData,paymentMethods) {
    var $checkbox = jQuery('.wc-block-checkout__use-address-for-billing #checkbox-control-0');
    var checkoutDetails;

    if ($checkbox.is(':checked')) {
        checkoutDetails = {
            "shipping": Shipping_details,
            "billing": Shipping_details,
            "shippingMethod": ShippingMethod,
            "paymentMethod": getpaymentData
        };
    } else {
        checkoutDetails = {
            "shipping": Billing_details,
            "billing": Billing_details,
            "shippingMethod": ShippingMethod,
            "paymentMethod": getpaymentData
        };
    }


sendCheckoutDetails(checkoutDetails,paymentMethods);


  
}


function debouncedAfCspBlockGetCheckoutDetails(shippingAddress, billingAddress, shippingMethod, paymentMethod,avaliblePaymentOptions) {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(function() {
        afcspblockgetcheckoutdetails(shippingAddress, billingAddress, shippingMethod, paymentMethod,avaliblePaymentOptions);
    }, 100); // Adjust debounce time as needed
}

function checkPaymentMethods(paymentMethods) {
	if (Array.isArray(paymentMethods) && paymentMethods.length === 1 && paymentMethods[0] === "invoice") {
		return true;
	}
	return false;
}