<?php
/**
 * Plugin Name:       Invoice Payment Option
 * Plugin URI:        https://woocommerce.com/products/invoice-payment-option/
 * Description:       Allow your customers to select invoice payment method during checkout.
 * Version:           1.4.2
 * Author:            Addify
 * Developed By:      Addify
 * Author URI:        https://woocommerce.com/vendor/addify/
 * Support:           https://woocommerce.com/vendor/addify/
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path:       /languages
 * TextDomain : af_ig_td
 * WC requires at least: 4.0
 * WC tested up to: 9.*.*
 * Requires at least: 6.5
 * Tested up to: 6.*.*
 * Requires PHP: 7.4
 * Requires Plugins: woocommerce
 *
/**
 * Define class.
 * Woo: 8518169:0d361fc1719d9e4fea2389399f7f6b5c

 */
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Class start.
 */
class AF_IG_Main {
	public function __construct() {
		$this->Af_ig_global_constents_vars();
		add_filter( 'woocommerce_payment_gateways', array( $this, 'af_ig_creat_object_gateway' ), 999 );
		
		add_action( 'plugins_loaded', array( $this, 'af_if_include_gateway_class' ), 999 );
		add_action( 'wp_loaded', array( $this, 'af_ig_lang_load' ) );
		add_action( 'wp_loaded', array( $this, 'af_ig_register_custom_post' ) );
		add_filter( 'woocommerce_email_classes', array( $this, 'af_inv_email_body_share' ), 90, 1 );

		if ( is_admin() ) {
			include_once AF_IG_PLUGIN_DIR . 'class-af-ig-admin.php';
		} else {
			include_once AF_IG_PLUGIN_DIR . 'class-af-ig-front.php';
			add_filter( 'woocommerce_available_payment_gateways', array( $this, 'af_ig_woocs_filter_payment_gateways' ), 999 );
		}
		
		include_once AF_IG_PLUGIN_DIR . 'include/general-functions.php';
		include_once AF_IG_PLUGIN_DIR . 'include/class-af-ig-shipping-virtual.php';
		include_once AF_IG_PLUGIN_DIR . 'include/class-af-ig-cart-items-check.php';
		include_once AF_IG_PLUGIN_DIR . 'include/class-af-ig-location-check.php';
		require_once AF_IG_PLUGIN_DIR . 'vendor/autoload.php';

		// HOPS compatibility.
		add_action( 'before_woocommerce_init', array( $this, 'af_ig_HOPS_Compatibility' ) );

		add_action( 'plugins_loaded', array( $this, 'af_ig_checks' ) );

		register_activation_hook( __FILE__, array( $this, 'af_inv_update_options' ) );
		add_action('woocommerce_blocks_loaded', array( $this, 'af_ig_register_blocks' ));
		add_action('wp_ajax_af_ig_block_process_checkout_details', array( $this, 'af_ig_block_process_checkout_details' ));
		add_action('wp_ajax_nopriv_af_ig_block_process_checkout_details', array( $this, 'af_ig_block_process_checkout_details' ));
	}
	

	public function Checkout_block_getall_rules( $Rules, $checkoutblock_details, $af_check_res ) {


		if ( empty( $Rules ) ) {
			return true;
		}
		

		foreach ( $Rules as $rule_id ) {

			if ( !$af_check_res->check_user_restrictions( $rule_id ) ) {    
				continue;
			}

			// Check Cart requirements.
			if ( !$af_check_res->check_cart_restrictions( $rule_id ) ) {
				continue;
			}

			if (!$af_check_res->check_shipping_restrictions( $rule_id, $checkoutblock_details ) ) {
				continue;
			}

			if (!$this->af_ig_check_block_restrictions( $rule_id, $checkoutblock_details ) ) {
				continue;
			}

			
			return $rule_id;
			



		}

		return null;
	}


