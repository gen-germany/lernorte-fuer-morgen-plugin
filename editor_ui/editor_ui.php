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
add_filter( 'admin_footer', 'lfm_remove_editor_tabs_css', 99 );
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

add_filter( 'admin_footer', 'lfm_remove_caldera_form_link', 99 );
function lfm_remove_caldera_form_link() {
  $user = wp_get_current_user();
  if ( in_array( 'administrator', (array) $user->roles ) ) {
    // Admins see everything.
  }
  else {
    echo '  <style type="text/css">
      #caldera-forms-form-insert {
        display:none;
      }
  </style>';
  }
}

/** Add a JavaScript snippet to show the word limit in TinyMCE Editor. */
add_filter( 'admin_print_footer_scripts', 'lfm_add_tinymce_word_limits' );
function lfm_add_tinymce_word_limits() {
  global $post_type;
  if ('referentn' == $post_type) {
    $word_limit = 60;
  }
  else {
    return;
  }
  ?>
  <script type="text/javascript">
  window.onload = function () {
    var word_limit = <?php echo $word_limit; ?>;
    tinyMCE.editors[0].on('keyup', function(ed,e) {
      var word_count_element = document.querySelectorAll('.word-count')[0];
       var word_count = parseInt( word_count_element.textContent );
       if(word_count > word_limit) {
         document.getElementById('post-status-info').style.backgroundColor = '#ff3333';
         var text_to_change = document.getElementById('wp-word-count').childNodes[0];
         text_to_change.nodeValue = 'Wortanzahl (max ' + word_limit + '): ';
       } else {
         document.getElementById('post-status-info').style.backgroundColor = '#f7f7f7';
         var text_to_change = document.getElementById('wp-word-count').childNodes[0];
         text_to_change.nodeValue = 'Wortanzahl (max ' + word_limit + '): ';
         //text_to_change.nodeValue = 'Wortanzahl: ';
       }
    });
  }
  </script>

	<style type="text/css">
	</style>
  <?php
}

?>
