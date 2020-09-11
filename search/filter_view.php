<?php

function lfm_check_box( $pod, $param_name, $checked ){
  $is_checked = ( $checked ) ? 'checked' : '' ;

  echo '<div class="checkbox-wrap">';
  echo '<input type="checkbox" name="' . $param_name . '[]" value="' . $pod->id() . '" ' . $is_checked . '>';
  echo '<label>' . $pod->field( 'post_title' ) . '</label>';
  echo '</div>';

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
  $pods = pods( $pod_name, $params );

  if ( $pods->total() > 0 ) {
    while( $pods->fetch() )  {
      $is_checked = ( in_array ($pods->id(), $choice) ) ? 'checked' : '' ;
      lfm_check_box( $pods, $param_name, $is_checked );
      /*echo '<input type="checkbox" name="' . $param_name . '[]" value="' . $pods->id() . '" ' . $is_checked . '>';
      echo '<label>' . $pods->field( 'post_title' ) . '</label>';
      echo '<br/>';*/
    }
  }
}

/** As Themenfelder are modeled as tree (with 'parent'), descend the tree
 * instead of a simple list */
function lfm_themenfeld_filter() {
  $choice = get_query_var( 'themenfeld' );

  if ( empty ( $choice ) ) {
    $choice = array();
  }

  $params = array(
    //'orderby' => '',
    'limit'   => -1,
    'where'   => 't.post_parent = 0'
  );
  $pods = pods( 'themenfeld', $params );
  if ( $pods->total() > 0 ) {
    while( $pods->fetch() )  {
      echo "<div class=\"themenfeld-filter\">";
      echo "<strong>".$pods->field( 'post_title' )."</strong>";
      echo '<br/>';
      $subpods = pods( 'themenfeld', array( 'limit' => -1, "where" => 't.post_parent = ' . $pods->id() ) );
      while( $subpods->fetch() ) {
        lfm_check_box( $subpods, 'themenfeld', in_array ( $subpods->id(), $choice ) );
        /*echo ' -> ' . $subpods->field( 'post_title' );
        echo '<br/>';*/
      }
      echo "</div>";
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

  echo '<input class="et_pb_button" type="submit" value="Filtern">';
  echo "</form>";

  return ob_get_clean();
}
add_shortcode( 'lfm_format_filter', 'lfm_shortcode_format_filter' );

function lfm_shortcode_filter_form() {
  ob_start();

  echo "<form id=\"lfm-calendar-filter-form\" method=\"GET\">";
  echo "<h3>Themenfelder</h3>";

  echo '<div id="lfm-themenfeld-filter">';
  lfm_themenfeld_filter();
  echo '<button type="submit" name="et_builder_submit_button" class="et_pb_button">Filter anwenden</button>';
  echo '</div>';

  /*echo '<h4>Themenfelder</h4>';
  lfm_check_boxes( 'themenfeld' );*/

  echo '<div id="lfm-format-filter">';
  echo '<h4>Veranstaltungsformate</h4>';
  lfm_check_boxes( 'veranstaltungsformat', 'format' );
  echo '<button type="submit" name="et_builder_submit_button" class="et_pb_button">Filter anwenden</button>';
  echo '</div>';

  echo '<div id="lfm-zielgruppen-filter">';
  echo '<h4>Zielgruppen</h4>';
  lfm_check_boxes( 'zielgruppe' );
  echo '<button type="submit" name="et_builder_submit_button" class="et_pb_button">Filter anwenden</button>';
  echo '</div>';

  echo '<div id="lfm-spezial-filter">';
  echo '<h4>Spezial</h4>';
  lfm_check_boxes( 'spezial' );
  echo '<button type="submit" name="et_builder_submit_button" class="et_pb_button">Filter anwenden</button>';
  echo '</div>';

  echo "</form>";

  return ob_get_clean();
}
add_shortcode( 'lfm_filter_form', 'lfm_shortcode_filter_form' );


?>