	public function af_ig_check_block_restrictions( $rule_id, $checkoutblock_details ) {

		$values        = json_decode( get_post_meta( $rule_id, 'af_ig_countries', true ) );
		$sel_countries = is_array( $values ) ? $values : array();

		if (!empty($values)) {

			$af_ig_current_selected_country =$checkoutblock_details['shipping']['country'];

			if ( ! in_array( $af_ig_current_selected_country , $sel_countries )) {
				return false;
			}
			

		}

		// States.
		$values     = json_decode( get_post_meta( $rule_id, 'af_ig_states', true ) );
		$sel_states = is_array( $values ) ? $values : array();

		if (!empty($values)) {

			$af_ig_current_selected_state =$checkoutblock_details['shipping']['country'] . ':' . $checkoutblock_details['shipping']['state'];
		
			if ( ! in_array( $af_ig_current_selected_state , $sel_states )) {
				return false;
			}

		}

		// Cities.
		$values     = get_post_meta( $rule_id, 'af_ig_cities', true );
		$sel_cities = isset( $values ) ? $this->addify_ig_purify_explode_data( $values ) : array();
		$sel_cities = isset( $sel_cities[0] ) ? $sel_cities[0] : array();


		if (!empty($values)) {
			
			if (! in_array( $checkoutblock_details['shipping']['city'], $sel_cities )) {
				return false;
			}

		}

		// Zip Codes.
		$values   = get_post_meta( $rule_id, 'af_ig_zip_codes', true );
		$sel_zips = isset( $values ) ? $this->addify_ig_purify_explode_data( $values ) : '';
	
		if (!empty($values)) {
		
			$_zip_code = isset( $checkoutblock_details['shipping']['postcode'] ) ? strtolower( trim( preg_replace( '/[\t\n\r\s]+/', ' ', $checkoutblock_details['shipping']['postcode'] ) ) ) : '';

			$nor_zip_codes   = isset( $sel_zips[0] ) ? $sel_zips[0] : array();
			$range_zip_codes = isset( $sel_zips[1] ) ? $sel_zips[1] : array();


			if ( ! empty( $nor_zip_codes ) && in_array( (string) $_zip_code, (array) $nor_zip_codes, true ) ) {
				return true;
			}

			foreach ( $range_zip_codes as $value ) {

				$_data = explode( '-', $value );

				if ( 2 === count( $_data ) ) {
					if ( intval( $_data[0] ) <= intval( $_zip_code ) && intval( $_zip_code ) <= intval( $_data[1] ) ) {
						return true;
					}
				}
			}
			return false;
		}
		return true;
	}

		/**
		 * Explode data and remove all empty index and add range of zip codes in array.
		 *
		 * @param string $_text     Text to explode.
		 * @param string $delimiter delimiter to explode.
		 *
		 * @return bool Return true or false for Product in Cart.
		 */
	public function addify_ig_purify_explode_data( $_text = '', $delimiter = ',' ) {
		// Removes white spaces form text.
		$_text          = trim( preg_replace( '/[\t\n\r\s]+/', ' ', $_text ) );
		$explode_data   = explode( $delimiter, $_text );
		$purified_array = array();

		foreach ( $explode_data as $key => $value ) {
			// Remove empty indexes.
			if ( ! empty( $value ) ) {
				$purified_array[] = strtolower( trim( preg_replace( '/[\t\n\r\s]+/', ' ', $value ) ) );

			}
		}

		$range_array = array();
		$nor_array   = array();

		// Check for Range of Zip Codes.
		foreach ( $purified_array as $key => $value ) {

			$_data = explode( '-', $value );

			if ( 2 === count( $_data ) ) {

				$range_array[] = $value;

			} else {

				$nor_array[] = $value;

			}
		}
		$purified_array   = array();
		$purified_array[] = $nor_array;
		$purified_array[] = $range_array;

		return $purified_array;
	}

