<?php

if ( ! class_exists( 'AF_I_N_V_CUSTOMER_Mail' ) ) {
	// code...
	class AF_I_N_V_CUSTOMER_Mail extends WC_Email {


		public $object;

		public function __construct() {

			$plain_text    = 'plain' == $this->get_email_type() ? true : false;
			$sent_to_admin = false;

			$email = get_option( 'admin_email' );
			$order = $this->object;

			$this->id             = 'af_inv_customer_email_id'; // Unique ID to Store Emails Settings
			$this->title          = __( 'Addify Invoice Email for Customer', 'Addify_rs' ); // Title of email to show in Settings
			$this->customer_email = true; // Set true for customer email and false for admin email.
			$this->description    = __( 'This will send a pdf to customers', 'Addify_rs' ); // description of email
			$this->template_base  = AF_IG_PLUGIN_DIR; // Base directory of template
			$this->template_html  = '/include/email-template/html/af_inv_customer_mail_html.php'; // HTML template path
			$this->template_plain = '/include/email-template/plain/af_inv_customer_mail_plain.php'; // Plain template path
			$this->placeholders   = array( // Placeholders/Variables to be used in email
				'{site_url}'     => '',
				'{Site_title}'   => '',
				'{order_number}' => '',
			);
			// Call to the  parent constructor.
			parent::__construct(); // Must call constructor of parent class
			// Trigger function  for this customer email cancelled order.
			add_action( 'addify_refer_share_email_notification', array( $this, 'trigger' ), 10, 2 ); // action hook(s) to trigger email
		}

		// Step 3: change default subject of email by overriding the parent class method
		// Ex.

		public function get_default_subject() {
			return __( '{site_title}#New Invoice Order#{order_number}', 'Addify_rs' );
		}

		// Step 4: change default heading of email by overriding the parent class method

		public function get_default_heading() {
			return __( 'Order Number#{order_number}', 'Addify_rs' );
		}

		// Step 5: Must over ride trigger method to replace your placeholders and send email

		public function trigger( $order ) {

			$order = wc_get_order( $order );

			$this->object = $order;

			$this->object = $order;

			if ( ! $order || is_wp_error( $order ) ) {

				return;
			}
			$billing_email = $order->get_billing_email();
			$site_title    = get_bloginfo( 'url' );
			$this->setup_locale();
			$this->placeholders['{site_url}'] = $site_title;

			$this->placeholders['{order_date}']   = wc_format_datetime( $order->get_date_created() );
			$this->placeholders['{order_number}'] = $order->get_order_number();

			if ( $this->is_enabled() ) {
				$this->send( $billing_email, $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
			}

			$this->restore_locale();
		}
		public function get_attachments() {

			$files = array();

			if ( $this->object ) {

				$files = af_ig_attach_pdf_to_emails_new_order( $this->object );

			}

			return apply_filters( 'woocommerce_email_attachments', $files, $this->id, $this->object, $this );
		}

		// Step 6: Override the get_content_html method to add your template of html email

		public function get_content_html() {
			return wc_get_template_html(
				$this->template_html,
				array(
					'member'             => $this->object,
					'order'              => $this->object,
					'email_heading'      => $this->get_heading(),
					'additional_content' => $this->get_additional_content(),
					'sent_to_admin'      => false,
					'plain_text'         => false,
					'email'              => $this,
				),
				$this->template_base,
				$this->template_base
			);
		}
		// Note: Path and default path in wc_get_template_html() can be defined as, path is defined path to over-ride email template and default path is path to your plugin template.
		// Read more about wc_get_template and wc_locate_template() to understand the over-riding templates in WooCommerce.
		// Step 7: Override the get_content_plain method to add your template of plain email


		public function get_content_plain() {

				return wc_get_template_html(
					$this->template_plain,
					array(
						'member'             => $this->object,
						'order'              => $this->object,
						'email_heading'      => $this->get_heading(),
						'additional_content' => $this->get_additional_content(),
						'sent_to_admin'      => false,
						'plain_text'         => true,
						'email'              => $this,
					),
					$this->template_base,
					$this->template_base
				);
		}
	}
}
