<?php // If cheating exit
if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
exit();

global $wpdb;
$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '%_instagram_feed'" );

delete_option( 'jm_ifw' );
