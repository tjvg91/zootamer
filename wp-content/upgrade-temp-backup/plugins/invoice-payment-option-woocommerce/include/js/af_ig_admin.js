
jQuery('document').ready( function($) {
var horizontaldata=af_ig_ajax_var.invoicedata;
var upload_pdf_icon=af_ig_ajax_var.upload_pdf_icon;
jQuery('.af_invoice_template').closest('td').html(horizontaldata);
jQuery('.af_invoice_custom_icon').closest('td').html(upload_pdf_icon);


	'use strict';

	$('.af-ig-select2').select2();
	
} );
(function ( $ ) {
	'use strict';
	$(
		function () {
			var ajaxurl = af_ig_ajax_var.admin_url;
			var nonce   = af_ig_ajax_var.nonce;

			// Search customers.
			$('.af_ig_ajax_customer_search').select2(
			{
				ajax: {
					url: ajaxurl, // AJAX URL is predefined in WordPress admin.
					dataType: 'json',
					type: 'POST',
					delay: 250, // Delay in ms while typing when to perform a AJAX search.
					data: function (params) {
						return {
							q: params.term, // Search query.
							action: 'af_ig_search_users', // AJAX action for admin-ajax.php.
							nonce: nonce // AJAX nonce for admin-ajax.php.
						};
					},
					processResults: function ( data ) {
						var options = [];
						if (data ) {

							// Data is the array of arrays, and each of them contains ID and the Label of the option.
							$.each(
								data, function ( index, text ) {
									// Do not forget that "index" is just auto incremented value.
									options.push({ id: text[0], text: text[1]  });
								}
								);
						}
						return {
							results: options
						};
					},
					cache: true
				},
				multiple: true,
				placeholder: 'Choose Users',
				minimumInputLength: 3 // The minimum of symbols to input before perform a search.

			});

			//Search Products
			jQuery('.af-ig-ajax-products-search').select2(
			{
				ajax: {
					url: ajaxurl, // AJAX URL is predefined in WordPress admin.
					dataType: 'json',
					type: 'POST',
					delay: 250, // Delay in ms while typing when to perform a AJAX search.
					data: function (params) {
						return {
							q: params.term, // search query
							action: 'af_ig_search_products', // AJAX action for admin-ajax.php.
							nonce: nonce // AJAX nonce for admin-ajax.php.
						};
					},
					processResults: function ( data ) {
						var options = [];
						if (data ) {

								 // data is the array of arrays, and each of them contains ID and the Label of the option.
							$.each(
								data, function ( index, text ) {
										// do not forget that "index" is just auto incremented value.
									options.push({ id: text[0], text: text[1]  });
								}
								);

						}
						return {
							results: options
						};
					},
					cache: true
				},
				multiple: true,
				placeholder: 'Choose Products',
				minimumInputLength: 3 // the minimum of symbols to input before perform a search.

			}
			);

		}
		);

})(jQuery);
jQuery(document).ready(function($) {
    // Function to handle click event
    $(document).on('click', '.af_invoice_templates', function() {
        // Remove any existing blue borders
        $('.af_invoice_templates').removeClass('selected');
        // Add blue border to the clicked element
        $(this).addClass('selected');
        // Show the text "Activated"
        $('.activation_text').text('Activated');
        // Mark the corresponding option as checked
        $(this).find('.af_inv_step_style').prop('checked', true);

        // Check if clicked element has value "temp1.php"
    	fill_pdf_color_fields();


    });
    fill_pdf_color_fields();

   function fill_pdf_color_fields() {
    var selectedValue = $('.af_inv_step_style:checked').val();
    console.log(selectedValue);
    
    if (selectedValue === 'temp1.php') {
        $('#af_invoice_header_color, #af_invo_pro_table, #af_inv_footer_backgrond_color').each(function() {
            // if (!$(this).val()) {
            if (!$(this).data('db_value')) {

                $(this).val('#1765f6');
                $(this).closest('td').find('span.colorpickpreview').css('background-color', '#1765f6');
            }
        });
        $('#af_invoice_header_text_color, #af_invo_pro_table_text, #af_inv_footer_text_color').each(function() {
            // if (!$(this).val()) {
            if (!$(this).data('db_value')) {

                $(this).val('#ffffff');
                $(this).closest('td').find('span.colorpickpreview').css('background-color', '#ffffff');
            }
        });
    } else if (selectedValue === 'temp2.php') {
    	console.log('aaaaa');
        $('#af_invoice_header_color, #af_invo_pro_table, #af_inv_footer_backgrond_color').each(function() {
            // if (!$(this).val()) {
            if (!$(this).data('db_value')) {

                $(this).val('#43e3f8');
                $(this).closest('td').find('span.colorpickpreview').css('background-color', '#43e3f8');
            }
        });
        $('#af_invoice_header_text_color, #af_invo_pro_table_text, #af_inv_footer_text_color').each(function() {
            // if (!$(this).val()) {
            if (!$(this).data('db_value')) {

                $(this).val('#121111');
                $(this).closest('td').find('span.colorpickpreview').css('background-color', '#121111');
            }
        });
    } else if (selectedValue === 'temp3.php') {
        $('#af_invoice_header_color, #af_invo_pro_table, #af_inv_footer_backgrond_color').each(function() {
            // if (!$(this).val()) {
            if (!$(this).data('db_value')) {

                $(this).val('#20e361');
                $(this).closest('td').find('span.colorpickpreview').css('background-color', '#20e361');
            }
        });
        $('#af_invoice_header_text_color, #af_invo_pro_table_text, #af_inv_footer_text_color').each(function() {
            // if (!$(this).val()) {
            if (!$(this).data('db_value')) {

                $(this).val('#121111');
                $(this).closest('td').find('span.colorpickpreview').css('background-color', '#121111');
            }
        });
    }
}


    // Check if any option is saved initially
    $('.af_inv_step_style:checked').closest('.af_invoice_templates').addClass('selected');
    $('.af_inv_step_style:checked').closest('.af_invoice_templates').find('.activation_text').text('Activated');

    // Function to handle option selection
    $(document).on('change', '.af_inv_step_style', function() {
        // Remove any existing blue borders
        $('.af_invoice_templates').removeClass('selected');
        // If the option is selected, add blue border to the corresponding element
        if ($(this).is(':checked')) {
            // Add blue border to the corresponding element
            $(this).closest('.af_invoice_templates').addClass('selected');
            // Show the text "Activated"
            $(this).closest('.af_invoice_templates').find('.activation_text').text('Activated');
        } else {
            // Hide the text if the option is not selected
            $('.activation_text').text('');
        }
    });
});







