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
 * Version:     0.3.6
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
if(!defined('LFM_PLUGIN_URL')) {
	define('LFM_PLUGIN_URL', plugin_dir_url( __FILE__ ));
}

// plugin folder dir
if(!defined('LFM_PLUGIN_DIR')) {
	define('LFM_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
}

/** Make nested shortcodes (e.g. for maps) work with Pods. */
define('PODS_SHORTCODE_ALLOW_SUB_SHORTCODES',true);
/**
* Allow Pods Templates to use shortcodes
* NOTE: Will only work if the constant PODS_SHORTCODE_ALLOW_SUB_SHORTCODES is true.
*/
add_filter( 'pods_shortcode', function( $tags )  {
  $tags[ 'shortcodes' ] = true;

  return $tags;
});

include( LFM_PLUGIN_DIR . '/dashboard/dashboard.php' );

include( LFM_PLUGIN_DIR . '/admin/admin_style.php' );
include( LFM_PLUGIN_DIR . '/frontend/frontend_style.php' );
include( LFM_PLUGIN_DIR . '/frontend/image_sizes.php' );

include( LFM_PLUGIN_DIR . '/restrict-media/restrict-media.php' );

include( LFM_PLUGIN_DIR . '/shortcodes/shortcodes.php' );
include( LFM_PLUGIN_DIR . '/editor_ui/editor_ui.php' );
include( LFM_PLUGIN_DIR . '/pods/referentn_save.php' );
include( LFM_PLUGIN_DIR . '/pods/lernorte_save.php' );
include( LFM_PLUGIN_DIR . '/admin/profile_page.php' );
include( LFM_PLUGIN_DIR . '/admin/remove_help.php' );
include( LFM_PLUGIN_DIR . '/admin/excerpt_labels.php' );

include( LFM_PLUGIN_DIR . '/divi/divi.php' );

include( LFM_PLUGIN_DIR . '/nav/auto_menu.php' );

include( LFM_PLUGIN_DIR . '/search/calendar.php' );
include( LFM_PLUGIN_DIR . '/search/filter_view.php' );


function lfm_event_date_format( $date_string ) {
	$timestamp = strtotime( $date_string );
	$format = "d.m.Y";
	return date( $format, $timestamp );
}


?>
