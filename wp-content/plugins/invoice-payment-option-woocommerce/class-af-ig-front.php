<?php

require AF_IG_PLUGIN_DIR . 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (!defined('ABSPATH')) {
	die;
}

class AF_IG_Front {

	public function __construct() {
		include AF_IG_PLUGIN_DIR . 'vendor/autoload.php';
		add_action('wp_enqueue_scripts', array( $this, 'af_ig_front_assets' ), 10);
		add_filter('woocommerce_email_attachments', array( $this, 'attach_pdf_to_emails_new_order' ), 10, 3);
		add_action('woocommerce_checkout_order_created', array( $this, 'send_custom_emails_on_new_order' ), 10, 1);
		add_filter('woocommerce_my_account_my_orders_actions', array( $this, 'af_ig_add_download_pdf_button' ), 10, 2);
		add_action('init', array( $this, 'af_ig_handle_pdf_download' ));
		add_action('wp_footer', array( $this, 'af_ig_handle_block_validation_session' ));

		add_action('woocommerce_store_api_checkout_update_order_from_request', array( $this, 'send_custom_emails_on_new_order_for_blocks' ), 10, 2);
	}

	public function send_custom_emails_on_new_order_for_blocks( $order, $request ) {

		WC()->session->set( 'af_ig_payment_method_validation_block_check', 'hide_val' );

		$af_ig_payment_method_validation_block = WC()->session->get( 'af_ig_payment_method_validation_block' );
		
		if (!empty($af_ig_payment_method_validation_block)) {
	
			$af_ig_block_validation_message ='' . __('Select a Valid Payment Method', 'af_ig_td');


			wc_add_notice($af_ig_block_validation_message, 'error');    
			return;  

		}

		// $order = wc_get_order($order_id);

		if (empty($order )) {

			return;
		}

		
	// Check if payment method is invoice
		if ($order && $order->get_payment_method() == 'invoice') {

			$af_inv_enable_admin_email = get_option('af_inv_enable_admin_email');

			// Attach PDF and send admin email
			if ('yes'== $af_inv_enable_admin_email) {
				$this->send_admin_email_with_pdf($order);
			}
			// Attach PDF and send customer email
			$af_inv_enable_customer_email = get_option('af_inv_enable_customer_email');
			if ('yes'==$af_inv_enable_customer_email) {
				$this->send_customer_email_with_pdf($order);
			}
		}
	}

	public function af_ig_handle_block_validation_session() {
		
		WC()->session->set( 'af_ig_payment_method_validation_block_check', '');
	}

	public function send_custom_emails_on_new_order( $order ) {

				
	// $order = wc_get_order($order_id);
		if (empty($order )) {

			return;
		}

	// Check if payment method is invoice
		if ($order && $order->get_payment_method() == 'invoice') {

			$af_inv_enable_admin_email = get_option('af_inv_enable_admin_email');

			// Attach PDF and send admin email
			if ('yes'== $af_inv_enable_admin_email) {
				$this->send_admin_email_with_pdf($order);
			}
			// Attach PDF and send customer email
			$af_inv_enable_customer_email = get_option('af_inv_enable_customer_email');
			if ('yes'==$af_inv_enable_customer_email) {
				$this->send_customer_email_with_pdf($order);
			}
		}
	}

	public function send_admin_email_with_pdf( $order ) {
	// Triggering the admin email
		WC()->mailer()->emails['af_inv_admin_email_id']->trigger($order->get_id(), $order);
		$attachments = af_ig_attach_pdf_to_emails_new_order($order); 
		return !empty($attachments);
	}

	public function send_customer_email_with_pdf( $order ) {
	// Triggering the customer email
		WC()->mailer()->emails['af_inv_customer_email_id']->trigger($order->get_id(), $order);
	// Attach PDF to the customer email
		$attachments = af_ig_attach_pdf_to_emails_new_order($order); 

	// Check if the PDF attachment was successfully added
		return !empty($attachments);
	}

