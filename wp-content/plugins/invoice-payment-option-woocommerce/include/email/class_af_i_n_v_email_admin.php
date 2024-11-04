<?php


// require_once WP_PLUGIN_DIR . '/woocommerce/includes/emails/class-wc-email.php';
// require_once WP_PLUGIN_DIR . '/woocommerce/includes/emails/class-wc-email-new-order.php';

if ( ! class_exists( 'AF_I_N_V_ADMIN_Mail' ) ) {
	// code...
	class AF_I_N_V_ADMIN_Mail extends WC_Email {

		public $object;

		public function __construct() {

			$plain_text    = 'plain' == $this->get_email_type() ? true : false;
			$sent_to_admin = true;

			$email = get_option( 'admin_email' );
			

			$this->id             = 'af_inv_admin_email_id'; // Unique ID to Store Emails Settings
			$this->title          = __( 'Addify Invoice Email for Admin', 'Addify_rs' ); // Title of email to show in Settings
			$this->customer_email = false; // Set true for customer email and false for admin email.
			$this->description    = __( 'This will send a pdf to admin', 'Addify_rs' ); // description of email
			$this->template_base  = AF_IG_PLUGIN_DIR; // Base directory of template
			$this->template_html  = '/include/email-template/html/af_inv_admin_mail_html.php'; // HTML template path
			$this->template_plain = '/include/email-template/plain/af_inv_admin_mail_plain.php'; // Plain template path
			$this->placeholders   = array( // Placeholders/Variables to be used in email
				'{site_url}'     => '',
				'{Site_title}'   => '',
				'{order_date}'   => '',
				'{order_number}' => '',
				'{order_id}'     => '',
				// '{order_items}'  => '',
				// '{customer_details}' => '',

			);
			$this->subject = __( '{site_title} #New Invoice Order#{order_number}', 'Addify_rs' ); // Title of email to show in Settings

			$this->recipient = $this->get_option( 'recipient', get_option( 'admin_email' ) );

			// Call to the  parent constructor.
			parent::__construct(); // Must call constructor of parent class
			// Trigger function  for this customer email cancelled order.
			add_action( 'addify_refer_share_email_notification', array( $this, 'trigger' ), 10, 1 ); // action hook(s) to trigger email
		}

		// Step 3: change default subject of email by overriding the parent class method
		// Ex.
		public function get_default_subject() {
			return __( '{site_title} #New Invoice Order#{order_number}', 'Addify_rs' );

			$AF_WC_Email_New_Order = new WC_Email_New_Order();

			return $AF_WC_Email_New_Order->get_default_subject();
		}

		// Step 4: change default heading of email by overriding the parent class method

		public function get_default_heading() {

			$AF_WC_Email_New_Order = new WC_Email_New_Order();
			// return __('New Invoice Order', 'Addify_rs');
			return $AF_WC_Email_New_Order->get_default_heading();
		}

		// Step 5: Must over ride trigger method to replace your placeholders and send email

		public function trigger( $order_id, $order ) {

			$email = get_option( 'admin_email' );

			// $AF_WC_Email_New_Order =  new WC_Email_New_Order();
			// return $AF_WC_Email_New_Order->trigger($order_id , $order );

			// $AF_WC_Email_New_Order->object                         = $order;

			// $plain = 'plain' == $this->get_email_type() ? true : false;
			
			$this->placeholders['{order_date}']   = wc_format_datetime( $order->get_date_created() );
			$this->placeholders['{order_number}'] = $order->get_order_number();

			$this->object = $order;
			if ( ! $order || is_wp_error( $order ) ) {
				echo 'Invalid order or error occurred.';
				return;
			}
			$site_title = get_bloginfo( 'url' );
			$this->setup_locale();
			$this->placeholders['{site_url}'] = $site_title;

			if ( $this->is_enabled() ) {

				$this->send( $email, $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
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
			// $AF_WC_Email_New_Order =  new WC_Email_New_Order();
			// return $AF_WC_Email_New_Order->get_content_html();
			return wc_get_template_html(
				$this->template_html,
				array(
					'member'             => $this->object,
					'order'              => $this->object,
					'email_heading'      => $this->get_heading(),
					'additional_content' => $this->get_additional_content(),
					'sent_to_admin'      => true,
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
						'sent_to_admin'      => true,
						'plain_text'         => true,
						'email'              => $this,
					),
					$this->template_base,
					$this->template_base
				);
		}
	}
}