jQuery(document).ready(
	function($) {
		"use strict";
		af_ig_products();
		jQuery( document ).on('click','.af_ig_products', function(e) {

		 af_ig_products();
		}); 
	});


function af_ig_products() {
	jQuery('.hide_ig_setting_pro').each(function(){jQuery(this).closest('tr').show()});
	if (jQuery('.af_ig_products').is(":checked")) {
		jQuery('.hide_ig_setting_pro').each(function(){jQuery(this).closest('tr').hide()});

	}
}

jQuery(document).ready(function ($) {
    $(document).on('click', '#upload-btn', function () {
        var image = wp.media({
            title: 'Upload Image',
            multiple: false
        }).open()
        .on('select', function () {
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $('#af_invoice_upload_icon').val(image_url);
            $('#af_invoice_upload_icon_img').attr("src", image_url);
        });
    });

});

jQuery(document).ready(function() {
    // Function to show or hide the field based on the checkbox state
    function toggleFieldVisibility() {
        if (jQuery('#af_invoice_customize_theme').is(':checked')) {
            jQuery('#af_invoice_header_color, #af_invoice_header_text_color, #af_invo_pro_table, #af_invo_pro_table_text, #af_inv_footer_backgrond_color, #af_inv_footer_text_color').closest('tr').show();
        } else {
            jQuery('#af_invoice_header_color, #af_invoice_header_text_color, #af_invo_pro_table, #af_invo_pro_table_text, #af_inv_footer_backgrond_color, #af_inv_footer_text_color').closest('tr').hide(); 
        }
    }

    // Load the saved state of the checkbox when the page is loaded
    var isChecked = localStorage.getItem('af_invoice_customize_theme_checked');
    if (isChecked === 'true') {
        jQuery('#af_invoice_customize_theme').prop('checked', true);
    } else {
        jQuery('#af_invoice_customize_theme').prop('checked', false);
    }
    toggleFieldVisibility(); // Show or hide the fields based on the loaded state

    // Toggle field visibility when checkbox is clicked
    jQuery('#af_invoice_customize_theme').click(function() {
        toggleFieldVisibility(); // Show or hide the fields based on the checkbox state
        // Save the state of the checkbox
        localStorage.setItem('af_invoice_customize_theme_checked', jQuery(this).is(':checked'));
    });
});



