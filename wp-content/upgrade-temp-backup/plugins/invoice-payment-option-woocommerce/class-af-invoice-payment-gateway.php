<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class Af_Inovice_Pyament_Gateway extends WC_Payment_Gateway {
	public $instructions;
	public $order_status;
	public function __construct() {
		$this->setup_properties();
		$this->init_form_fields();
		$this->title        = $this->get_option( 'title' );
		$this->description  = $this->get_option( 'description' );
		$this->instructions = $this->get_option( 'instructions' );
		$this->order_status = $this->get_option( 'order_status' );
		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		add_action( 'woocommerce_thankyou_invoice', array( $this, 'af_ig_thankyou_page' ) );
	}

	protected function setup_properties() {
		$this->id                 = 'invoice';
		$this->method_title       = __( 'Invoice Payments', 'af_ig_td' );
		$this->method_description = __( 'Allows invoice payments.', 'af_ig_td' );
		$this->has_fields         = false;
	}

	public function init_form_fields() {
		$this->form_fields = array(
			'enabled'      => array(
				'title'   => __( 'Enable/Disable', 'af_ig_td' ),
				'type'    => 'checkbox',
				'label'   => __( 'Enable Invoice Payment', 'af_ig_td' ),
				'default' => 'yes',
			),
			'title'        => array(
				'title'       => __( 'Title', 'af_ig_td' ),
				'type'        => 'text',
				'description' => __( 'Title during checkout.', 'af_ig_td' ),
				'default'     => __( 'Invoice Payment', 'af_ig_td' ),
				'desc_tip'    => true,
			),
			'description'  => array(
				'title'       => __( 'Description', 'af_ig_td' ),
				'type'        => 'textarea',
				'description' => __( 'Payment method description during checkout.', 'af_ig_td' ),
				'default'     => __( 'Thank you for your order.', 'af_ig_td' ),
				'desc_tip'    => true,
			),
			'instructions' => array(
				'title'       => __( 'Instructions', 'af_ig_td' ),
				'type'        => 'textarea',
				'description' => __( 'Instructions that will be added to the thank you page.', 'af_ig_td' ),
				'default'     => __( 'you will be invoiced soon with regards to payment.', 'af_ig_td' ),
				'desc_tip'    => true,
			),
			'order_status' => array(
				'title'             => __( 'Choose an order status', 'af_ig_td' ),
				'type'              => 'select',
				'class'             => 'wc-enhanced-select',
				'default'           => 'on-hold',
				'description'       => __( 'Choose the order status that will be set after checkout', 'af_ig_td' ),
				'options'           => $this->af_ig_get_order_status(),
				'desc_tip'          => true,
				'custom_attributes' => array(
					'data-placeholder' => __( 'Select order status', 'af_ig_td' ),
				),
			),
		);
	}

	protected function af_ig_get_order_status() {
		$af_ig_all_order = wc_get_order_statuses();
		$keys            = array_map(
			function ( $key ) {
				return str_replace( 'wc-', '', $key );
			},
			array_keys( $af_ig_all_order )
		);
		$status          = array_combine( $keys, $af_ig_all_order );
		unset( $status['cancelled'] );
		unset( $status['refunded'] );
		unset( $status['failed'] );
		return $status;
	}

	public function process_payment( $order_id ) {

		$order = wc_get_order( $order_id );
		$order->update_status( apply_filters( 'wc_invoice_gateway_process_payment_order_status', $this->order_status ), __( 'Awaiting invoice payment', 'af_ig_td' ) );
		wc_reduce_stock_levels( $order_id );
		WC()->cart->empty_cart();
		return array(
			'result'   => 'success',
			'redirect' => $this->get_return_url( $order ),
		);
	}

	public function af_ig_thankyou_page() {
		if ( $this->instructions ) {
			echo wp_kses_post( $this->instructions );
		}
	}
}
