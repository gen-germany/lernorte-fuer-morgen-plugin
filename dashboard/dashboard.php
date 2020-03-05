<?php

/** Custom Dashboard Widget */
add_action('wp_dashboard_setup', 'lfm_dashboard_widgets');

/** Callback to add dashboard widget and meta boxes */
function lfm_dashboard_widgets() {
  wp_add_dashboard_widget('lfm_help_widget', __('Lernorte für Morgen'), 'lfm_custom_dashboard_help');
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
function lfm_custom_dashboard_help() {
  require_once( LFM_PLUGIN_DIR . '/dashboard/help_widget.php' );
}

/** Callback to remove unwanted dashboard widgets.
  * Names correspond to what can be found using Inspect Element (id of widget-element). */
function lfm_remove_dashboard_widgets() {
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
add_action( 'wp_dashboard_setup', 'lfm_remove_dashboard_widgets' );

/** Modify Welcome Dashboard Panel */
function lfm_dashboard_welcome_panel() {
  require_once( LFM_PLUGIN_DIR . '/dashboard/welcome_panel.php' );
}

/** Replace dashboard welcome panel */
add_action( 'welcome_panel', 'lfm_dashboard_welcome_panel' );

?>
