<?php

/* Automtically extract lastname from name of referentn when saving (pre-save). */
add_filter('pods_api_pre_save_pod_item_referentn', 'lfm_autoset_referentn_lastname', 10, 2);

function lfm_autoset_referentn_lastname($pieces, $is_new_item) {
  if ( ! isset( $pieces[ 'fields_active' ][ 'nachname' ] ) ) {
    array_push ($pieces[ 'fields_active' ], 'nachname' );
  }

  $fullname = get_the_title();
  $name_parts = explode(' ', $fullname);
  $pieces[ 'fields' ][ 'nachname' ][ 'value' ] = end($name_parts);

  return $pieces;
}
