<?php

/**
 * Query vars used for calendar and filtered event view.
 */
function lfm_register_calendar_query_vars( $vars ) {
  $vars[] = 'calendar_month';
  $vars[] = 'calendar_year';

  return $vars;
}

add_filter( 'query_vars', 'lfm_register_calendar_query_vars' );

/**
 * Rewrite calendar routes
 * GOTCHA: Visit the permalink settings page to flush the rewrite rules in WP Admin backend!
 */
function lfm_rewrite_calendar() {
  add_rewrite_tag( '%calendar_month%', '([^&]+)' );
  add_rewrite_tag( '%calendar_year%',  '([^&]+)' );

  add_rewrite_rule( '^veranstaltungen/([^/]*)/([^/]*)/?', 'index.php?page_id=480&calendar_month=$matches[2]&calendar_year=$matches[1]', 'top');
}

add_action( 'init', 'lfm_rewrite_calendar', 10, 0 );

?>
