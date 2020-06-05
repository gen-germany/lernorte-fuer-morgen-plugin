<?php

/**
 * Shortcode to display number of lernorte.
 */
function lfm_shortcode_number_lernorte() {
  $params = array(
    'limit' => -1
  );
  $lernorte = pods('lernort', $params);
  return $lernorte->total_found();
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
  $veranstaltungen = pods('veranstaltung', $params);
  return $veranstaltungen->total_found();
}
add_shortcode('lfm_veranstaltungen_count',
  'lfm_shortcode_number_veranstaltungen' );

/**
 * Shortcode to display links to (upcoming) months
 */
function lfm_shortcode_upcoming_months_links() {
  ob_start();
  $num_month = 8;

  $iter_date = new DateTime( strtotime( 'beginning of month') );

  $i = -1;
  while( $i++ < $num_month ) {
    $month_date = mktime(0, 0, 0, date('n') + $i);
    $month_name = date_i18n( 'F', $month_date, 1 );

    echo "<a href=\"/veranstaltungen/".$iter_date->format('Y')."/" . date( 'm', $month_date ) . "\">" . $month_name . "</a> ";

    if ( $i < $num_month ) {
      echo "| ";
    }

    $iter_date->modify("+1 month");
  }
  //->modify( 'first day of next month' );
  //$final = date("Y-m-d", strtotime("+1 month", $time));
  return ob_get_clean();
}
add_shortcode('lfm_upcoming_months_links', 'lfm_shortcode_upcoming_months_links' );

/**
 * Shortcode to display a list of events
 */
function lfm_shortcode_event_list_month() {
  ob_start();

  $calendar_month = get_query_var( 'calendar_month' );
  $calendar_year  = get_query_var( 'calendar_year' );
  $zielgruppen    = get_query_var( 'zielgruppe' );
  $formate        = get_query_var( 'format' );

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

  $where_query = "CAST(start_datum.meta_value AS DATE) >= '" . $beginning_of_month->format('Y/m/d') . "'" . " AND CAST(start_datum.meta_value AS DATE) <= '" . $end_of_month->format('Y/m/d') . "'";

  if ( !empty($zielgruppen) ) {
    $zielgruppe_query = " AND zielgruppe.ID in (" . implode(', ', $zielgruppen) . ")";
    $where_query .= $zielgruppe_query;
  }

  if ( !empty($formate) ) {
    $formate_query =    " AND veranstaltungsformate.ID in (" . implode(', ', $formate) . ")";
    $where_query .= $formate_query;
  }

  $params = array(
    'orderby' => 'start_datum ASC',
    //'limit' => 15,
    'where' => $where_query
  );

  $pods = pods( 'veranstaltung', $params );

  if ( $pods->total() <= 0 ) {
    echo "In diesem Zeitraum mit diesem Filter keine Veranstaltungen";
  }

  while ( $pods->fetch() ) {
    // reset id to use a single template
    $pods->id = $pods->id();
    echo $pods->template( 'Veranstaltung: Mini' );
    //echo $pods->display( 'name' );
  }

  return ob_get_clean();
}
add_shortcode('lfm_event_list_month', 'lfm_shortcode_event_list_month' );


/** Hop over all referentn and output their lastnames first letter. */
function lfm_shortcode_referentn_list() {
  ob_start(); // Capture output in buffer, to return it later.

  $params = array(
    'orderby' => 'nachname',
    'limit'   => -1
  );

  $pods = pods( 'referentn', $params );

  $current_first_letter = '';

  if ( $pods->total() > 0 ) {
    while( $pods->fetch() )  {
      // reset id to use a single template
      $pods->id = $pods->id();
      $nachname = $pods->field( 'nachname' );

      if (mb_substr($nachname, 0, 1, "UTF-8") != $current_first_letter) {
        $current_first_letter = mb_substr( $nachname, 0, 1, "UTF-8" );
        echo "<h2>" . $current_first_letter . "</h2>";
      }

      $temp = $pods->template( 'Referent: Mini' );

      // Output rendered template if it exists
      if ( isset( $temp ) ) {
        //echo $pods->display( 'nachname' );
        echo $temp;
        //echo $pods->field('nachname');
      }
    }
    // Pagination
    echo $pods->pagination();
  }
  else {
    echo 'No content found.';
  }

  $output = ob_get_clean();
  return $output;
}
add_shortcode('lfm_referentn_list', 'lfm_shortcode_referentn_list' );

?>
