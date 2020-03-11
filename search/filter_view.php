<?php

/** */
function lfm_shortcode_format_filter() {
  ob_start();

  $formate = get_query_var( 'format' );

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
add_shortcode('lfm_format_filter', 'lfm_shortcode_format_filter' );


?>