	public function af_ig_register_blocks() {

		if ( ! class_exists( 'Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType' ) ) {
			return;
		}

		
		require_once AF_IG_PLUGIN_DIR . 'blocks-compatibility/class-af-ig-invoice-blocks-integration.php';
		
		add_action(
			'woocommerce_blocks_payment_method_type_registration',
			function ( Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry $payment_method_registry ) {
			$payment_method_registry->register( new Af_Ig_Invoice_Integration() );
			}
		);
	}
	public function af_inv_update_options() {
		$af_check ='yes';

		// Check if the option value is empty for admin email subject
		$admin_email_subject = get_option( 'woocommerce_af_inv_admin_email_id_heading' );

		if ( '' == $admin_email_subject ) {
			// Set the option value to the default text for admin email subject
			update_option( 'woocommerce_af_inv_admin_email_id_heading', '{site_title}#New Invoice Order #{order_number}' );
		}

		// Check if the option value is empty for customer email subject
		$customer_email_subject = get_option( 'woocommerce_af_inv_customer_email_id_subject' );

		if ( '' == $customer_email_subject ) {
			// Set the option value to the default text for customer email subject
			update_option( 'woocommerce_af_inv_customer_email_id_subject', '{site_title}#New Invoice Order #{order_number}' );
		}
		$woocommerce_af_inv_admin_email_id_additional_content = get_option( 'woocommerce_af_inv_admin_email_id_additional_content' );

		if ( '' == $woocommerce_af_inv_admin_email_id_additional_content ) {
			update_option( 'woocommerce_af_inv_admin_email_id_additional_content', 'Congratulations on the sale.' );
		}
	}

	// Hook the function to admin_init instead of wp_loaded

	public function af_inv_email_body_share( $emails ) {
			// include_once AF_IG_PLUGIN_DIR . 'class-af-ig-email.php';

		include_once AF_IG_PLUGIN_DIR . 'include/email/class_af_i_n_v_email_admin.php';
		$emails['af_inv_admin_email_id'] = new AF_I_N_V_ADMIN_Mail();
		include_once AF_IG_PLUGIN_DIR . 'include/email/class_af_i_n_v_email_customer.php';
		$emails['af_inv_customer_email_id'] = new AF_I_N_V_CUSTOMER_Mail();
		return $emails;
	}


