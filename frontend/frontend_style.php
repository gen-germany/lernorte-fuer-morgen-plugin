<?php

/* Callback to add frontend CSS */
function lfm_frontend_style() {
  wp_enqueue_style( 'lfm-frontend', plugins_url( 'frontend.css', __FILE__ ) );
}

/** Add CSS for frontend */
add_action ( 'wp_enqueue_scripts', 'lfm_frontend_style' );

?>
