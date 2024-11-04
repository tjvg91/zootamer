<?php

require AF_IG_PLUGIN_DIR . 'vendor/autoload.php';

// Reference the Dompdf namespace.
use Dompdf\Dompdf;
// Reference the Options namespace.
use Dompdf\Options;
// Reference the Font Metrics namespace.
use Dompdf\FontMetrics;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}
class AF_IG_Front {


	public function __construct() {
		include AF_IG_PLUGIN_DIR . 'vendor/autoload.php';

		add_action( 'wp_enqueue_scripts', array( $this, 'af_ig_front_assests' ), 10 );
		add_filter( 'woocommerce_email_attachments', array( $this, 'attach_pdf_to_emails_new_order' ), 10, 3 );
		add_action( 'woocommerce_checkout_order_created', array( $this, 'send_custom_emails_on_new_order' ), 10, 1 );
	}


	public function send_custom_emails_on_new_order( $order_id ) {
		// Assuming $variation_id is the ID of your product variation
		$variation = wc_get_product( $variation_id );

		// Assuming $order_id is the ID of the order
		$order = wc_get_order( $order_id );

		// Check if both $variation and $order are valid objects
		if ( $variation && $order ) {
			// Get the payment method used for the order
			$payment_method = $order->get_payment_method();

			// Check if the payment method is 'invoice'
			if ( 'invoice' === $payment_method ) {
				$af_inv_enable_admin_email = get_option( 'af_inv_enable_admin_email' );

				// Attach PDF and send admin email
				if ( 'yes' == $af_inv_enable_admin_email ) {
					$this->send_admin_email_with_pdf( $order );
				}
				// Attach PDF and send customer email
				$af_inv_enable_customer_email = get_option( 'af_inv_enable_customer_email' );
				if ( 'yes' == $af_inv_enable_customer_email ) {
					$this->send_customer_email_with_pdf( $order );
				}
			}
		}
	}

	public function send_admin_email_with_pdf( $order ) {
		// Triggering the admin email
		WC()->mailer()->emails['af_inv_admin_email_id']->trigger( $order->get_id(), $order );
		$attachments = af_ig_attach_pdf_to_emails_new_order( $order );
		return ! empty( $attachments );
	}

	public function send_customer_email_with_pdf( $order ) {
		// Triggering the customer email
		WC()->mailer()->emails['af_inv_customer_email_id']->trigger( $order->get_id(), $order );
		// Attach PDF to the customer email
		$attachments = af_ig_attach_pdf_to_emails_new_order( $order );

		// Check if the PDF attachment was successfully added
		return ! empty( $attachments );
	}





	public function attach_pdf_to_emails_new_order( $attachments, $email_id, $order ) {
		// Check if the email is for new order and payment method is invoice
		$variation = wc_get_product( $variation_id );

		// Assuming $order_id is the ID of the order
		$order = wc_get_order( $order_id );

		// Check if both $variation and $order are valid objects
		if ( $variation && $order ) {
			// Get the payment method used for the order
			$payment_method = $order->get_payment_method();

			// Check if the payment method is 'invoice'
			if ( 'invoice' === $payment_method ) {

				if ( 'yes' == get_option( 'af_invoice_enable_pdf' ) && $order ) {

					$af_invoice_template = get_option( 'af_invoice_template' ) ? get_option( 'af_invoice_template' ) : 'temp1';

					ob_start();
					include AF_IG_PLUGIN_DIR . 'templates/pdf/' . $af_invoice_template;
					$af_invoice_pdf = ob_get_clean();

					$options = new Options();
					$options->set( 'isPhpEnabled', 'true' );
					$options->set( 'isRemoteEnabled', true );
					$options->set( 'defaultPaperSize', 'letter' );
					$options->set( 'isHtml5ParserEnabled', true );

					// Instantiate dompdf class.
					$dompdf = new Dompdf( $options );

					// Load HTML content.
					$dompdf->loadHtml( $af_invoice_pdf );

					// (Optional) Setup the paper size and orientation.
					$dompdf->setPaper( 'A4', 'Portrait' );

					// Render the HTML as PDF.
					$dompdf->render();

					// Instantiate canvas instance.
					$canvas = $dompdf->getCanvas();

					$canvas = $dompdf->getCanvas();

					// Instantiate font metrics class.
					$fontMetrics = new FontMetrics( $canvas, $options );

					// Get height and width of page.
					$w = $canvas->get_width();
					$h = $canvas->get_height();

					// Get font family file.
					$font = $fontMetrics->getFont( 'times' );

					$output = $dompdf->output();

					$basedir   = wp_upload_dir()['basedir'];
					$directory = $basedir . '/invoice-payment-option-woocommerce/';

					wp_mkdir_p( $directory );

					$pdfs = $directory . 'invoice-' . $order->get_id() . '-.pdf';

					if ( file_exists( $pdfs ) ) {
						unlink( $pdfs );
					}

					file_put_contents( $pdfs, $output );

					$attachments[] = $pdfs;

				}
			}
		}
		return $attachments;
	}


	public function af_ig_front_assests() {
		// Enqueue Styles.
		wp_enqueue_style( 'af_ig-front', plugins_url( '/include/css/af_ig_front.css', __FILE__ ), false, '1.0' );
		wp_enqueue_style( 'af_ig-select2', plugins_url( '/include/css/select2.css', __FILE__ ), false, '1.0' );
		wp_enqueue_style( 'af_ig-attachment', plugins_url( '/include/css/attachment.css', __FILE__ ), false, '1.0' );
		// Enqueue Scripts.
		// Enqueue Select2 script first, as 'af_ig-front' script depends on it.
		wp_enqueue_script( 'af_ig-select2', plugins_url( '/include/js/select2.js', __FILE__ ), array( 'jquery' ), '4.1.0', true );
		wp_enqueue_script( 'af_ig-front', plugins_url( '/include/js/af_ig_front.js', __FILE__ ), array( 'jquery', 'af_ig-select2' ), '1.0.0', true );

		// Localize the variables.
		$af_ig_data = array(
			'admin_url' => admin_url( 'admin-ajax.php' ),
			'nonce'     => wp_create_nonce( 'af-ig-ajax-nonce' ),
		);
		wp_localize_script( 'af_ig-front', 'af_ig_php_vars', $af_ig_data );
	}
}

if ( class_exists( 'AF_IG_Front' ) ) {
	new AF_IG_Front();
}
