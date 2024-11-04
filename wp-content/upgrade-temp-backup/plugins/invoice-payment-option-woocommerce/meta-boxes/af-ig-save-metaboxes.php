<?php
/**
 * Save Invoice-gateway Meta
 *
 * Save the data of all meta boxes i.e. virtual, Location, Cart Conditions, users and Shipping
 *
 * @package  addify-invoice-gateway/meta-boxes
 * @version  1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
}

			// if our current user can't edit this post, bail
if ( ! current_user_can( 'edit_posts' ) ) {
	return;
}
		// For custom post type:
		$exclude_statuses = array(
			'auto-draft',
			'trash',
		);

		$post_action = isset( $_GET['action'] ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : '';

		if ( ! in_array( get_post_status( $post_id ), $exclude_statuses ) && ! is_ajax() && 'untrash' != $post_action ) {
			if ( ! empty( $_POST['af_ig_field_nonce'] ) ) {

				$retrieved_nonce = sanitize_text_field( $_POST['af_ig_field_nonce'] );
			} else {
					$retrieved_nonce = 0;
			}

			if ( ! wp_verify_nonce( $retrieved_nonce, 'af_ig_nonce_action' ) ) {

					die( 'Failed Security Check!' );
			}

			/**
			 * Shipping Meta Box.
			 *
			 * Save invoice-payment amount, invoice-payment Type, Enable Tax, Include in cart amount.
			 */

			// invoice-payment Amount.
			if ( isset( $_POST['af_ig_fee_amount'] ) ) {
				update_post_meta( $post_id, 'af_ig_fee_amount', sanitize_text_field( wp_unslash( $_POST['af_ig_fee_amount'] ) ) );
			}

			// invoice Type.
			if ( isset( $_POST['af_ig_fee_type'] ) ) {
				update_post_meta( $post_id, 'af_ig_fee_type', sanitize_text_field( wp_unslash( $_POST['af_ig_fee_type'] ) ) );
			}

			// Enable All Products.
			if ( isset( $_POST['af_ig_enable_products'] ) ) {
				update_post_meta( $post_id, 'af_ig_enable_products', sanitize_text_field( wp_unslash( $_POST['af_ig_enable_products'] ) ) );
			} else {
				update_post_meta( $post_id, 'af_ig_enable_products', sanitize_text_field( 'no' ) );
			}

			// Enable Tax.
			if ( isset( $_POST['af_ig_enable_tax'] ) ) {
				update_post_meta( $post_id, 'af_ig_enable_tax', sanitize_text_field( wp_unslash( $_POST['af_ig_enable_tax'] ) ) );
			} else {
				update_post_meta( $post_id, 'af_ig_enable_tax', sanitize_text_field( 'no' ) );
			}

			/**
			 * Location for invoice.
			 *
			 * Save Countries, States, Zip Codes, Cities.
			 */

			// invoice-payment on Shipping zones.
			if ( isset( $_POST['af_ig_shipping_zone'] ) ) {
				update_post_meta( $post_id, 'af_ig_shipping_zone', wp_json_encode( sanitize_meta( '', wp_unslash( $_POST['af_ig_shipping_zone'] ), '' ) ) );
			} else {
				update_post_meta( $post_id, 'af_ig_shipping_zone', wp_json_encode( array() ) );
			}

			// invoice-payment Countries.
			if ( isset( $_POST['af_ig_countries'] ) ) {
				update_post_meta( $post_id, 'af_ig_countries', wp_json_encode( sanitize_meta( '', wp_unslash( $_POST['af_ig_countries'] ), '' ) ) );
			} else {
				update_post_meta( $post_id, 'af_ig_countries', wp_json_encode( array() ) );
			}

			// invoice-payment States.
			if ( isset( $_POST['af_ig_states'] ) ) {
				update_post_meta( $post_id, 'af_ig_states', wp_json_encode( sanitize_meta( '', wp_unslash( $_POST['af_ig_states'] ), '' ) ) );
			} else {
				update_post_meta( $post_id, 'af_ig_states', wp_json_encode( array() ) );
			}

			// Enable Zip Codes.
			if ( isset( $_POST['af_ig_zip_codes'] ) ) {
				update_post_meta( $post_id, 'af_ig_zip_codes', sanitize_text_field( wp_unslash( $_POST['af_ig_zip_codes'] ) ) );
			}

			// invoice-payment Cities.
			if ( isset( $_POST['af_ig_cities'] ) ) {
				update_post_meta( $post_id, 'af_ig_cities', sanitize_text_field( wp_unslash( $_POST['af_ig_cities'] ) ) );
			}

			/**
			 * Cart conditions for invoice-payment.
			 *
			 * Save Cart Amount, Products and Product Categories.
*/

			// invoice-payment on Cart Amount.
			if ( isset( $_POST['af_ig_cart_amount'] ) ) {
				update_post_meta( $post_id, 'af_ig_cart_amount', wp_json_encode( sanitize_meta( '', wp_unslash( $_POST['af_ig_cart_amount'] ), '' ) ) );
			}
			// invoice-payment on Cart quantity.
			if ( isset( $_POST['af_ig_cart_quantity'] ) ) {
				update_post_meta( $post_id, 'af_ig_cart_quantity', wp_json_encode( sanitize_meta( '', wp_unslash( $_POST['af_ig_cart_quantity'] ), '' ) ) );
			}

			// invoice-payment for Products.
			if ( isset( $_POST['af_ig_cart_products'] ) ) {
				update_post_meta( $post_id, 'af_ig_cart_products', wp_json_encode( sanitize_meta( '', wp_unslash( $_POST['af_ig_cart_products'] ), '' ) ) );
			}

			// invoice-payment for product Categories.
			if ( isset( $_POST['af_ig_cart_products_cat'] ) ) {
				update_post_meta( $post_id, 'af_ig_cart_products_cat', wp_json_encode( sanitize_meta( '', wp_unslash( $_POST['af_ig_cart_products_cat'] ), '' ) ) );
			} else {

				update_post_meta( $post_id, 'af_ig_cart_products_cat', wp_json_encode( array() ) );
			}
			// invoice-payment for product tags.
			if ( isset( $_POST['af_ig_cart_products_tag'] ) ) {
				update_post_meta( $post_id, 'af_ig_cart_products_tag', wp_json_encode( sanitize_meta( '', wp_unslash( $_POST['af_ig_cart_products_tag'] ), '' ) ) );
			} else {

				update_post_meta( $post_id, 'af_ig_cart_products_tag', wp_json_encode( array() ) );
			}
			// invoice-payment for shipping.
			if ( isset( $_POST['af_ig_shipping'] ) ) {
				update_post_meta( $post_id, 'af_ig_shipping', wp_json_encode( sanitize_meta( '', wp_unslash( $_POST['af_ig_shipping'] ), '' ) ) );
			} else {

				update_post_meta( $post_id, 'af_ig_shipping', wp_json_encode( array() ) );
			}
			// invoice-payment for user Shipping Classes.
			if ( isset( $_POST['af_ig_shipping_classes'] ) ) {
				update_post_meta( $post_id, 'af_ig_shipping_classes', wp_json_encode( sanitize_meta( '', wp_unslash( $_POST['af_ig_shipping_classes'] ), '' ) ) );
			}

			/**
			 * Users for invoice-payment.
			 *
			 * Save users and user roles.
*/

			// invoice-payment on users.
			if ( isset( $_POST['af_ig_customer_select'] ) ) {
				update_post_meta( $post_id, 'af_ig_customer_select', wp_json_encode( sanitize_meta( '', wp_unslash( $_POST['af_ig_customer_select'] ), '' ) ) );
			} else {
				update_post_meta( $post_id, 'af_ig_customer_select', wp_json_encode( array() ) );
			}

			// invoice-payment for user roles.
			if ( isset( $_POST['af_ig_customer_roles'] ) ) {
				update_post_meta( $post_id, 'af_ig_customer_roles', wp_json_encode( sanitize_meta( '', wp_unslash( $_POST['af_ig_customer_roles'] ), '' ) ) );
			} else {
				update_post_meta( $post_id, 'af_ig_customer_roles', wp_json_encode( array() ) );
			}
		}