	public function attach_pdf_to_emails_new_order( $attachments, $email_id, $order ) {

		$order_new = wc_get_order($order->get_id());

		if (empty($order_new )) {

			return;
		}
		 
		if ($order && $order->get_payment_method() == 'invoice' && 'yes' == get_option('af_invoice_enable_pdf')) { 
			$af_invoice_template = get_option('af_invoice_template') ? get_option('af_invoice_template') : 'temp1';
			ob_start();
			include AF_IG_PLUGIN_DIR . 'templates/pdf/' . $af_invoice_template;
			$af_invoice_pdf = ob_get_clean();

			$options = new Options();
			$options->set('isPhpEnabled', true);
			$options->set('isRemoteEnabled', true);
			$options->set('defaultPaperSize', 'letter');
			$options->set('isHtml5ParserEnabled', true);

			$dompdf = new Dompdf($options);
			$dompdf->loadHtml($af_invoice_pdf);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();

			$output     = $dompdf->output();
			$upload_dir = wp_upload_dir();
			$directory  = trailingslashit($upload_dir['basedir']) . 'invoice-payment-option-woocommerce/';
			wp_mkdir_p($directory);
			$pdf_file = $directory . 'invoice-' . $order->get_id() . '.pdf'; 

			if (file_exists($pdf_file)) {
				unlink($pdf_file);
			} 
			file_put_contents($pdf_file, $output);

			$attachments[ $order->get_id() ] = $pdf_file;
		}

		return $attachments;
	}

	public function af_ig_front_assets() {
		if (( is_checkout() )||( WC_Blocks_Utils::has_block_in_page( wc_get_page_id('checkout'), 'woocommerce/checkout' ) )) {

			wp_enqueue_script('wp-api-fetch'); // Enqueue the apiFetch package
			wp_enqueue_style('af_ig-front', plugins_url('/include/css/af_ig_front.css', __FILE__), false, '1.0');
			wp_enqueue_style('af_ig-select2', plugins_url('/include/css/select2.css', __FILE__), false, '1.0');
			wp_enqueue_style('af_ig-attachment', plugins_url('/include/css/attachment.css', __FILE__), false, '1.0');
			wp_enqueue_script('af_ig-select2', plugins_url('/include/js/select2.js', __FILE__), array( 'jquery' ), '4.1.0', true);
			wp_enqueue_script('af_ig-front', plugins_url('/include/js/af_ig_front.js', __FILE__), array( 'jquery', 'af_ig-select2' ), '1.0.0', true);

		

			$af_ig_data = array(
				'admin_url' => admin_url('admin-ajax.php'),
				'nonce'     => wp_create_nonce('af-ig-ajax-nonce'),
			);
			wp_localize_script('af_ig-front', 'af_ig_php_vars', $af_ig_data);

		} 
	}

	public function af_ig_handle_pdf_download() {
		if (isset($_GET['download_pdf']) && isset($_GET['_wpnonce']) && wp_verify_nonce(sanitize_text_field($_GET['_wpnonce'] ), 'af_ig_generate_pdf')) {
			$order_id = absint($_GET['download_pdf']);
		
			if ($order_id) {
				$order = wc_get_order($order_id);
				if ($order && 'invoice' == $order->get_payment_method()) {
			  
				$this->af_ig_generate_pdf_for_order($order);
				exit;
				}
			}
		}
	}

	public function af_ig_add_download_pdf_button( $actions, $order ) {
 
		$order_status = $order->get_status();

		$EnablePDF = get_option('af_invoice_enable_pdf');
	
  
		if ('invoice' === $order->get_payment_method() && 'refunded' !== $order_status) {
			$order_id = $order->get_id();

			if ('yes' == $EnablePDF) {
				$actions['download_pdf'] = array(
					'url'  => wp_nonce_url(add_query_arg(array( 'download_pdf' => $order_id )), 'af_ig_generate_pdf'),
					'name' => __('Download PDF', 'af_ig_td'),
				);
			}
		}
	
		return $actions;
	}

	public function af_ig_generate_pdf_for_order( $order ) {

		$af_invoice_template = get_option( 'af_invoice_template' ) ? get_option( 'af_invoice_template' ) : 'temp1';

		ob_start();

		include AF_IG_PLUGIN_DIR . 'templates/pdf/' . $af_invoice_template; 
		$af_invoice_pdf = ob_get_clean();

		$options = new \Dompdf\Options();
		$options->set('isPhpEnabled', true);
		$options->set('isRemoteEnabled', true);
		$options->set('defaultPaperSize', 'A4');  
		$options->set('isHtml5ParserEnabled', true);

   
		$dompdf = new \Dompdf\Dompdf($options);

 
		$dompdf->loadHtml($af_invoice_pdf);

 
		$dompdf->setPaper('A4', 'portrait');

  
		$dompdf->render();

   
		$filename = 'invoice-' . $order->get_id() . '.pdf';

  
		$dompdf->stream($filename, array( 'Attachment' => true )); 

  
		exit;
	}
}

if (class_exists('AF_IG_Front')) {
	new AF_IG_Front();
}
