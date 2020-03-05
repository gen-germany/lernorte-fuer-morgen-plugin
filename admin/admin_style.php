<?php

/* Callback to update CSS within in Admin */
function lfm_admin_style() {
  wp_enqueue_style('admin-styles', plugins_url('/admin.css', __FILE__));
}
/* Update CSS within Admin backend */
add_action('admin_enqueue_scripts', 'lfm_admin_style');

?>
