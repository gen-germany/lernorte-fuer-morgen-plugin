<?php

/**
 * Shortcode to display number of lernorte.
 */
function lfm_shortcode_number_lernorte() {
  $params = array(
    'limit' => -1
  );
  $bildungsanbieter = pods('lernorte', $params);
  return $bildungsanbieter->total_found();
}
add_shortcode('lfm_lernorte_count',
  'lfm_shortcode_number_lernorte' );

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
add_shortcode('lfm_referentn_count',
  'lfm_shortcode_number_referentn' );

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
add_shortcode('lfm_veranstaltungen_count',
  'lfm_shortcode_number_veranstaltungen' );

/**
 * Shortcode to display links to (upcoming) months
 */
function lfm_shortcode_upcoming_months_links() {
  $num_month = 8;

  $i = 0;
  while( $i++ < $num_month ) {
    $month_date = mktime(0, 0, 0, date('n') + $i);
    $month_name = date_i18n( 'F', $month_date, 1 );
    echo "<a href=\"/veranstaltungen/2020/" . date( 'm', $month_date ) . "\">" . $month_name . "</a> ";
  }
  //->modify( 'first day of next month' );
  //$final = date("Y-m-d", strtotime("+1 month", $time));
}
add_shortcode('lfm_upcoming_months_links', 'lfm_shortcode_upcoming_months_links' );

/**
 * Shortcode to display a list of events
 */
function lfm_shortcode_event_list_month() {
  ob_start();

  $calendar_month = get_query_var( 'calendar_month' );
  $calendar_year  = get_query_var( 'calendar_year' );

  if( !$calendar_month ) {
    $today = strtotime('today');
    $calendar_month = date( 'm', $today );
  }
  if( !$calendar_year ) {
    $today = strtotime('today');
    $calendar_year = date( 'y', $today );
  }

  $beginning_of_month_str = $calendar_year . '-' . str_pad($calendar_month, 2, "0", STR_PAD_LEFT) . '-' . '01';

  $beginning_of_month = new DateTime($beginning_of_month_str);
  $end_of_month       = new DateTime($beginning_of_month_str);
  $end_of_month->modify( 'last day of' );

  $params = array(
    'orderby' => 'start_datum ASC',
    //'limit' => 15,
    'where' => "CAST(start_datum.meta_value AS DATE) >= '" . $beginning_of_month->format('Y/m/d') . "'" . " AND CAST(start_datum.meta_value AS DATE) <= '" . $end_of_month->format('Y/m/d') . "'"
  );

  $pods = pods( 'veranstaltung', $params );

  while ( $pods->fetch() ) {
    echo $pods->display( 'name' );
  }

  return ob_get_clean();
}
add_shortcode('lfm_event_list_month', 'lfm_shortcode_event_list_month' );

?>
