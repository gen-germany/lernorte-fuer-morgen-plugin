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
 * Version:     0.2.1
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

include( LFM_PLUGIN_DIR . '/restrict-media/restrict-media.php' );

include( LFM_PLUGIN_DIR . '/shortcodes/shortcodes.php' );
include( LFM_PLUGIN_DIR . '/editor_ui/editor_ui.php' );
include( LFM_PLUGIN_DIR . '/pods/referentn_save.php' );
include( LFM_PLUGIN_DIR . '/pods/bildungsanbieter_save.php' );
include( LFM_PLUGIN_DIR . '/admin/profile_page.php' );
include( LFM_PLUGIN_DIR . '/admin/remove_help.php' );
include( LFM_PLUGIN_DIR . '/admin/excerpt_labels.php' );

include( LFM_PLUGIN_DIR . '/search/calendar.php' );


/**
 * Remove the Divi "Project" stuff from backend.
 */
add_filter( 'et_project_posttype_args', 'lfm_et_project_posttype_args', 10, 1 );
function lfm_et_project_posttype_args( $args ) {
	return array_merge( $args, array(
		'public'              => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'show_in_nav_menus'   => false,
		'show_ui'             => false
	));
}


?>
