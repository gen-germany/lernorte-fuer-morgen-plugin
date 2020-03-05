<?php

/**
 * Shortcode to display number of bildungsveranstalter.
 */
function lfm_shortcode_number_bildungsanbieter() {
  $params = array(
    'limit' => -1
  );
  $bildungsanbieter = pods('bildungsanbieter', $params);
  return $bildungsanbieter->total_found();
}
add_shortcode('bildungsanbieter_count', 'lfm_shortcode_number_bildungsanbieter' );

/**
 * Shortcode to display number of referent*n.
 */
function lfm_shortcode_number_referentn() {
  $params = array(
    'limit' => -1
  );
  $referentn = pods('referentn', $params);
  return $referentn->total_found();
}
add_shortcode('referentn_count', 'lfm_shortcode_number_referentn' );

/**
 * Shortcode to display number of veranstaltungen.
 */
function lfm_shortcode_number_veranstaltungen() {
  $params = array(
    'limit' => -1
  );
  $veranstaltungen = pods('veranstaltungen', $params);
  return $veranstaltungen->total_found();
}
add_shortcode('veranstaltungen_count', 'lfm_shortcode_number_veranstaltungen' );

/**
 * Shortcode to display links to (upcoming) months
 */
function lfm_shortcode_upcoming_months_links() {
  $num_month = 8;

  $i = 0;
  while( $i++ < $num_month ) {
    $month_date = mktime(0, 0, 0, date('n') + $i);
    $month_name = date_i18n( 'F', $month_date, 1 );
    echo "<a href=\"calendar/" . date( 'M', $month_date ) . "\">" . $month_name . "</a>";
  }

  }
}
add_shortcode('upcoming_months_links', 'lfm_shortcode_upcoming_months_links' );

?>
