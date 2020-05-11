<?php

/*
add_filter( 'wp_nav_menu_items', 'lfm_add_calendar_menu_items', 10, 2);
function lfm_add_calendar_menu_items ( $items, $args ) {
  $items .= '<li class="menu-item menu-item-has-children"><a href="">My menu entry</a></li>';
  return $items;
}*/

function lfm_add_calendar_items ( $items, $args) {
  // Only attach to main menu
  if ( 'primary-menu' !== $args->theme_location ) {
    return $items;
  }

  $cal_nav_pseudo_id  = 9997771;
  $year_nav_pseudo_id = $cal_nav_pseudo_id + 1;

  $timezone = new DateTimeZone( get_option( 'timezone_string' ) );

  $today_dt = new DateTime();
  $today_dt->setTimezone($timezone);

  // We want: $today_dt->modify( 'first of month' );
  // But this is not possible :( - so substract the day.
  $num_days = $today_dt->format('d') - 1;
  $today_dt->modify( '-'.$num_days.' day' );

  $current_year = $today_dt->format( 'Y' );
	
	// Iterate over months, years, ...
  $items[] = (object) array(
    'title' => "Kalender",
    'ID'    => 'nav_cal',
    'db_id' => $cal_nav_pseudo_id,
    'current' => false,
    'target'  => '',
    'xfn'     => '',
    'classes' => array( 'menu-item', 'menu-item-has-children' ),
    'url' => site_url( '/veranstaltungen/' . $current_year )
  );

  $items[] = (object) array(
    'title' => $current_year,
    'ID' => 'nav_current_year',
    'menu_item_parent' => $cal_nav_pseudo_id,
    'db_id' => $year_nav_pseudo_id,
    'current' => false,
    'xfn'     => '',
    'target'  => '',
    'classes' => array( 'menu-item', 'menu-item-has-children' ),
    'url' => site_url( '/veranstaltungen/' . $current_year )
  );

  /*
  $items[] = (object) array(
    'title' => $today_dt->format( 'F' ),
    'ID' => 'nav_current_month',
    'menu_item_parent' => $current_walk_id,
    'db_id'   => $current_walk_id += 1,
    'current' => false,
    'target'  => '',
    'url' => 'https://bog.us/me/too'
  );
   */

  $current_pseudo_id = $year_nav_pseudo_id;
  while ( $today_dt->format( 'Y' ) == $current_year ) {
    $items[] = (object) array(
      'title' => date_i18n( 'F', $today_dt->getTimestamp()),
      'ID' => 'nav_current_month',
      'menu_item_parent' => $year_nav_pseudo_id,
      'db_id'   => $current_pseudo_id += 1,
      'current' => false,
      'xfn'     => '',
      'target'  => '',
      'url'     => site_url( '/veranstaltungen/' . $current_year . '/' . $today_dt->format( 'm' ) )
    );
    $today_dt->modify( '+1 month' );
  }
  return $items;
}
add_filter( 'wp_nav_menu_objects', 'lfm_add_calendar_items', 10, 2 );

?>
