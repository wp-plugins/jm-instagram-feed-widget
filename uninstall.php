<?php // If cheating exit
if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
exit();

delete_site_transient( '_instagram_feed' );
