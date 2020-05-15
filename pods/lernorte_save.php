<?php

/* Auto-select first Lernort when not set and saving a Veranstaltung (pre-save). */
add_filter('pods_api_pre_save_pod_item_veranstaltung', 'lfm_autoselect_lernort', 10, 2);

function lfm_autoselect_lernort($pieces, $is_new_item) {
  // PHP special: '' == NULL (but not ===)
  if ($pieces[ 'fields' ][ 'lernort' ][ 'value' ] == NULL) {
    // Mark field as 'dirty', to process changes.
    if ( ! isset( $pieces[ 'fields_active' ][ 'lernort' ] ) ) {
	     array_push ($pieces[ 'fields_active' ], 'lernort' );
    }
    // Find relevant lernort
    $params = array(
      'where' => 'post_author = ' . get_current_user_id()
    );

    $lernort = pods( 'lernort', $params );
    $lernort_data = $lernort->data();

    if ($lernort_data == NULL) {
      return pods_error("Bitte lege zuerst einen Lernort an.");
    }

    $first_lernort_id = reset($lernort_data)->ID;
    $pieces[ 'fields' ][ 'lernort' ][ 'value' ] = $first_lernort_id;
  }

  return $pieces;
}

