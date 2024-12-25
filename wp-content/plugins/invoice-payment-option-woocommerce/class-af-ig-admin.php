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
class AF_IG_Admin {

	public function __construct() {
		add_action( 'add_meta_boxes_payment_gateway', array( $this, 'Af_ig_payment_gateway_meta_boxes' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'af_ig_admin_assests' ), 10 );
		add_action( 'save_post', array( $this, 'af_ig_save_metadata' ), 10, 2 );
		add_action( 'wp_ajax_af_ig_search_users', array( $this, 'af_ig_search_users' ) );
		add_action( 'wp_ajax_af_ig_search_products', array( $this, 'af_ig_search_products' ) );
		add_action( 'admin_menu', array( $this, 'add_submenu_in_woocommerce' ) );

		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'filter_woocommerce_settings_tabs_array' ), 99 );
		add_action( 'woocommerce_sections_invoice-custom-tab-pdf', array( $this, 'action_woocommerce_sections_invoice_custom_tab_for_pdf' ), 10 );
		add_action( 'woocommerce_settings_invoice-custom-tab-pdf', array( $this, 'action_woocommerce_settings_invoice_custom_tab_for_pdf' ), 10 );
		add_action( 'woocommerce_settings_save_invoice-custom-tab-pdf', array( $this, 'action_woocommerce_settings_save_invoice_custom_tab_for_pdf' ), 10 );

		add_action( 'admin_init', array( $this, 'af_inf_template_email' ) );

		add_action( 'woocommerce_email_attachments', array( $this, 'attach_pdf_invoice_to_order_email_on_save' ), 10, 3 );
	}

	public function attach_pdf_invoice_to_order_email_on_save( $attachments, $email_id, $order ) {

		$order_new = wc_get_order($order->get_id());

		if (empty($order_new )) {

			return;
		}

		$payment_method = $order->get_payment_method();
		if ( 'invoice' === $payment_method ) {
			if ( 'yes' == get_option( 'af_invoice_enable_pdf' ) ) {
					$af_invoice_template = get_option( 'af_invoice_template' ) ? get_option( 'af_invoice_template' ) : 'temp1';

					ob_start();
					include AF_IG_PLUGIN_DIR . 'templates/pdf/' . $af_invoice_template;
					$af_invoice_pdf = ob_get_clean();

				$options = new Options();
				$options->set( 'isPhpEnabled', 'true' );
				$options->set( 'isRemoteEnabled', true );
				$options->set( 'defaultPaperSize', 'letter' );
				$options->set( 'isHtml5ParserEnabled', true );

					$dompdf = new Dompdf( $options );
					$dompdf->loadHtml( $af_invoice_pdf );
					$dompdf->setPaper( 'A4', 'Portrait' );
					$dompdf->render();

					$output = $dompdf->output();

					$basedir   = wp_upload_dir()['basedir'];
					$directory = $basedir . '/invoice-payment-option-woocommerce/';

					wp_mkdir_p( $directory );

					$pdf_path = $directory . 'invoice-' . $order->get_id() . '.pdf';

				if ( file_exists( $pdf_path ) ) {
					unlink( $pdf_path );
				}

				file_put_contents( $pdf_path, $output );

				// Attach the PDF to the email
				$attachments[] = $pdf_path;

				return $attachments;
			}
		}
	}
	public function af_inf_template_email() {

		if ( ! class_exists( 'WC_Email', false ) ) {
			include_once dirname( WC_PLUGIN_FILE ) . '/includes/emails/class-wc-email.php';
		}
		include_once AF_IG_PLUGIN_DIR . '/include/email/class_af_i_n_v_email_customer.php';
		include_once AF_IG_PLUGIN_DIR . '/include/email/class_af_i_n_v_email_admin.php';
	}



	public function filter_woocommerce_settings_tabs_array( $settings_tabs ) {
		$settings_tabs['invoice-custom-tab-pdf'] = __( 'Invoice Payment Option', 'woocommerce' );

		return $settings_tabs;
	}

	public function action_woocommerce_sections_invoice_custom_tab_for_pdf() {

		global $current_section;
		$tab_id = 'invoice-custom-tab-pdf';
		// Must contain more than one section to display the links
		// Make first element's key empty ('')
		$sections = array(
			'general-setting' => __( 'General Setting', 'woocommerce' ),

		);
		$array_keys      = array_keys( $sections );
		$current_section = empty( $current_section ) ? 'general-setting' : $current_section;
		?>
<br class="clear" />
		<?php
	}

	public function get_custom_settings() {

		global $current_section;
		$settings = array();
		if ( 'general-setting' == $current_section ) {
			$settings = array(
				// Title
				array(
					'title' => __( 'General Setting', 'woocommerce' ),
					'type'  => 'title',
					'id'    => 'custom_settings14',
				),
				// Text

				// Select
				array(
					'title'       => __( 'Enable PDF ', 'woocommerce' ),
					'placeholder' => __( 'checked this checkedbox to enable pdf', 'af_ig_td' ),
					'type'        => 'checkbox',
					'id'          => 'af_invoice_enable_pdf',
					'class'       => 'af_invoice_enable_pdf',
				),
				array(
					'title'    => __( 'Choose style for PDF', 'woocommerce' ),
					'type'     => 'radio',
					'desc'     => __( 'Choose the PDF style', 'woocommerce' ),
					'desc_tip' => true,
					'id'       => 'af_invoice_template',
					'class'    => 'af_invoice_template',
					'options'  => array(
						'temp1.php' => 'Tempate1',
						'temp2.php' => 'Tempate2',
						'temp3.php' => 'Tempate3',
						'temp4.php' => 'Tempate4',

					),
				),
				array(
					'title'       => __( 'Upload icon for PDF', 'af_ig_td' ),
					'placeholder' => __( 'Text for button', 'af_ig_td' ),
					'type'        => 'text',
					'id'          => 'af_invoice_upload_icon',
					'class'       => 'af_invoice_custom_icon',
				),

				array(
					'title'    => __( 'Show company detail', 'af_ig_td' ),
					'desc'     => __( 'Check to show all company detail', 'af_ig_td' ),
					'desc_tip' => true,
					'type'     => 'checkbox',
					'id'       => 'af_invoice_comp_detail',
				),
				array(
					'title' => __( 'Invoice heading', 'af_ig_td' ),
					'type'  => 'text',
					'id'    => 'af_invoice_heading',
				),

				array(
					'title'    => __( 'Customize PDF theme', 'af_ig_td' ),
					'desc'     => __( 'Customize color scheme of your PDF theme', 'af_ig_td' ),
					'desc_tip' => true,
					'type'     => 'checkbox',
					'id'       => 'af_invoice_customize_theme',
				),

				array(
					'title'             => __( 'Background color of header', 'af_ig_td' ),
					'type'              => 'color',
					'desc'              => __( 'Set as background color for pdf', 'af_ig_td' ),
					'desc_tip'          => true,
					'id'                => 'af_invoice_header_color',
					'custom_attributes' => array( 'data-db_value' => get_option( 'af_invoice_header_color' ) ),

				),

				array(
					'title'             => __( 'Text color of header', 'af_ig_td' ),
					'type'              => 'color',

					'desc'              => __( 'Set as text color of pdf', 'woocommerce' ),
					'desc_tip'          => true,
					'id'                => 'af_invoice_header_text_color',
					'custom_attributes' => array( 'data-db_value' => get_option( 'af_invoice_header_color' ) ),

				),

				array(
					'title'             => __( 'Background color of product table', 'af_ig_td' ),
					'type'              => 'color',
					'desc'              => __( 'Background color of product table', 'woocommerce' ),
					'desc_tip'          => true,
					'id'                => 'af_invo_pro_table',
					'custom_attributes' => array( 'data-db_value' => get_option( 'af_invoice_header_color' ) ),

				),
				array(
					'title'             => __( 'Text color of product table', 'af_ig_td' ),
					'type'              => 'color',
					'desc'              => __( 'set text color of product table', 'woocommerce' ),
					'desc_tip'          => true,
					'id'                => 'af_invo_pro_table_text',
					'custom_attributes' => array( 'data-db_value' => get_option( 'af_invoice_header_color' ) ),

				),

				array(
					'title'             => __( 'Background color of footer', 'af_ig_td' ),
					'type'              => 'color',
					'desc'              => __( 'Background color of footer', 'woocommerce' ),
					'desc_tip'          => true,
					'id'                => 'af_inv_footer_backgrond_color',
					'custom_attributes' => array( 'data-db_value' => get_option( 'af_invoice_header_color' ) ),

				),

				array(
					'title'             => __( 'Text color of footer', 'af_ig_td' ),
					'type'              => 'color',
					'desc'              => __( 'text color of footer', 'woocommerce' ),
					'desc_tip'          => true,
					'id'                => 'af_inv_footer_text_color',
					'custom_attributes' => array( 'data-db_value' => get_option( 'af_invoice_header_color' ) ),

				),
				array(
					'title'    => __( 'Terms and conditions', 'af_ig_td' ),
					'type'     => 'text',
					'desc_tip' => true,
					'id'       => 'af_invo_footer_text',

				),
				array(
					'title'    => __( 'Show note', 'af_ig_td' ),
					'type'     => 'text',
					'desc'     => __( 'Note to show in footer', 'woocommerce' ),
					'desc_tip' => true,
					'id'       => 'af_inv_invoice_note',

				),

				array(
					'title'    => __( 'Separate email for customers', 'af_ig_td' ),
					'type'     => 'checkbox',
					'desc'     => __( 'Enable separate order email notification for customers when order is placed using invoice payment method', 'woocommerce' ),
					'desc_tip' => true,
					'id'       => 'af_inv_enable_customer_email',

				),

				array(
					'title'    => __( 'Separate email for admin', 'af_ig_td' ),
					'type'     => 'checkbox',
					'desc'     => __( 'Enable separate order email notification for admin when order is placed using invoice payment method', 'woocommerce' ),
					'desc_tip' => true,
					'id'       => 'af_inv_enable_admin_email',

				),

				// Section end
				array(
					'type' => 'sectionend',
					'id'   => 'custom_settings',
				),
			);

		}

		return $settings;
	}

	public function action_woocommerce_settings_invoice_custom_tab_for_pdf() {
		// Call settings function
		$settings = $this->get_custom_settings();
		WC_Admin_Settings::output_fields( $settings );
	}

	public function action_woocommerce_settings_save_invoice_custom_tab_for_pdf() {
		global $current_section;
		$tab_id          = 'invoice-custom-tab-pdf';
		$current_section = $current_section ? $current_section : 'general-setting';
		// Call settings function
		$settings = $this->get_custom_settings();
		WC_Admin_Settings::save_fields( $settings );
		if ( $current_section ) {
			WC_Admin_Settings::save_fields( $settings );
			do_action( 'woocommerce_update_options_' . $tab_id . '_' . $current_section );
		}
	}

	public function add_submenu_in_woocommerce() {

		add_submenu_page(
			'woocommerce',
			__( 'Invoice Payment', 'af_ig_td' ),
			__( 'Invoice Payment', 'af_ig_td' ),
			'manage_woocommerce',
			'edit.php?post_type=payment_gateway',
			'',
			30
		);
	}

	/**
	 * Search Products by Ajax.
	 *
	 * @return void
	 */
	public function af_ig_search_products() {

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : 0;
		if ( ! wp_verify_nonce( $nonce, 'af-ig-ajax-nonce' ) ) {
			die( 'Failed security check!' );
		}

		if ( isset( $_POST['q'] ) && '' !== $_POST['q'] ) {
			$pro = sanitize_text_field( wp_unslash( $_POST['q'] ) );
		} else {
			$pro = '';
		}

		$data_array = array();
		$args       = array(
			'post_type'   => array( 'product' ),
			'post_status' => 'publish',
			'numberposts' => -1,
			's'           => $pro,
		);
		$pros       = get_posts( $args );
		if ( ! empty( $pros ) ) {
			foreach ( $pros as $proo ) {
				$title            = ( mb_strlen( $proo->post_title ) > 50 ) ? mb_substr( $proo->post_title, 0, 49 ) . '...' : $proo->post_title;
					$data_array[] = array( $proo->ID, $title ); // array( Post ID, Post Title ).
			}
		}
			echo wp_json_encode( $data_array );
			die();
	}



		/**
		 * Search users by Ajax.
		 */
	public function af_ig_search_users() {

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : 0;
		if ( ! wp_verify_nonce( $nonce, 'af-ig-ajax-nonce' ) ) {
			die( 'Failed security check!' );
		}

		if ( isset( $_POST['q'] ) && '' !== $_POST['q'] ) {
			$pro = sanitize_text_field( wp_unslash( $_POST['q'] ) );
		} else {
			$pro = '';
		}
		$data_array  = array();
		$users       = new WP_User_Query(
			array(
				'search'         => '*' . esc_attr( $pro ) . '*',
				'search_columns' => array(
					'user_login',
					'user_nicename',
					'user_email',
					'user_url',
				),
			)
		);
		$users_found = $users->get_results();

		if ( ! empty( $users_found ) ) {
			foreach ( $users_found as $proo ) {
				$title        = $proo->display_name . '(' . $proo->user_email . ')';
				$data_array[] = array( $proo->ID, $title ); // array( User ID, User name and email ).
			}
		}

		echo wp_json_encode( $data_array );
		die();
	}
	public function af_ig_admin_assests() {
		$af_invoice_template = get_option( 'af_invoice_template' ) ? get_option( 'af_invoice_template' ) : 'temp1.php';
		ob_start();
		?>

		<div class="af_invoice_template" style="display: flex;">
		 
			<div class="af_invoice_templates" style="" >
				<input  style="display: none;" type="radio"   name="af_invoice_template" class="af_inv_step_style"  id="choose1" value="temp1.php"
				<?php
				if ( 'temp1.php' == $af_invoice_template ) {
					echo 'checked';
				}
				?>
				/>
				<label for="choose-1">
					<img style="  width: 140px!important; height:192px!important;" src="<?php echo esc_attr( AF_IG_URL . 'uploads\temp1.png' ); ?>" />
				</label>
			</div>
			<div class="af_invoice_templates" style="">
				<input style="  display: none;" type="radio" name="af_invoice_template" class="af_inv_step_style" id="choose2" value="temp2.php" 
				<?php
				if ( 'temp2.php' == $af_invoice_template ) {
					echo 'checked';
				}
				?>
				/>
				<label for="choose-2">
					<img style= "  width: 140px!important; height:192px!important;" src="<?php echo esc_attr( AF_IG_URL . 'uploads\temp2.png' ); ?>" />
				</label>
			</div>
			<div class="af_invoice_templates" style="">
				<input style="display: none;" type="radio" name="af_invoice_template" class="af_inv_step_style" id="choose2" value="temp3.php" 
				<?php
				if ( 'temp3.php' == $af_invoice_template ) {
					echo 'checked';
				}
				?>
				/>
				<label for="choose-2">
					<img style="  width: 140px!important; height:192px!important;" src="<?php echo esc_attr( AF_IG_URL . 'uploads\temp3.png' ); ?>" />
				</label>
			</div>
			<div class="af_invoice_templates" style="">
				<input style="display: none;" type="radio" name="af_invoice_template" class="af_inv_step_style" id="choose2" value="temp4.php" 
				<?php
				if ( 'temp4.php' == $af_invoice_template ) {
					echo 'checked';
				}
				?>
				/>
				<label for="choose-2">
					<img style="  width: 140px!important; height:192px!important;" src="<?php echo esc_attr( AF_IG_URL . 'uploads\temp4.png' ); ?>" />
				</label>
			</div>
			
		</div>

		<?php
		$invoicedata = ob_get_clean();
		ob_start();
		$af_invoice_upload_icon = get_option( 'af_invoice_upload_icon' );
		?>

		<div class="af_invoice_upload_icon af_invoice_custom_icon">
			<div class="af_wpb_logo_img_div" id="af_wpb_logo_img_div">
				<div class="af_wpb_logo_img_right">
					<div class="imgdis">
						<img style="  max-width: 200px!important ; " id="af_invoice_upload_icon_img" src="<?php echo esc_url( $af_invoice_upload_icon ); ?>"/>
					</div>
				</div>
				<input type="hidden" value="<?php echo esc_url( $af_invoice_upload_icon ); ?>" name="af_invoice_upload_icon" id="af_invoice_upload_icon" class="login_title">
				<input type="button" name="upload-btn" id="upload-btn" class="af_invoice_upload_icon button-secondary" value="<?php echo esc_html__( 'Upload icon', 'af_invoice_upload_icon' ); ?>">
				<label class="description"></label>
			</div>
		</div>
		<?php
		$upload_pdf_icon = ob_get_clean();

			$screen = get_current_screen();

		if ( 'payment_gateway' === $screen->post_type || 'woocommerce_page_wc-settings' === $screen->id ) {
				wp_enqueue_style( 'af-ig-admin', plugins_url( './include/css/af_ig_admin.css', __FILE__ ), false, '1.0' );
				wp_enqueue_style( 'af-ig-select2', plugins_url( './include/css/select2.css', __FILE__ ), false, '1.0' );

			// Enqueue Scripts.
				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'af-ig-select2', plugins_url( './include/js/select2.js', __FILE__ ), array( 'jquery' ), '1.0', false );
				wp_enqueue_script( 'af-ig-admin', plugins_url( './include/js/af_ig_admin.js', __FILE__ ), array( 'jquery' ), '1.0', false );
				wp_enqueue_media();

			// Localize the variables.
			$af_ig_data = array(
				'admin_url'       => admin_url( 'admin-ajax.php' ),
				'invoicedata'     => $invoicedata,
				'upload_pdf_icon' => $upload_pdf_icon,
				'nonce'           => wp_create_nonce( 'af-ig-ajax-nonce' ),
			);
			wp_localize_script( 'af-ig-admin', 'af_ig_ajax_var', $af_ig_data );
		}
	}
			/**
			 * Save Post meta for Ivnoice Payment.
			 *
			 * @param int     $post_id post id of current post.
			 * @param WP_Post $post    post object.
			 *
			 * @return void
			 */
	public function af_ig_save_metadata( $post_id, $post = false ) {

		// Return if not relevant post type.
		if ( 'payment_gateway' !== $post->post_type ) {
			return;
		}

		// Return if we're doing an auto save.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( 'auto-draft' === get_post_status( $post_id ) ) {
			return;
		}

		include_once AF_IG_PLUGIN_DIR . '/meta-boxes/af-ig-save-metaboxes.php';
	}
	public function Af_ig_payment_gateway_meta_boxes() {
		// Meta box for invoice payment.
		add_meta_box(
			'af-ig-shipping-method',
			esc_html__( 'Invoice based on Shipping', 'af_ig_td' ),
			array( $this, 'af_ig_virtual_meta' ),
			array( 'payment_gateway' )
		);

		// Meta box for invoice payment restrictions for Users.
		add_meta_box(
			'af-ig-conditions-users',
			esc_html__( 'Users and Roles for Invoice', 'af_ig_td' ),
			array( $this, 'af_ig_conditions_users_meta' ),
			array( 'payment_gateway' )
		);

		// Meta box for invoice payment restrictions for Cart.
		add_meta_box(
			'af-ig-conditions-cart',
			esc_html__( 'Cart Amount and Products for Invoice', 'af_ig_td' ),
			array( $this, 'af_ig_conditions_cart_meta' ),
			array( 'payment_gateway' )
		);

		// Meta box for invoice payment restrictions for location.
		add_meta_box(
			'af-ig-conditions-location',
			esc_html__( 'Countries, States, Zip-Codes, Cities  for Invoice', 'af_ig_td' ),
			array( $this, 'af_ig_conditions_location_meta' ),
			array( 'payment_gateway' )
		);
	}
			/**
			 * Ivnoice Payment meta box call back function.
			 *
			 * @return void
			 */
	public function af_ig_virtual_meta() {
		wp_nonce_field( 'af_ig_nonce_action', 'af_ig_nonce_field' );
		include_once AF_IG_PLUGIN_DIR . '/meta-boxes/af-ig-virtual.php';
	}

		/**
		 * Ivnoice Payment conditions for Location.
		 *
		 * @return void
		 */
	public function af_ig_conditions_location_meta() {
		include_once AF_IG_PLUGIN_DIR . '/meta-boxes/af-ig-conditions-location.php';
	}

		/**
		 * Ivnoice Payment conditions for Cart.
		 *
		 * @return void
		 */
	public function af_ig_conditions_cart_meta() {
		include_once AF_IG_PLUGIN_DIR . '/meta-boxes/af-ig-conditions-cart.php';
	}

		/**
		 * Ivnoice Payment conditions for Users.
		 *
		 * @return void
		 */
	public function af_ig_conditions_users_meta() {
		include_once AF_IG_PLUGIN_DIR . '/meta-boxes/af-ig-conditions-users.php';
	}
}
if ( class_exists( 'AF_IG_Admin' ) ) {
	new AF_IG_Admin();
}
