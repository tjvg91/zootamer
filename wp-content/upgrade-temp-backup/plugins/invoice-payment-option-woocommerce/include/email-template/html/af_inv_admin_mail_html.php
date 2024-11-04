<?php
defined( 'ABSPATH' ) || exit;
/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email );


// $plain = 'plain' == $this->get_email_type() ? true : false;

// wc()->mailer()->order_details($this->order_object, true, false , $email );


do_action( 'woocommerce_email_order_details', $order, true, $plain, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, true, $plain, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, true, $plain, $email );


/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );

}

do_action( 'woocommerce_email_footer', $email );
