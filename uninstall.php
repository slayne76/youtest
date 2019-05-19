<?php
/*
 * Uninstall plugin
 */
	
if ( is_multisite() ) {
	$ms_sites = function_exists( 'get_sites' ) ? get_sites() : wp_get_sites();

	restore_current_blog();
} else {
	if( sizeof( $option_names ) > 0 ) {
		foreach( $option_names as $option_name ) {
			delete_option( $option_name );
			plugin_uninstalled();
		}
	}
}
