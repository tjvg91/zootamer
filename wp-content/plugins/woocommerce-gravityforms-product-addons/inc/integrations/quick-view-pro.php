<?php

class WC_GFPA_Quick_View_Pro_Integration {
	private static ?WC_GFPA_Quick_View_Pro_Integration $instance;

	public static function register() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
	}

	private ?WP_REST_Request $request = null;

	private function __construct() {
		add_action(
			'wc_quick_view_pro_before_quick_view_template',
			array( $this, 'on_wc_quick_view_pro_before_quick_view_template' )
		);

		add_filter('rest_dispatch_request', array($this, 'on_rest_dispatch_request'), 10, 4);
	}

	public function on_rest_dispatch_request($result, $request, $route, $handler) {
		if ($route === '/wc-quick-view-pro/v1/cart') {
			$this->request = $request;
			return $result;
		}

		return $result;
	}

	public function on_wc_quick_view_pro_before_quick_view_template() {
		// Bind to the quick view before template hook to force the Gravity Forms scripts to render in the form markup.
		add_filter( 'gform_init_scripts_footer', array( $this, 'on_gform_init_scripts_footer' ) );
	}

	public function on_gform_init_scripts_footer( $value ) {
		// Force the script to render in the form markup rather than in the footer. This is necessary for the form to work in the quick view.
		remove_filter( 'gform_init_scripts_footer', array( $this, 'on_gform_init_scripts_footer' ) );
		return false;
	}

	public static function remove_gform_init_scripts_footer() {
		add_filter( 'gform_init_scripts_footer', array( self::$instance, 'on_gform_init_scripts_footer' ) );
	}

	public static function get_variation_id() {
		$request = self::$instance->request;
		if ( ! $request ) {
			return false;
		}

		$variation_id = $request->get_param( 'variation_id' );
		return $variation_id;
	}
}
