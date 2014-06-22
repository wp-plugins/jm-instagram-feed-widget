<?php
/*
Plugin Name: JM Instagram Feed Widget
Plugin URI: http://www.tweetpress.fr
Description: Meant to add a widget with your Instagram pics
Author: Julien Maury
Author URI: http://www.julien-maury.com
Version: 1.0
Text Domain: jm-sqrw
Domain Path: /langs/
License: GPL2++
*/
/*  
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

defined('ABSPATH') 
	or die('No !');

// Constants
define( 'IFW_VERSION', 	'1.0' );
define( 'IFW_DIR', 		plugin_dir_path( __FILE__ ));
define( 'IFW_DIR_LIB', 	trailingslashit(plugin_dir_path( __FILE__ ) .'/inc/lib'));
define( 'IFW_URL', 		plugin_dir_url( __FILE__ ));
define( 'IFW_CSS_URL', 	trailingslashit(IFW_URL.'/css'));
define( 'IFW_LANG_DIR', dirname(plugin_basename(__FILE__)) . '/langs/' );


// Init
add_action( 'plugins_loaded', 'jm_ifw_init' );
function jm_ifw_init() {

	require( IFW_DIR . 'inc/widget.class.php' );
	
	// Widget
	add_action( 'widgets_init', create_function('', 'return register_widget("JM_IFW_Widget");') );
	
	// Lang
	load_plugin_textdomain('jm-ifw', FALSE, IFW_LANG_DIR);
	
}