	public function af_ig_HOPS_Compatibility() {

		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		}
	}

	public function af_ig_checks() {

		// Check for multisite.
		if ( ! is_multisite() && ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

			add_action( 'admin_notices', array( $this, 'af_ig_admin_notice' ) );
		}
	}

	public function af_ig_admin_notice() {

		// Deactivate the plugin.
			deactivate_plugins( __FILE__ );

			$af_ig_woo_check = '<div id="message" class="error">
				<p><strong>' . __( 'Invoice Payment Option plugin is inactive.', 'af_ig_td' ) . '</strong> The <a href="http://wordpress.org/extend/plugins/woocommerce/">WooCommerce plugin</a> ' . __( 'must be active for this plugin to work. Please install &amp; activate WooCommerce.', 'af_ig_td' ) . ' »</p></div>';
			echo wp_kses_post( $af_ig_woo_check );
	}

	public function af_ig_register_custom_post() {
		$labels = array(
			'name'           => __( 'Invoice Payment Option', 'af_ig_td' ),
			'singular_name'  => __( 'Invoice Payment Option', 'af_ig_td' ),
			'menu_name'      => __( 'Invoice Payment Option', 'af_ig_td' ),
			'name_admin_bar' => __( 'Invoice Payment Option', 'af_ig_td' ),
			'add_new'        => __( 'Add New', 'af_ig_td' ),
			'add_new_item'   => __( 'Add New Rule', 'af_ig_td' ),
			'new_item'       => __( 'New Rule', 'af_ig_td' ),
			'edit_item'      => __( 'Edit Rule', 'af_ig_td' ),
			'view_item'      => __( 'View Rule', 'af_ig_td' ),
			'all_items'      => __( 'Manage Rules', 'af_ig_td' ),
			'search_items'   => __( 'Search Rules', 'af_ig_td' ),
			'not_found'      => __( 'No Rule created.', 'af_ig_td' ),
		);
		$args   = array(
			'supports'            => array( 'title' ),
			'labels'              => $labels,
			'public'              => true,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => 'payment_gateway' ),
			'has_archive'         => true,
			'hierarchical'        => false,
			'menu_icon'           => plugins_url( 'include/images/addifylogo.png', __FILE__ ),
			'show_ui'             => true,
			'can_export'          => true,
			'exclude_from_search' => false,
			'show_in_menu'        => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
		);
		register_post_type( 'payment_gateway', $args );
	}

	public function af_if_include_gateway_class() {
		include_once AF_IG_PLUGIN_DIR . 'class-af-invoice-payment-gateway.php';
	}

	public function af_ig_woocs_filter_payment_gateways( $gateway_list ) {
		
		if ( ! is_checkout()  ) {
			return $gateway_list;
		}
		
		if (!empty(WC()->session->get( 'af_ig_payment_method_validation_block_check'))) {
	
			return $gateway_list;       

		} else {
		
			
			if ( isset( $_POST['woocommerce-process-checkout-nonce'] ) ) {
	
				return $gateway_list;
			}
	
			if ( isset( $_POST['security'] ) ) {
				check_ajax_referer( 'update-order-review', 'security' );
			}
	
			$gateways         = WC()->payment_gateways->payment_gateways();
			$enabled_gateways = array();
			$flag             = false;
	
			if ( $gateways ) {
				foreach ( $gateways as $gateway ) {
	
					if ( 'yes' == $gateway->enabled ) {
						if (
						'Invoice Payments' == $gateway->method_title ) {
							$flag = true;
	
						}
					}
				}
			}
	
			if ( true == $flag ) {
	
				$form_data    = $_POST;
				$af_check_res = new AF_Ig_All_Restrictions();
				$payment_rule = $af_check_res->get_py_ig_all_rules( $form_data );
			
				if ( ! $payment_rule ) {
					if (!empty($_POST)) {
							unset( $gateway_list['invoice'] );
					}
			
					return $gateway_list;
				} else {
					if ( ! isset( $gateway_list['invoice'] ) ) {
						$gateway_list['invoice'] = new Af_Inovice_Pyament_Gateway();
					}
					return $gateway_list;
				}
	
	
			} else {
				return $gateway_list;
			}
		}
	}
	public function af_ig_creat_object_gateway( $methods ) {

		$methods[] = 'Af_Inovice_Pyament_Gateway';
		return $methods;
	}

	public function af_ig_block_process_checkout_details() {

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : 0;
		if (!wp_verify_nonce( $nonce, 'af-ig-ajax-nonce' ) ) {
			die('Failed security check!');
		}

			$post_checkout_block_details = isset( $_POST['checkoutDetails'] ) ? sanitize_meta( '' , ( $_POST['checkoutDetails'] ) , '' ) : array( '' );

			$checkoutblock_details =$post_checkout_block_details;
	  
			WC()->session->set( 'af_ig_payment_method_validation_block', '' );
  
			$af_check_res = new AF_Ig_All_Restrictions();
			$args         = array(
				'post_type'   => 'payment_gateway',
				'post_status' => 'publish',
				'numberposts' => -1,
				'fields'      => 'ids',
			);
			$the_query    = new WP_Query( $args );
			$Rules        = $the_query->get_posts();
  
			if (( $this->Checkout_block_getall_rules($Rules, $checkoutblock_details, $af_check_res) )) {
				wp_send_json_success(array( 'invoicecheck' => 'showinvoice' ));
			} else {

				if ('invoice'== $checkoutblock_details['paymentMethod']) {

					WC()->session->set( 'af_ig_payment_method_validation_block', 'hide_invoice' );
				  
				}

				wp_send_json_success(array(                     
					'invoicecheck' => 'hideinvoice', 
					'invoiceerror' => __('There are no payment methods available. This may be an error on our side. Please contact us if you need any help placing your order.', 'af_ig_td'), 
				));
			}
	}

	public function Af_ig_global_constents_vars() {
		if ( ! defined( 'AF_IG_URL' ) ) {
			define( 'AF_IG_URL', plugin_dir_url( __FILE__ ) );
		}
		if ( ! defined( 'AF_IG_BASENAME' ) ) {
			define( 'AF_IG_BASENAME', plugin_basename( __FILE__ ) );
		}
		if ( ! defined( 'AF_IG_PLUGIN_DIR' ) ) {
			define( 'AF_IG_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}
	}
	public function af_ig_lang_load() {
		if ( function_exists( 'load_plugin_textdomain' ) ) {
			load_plugin_textdomain( 'af_ig_td', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}
	}
}

if ( class_exists( 'AF_IG_Main' ) ) {
	new AF_IG_Main();
}
