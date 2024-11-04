<?php
/**
 * Plugin Name:       Invoice Payment Option
 * Plugin URI:        https://woocommerce.com/products/invoice-payment-option/
 * Description:       Allow your customers to select invoice payment method during checkout.
 * Version:           1.3.3
 * Author:            Addify
 * Developed By:      Addify
 * Author URI:        https://woocommerce.com/vendor/addify/
 * Support:           https://woocommerce.com/vendor/addify/
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path:       /languages
 * TextDomain : af_ig_td
 * WC requires at least: 3.0.9
 * WC tested up to: 9.*.*
 * Woo: 8518169:0d361fc1719d9e4fea2389399f7f6b5c
 * Requires Plugins: woocommerce
 *
/**
 * Define class.
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
		add_filter( 'woocommerce_payment_gateways', array( $this, 'af_ig_creat_object_gateway' ), 999999 );
		add_filter( 'woocommerce_available_payment_gateways', array( $this, 'af_ig_woocs_filter_payment_gateways' ), 999999 );
		add_action( 'plugins_loaded', array( $this, 'af_if_include_gateway_class' ), 999999 );
		add_action( 'wp_loaded', array( $this, 'af_ig_lang_load' ) );
		add_action( 'wp_loaded', array( $this, 'af_ig_register_custom_post' ) );

		add_filter( 'woocommerce_email_classes', array( $this, 'af_inv_email_body_share' ), 90, 1 );

		if ( is_admin() ) {
			include_once AF_IG_PLUGIN_DIR . 'class-af-ig-admin.php';
		} else {
			include_once AF_IG_PLUGIN_DIR . 'class-af-ig-front.php';

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
		if ( ! is_checkout() ) {
			return $gateway_list;
		}
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
				unset( $gateway_list['invoice'] );
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
	public function af_ig_creat_object_gateway( $methods ) {

		$methods[] = 'Af_Inovice_Pyament_Gateway';
		return $methods;
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
