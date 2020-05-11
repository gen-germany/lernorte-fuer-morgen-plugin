<?php

/**
 * Remove pods shortcode editor and other buttons for non-admins.
 */
add_action( 'admin_init', 'lfm_remove_editor_buttons', 14 );
function lfm_remove_editor_buttons () {
  $user = wp_get_current_user();
  if ( in_array( 'administrator', (array) $user->roles ) ) {
    # Admins see everything.
  }
  else {
    remove_action( 'media_buttons', array( PodsInit::$admin, 'media_button' ), 12 );
    remove_action( 'media_buttons', 'media_buttons' );
  }
}

/**
 * Remove Visual/Text tab from editor if non-admin.
 */
add_filter( 'admin_footer', 'lfm_remove_editor_tabs_css', 99);
function lfm_remove_editor_tabs_css(){
  $user = wp_get_current_user();
  if ( in_array( 'administrator', (array) $user->roles ) ) {
    // Admins see everything.
  }
  else {
    echo '  <style type="text/css">
      .wp-editor-tabs {
        display:none;
      }
  </style>';
  }
}

?>
