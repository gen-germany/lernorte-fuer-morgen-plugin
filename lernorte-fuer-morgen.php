<?php
/**
 * Lernorte für MorGEN Plugin
 *
 * @package   Lernorte_fuer_MorGEN
 * @license   AGPL-3.0+
 *
 * @wordpress-plugin
 * Plugin Name: Lernorte für MorGEN
 * Plugin URI:  https://github.com/gen-germany/lernorte-fuer-morgen-plugin
 * Description: Specific additions for the Lernorte für MorGEN website
 * Version:     0.1.1
 * Author:      Felix Wolfsteller
 * Author URI:  https://econya.de
 * Text Domain: lernorte-fuer-morgen
 * License:     AGPL-3.0+
 * License URI: http://www.gnu.org/licenses/agpl-3.0.txt
 * Domain Path: /languages
 * GitHub Plugin URI: https://github.com/gen-germany/lernorte-fuer-morgen-plugin
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

// plugin folder url
if(!defined('LFD_PLUGIN_URL')) {
	define('LFD_PLUGIN_URL', plugin_dir_url( __FILE__ ));
}

// plugin folder dir
if(!defined('LFD_PLUGIN_DIR')) {
	define('LFD_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
}


/** Dashboard Class (inspired by https://remicorson.com/sweet-custom-dashboard/) */
class lfd_custom_dashboard {
  /** Initializes the plugin by setting localization, filters, and administration functions. */
	function __construct() {
		add_action('admin_menu', array( &$this,'lfd_register_menu') );
		add_action('load-index.php', array( &$this,'lfd_redirect_dashboard') );
	}

	function lfd_redirect_dashboard() {
		if( is_admin() ) {
			$screen = get_current_screen();

			if( $screen->base == 'dashboard' ) {
				wp_redirect( admin_url( 'index.php?page=custom-dashboard' ) );
			}
		}
	}

	function lfd_register_menu() {
		add_dashboard_page( 'Custom Dashboard', 'Custom Dashboard', 'read', 'custom-dashboard', array( &$this,'lfd_create_dashboard') );
	}

	function lfd_create_dashboard() {
		require_once( LFD_PLUGIN_DIR . 'custom_dashboard.php' );
	}
}

// instantiate plugin's class
$GLOBALS['lfd_custom_dashboard'] = new lfd_custom_dashboard();

/** Make nested shortcodes (e.g. for maps) work with Pods. */
define('PODS_SHORTCODE_ALLOW_SUB_SHORTCODES',true);
/**
* Allow Pods Templates to use shortcodes
*
* NOTE: Will only work if the constant PODS_SHORTCODE_ALLOW_SUB_SHORTCODES is true.
*/
add_filter( 'pods_shortcode', function( $tags )  {
  $tags[ 'shortcodes' ] = true;

  return $tags;
});

// Update CSS within in Admin
function admin_style() {
  wp_enqueue_style('admin-styles', plugin_dir('/admin.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'admin_style');

?>
