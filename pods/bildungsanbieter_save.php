<?php

/* Auto-select first Bildungsanbieter when not set and saving a Veranstaltung (pre-save). */
add_filter('pods_api_pre_save_pod_item_veranstaltung', 'lfm_autoselect_bildungsanbieter', 10, 2);

function lfm_autoselect_bildungsanbieter($pieces, $is_new_item) {
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

