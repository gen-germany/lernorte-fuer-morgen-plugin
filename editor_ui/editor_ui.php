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
  if ( 'referentn' == $post_type ) {
    $word_limit = 200;
  } elseif ( 'lernort' == $post_type ) {
    $word_limit = 400;
    $excerpt_word_limit = 70;
  } elseif ( 'veranstaltung' == $post_type ) {
    $word_limit = 800;
    $excerpt_word_limit = 50;
  } else {
    return;
  }
  ?>
  <script type="text/javascript">
  window.onload = function () {
    if (!tinyMCE) { return; }

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

    var excerpt_element = document.getElementById('excerpt');
    var excerpt_word_limit = <?php echo $excerpt_word_limit ?>;
    if (excerpt_element) {
      var excerpt_box = document.getElementById('postexcerpt');
      var limit_span  = document.getElementById('postexcerpt-limit');
      if (!limit_span) {
        var limit_span = document.createElement('span');
        limit_span.innerHTML = "Wort-Limit: " + excerpt_word_limit;
        limit_span.id = "postexcerpt-limit";
        var excerpt_inside = document.querySelectorAll('#postexcerpt .inside')[0];
        excerpt_inside.appendChild(limit_span);
      }

      excerpt_element.onkeyup = function() {
        // or words: w+ ?
        var word_count = this.value.trim().split(/\s+/).length;
        limit_span.innerHTML = "Wort-Limit: " + excerpt_word_limit + " (" + word_count + ")";


        if (word_count > excerpt_word_limit) {
          limit_span.style.backgroundColor = 'red';
          excerpt_box.style.border = "1px solid red";
        } else {
          limit_span.style.backgroundColor = 'white';
          excerpt_box.style.border = "1px solid #ccd0d4";
        }
      };
    }
  }
  </script>

	<style type="text/css">
	</style>
  <?php
}

?>
