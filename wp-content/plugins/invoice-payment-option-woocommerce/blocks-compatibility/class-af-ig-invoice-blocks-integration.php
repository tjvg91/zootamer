<?php

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;
final class Af_Ig_Invoice_Integration extends AbstractPaymentMethodType {

	private $gateway;
	protected $name = 'invoice';
	public function initialize() {
		$this->settings = get_option( 'woocommerce_invoice_settings', array() );
		$this->gateway  = new Af_Inovice_Pyament_Gateway();
	}
	public function is_active() {
	return $this->gateway->is_available();
	}

	public function get_payment_method_script_handles() {
		wp_register_script(
		'af-ig-blocks-integration',
		plugin_dir_url(__FILE__) . '/src/index.js',
		array(
			'wc-blocks-registry',
			'wc-settings',
			'wp-element',
			'wp-html-entities',
			'wp-i18n',
		),
		null,
		true
	);

		return array( 'af-ig-blocks-integration' );
	}
	public function get_payment_method_data() {
		return array(
			'title'       => $this->gateway->title,
			'description' => $this->gateway->description,
		);
	}
}
