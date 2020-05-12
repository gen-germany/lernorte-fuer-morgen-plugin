<?php

function lfm_check_box( $pod, $param_name, $checked ){
  $is_checked = ( $checked ) ? 'checked' : '' ;

  echo '<input type="checkbox" name="' . $param_name . '[]" value="' . $pod->id() . '" ' . $is_checked . '>';
  echo '<label>' . $pod->field( 'post_title' ) . '</label>';
  echo '<br/>';

}
function lfm_check_boxes( $pod_name, $param_name = null) {
  if ( $param_name == null ) {
    $param_name = $pod_name;
  }

  $choice = get_query_var( $param_name );

  if ( empty ( $choice ) ) {
    $choice = array();
  }

  $params = array(
    //'orderby' => '',
    'limit'   => -1
  );
  $pods = pods( $pod_name, $params);

  if ( $pods->total() > 0 ) {
    while( $pods->fetch() )  {
      $is_checked = ( in_array ($pods->id(), $choice) ) ? 'checked' : '' ;
      echo '<input type="checkbox" name="' . $param_name . '[]" value="' . $pods->id() . '" ' . $is_checked . '>';
      echo '<label>' . $pods->field( 'post_title' ) . '</label>';
      echo '<br/>';
    }
  }
}

function lfm_shortcode_zielgruppe_filter() {
  ob_start();

  echo "<form method=\"GET\">";

  lfm_check_boxes( 'zielgruppe' );

  echo '<input type="submit">';
  echo "</form>";

  return ob_get_clean();
}
add_shortcode('lfm_zielgruppe_filter', 'lfm_shortcode_zielgruppe_filter' );

/** */
function lfm_shortcode_format_filter() {
  ob_start();

  $formate = get_query_var( 'format' );

  if ( empty ( $formate ) ) {
    $formate = array();
  }

  echo "<form method=\"GET\">";
  $params = array(
    //'orderby' => '',
    'limit'   => -1
  );
  $pods = pods( 'veranstaltungsformat', $params);
  if ( $pods->total() > 0 ) {
    while( $pods->fetch() )  {
      $is_checked = ( in_array ($pods->id(), $formate) ) ? 'checked' : '' ;
      echo '<input type="checkbox" name="format[]" value="' . $pods->id() . '" ' . $is_checked . '>';
      echo '<label>' . $pods->field( 'post_title' ) . '</label>';
      echo '<br/>';
    }
  }

  echo '<input type="submit">';
  echo "</form>";

  return ob_get_clean();
}
add_shortcode( 'lfm_format_filter', 'lfm_shortcode_format_filter' );

function lfm_shortcode_filter_form() {
  ob_start();

  echo "<form method=\"GET\">";

  echo '<h3>Themenfelder</h3>';
  lfm_check_boxes( 'themenfeld' );
  echo '<h3>Formate</h3>';
  lfm_check_boxes( 'veranstaltungsformat', 'format' );
  echo '<h3>Zielgruppen</h3>';
  lfm_check_boxes( 'zielgruppe' );

  echo '<input type="submit">';

  echo "</form>";

  return ob_get_clean();
}
add_shortcode( 'lfm_filter_form', 'lfm_shortcode_filter_form' );


?>
