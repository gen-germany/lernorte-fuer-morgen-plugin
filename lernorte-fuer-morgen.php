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
 * Version:     0.1.7
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


/** Custom Dashboard Widget */
add_action('wp_dashboard_setup', 'lfm_dashboard_widgets');

/** Callback to add dashboard widget and meta boxes */
function lfm_dashboard_widgets() {
  wp_add_dashboard_widget('lfm_help_widget', __('Lernorte für Morgen'), 'custom_dashboard_help');
  // The other widgets should be at the side, so use add_meta_box instead
  add_meta_box('lfm_dashboard_veranstaltungen',
    __('Lernorte für Morgen - Veranstaltungen'),
    'lfm_dashboard_veranstaltungen',
    'dashboard', 'side', 'high');
  add_meta_box('lfm_dashboard_referentn',
    __('Lernorte für Morgen - Referent*n'),
    'lfm_dashboard_referentn', 'dashboard', 'side', 'high');
}

/** Callback for the dashboard referentn metabox */
function lfm_dashboard_referentn() {
  require_once( LFM_PLUGIN_DIR . '/dashboard/referentn_widget.php' );
}

/** Callback for the dashboard veranstaltungen metabox */
function lfm_dashboard_veranstaltungen() {
  require_once( LFM_PLUGIN_DIR . '/dashboard/veranstaltungen_widget.php' );
}

/** Callback for the dashboard help widget */
function custom_dashboard_help() {
  require_once( LFM_PLUGIN_DIR . '/dashboard/help_widget.php' );
}

/** Callback to remove unwanted dashboard widgets.
  * Names correspond to what can be found using Inspect Element (id of widget-element). */
function remove_dashboard_widgets() {
 // Remove Welcome to WordPress! widget
 // https://codex.wordpress.org/Plugin_API/Action_Reference/welcome_panel
 remove_action( 'welcome_panel', 'wp_welcome_panel');

 // Remove meta boxes to the left.
 // At a Glance widget
 remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
 // Activity widget
 remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );

 // Remove meta boxes to the right.
 // Quick Draft widget
 remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
 // WordPress News
 remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
}

/** Remove default dashboard widgets */
add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );

/** Modify Welcome Dashboard Panel */
function lfm_dashboard_welcome_panel() {
  require_once( LFM_PLUGIN_DIR . '/dashboard/welcome_panel.php' );
}

/** Replace dashboard welcome panel */
add_action( 'welcome_panel', 'lfm_dashboard_welcome_panel' );


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

/* Callback to update CSS within in Admin */
function admin_style() {
  wp_enqueue_style('admin-styles', plugins_url('/admin.css', __FILE__));
}
/* Update CSS within Admin backend */
add_action('admin_enqueue_scripts', 'admin_style');

include( LFM_PLUGIN_DIR . '/restrict-media/restrict-media.php' );

/* Auto-select first Bildungsanbieter when not set and saving a Veranstaltung (pre-save). */
add_filter('pods_api_pre_save_pod_item_veranstaltung', 'autoselect_bildungsanbieter', 10, 2);
function autoselect_bildungsanbieter($pieces, $is_new_item) {
  // PHP special: '' == NULL (but not ===)
  if ($pieces[ 'fields' ][ 'bildungsanbieter' ][ 'value' ] == NULL) {
    // Mark field as 'dirty', to process changes.
    if ( ! isset( $pieces[ 'fields_active' ][ 'bildungsanbieter' ] ) ) {
      array_push ($pieces[ 'fields_active' ], 'bildungsanbieter' );
    }
    // Find relevant bildungsanbieter
    $params = array(
      'where' => 'post_author = ' . get_current_user_id()
    );

    $bildungsanbieter = pods( 'bildungsanbieter', $params );
    $bildungsanbieter_data = $bildungsanbieter->data();

    if ($bildungsanbieter_data == NULL) {
      return pods_error("Bitte lege zuerst einen Bildungsanbieter an.");
    }

    $first_bildungsanbieter_id = reset($bildungsanbieter_data)->ID;
    $pieces[ 'fields' ][ 'bildungsanbieter' ][ 'value' ] = $first_bildungsanbieter_id;
  }

  return $pieces;
}

?>
