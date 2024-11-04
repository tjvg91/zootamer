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

function af_ig_attach_pdf_to_emails_new_order( $order ) {
		$attachments = array();

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

		if ( file_exists( $directory . 'invoice-' . $order->get_id() . '-.pdf' ) ) {
			unlink( $directory . 'invoice-' . $order->get_id() . '-.pdf' );
		}

		wp_mkdir_p( $directory );

		$pdfs = $directory . 'invoice-' . $order->get_id() . '-.pdf';

		if ( file_exists( $pdfs ) ) {
			unlink( $pdfs );
		}

		file_put_contents( $pdfs, $output );

		$attachments[] = $pdfs;

	}

		return $attachments;
}
