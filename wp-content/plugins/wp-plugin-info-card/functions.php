<?php
/**
 * Global Functions and Variables.
 *
 * @package WPPIC
 */

/**
 * Exit and prevent direct access.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct acces not allowed!' );
}

/***************************************************************
 * Fetching plugins and themes data through WordPress Plugin API
 ***************************************************************/
function wppic_api_parser( $type, $slug, $expiration = 720, $extra = '', $load_attachments = false, $force = false ) {

	if ( ! empty( $extra ) ) {
		$extra = $extra . '_';
	}

	// Get option key name.
	$option_key = sanitize_key( 'wppic_' . $extra . $type . '_' . preg_replace( '/\-/', '_', $slug ) );

	$wppic_data = false;

	// Determine if we're getting data from cache.
	if ( ! $force ) {
		$maybe_wppic_data = get_transient( $option_key );
		if ( false !== $maybe_wppic_data ) {
			// We have data, but need to check for any errors.
			if ( is_wp_error( $maybe_wppic_data ) ) {
				// Try to get the data from option.
				$maybe_wppic_data = get_option( $option_key, false );
				if ( false !== $maybe_wppic_data && ! is_wp_error( $maybe_wppic_data ) ) {
					$wppic_data = $maybe_wppic_data;
				}
			} else {
				$wppic_data = $maybe_wppic_data;
			}
		}
	}

	// check if $expiration is numeric, only digit char.
	if ( empty( $expiration ) || ! is_numeric( $expiration ) ) {
		$expiration = 720;
	}

	if ( false === $wppic_data || empty( $wppic_data ) || $force ) {

		$wppic_data = false;
		$wppic_data = apply_filters( 'wppic_add_api_parser', $wppic_data, $type, $slug, $load_attachments, $force );
	}

	// If we have data, store it as an option and a transient.
	if ( false !== $wppic_data && ! empty( $wppic_data ) ) {
		// Remove old option.
		delete_option( $option_key );

		// Re-add option.
		add_option( $option_key, $wppic_data, '', 'no' );
		set_transient( $option_key, $wppic_data, $expiration * 60 );
	}

	return $wppic_data;
}


/***************************************************************
 * Add settings link on plugin list page
 ***************************************************************/
function wppic_settings_link( $links ) {
	$links[] = '<a href="' . esc_url( admin_url( 'options-general.php?page=' . WPPIC_ID ) ) . '" title="' . esc_html__( 'WP Plugin Info Card Settings', 'wp-plugin-info-card' ) . '">' . __( 'Settings', 'wp-plugin-info-card' ) . '</a>';
	return $links;
}
add_filter( 'plugin_action_links_' . WPPIC_BASE, 'wppic_settings_link' );


/***************************************************************
 * Add custom meta link on plugin list page
 ***************************************************************/
function wppic_meta_links( $links, $file ) {
	if ( $file === 'wp-plugin-info-card/wp-plugin-info-card.php' ) {
		$links[] = '<a href="https://wppic.dlxplugins.com/" target="_blank" title="' . __( 'Documentation and examples', 'wp-plugin-info-card' ) . '"><strong>' . __( 'Documentation and examples', 'wp-plugin-info-card' ) . '</strong></a>';
		$links[] = '<a href="http://b-website.com/category/plugins" target="_blank" title="' . __( 'More plugins by b*web', 'wp-plugin-info-card' ) . '">' . __( 'More plugins by b*web', 'wp-plugin-info-card' ) . '</a>';
		$links[] = '<a href="https://dlxplugins.com/plugins/" target="_blank" title="' . __( 'More plugins by MediaRon', 'wp-plugin-info-card' ) . '">' . __( 'More plugins by DLX Plugins', 'wp-plugin-info-card' ) . '</a>';
	}
	return $links;
}
add_filter( 'plugin_row_meta', 'wppic_meta_links', 10, 2 );


/***************************************************************
 * Purge all plugin transients function
 ***************************************************************/
function wppic_delete_transients() {
	global $wpdb;
	/*
	if( extension_loaded( 'Memcache' ) )
		return;*/
	$wppic_transients = $wpdb->get_results(
		"SELECT option_name AS name,
		option_value AS value FROM $wpdb->options
		WHERE option_name LIKE '_transient_wppic_%'"
	);
	foreach ( (array) $wppic_transients as $singleTransient ) {
		delete_transient( str_replace( '_transient_', '', $singleTransient->name ) );
	}
}

/***************************************************************
 * Purge all plugin options cache function
 ***************************************************************/
function wppic_delete_options_cache() {
	global $wpdb;
	$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE 'wppic_plugin%'" );
	$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE 'wppic_theme%'" );
}


/***************************************************************
 * Cron to purge all plugin transients every weeks
 ***************************************************************/
function wppic_add_weekly( $schedules ) {
	$schedules['wppic-weekly'] = array(
		'interval' => 604800,
		'display'  => __( 'Once Weekly', 'wp-plugin-info-card' ),
	);
	return $schedules;
}
add_filter( 'cron_schedules', 'wppic_add_weekly' );

function wppic_cron_activation() {
	wp_schedule_event( current_time( 'timestamp' ), 'wppic-weekly', 'wppic_daily_cron' );
}
add_action( 'wppic_daily_cron', 'wppic_delete_transients' );

register_activation_hook( __FILE__, 'wppic_cron_activation' );
register_activation_hook( __FILE__, 'wppic_delete_transients' );
